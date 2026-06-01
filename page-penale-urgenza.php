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
// Numero cellulare urgenze 24/7 (cellulare dedicato Avv. Lanotte)
$phone_urgenza_raw = '+393929703202';
$phone_urgenza     = '+39 392 970 3202';
?>

<!-- Schema.org EmergencyService -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EmergencyService",
  "name": "Studio Legale Lanotte & Partners — Difesa penale d'urgenza H24",
  "description": "Reperibilità 24/7 per arresti, fermi, perquisizioni, sequestri. Difesa penale d'urgenza in tutta la BAT e Foro di Trani.",
  "telephone": "<?php echo esc_js($phone_urgenza_raw); ?>",
  "availableLanguage": ["it", "en"],
  "areaServed": {
    "@type": "AdministrativeArea",
    "name": "Foro di Trani — BAT, Bari, Puglia"
  },
  "hoursAvailable": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
    "opens": "00:00",
    "closes": "23:59"
  }
}
</script>

<section class="hero-internal" style="background-image:linear-gradient(135deg,rgba(120,30,30,.95) 0%,rgba(60,15,15,.9) 100%),url('<?php echo esc_url($hero_bg); ?>');background-size:cover;background-position:center;padding:90px 0 60px">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <div class="urgenza-badge">⚡ Reperibilità H24 · 7 giorni su 7</div>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,48px);line-height:1.15;margin:8px 0 14px">Difesa penale d'urgenza<br>per arresti, fermi, perquisizioni.</h1>
    <p class="subtitle" style="color:#fee2e2;max-width:760px">Le prime 48 ore di un procedimento penale possono determinare l'esito di tutto il giudizio. Chiama subito uno dei nostri legali per un primo orientamento e — ove possibile — l'intervento tempestivo del difensore di fiducia.</p>
  </div>
</section>

<!-- BARRA CONTATTO IMMEDIATO -->
<section class="urgenza-bar">
  <div class="container urgenza-bar-grid">
    <div>
      <div class="urgenza-label">REPERIBILITÀ PENALE 24/7</div>
      <a href="tel:<?php echo esc_attr($phone_urgenza_raw); ?>" class="urgenza-tel-big"><?php echo esc_html($phone_urgenza); ?></a>
      <div class="urgenza-sub">Cellulare dedicato urgenze · giorno e notte</div>
      <div class="urgenza-label" style="margin-top:6px">STUDIO · ORARIO UFFICIO</div>
      <a href="tel:<?php echo esc_attr($phone_studio_raw); ?>" class="urgenza-tel-sm"><?php echo esc_html($phone_studio); ?></a>
    </div>
    <div class="urgenza-cta-col">
      <a href="tel:<?php echo esc_attr($phone_urgenza_raw); ?>" class="urgenza-cta urgenza-cta-call">📞 Reperibilità urgenze 24/7</a>
      <a href="https://wa.me/<?php echo esc_attr(ltrim($phone_urgenza_raw, '+')); ?>?text=URGENZA%20PENALE%20-%20ho%20bisogno%20di%20assistenza%20immediata" class="urgenza-cta urgenza-cta-wa">💬 WhatsApp urgenze</a>
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
      <p>Tre regole essenziali da seguire prima di qualsiasi altra cosa.</p>
    </div>
    <div class="urgenza-rules-grid">
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">01</div>
        <h3>Esercita il diritto al silenzio</h3>
        <p>Hai il diritto di non rispondere alle domande della Polizia Giudiziaria finché non parli con un avvocato. Comunicare di propria iniziativa <strong>solo dati anagrafici</strong>. Tutto il resto va valutato con il difensore.</p>
      </div>
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">02</div>
        <h3>Nomina un difensore di fiducia</h3>
        <p>Il difensore d'ufficio non è sempre la scelta migliore: viene assegnato dal sistema e non conosce la tua situazione. Hai diritto a nominare <strong>il tuo avvocato di fiducia</strong> in qualunque momento.</p>
      </div>
      <div class="urgenza-rule">
        <div class="urgenza-rule-num">03</div>
        <h3>Non firmare nulla senza l'avvocato</h3>
        <p>Verbali, dichiarazioni, atti di consenso: tutto va letto e valutato dal difensore prima della firma. Una firma data sotto pressione può <strong>condizionare l'esito del procedimento</strong>.</p>
      </div>
    </div>
  </div>
</section>

<!-- CASI TIPICI -->
<section class="block" style="background:var(--cream)">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Casi che gestiamo H24</div>
      <h2>Quando chiamare subito</h2>
    </div>
    <div class="urgenza-casi-grid">
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🚨</div>
        <div>
          <h4>Arresto in flagranza</h4>
          <p>Convalida dell'arresto entro 96 ore. È fondamentale che il difensore sia presente all'interrogatorio di garanzia.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🛑</div>
        <div>
          <h4>Fermo di Polizia Giudiziaria</h4>
          <p>Misura pre-cautelare: il difensore può intervenire immediatamente e contestare il fermo se non sussistono i presupposti.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🔍</div>
        <div>
          <h4>Perquisizione domiciliare o personale</h4>
          <p>Hai diritto a farti assistere dal difensore. Le irregolarità nel verbale possono portare a inutilizzabilità delle prove raccolte.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">📋</div>
        <div>
          <h4>Sequestro probatorio o preventivo</h4>
          <p>Riesame entro 10 giorni. Il difensore può chiedere il dissequestro o la restituzione dei beni.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">🚔</div>
        <div>
          <h4>Incidente con omicidio o lesioni stradali</h4>
          <p>Reato grave: serve assistenza immediata sia per la difesa penale che per il risarcimento alla parte offesa.</p>
        </div>
      </div>
      <div class="urgenza-caso">
        <div class="urgenza-caso-icon">⚖️</div>
        <div>
          <h4>Notifica di avviso di garanzia</h4>
          <p>Anche senza arresto, ricevere un avviso significa essere iscritti nel registro indagati. Agire subito può evitare misure cautelari.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECONDO RICHIAMO CONTATTO -->
<section class="urgenza-cta-strip">
  <div class="container" style="text-align:center;max-width:780px;margin:0 auto">
    <h2>Ogni minuto conta.</h2>
    <p>Non aspettare di "vedere come si mette". Le scelte processuali fatte nelle prime ore — silenzio, nomina difensore, modalità di interrogatorio — determinano spesso l'esito finale del procedimento.</p>
    <div class="urgenza-cta-strip-row">
      <a href="tel:<?php echo esc_attr($phone_studio_raw); ?>" class="btn btn-gold">📞 Chiama <?php echo esc_html($phone_studio); ?></a>
      <a href="<?php echo esc_url($wa_url); ?>?text=URGENZA%20PENALE" class="btn btn-ghost">💬 WhatsApp</a>
    </div>
    <p class="urgenza-cta-strip-note">Reperibilità anche fuori orario di studio · Risposta tempestiva per casi d'urgenza</p>
  </div>
</section>

<!-- PROCEDURA SE TI CHIAMANO -->
<section class="block">
  <div class="container" style="max-width:880px">
    <div class="section-title left" style="margin-bottom:32px">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Come lavoriamo nelle emergenze</div>
      <h2>Cosa succede dopo che ci chiami</h2>
    </div>
    <div class="urgenza-timeline">
      <div class="urgenza-step">
        <div class="urgenza-step-num">1</div>
        <h4>Triage telefonico immediato</h4>
        <p>In 5-10 minuti raccogliamo i dati essenziali: cosa è successo, dove ti trovi, chi ti sta interrogando, di quale reato si parla. Valutiamo se c'è urgenza assoluta o se è un caso da gestire l'indomani.</p>
      </div>
      <div class="urgenza-step">
        <div class="urgenza-step-num">2</div>
        <h4>Nomina di fiducia e accesso agli atti</h4>
        <p>Inviamo la nomina di fiducia agli organi competenti (Polizia, Procura, Casa Circondariale). Otteniamo accesso agli atti d'indagine disponibili al difensore.</p>
      </div>
      <div class="urgenza-step">
        <div class="urgenza-step-num">3</div>
        <h4>Presenza all'interrogatorio</h4>
        <p>Ti raggiungiamo presso la sede dell'audizione o dell'interrogatorio di garanzia (Tribunale di Trani o Casa Circondariale). Concordiamo insieme strategia difensiva e domande a cui rispondere.</p>
      </div>
      <div class="urgenza-step" style="margin-bottom:0">
        <div class="urgenza-step-num">4</div>
        <h4>Strategia post-urgenza</h4>
        <p>Superata la fase d'urgenza, definiamo strategia complessiva: opposizione a misure cautelari, richieste alternative (domiciliari, obbligo di firma), riti speciali (patteggiamento, abbreviato), istanze al GIP.</p>
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
        <div class="faq-a">Il primo contatto telefonico serve a inquadrare la situazione e a valutare l'urgenza. Se si conferisce mandato, viene consegnato un <strong>preventivo scritto</strong> sin dal primo incontro, ai sensi dell'art. 13 c. 5 L. 247/2012 (modif. da L. 124/2017), con indicazione di onorari, spese e oneri tributari secondo i parametri del DM 55/2014.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Posso cambiare il difensore d'ufficio già assegnato?</div>
        <div class="faq-a">Sì, in qualunque momento. La revoca del difensore d'ufficio e la nomina del difensore di fiducia sono atti immediati. Basta firmare l'atto di nomina che ti porteremo noi.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Mio figlio/familiare è stato arrestato. Posso chiamarvi io?</div>
        <div class="faq-a">Assolutamente sì. La nomina del difensore di fiducia può essere fatta da un familiare prossimo, dal coniuge o dal convivente. Vi indichiamo i passaggi formali da fare per ottenere subito l'incarico.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">In che Tribunali siete attivi?</div>
        <div class="faq-a">Operiamo presso il <strong>Tribunale di Trani</strong> (sezioni penale, riesame, sorveglianza) e la <strong>Corte d'Appello di Bari</strong>. Per gli altri Fori e per la <strong>Cassazione</strong> ci avvaliamo di corrispondenti qualificati.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">Se non rispondete subito al telefono?</div>
        <div class="faq-a">Il numero <strong><?php echo esc_html($phone_urgenza); ?></strong> è il cellulare dedicato alle urgenze penali e attivo H24. Se la chiamata non viene presa, invia un <strong>WhatsApp con la parola "URGENZA"</strong> allo stesso numero: <a href="https://wa.me/<?php echo esc_attr(ltrim($phone_urgenza_raw, '+')); ?>" style="color:var(--gold)"><?php echo esc_html($phone_urgenza); ?></a>. Sarai ricontattato il prima possibile.</div>
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
