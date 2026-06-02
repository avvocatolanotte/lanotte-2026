<?php
/**
 * Template Name: Richiesta preventivo
 * Template Post Type: page
 *
 * @package lanotte-2026
 */
get_header();
?>

<section style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);color:#fff;padding:60px 0 50px">
  <div class="container">
    <nav style="font-size:13px;color:#cbd5e1;margin-bottom:14px">
      <a href="<?php echo esc_url(home_url('/')); ?>" style="color:#cbd5e1">Home</a>
      <span style="opacity:.5;margin:0 8px">&gt;</span>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari')) ?: home_url('/onorari/')); ?>" style="color:#cbd5e1">Onorari e servizi</a>
      <span style="opacity:.5;margin:0 8px">&gt;</span>
      <span style="color:#b89968">Richiesta preventivo</span>
    </nav>
    <h1 style="font-family:var(--serif);font-size:44px;font-weight:600;line-height:1.1;margin:0 0 14px;color:#fff">Richiesta di preventivo scritto</h1>
    <p style="font-size:17px;color:#cbd5e1;max-width:720px;margin:0;line-height:1.6">Ai sensi dell'art. 13 L. 247/2012, ogni prestazione e preceduta da preventivo scritto personalizzato. Compili la richiesta indicando i servizi di interesse: lo Studio rispondera entro 48 ore lavorative.</p>
  </div>
</section>

<section style="background:#fafaf7;padding:60px 0">
  <div class="container">
    <div id="cartLayout" class="quote-layout">
      <div>
        <div class="quote-block">
          <div class="quote-block-head">
            <h2>Servizi selezionati <span id="cartCountLabel">(0)</span></h2>
            <a href="<?php echo esc_url((get_permalink(get_page_by_path('onorari')) ?: home_url('/onorari/')) . '#servizi-online'); ?>" class="quote-link-back">Aggiungi altri servizi</a>
          </div>
          <ul id="cartItems" class="quote-items"></ul>
          <div id="cartEmpty" class="quote-empty" style="display:none">
            <h3>Nessun servizio selezionato</h3>
            <p>Sfoglia il catalogo e aggiunga i servizi di interesse alla richiesta.</p>
            <a href="<?php echo esc_url((get_permalink(get_page_by_path('onorari')) ?: home_url('/onorari/')) . '#servizi-online'); ?>" class="btn btn-primary">Vai ai servizi online</a>
          </div>
        </div>

        <div class="quote-block" id="formBlock">
          <div class="quote-block-head"><h2>I suoi dati</h2></div>
          <form id="quoteForm" class="quote-form">
            <div class="form-row">
              <label>Nome e cognome *<input type="text" name="nome" required></label>
              <label>Email *<input type="email" name="email" required></label>
            </div>
            <div class="form-row">
              <label>Telefono *<input type="tel" name="telefono" required placeholder="+39 ..."></label>
              <label>Citta / Comune<input type="text" name="citta"></label>
            </div>
            <label>Sono *
              <select name="qualifica" required>
                <option value="">Seleziona</option>
                <option>Privato cittadino</option>
                <option>Impresa / Professionista</option>
                <option>Associazione / ETS / No Profit</option>
                <option>Pubblica Amministrazione</option>
                <option>Avvocato corrispondente</option>
              </select>
            </label>
            <label>Descrizione della questione *
              <textarea name="descrizione" rows="5" required placeholder="Descriva brevemente la situazione, le parti coinvolte, le scadenze rilevanti e gli obiettivi auspicati."></textarea>
            </label>
            <label>Urgenza
              <select name="urgenza">
                <option>Standard (48-72 ore)</option>
                <option>Entro 24 ore</option>
                <option>Immediata (oggi)</option>
              </select>
            </label>

            <fieldset class="quote-consent">
              <label class="checkbox-line">
                <input type="checkbox" name="privacy" required>
                <span>Ho letto l'<a href="<?php echo esc_url(home_url('/privacy/')); ?>" target="_blank" rel="noopener">informativa privacy</a> e acconsento al trattamento dei dati per la formulazione del preventivo. *</span>
              </label>
              <label class="checkbox-line">
                <input type="checkbox" name="preventivo" required>
                <span>Ho preso atto che la richiesta non costituisce conferimento d'incarico e che ricevero un preventivo scritto personalizzato ex art. 13 L. 247/2012. *</span>
              </label>
            </fieldset>

            <button type="submit" class="btn btn-primary" id="submitBtn">Prepara email di richiesta</button>
            <p class="quote-note">L'invio apre il programma email con il riepilogo gia compilato.</p>
          </form>
        </div>
      </div>

      <aside class="quote-sidebar">
        <div class="quote-side-card quote-summary">
          <h4>Riepilogo richiesta</h4>
          <div class="quote-row"><span>Servizi selezionati</span><strong id="sumCount">0</strong></div>
          <div class="quote-row"><span>Tipo preventivo</span><strong>Personalizzato</strong></div>
          <div class="quote-row"><span>Tempo di risposta</span><strong>48h lavorative</strong></div>
          <div class="quote-row"><span>Costo preventivo</span><strong style="color:#16a34a">Gratuito</strong></div>
          <p>Il preventivo scritto indichera compenso, modalita di pagamento, tempi e oneri accessori.</p>
        </div>

        <div class="quote-side-card">
          <h4>Cosa succede dopo</h4>
          <ol class="quote-steps">
            <li><strong>Ricezione richiesta</strong><span>Lo Studio prende in carico il messaggio.</span></li>
            <li><strong>Analisi preliminare</strong><span>Valutazione di competenza e urgenza.</span></li>
            <li><strong>Contatto diretto</strong><span>Telefonata o email per eventuali dettagli.</span></li>
            <li><strong>Preventivo scritto</strong><span>Risposta entro 48 ore lavorative.</span></li>
          </ol>
        </div>

        <div class="quote-side-card quote-urgent">
          <h4>Urgenza penale?</h4>
          <p>Per arresti, fermi, perquisizioni o scadenze immediate.</p>
          <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>"><?php echo esc_html(lanotte_phone()); ?></a>
        </div>
      </aside>
    </div>
  </div>
</section>

<style>
.quote-layout{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(280px,1fr);gap:40px;align-items:start}
.quote-block{background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:28px;margin-bottom:24px}
.quote-block-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f1f5f9;flex-wrap:wrap;gap:10px}
.quote-block-head h2{font-family:var(--serif);font-size:24px;color:var(--navy);margin:0;font-weight:600}
.quote-block-head h2 span{color:var(--gold);font-size:18px;font-weight:500}
.quote-link-back{font-size:13.5px;color:var(--gold);font-weight:600}
.quote-items{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px}
.quote-items li{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;padding:18px;background:#fafaf7;border:1px solid #f0e9dc;border-radius:6px}
.quote-items .ci-title{font-weight:600;color:var(--navy);font-size:15.5px;margin:0 0 4px;font-family:var(--serif)}
.quote-items .ci-sku{font-size:11.5px;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;font-weight:600}
.quote-items .ci-rm{background:none;border:1px solid #fecaca;color:#dc2626;font-size:13px;padding:6px 12px;border-radius:3px;cursor:pointer;font-weight:600;font-family:inherit;flex-shrink:0}
.quote-items .ci-rm:hover{background:#dc2626;color:#fff;border-color:#dc2626}
.quote-empty{text-align:center;padding:50px 20px;background:#fff;border:2px dashed #e5e7eb;border-radius:6px}
.quote-empty h3{font-family:var(--serif);color:var(--navy);font-size:22px;margin:0 0 8px}
.quote-empty p{color:#64748b;margin:0 0 22px}
.quote-form{display:flex;flex-direction:column;gap:16px}
.quote-form label{display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:600;color:var(--navy);letter-spacing:.02em}
.quote-form input,.quote-form select,.quote-form textarea{padding:11px 14px;border:1px solid #cbd5e1;border-radius:4px;font-size:14.5px;font-family:inherit;color:var(--text);background:#fff;width:100%;font-weight:400}
.quote-form input:focus,.quote-form select:focus,.quote-form textarea:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,153,104,.15)}
.quote-form .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.quote-form textarea{resize:vertical;min-height:110px}
.quote-consent{border:1px solid #f0e9dc;border-radius:6px;padding:14px 16px;background:#fdfbf5;display:flex;flex-direction:column;gap:10px;margin:0}
.checkbox-line{display:flex;align-items:flex-start;gap:10px;font-weight:400;font-size:13px;line-height:1.5;color:#475569}
.checkbox-line input{width:18px;height:18px;margin:2px 0 0;flex-shrink:0;cursor:pointer;accent-color:var(--gold)}
.checkbox-line a{color:var(--gold);font-weight:600}
.quote-note{font-size:12px;color:#64748b;margin:0;text-align:center}
.quote-sidebar{display:flex;flex-direction:column;gap:18px;position:sticky;top:90px}
.quote-side-card{background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:24px}
.quote-side-card h4{font-family:var(--serif);font-size:18px;color:var(--navy);margin:0 0 16px;font-weight:600}
.quote-summary{background:linear-gradient(180deg,#fdfbf5 0%,#fff 100%);border-color:#f0e9dc}
.quote-summary p{font-size:12.5px;color:#64748b;margin:14px 0 0;line-height:1.55;border-top:1px solid #e5e7eb;padding-top:14px}
.quote-row{display:flex;justify-content:space-between;align-items:center;padding:6px 0;font-size:13.5px;color:#475569}
.quote-row strong{color:var(--navy);font-size:14px}
.quote-steps{padding:0;margin:0;list-style:none;counter-reset:step;display:flex;flex-direction:column;gap:12px}
.quote-steps li{counter-increment:step;position:relative;padding-left:34px;font-size:13.5px;line-height:1.4}
.quote-steps li::before{content:counter(step);position:absolute;left:0;top:0;width:24px;height:24px;background:var(--gold);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700}
.quote-steps strong{color:var(--navy);display:block;font-size:14px;font-weight:600}
.quote-steps span{color:#64748b;font-size:12.5px}
.quote-urgent{background:linear-gradient(135deg,#7f1d1d,#991b1b);border:0;color:#fff}
.quote-urgent h4{color:#fff}
.quote-urgent p{font-size:13px;color:#fecaca;margin:0 0 12px;line-height:1.5}
.quote-urgent a{display:inline-block;background:#fff;color:#7f1d1d;padding:10px 16px;border-radius:4px;font-size:16px;font-weight:700;font-family:var(--serif)}
@media (max-width:900px){.quote-layout{grid-template-columns:1fr}.quote-sidebar{position:static}.quote-form .form-row{grid-template-columns:1fr}}
</style>

<script>
(function(){
  const CART_KEY='lanotte_cart_v1';
  const emailTo=<?php echo wp_json_encode(lanotte_email()); ?>;
  function safeText(value){return String(value || '').replace(/[<>&"']/g,function(ch){return {'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;',"'":'&#039;'}[ch];});}
  function getCart(){try{return JSON.parse(localStorage.getItem(CART_KEY))||[]}catch(e){return[]}}
  function setCart(arr){localStorage.setItem(CART_KEY,JSON.stringify(arr));render();}
  function removeItem(sku){setCart(getCart().filter(function(i){return i.sku!==sku;}));}
  function render(){
    const cart=getCart();
    const list=document.getElementById('cartItems');
    const empty=document.getElementById('cartEmpty');
    const formBlock=document.getElementById('formBlock');
    document.getElementById('cartCountLabel').textContent='('+cart.length+')';
    document.getElementById('sumCount').textContent=cart.length;
    document.querySelectorAll('[data-cart-count]').forEach(function(el){el.textContent=cart.length;el.setAttribute('data-cart-count',cart.length);});
    if(cart.length===0){list.style.display='none';empty.style.display='block';formBlock.style.opacity='.45';formBlock.style.pointerEvents='none';return;}
    list.style.display='flex';empty.style.display='none';formBlock.style.opacity='1';formBlock.style.pointerEvents='auto';
    list.innerHTML=cart.map(function(i){
      return '<li><div class="ci-info"><p class="ci-title">'+safeText(i.name)+'</p><span class="ci-sku">Cod. '+safeText(i.sku)+'</span></div><button class="ci-rm" data-rm="'+safeText(i.sku)+'" type="button">Rimuovi</button></li>';
    }).join('');
    list.querySelectorAll('button[data-rm]').forEach(function(b){b.onclick=function(){removeItem(b.dataset.rm);};});
  }
  document.getElementById('quoteForm').addEventListener('submit',function(e){
    e.preventDefault();
    const cart=getCart();
    if(cart.length===0){return;}
    const data=new FormData(this);
    const subject='Richiesta preventivo - '+data.get('nome')+' ('+cart.length+' servizi)';
    const lines=[
      'RICHIESTA DI PREVENTIVO ex art. 13 L. 247/2012',
      '',
      'DATI RICHIEDENTE',
      'Nome e cognome: '+data.get('nome'),
      'Email: '+data.get('email'),
      'Telefono: '+data.get('telefono'),
      'Citta: '+(data.get('citta')||'-'),
      'Qualifica: '+data.get('qualifica'),
      '',
      'SERVIZI RICHIESTI ('+cart.length+')'
    ];
    cart.forEach(function(i,n){lines.push((n+1)+'. '+i.name+' ['+i.sku+']');});
    lines.push('', 'DESCRIZIONE DELLA QUESTIONE', data.get('descrizione'), '', 'URGENZA: '+data.get('urgenza'), '', 'CONSENSI', 'Privacy accettata', 'Preventivo scritto ex art. 13 L. 247/2012 accettato', '', 'Inviato dal sito studiolegalelanotte.it', 'Data: '+new Date().toLocaleString('it-IT'));
    window.location.href='mailto:'+emailTo+'?subject='+encodeURIComponent(subject)+'&body='+encodeURIComponent(lines.join('\n'));
  });
  render();
})();
</script>

<?php get_footer();
