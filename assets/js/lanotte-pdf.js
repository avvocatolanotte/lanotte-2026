/**
 * lanotte-pdf.js — Generatore PDF con carta intestata Studio
 * Riutilizzabile da tutti i calcolatori del sito.
 *
 * Dipendenze esterne: jsPDF (caricata via CDN nei singoli calcolatori).
 *
 * USO:
 *   LanottePDF.generate({
 *     titolo: 'Calcolo Aumento ISTAT Locazione',
 *     normativa: 'art. 32 L. 392/1978',
 *     cliente: { nome: 'Mario Rossi', codiceFiscale: 'RSSMRA80A01F839X' },
 *     dati: [
 *       { label: 'Canone iniziale', value: '€ 600,00' },
 *       { label: 'Decorrenza contratto', value: '01/01/2020' }
 *     ],
 *     tabella: {
 *       headers: ['Periodo', 'Indice FOI', 'Canone aggiornato'],
 *       rows: [['Gen 2024', '119.6', '€ 612,30'], ...]
 *     },
 *     conclusioni: 'Il canone aggiornato al 01/01/2025 è di € 645,80...',
 *     fonteIstat: '2025-04'  // YYYY-MM, opzionale
 *   });
 */
(function(global){
  'use strict';

  const STUDIO = {
    nome: 'Studio Legale Lanotte & Partners',
    titolare: 'Avv. Giuseppe Lanotte',
    indirizzo: 'Viale Falcone e Borsellino, 75 — 76121 Barletta (BT)',
    telefono: '0883 1955533',
    cellulare: '392 970 3202 (Penale H24)',
    email: 'info@studiolegalelanotte.it',
    pec: 'studiolegalelanotte@legalmail.it',
    cf: 'LNTGPP78B01L328P',
    piva: '06731750722',
    foro: 'Foro di Trani',
    sito: 'studiolegalelanotte.it'
  };

  const COLORS = {
    navy: [29, 44, 74],     // #1d2c4a
    gold: [184, 153, 104],  // #b89968
    dark: [15, 23, 42],     // #0f172a
    text: [51, 65, 85],     // #334155
    muted: [148, 163, 184], // #94a3b8
    lightBg: [250, 250, 247] // #fafaf7
  };

  function nowIso(){
    const d = new Date();
    return d.toLocaleDateString('it-IT', {day:'2-digit', month:'2-digit', year:'numeric'}) +
           ' ' + d.toLocaleTimeString('it-IT', {hour:'2-digit', minute:'2-digit'});
  }

  function generate(opts){
    if (typeof window.jspdf === 'undefined') {
      alert('Errore: libreria jsPDF non caricata. Ricarica la pagina.');
      return;
    }
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({orientation:'portrait', unit:'mm', format:'a4'});

    const W = 210, H = 297;
    const M = 18; // margine
    let y = M;

    // ===== HEADER (carta intestata) =====
    // Riga oro decorativa
    doc.setFillColor(...COLORS.gold);
    doc.rect(0, 0, W, 4, 'F');

    // Logo testuale stilizzato
    y = 16;
    doc.setFont('helvetica','bold');
    doc.setFontSize(22);
    doc.setTextColor(...COLORS.navy);
    doc.text('Lanotte', M, y);
    doc.setTextColor(...COLORS.gold);
    doc.setFont('times','italic');
    doc.text('&', M + 32, y);
    doc.setFont('helvetica','bold');
    doc.setTextColor(...COLORS.navy);
    doc.text('Partners', M + 38, y);

    // Sottotitolo studio legale
    y += 5;
    doc.setFont('helvetica','normal');
    doc.setFontSize(8);
    doc.setTextColor(...COLORS.gold);
    doc.text('· STUDIO LEGALE ·', M, y);

    // Blocco contatti a destra
    doc.setTextColor(...COLORS.text);
    doc.setFontSize(8);
    let yR = 14;
    const xR = W - M;
    doc.text(STUDIO.titolare, xR, yR, {align:'right'}); yR += 3.5;
    doc.text(STUDIO.indirizzo, xR, yR, {align:'right'}); yR += 3.5;
    doc.text('Tel. ' + STUDIO.telefono + ' · ' + STUDIO.cellulare, xR, yR, {align:'right'}); yR += 3.5;
    doc.text(STUDIO.email + ' · PEC: ' + STUDIO.pec, xR, yR, {align:'right'}); yR += 3.5;
    doc.text('C.F. ' + STUDIO.cf + ' · P.IVA ' + STUDIO.piva, xR, yR, {align:'right'}); yR += 3.5;
    doc.text(STUDIO.foro, xR, yR, {align:'right'});

    // Linea separatrice
    y = 38;
    doc.setDrawColor(...COLORS.gold);
    doc.setLineWidth(0.4);
    doc.line(M, y, W - M, y);
    y += 8;

    // ===== TITOLO =====
    doc.setFont('helvetica','bold');
    doc.setFontSize(15);
    doc.setTextColor(...COLORS.navy);
    doc.text(opts.titolo || 'Calcolo', M, y);
    y += 6;

    // Sottotitolo normativa
    if (opts.normativa) {
      doc.setFont('helvetica','italic');
      doc.setFontSize(9.5);
      doc.setTextColor(...COLORS.muted);
      doc.text('Riferimento normativo: ' + opts.normativa, M, y);
      y += 6;
    }

    // ===== DATI CLIENTE (se presenti) =====
    if (opts.cliente && (opts.cliente.nome || opts.cliente.codiceFiscale)) {
      y += 2;
      doc.setFillColor(...COLORS.lightBg);
      doc.roundedRect(M, y, W - 2*M, 16, 1.5, 1.5, 'F');
      doc.setFont('helvetica','bold');
      doc.setFontSize(8);
      doc.setTextColor(...COLORS.gold);
      doc.text('DATI CLIENTE', M + 4, y + 5);
      doc.setFont('helvetica','normal');
      doc.setFontSize(10);
      doc.setTextColor(...COLORS.text);
      let cx = M + 4, cy = y + 11;
      if (opts.cliente.nome) {
        doc.text('Cliente: ' + opts.cliente.nome, cx, cy);
        cx += 80;
      }
      if (opts.cliente.codiceFiscale) {
        doc.text('C.F.: ' + opts.cliente.codiceFiscale, cx, cy);
      }
      y += 20;
    }

    // ===== DATI PRINCIPALI (se presenti) =====
    if (opts.dati && opts.dati.length) {
      doc.setFont('helvetica','bold');
      doc.setFontSize(11);
      doc.setTextColor(...COLORS.navy);
      doc.text('Dati di partenza', M, y);
      y += 5;

      doc.setFont('helvetica','normal');
      doc.setFontSize(10);
      doc.setTextColor(...COLORS.text);
      opts.dati.forEach(d => {
        if (y > H - 40) { doc.addPage(); y = M; }
        doc.setTextColor(...COLORS.muted);
        doc.text(d.label + ':', M, y);
        doc.setTextColor(...COLORS.text);
        doc.setFont('helvetica','bold');
        doc.text(String(d.value), M + 70, y);
        doc.setFont('helvetica','normal');
        y += 5;
      });
      y += 4;
    }

    // ===== TABELLA RISULTATI =====
    if (opts.tabella && opts.tabella.headers && opts.tabella.rows) {
      if (y > H - 60) { doc.addPage(); y = M; }
      doc.setFont('helvetica','bold');
      doc.setFontSize(11);
      doc.setTextColor(...COLORS.navy);
      doc.text(opts.tabella.titolo || 'Dettaglio calcolo', M, y);
      y += 4;

      const headers = opts.tabella.headers;
      const rows = opts.tabella.rows;
      const colWidth = (W - 2*M) / headers.length;

      // Header riga
      doc.setFillColor(...COLORS.navy);
      doc.rect(M, y, W - 2*M, 7, 'F');
      doc.setFont('helvetica','bold');
      doc.setFontSize(9);
      doc.setTextColor(255, 255, 255);
      headers.forEach((h, i) => {
        doc.text(h, M + i*colWidth + 2, y + 4.8);
      });
      y += 7;

      // Righe dati
      doc.setFont('helvetica','normal');
      doc.setFontSize(9);
      doc.setTextColor(...COLORS.text);
      rows.forEach((row, ri) => {
        if (y > H - 30) {
          doc.addPage();
          y = M;
          // Ripeti header su nuova pagina
          doc.setFillColor(...COLORS.navy);
          doc.rect(M, y, W - 2*M, 7, 'F');
          doc.setFont('helvetica','bold');
          doc.setTextColor(255, 255, 255);
          headers.forEach((h, i) => doc.text(h, M + i*colWidth + 2, y + 4.8));
          y += 7;
          doc.setFont('helvetica','normal');
          doc.setTextColor(...COLORS.text);
        }
        if (ri % 2 === 0) {
          doc.setFillColor(...COLORS.lightBg);
          doc.rect(M, y, W - 2*M, 6, 'F');
        }
        row.forEach((cell, i) => {
          const txt = String(cell);
          doc.text(txt, M + i*colWidth + 2, y + 4);
        });
        y += 6;
      });
      y += 6;
    }

    // ===== CONCLUSIONI =====
    if (opts.conclusioni) {
      if (y > H - 40) { doc.addPage(); y = M; }
      doc.setFillColor(...COLORS.lightBg);
      doc.setDrawColor(...COLORS.gold);
      doc.setLineWidth(0.3);
      const lines = doc.splitTextToSize(opts.conclusioni, W - 2*M - 8);
      const blockH = 6 + lines.length * 4.5 + 4;
      doc.roundedRect(M, y, W - 2*M, blockH, 1.5, 1.5, 'FD');
      doc.setFont('helvetica','bold');
      doc.setFontSize(8.5);
      doc.setTextColor(...COLORS.gold);
      doc.text('CONCLUSIONI', M + 4, y + 5);
      doc.setFont('helvetica','normal');
      doc.setFontSize(10);
      doc.setTextColor(...COLORS.text);
      doc.text(lines, M + 4, y + 10);
      y += blockH + 4;
    }

    // ===== FOOTER (su tutte le pagine) =====
    const pages = doc.internal.getNumberOfPages();
    for (let p = 1; p <= pages; p++) {
      doc.setPage(p);
      // Riga oro
      doc.setDrawColor(...COLORS.gold);
      doc.setLineWidth(0.3);
      doc.line(M, H - 22, W - M, H - 22);

      // Disclaimer
      doc.setFont('helvetica','italic');
      doc.setFontSize(7.5);
      doc.setTextColor(...COLORS.muted);
      const disclaimer = 'Documento generato automaticamente da ' + STUDIO.sito + '. ' +
        'I valori indicati hanno carattere indicativo e devono essere verificati con un professionista. ' +
        'Il documento non costituisce parere legale ex art. 14 c.d.f.';
      const dLines = doc.splitTextToSize(disclaimer, W - 2*M);
      doc.text(dLines, M, H - 18);

      // Generato il
      doc.setFont('helvetica','normal');
      doc.setFontSize(7.5);
      doc.setTextColor(...COLORS.text);
      doc.text('Generato il: ' + nowIso(), M, H - 9);
      if (opts.fonteIstat) {
        doc.text('Indici ISTAT aggiornati a: ' + opts.fonteIstat, M + 70, H - 9);
      }

      // Pagina
      doc.text('Pag. ' + p + ' di ' + pages, W - M, H - 9, {align:'right'});

      // Riga oro decorativa in fondo
      doc.setFillColor(...COLORS.gold);
      doc.rect(0, H - 4, W, 4, 'F');
    }

    // ===== SALVA =====
    const filename = (opts.filename || 'calcolo') + '_' +
                     new Date().toISOString().slice(0,10) + '.pdf';
    doc.save(filename);
  }

  // Espone pubblicamente
  global.LanottePDF = { generate, STUDIO, COLORS };
})(window);
