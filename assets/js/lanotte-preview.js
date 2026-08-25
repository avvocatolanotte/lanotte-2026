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
    let cleaned = false;
    const cleanup = function(){
      if (cleaned) return;
      cleaned = true;
      document.body.classList.remove('lph-printing');
      root.remove();
    };
    global.addEventListener('afterprint', cleanup, {once:true});
    setTimeout(cleanup, 60000);
    global.requestAnimationFrame(function(){
      global.requestAnimationFrame(function(){ global.print(); });
    });
  }

  function loadJsPdf(callback){
    if (global.jspdf && global.jspdf.jsPDF) {
      callback();
      return;
    }
    const existing = document.querySelector('script[data-lanotte-jspdf]');
    if (existing) {
      let completed = false;
      const existingFallback = function(){
        if (completed) return;
        completed = true;
        alert('Download PDF non disponibile. Si apre la stampa: scegli “Salva come PDF”.');
        printNode(document.querySelector('.lph-preview') || document.body);
      };
      const existingTimer = setTimeout(existingFallback, 12000);
      existing.addEventListener('load', function(){
        if (completed) return;
        completed = true;
        clearTimeout(existingTimer);
        callback();
      }, {once:true});
      existing.addEventListener('error', function(){
        clearTimeout(existingTimer);
        existingFallback();
      }, {once:true});
      return;
    }
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
    script.async = true;
    script.dataset.lanotteJspdf = '1';
    let settled = false;
    const fallback = function(){
      if (settled) return;
      settled = true;
      alert('Download PDF non disponibile. Si apre la stampa: scegli “Salva come PDF”.');
      printNode(document.querySelector('.lph-preview') || document.body);
    };
    const timer = setTimeout(fallback, 12000);
    script.onload = function(){
      if (settled) return;
      settled = true;
      clearTimeout(timer);
      callback();
    };
    script.onerror = function(){
      clearTimeout(timer);
      fallback();
    };
    document.head.appendChild(script);
  }

  function cleanPdfText(value){
    return String(value || '')
      .replace(/[\u2018\u2019]/g, "'")
      .replace(/[\u2013\u2014]/g, '-')
      .replace(/\u00a0/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();
  }

  function downloadStructuredReport(doc, report, title){
    const navy = [14, 26, 51];
    const gold = [184, 153, 104];
    const slate = [71, 85, 105];
    const light = [247, 248, 250];
    const margin = 16;
    const pageWidth = 210;
    const contentWidth = pageWidth - margin * 2;
    const pageBottom = 278;
    let pageNumber = 1;
    let y = 13;

    function setColor(rgb){ doc.setTextColor(rgb[0], rgb[1], rgb[2]); }
    function pageHeader(){
      doc.setFillColor(gold[0], gold[1], gold[2]);
      doc.rect(0, 0, pageWidth, 3, 'F');
      if (pageNumber > 1) {
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(8);
        setColor(navy);
        doc.text('STUDIO LEGALE LANOTTE & PARTNERS', margin, 10);
        doc.setDrawColor(220, 224, 230);
        doc.line(margin, 12, pageWidth - margin, 12);
        y = 18;
      }
    }
    function pageFooter(){
      doc.setDrawColor(220, 224, 230);
      doc.line(margin, 286, pageWidth - margin, 286);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(7.5);
      setColor(slate);
      doc.text('www.studiolegalelanotte.it  |  Prospetto generato automaticamente', margin, 291);
      doc.text('Pagina ' + pageNumber, pageWidth - margin, 291, {align:'right'});
    }
    function nextPage(){
      pageFooter();
      doc.addPage();
      pageNumber += 1;
      pageHeader();
    }
    function ensure(height){ if (y + height > pageBottom) nextPage(); }
    function wrapped(text, width, size, style){
      doc.setFont('helvetica', style || 'normal');
      doc.setFontSize(size || 9);
      return doc.splitTextToSize(cleanPdfText(text), width);
    }
    function sectionHeading(number, heading){
      ensure(13);
      doc.setFillColor(navy[0], navy[1], navy[2]);
      doc.rect(margin, y, 8, 8, 'F');
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(7);
      doc.setTextColor(255, 255, 255);
      doc.text(number, margin + 4, y + 5.4, {align:'center'});
      doc.setFontSize(9);
      setColor(navy);
      doc.text(cleanPdfText(heading).replace(/^\d{2}\s*/, '').toUpperCase(), margin + 12, y + 5.8);
      doc.setDrawColor(gold[0], gold[1], gold[2]);
      doc.line(margin + 12, y + 8, pageWidth - margin, y + 8);
      y += 12;
    }
    function drawRows(rows){
      rows.forEach(function(row, index){
        const cells = row.querySelectorAll('td,th');
        if (cells.length < 2) return;
        const label = cleanPdfText(cells[0].innerText || cells[0].textContent);
        const value = cleanPdfText(cells[1].innerText || cells[1].textContent);
        const labelLines = wrapped(label, 103, 8.4, 'normal');
        const valueLines = wrapped(value, 62, 8.7, 'bold');
        const rowHeight = Math.max(8, Math.max(labelLines.length, valueLines.length) * 4.2 + 3.2);
        ensure(rowHeight);
        const isTotal = row.classList.contains('print-total');
        if (isTotal) {
          doc.setFillColor(245, 239, 229);
          doc.setDrawColor(gold[0], gold[1], gold[2]);
          doc.rect(margin, y, contentWidth, rowHeight, 'FD');
        } else if (index % 2) {
          doc.setFillColor(light[0], light[1], light[2]);
          doc.rect(margin, y, contentWidth, rowHeight, 'F');
        }
        doc.setFont('helvetica', isTotal ? 'bold' : 'normal');
        doc.setFontSize(isTotal ? 10 : 8.4);
        setColor(isTotal ? navy : slate);
        doc.text(labelLines, margin + 3, y + 5.2);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(isTotal ? 12 : 8.7);
        setColor(navy);
        doc.text(valueLines, pageWidth - margin - 3, y + 5.2, {align:'right'});
        y += rowHeight;
      });
      y += 5;
    }

    pageHeader();
    const logoImage = report.querySelector('.print-logo-image');
    let logoAdded = false;
    if (logoImage && logoImage.complete && logoImage.naturalWidth) {
      try {
        const canvas = document.createElement('canvas');
        canvas.width = logoImage.naturalWidth;
        canvas.height = logoImage.naturalHeight;
        canvas.getContext('2d').drawImage(logoImage, 0, 0);
        doc.addImage(canvas.toDataURL('image/png'), 'PNG', margin, y, 62, 20.7, 'lanotte-logo', 'FAST');
        logoAdded = true;
      } catch (e) {}
    }
    if (!logoAdded) {
      doc.setFillColor(navy[0], navy[1], navy[2]);
      doc.rect(margin, y, 18, 18, 'F');
      doc.setFont('times', 'bold');
      doc.setFontSize(15);
      doc.setTextColor(gold[0], gold[1], gold[2]);
      doc.text('L&', margin + 9, y + 11.8, {align:'center'});
      doc.setFont('times', 'bold');
      doc.setFontSize(14);
      setColor(navy);
      doc.text('Studio Legale Lanotte & Partners', margin + 23, y + 7);
    }
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6.8);
    setColor(slate);
    doc.text('Avv. Giuseppe Lanotte - Ordine degli Avvocati di Trani', margin + 1, y + 24);
    doc.text('Viale Falcone e Borsellino, 75 - Barletta (BT) | Tel. 0883 1955533', margin + 1, y + 28);
    const meta = report.querySelector('.print-meta');
    const metaLines = meta ? cleanPdfText(meta.innerText).split(/(?=Documento n\.|Data calcolo:)/) : [];
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(7);
    setColor(navy);
    doc.text('PROSPETTO DI CALCOLO', pageWidth - margin, y + 4, {align:'right'});
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6.7);
    setColor(slate);
    metaLines.filter(Boolean).slice(-2).forEach(function(line, i){
      doc.text(cleanPdfText(line), pageWidth - margin, y + 9 + i * 4, {align:'right'});
    });
    y += 33;
    doc.setDrawColor(220, 224, 230);
    doc.line(margin, y, pageWidth - margin, y);
    y += 8;

    const kicker = report.querySelector('.print-kicker');
    const reportTitle = report.querySelector('.print-title');
    const subtitle = report.querySelector('.print-subtitle');
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(7.5);
    doc.setTextColor(gold[0], gold[1], gold[2]);
    doc.text(cleanPdfText(kicker && kicker.innerText).toUpperCase(), margin, y);
    y += 6;
    doc.setFont('times', 'bold');
    doc.setFontSize(22);
    setColor(navy);
    doc.text(cleanPdfText(reportTitle && reportTitle.innerText), margin, y);
    y += 6;
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8.5);
    setColor(slate);
    doc.text(wrapped(subtitle && subtitle.innerText, contentWidth, 8.5, 'normal'), margin, y);
    y += 10;

    const status = report.querySelector('.print-status');
    if (status) {
      const statusLines = wrapped(status.innerText, contentWidth - 8, 8, 'normal');
      const statusHeight = statusLines.length * 3.8 + 7;
      doc.setFillColor(244, 246, 249);
      doc.setDrawColor(navy[0], navy[1], navy[2]);
      doc.rect(margin, y, contentWidth, statusHeight, 'FD');
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(8);
      setColor(slate);
      doc.text(statusLines, margin + 4, y + 5);
      y += statusHeight + 7;
    }

    const sections = report.querySelectorAll('.print-section');
    sections.forEach(function(section, index){
      const heading = section.querySelector('h2');
      sectionHeading(String(index + 1).padStart(2, '0'), heading ? heading.innerText : 'Sezione');
      const table = section.querySelector('table');
      if (table) {
        drawRows(table.querySelectorAll('tr'));
        return;
      }
      const paragraph = section.querySelector('p');
      if (paragraph) {
        const lines = wrapped(paragraph.innerText, contentWidth, 8.2, 'normal');
        ensure(lines.length * 3.9 + 4);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8.2);
        setColor(slate);
        doc.text(lines, margin, y);
        y += lines.length * 3.9 + 4;
      }
      const formulaItems = section.querySelectorAll('.print-formula-grid > div');
      if (formulaItems.length) {
        ensure(19);
        const gap = 3;
        const boxWidth = (contentWidth - gap * 2) / 3;
        formulaItems.forEach(function(item, itemIndex){
          const x = margin + itemIndex * (boxWidth + gap);
          doc.setFillColor(light[0], light[1], light[2]);
          doc.setDrawColor(220, 224, 230);
          doc.rect(x, y, boxWidth, 15, 'FD');
          const parts = item.querySelectorAll('span,strong');
          doc.setFont('helvetica', 'normal');
          doc.setFontSize(6.7);
          setColor(slate);
          doc.text(cleanPdfText(parts[0] && parts[0].innerText), x + 2.5, y + 4.5);
          doc.setFont('helvetica', 'bold');
          doc.setFontSize(8);
          setColor(navy);
          doc.text(cleanPdfText(parts[1] && parts[1].innerText), x + 2.5, y + 10.5);
        });
        y += 20;
      }
      const items = section.querySelectorAll('li');
      if (items.length) {
        items.forEach(function(item){
          const lines = wrapped('- ' + item.innerText, contentWidth - 3, 7.7, 'normal');
          ensure(lines.length * 3.7 + 1);
          doc.setFont('helvetica', 'normal');
          doc.setFontSize(7.7);
          setColor(slate);
          doc.text(lines, margin + 2, y);
          y += lines.length * 3.7 + 1;
        });
        y += 4;
      }
    });

    const disclaimer = report.querySelector('.print-disclaimer');
    if (disclaimer) {
      const disclaimerLines = wrapped(disclaimer.innerText, contentWidth - 8, 7.5, 'normal');
      const h = disclaimerLines.length * 3.5 + 8;
      ensure(h);
      doc.setFillColor(255, 248, 232);
      doc.setDrawColor(gold[0], gold[1], gold[2]);
      doc.rect(margin, y, contentWidth, h, 'FD');
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(7.5);
      doc.setTextColor(95, 75, 34);
      doc.text(disclaimerLines, margin + 4, y + 5);
      y += h + 4;
    }

    pageFooter();
    const filename = (title || 'prospetto-calcolo-danno-biologico').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    doc.save((filename || 'prospetto-calcolo-danno-biologico') + '.pdf');
  }

  function downloadPdf(node, title){
    loadJsPdf(function(){
      const jsPDF = global.jspdf && global.jspdf.jsPDF;
      if (!jsPDF) {
        printNode(node);
        return;
      }
      const doc = new jsPDF({orientation:'portrait', unit:'mm', format:'a4'});
      const structuredReport = node.matches && node.matches('[data-lanotte-structured-pdf="damage-biological"]')
        ? node
        : node.querySelector('[data-lanotte-structured-pdf="damage-biological"]');
      if (structuredReport) {
        downloadStructuredReport(doc, structuredReport, title);
        return;
      }
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
    document.dispatchEvent(new CustomEvent('lanotte:calculation', {detail:{action:'preview_open'}}));
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
    modal.querySelector('[data-action="print"]').addEventListener('click', () => {
      document.dispatchEvent(new CustomEvent('lanotte:calculation', {detail:{action:'report_print'}}));
      printNode(clone);
    });
    modal.querySelector('[data-action="pdf"]').addEventListener('click', () => {
      document.dispatchEvent(new CustomEvent('lanotte:calculation', {detail:{action:'pdf_download'}}));
      downloadPdf(clone, title);
    });
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
