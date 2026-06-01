/**
 * lanotte-istat.js — Modulo gestione indici ISTAT FOI
 *
 * Strategia (4 livelli con priorità):
 *  1. Override manuale dell'utente (localStorage `lanotte_istat_override`)
 *  2. API ISTAT SDMX live (fetch best-effort, spesso bloccato da CORS)
 *  3. Indici "da verificare" (interpolazioni stima)
 *  4. Indici UFFICIALI nel JSON statico
 *
 * USO:
 *   await LanotteISTAT.load('/assets/data/istat-foi.json');
 *   const idx = LanotteISTAT.indice('2026-04');         // 122.6 (con flag)
 *   LanotteISTAT.aggiungiManuale('2026-05', 122.8);     // salva nel browser
 */
(function(global){
  'use strict';

  const CACHE_KEY    = 'lanotte_istat_cache_v2';
  const OVERRIDE_KEY = 'lanotte_istat_override_v1';
  const CACHE_TTL    = 24 * 60 * 60 * 1000; // 24h
  let DATA = null;

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

    // Combina: ufficiali + da verificare + override + API live (se disponibile)
    const indici = Object.assign({}, json.indici);
    const flag = {};
    Object.keys(json.indici || {}).forEach(k => flag[k] = 'ufficiale');

    if (json.indici_da_verificare) {
      Object.entries(json.indici_da_verificare).forEach(([k, v]) => {
        if (k.startsWith('_')) return;
        indici[k] = v;
        flag[k] = 'stima';
      });
    }

    // Tentativo API live (se funziona, sovrascrive le stime)
    const live = await tryFetchISTAT();
    if (live) {
      Object.entries(live.indici).forEach(([k, v]) => {
        indici[k] = v;
        flag[k] = 'live';
      });
    }

    // Override manuale dell'utente (massima priorità)
    const overrides = getOverrides();
    Object.entries(overrides).forEach(([k, v]) => {
      indici[k] = v;
      flag[k] = 'manuale';
    });

    DATA = {
      meta: json.meta,
      indici, flag,
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
    const prev = (parseInt(y) - 1) + '-' + m;
    const i1 = indice(prev), i2 = indice(yyyymm);
    if (i1 == null || i2 == null) return null;
    return ((i2 - i1) / i1) * 100;
  }

  function variazione(da, a){
    const i1 = indice(da), i2 = indice(a);
    if (i1 == null || i2 == null) return null;
    return ((i2 - i1) / i1) * 100;
  }

  function aumento75(da, a){
    const v = variazione(da, a);
    return v === null ? null : v * 0.75;
  }

  function rivaluta(importo, da, a){
    const i1 = indice(da), i2 = indice(a);
    if (i1 == null || i2 == null) return null;
    return importo * (i2 / i1);
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
    const v = parseFloat(valore);
    if (isNaN(v) || v < 50 || v > 200) throw new Error('Valore non plausibile (FOI tipico: 100-130)');
    const overrides = getOverrides();
    overrides[yyyymm] = v;
    setOverrides(overrides);
    // Aggiorna anche DATA in memoria
    if (DATA) {
      DATA.indici[yyyymm] = v;
      DATA.flag[yyyymm] = 'manuale';
    }
    return true;
  }

  function rimuoviManuale(yyyymm){
    const overrides = getOverrides();
    delete overrides[yyyymm];
    setOverrides(overrides);
  }

  function listaManuali(){
    return getOverrides();
  }

  global.LanotteISTAT = {
    load, indice, flagDi, ultimoMese, ultimoMeseUfficiale,
    variazione12mesi, variazione, aumento75, rivaluta,
    mesiDisponibili, meta, isLive, liveFetchedAt,
    aggiungiManuale, rimuoviManuale, listaManuali
  };
})(window);
