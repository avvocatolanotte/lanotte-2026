<?php
/**
 * Header globale del sito — con dual mega-menu (Aree + Calcolatori) e carrello
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
<!-- CRITICAL CSS inline (immune da cache esterna) + RESPONSIVE MOBILE -->
<style>
.nav-mega-trigger,.nav-mega-trigger-calc{cursor:pointer;display:inline-flex;align-items:center}
.header-actions{display:flex;align-items:center;gap:12px}
.header-cart{position:relative;display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border:1px solid #e5e7eb;border-radius:50%;color:#1d2c4a;text-decoration:none}
.cart-count{position:absolute;top:-4px;right:-4px;min-width:18px;height:18px;padding:0 5px;background:#b89968;color:#fff;font-size:11px;font-weight:700;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;line-height:1;border:2px solid #fff}
.cart-count[data-cart-count="0"]{display:none}
header.site-header{position:sticky;top:0;z-index:50;background:#fff}
/* === LOGO BRAND === */
.brand{display:inline-flex;align-items:center;gap:10px;text-decoration:none}
.brand-logo{display:block;height:60px;width:auto;max-width:280px;object-fit:contain}
.brand-logo-compact{height:48px;width:48px;max-width:48px}
.footer-logo{display:block;max-width:260px;height:auto}
/* Dropdown "Studio" desktop */
.nav-dd{position:relative;display:inline-block}
.nav-dd-trigger{cursor:pointer}
.nav-dd-panel{position:absolute;top:100%;left:0;min-width:210px;background:#fff;border:1px solid #e5e7eb;border-top:2px solid var(--gold,#b89968);box-shadow:0 12px 28px -10px rgba(15,23,42,.18);border-radius:0 0 6px 6px;padding:8px 0;display:none;z-index:60}
.nav-dd:hover .nav-dd-panel{display:block}
.nav-dd-panel a{display:block;padding:9px 18px;font-size:14px;color:#1d2c4a;text-decoration:none;white-space:nowrap;font-weight:500}
.nav-dd-panel a:hover{background:#fafaf7;color:var(--gold,#b89968)}

/* MOBILE DRAWER */
.mobile-drawer{position:fixed;top:0;right:-100%;width:min(360px,90vw);height:100vh;background:#fff;box-shadow:-10px 0 40px rgba(15,23,42,.25);z-index:200;overflow-y:auto;transition:right .3s ease;padding:24px}
.mobile-drawer.is-open{right:0}
.mobile-drawer-overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:199;display:none;backdrop-filter:blur(2px)}
.mobile-drawer-overlay.is-open{display:block}
.mobile-drawer .md-close{position:absolute;top:14px;right:14px;background:none;border:0;font-size:30px;color:#94a3b8;cursor:pointer;line-height:1}
.mobile-drawer ul{list-style:none;padding:0;margin:24px 0 0}
.mobile-drawer ul li{border-bottom:1px solid #f1f5f9}
.mobile-drawer ul li a{display:block;padding:14px 4px;color:#1d2c4a;font-weight:600;text-decoration:none;font-size:15px}
.mobile-drawer ul li a:hover{color:#b89968}
.mobile-drawer .md-section{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:#b89968;font-weight:700;margin:24px 0 8px;padding-bottom:6px;border-bottom:2px solid #f0e9dc}
.mobile-drawer .md-cta{display:block;margin-top:24px;padding:14px;background:#b89968;color:#fff;border-radius:4px;font-weight:600;text-align:center;text-decoration:none}
.mobile-drawer .md-cta:hover{background:#1d2c4a;color:#fff}

@media (max-width:900px){
  nav.primary{display:none !important}
  .cta-desktop{display:none !important}
  .hamburger-btn{display:inline-flex !important;align-items:center;justify-content:center}
  .header-inner{padding:12px 16px !important;gap:8px}
  .brand-logo{height:46px !important;max-width:200px !important}
  .topbar-left a,.topbar-left span{font-size:11px}
  .topbar-left span:nth-child(3){display:none}
  .topbar{padding:6px 0}
}
@media (max-width:600px){
  .topbar-right{display:none}
  .header-cart{width:36px;height:36px}
  .brand-logo{height:38px !important;max-width:160px !important}
}

/* Mega-menu mobile fix: nascosto su mobile, drawer subentra */
@media (max-width:900px){
  .nav-mega-panel,.nav-mega-panel-calc{display:none !important}
}

/* === DEFENSIVE MOBILE: forza collasso 1-col su grid inline ovunque === */
@media (max-width:700px){
  .entry-content [style*="grid-template-columns"],
  .legal-content [style*="grid-template-columns"],
  .post-content [style*="grid-template-columns"],
  main [style*="grid-template-columns:repeat(3"],
  main [style*="grid-template-columns:repeat(2"]{
    display:block !important;
    grid-template-columns:1fr !important;
  }
  .entry-content [style*="grid-template-columns"] > *,
  .legal-content [style*="grid-template-columns"] > *,
  .post-content [style*="grid-template-columns"] > *{
    margin-bottom:16px !important;
    width:100% !important;
    max-width:100% !important;
    box-sizing:border-box !important;
  }
  /* Topbar SVG defensive */
  .topbar svg,.topbar-left svg,.topbar-right svg{
    width:13px !important;
    height:13px !important;
    flex-shrink:0
  }
  /* Img/embed responsivi */
  main img,main iframe,main video{max-width:100%;height:auto}
  /* Tabelle scrollabili invece di esplodere */
  main table{display:block;overflow-x:auto;max-width:100%}
}

/* Polylang lang switcher */
.lang-switcher ul{list-style:none;display:inline-flex;gap:10px;margin:0;padding:0}
.lang-switcher li a{color:#cbd5e1;font-weight:600;text-decoration:none;text-transform:uppercase;font-size:11.5px;letter-spacing:.1em;padding:2px 4px;transition:color .15s}
.lang-switcher li a:hover{color:#b89968}
.lang-switcher li.current-lang a{color:#fff;border-bottom:1px solid #b89968}
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOPBAR -->
<div class="topbar">
  <div class="container topbar-inner">
    <div class="topbar-left">
      <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.5 1.953l-1.27 1.27a16 16 0 006.586 6.586l1.27-1.27a2 2 0 011.953-.502l2.8.7A2 2 0 0121 18.72V21a2 2 0 01-2 2C9.611 23 1 14.389 1 5z"/></svg>
        <?php echo esc_html(lanotte_phone()); ?>
      </a>
      <a href="mailto:<?php echo esc_attr(lanotte_email()); ?>">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <?php echo esc_html(lanotte_email()); ?>
      </a>
      <span>
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        <?php echo esc_html(lanotte_orari()); ?>
      </span>
    </div>
    <div class="topbar-right">
      <?php $url_riservata = lanotte_acf_option('studio_url_riservata', 'https://lanotte.netlex.cloud'); ?>
      <?php if ($url_riservata): ?>
      <a href="<?php echo esc_url($url_riservata); ?>" target="_blank" rel="noopener" style="display:inline-flex;gap:6px;align-items:center;font-size:12px;letter-spacing:.06em;color:#cbd5e1;font-weight:500;border-right:1px solid rgba(255,255,255,.12);padding-right:14px">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        Area Riservata
      </a>
      <?php endif; ?>
      <?php
      // Switcher lingue Polylang — visibile solo se plugin attivo
      if (function_exists('pll_the_languages')) {
          echo '<span class="lang-switcher" style="display:inline-flex;gap:10px;align-items:center;font-size:11.5px;letter-spacing:.08em;text-transform:uppercase;border-right:1px solid rgba(255,255,255,.12);padding-right:14px">';
          pll_the_languages([
              'raw' => 0,
              'show_flags' => 0,
              'show_names' => 1,
              'display_names_as' => 'slug',
              'hide_if_no_translation' => 0,
          ]);
          echo '</span>';
      }
      ?>
      <?php $fb = lanotte_acf_option('social_facebook',  'https://www.facebook.com/studiolegalelanotte/'); ?>
      <?php $ig = lanotte_acf_option('social_instagram', 'https://www.instagram.com/studio_legale_lanotte'); ?>
      <?php if ($fb): ?>
      <a href="<?php echo esc_url($fb); ?>" class="social" aria-label="Facebook" target="_blank" rel="noopener">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.99 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
      </a>
      <?php endif; ?>
      <?php if ($ig): ?>
      <a href="<?php echo esc_url($ig); ?>" class="social" aria-label="Instagram" target="_blank" rel="noopener">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
      </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- HEADER -->
<header class="site-header">
  <div class="container header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand">
      <?php lanotte_brand(); ?>
    </a>
    <nav class="primary" aria-label="Menu principale">
      <a href="<?php echo esc_url(home_url('/')); ?>" <?php if (is_front_page()) echo 'class="active"'; ?>>Home</a>
      <span class="nav-dd">
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('lo-studio'))); ?>" class="nav-dd-trigger<?php if (is_page(['lo-studio','carriere','newsletter','glossario']) || is_post_type_archive('caso') || is_singular('caso')) echo ' active'; ?>">Studio <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left:2px;vertical-align:-1px"><path d="M6 9l6 6 6-6"/></svg></a>
        <div class="nav-dd-panel">
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('lo-studio'))); ?>">Lo Studio</a>
          <?php $casi = get_post_type_archive_link('caso'); if ($casi): ?><a href="<?php echo esc_url($casi); ?>">Casi studio</a><?php endif; ?>
          <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Rassegna giuridica</a>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('glossario'))); ?>">Glossario giuridico</a>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('newsletter'))); ?>">Newsletter</a>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('carriere'))); ?>">Carriere</a>
        </div>
      </span>
      <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="nav-mega-trigger<?php if (is_post_type_archive('area') || is_singular('area')) echo ' active'; ?>">Aree <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left:4px;vertical-align:-1px"><path d="M6 9l6 6 6-6"/></svg></a>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari'))); ?>" <?php if (is_page('onorari')) echo 'class="active"'; ?>>Onorari &amp; Servizi</a>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('calcolatori')) ?: home_url('/calcolatori/')); ?>" class="nav-mega-trigger-calc<?php if (strpos($_SERVER['REQUEST_URI'], '/calcolatori') === 0) echo ' active'; ?>">Calcolatori <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left:4px;vertical-align:-1px"><path d="M6 9l6 6 6-6"/></svg></a>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" <?php if (is_page('contatti')) echo 'class="active"'; ?>>Contatti</a>
    </nav>
    <div class="header-actions">
      <a href="<?php echo esc_url(home_url('/carrello/')); ?>" class="header-cart" aria-label="Carrello servizi online">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 002 1.6h9.7a2 2 0 002-1.6L23 6H6"/></svg>
        <span class="cart-count" data-cart-count>0</span>
      </a>
      <?php $cta_url = lanotte_acf_option('cta_principale_url', get_permalink(get_page_by_path('contatti'))); ?>
      <a href="<?php echo esc_url($cta_url ?: '#'); ?>" class="btn btn-primary cta-desktop">Richiedi consulenza</a>
      <button class="hamburger-btn" id="hamburgerBtn" aria-label="Apri menu" type="button" style="display:none;background:none;border:1px solid #e5e7eb;border-radius:6px;padding:8px;cursor:pointer;color:#1d2c4a">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>

  <!-- MEGA MENU CALCOLATORI — hidden di default via inline style (immune a cache/CSS) -->
  <div class="nav-mega-panel-calc" role="menu" aria-label="Calcolatori" style="display:none;position:absolute;left:0;right:0;top:100%;background:#fff;border-top:1px solid #e5e7eb;border-bottom:3px solid #b89968;box-shadow:0 18px 40px -18px rgba(15,23,42,.25);z-index:90">
    <div class="nav-mega-grid">
      <div class="nav-mega-col">
        <h6>Compensi forensi</h6>
        <ul>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/parcella-civile.html'); ?>">⚖️ Parcella Civile</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/parcella-penale.html'); ?>">🔨 Parcella Penale</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/stragiudiziale.html'); ?>">🤝 Stragiudiziale + Mediazione</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/sfratti.html'); ?>">🏠 Procedimento Sfratto</a></li>
        </ul>
      </div>
      <div class="nav-mega-col">
        <h6>Lesioni e Danni</h6>
        <ul>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/micropermanenti.html'); ?>">🩺 Micropermanenti</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/macropermanenti.html'); ?>">🦴 Macropermanenti</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/danni-preesistenti.html'); ?>">📊 Coesistenti / Concorrenti</a></li>
        </ul>
      </div>
      <div class="nav-mega-col">
        <h6>ISTAT &amp; Interessi <span style="background:#065f46;color:#fff;font-size:9px;padding:2px 6px;border-radius:2px;margin-left:6px;vertical-align:middle">AUTO ⚡</span></h6>
        <ul>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/istat-locazione.html'); ?>">🏘️ ISTAT Locazione</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/mantenimento-istat.html'); ?>">👨‍👩‍👧 Mantenimento ISTAT</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/svalutazione.html'); ?>">💰 Svalutazione Monetaria</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/interessi-legali.html'); ?>">📈 Interessi Legali</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/interessi-moratori.html'); ?>">⏰ Interessi Moratori B2B</a></li>
        </ul>
      </div>
      <div class="nav-mega-col nav-mega-cta">
        <h6>Procedurali &amp; Utilities</h6>
        <ul>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/scadenze.html'); ?>">📅 Scadenze Processuali</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/aqp.html'); ?>">💧 Bolletta AQP</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/contributo-unificato.html'); ?>">🏛️ Contributo Unificato</a></li>
          <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/timeline-marchio.html'); ?>">™ Timeline Marchio</a></li>
        </ul>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('calcolatori')) ?: home_url('/calcolatori/')); ?>" class="nav-mega-allbtn">Vedi tutti i 16 strumenti <span aria-hidden="true">→</span></a>
      </div>
    </div>
  </div>

  <!-- MEGA MENU AREE — hidden di default via inline style (immune a cache/CSS) -->
  <div class="nav-mega-panel" role="menu" aria-label="Aree di attività" style="display:none;position:absolute;left:0;right:0;top:100%;background:#fff;border-top:1px solid #e5e7eb;border-bottom:3px solid #b89968;box-shadow:0 18px 40px -18px rgba(15,23,42,.25);z-index:90">
    <div class="nav-mega-grid">
      <?php
      // Recupera tutte le aree pubblicate, ordinate per menu_order
      $aree_query = new WP_Query([
          'post_type'      => 'area',
          'posts_per_page' => 13,
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
      ]);

      // Suddividi in 3 colonne tematiche se hai impostato meta o taxonomy
      // Per semplicità qui mostriamo tutte in una griglia
      $aree = [];
      while ($aree_query->have_posts()) { $aree_query->the_post(); $aree[] = ['title' => get_the_title(), 'url' => get_permalink()]; }
      wp_reset_postdata();

      // Suddividi in 3 colonne uniformi
      $chunks = array_chunk($aree, ceil(count($aree) / 3) ?: 1);
      foreach (array_slice($chunks, 0, 3) as $i => $chunk):
      ?>
      <div class="nav-mega-col">
        <h6><?php
          if ($i === 0) echo 'Civile &amp; Commerciale';
          elseif ($i === 1) echo 'Penale &amp; Persona';
          else echo 'Internazionale, IP &amp; Fiscale';
        ?></h6>
        <ul>
          <?php foreach ($chunk as $a): ?>
          <li><a href="<?php echo esc_url($a['url']); ?>"><?php echo esc_html($a['title']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
      <div class="nav-mega-col nav-mega-cta">
        <h6>Strumenti utili</h6>
        <ul class="nav-mega-tools">
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('calcolatori')) ?: home_url('/calcolatori/')); ?>">📊 Calcolatori (16)</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari'))); ?>">💼 Onorari trasparenti</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">📰 Rassegna giuridica</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari')) . '#servizi-online'); ?>">🛒 Servizi online</a></li>
        </ul>
        <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="nav-mega-allbtn">Vedi tutte le 13 aree <span aria-hidden="true">→</span></a>
      </div>
    </div>
  </div>
</header>

<!-- MOBILE DRAWER (visibile solo dopo click hamburger) -->
<div class="mobile-drawer-overlay" id="mdOverlay"></div>
<aside class="mobile-drawer" id="mobileDrawer" aria-label="Menu mobile">
  <button class="md-close" id="mdClose" aria-label="Chiudi">&times;</button>
  <ul>
    <li><a href="<?php echo esc_url(home_url('/')); ?>">🏠 Home</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('lo-studio'))); ?>">👥 Lo Studio</a></li>
    <li><a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>">⚖️ Aree di Competenza</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari'))); ?>">💼 Onorari &amp; Servizi</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('calcolatori')) ?: home_url('/calcolatori/')); ?>">📊 Calcolatori</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>">📞 Contatti</a></li>
  </ul>
  <div class="md-section">Approfondimenti</div>
  <ul>
    <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">📰 Rassegna giuridica</a></li>
    <?php $casi = get_post_type_archive_link('caso'); if ($casi): ?><li><a href="<?php echo esc_url($casi); ?>">📁 Casi studio</a></li><?php endif; ?>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('glossario'))); ?>">📖 Glossario giuridico</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('newsletter'))); ?>">✉️ Newsletter</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('carriere'))); ?>">💼 Carriere</a></li>
    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('penale-urgenza'))); ?>" style="color:#dc2626">🚨 Penale d'Urgenza H24</a></li>
  </ul>
  <div class="md-section">Calcolatori più richiesti</div>
  <ul>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/parcella-civile.html'); ?>">⚖️ Parcella Civile</a></li>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/parcella-penale.html'); ?>">🔨 Parcella Penale</a></li>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/istat-locazione.html'); ?>">🏘️ ISTAT Locazione</a></li>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/interessi-legali.html'); ?>">📈 Interessi Legali</a></li>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/scadenze.html'); ?>">📅 Scadenze Processuali</a></li>
    <li><a href="<?php echo esc_url(LANOTTE_THEME_URI . '/calcolatori/aqp.html'); ?>">💧 Bolletta AQP</a></li>
  </ul>
  <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="md-cta">RICHIEDI CONSULENZA</a>
  <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>" class="md-cta" style="background:#0f172a;margin-top:8px">📞 Chiama Studio</a>
</aside>

<!-- GLOBAL: cart badge + mega-menu hover -->
<script>
(function(){
  try{
    var c=JSON.parse(localStorage.getItem('lanotte_cart_v1'))||[];
    var n=c.length;
    document.querySelectorAll('[data-cart-count]').forEach(function(el){
      el.textContent=n;el.setAttribute('data-cart-count',n);
    });
  }catch(e){}
  (function(){
    var menus=[
      {trigger:document.querySelector('.nav-mega-trigger'),       panel:document.querySelector('.nav-mega-panel')},
      {trigger:document.querySelector('.nav-mega-trigger-calc'),  panel:document.querySelector('.nav-mega-panel-calc')}
    ].filter(function(m){return m.trigger && m.panel;});
    if(!menus.length) return;
    var closeTimer=null, activePanel=null;
    function closeAll(){menus.forEach(function(m){m.panel.style.display='none';m.panel.classList.remove('is-open');});activePanel=null;}
    function openOnly(panel){if(closeTimer){clearTimeout(closeTimer);closeTimer=null;}menus.forEach(function(m){if(m.panel===panel){m.panel.style.display='block';m.panel.classList.add('is-open');}else{m.panel.style.display='none';m.panel.classList.remove('is-open');}});activePanel=panel;}
    function scheduleClose(panel){if(closeTimer)clearTimeout(closeTimer);closeTimer=setTimeout(function(){panel.style.display='none';panel.classList.remove('is-open');if(activePanel===panel)activePanel=null;},220);}
    menus.forEach(function(m){
      m.trigger.addEventListener('mouseenter',function(){openOnly(m.panel);});
      m.trigger.addEventListener('mouseleave',function(){scheduleClose(m.panel);});
      m.panel.addEventListener('mouseenter',function(){openOnly(m.panel);});
      m.panel.addEventListener('mouseleave',function(){scheduleClose(m.panel);});
    });
    document.addEventListener('click',function(e){if(!activePanel)return;if(e.target.closest('.nav-mega-panel,.nav-mega-panel-calc,.nav-mega-trigger,.nav-mega-trigger-calc'))return;closeAll();});
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closeAll();});
  })();

  /* MOBILE DRAWER */
  var hamb=document.getElementById('hamburgerBtn'),
      drawer=document.getElementById('mobileDrawer'),
      overlay=document.getElementById('mdOverlay'),
      mdClose=document.getElementById('mdClose');
  function openDrawer(){if(drawer)drawer.classList.add('is-open');if(overlay)overlay.classList.add('is-open');document.body.style.overflow='hidden';}
  function closeDrawer(){if(drawer)drawer.classList.remove('is-open');if(overlay)overlay.classList.remove('is-open');document.body.style.overflow='';}
  if(hamb)hamb.addEventListener('click',openDrawer);
  if(mdClose)mdClose.addEventListener('click',closeDrawer);
  if(overlay)overlay.addEventListener('click',closeDrawer);
  document.addEventListener('keydown',function(e){if(e.key==='Escape')closeDrawer();});
})();
</script>
