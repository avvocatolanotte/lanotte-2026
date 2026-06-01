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
    const cacheKey = 'lanotte_int_' + tipo + '_v1';
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
    const ds = DATASETS[tipo];
    if (!ds) throw new Error('Dataset ' + tipo + ' non caricato');
    if (!importo || importo <= 0) throw new Error('Importo non valido');

    const dStart = new Date(dataIniziale);
    const dEnd = new Date(dataFinale);
    if (dEnd <= dStart) throw new Error('Data finale deve essere successiva all\'iniziale');

    // Trova gli scaglioni di tasso che intersecano il periodo
    const scaglioni = [];
    ds.tassi.forEach(t => {
      const tStart = new Date(t.dal);
      const tEnd = t.al ? new Date(t.al) : new Date('2099-12-31');
      // Sovrapposizione con [dStart, dEnd]?
      const overlapStart = tStart > dStart ? tStart : dStart;
      const overlapEnd = tEnd < dEnd ? tEnd : dEnd;
      if (overlapStart <= overlapEnd) {
        scaglioni.push({
          dal: overlapStart,
          al: overlapEnd,
          tasso: tipo === 'moratori' ? t.moratorio : t.tasso,
          norma: t.norma
        });
      }
    });

    // Ordina cronologicamente
    scaglioni.sort((a, b) => a.dal - b.dal);

    // Calcolo
    const dettaglio = [];
    let totaleInteressi = 0;
    scaglioni.forEach(s => {
      const giorni = giorniTra(s.dal, s.al) + 1; // inclusivo
      const anno = s.dal.getFullYear();
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

  global.LanotteInteressi = { load, calcola, tassoIn, elencoTassi, meta };
})(window);
