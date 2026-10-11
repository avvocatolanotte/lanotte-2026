/**
 * lanotte-istat.js — Modulo gestione indici ISTAT FOI
 *
 * Strategia:
 *  1. Indici UFFICIALI nel JSON statico: prevalgono sempre
 *  2. Indici "da verificare" (se presenti)
 *  3. Valori inseriti a mano dall'utente (localStorage `lanotte_istat_override_v1`):
 *     solo per i mesi che l'archivio ufficiale non ha ancora
 *
 * Variazioni e coefficienti seguono la nota metodologica ISTAT 2026: rapporto in un solo
 * passaggio, variazione arrotondata a 1 decimale, coefficiente di rivalutazione a 3 decimali.
 *
 * USO:
 *   await LanotteISTAT.load('/assets/data/istat-foi.json');
 *   const idx = LanotteISTAT.indice('2026-05');         // 124.8 (con flag)
 *   LanotteISTAT.aggiungiManuale('2026-09', 103.9);     // valore pubblicato (base 2025=100 dal 2026), salvato nel browser
 */
(function(global){
  'use strict';

  const CACHE_KEY    = 'lanotte_istat_cache_v2';
  const OVERRIDE_KEY = 'lanotte_istat_override_v1';
  const CACHE_TTL    = 24 * 60 * 60 * 1000; // 24h
  let DATA = null;

  // Dal gennaio 2026 l'ISTAT pubblica il FOI in base 2025=100: il valore inserito a mano
  // per quei mesi viene riportato in base 2015=100 con il coefficiente ufficiale 1,214.
  const RACCORDO_2025 = 1.214;
  function baseDelMese(yyyymm){ return yyyymm >= '2026-01' ? '2025' : '2015'; }
  // Un valore FOI del 2026 in base 2025 sta intorno a 100-110; lo stesso valore in base 2015 sta
  // sopra 120. I numeri salvati prima del 10/10/2026 non dicono la base: si riconosce dalla misura.
  const SOGLIA_BASE_2025 = 115;
  function valoreInterno(v, yyyymm){
    if (v && typeof v === 'object') return v.base === '2025' ? v.pubblicato * RACCORDO_2025 : v.pubblicato;
    if (typeof v !== 'number') return v;
    if (yyyymm && baseDelMese(yyyymm) === '2025' && v < SOGLIA_BASE_2025) return v * RACCORDO_2025;
    return v;
  }

  // Raccordi ufficiali ISTAT tra basi contigue, come frazioni intere: 1,3731 · 1,071 · 1,214.
  const ORDINE_BASI = ['1995', '2010', '2015', '2025'];
  const RACCORDI = { '1995': [13731n, 10000n], '2010': [1071n, 1000n], '2015': [1214n, 1000n] };

  // Valore come pubblicato e sua base: dall'archivio ufficiale, dal valore inserito a mano o,
  // in mancanza, dal valore interno in base 2015.
  function pubblicatoDi(yyyymm){
    if (!DATA) throw new Error('ISTAT non caricato');
    if (DATA.pubblicati[yyyymm]) return DATA.pubblicati[yyyymm];
    const v = DATA.indici[yyyymm];
    return (typeof v === 'number') ? { valore: v, base: '2015' } : null;
  }

  // Rapporto fra due mesi come frazione intera num/den, raccordi compresi (un solo passaggio, nessun
  // arrotondamento intermedio). I valori sono portati a interi con 4 decimali.
  function rapporto(da, a){
    const p1 = pubblicatoDi(da), p2 = pubblicatoDi(a);
    if (!p1 || !p2) return null;
    const i1 = ORDINE_BASI.indexOf(p1.base), i2 = ORDINE_BASI.indexOf(p2.base);
    if (i1 < 0 || i2 < 0 || !(p1.valore > 0) || !(p2.valore > 0)) return null;
    let num = BigInt(Math.round(p2.valore * 10000)), den = BigInt(Math.round(p1.valore * 10000));
    for (let i = i1; i < i2; i++) { const r = RACCORDI[ORDINE_BASI[i]]; num *= r[0]; den *= r[1]; }
    for (let i = i2; i < i1; i++) { const r = RACCORDI[ORDINE_BASI[i]]; num *= r[1]; den *= r[0]; }
    return { num, den };
  }

  // Arrotondamento di num/den all'intero, metà lontano da zero, in aritmetica esatta.
  function arrotondaFrazione(num, den){
    const neg = num < 0n;
    const x = neg ? -num : num;
    const q = (2n * x + den) / (2n * den);
    return neg ? -q : q;
  }

  // Valore inserito a mano come {valore, base}; i numeri salvati prima del 10/10/2026 si
  // attribuiscono alla base con la stessa regola di valoreInterno.
  function pubblicatoManuale(v, yyyymm){
    if (v && typeof v === 'object') return { valore: v.pubblicato, base: v.base };
    const base = (baseDelMese(yyyymm) === '2025' && v < SOGLIA_BASE_2025) ? '2025' : '2015';
    return { valore: v, base: base };
  }

  function getOverrides(){
    try { return JSON.parse(localStorage.getItem(OVERRIDE_KEY)) || {}; }
    catch(e) { return {}; }
  }
  function setOverrides(map){
    localStorage.setItem(OVERRIDE_KEY, JSON.stringify(map));
  }

  function isCacheValid(c){
    return c && c.timestamp && c.data && (Date.now() - c.timestamp) < CACHE_TTL;
  }

  async function tryFetchISTAT(){
    try {
      const url = 'https://esploradati.istat.it/SDMXWS/rest/data/IT1,165_271_DF_DCSP_FOI1B2015_5,1.0/.IFOI.0./';
      const res = await fetch(url, {
        headers: {'Accept': 'application/vnd.sdmx.data+json;version=1.0.0'},
        signal: AbortSignal.timeout(4000),
        mode: 'cors'
      });
      if (!res.ok) return null;
      const json = await res.json();
      const series = json?.dataSets?.[0]?.series;
      const timeValues = json?.structure?.dimensions?.observation?.[0]?.values;
      if (!series || !timeValues) return null;

      const indici = {};
      Object.values(series).forEach(s => {
        Object.entries(s.observations || {}).forEach(([timeIdx, obs]) => {
          const time = timeValues[parseInt(timeIdx)]?.id;
          const val = obs[0];
          if (time && val !== null) indici[time] = val;
        });
      });
      if (Object.keys(indici).length === 0) return null;
      return { indici, fetchedAt: new Date().toISOString() };
    } catch(e) {
      console.warn('[ISTAT] API live non raggiungibile (probabile CORS):', e.message);
      return null;
    }
  }

  async function load(fallbackUrl){
    const res = await fetch(fallbackUrl || '/assets/data/istat-foi.json');
    if (!res.ok) throw new Error('Impossibile caricare JSON ISTAT');
    const json = await res.json();

    // Combina: ufficiali + da verificare + override manuale.
    // Non facciamo fetch live da browser: le API ISTAT possono essere lente,
    // cambiare endpoint o essere bloccate da CORS, lasciando il calcolatore fermo.
    const indici = Object.assign({}, json.indici);
    const flag = {};
    Object.keys(json.indici || {}).forEach(k => flag[k] = 'ufficiale');
    const pubblicati = {};
    Object.entries(json.indici_pubblicati || {}).forEach(([k, v]) => {
      if (Array.isArray(v) && typeof v[0] === 'number') pubblicati[k] = { valore: v[0], base: String(v[1]) };
    });

    if (json.indici_da_verificare) {
      Object.entries(json.indici_da_verificare).forEach(([k, v]) => {
        if (k.startsWith('_')) return;
        indici[k] = v;
        flag[k] = 'stima';
      });
    }

    const live = null;

    // Valori inseriti a mano: solo per i mesi che l'archivio ufficiale non ha ancora.
    const overrides = getOverrides();
    Object.entries(overrides).forEach(([k, v]) => {
      if (flag[k] === 'ufficiale') return;
      const interno = valoreInterno(v, k);
      if (typeof interno !== 'number' || isNaN(interno)) return;
      indici[k] = interno;
      flag[k] = 'manuale';
      pubblicati[k] = pubblicatoManuale(v, k);
    });

    DATA = {
      meta: json.meta,
      indici, flag, pubblicati,
      hasLive: !!live,
      liveFetchedAt: live ? live.fetchedAt : null
    };
    return DATA;
  }

  function indice(yyyymm){
    if (!DATA) throw new Error('ISTAT non caricato');
    return DATA.indici[yyyymm] ?? null;
  }

  function flagDi(yyyymm){
    return DATA?.flag?.[yyyymm] || null;
  }

  function ultimoMese(){
    if (!DATA) return null;
    return Object.keys(DATA.indici).sort().slice(-1)[0];
  }

  function ultimoMeseUfficiale(){
    if (!DATA) return null;
    return Object.keys(DATA.indici)
      .filter(k => DATA.flag[k] === 'ufficiale' || DATA.flag[k] === 'live' || DATA.flag[k] === 'manuale')
      .sort().slice(-1)[0];
  }

  function variazione12mesi(yyyymm){
    const [y, m] = yyyymm.split('-');
    return variazione((parseInt(y) - 1) + '-' + m, yyyymm);
  }

  // Variazione percentuale: rapporto × 100 − 100, arrotondata a 1 decimale (metodo ISTAT).
  function variazione(da, a){
    const r = rapporto(da, a);
    if (!r) return null;
    return Number(arrotondaFrazione(r.num * 1000n - r.den * 1000n, r.den)) / 10;
  }

  // Coefficiente di rivalutazione: rapporto in un solo passaggio, arrotondato a 3 decimali (metodo ISTAT).
  function coefficiente(da, a){
    const r = rapporto(da, a);
    if (!r) return null;
    return Number(arrotondaFrazione(r.num * 1000n, r.den)) / 1000;
  }

  // Indice come pubblicato dall'ISTAT, con la base: «103,7 (base 2025=100)».
  function testoIndice(yyyymm){
    const p = pubblicatoDi(yyyymm);
    if (!p) return '—';
    const dec = (String(p.valore).split('.')[1] || '').length;
    return p.valore.toFixed(Math.max(1, Math.min(dec, 4))).replace('.', ',') + ' (base ' + p.base + '=100)';
  }

  function aumento75(da, a){
    const v = variazione(da, a);
    return v === null ? null : v * 0.75;
  }

  function rivaluta(importo, da, a){
    const c = coefficiente(da, a);
    return c === null ? null : importo * c;
  }

  function mesiDisponibili(){
    return DATA ? Object.keys(DATA.indici).sort() : [];
  }

  function meta(){ return DATA ? DATA.meta : null; }
  function isLive(){ return DATA ? DATA.hasLive : false; }
  function liveFetchedAt(){ return DATA ? DATA.liveFetchedAt : null; }

  // Aggiunge/modifica un valore manualmente (salvato nel browser)
  function aggiungiManuale(yyyymm, valore){
    if (!yyyymm.match(/^\d{4}-\d{2}$/)) throw new Error('Formato mese non valido (YYYY-MM)');
    const v = parseFloat(String(valore).replace(',', '.'));
    if (DATA && DATA.flag[yyyymm] === 'ufficiale') throw new Error('Per ' + yyyymm + ' l\'archivio del sito ha già il dato ufficiale ISTAT, che prevale: non serve inserirlo a mano.');
    const base = baseDelMese(yyyymm);
    if (base === '2025' && (isNaN(v) || v < 90 || v > 120)) throw new Error('Valore non plausibile: dal 2026 l\'indice FOI è pubblicato in base 2025=100 (valori intorno a 100-110). Se ha copiato un valore in base 2015, usi quello in base 2025.');
    if (base === '2015' && (isNaN(v) || v < 50 || v > 200)) throw new Error('Valore non plausibile (FOI in base 2015=100: valori tipici 100-130)');
    const overrides = getOverrides();
    overrides[yyyymm] = { pubblicato: v, base: base };
    setOverrides(overrides);
    // Aggiorna anche DATA in memoria
    if (DATA) {
      DATA.indici[yyyymm] = valoreInterno(overrides[yyyymm], yyyymm);
      DATA.flag[yyyymm] = 'manuale';
      DATA.pubblicati[yyyymm] = pubblicatoManuale(overrides[yyyymm], yyyymm);
    }
    return true;
  }

  function rimuoviManuale(yyyymm){
    const overrides = getOverrides();
    delete overrides[yyyymm];
    setOverrides(overrides);
  }

  // Per la visualizzazione: valore come pubblicato dall'ISTAT, con la base indicata
  function listaManuali(){
    const out = {};
    Object.entries(getOverrides()).forEach(([k, v]) => {
      out[k] = (v && typeof v === 'object')
        ? String(v.pubblicato).replace('.', ',') + ' (base ' + v.base + '=100)'
        : String(v).replace('.', ',') + ' (base ' + (baseDelMese(k) === '2025' && v < SOGLIA_BASE_2025 ? '2025' : '2015') + '=100)';
      if (DATA && DATA.flag[k] === 'ufficiale') out[k] += ' — non usato: prevale il dato ufficiale';
    });
    return out;
  }

  global.LanotteISTAT = {
    load, indice, flagDi, ultimoMese, ultimoMeseUfficiale,
    variazione12mesi, variazione, aumento75, coefficiente, rivaluta, testoIndice,
    mesiDisponibili, meta, isLive, liveFetchedAt,
    aggiungiManuale, rimuoviManuale, listaManuali
  };
})(window);
