/**
 * lanotte-istat-panel.js — Widget riutilizzabile per aggiornamento manuale indici ISTAT.
 *
 * USO:
 *   LanotteISTATPanel.inject('#contenitorePanel', { onUpdate: () => reloadCalc() });
 *
 * Requisito: LanotteISTAT deve già essere stato caricato con load().
 */
(function(global){
  'use strict';

  function inject(selectorOrEl, opts){
    opts = opts || {};
    const target = typeof selectorOrEl === 'string' ? document.querySelector(selectorOrEl) : selectorOrEl;
    if (!target) { console.warn('[LanotteISTATPanel] target non trovato'); return; }

    const mesi = LanotteISTAT.mesiDisponibili ? LanotteISTAT.mesiDisponibili() : [];
    const primo = mesi[0] || '2016-01';
    const ultimo = LanotteISTAT.ultimoMese();
    const next = nextMonth(ultimo);

    target.innerHTML = `
      <details class="lp-panel">
        <summary>
          <span>⚙️ Mancano valori ISTAT recenti? Aggiornali manualmente</span>
          <span class="lp-summary-cta">apri pannello ›</span>
        </summary>
        <div class="lp-body">
          <p class="lp-help">
            <strong>Quando si usa</strong>: se devi calcolare un mese non ancora presente nell'archivio locale,
            qui inserisci manualmente l'indice FOI senza tabacchi pubblicato da
            <a href="https://www.istat.it/notizia/indice-dei-prezzi-per-le-rivalutazioni-monetarie/" target="_blank" rel="noopener">istat.it</a>.<br>
            <strong>Il valore viene salvato nel tuo browser</strong> e usato in tutti i calcolatori ISTAT del sito.
          </p>
          <div class="lp-row">
            <label>Mese (YYYY-MM)<input type="month" class="lp-mese" value="${next}" min="${primo}"></label>
            <label>Valore FOI (base 2015=100)<input type="number" class="lp-valore" step="0.1" min="80" max="200" placeholder="Es. 124.8"></label>
          </div>
          <div class="lp-actions">
            <button type="button" class="btn btn-primary lp-save">Salva nel browser</button>
            <button type="button" class="btn btn-ghost lp-list">Vedi valori salvati</button>
          </div>
          <div class="lp-listbox" style="display:none"></div>
          <div class="lp-msg"></div>
        </div>
      </details>
    `;

    const root = target.querySelector('.lp-panel');
    const meseInput = root.querySelector('.lp-mese');
    const valoreInput = root.querySelector('.lp-valore');
    const msg = root.querySelector('.lp-msg');
    const listBox = root.querySelector('.lp-listbox');

    root.querySelector('.lp-save').addEventListener('click', async () => {
      const m = meseInput.value, v = valoreInput.value;
      if (!m || !v) { msg.innerHTML = '<span class="lp-err">⚠️ Compila entrambi i campi</span>'; return; }
      try {
        LanotteISTAT.aggiungiManuale(m, v);
        msg.innerHTML = '<span class="lp-ok">✓ Salvato. Indice FOI ' + m + ' = ' + v + ' ora disponibile.</span>';
        valoreInput.value = '';
        if (typeof opts.onUpdate === 'function') opts.onUpdate(m, v);
        mostraLista();
      } catch(err) { msg.innerHTML = '<span class="lp-err">⚠️ ' + err.message + '</span>'; }
    });

    root.querySelector('.lp-list').addEventListener('click', mostraLista);

    function mostraLista(){
      const lista = LanotteISTAT.listaManuali();
      const entries = Object.entries(lista).sort();
      listBox.style.display = 'block';
      if (entries.length === 0) {
        listBox.innerHTML = '<p class="lp-empty">Nessun valore manuale salvato. I dati vengono dalla banca dati locale o dall\'API ISTAT.</p>';
        return;
      }
      listBox.innerHTML = '<h5>Valori manuali salvati (' + entries.length + ')</h5>' +
        '<table class="lp-table"><tr><th>Mese</th><th>Valore FOI</th><th></th></tr>' +
        entries.map(([m, v]) => `<tr><td>${m}</td><td><strong>${v}</strong></td><td><button class="lp-rm" data-m="${m}">Rimuovi</button></td></tr>`).join('') +
        '</table>';
      listBox.querySelectorAll('.lp-rm').forEach(b => b.addEventListener('click', () => {
        LanotteISTAT.rimuoviManuale(b.dataset.m);
        if (typeof opts.onUpdate === 'function') opts.onUpdate();
        mostraLista();
      }));
    }
  }

  function nextMonth(yyyymm){
    if (!yyyymm) return '';
    const [y, m] = yyyymm.split('-').map(Number);
    let ny = y, nm = m + 1;
    if (nm > 12) { ny++; nm = 1; }
    return ny + '-' + String(nm).padStart(2, '0');
  }

  // CSS inline (auto-iniettato)
  if (!document.getElementById('lp-styles')) {
    const style = document.createElement('style');
    style.id = 'lp-styles';
    style.textContent = `
      .lp-panel{background:#fdfbf5;border:2px dashed #f0e9dc;border-radius:8px;padding:24px;margin-bottom:20px}
      .lp-panel summary{cursor:pointer;font-family:var(--serif);font-size:18px;color:var(--navy);font-weight:600;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:14px}
      .lp-panel summary::-webkit-details-marker{display:none}
      .lp-summary-cta{font-size:13px;color:var(--gold);font-weight:500}
      .lp-panel[open] .lp-summary-cta{display:none}
      .lp-body{margin-top:18px}
      .lp-help{font-size:13.5px;color:#475569;line-height:1.6;margin:0 0 16px}
      .lp-help a{color:var(--gold);font-weight:600}
      .lp-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px}
      .lp-row label{display:flex;flex-direction:column;gap:6px;font-size:13px;color:var(--navy);font-weight:600}
      .lp-row input{padding:10px 14px;border:1px solid #cbd5e1;border-radius:4px;font-size:14.5px;font-family:inherit;background:#fff;color:#334155}
      .lp-row input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,153,104,.15)}
      .lp-actions{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap}
      .lp-msg{margin-top:12px;font-size:13.5px}
      .lp-msg .lp-ok{color:#16a34a;background:#f0fdf4;padding:8px 12px;border-radius:4px;display:inline-block}
      .lp-msg .lp-err{color:#dc2626;background:#fee2e2;padding:8px 12px;border-radius:4px;display:inline-block}
      .lp-listbox{margin-top:18px;background:#fff;border:1px solid #e5e7eb;border-radius:4px;padding:14px}
      .lp-empty{font-size:13px;color:#64748b;font-style:italic;margin:0}
      .lp-listbox h5{margin:0 0 10px;color:var(--navy);font-family:var(--serif)}
      .lp-table{width:100%;border-collapse:collapse;font-size:13.5px}
      .lp-table th{background:var(--navy);color:#fff;padding:8px;text-align:left}
      .lp-table td{padding:6px 8px;border-bottom:1px solid #f1f5f9}
      .lp-rm{background:none;border:1px solid #fecaca;color:#dc2626;padding:3px 9px;border-radius:3px;cursor:pointer;font-size:12px;font-family:inherit}
      .lp-rm:hover{background:#dc2626;color:#fff}
      @media (max-width:700px){.lp-row{grid-template-columns:1fr}}
    `;
    document.head.appendChild(style);
  }

  global.LanotteISTATPanel = { inject };
})(window);
