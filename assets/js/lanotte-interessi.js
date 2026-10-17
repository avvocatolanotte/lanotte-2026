/**
 * lanotte-interessi.js — Calcolo interessi legali e moratori
 *
 * USO:
 *   await LanotteInteressi.load('legali', '/assets/data/interessi-legali.json');
 *   const r = LanotteInteressi.calcola({
 *     importo: 1000,
 *     dataIniziale: '2020-01-01',
 *     dataFinale: '2025-01-31',
 *     tipo: 'legali'  // o 'moratori'
 *   });
 *   // r = { totaleInteressi, totaleComplessivo, dettaglio: [...] }
 */
(function(global){
  'use strict';

  const DATASETS = { legali: null, moratori: null };

  async function load(tipo, url){
    // _v2 dal 17/10/2026: la copia _v1 poteva contenere il 10,15% «in vigore» dopo il 30/06/2026.
    // _v3 (1.0.150): tabelle chiuse al 31/12/2026 e legali al 5% fino al 15/12/1990. Ogni modifica ai dati cambia la chiave.
    const cacheKey = 'lanotte_int_' + tipo + '_v3';
    try {
      const cached = JSON.parse(localStorage.getItem(cacheKey));
      if (cached && (Date.now() - cached.timestamp) < 7*24*60*60*1000) {
        DATASETS[tipo] = cached.data;
        return cached.data;
      }
    } catch(e){}

    const res = await fetch(url);
    if (!res.ok) throw new Error('Errore caricamento ' + tipo);
    const data = await res.json();
    DATASETS[tipo] = data;
    try { localStorage.setItem(cacheKey, JSON.stringify({timestamp: Date.now(), data})); } catch(e){}
    return data;
  }

  /** Differenza giorni tra due date (incluse) */
  function giorniTra(da, a){
    const d1 = new Date(da);
    const d2 = new Date(a);
    return Math.floor((d2 - d1) / (1000 * 60 * 60 * 24));
  }

  /** Giorni nell'anno (366 se bisestile) */
  function giorniAnno(year){
    return ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) ? 366 : 365;
  }

  /**
   * Calcolo interessi capitalizzazione semplice per periodo,
   * suddividendo automaticamente in scaglioni quando il tasso cambia.
   */
  function calcola(opts){
    const { importo, dataIniziale, dataFinale, tipo } = opts;
    // Punti aggiuntivi sul saggio (es. +4 per le cessioni agroalimentari: art. 4, c. 2, d.lgs. 198/2021)
    const maggiorazione = Number(opts.maggiorazione) || 0;
    const ds = DATASETS[tipo];
    if (!ds) throw new Error('Dataset ' + tipo + ' non caricato');
    if (!importo || importo <= 0) throw new Error('Importo non valido');

    const dStart = new Date(dataIniziale);
    const dEnd = new Date(dataFinale);
    // Giorni contati inclusi entrambi gli estremi: stessa data = 1 giorno (per la mora: decorrenza e saldo nello stesso giorno)
    if (dEnd < dStart) throw new Error('La data finale non può precedere quella iniziale');

    // Trova gli scaglioni di tasso che intersecano il periodo, divisi per anno solare: ogni anno ha il suo
    // divisore (365 o 366), anche quando una riga della tabella copre più anni (rilievo Codex 17/10/2026).
    const scaglioni = [];
    ds.tassi.forEach(t => {
      const tStart = new Date(t.dal);
      const tEnd = t.al ? new Date(t.al) : new Date('2099-12-31');
      // Sovrapposizione con [dStart, dEnd]?
      const overlapStart = tStart > dStart ? tStart : dStart;
      const overlapEnd = tEnd < dEnd ? tEnd : dEnd;
      const tasso = Math.round(((tipo === 'moratori' ? t.moratorio : t.tasso) + maggiorazione) * 1000) / 1000;
      const norma = maggiorazione ? t.norma + ' + ' + maggiorazione + ' punti' : t.norma;
      for (let y = overlapStart.getUTCFullYear(); overlapStart <= overlapEnd && y <= overlapEnd.getUTCFullYear(); y++) {
        const inizioAnno = new Date(Date.UTC(y, 0, 1)), fineAnno = new Date(Date.UTC(y, 11, 31));
        scaglioni.push({
          dal: overlapStart > inizioAnno ? overlapStart : inizioAnno,
          al: overlapEnd < fineAnno ? overlapEnd : fineAnno,
          tasso,
          norma
        });
      }
    });

    // Ordina cronologicamente
    scaglioni.sort((a, b) => a.dal - b.dal);

    // Ogni giorno del periodo deve avere un tasso: un giorno senza tasso (prima della tabella, oltre l'ultimo
    // tasso pubblicato, o in un buco) ferma il calcolo, invece di sparire in silenzio dal totale.
    const giornoMs = 24 * 60 * 60 * 1000;
    let atteso = dStart;
    for (const s of scaglioni) {
      if (s.dal > atteso) break;
      const dopo = new Date(s.al.getTime() + giornoMs);
      if (dopo > atteso) atteso = dopo;
    }
    if (atteso <= dEnd) {
      const c = copertura(tipo);
      const it = d => d.toISOString().slice(0, 10).split('-').reverse().join('/');
      throw new Error('Il tasso non è disponibile per il giorno ' + it(atteso)
        + (c ? ': la tabella dei tassi va dal ' + it(new Date(c.dal)) + ' al ' + it(new Date(c.al)) : '')
        + '. Il calcolo si ferma per non dare un totale incompleto: per i periodi successivi occorre il tasso pubblicato in Gazzetta Ufficiale.');
    }

    // Calcolo
    const dettaglio = [];
    let totaleInteressi = 0;
    scaglioni.forEach(s => {
      const giorni = giorniTra(s.dal, s.al) + 1; // inclusivo
      const anno = s.dal.getUTCFullYear();
      const gAnno = giorniAnno(anno);
      // Interesse = capitale × tasso% × giorni / giorni_anno
      const interesse = importo * (s.tasso / 100) * (giorni / gAnno);
      totaleInteressi += interesse;
      dettaglio.push({
        dal: s.dal.toISOString().slice(0,10),
        al: s.al.toISOString().slice(0,10),
        giorni,
        tasso: s.tasso,
        norma: s.norma,
        interesse
      });
    });

    return {
      importo,
      dataIniziale,
      dataFinale,
      tipo,
      totaleInteressi,
      totaleComplessivo: importo + totaleInteressi,
      dettaglio,
      meta: ds.meta
    };
  }

  /** Tasso vigente in una data specifica */
  function tassoIn(data, tipo){
    const ds = DATASETS[tipo];
    if (!ds) return null;
    const d = new Date(data);
    const found = ds.tassi.find(t => {
      const tStart = new Date(t.dal);
      const tEnd = t.al ? new Date(t.al) : new Date('2099-12-31');
      return d >= tStart && d <= tEnd;
    });
    if (!found) return null;
    return {
      tasso: tipo === 'moratori' ? found.moratorio : found.tasso,
      norma: found.norma,
      bce: found.saggio_bce ?? null
    };
  }

  /** Lista cronologica di tutti i tassi (per UI tabella storico) */
  function elencoTassi(tipo){
    return DATASETS[tipo]?.tassi || [];
  }

  function meta(tipo){
    return DATASETS[tipo]?.meta || null;
  }

  /** Primo e ultimo giorno coperti dalla tabella ({dal, al} in formato AAAA-MM-GG); null se manca la tabella. */
  function copertura(tipo){
    const t = DATASETS[tipo]?.tassi;
    if (!t || !t.length) return null;
    const dal = t.reduce((m, x) => x.dal < m ? x.dal : m, t[0].dal);
    const al = t.some(x => !x.al) ? '2099-12-31' : t.reduce((m, x) => x.al > m ? x.al : m, t[0].al);
    return { dal, al };
  }

  global.LanotteInteressi = { load, calcola, tassoIn, elencoTassi, meta, copertura };
})(window);
