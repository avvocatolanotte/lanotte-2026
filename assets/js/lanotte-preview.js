/**
 * lanotte-preview.js — Anteprima report HTML prima di stampare/salvare PDF.
 */
(function(global){
  'use strict';

  function ensureStyles(){
    if (document.getElementById('lanotte-preview-html-styles')) return;
    const style = document.createElement('style');
    style.id = 'lanotte-preview-html-styles';
    style.textContent = `
      .lph-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.72);z-index:99999;display:flex;align-items:center;justify-content:center;padding:24px}
      .lph-modal{width:min(980px,100%);max-height:92vh;background:#fff;border-radius:8px;box-shadow:0 24px 80px rgba(0,0,0,.35);display:flex;flex-direction:column;overflow:hidden}
      .lph-top{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 22px;background:#0E1A33;color:#fff;border-bottom:3px solid #B89968}
      .lph-top h3{margin:0;font-family:var(--serif, Georgia, serif);font-size:22px;font-weight:600}
      .lph-close{background:transparent;border:1px solid rgba(255,255,255,.35);color:#fff;border-radius:4px;width:34px;height:34px;cursor:pointer;font-size:22px;line-height:1}
      .lph-body{overflow:auto;padding:24px;background:#f8fafc}.lph-preview{background:#fff;color:#111;padding:26px;border:1px solid #e5e7eb}
      .lph-preview #print-report{display:block!important}
      .lph-report{background:#fff;color:#111;font-family:Georgia,'Times New Roman',serif;line-height:1.5}
      .lph-report-head{border-bottom:3px solid #B89968;padding-bottom:16px;margin-bottom:20px}
      .lph-report-kicker{font:700 11px Arial,sans-serif;letter-spacing:.16em;text-transform:uppercase;color:#B89968;margin-bottom:6px}
      .lph-report h1{margin:0;color:#0E1A33;font-size:28px;line-height:1.15;font-weight:600}
      .lph-report-subtitle{margin:8px 0 0;color:#475569;font:400 13px Arial,sans-serif}
      .lph-report table{width:100%;border-collapse:collapse;margin:18px 0;font:400 13px Arial,sans-serif}
      .lph-report th,.lph-report td{border-bottom:1px solid #e5e7eb;padding:10px 8px;text-align:left;vertical-align:top}
      .lph-report th{width:34%;color:#64748b;font-weight:700;background:#f8fafc}
      .lph-report-total{margin-top:18px;border:1px solid #B89968;background:#fdfbf5;padding:16px}
      .lph-report-total span{display:block;font:700 11px Arial,sans-serif;letter-spacing:.14em;text-transform:uppercase;color:#B89968;margin-bottom:4px}
      .lph-report-total strong{display:block;color:#0E1A33;font-size:26px;line-height:1.1}
      .lph-report-notes{margin-top:16px;color:#64748b;font:400 12px Arial,sans-serif;line-height:1.55}
      .lph-actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;padding:16px 22px;border-top:1px solid #e5e7eb;background:#fff}
      .lph-actions button{border:1px solid #B89968;background:#fff;color:#0E1A33;padding:11px 16px;border-radius:4px;font-weight:700;cursor:pointer;font-family:inherit}
      .lph-actions .primary{background:#B89968;color:#fff}
      @media print{body.lph-printing > *:not(.lph-print-root){display:none!important}.lph-print-root{display:block!important}.lph-actions,.lph-top{display:none!important}}
    `;
    document.head.appendChild(style);
  }

  function cloneReport(selector){
    const source = document.querySelector(selector || '#print-report');
    if (!source) {
      alert('Anteprima non disponibile: report non trovato.');
      return null;
    }
    const clone = source.cloneNode(true);
    clone.style.display = 'block';
    return clone;
  }

  function esc(value){
    return String(value == null ? '' : value).replace(/[&<>"']/g, function(ch){
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[ch]);
    });
  }

  function printNode(node){
    const root = document.createElement('div');
    root.className = 'lph-print-root';
    root.appendChild(node.cloneNode(true));
    document.body.appendChild(root);
    document.body.classList.add('lph-printing');
    window.print();
    setTimeout(() => {
      document.body.classList.remove('lph-printing');
      root.remove();
    }, 500);
  }

  function loadJsPdf(callback){
    if (global.jspdf && global.jspdf.jsPDF) {
      callback();
      return;
    }
    const existing = document.querySelector('script[data-lanotte-jspdf]');
    if (existing) {
      existing.addEventListener('load', callback, {once:true});
      existing.addEventListener('error', function(){ printNode(document.querySelector('.lph-preview') || document.body); }, {once:true});
      return;
    }
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
    script.async = true;
    script.dataset.lanotteJspdf = '1';
    script.onload = callback;
    script.onerror = function(){
      alert('Download PDF non disponibile. Si apre la stampa: scegli “Salva come PDF”.');
      printNode(document.querySelector('.lph-preview') || document.body);
    };
    document.head.appendChild(script);
  }

  function downloadPdf(node, title){
    loadJsPdf(function(){
      const jsPDF = global.jspdf && global.jspdf.jsPDF;
      if (!jsPDF) {
        printNode(node);
        return;
      }
      const doc = new jsPDF({orientation:'portrait', unit:'mm', format:'a4'});
      const margin = 16;
      const width = 210 - margin * 2;
      const titleText = title || 'Anteprima report';
      const bodyText = (node.innerText || node.textContent || '').replace(/\n{3,}/g, '\n\n').trim();
      let y = margin;

      doc.setFillColor(184, 153, 104);
      doc.rect(0, 0, 210, 4, 'F');
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(16);
      doc.setTextColor(14, 26, 51);
      doc.text(titleText, margin, y);
      y += 8;

      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.setTextColor(51, 65, 85);
      const lines = doc.splitTextToSize(bodyText, width);
      lines.forEach(function(line){
        if (y > 282) {
          doc.addPage();
          y = margin;
        }
        doc.text(line, margin, y);
        y += 5;
      });

      const filename = titleText.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') || 'report';
      doc.save(filename + '.pdf');
    });
  }

  function openNode(node, title){
    ensureStyles();
    const modal = document.createElement('div');
    modal.className = 'lph-backdrop';
    modal.innerHTML = `
      <div class="lph-modal" role="dialog" aria-modal="true" aria-label="Anteprima report">
        <div class="lph-top"><h3>${esc(title || 'Anteprima report')}</h3><button type="button" class="lph-close" aria-label="Chiudi">×</button></div>
        <div class="lph-body"><div class="lph-preview"></div></div>
        <div class="lph-actions">
          <button type="button" data-action="close">Torna al calcolo</button>
          <button type="button" data-action="print">Stampa</button>
          <button type="button" class="primary" data-action="pdf">Scarica PDF</button>
        </div>
      </div>
    `;
    const clone = node.cloneNode(true);
    modal.querySelector('.lph-preview').appendChild(clone);
    document.body.appendChild(modal);
    modal.querySelector('.lph-close').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="close"]').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="print"]').addEventListener('click', () => printNode(clone));
    modal.querySelector('[data-action="pdf"]').addEventListener('click', () => downloadPdf(clone, title));
    modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
  }

  function open(opts){
    opts = opts || {};
    if (typeof opts.beforeOpen === 'function') opts.beforeOpen();
    const clone = cloneReport(opts.selector || '#print-report');
    if (!clone) return;
    openNode(clone, opts.title || 'Anteprima report');
  }

  function openSummary(opts){
    opts = opts || {};
    if (typeof opts.beforeOpen === 'function') opts.beforeOpen();
    const article = document.createElement('article');
    article.className = 'lph-report';
    const rows = (opts.rows || []).filter(function(row){ return row && row.length >= 2 && row[1] !== ''; });
    article.innerHTML = `
      <div class="lph-report-head">
        <div class="lph-report-kicker">${esc(opts.kicker || 'Studio Legale Lanotte & Partners')}</div>
        <h1>${esc(opts.title || 'Report di calcolo')}</h1>
        ${opts.subtitle ? '<p class="lph-report-subtitle">' + esc(opts.subtitle) + '</p>' : ''}
      </div>
      <table>
        <tbody>${rows.map(function(row){ return '<tr><th>' + esc(row[0]) + '</th><td>' + esc(row[1]) + '</td></tr>'; }).join('')}</tbody>
      </table>
      ${opts.total ? '<div class="lph-report-total"><span>' + esc(opts.totalLabel || 'Risultato') + '</span><strong>' + esc(opts.total) + '</strong></div>' : ''}
      ${opts.notes ? '<p class="lph-report-notes">' + esc(opts.notes) + '</p>' : ''}
    `;
    openNode(article, opts.modalTitle || 'Anteprima report');
  }

  global.LanottePreview = { open, openSummary };
})(window);
