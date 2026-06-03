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

  function open(opts){
    opts = opts || {};
    if (typeof opts.beforeOpen === 'function') opts.beforeOpen();
    ensureStyles();
    const clone = cloneReport(opts.selector || '#print-report');
    if (!clone) return;

    const modal = document.createElement('div');
    modal.className = 'lph-backdrop';
    modal.innerHTML = `
      <div class="lph-modal" role="dialog" aria-modal="true" aria-label="Anteprima report">
        <div class="lph-top"><h3>${opts.title || 'Anteprima report'}</h3><button type="button" class="lph-close" aria-label="Chiudi">×</button></div>
        <div class="lph-body"><div class="lph-preview"></div></div>
        <div class="lph-actions">
          <button type="button" data-action="close">Torna al calcolo</button>
          <button type="button" data-action="print">Stampa</button>
          <button type="button" class="primary" data-action="pdf">Scarica PDF</button>
        </div>
      </div>
    `;
    modal.querySelector('.lph-preview').appendChild(clone);
    document.body.appendChild(modal);
    modal.querySelector('.lph-close').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="close"]').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="print"]').addEventListener('click', () => printNode(clone));
    modal.querySelector('[data-action="pdf"]').addEventListener('click', () => printNode(clone));
    modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
  }

  global.LanottePreview = { open };
})(window);
