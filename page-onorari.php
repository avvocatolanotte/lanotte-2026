<?php
/**
 * Template Name: Onorari & Servizi (unificato)
 * Template Post Type: page
 *
 * @package lanotte-2026
 */
get_header();
?>

<section style="background:linear-gradient(135deg,rgba(14,26,51,.92) 0%,rgba(14,26,51,.7) 100%),url('<?php echo esc_url(LANOTTE_THEME_URI . '/assets/img/trani/tribunale-facciata.jpg'); ?>');background-size:cover;background-position:center;color:#fff;padding:90px 0 70px">
  <div class="container" style="position:relative;z-index:2">
    <nav style="font-size:13px;color:#cbd5e1;margin-bottom:18px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:#cbd5e1">Home</a> <span style="opacity:.5">›</span> <span style="color:#b89968">Onorari e Servizi</span></nav>
    <span style="display:inline-block;padding:6px 14px;background:rgba(184,153,104,.18);border:1px solid rgba(184,153,104,.4);border-radius:2px;font-size:11px;letter-spacing:.14em;color:#d4b87f;font-weight:600;text-transform:uppercase;margin-bottom:18px">Trasparenza · Preventivo scritto · art. 13 L. 247/2012</span>
    <h1 style="font-family:var(--serif);font-size:48px;font-weight:600;line-height:1.1;margin:0 0 18px;color:#fff">Onorari trasparenti<br><em style="font-style:italic;color:#d4b87f">e catalogo servizi online</em></h1>
    <p style="font-size:17px;color:#cbd5e1;max-width:780px;margin:0;line-height:1.6">Lo Studio applica gli onorari secondo i parametri <strong style="color:#fff">DM 55/2014</strong> e consegna un <strong style="color:#fff">preventivo scritto sin dal primo incontro</strong>. Non applichiamo patti di quota lite (art. 25 c.d.f.).</p>
    <div style="display:flex;gap:14px;margin-top:28px;flex-wrap:wrap">
      <a href="#modalita" class="btn btn-primary">Modalità di consulenza</a>
      <a href="#servizi-online" class="btn btn-ghost" style="border-color:rgba(255,255,255,.4);color:#fff">Catalogo servizi online ↓</a>
    </div>
  </div>
</section>

<section class="block" id="modalita">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Modalità di consulenza</div>
      <h2>Tre formule, una sola qualità</h2>
      <p>Scegli la modalità più comoda. La consulenza in videocall è indicata per clienti fuori Puglia o per un primo orientamento rapido.</p>
    </div>
    <div class="tariff-grid">
      <div class="tariff">
        <h3>Consulenza in studio</h3>
        <div class="price" style="font-size:24px">Su preventivo</div>
        <div class="price-note">Parametri DM 55/2014 · oltre IVA e CPA</div>
        <p style="font-size:14px;color:var(--text-muted);margin-bottom:18px">Colloquio in presenza presso la sede di Barletta. Ideale per pratiche complesse e per la consegna documenti.</p>
        <ul><li>Analisi del caso e documentale</li><li>Parere verbale strutturato</li><li>Preventivo scritto ex art. 13 L. 247/2012</li></ul>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-outline">Prenota appuntamento</a>
      </div>
      <div class="tariff featured">
        <h3>Videoconsulenza</h3>
        <div class="price" style="font-size:24px">Su preventivo</div>
        <div class="price-note">Parametri DM 55/2014 · oltre IVA e CPA</div>
        <p style="font-size:14px;color:var(--text-muted);margin-bottom:18px">Colloquio in videocall (Google Meet, Zoom o Teams). Ottima per chi vive fuori provincia.</p>
        <ul><li>Analisi del caso a distanza</li><li>Documenti via email o cloud sicuro</li><li>Preventivo scritto ex art. 13 L. 247/2012</li></ul>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-primary">Prenota videocall</a>
      </div>
      <div class="tariff">
        <h3>Parere scritto</h3>
        <div class="price" style="font-size:24px">Su preventivo</div>
        <div class="price-note">Parametri DM 55/2014 · oltre IVA e CPA</div>
        <p style="font-size:14px;color:var(--text-muted);margin-bottom:18px">Parere motivato per iscritto, citante norme e giurisprudenza, su quesito specifico.</p>
        <ul><li>Analisi documentale completa</li><li>Citazione norme e giurisprudenza</li><li>Conclusioni operative</li></ul>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-outline">Richiedi parere</a>
      </div>
    </div>
  </div>
</section>

<section class="block" style="background:var(--cream)">
  <div class="container">
    <div class="section-title left" style="max-width:720px;margin-bottom:32px">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Compensi per attività giudiziale</div>
      <h2>Come calcoliamo gli onorari di causa</h2>
      <p>Parametri ministeriali DM 55/2014, modulati su complessità, valore, udienze e fasi processuali.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px">
      <div style="background:#fff;padding:28px;border-top:3px solid var(--gold)"><div style="font-family:var(--serif);font-size:36px;color:var(--gold);font-weight:600">1</div><h4 style="font-family:var(--serif);font-size:18px;color:var(--navy);margin:8px 0">Fase di studio</h4><p style="font-size:13.5px;color:var(--text-muted)">Esame atti, ricerca normativa, definizione strategia.</p></div>
      <div style="background:#fff;padding:28px;border-top:3px solid var(--gold)"><div style="font-family:var(--serif);font-size:36px;color:var(--gold);font-weight:600">2</div><h4 style="font-family:var(--serif);font-size:18px;color:var(--navy);margin:8px 0">Fase introduttiva</h4><p style="font-size:13.5px;color:var(--text-muted)">Atto introduttivo, notifica, iscrizione a ruolo.</p></div>
      <div style="background:#fff;padding:28px;border-top:3px solid var(--gold)"><div style="font-family:var(--serif);font-size:36px;color:var(--gold);font-weight:600">3</div><h4 style="font-family:var(--serif);font-size:18px;color:var(--navy);margin:8px 0">Fase istruttoria</h4><p style="font-size:13.5px;color:var(--text-muted)">Memorie, prove, CTU, udienze.</p></div>
      <div style="background:#fff;padding:28px;border-top:3px solid var(--gold)"><div style="font-family:var(--serif);font-size:36px;color:var(--gold);font-weight:600">4</div><h4 style="font-family:var(--serif);font-size:18px;color:var(--navy);margin:8px 0">Fase decisoria</h4><p style="font-size:13.5px;color:var(--text-muted)">Conclusionali, repliche, discussione, sentenza.</p></div>
    </div>
    <p style="text-align:center;margin-top:30px;font-size:14px;color:var(--text-muted)">Vuoi una stima orientativa? Usa i nostri <a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/'); ?>" style="color:var(--gold);font-weight:600">calcolatori di parcella civile e penale</a> basati sul DM 55/2014.</p>
  </div>
</section>

<section id="servizi-online" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;padding:70px 0 60px">
  <div class="container">
    <span style="display:inline-block;padding:6px 14px;background:rgba(184,153,104,.18);border:1px solid rgba(184,153,104,.4);border-radius:2px;font-size:11px;letter-spacing:.14em;color:#d4b87f;font-weight:600;text-transform:uppercase;margin-bottom:18px">Catalogo prestazioni · Preventivo a richiesta</span>
    <h2 style="font-family:var(--serif);font-size:42px;font-weight:600;margin:0 0 20px;color:#fff">Servizi legali <em style="font-style:italic;color:#d4b87f">a richiesta online</em></h2>
    <p style="font-size:16px;color:#cbd5e1;max-width:680px;margin:0">Selezioni i servizi di interesse e li aggiunga alla richiesta. Riceverà un <strong style="color:#fff">preventivo scritto personalizzato entro 48 ore</strong>.</p>
  </div>
</section>

<section style="background:#fef9e7;border-bottom:1px solid #f0e9dc;padding:18px 0">
  <div class="container" style="display:flex;align-items:flex-start;gap:14px">
    <svg width="22" height="22" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <div style="font-size:13.5px;color:#78350f;line-height:1.55"><strong>Servizi non vendibili a prezzo fisso indeterminato.</strong> Ex art. 13 L. 247/2012 ogni prestazione richiede preventivo scritto personalizzato.</div>
  </div>
</section>

<section style="background:#fff;border-bottom:1px solid #e5e7eb;padding:22px 0;position:sticky;top:64px;z-index:20">
  <div class="container" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
    <strong style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#64748b;margin-right:10px">Filtra per area:</strong>
    <button class="srv-filter active" data-filter="all">Tutti</button>
    <button class="srv-filter" data-filter="civile">Civile</button>
    <button class="srv-filter" data-filter="penale">Penale</button>
    <button class="srv-filter" data-filter="impresa">Impresa</button>
    <button class="srv-filter" data-filter="famiglia">Famiglia</button>
    <button class="srv-filter" data-filter="contratti">Contratti</button>
    <button class="srv-filter" data-filter="ip">Marchi &amp; IP</button>
    <button class="srv-filter" data-filter="consulenza">Consulenza</button>
  </div>
</section>

<section style="background:#fafaf7;padding:60px 0">
  <div class="container">
    <div class="srv-grid">
      <?php
      $servizi = [
        ['cat'=>'consulenza','sku'=>'cons-videocall','nome'=>'Consulenza in videocall','badge'=>'Consulenza','grad'=>'linear-gradient(135deg,#0f172a,#1e293b)','desc'=>'Colloquio di 30 minuti con l\'avvocato per inquadramento, parere preliminare e piano d\'azione.','feat'=>['Verbalizzazione scritta','Google Meet o Zoom','Documenti preparati']],
        ['cat'=>'consulenza','sku'=>'cons-studio','nome'=>'Consulenza in studio','badge'=>'Consulenza','grad'=>'linear-gradient(135deg,#0f172a,#1e293b)','desc'=>'Incontro di 60 minuti presso lo studio di Barletta. Analisi approfondita, strategia.','feat'=>['Sede: Viale Falcone 75','Accesso disabili','Art. 28 c.d.f. segreto']],
        ['cat'=>'consulenza','sku'=>'cons-parere','nome'=>'Parere legale scritto','badge'=>'Consulenza','grad'=>'linear-gradient(135deg,#0f172a,#1e293b)','desc'=>'Parere motivato con norme, giurisprudenza aggiornata, conclusioni operative.','feat'=>['Citazioni complete','Massime giurisprudenziali','PDF firmato']],
        ['cat'=>'civile','sku'=>'civ-diffida','nome'=>'Diffida / Messa in mora','badge'=>'Civile','grad'=>'linear-gradient(135deg,#7c2d12,#9a3412)','desc'=>'Lettera ex art. 1219 c.c. per interrompere prescrizione o intimare adempimento.','feat'=>['Invio PEC','Prova di consegna','Effetto interruttivo']],
        ['cat'=>'civile','sku'=>'civ-recupero','nome'=>'Recupero crediti','badge'=>'Civile','grad'=>'linear-gradient(135deg,#7c2d12,#9a3412)','desc'=>'Iter completo: diffida, decreto ingiuntivo ex art. 633 c.p.c., precetto, pignoramento.','feat'=>['Visura camerale','Interessi legali e moratori','Anticipazione spese']],
        ['cat'=>'civile','sku'=>'civ-risarcimento','nome'=>'Risarcimento danni sinistro','badge'=>'Civile','grad'=>'linear-gradient(135deg,#7c2d12,#9a3412)','desc'=>'Pratica danni stradali: trattativa assicurazione, eventuale azione giudiziaria.','feat'=>['Patrocinio medico-legale','Calcolo punto IP','Anticipazione CTU']],
        ['cat'=>'contratti','sku'=>'con-revisione','nome'=>'Revisione contratto','badge'=>'Contratti','grad'=>'linear-gradient(135deg,#1e3a8a,#1e40af)','desc'=>'Analisi critica: rischi, clausole vessatorie ex art. 1341 c.c., proposte di modifica.','feat'=>['Relazione punto-punto','Track changes','Confronto orale']],
        ['cat'=>'contratti','sku'=>'con-redazione','nome'=>'Redazione contratto','badge'=>'Contratti','grad'=>'linear-gradient(135deg,#1e3a8a,#1e40af)','desc'=>'Contratto personalizzato: compravendita, locazione, opera, NDA, distribuzione.','feat'=>['Brief esigenze','Prima bozza 7 giorni','Revisione finale']],
        ['cat'=>'contratti','sku'=>'con-disdetta','nome'=>'Disdetta locazione','badge'=>'Contratti','grad'=>'linear-gradient(135deg,#1e3a8a,#1e40af)','desc'=>'Lettera disdetta L. 431/1998 o L. 392/1978 nel rispetto dei termini.','feat'=>['Verifica preavviso','Data cessazione','Cause legittime']],
        ['cat'=>'impresa','sku'=>'imp-costituzione','nome'=>'Costituzione società/ETS','badge'=>'Impresa','grad'=>'linear-gradient(135deg,#064e3b,#065f46)','desc'=>'Costituzione SRL, SAS, associazione, fondazione, ETS. Statuto, RUNTS.','feat'=>['Statuto su misura','Coordinamento notaio','Iscrizione RUNTS']],
        ['cat'=>'impresa','sku'=>'imp-noprofit','nome'=>'Consulenza Terzo Settore','badge'=>'Impresa','grad'=>'linear-gradient(135deg,#064e3b,#065f46)','desc'=>'Adempimenti CTS D.Lgs. 117/2017: RUNTS, ODV/APS, 5x1000.','feat'=>['Specializzazione No Profit','Coordinamento commercialista','Modulistica']],
        ['cat'=>'ip','sku'=>'ip-marchio-it','nome'=>'Marchio italiano UIBM','badge'=>'Marchi &amp; IP','grad'=>'linear-gradient(135deg,#581c87,#6b21a8)','desc'=>'Deposito marchio nazionale UIBM: anteriorità, Nizza, monitoraggio.','feat'=>['Ricerca anteriorità','Classi Nizza fino a 3','Tutela 10 anni rinnovabile']],
        ['cat'=>'ip','sku'=>'ip-marchio-eu','nome'=>'Marchio UE (EUIPO)','badge'=>'Marchi &amp; IP','grad'=>'linear-gradient(135deg,#581c87,#6b21a8)','desc'=>'Marchio UE con effetto in 27 Stati membri. Deposito EUIPO, opposizioni.','feat'=>['Tutela in 27 Paesi UE','Procedura telematica','Esperienza diretta EUIPO']],
        ['cat'=>'famiglia','sku'=>'fam-separazione','nome'=>'Separazione consensuale','badge'=>'Famiglia','grad'=>'linear-gradient(135deg,#9d174d,#be185d)','desc'=>'Separazione consensuale art. 711 c.p.c. o negoziazione assistita DL 132/2014.','feat'=>['Negoziazione o ricorso','Tutela bigenitorialità','Verifica Procura Minori']],
        ['cat'=>'famiglia','sku'=>'fam-successione','nome'=>'Pratica successoria','badge'=>'Famiglia','grad'=>'linear-gradient(135deg,#9d174d,#be185d)','desc'=>'Dichiarazione successione, divisione ereditaria, azione di riduzione.','feat'=>['Voltura catastale','Coordinamento Agenzia Entrate','Contenziosi eredi']],
        ['cat'=>'penale','sku'=>'pen-querela','nome'=>'Querela / Denuncia','badge'=>'Penale','grad'=>'linear-gradient(135deg,#7f1d1d,#991b1b)','desc'=>'Redazione querela ex art. 336 c.p.p., denuncia per reati procedibili d\'ufficio.','feat'=>['Termini 3 mesi','Costituzione parte civile','Difesa procedimento']],
        ['cat'=>'penale','sku'=>'pen-urgenza','nome'=>'Penale d\'urgenza H24','badge'=>'Penale','grad'=>'linear-gradient(135deg,#7f1d1d,#991b1b)','desc'=>'Reperibilità 24h per arresti, fermi, perquisizioni, sequestri. Foro di Trani.','feat'=>['<strong style="color:#dc2626">Cell: 392 970 3202</strong>','Intervento entro 1 ora','Prima consulenza gratuita']],
      ];
      foreach ($servizi as $s):
      ?>
      <article class="srv-card" data-cat="<?php echo esc_attr($s['cat']); ?>" data-sku="<?php echo esc_attr($s['sku']); ?>" data-name="<?php echo esc_attr($s['nome']); ?>">
        <div class="srv-icon" style="background:<?php echo esc_attr($s['grad']); ?>"></div>
        <span class="srv-badge"><?php echo $s['badge']; ?></span>
        <h3><?php echo esc_html($s['nome']); ?></h3>
        <p><?php echo esc_html($s['desc']); ?></p>
        <ul class="srv-feat"><?php foreach ($s['feat'] as $f): ?><li><?php echo wp_kses_post($f); ?></li><?php endforeach; ?></ul>
        <button class="btn srv-add" type="button">Aggiungi alla richiesta</button>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div id="srvCartWidget" class="cart-widget" style="display:none">
  <div class="cart-widget-head"><strong>Richiesta in preparazione</strong><button id="cwClose" aria-label="Chiudi">&times;</button></div>
  <ul id="cwList"></ul>
  <a href="<?php echo esc_url(home_url('/carrello/')); ?>" class="btn btn-primary cart-widget-cta">Procedi alla richiesta →</a>
</div>

<section class="block">
  <div class="container" style="max-width:880px">
    <div class="section-title"><div class="divider-dot"></div><div class="section-eyebrow">Trasparenza</div><h2>Quattro impegni di chiarezza</h2></div>
    <div class="faq">
      <div class="faq-item"><div class="faq-q">Preventivo scritto sin dal primo incontro</div><div class="faq-a">Art. 13 L. 247/2012: prima dell'accettazione del mandato consegniamo un preventivo scritto con voci di compenso, spese di domiciliazione, anticipazioni e oneri tributari.</div></div>
      <div class="faq-item"><div class="faq-q">Niente patti di quota lite</div><div class="faq-a">Lo Studio non applica patti che leghino l'onorario al risultato (art. 25 c.d.f.).</div></div>
      <div class="faq-item"><div class="faq-q">Onorari fissi o orari, mai a sorpresa</div><div class="faq-a">Onorari fissi (attività ben definite) o tariffe orarie. Le ore vengono rendicontate periodicamente.</div></div>
      <div class="faq-item"><div class="faq-q">Ricevuta e fattura elettronica</div><div class="faq-a">Tutti i pagamenti sono fatturati elettronicamente. Rateizzazione per pratiche lunghe.</div></div>
    </div>
  </div>
</section>

<style>
.srv-filter{padding:8px 14px;border:1px solid #e5e7eb;background:#fff;color:#475569;font-size:13px;font-weight:500;border-radius:20px;cursor:pointer;font-family:inherit}
.srv-filter:hover{border-color:var(--gold);color:var(--navy)}
.srv-filter.active{background:var(--navy);color:#fff;border-color:var(--navy)}
.srv-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:22px}
.srv-card{background:#fff;border:1px solid #e5e7eb;border-radius:6px;padding:26px;display:flex;flex-direction:column;position:relative;transition:all .2s}
.srv-card:hover{border-color:var(--gold);box-shadow:0 12px 28px -16px rgba(15,23,42,.18);transform:translateY(-2px)}
.srv-card.is-added{border-color:var(--gold);background:#fdfbf5}
.srv-icon{width:46px;height:46px;border-radius:6px;margin-bottom:18px}
.srv-badge{position:absolute;top:24px;right:24px;font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);font-weight:700;padding:4px 8px;border:1px solid #f0e9dc;border-radius:2px;background:#faf8f3}
.srv-card h3{font-family:var(--serif);font-size:20px;color:var(--navy);font-weight:600;margin:0 0 10px;line-height:1.25}
.srv-card > p{font-size:14px;line-height:1.55;color:#475569;margin:0 0 16px;flex-grow:1}
.srv-feat{list-style:none;padding:0;margin:0 0 22px;font-size:13px;color:#64748b;display:flex;flex-direction:column;gap:6px}
.srv-feat li{padding-left:18px;position:relative;line-height:1.4}
.srv-feat li::before{content:"✓";position:absolute;left:0;color:var(--gold);font-weight:700}
.srv-add{background:#fff;border:1.5px solid var(--navy);color:var(--navy);font-size:13.5px;font-weight:600;padding:11px 16px;border-radius:3px;cursor:pointer;font-family:inherit;text-align:center;width:100%}
.srv-add:hover{background:var(--navy);color:#fff}
.srv-add.added{background:var(--gold);color:#fff;border-color:var(--gold)}
.cart-widget{position:fixed;bottom:24px;right:24px;width:340px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 20px 48px -16px rgba(15,23,42,.3);padding:18px;z-index:80}
.cart-widget-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #f1f5f9}
.cart-widget-head strong{color:var(--navy);font-size:14px}
#cwClose{background:none;border:0;font-size:22px;color:#94a3b8;cursor:pointer}
#cwList{list-style:none;padding:0;margin:0 0 12px;max-height:200px;overflow-y:auto}
#cwList li{font-size:13px;color:#475569;padding:6px 0;border-bottom:1px solid #f8fafc;display:flex;justify-content:space-between;gap:8px}
#cwList li button{background:none;border:0;color:#dc2626;cursor:pointer;font-size:16px}
.cart-widget-cta{width:100%;text-align:center;display:block}
@media (max-width:600px){.cart-widget{left:16px;right:16px;width:auto;bottom:16px}}
</style>

<script>
(function(){
  const K='lanotte_cart_v1';
  function g(){try{return JSON.parse(localStorage.getItem(K))||[]}catch(e){return[]}}
  function s(a){localStorage.setItem(K,JSON.stringify(a));rc();rw();rs();}
  function add(sku,name){const c=g();if(c.find(i=>i.sku===sku))return;c.push({sku,name,addedAt:Date.now()});s(c);}
  function rem(sku){s(g().filter(i=>i.sku!==sku));}
  function rc(){const n=g().length;document.querySelectorAll('[data-cart-count]').forEach(el=>{el.textContent=n;el.setAttribute('data-cart-count',n);});}
  function rs(){const c=g();document.querySelectorAll('.srv-card').forEach(card=>{const sku=card.dataset.sku,ic=c.some(i=>i.sku===sku);card.classList.toggle('is-added',ic);const b=card.querySelector('.srv-add');if(ic){b.classList.add('added');b.innerHTML='✓ Aggiunto alla richiesta';}else{b.classList.remove('added');b.innerHTML='Aggiungi alla richiesta';}});}
  function rw(){const w=document.getElementById('srvCartWidget');if(!w)return;const c=g(),l=document.getElementById('cwList');if(c.length===0){w.style.display='none';return;}w.style.display='block';l.innerHTML=c.map(i=>`<li><span>${i.name}</span><button data-rm="${i.sku}">×</button></li>`).join('');l.querySelectorAll('button[data-rm]').forEach(b=>b.onclick=()=>rem(b.dataset.rm));}
  document.querySelectorAll('.srv-filter').forEach(b=>b.addEventListener('click',()=>{document.querySelectorAll('.srv-filter').forEach(x=>x.classList.remove('active'));b.classList.add('active');const f=b.dataset.filter;document.querySelectorAll('.srv-card').forEach(c=>{c.style.display=(f==='all'||c.dataset.cat===f)?'flex':'none';});}));
  document.querySelectorAll('.srv-card').forEach(card=>card.querySelector('.srv-add').addEventListener('click',()=>{const sku=card.dataset.sku,nm=card.dataset.name;if(g().some(i=>i.sku===sku))rem(sku);else add(sku,nm);}));
  const cw=document.getElementById('cwClose');if(cw)cw.onclick=()=>{document.getElementById('srvCartWidget').style.display='none';};
  rc();rw();rs();
})();
</script>

<?php get_footer();
