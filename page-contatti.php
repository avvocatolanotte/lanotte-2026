<?php
/**
 * Template Name: Contatti
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

// Indirizzo per Google Maps embed (URL encoded)
$indirizzo_raw = lanotte_indirizzo();
$indirizzo_query = rawurlencode(strip_tags(str_replace(["\n", "\r"], ', ', $indirizzo_raw)));
$map_embed_acf = function_exists('get_field') ? get_field('map_embed') : '';
?>

<section class="hero-internal" style="padding:60px 0 40px">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1 style="font-size:clamp(32px,5vw,52px);line-height:1.1;margin-bottom:14px">Parliamone.</h1>
    <p class="subtitle" style="max-width:680px">Per appuntamenti, urgenze penali o richiesta di preventivo, il modo più rapido è il modulo qui sotto o WhatsApp.</p>
  </div>
</section>

<!-- QUICK ACTIONS bar: 3 CTA giganti, mobile-first -->
<section style="background:#fff;padding:24px 0;border-bottom:1px solid #e5e7eb">
  <div class="container">
    <div class="quick-actions">
      <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" target="_blank" rel="noopener" class="qa-btn qa-wa">
        <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <div>
          <strong>WhatsApp</strong>
          <span>Risposta rapida</span>
        </div>
      </a>
      <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>" class="qa-btn qa-tel">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.5 1.953l-1.27 1.27a16 16 0 006.586 6.586l1.27-1.27a2 2 0 011.953-.502l2.8.7A2 2 0 0121 18.72V21a2 2 0 01-2 2C9.611 23 1 14.389 1 5z"/></svg>
        <div>
          <strong>Chiama</strong>
          <span><?php echo esc_html(lanotte_phone()); ?></span>
        </div>
      </a>
      <a href="mailto:<?php echo esc_attr(lanotte_email()); ?>" class="qa-btn qa-mail">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <div>
          <strong>Email</strong>
          <span>Scrivici</span>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- MAPPA in primo piano, full width banner -->
<section style="background:#fff;padding:0">
  <div class="map-wrap">
    <?php if ($map_embed_acf): ?>
      <?php echo $map_embed_acf; ?>
    <?php else: ?>
      <iframe
        src="https://www.google.com/maps?q=<?php echo esc_attr($indirizzo_query); ?>&output=embed&z=15"
        width="100%"
        height="380"
        style="border:0;display:block"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Sede Studio Legale Lanotte &amp; Partners — Barletta"
        allowfullscreen></iframe>
    <?php endif; ?>
    <a href="https://www.google.com/maps?q=<?php echo esc_attr($indirizzo_query); ?>" target="_blank" rel="noopener" class="map-cta">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21s-7-4.5-7-10a7 7 0 0114 0c0 5.5-7 10-7 10z"/><circle cx="12" cy="11" r="2.5"/></svg>
      Apri in Google Maps →
    </a>
  </div>
</section>

<section class="block contact" style="padding:60px 0">
  <div class="container contact-grid">

    <div class="contact-info">
      <div class="section-eyebrow">Studio Legale Lanotte &amp; Partners</div>
      <h2 style="font-size:clamp(26px,3.5vw,34px);line-height:1.2;margin:8px 0 14px">Come scriverci.</h2>
      <p class="intro" style="font-size:15.5px;line-height:1.65;margin:0 0 28px">Risposta entro 24 ore lavorative. Per il <strong>penale d'urgenza</strong> è attiva la reperibilità telefonica anche festiva e notturna.</p>

      <div class="contact-row">
        <div class="contact-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21s-7-4.5-7-10a7 7 0 0114 0c0 5.5-7 10-7 10z"/><circle cx="12" cy="11" r="2.5"/></svg></div>
        <div class="contact-text">
          <strong>Sede</strong>
          <p><?php echo nl2br(esc_html($indirizzo_raw)); ?></p>
        </div>
      </div>

      <div class="contact-row">
        <div class="contact-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.5 1.953l-1.27 1.27a16 16 0 006.586 6.586l1.27-1.27a2 2 0 011.953-.502l2.8.7A2 2 0 0121 18.72V21a2 2 0 01-2 2C9.611 23 1 14.389 1 5z"/></svg></div>
        <div class="contact-text">
          <strong>Telefono</strong>
          <p><a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>"><?php echo esc_html(lanotte_phone()); ?></a></p>
          <small><?php echo esc_html(lanotte_orari()); ?></small>
        </div>
      </div>

      <div class="contact-row">
        <div class="contact-icon" style="background:#dcfce7;color:#16a34a"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg></div>
        <div class="contact-text">
          <strong>WhatsApp</strong>
          <p><a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" target="_blank" rel="noopener">Scrivici subito</a></p>
          <small>Il modo più rapido per urgenze</small>
        </div>
      </div>

      <div class="contact-row">
        <div class="contact-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
        <div class="contact-text">
          <strong>Email &amp; PEC</strong>
          <p><a href="mailto:<?php echo esc_attr(lanotte_email()); ?>"><?php echo esc_html(lanotte_email()); ?></a></p>
          <small><a href="mailto:<?php echo esc_attr(lanotte_pec()); ?>" style="color:inherit"><?php echo esc_html(lanotte_pec()); ?></a> (PEC)</small>
        </div>
      </div>
    </div>

    <div class="contact-form">
      <h3 style="font-family:var(--serif);font-size:24px;color:var(--navy);margin:0 0 8px">Scrivici</h3>
      <p style="font-size:14.5px;color:#475569;margin:0 0 22px">Compila il modulo e ti rispondiamo entro 24 ore lavorative.</p>
      <?php
      $cf7 = function_exists('get_field') ? get_field('cf7_shortcode') : '';
      if ($cf7) {
          echo do_shortcode($cf7);
      } else {
          // Mostriamo SEMPRE il form HTML pulito (non the_content() che potrebbe
          // contenere blocchi duplicati ereditati dal seed/import precedente)
          ?>
              <form action="mailto:<?php echo esc_attr(lanotte_email()); ?>" method="post" enctype="text/plain" class="fallback-form">
                <label>Nome e cognome
                  <input type="text" name="nome" required>
                </label>
                <label>Email
                  <input type="email" name="email" required>
                </label>
                <label>Telefono
                  <input type="tel" name="telefono">
                </label>
                <label>Materia
                  <select name="materia">
                    <option>Civile</option>
                    <option>Penale</option>
                    <option>Lavoro</option>
                    <option>Commerciale</option>
                    <option>Famiglia</option>
                    <option>Altro</option>
                  </select>
                </label>
                <label>Messaggio
                  <textarea name="messaggio" rows="5" required></textarea>
                </label>
                <label class="check">
                  <input type="checkbox" required>
                  <span>Ho letto l'<a href="<?php echo esc_url(home_url('/privacy/')); ?>" target="_blank">informativa privacy</a> e acconsento al trattamento.</span>
                </label>
                <button type="submit" class="btn btn-primary">Invia messaggio →</button>
                <p class="form-note">Modulo provvisorio. Per la versione definitiva verrà installato Contact Form 7 con anti-spam.</p>
              </form>
              <?php
      }
      ?>
    </div>

  </div>
</section>

<section class="block-sm" style="background:var(--cream);padding:50px 0">
  <div class="container">
    <div class="section-title" style="text-align:center;margin-bottom:30px">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Come raggiungerci</div>
      <h2 style="font-size:clamp(24px,3vw,30px);margin:8px 0 0">Indicazioni stradali</h2>
    </div>
    <div class="indicazioni-grid">
      <div class="ind-card">
        <div class="ind-icon"><svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 16H9m10 0h3v-3.15a1 1 0 00-.84-.99L16 11l-2.7-3.6a1 1 0 00-.8-.4H5.24a2 2 0 00-1.8 1.1l-.8 1.63A6 6 0 002 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg></div>
        <h4>In auto</h4>
        <p>Uscita A14 "Andria-Barletta" o "Canosa". Da entrambe, circa 15 minuti. Parcheggio sulla strada o nelle vicinanze.</p>
      </div>
      <div class="ind-card">
        <div class="ind-icon"><svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="14" rx="2"/><path d="M4 12h16M9 18l-2 3M15 18l2 3"/><circle cx="8" cy="15" r="1" fill="currentColor"/><circle cx="16" cy="15" r="1" fill="currentColor"/></svg></div>
        <h4>In treno</h4>
        <p>Stazione di Barletta sulla linea adriatica (Bari-Foggia). Da lì 8 minuti in taxi o autobus.</p>
      </div>
      <div class="ind-card">
        <div class="ind-icon"><svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 00-3 0V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5z"/></svg></div>
        <h4>In aereo</h4>
        <p>Aeroporto di Bari "Karol Wojtyła" a 60 km. Collegamento treno/bus diretto verso Barletta.</p>
      </div>
    </div>
  </div>
</section>

<style>
/* ===== QUICK ACTIONS ===== */
.quick-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
.qa-btn{display:flex;align-items:center;gap:14px;padding:16px 18px;border-radius:8px;text-decoration:none;color:#fff;transition:all .2s;min-height:64px}
.qa-btn:hover{transform:translateY(-2px);box-shadow:0 12px 24px -12px rgba(15,23,42,.25)}
.qa-btn svg{flex-shrink:0}
.qa-btn div{display:flex;flex-direction:column;line-height:1.2}
.qa-btn strong{font-size:15px;font-weight:600;letter-spacing:.01em}
.qa-btn span{font-size:12.5px;opacity:.85;margin-top:2px}
.qa-wa{background:#16a34a}
.qa-tel{background:var(--navy,#0f172a)}
.qa-mail{background:var(--gold,#b89968)}

/* ===== MAPPA ===== */
.map-wrap{position:relative;width:100%}
.map-wrap iframe{display:block;width:100%}
.map-cta{position:absolute;bottom:16px;right:16px;background:#fff;color:var(--navy,#0f172a);padding:10px 16px;border-radius:6px;font-size:13.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 8px 20px -8px rgba(0,0,0,.3);transition:all .2s}
.map-cta:hover{transform:translateY(-2px);background:var(--gold,#b89968);color:#fff}

/* ===== CONTACT GRID ===== */
.contact-grid{display:grid;grid-template-columns:1fr 1.1fr;gap:48px;align-items:start}
.contact-row{display:flex;gap:16px;padding:16px 0;border-bottom:1px solid #f1f5f9}
.contact-row:last-child{border-bottom:0}
.contact-icon{flex-shrink:0;width:44px;height:44px;border-radius:10px;background:rgba(184,153,104,.12);color:var(--gold,#b89968);display:flex;align-items:center;justify-content:center}
.contact-icon svg{width:22px;height:22px}
.contact-text{flex:1;min-width:0}
.contact-text strong{display:block;font-size:11.5px;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;font-weight:700;margin-bottom:4px}
.contact-text p{margin:0;font-size:15px;line-height:1.5;color:var(--navy,#0f172a);word-break:break-word}
.contact-text p a{color:var(--navy,#0f172a);text-decoration:none;border-bottom:1px solid var(--gold,#b89968);transition:color .2s}
.contact-text p a:hover{color:var(--gold,#b89968)}
.contact-text small{display:block;font-size:13px;color:#64748b;margin-top:4px;line-height:1.4}
.contact-text small a{color:inherit}

/* ===== CONTACT FORM ===== */
.contact-form{background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:32px;border-top:4px solid var(--gold,#b89968)}
.fallback-form{display:flex;flex-direction:column;gap:14px}
.fallback-form label{display:flex;flex-direction:column;font-size:13px;font-weight:600;color:var(--navy,#0f172a);letter-spacing:.02em}
.fallback-form input,.fallback-form select,.fallback-form textarea{margin-top:6px;padding:12px 14px;border:1px solid #cbd5e1;border-radius:6px;font-size:15px;font-family:inherit;background:#fff;color:#0f172a;transition:border-color .2s}
.fallback-form input:focus,.fallback-form select:focus,.fallback-form textarea:focus{outline:none;border-color:var(--gold,#b89968);box-shadow:0 0 0 3px rgba(184,153,104,.15)}
.fallback-form textarea{resize:vertical;min-height:120px}
.fallback-form .check{flex-direction:row;align-items:flex-start;gap:10px;font-weight:400;font-size:13px;color:#475569;line-height:1.5}
.fallback-form .check input{margin:2px 0 0;flex-shrink:0}
.fallback-form .check a{color:var(--navy,#0f172a)}
.fallback-form button{margin-top:10px;width:100%;padding:14px;font-size:15px}
.form-note{font-size:11.5px;color:#94a3b8;font-style:italic;margin:8px 0 0;text-align:center}

/* ===== INDICAZIONI ===== */
.indicazioni-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.ind-card{background:#fff;padding:28px 24px;border-radius:8px;border-top:3px solid var(--gold,#b89968);text-align:center;transition:transform .2s}
.ind-card:hover{transform:translateY(-3px);box-shadow:0 16px 32px -16px rgba(15,23,42,.15)}
.ind-icon{color:var(--gold,#b89968);margin-bottom:12px;display:flex;justify-content:center}
.ind-card h4{font-family:var(--serif);font-size:18px;color:var(--navy,#0f172a);margin:0 0 10px;font-weight:600}
.ind-card p{font-size:14px;color:#475569;line-height:1.6;margin:0}

/* ===== MOBILE BREAKPOINTS ===== */
@media (max-width:900px){
  .contact-grid{grid-template-columns:1fr;gap:32px}
  .indicazioni-grid{grid-template-columns:1fr;gap:14px}
  .contact-form{padding:24px}
}

@media (max-width:680px){
  .quick-actions{grid-template-columns:1fr;gap:10px}
  .qa-btn{padding:14px 16px;min-height:auto}
  .map-wrap iframe{height:320px}
  .map-cta{bottom:12px;right:12px;font-size:12.5px;padding:8px 12px}
  .contact-row{padding:14px 0;gap:12px}
  .contact-icon{width:38px;height:38px;border-radius:8px}
  .contact-icon svg{width:18px;height:18px}
  .contact-text p{font-size:14.5px}
  .ind-card{padding:24px 18px;text-align:left}
  .ind-icon{justify-content:flex-start}
}

@media (max-width:420px){
  .map-wrap iframe{height:260px}
  .contact-form{padding:20px;border-radius:6px}
}
</style>

<?php endwhile; get_footer();
