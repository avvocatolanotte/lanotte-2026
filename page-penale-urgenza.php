<?php
/**
 * Template Name: Penale d'Urgenza H24
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$hero_bg = LANOTTE_THEME_URI . '/assets/img/trani/palazzo-tribunale.jpg';
$phone_studio_raw = lanotte_phone(true);
$phone_studio     = lanotte_phone();
$email_studio     = lanotte_email();
$wa_url           = lanotte_whatsapp_url();
// Numero cellulare urgenze 24/7 (cellulare dell'Avv. LANOTTE, solo chiamate: lanotte_cellulare())
$phone_urgenza_raw = lanotte_cellulare(true);
$phone_urgenza     = lanotte_cellulare();
?>

<!-- Schema.org EmergencyService -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LegalService",
  "name": "Studio Legale LANOTTE & Partners — Difesa penale d'urgenza",
  "description": "Linea telefonica per le urgenze penali (arresti, fermi, perquisizioni, sequestri). Foro di Trani e distretto della Corte d'appello di Bari.",
  "telephone": "<?php echo esc_js($phone_urgenza_raw); ?>",
  "availableLanguage": ["it", "en"],
  "areaServed": {
    "@type": "AdministrativeArea",
    "name": "Foro di Trani — distretto della Corte d'appello di Bari"
  }
}
</script>

<section class="hero-internal" style="background-image:linear-gradient(135deg,rgba(120,30,30,.95) 0%,rgba(60,15,15,.9) 100%),url('<?php echo esc_url($hero_bg); ?>');background-size:cover;background-position:center;padding:90px 0 60px">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <div class="urgenza-badge">Linea per le urgenze penali</div>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,48px);line-height:1.15;margin:8px 0 14px">Difesa penale d'urgenza<br>per arresti, fermi, perquisizioni.</h1>
    <p class="subtitle" style="color:#fee2e2;max-width:760px">In caso di arresto, fermo, perquisizione o sequestro può chiamare il cellulare dello Studio dedicato alle urgenze penali: risponderemo appena possibile, compatibilmente con udienze e impegni, per un primo orientamento e, se lo desidera, per la nomina del difensore di fiducia.</p>
  </div>
</section>

<!-- BARRA CONTATTO IMMEDIATO -->
<section class="urgenza-bar">
  <div class="container urgenza-bar-grid">
    <div>
      <div class="urgenza-label">URGENZE PENALI · CELLULARE</div>
      <a href="tel:<?php echo esc_attr($phone_urgenza_raw); ?>" class="urgenza-tel-big"><?php echo esc_html($phone_urgenza); ?></a>
      <div class="urgenza-sub">Solo chiamate · risposta appena possibile, compatibilmente con udienze e impegni</div>
      <div class="urgenza-label" style="margin-top:6px">STUDIO · ORARIO UFFICIO</div>
      <a href="tel:<?php echo esc_attr($phone_studio_raw); ?>" class="urgenza-tel-sm"><?php echo esc_html($phone_studio); ?></a>
    </div>
    <div class="urgenza-cta-col">
      <a href="tel:<?php echo esc_attr($phone_urgenza_raw); ?>" class="urgenza-cta urgenza-cta-call">📞 Chiami il cellulare urgenze</a>
      <?php /* 27/09/2026 — regola dell'Avvocato: il cellulare solo per le CHIAMATE urgenti, ogni WhatsApp al fisso.
         Il WhatsApp del fisso è letto dal presidio ogni 6 ore (la corsa delle 02 è muta): non è un canale
         d'urgenza e non va presentato come tale. L'urgenza passa dalla chiamata qui sopra. */ ?>
      <a href="<?php echo esc_url($wa_url . '?text=Buongiorno%2C%20scrivo%20dalla%20pagina%20Penale%20d%27urgenza'); ?>" class="urgenza-cta urgenza-cta-wa">💬 WhatsApp dello Studio (non urgente)</a>
    </div>
  </div>
</section>

<!-- COSA FARE SUBITO -->
<section class="block">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Le prime 48 ore</div>
      <h2>Cosa fare in caso di emergenza penale</h2>
      <p>Tre indicazioni utili.</p>
    </div>
    <div class="urgenza-rules-grid">
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">01</div>
        <h3>La facoltà di non rispondere</h3>
        <p>Prima dell'interrogatorio la persona sottoposta alle indagini deve essere avvertita che ha <strong>facoltà di non rispondere</strong> ad alcuna domanda, salvo l'obbligo di fornire le proprie generalità (art. 64 c.p.p.). Ogni dichiarazione è opportuno valutarla con il difensore.</p>
      </div>
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">02</div>
        <h3>Il difensore di fiducia</h3>
        <p>Ha diritto di nominare un <strong>difensore di fiducia</strong> (art. 96 c.p.p.); in mancanza, la difesa è assicurata dal difensore d'ufficio, che cessa dalle funzioni con la nomina del difensore di fiducia (art. 97 c.p.p.). Per chi è fermato o arrestato la nomina può essere fatta da un prossimo congiunto.</p>
      </div>
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">03</div>
        <h3>Prima di firmare, leggere</h3>
        <p>Verbali e dichiarazioni vanno letti con attenzione prima della sottoscrizione; quando possibile, è opportuno valutarli con il difensore.</p>
      </div>
    </div>
  </div>
</section>

<!-- CASI TIPICI -->
<section class="block" style="background:var(--cream)">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Situazioni urgenti</div>
      <h2>Quando chiamare il cellulare urgenze</h2>
    </div>
    <div class="urgenza-casi-grid">
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🚨</div>
        <div>
          <h4>Arresto in flagranza</h4>
          <p>Il pubblico ministero chiede la convalida entro 48 ore e il giudice fissa l'udienza entro le 48 ore successive, dandone avviso al difensore (art. 390 c.p.p.).</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🛑</div>
        <div>
          <h4>Fermo di indiziato di delitto</h4>
          <p>Misura precautelare disposta dal pubblico ministero o, nei casi previsti, dalla polizia giudiziaria (art. 384 c.p.p.); nell'udienza di convalida il difensore può contestarne i presupposti.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🔍</div>
        <div>
          <h4>Perquisizione domiciliare o personale</h4>
          <p>La polizia giudiziaria deve avvertire la persona sottoposta alle indagini, se presente, della facoltà di farsi assistere dal difensore di fiducia (art. 114 disp. att. c.p.p.). Il verbale va letto con attenzione.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">📋</div>
        <div>
          <h4>Sequestro probatorio o preventivo</h4>
          <p>La richiesta di riesame si propone entro 10 giorni dall'esecuzione o dalla conoscenza del sequestro (art. 324 c.p.p.); si può chiedere anche la restituzione dei beni.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🚔</div>
        <div>
          <h4>Incidente con omicidio o lesioni stradali</h4>
          <p>Sono reati gravi, che richiedono assistenza sia per la difesa penale sia per gli aspetti risarcitori.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">⚖️</div>
        <div>
          <h4>Informazione di garanzia</h4>
          <p>Il pubblico ministero la notifica quando deve compiere un atto al quale il difensore ha diritto di assistere; contiene l'invito a nominare un difensore di fiducia (art. 369 c.p.p.). Di regola non richiede un intervento immediato: conviene valutare con il difensore atti e termini.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECONDO RICHIAMO CONTATTO -->
<section class="urgenza-cta-strip">
  <div class="container" style="text-align:center;max-width:780px;margin:0 auto">
    <h2>Come contattare lo Studio</h2>
    <p>Per le urgenze penali chiami il cellulare dedicato. Per tutte le altre comunicazioni sono a disposizione il telefono dello Studio in orario d'ufficio e il WhatsApp del fisso.</p>
    <div class="urgenza-cta-strip-row">
      <a href="tel:<?php echo esc_attr($phone_urgenza_raw); ?>" class="btn btn-gold">📞 Urgenze: <?php echo esc_html($phone_urgenza); ?></a>
      <a href="<?php echo esc_url($wa_url); ?>?text=Buongiorno%2C%20scrivo%20dalla%20pagina%20Penale%20d%27urgenza" class="btn btn-ghost">💬 WhatsApp dello Studio (non urgente)</a>
    </div>
    <p class="urgenza-cta-strip-note">Il cellulare urgenze risponde appena possibile, compatibilmente con udienze e impegni.</p>
  </div>
</section>

<!-- PROCEDURA SE TI CHIAMANO -->
<section class="block">
  <div class="container" style="max-width:880px">
    <div class="section-title left" style="margin-bottom:32px">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Come lavoriamo nelle emergenze</div>
      <h2>Che cosa succede dopo la chiamata</h2>
    </div>
    <div class="urgenza-timeline">
      <div class="urgenza-step">
        <div class="urgenza-step-num">1</div>
        <h4>Primo colloquio telefonico</h4>
        <p>Raccogliamo i dati essenziali: che cosa è accaduto, dove si trova la persona interessata, di quale reato si parla. Valutiamo se occorre intervenire subito o se il caso può essere gestito nei giorni successivi.</p>
      </div>
      <div class="urgenza-step">
        <div class="urgenza-step-num">2</div>
        <h4>Nomina di fiducia e accesso agli atti</h4>
        <p>Se ci viene conferito l'incarico, la nomina è comunicata all'autorità procedente e chiediamo gli atti che il difensore può consultare.</p>
      </div>
      <div class="urgenza-step">
        <div class="urgenza-step-num">3</div>
        <h4>Presenza all'interrogatorio</h4>
        <p>Il difensore partecipa agli atti e alle udienze per cui è previsto (interrogatorio, udienza di convalida), presso l'ufficio giudiziario o l'istituto penitenziario, e concorda con l'assistito la linea difensiva.</p>
      </div>
      <div class="urgenza-step" style="margin-bottom:0">
        <div class="urgenza-step-num">4</div>
        <h4>Strategia post-urgenza</h4>
        <p>Superata la fase urgente, si valutano con l'assistito le iniziative possibili: impugnazione delle misure cautelari, richieste di misure meno gravose, riti speciali (patteggiamento, abbreviato), istanze al GIP.</p>
      </div>
    </div>
  </div>
</section>

<!-- FAQ URGENZA -->
<section class="block" style="background:var(--cream)">
  <div class="container" style="max-width:880px">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">FAQ Urgenze</div>
      <h2>Domande frequenti</h2>
    </div>
    <div class="faq">
      <div class="faq-item">
        <div class="faq-q">Quanto costa l'intervento d'urgenza?</div>
        <div class="faq-a">Il primo contatto telefonico serve a inquadrare la situazione e a valutare l'urgenza. Se si conferisce mandato, viene consegnato un <strong>preventivo scritto</strong> sin dal primo incontro, ai sensi dell'art. 13, comma 5, L. 247/2012, con indicazione di onorari, spese e oneri tributari secondo i parametri del DM 55/2014.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Posso cambiare il difensore d'ufficio già assegnato?</div>
        <div class="faq-a">Sì. Con la nomina di un difensore di fiducia il difensore d'ufficio cessa dalle sue funzioni (art. 97, comma 6, c.p.p.). Le indichiamo come sottoscrivere la nomina.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Mio figlio/familiare è stato arrestato. Posso chiamarvi io?</div>
        <div class="faq-a">Sì. Finché la persona fermata, arrestata o in custodia cautelare non vi ha provveduto, la nomina del difensore di fiducia può essere fatta da un prossimo congiunto (art. 96, comma 3, c.p.p.). Le indichiamo i passaggi formali.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">In che Tribunali siete attivi?</div>
        <div class="faq-a">Operiamo presso il <strong>Tribunale di Trani</strong>, il <strong>Tribunale di Bari</strong> per il riesame delle misure cautelari personali (art. 309, comma 7, c.p.p.), il <strong>Tribunale di sorveglianza di Bari</strong> e la <strong>Corte d'Appello di Bari</strong>. Per gli altri Fori e per la <strong>Cassazione</strong> ci avvaliamo di colleghi corrispondenti.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Se non rispondete subito al telefono?</div>
        <div class="faq-a">Il numero <strong><?php echo esc_html($phone_urgenza); ?></strong> è il cellulare dedicato alle urgenze penali. Se la chiamata non viene presa, <strong>richiami dopo qualche minuto</strong>: sarà ricontattato appena possibile, compatibilmente con udienze e impegni. Il WhatsApp dello Studio, <a href="<?php echo esc_url($wa_url); ?>" style="color:var(--gold)"><?php echo esc_html(lanotte_phone()); ?></a>, è per le comunicazioni che non hanno carattere d'urgenza.</div>
      </div>
    </div>
  </div>
</section>

<style>
/* === BADGE EMERGENZA === */
.urgenza-badge{display:inline-block;background:#dc2626;color:#fff;padding:6px 14px;font-size:11px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;margin-bottom:18px}

/* === BARRA CONTATTO IMMEDIATO === */
.urgenza-bar{background:#dc2626;color:#fff;padding:32px 0;border-bottom:3px solid #991b1b}
.urgenza-bar-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:center}
.urgenza-label{font-size:13px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;margin-bottom:8px;color:#fecaca}
.urgenza-tel-big{font-family:var(--serif);font-size:42px;font-weight:600;color:#fff;text-decoration:none;display:block;line-height:1;margin-bottom:4px}
.urgenza-sub{font-size:13px;color:#fee2e2;margin-bottom:14px}
.urgenza-tel-sm{font-family:var(--serif);font-size:22px;color:#fff;text-decoration:none;line-height:1}
.urgenza-cta-col{display:flex;flex-direction:column;gap:12px}
.urgenza-cta{padding:18px;text-align:center;font-weight:700;letter-spacing:.04em;text-transform:uppercase;font-size:15px;border-radius:2px;text-decoration:none;display:block}
.urgenza-cta-call{background:#fff;color:#dc2626}
.urgenza-cta-wa{background:#25d366;color:#fff}

/* === COSA FARE: 3 REGOLE === */
.urgenza-rules-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:32px}
.urgenza-rule{background:#fff;border:1px solid var(--border);padding:32px;border-top:4px solid #dc2626}
.urgenza-rule-num{font-family:var(--serif);font-size:48px;color:#dc2626;font-weight:600;line-height:1;margin-bottom:12px}
.urgenza-rule h3{font-family:var(--serif);font-size:22px;color:var(--navy);margin-bottom:14px}
.urgenza-rule p{font-size:15px;color:var(--text);line-height:1.65}

/* === CASI === */
.urgenza-casi-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;max-width:980px;margin:32px auto 0}
.urgenza-caso{background:#fff;padding:24px;display:flex;gap:18px;align-items:flex-start;border-left:3px solid #dc2626}
.urgenza-caso-icon{font-size:32px;line-height:1;flex-shrink:0}
.urgenza-caso h4{font-family:var(--serif);font-size:19px;color:var(--navy);margin-bottom:6px}
.urgenza-caso p{font-size:14px;color:var(--text-muted);line-height:1.5}

/* === STRIP CTA SCURA === */
.urgenza-cta-strip{background:linear-gradient(135deg,#0E1A33,#1a2a4a);color:#fff;padding:64px 0}
.urgenza-cta-strip h2{font-family:var(--serif);font-size:clamp(26px,4vw,36px);font-weight:600;line-height:1.2;margin-bottom:16px;color:#fff}
.urgenza-cta-strip p{font-size:18px;color:#cbd5e1;margin-bottom:32px;line-height:1.6}
.urgenza-cta-strip-row{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-bottom:32px}
.urgenza-cta-strip-row .btn{font-size:16px;padding:18px 32px}
.urgenza-cta-strip-note{font-size:13px;color:#94a3b8;font-style:italic}

/* === TIMELINE === */
.urgenza-timeline{position:relative;padding-left:32px;border-left:2px solid var(--gold)}
.urgenza-step{margin-bottom:32px;position:relative}
.urgenza-step-num{position:absolute;left:-44px;width:24px;height:24px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px}
.urgenza-step h4{font-family:var(--serif);font-size:20px;color:var(--navy);margin-bottom:6px}
.urgenza-step p{color:var(--text-muted);line-height:1.65}

/* === MOBILE === */
@media (max-width:900px){
  .urgenza-bar-grid{grid-template-columns:1fr;gap:22px}
  .urgenza-rules-grid{grid-template-columns:1fr;gap:16px}
  .urgenza-casi-grid{grid-template-columns:1fr;gap:14px}
}
@media (max-width:680px){
  .urgenza-tel-big{font-size:clamp(28px,8vw,38px)}
  .urgenza-tel-sm{font-size:18px}
  .urgenza-bar{padding:24px 0}
  .urgenza-rule{padding:24px 20px}
  .urgenza-rule-num{font-size:38px}
  .urgenza-rule h3{font-size:19px}
  .urgenza-caso{padding:18px;gap:14px}
  .urgenza-caso-icon{font-size:26px}
  .urgenza-caso h4{font-size:17px}
  .urgenza-cta-strip{padding:48px 0}
  .urgenza-cta-strip p{font-size:16px}
  .urgenza-cta-strip-row .btn{width:100%;padding:16px 20px;font-size:15px}
  .urgenza-cta-call,.urgenza-cta-wa{width:100%;font-size:14px;padding:16px}
  .urgenza-timeline{padding-left:24px}
  .urgenza-step-num{left:-36px}
}
</style>

<?php endwhile; get_footer();
