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

  function esc(value){
    return String(value ?? '').replace(/[&<>"']/g, ch => ({
      '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'
    }[ch]));
  }

  function rowsHtml(rows){
    return rows.map(row => '<tr>' + row.map(cell => '<td>' + esc(cell) + '</td>').join('') + '</tr>').join('');
  }

  function previewHtml(opts){
    const cliente = opts.cliente || {};
    const dati = opts.dati || [];
    const tabella = opts.tabella || null;
    return `
      <article class="lpv-report">
        <header class="lpv-head">
          <div>
            <strong>Lanotte <span>&amp;</span> Partners</strong>
            <small>Studio Legale · Foro di Trani</small>
          </div>
          <div class="lpv-meta">${esc(nowIso())}</div>
        </header>
        <h1>${esc(opts.titolo || 'Calcolo')}</h1>
        ${opts.normativa ? `<p class="lpv-sub">Riferimento normativo: ${esc(opts.normativa)}</p>` : ''}
        ${(cliente.nome || cliente.codiceFiscale) ? `
          <section>
            <h2>Dati cliente</h2>
            <table>
              ${cliente.nome ? `<tr><td>Cliente</td><td>${esc(cliente.nome)}</td></tr>` : ''}
              ${cliente.codiceFiscale ? `<tr><td>Codice fiscale</td><td>${esc(cliente.codiceFiscale)}</td></tr>` : ''}
            </table>
          </section>
        ` : ''}
        ${dati.length ? `
          <section>
            <h2>Dati e risultato</h2>
            <table>${dati.map(d => `<tr><td>${esc(d.label)}</td><td>${esc(d.value)}</td></tr>`).join('')}</table>
          </section>
        ` : ''}
        ${tabella && tabella.rows ? `
          <section>
            <h2>${esc(tabella.titolo || 'Dettaglio calcolo')}</h2>
            <div class="lpv-table-wrap">
              <table>
                ${tabella.headers ? `<thead><tr>${tabella.headers.map(h => `<th>${esc(h)}</th>`).join('')}</tr></thead>` : ''}
                <tbody>${rowsHtml(tabella.rows)}</tbody>
              </table>
            </div>
          </section>
        ` : ''}
        ${opts.conclusioni ? `<section class="lpv-conclusioni"><h2>Conclusioni</h2><p>${esc(opts.conclusioni)}</p></section>` : ''}
        <footer>Documento generato automaticamente da ${esc(STUDIO.sito)}. I valori hanno carattere indicativo e devono essere verificati con un professionista.</footer>
      </article>
    `;
  }

  function ensurePreviewStyles(){
    if (document.getElementById('lanotte-preview-styles')) return;
    const style = document.createElement('style');
    style.id = 'lanotte-preview-styles';
    style.textContent = `
      .lpv-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.72);z-index:99999;display:flex;align-items:center;justify-content:center;padding:24px}
      .lpv-modal{width:min(980px,100%);max-height:92vh;background:#fff;border-radius:8px;box-shadow:0 24px 80px rgba(0,0,0,.35);display:flex;flex-direction:column;overflow:hidden}
      .lpv-top{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 22px;background:#0E1A33;color:#fff;border-bottom:3px solid #B89968}
      .lpv-top h3{margin:0;font-family:var(--serif, Georgia, serif);font-size:22px;font-weight:600}
      .lpv-close{background:transparent;border:1px solid rgba(255,255,255,.35);color:#fff;border-radius:4px;width:34px;height:34px;cursor:pointer;font-size:22px;line-height:1}
      .lpv-body{overflow:auto;padding:24px;background:#f8fafc}
      .lpv-actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;padding:16px 22px;border-top:1px solid #e5e7eb;background:#fff}
      .lpv-actions button{border:1px solid #B89968;background:#fff;color:#0E1A33;padding:11px 16px;border-radius:4px;font-weight:700;cursor:pointer;font-family:inherit}
      .lpv-actions .primary{background:#B89968;color:#fff}
      .lpv-report{background:#fff;color:#0f172a;padding:28px;border:1px solid #e5e7eb;line-height:1.5}
      .lpv-head{display:flex;justify-content:space-between;gap:18px;border-bottom:2px solid #B89968;padding-bottom:14px;margin-bottom:18px}
      .lpv-head strong{font-family:Georgia,serif;font-size:22px;color:#0E1A33;display:block}.lpv-head strong span{color:#B89968}.lpv-head small,.lpv-meta{color:#64748b;font-size:12px}
      .lpv-report h1{font-family:Georgia,serif;color:#0E1A33;font-size:28px;margin:0 0 6px}.lpv-sub{color:#64748b;font-style:italic;margin:0 0 18px}
      .lpv-report section{margin-top:20px}.lpv-report h2{font-size:14px;text-transform:uppercase;letter-spacing:.08em;color:#B89968;margin:0 0 10px}
      .lpv-report table{width:100%;border-collapse:collapse;font-size:13px}.lpv-report th{background:#0E1A33;color:#fff;text-align:left;padding:8px}.lpv-report td{padding:8px;border-bottom:1px solid #e5e7eb;vertical-align:top}.lpv-report td:first-child{color:#64748b;font-weight:600}
      .lpv-table-wrap{overflow:auto}.lpv-conclusioni{background:#fdfbf5;border-left:4px solid #B89968;padding:14px}.lpv-conclusioni p{margin:0}.lpv-report footer{margin-top:24px;padding-top:12px;border-top:1px solid #e5e7eb;color:#64748b;font-size:12px;font-style:italic}
      @media print{body.lpv-printing > *:not(.lpv-print-root){display:none!important}.lpv-print-root{display:block!important}.lpv-report{border:0}.lpv-actions,.lpv-top{display:none!important}}
    `;
    document.head.appendChild(style);
  }

  function printMarkup(markup){
    ensurePreviewStyles();
    const root = document.createElement('div');
    root.className = 'lpv-print-root';
    root.innerHTML = markup;
    document.body.appendChild(root);
    document.body.classList.add('lpv-printing');
    window.print();
    setTimeout(() => {
      document.body.classList.remove('lpv-printing');
      root.remove();
    }, 500);
  }

  function preview(opts){
    ensurePreviewStyles();
    const markup = previewHtml(opts || {});
    const modal = document.createElement('div');
    modal.className = 'lpv-backdrop';
    modal.innerHTML = `
      <div class="lpv-modal" role="dialog" aria-modal="true" aria-label="Anteprima report">
        <div class="lpv-top"><h3>Anteprima report</h3><button type="button" class="lpv-close" aria-label="Chiudi">×</button></div>
        <div class="lpv-body">${markup}</div>
        <div class="lpv-actions">
          <button type="button" data-action="close">Torna al calcolo</button>
          <button type="button" data-action="print">Stampa</button>
          <button type="button" class="primary" data-action="pdf">Scarica PDF</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
    modal.querySelector('.lpv-close').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="close"]').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="print"]').addEventListener('click', () => printMarkup(markup));
    modal.querySelector('[data-action="pdf"]').addEventListener('click', () => generate(opts));
    modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
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
  global.LanottePDF = { generate, preview, STUDIO, COLORS };
})(window);
