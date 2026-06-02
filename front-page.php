<?php
/**
 * Template Homepage — sezioni riordinabili
 *
 * L'ordine e la visibilità delle sezioni sono gestiti da Aspetto → Sezioni Home.
 * Il registry e la pagina admin sono in /inc/homepage-builder.php.
 *
 * @package lanotte-2026
 */

get_header();

$registry = lanotte_home_sections_registry();
$config   = lanotte_home_sections_config();

foreach ($config as $item) {
    if (empty($item['enabled'])) continue;
    $id = $item['id'];
    if (!isset($registry[$id])) continue;
    $cb = $registry[$id]['callback'];
    if (function_exists($cb)) {
        call_user_func($cb);
    }
}

get_footer();

/* ========================================================================
   SEZIONI HOME — callback (referenziati nel registry)
======================================================================== */

function lanotte_render_section_hero() {
    $hero_eyebrow = lanotte_acf_option('hero_eyebrow', 'Studio Legale · Barletta · Foro di Trani');
    $hero_title   = lanotte_acf_option('hero_title',   'Un presidio legale<br><em>al Vostro fianco,</em> ogni giorno.');
    $hero_lead    = lanotte_acf_option('hero_lead',    'Assistiamo imprese e privati con un approccio multidisciplinare: civile, penale, commerciale, lavoro, tributario, internazionale e proprietà industriale. Un solo interlocutore, una rete di specialisti.');
    $hero_bg      = lanotte_acf_option('hero_bg',      LANOTTE_THEME_URI . '/assets/img/trani/cattedrale-trani.jpg');
    $hero_cf7     = lanotte_acf_option('hero_cf7_shortcode', '');
    $cf_url       = lanotte_acf_option('cta_principale_url', get_permalink(get_page_by_path('contatti'))) ?: '#';
    ?>
    <section class="hero" style="--hero-bg:url('<?php echo esc_url($hero_bg); ?>')">
      <div class="container hero-inner">
        <div>
          <div class="hero-eyebrow"><?php echo esc_html($hero_eyebrow); ?></div>
          <h1><?php echo wp_kses_post($hero_title); ?></h1>
          <p class="lead"><?php echo wp_kses_post($hero_lead); ?></p>
          <div class="hero-cta">
            <a href="<?php echo esc_url($cf_url); ?>" class="btn btn-primary">Prenota una consulenza</a>
            <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="btn btn-ghost">Aree di competenza</a>
          </div>
          <?php
          $stats = function_exists('get_field') ? get_field('hero_stats', 'option') : null;
          if (!$stats) $stats = [
              ['numero' => '13',   'etichetta' => 'Aree di competenza'],
              ['numero' => 'Foro', 'etichetta' => 'di Trani'],
          ];
          if ($stats): ?>
          <div class="hero-stats">
            <?php foreach ($stats as $s): ?>
            <div class="hero-stat">
              <strong><?php echo esc_html($s['numero']); ?></strong>
              <span><?php echo esc_html($s['etichetta']); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <?php if ($hero_cf7): ?>
          <div class="hero-card">
            <h3>Hai un caso da discutere?</h3>
            <p>Rispondiamo entro 24 ore con un primo riscontro.</p>
            <?php echo do_shortcode($hero_cf7); ?>
          </div>
        <?php else: ?>
          <div class="hero-card">
            <h3>Hai un caso da discutere?</h3>
            <p>Rispondiamo entro 24 ore con un primo riscontro. Scegli il canale più comodo:</p>
            <div class="hero-card-actions">
              <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>" class="hca hca-phone">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.5 1.953l-1.27 1.27a16 16 0 006.586 6.586l1.27-1.27a2 2 0 011.953-.502l2.8.7A2 2 0 0121 18.72V21a2 2 0 01-2 2C9.611 23 1 14.389 1 5z"/></svg>
                <span><strong>Chiama</strong><?php echo esc_html(lanotte_phone()); ?></span>
              </a>
              <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" target="_blank" rel="noopener" class="hca hca-wa">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.4-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37s-1.04 1.02-1.04 2.48 1.07 2.88 1.22 3.07c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.12-.27-.2-.57-.35"/><path d="M12.05 2C6.6 2 2.13 6.45 2.13 11.9c0 1.76.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 004.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.9 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.05 2"/></svg>
                <span><strong>WhatsApp</strong>Risposta rapida</span>
              </a>
            </div>
            <a href="<?php echo esc_url($cf_url); ?>" class="btn btn-primary" style="margin-top:14px;width:100%">Compila il modulo contatti →</a>
          </div>
        <?php endif; ?>
      </div>
    </section>
    <style>
    .hero-card-actions{display:flex;flex-direction:column;gap:10px;margin:18px 0 0}
    .hca{display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:8px;text-decoration:none;transition:all .2s}
    .hca svg{flex-shrink:0}
    .hca span{display:flex;flex-direction:column;line-height:1.25;font-size:13px}
    .hca span strong{font-size:14.5px;font-weight:600}
    .hca-phone{background:var(--navy,#0f172a);color:#fff}
    .hca-phone span{color:#cbd5e1}.hca-phone span strong{color:#fff}
    .hca-wa{background:#16a34a;color:#fff}
    .hca-wa span{color:#dcfce7}.hca-wa span strong{color:#fff}
    .hca:hover{transform:translateY(-2px);box-shadow:0 10px 22px -12px rgba(15,23,42,.3)}
    </style>
    <?php
}

function lanotte_render_section_painpoint() {
    $aziende_url = get_post_type_archive_link('area');
    $privati_url = get_post_type_archive_link('area');
    ?>
    <section class="painpoint">
      <div class="container">
        <div class="pp-intro">
          <h2>Di cosa hai bisogno?</h2>
          <p>Assistenza legale multidisciplinare e tutela della proprietà intellettuale. Operativi sui Fori di Trani e Bari e in ambito internazionale.</p>
        </div>
        <div class="pp-grid">
          <a href="<?php echo esc_url($aziende_url); ?>" class="pp-card pp-aziende">
            <div class="pp-icon">
              <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/><path d="M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/></svg>
            </div>
            <h3>Per le Aziende</h3>
            <p>Contratti, proprietà intellettuale e marchi, diritto societario, recupero crediti, contenzioso d'impresa, internazionalizzazione.</p>
            <ul>
              <li>Contratti &amp; IP</li>
              <li>Societario &amp; governance</li>
              <li>Crediti &amp; contenzioso</li>
            </ul>
            <span class="pp-cta">Esplora le aree per l'impresa →</span>
          </a>
          <a href="<?php echo esc_url($privati_url); ?>" class="pp-card pp-privati">
            <div class="pp-icon">
              <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path d="M12 11a4 4 0 100-8 4 4 0 000 8z"/><path d="M4 21v-1a6 6 0 016-6h4a6 6 0 016 6v1"/></svg>
            </div>
            <h3>Per i Privati</h3>
            <p>Famiglia e successioni, casa e immobili, risarcimento danni e malasanità, lavoro, penale, previdenza e invalidità.</p>
            <ul>
              <li>Famiglia &amp; eredità</li>
              <li>Immobili &amp; condominio</li>
              <li>Risarcimenti &amp; danni</li>
            </ul>
            <span class="pp-cta">Esplora le aree per i privati →</span>
          </a>
        </div>
      </div>
    </section>
    <style>
    .painpoint{background:#fff;padding:64px 0}
    .pp-intro{text-align:center;max-width:680px;margin:0 auto 40px}
    .pp-intro h2{font-family:var(--serif);font-size:clamp(26px,3.5vw,36px);color:var(--navy);font-weight:600;margin:0 0 12px}
    .pp-intro p{font-size:16px;line-height:1.6;color:#475569;margin:0}
    .pp-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:980px;margin:0 auto}
    .pp-card{display:block;padding:36px 32px;border-radius:10px;text-decoration:none;border:1px solid #e5e7eb;transition:all .25s;position:relative;overflow:hidden}
    .pp-card::before{content:"";position:absolute;top:0;left:0;right:0;height:4px;background:var(--gold)}
    .pp-card:hover{transform:translateY(-4px);box-shadow:0 22px 44px -20px rgba(15,23,42,.28);border-color:var(--gold)}
    .pp-aziende{background:linear-gradient(160deg,#0f172a 0%,#1e293b 100%);color:#fff}
    .pp-aziende .pp-icon,.pp-aziende h3{color:#fff}
    .pp-aziende p{color:#cbd5e1}
    .pp-aziende ul li{color:#e2e8f0;border-color:rgba(255,255,255,.12)}
    .pp-aziende .pp-cta{color:var(--gold-light,#d4b87f)}
    .pp-privati{background:linear-gradient(160deg,#fdfbf5 0%,#fff 100%);color:var(--navy)}
    .pp-privati .pp-icon{color:var(--gold)}
    .pp-privati h3{color:var(--navy)}
    .pp-privati p{color:#475569}
    .pp-privati ul li{color:#334155;border-color:#f0e9dc}
    .pp-privati .pp-cta{color:var(--gold)}
    .pp-icon{margin-bottom:16px}
    .pp-card h3{font-family:var(--serif);font-size:24px;font-weight:600;margin:0 0 12px}
    .pp-card > p{font-size:14.5px;line-height:1.6;margin:0 0 18px}
    .pp-card ul{list-style:none;padding:0;margin:0 0 20px;display:flex;flex-wrap:wrap;gap:8px}
    .pp-card ul li{font-size:12.5px;font-weight:600;padding:5px 12px;border:1px solid;border-radius:20px}
    .pp-cta{font-size:14px;font-weight:600;letter-spacing:.01em}
    @media (max-width:760px){.pp-grid{grid-template-columns:1fr;gap:16px}.pp-card{padding:28px 24px}}
    </style>
    <?php
}

function lanotte_render_section_trustbar() {
    $trust_items = function_exists('get_field') ? get_field('trustbar', 'option') : null;
    if (!$trust_items) $trust_items = [
        ['titolo' => 'Iscritti Ordine Avvocati Trani', 'sottotitolo' => 'Codice deontologico forense', 'icona' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/></svg>'],
        ['titolo' => 'Preventivo scritto', 'sottotitolo' => 'L. 247/2012 · No quota lite', 'icona' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>'],
        ['titolo' => 'Segreto professionale', 'sottotitolo' => 'Comunicazioni cifrate e tracciate', 'icona' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7l9-4 9 4M5 9v8a2 2 0 002 2h10a2 2 0 002-2V9"/></svg>'],
        ['titolo' => 'Penale d\'urgenza', 'sottotitolo' => 'Reperibilità H24', 'icona' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>'],
    ];
    if (!$trust_items) return;
    ?>
    <div class="trustbar">
      <div class="container trustbar-inner">
        <?php foreach ($trust_items as $t): ?>
        <div class="trust-item">
          <?php echo wp_kses($t['icona'] ?? '', ['svg' => ['fill' => true, 'stroke' => true, 'stroke-width' => true, 'viewbox' => true], 'path' => ['d' => true], 'circle' => ['cx' => true, 'cy' => true, 'r' => true]]); ?>
          <span><strong><?php echo esc_html($t['titolo']); ?></strong><?php echo esc_html($t['sottotitolo']); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
}

function lanotte_render_section_clienti() {
    $clienti_q = new WP_Query([
        'post_type'      => 'cliente',
        'posts_per_page' => 12,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    $clienti_fallback = [
        ['title' => 'ITF — International Taekwon-Do Federation', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/itf-mondiale.svg', 'url' => 'https://itf-tkd.org/', 'desc' => 'ITF — International Taekwon-Do Federation (itf-tkd.org)'],
        ['title' => 'Taekwondo ITF Italia — Fitsport', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/taekwondo-itf.jpg', 'url' => '', 'desc' => 'Taekwondo ITF Italia · Fitsport'],
        ['title' => 'FQ Quinto', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/fq-quinto.png', 'url' => '', 'desc' => 'FQ Quinto'],
        ['title' => 'S.S.D. Federico II di Svevia — Centro Sportivo', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/federico-gym.svg', 'url' => '', 'desc' => 'S.S.D. Federico II di Svevia — Centro Sportivo'],
        ['title' => 'Condominiocasa.it', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/condominiocasa.jpg', 'url' => 'https://www.condominiocasa.it/', 'desc' => 'Condominiocasa.it · Amministrazione Condomini e Immobili'],
        ['title' => 'Puglia Fideiussioni', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/puglia-fideiussioni.jpg', 'url' => '', 'desc' => 'Puglia Fideiussioni'],
        ['title' => 'Prenota in Puglia', 'logo' => LANOTTE_THEME_URI . '/assets/img/clienti/prenota-in-puglia.png', 'url' => '', 'desc' => 'Prenota in Puglia'],
    ];

    $use_cpt = $clienti_q->have_posts();
    ?>
    <section class="block clienti-section" style="background:#fff;padding:60px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
      <div class="container">
        <div style="text-align:center;margin-bottom:32px">
          <div class="divider-dot"></div>
          <div class="section-eyebrow">Hanno scelto lo Studio</div>
          <h2 style="font-family:var(--serif);font-size:clamp(24px,2.5vw,32px);color:var(--navy);font-weight:600;margin-top:6px">I nostri clienti istituzionali</h2>
        </div>
        <div class="clienti-grid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:28px;align-items:center;justify-items:center;max-width:1180px;margin:0 auto">
          <?php if ($use_cpt): ?>
            <?php while ($clienti_q->have_posts()): $clienti_q->the_post();
              $title   = get_the_title();
              $img_src = function_exists('lanotte_cliente_logo') ? lanotte_cliente_logo(get_the_ID()) : '';
              $url     = function_exists('lanotte_cliente_url') ? lanotte_cliente_url(get_the_ID()) : '';
              $desc    = get_the_excerpt() ?: $title;
              if (!$img_src) continue;
            ?>
            <div class="cliente-logo">
              <?php if ($url): ?>
              <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($title); ?>">
                <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($desc ?: $title); ?>" title="<?php echo esc_attr($title); ?>" loading="lazy">
              </a>
              <?php else: ?>
              <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($desc ?: $title); ?>" title="<?php echo esc_attr($title); ?>" loading="lazy">
              <?php endif; ?>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
          <?php else: foreach ($clienti_fallback as $c): ?>
            <div class="cliente-logo">
              <?php if ($c['url']): ?>
              <a href="<?php echo esc_url($c['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($c['title']); ?>">
                <img src="<?php echo esc_url($c['logo']); ?>" alt="<?php echo esc_attr($c['desc']); ?>" title="<?php echo esc_attr($c['title']); ?>" loading="lazy">
              </a>
              <?php else: ?>
              <img src="<?php echo esc_url($c['logo']); ?>" alt="<?php echo esc_attr($c['desc']); ?>" title="<?php echo esc_attr($c['title']); ?>" loading="lazy">
              <?php endif; ?>
            </div>
          <?php endforeach; endif; ?>
        </div>
        <p style="text-align:center;font-size:12.5px;color:var(--text-muted);margin-top:24px;font-style:italic">Loghi pubblicati con il consenso dei rispettivi proprietari. Selezione fra i clienti istituzionali dello Studio.</p>
      </div>
    </section>
    <style>
    .cliente-logo{filter:grayscale(1);opacity:.6;transition:all .35s;width:100%;display:flex;align-items:center;justify-content:center}
    .cliente-logo:hover{filter:grayscale(0);opacity:1}
    .cliente-logo img{max-width:130px;max-height:80px;width:auto;height:auto;object-fit:contain}
    @media (max-width:1100px){.clienti-grid{grid-template-columns:repeat(4,1fr) !important;gap:24px !important}}
    @media (max-width:700px){.clienti-grid{grid-template-columns:repeat(3,1fr) !important;gap:20px !important}}
    @media (max-width:480px){.clienti-grid{grid-template-columns:repeat(2,1fr) !important}}
    </style>
    <?php
}

function lanotte_render_section_aree() {
    ?>
    <section class="block">
      <div class="container">
        <div class="section-title">
          <div class="divider-dot"></div>
          <div class="section-eyebrow">Cosa facciamo</div>
          <h2>Tredici aree, un solo interlocutore</h2>
          <p>Materia civile, penale, commerciale, tributaria e del lavoro, integrate dalla collaborazione di specialisti per la giurisdizione di legittimità.</p>
        </div>
        <div class="areas-grid">
          <?php
          $aree_query = new WP_Query([
              'post_type'      => 'area',
              'posts_per_page' => 9,
              'orderby'        => 'menu_order',
              'order'          => 'ASC',
          ]);
          while ($aree_query->have_posts()): $aree_query->the_post();
              get_template_part('template-parts/area-card');
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
        <div class="areas-cta">
          <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="btn btn-outline">Vedi tutte le 13 aree →</a>
        </div>
      </div>
    </section>
    <?php
}

function lanotte_render_section_trani() {
    get_template_part('template-parts/section-trani');
}

function lanotte_render_section_studio() {
    get_template_part('template-parts/section-studio-preview');
}

function lanotte_render_section_principi() {
    get_template_part('template-parts/section-principles');
}

function lanotte_render_section_recensioni() {
    get_template_part('template-parts/section-reviews');
}

function lanotte_render_section_ctastrip() {
    get_template_part('template-parts/section-ctastrip');
}

function lanotte_render_section_risorse() {
    $casi = get_post_type_archive_link('caso');
    $gloss = get_page_by_path('glossario');
    $cards = [
        ['url' => get_permalink(get_page_by_path('calcolatori')) ?: home_url('/calcolatori/'), 'icon' => '📊', 't' => '16 Calcolatori giuridici', 'd' => 'Parcelle forensi, danni, ISTAT, interessi, scadenze, contributo unificato. Gratuiti, con PDF.', 'cta' => 'Apri i calcolatori'],
        ['url' => $casi ?: '#', 'icon' => '📁', 't' => 'Casi Studio', 'd' => 'Scenari illustrativi che mostrano il metodo dello Studio nelle diverse materie del diritto.', 'cta' => 'Leggi i casi'],
        ['url' => $gloss ? get_permalink($gloss) : '#', 'icon' => '📖', 't' => 'Glossario giuridico', 'd' => 'I termini legali spiegati in modo chiaro e comprensibile a tutti.', 'cta' => 'Consulta il glossario'],
        ['url' => get_permalink(get_option('page_for_posts')) ?: '#', 'icon' => '📰', 't' => 'Rassegna giuridica', 'd' => 'Approfondimenti e aggiornamenti su giurisprudenza, prassi e novità normative.', 'cta' => 'Vai alla rassegna'],
    ];
    ?>
    <section class="risorse-section">
      <div class="container">
        <div style="text-align:center;margin-bottom:38px">
          <div class="section-eyebrow">Strumenti &amp; Risorse</div>
          <h2 style="font-family:var(--serif);font-size:clamp(26px,3.5vw,36px);color:var(--navy);font-weight:600;margin:8px 0 12px">Tutto a portata di mano</h2>
          <p style="font-size:15.5px;color:#475569;max-width:640px;margin:0 auto;line-height:1.6">Calcolatori gratuiti, scenari illustrativi, glossario e approfondimenti: strumenti utili anche prima di contattarci.</p>
        </div>
        <div class="risorse-grid">
          <?php foreach ($cards as $c): ?>
          <a href="<?php echo esc_url($c['url']); ?>" class="risorsa-card">
            <div class="risorsa-icon"><?php echo $c['icon']; ?></div>
            <h3><?php echo esc_html($c['t']); ?></h3>
            <p><?php echo esc_html($c['d']); ?></p>
            <span class="risorsa-cta"><?php echo esc_html($c['cta']); ?> →</span>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <style>
    .risorse-section{background:var(--cream,#fafaf7);padding:64px 0}
    .risorse-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;max-width:1100px;margin:0 auto}
    .risorsa-card{display:flex;flex-direction:column;background:#fff;border:1px solid #e5e7eb;border-top:3px solid var(--gold,#b89968);border-radius:10px;padding:30px 24px;text-decoration:none;transition:all .25s}
    .risorsa-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -18px rgba(15,23,42,.25);border-color:var(--gold,#b89968)}
    .risorsa-icon{font-size:38px;line-height:1;margin-bottom:14px}
    .risorsa-card h3{font-family:var(--serif);font-size:20px;color:var(--navy,#0f172a);font-weight:600;margin:0 0 10px;line-height:1.25}
    .risorsa-card p{font-size:13.5px;line-height:1.6;color:#475569;margin:0 0 16px;flex-grow:1}
    .risorsa-cta{font-size:13.5px;font-weight:600;color:var(--gold,#b89968)}
    @media (max-width:900px){.risorse-grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:520px){.risorse-grid{grid-template-columns:1fr}}
    </style>
    <?php
}

function lanotte_render_section_blog() {
    ?>
    <section class="block" id="blog">
      <div class="container">
        <div class="section-title">
          <div class="divider-dot"></div>
          <div class="section-eyebrow">Rassegna Giuridica</div>
          <h2>Approfondimenti e novità</h2>
          <p>Note di commento e aggiornamenti su giurisprudenza e prassi, a cura dei professionisti dello Studio.</p>
        </div>
        <div class="blog-grid">
          <?php
          $posts_q = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => 1]);
          while ($posts_q->have_posts()): $posts_q->the_post();
              get_template_part('template-parts/post-card');
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
    </section>
    <?php
}
