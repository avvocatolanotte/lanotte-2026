<?php
/**
 * Template Name: Newsletter
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$privacy_url = get_permalink(get_page_by_path('privacy'));
$privacy_url = $privacy_url ?: home_url('/privacy/');
?>

<section class="hero-internal" style="padding:80px 0 60px;color:#fff;background:linear-gradient(135deg,var(--navy),#1a2a4a)">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,48px);line-height:1.15;margin:8px 0 14px">Newsletter dello Studio.<br>Solo cose che servono.</h1>
    <p class="subtitle" style="color:#d4d8e0;max-width:760px">Un'email al mese con le novità giuridiche più rilevanti per imprese, professionisti e privati. Niente spam, niente filler. Disiscrizione in 1 click.</p>
  </div>
</section>

<!-- FORM ISCRIZIONE PROMINENTE -->
<!--
  TODO: il form qui sotto è un mock client-side. Da collegare a:
   - Mailchimp (action="https://<dc>.list-manage.com/subscribe/post?u=...&id=...") oppure
   - Brevo / Sendinblue (https://api.brevo.com/v3/contacts) oppure
   - endpoint custom AJAX (admin-ajax.php / REST route /newsletter/subscribe)
  In ogni caso: confermare double opt-in, registrare il consenso GDPR con timestamp e IP.
-->
<section class="block" style="background:var(--cream)">
  <div class="container" style="max-width:720px">
    <div class="nl-form-card">
      <h2>Iscriviti gratuitamente</h2>
      <p class="nl-form-intro">Ricevi la newsletter mensile dello Studio: novità normative, commenti a sentenze, scadenze fiscali, casi pratici.</p>

      <form id="nl-subscribe-form" action="" method="post" onsubmit="event.preventDefault();alert('Form non ancora collegato — vedi commento nel template.');" class="nl-form">
        <div class="form-row nl-form-row">
          <div class="form-field"><label>Nome</label><input type="text" name="nome" placeholder="Es. Mario" required></div>
          <div class="form-field"><label>Cognome</label><input type="text" name="cognome" placeholder="Es. Rossi" required></div>
        </div>
        <div class="form-field"><label>Email*</label><input type="email" name="email" placeholder="la-tua-email@esempio.it" required></div>

        <div class="form-field nl-form-aree">
          <label class="nl-aree-label">Aree di interesse <span>(opzionale — riceverai contenuti pertinenti)</span></label>
          <div class="nl-aree-grid">
            <label><input type="checkbox" name="aree[]" value="penale"> Diritto Penale</label>
            <label><input type="checkbox" name="aree[]" value="civile"> Diritto Civile</label>
            <label><input type="checkbox" name="aree[]" value="famiglia"> Famiglia e Successioni</label>
            <label><input type="checkbox" name="aree[]" value="lavoro"> Lavoro</label>
            <label><input type="checkbox" name="aree[]" value="impresa"> Impresa</label>
            <label><input type="checkbox" name="aree[]" value="tributario"> Tributario</label>
            <label><input type="checkbox" name="aree[]" value="condominio"> Condominio</label>
            <label><input type="checkbox" name="aree[]" value="ip"> Proprietà Intellettuale</label>
          </div>
        </div>

        <label class="checkbox-row nl-privacy">
          <input type="checkbox" name="privacy" required>
          <span>Acconsento al trattamento dei dati ex art. 13 GDPR per l'invio della newsletter. Ho letto l'<a href="<?php echo esc_url($privacy_url); ?>" style="color:var(--gold)">informativa privacy</a>. Posso disiscrivermi in qualunque momento.</span>
        </label>

        <button type="submit" class="btn btn-primary nl-submit">Iscrivimi alla Newsletter</button>
        <p class="nl-foot">Riceverai una email di conferma (double opt-in). Senza conferma non sarai iscritto.</p>
      </form>
    </div>
  </div>
</section>

<!-- COSA TROVI -->
<section class="block">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Cosa troverai</div>
      <h2>Contenuti curati dai professionisti dello Studio</h2>
    </div>
    <div class="nl-feat-grid">
      <div class="nl-feat">
        <div class="nl-feat-emoji">⚖️</div>
        <h4>Sentenze chiave</h4>
        <p>Commento alle pronunce della Cassazione e dei Tribunali con impatto pratico.</p>
      </div>
      <div class="nl-feat">
        <div class="nl-feat-emoji">📜</div>
        <h4>Novità normative</h4>
        <p>Decreti, leggi e regolamenti spiegati con linguaggio chiaro e indicazioni operative.</p>
      </div>
      <div class="nl-feat">
        <div class="nl-feat-emoji">⏰</div>
        <h4>Scadenze fiscali</h4>
        <p>Promemoria mensile delle principali scadenze tributarie e adempimenti aziendali.</p>
      </div>
      <div class="nl-feat">
        <div class="nl-feat-emoji">💡</div>
        <h4>Casi pratici</h4>
        <p>Esempi reali (anonimizzati) tratti dall'attività dello Studio: cosa è successo, come si risolve.</p>
      </div>
    </div>
  </div>
</section>

<!-- ARCHIVIO -->
<section class="block" style="background:var(--cream)">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Archivio numeri</div>
      <h2>Le edizioni precedenti</h2>
      <p>Anche se non sei iscritto puoi leggere i numeri pubblicati nei mesi scorsi.</p>
    </div>
    <div class="nl-arch-grid">
      <a href="#" class="nl-arch-card">
        <div class="nl-arch-meta">N° 5 · Maggio 2026</div>
        <h4>Riforma del processo penale: cosa cambia con la nuova "Cartabia bis"</h4>
        <p>Le modifiche introdotte dal DL marzo 2026 sui riti speciali e sull'improcedibilità in appello.</p>
        <span class="nl-arch-link">Leggi il numero →</span>
      </a>
      <a href="#" class="nl-arch-card">
        <div class="nl-arch-meta">N° 4 · Aprile 2026</div>
        <h4>Affidamento condiviso: 3 sentenze della Cassazione che devi conoscere</h4>
        <p>Quando il giudice deroga al principio di bigenitorialità e perché il conflitto da solo non basta.</p>
        <span class="nl-arch-link">Leggi il numero →</span>
      </a>
      <a href="#" class="nl-arch-card">
        <div class="nl-arch-meta">N° 3 · Marzo 2026</div>
        <h4>Definizione agevolata 2026: chi può aderire e con quale risparmio</h4>
        <p>Tabelle comparative e simulazione di risparmio per importi tipici.</p>
        <span class="nl-arch-link">Leggi il numero →</span>
      </a>
    </div>
  </div>
</section>

<!-- TRUST -->
<section class="block">
  <div class="container" style="max-width:780px;text-align:center">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Cosa garantiamo</div>
      <h2>Il tuo indirizzo email è al sicuro</h2>
    </div>
    <div class="nl-trust-grid">
      <div class="nl-trust">
        <h4>📨 Una sola email al mese</h4>
        <p>Mai più di 12 invii all'anno. Mai promozioni, mai vendite di dati.</p>
      </div>
      <div class="nl-trust">
        <h4>🚫 Disiscrizione 1 click</h4>
        <p>Link "unsubscribe" in fondo a ogni email. Una richiesta e sei subito fuori dalla lista.</p>
      </div>
      <div class="nl-trust">
        <h4>🔒 GDPR compliant</h4>
        <p>Dati ospitati in UE. Mai condivisi con terzi. Diritto di accesso, rettifica e cancellazione sempre garantiti.</p>
      </div>
    </div>
  </div>
</section>

<style>
/* === FORM CARD === */
.nl-form-card{background:#fff;padding:48px 40px;border-top:4px solid var(--gold);text-align:center}
.nl-form-card h2{font-family:var(--serif);font-size:30px;color:var(--navy);font-weight:600;margin-bottom:12px}
.nl-form-intro{color:var(--text-muted);margin-bottom:28px}
.nl-form{max-width:520px;margin:0 auto}
.nl-form-aree{text-align:left;margin-top:20px}
.nl-aree-label{margin-bottom:10px;display:block}
.nl-aree-label span{color:var(--text-muted);font-weight:400;font-size:11px}
.nl-aree-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;font-size:14px}
.nl-aree-grid label{display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:400}
.nl-privacy{margin-top:18px}
.nl-submit{width:100%;margin-top:10px;padding:16px}
.nl-foot{font-size:11px;color:var(--text-muted);margin-top:12px}

/* === COSA TROVERAI === */
.nl-feat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;max-width:1100px;margin:32px auto 0}
.nl-feat{background:#fff;border:1px solid var(--border);padding:28px;text-align:center}
.nl-feat-emoji{font-size:36px;margin-bottom:12px}
.nl-feat h4{font-family:var(--serif);font-size:18px;color:var(--navy);margin-bottom:8px}
.nl-feat p{font-size:13.5px;color:var(--text-muted);line-height:1.55}

/* === ARCHIVIO === */
.nl-arch-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1100px;margin:32px auto 0}
.nl-arch-card{background:#fff;border:1px solid var(--border);padding:28px;text-decoration:none;color:inherit;transition:all .3s;display:block}
.nl-arch-card:hover{box-shadow:0 20px 40px -16px rgba(14,26,51,.18);transform:translateY(-3px)}
.nl-arch-meta{font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:8px}
.nl-arch-card h4{font-family:var(--serif);font-size:20px;color:var(--navy);margin-bottom:10px;line-height:1.3}
.nl-arch-card p{font-size:13.5px;color:var(--text-muted);line-height:1.55;margin-bottom:14px}
.nl-arch-link{font-size:12px;color:var(--gold);font-weight:600;letter-spacing:.06em;text-transform:uppercase}

/* === TRUST === */
.nl-trust-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:32px;text-align:left}
.nl-trust{padding:24px;background:var(--cream);border-top:3px solid var(--gold)}
.nl-trust h4{font-family:var(--serif);font-size:18px;color:var(--navy);margin-bottom:8px}
.nl-trust p{font-size:13.5px;color:var(--text-muted);line-height:1.55}

/* === MOBILE === */
@media (max-width:980px){
  .nl-feat-grid{grid-template-columns:repeat(2,1fr)}
  .nl-arch-grid{grid-template-columns:1fr;max-width:560px}
  .nl-trust-grid{grid-template-columns:1fr;max-width:520px;margin-left:auto;margin-right:auto}
}
@media (max-width:680px){
  .nl-form-card{padding:32px 22px}
  .nl-form-card h2{font-size:24px}
  .nl-feat-grid{grid-template-columns:1fr;gap:14px}
  .nl-aree-grid{grid-template-columns:1fr}
  .nl-form-row{grid-template-columns:1fr}
}
</style>

<?php endwhile; get_footer();
