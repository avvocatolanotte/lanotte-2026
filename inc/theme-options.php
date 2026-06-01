<?php
/**
 * Theme Options — pannello "Personalizza Studio"
 *
 * Pagina admin in Aspetto → Personalizza Studio con tabs:
 *  - Contatti (telefono, email, PEC, indirizzo, orari)
 *  - Social (Facebook, Instagram, LinkedIn)
 *  - Hero homepage (titolo, sottotitolo, lead, bg, CTA)
 *  - Trust bar (4 punti di fiducia)
 *  - Footer (testo intro, copyright)
 *
 * Tutti i valori sono salvati in wp_options come 'lanotte_opt_<key>'.
 * Le funzioni helper (lanotte_phone, lanotte_email, ecc.) leggono prima
 * da queste options, poi cadono su default.
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/**
 * Definizione dei campi gestiti.
 * Ogni campo: key, label, tipo (text|textarea|url|image|color), default, group.
 */
function lanotte_options_schema() {
    return [
        // === CONTATTI ===
        'studio_telefono'    => ['label' => 'Telefono studio',         'type' => 'text',     'default' => '+39 0883 1955533', 'group' => 'contatti', 'hint' => 'Es: +39 0883 1955533'],
        'studio_email'       => ['label' => 'Email principale',        'type' => 'email',    'default' => 'info@studiolegalelanotte.it', 'group' => 'contatti'],
        'studio_pec'         => ['label' => 'PEC',                     'type' => 'email',    'default' => 'studiolegalelanotte@legalmail.it', 'group' => 'contatti'],
        'studio_indirizzo'   => ['label' => 'Indirizzo studio',        'type' => 'textarea', 'default' => 'Viale Falcone e Borsellino, 75 — 76121 Barletta (BT)', 'group' => 'contatti', 'rows' => 2],
        'studio_orari'       => ['label' => 'Orari ricevimento',       'type' => 'text',     'default' => 'Lun · Mer · Ven 9-13 / 16-21', 'group' => 'contatti'],
        'studio_whatsapp'    => ['label' => 'Numero WhatsApp',         'type' => 'text',     'default' => '+39 392 970 3202', 'group' => 'contatti', 'hint' => 'Senza spazi: es. +393929703202. Lascia vuoto per usare il telefono studio'],
        'studio_url_riservata' => ['label' => 'URL Area Riservata',    'type' => 'url',      'default' => 'https://lanotte.netlex.cloud', 'group' => 'contatti', 'hint' => 'Link in topbar (Netlex Cloud o altro)'],

        // === SOCIAL ===
        'social_facebook'    => ['label' => 'URL Facebook',            'type' => 'url', 'default' => 'https://www.facebook.com/studiolegalelanotte/', 'group' => 'social'],
        'social_instagram'   => ['label' => 'URL Instagram',           'type' => 'url', 'default' => 'https://www.instagram.com/studio_legale_lanotte', 'group' => 'social'],
        'social_linkedin'    => ['label' => 'URL LinkedIn',            'type' => 'url', 'default' => '', 'group' => 'social', 'hint' => 'Lascia vuoto se non hai LinkedIn'],

        // === HERO HOMEPAGE ===
        'hero_eyebrow'       => ['label' => 'Hero · Eyebrow (sopra titolo)', 'type' => 'text', 'default' => 'Studio Legale · Barletta · Foro di Trani', 'group' => 'hero'],
        'hero_title'         => ['label' => 'Hero · Titolo H1',        'type' => 'textarea', 'default' => "Un presidio legale<br><em>al Vostro fianco,</em> ogni giorno.", 'group' => 'hero', 'rows' => 3, 'hint' => 'HTML permesso: &lt;br&gt;, &lt;em&gt;, &lt;strong&gt;'],
        'hero_lead'          => ['label' => 'Hero · Testo introduttivo','type' => 'textarea', 'default' => 'Assistiamo imprese e privati con un approccio multidisciplinare: civile, penale, commerciale, lavoro, tributario, internazionale e proprietà industriale. Un solo interlocutore, una rete di specialisti.', 'group' => 'hero', 'rows' => 4],
        'hero_bg'            => ['label' => 'Hero · Immagine sfondo (URL)', 'type' => 'image', 'default' => '', 'group' => 'hero', 'hint' => 'Lascia vuoto per usare la cattedrale di Trani. Usa Media → Carica → copia URL.'],
        'cta_principale_url' => ['label' => 'Hero · Link bottone "Prenota consulenza"', 'type' => 'url', 'default' => '', 'group' => 'hero', 'hint' => 'Lascia vuoto per puntare automaticamente a /contatti/'],
        'hero_cf7_shortcode' => ['label' => 'Hero · Shortcode Contact Form 7', 'type' => 'text', 'default' => '', 'group' => 'hero', 'hint' => 'Es. [contact-form-7 id="123"]. Lascia vuoto per mostrare placeholder.'],

        // === FOOTER ===
        'footer_intro'       => ['label' => 'Footer · Testo dati studio', 'type' => 'textarea', 'default' => 'Avv. Giuseppe LANOTTE — Iscritto all\'Ordine degli Avvocati di Trani.<br>C.F.: LNTGPP78B01L328P · P.IVA: 06731750722', 'group' => 'footer', 'rows' => 3],
        'footer_disclaimer'  => ['label' => 'Footer · Disclaimer aggiuntivo', 'type' => 'textarea', 'default' => '', 'group' => 'footer', 'rows' => 3, 'hint' => 'Opzionale: testo nel footer bottom'],
    ];
}

/**
 * Lettore valore: option > default schema.
 */
function lanotte_opt($key, $fallback_default = null) {
    $val = get_option('lanotte_opt_' . $key, null);
    if ($val !== null && $val !== '') return $val;
    if ($fallback_default !== null) return $fallback_default;
    $schema = lanotte_options_schema();
    return $schema[$key]['default'] ?? '';
}

/**
 * Override degli helper: leggono da lanotte_opt() prima dei default ACF.
 * Vengono caricati DOPO helpers.php quindi sovrascrivono.
 *
 * NB: lanotte_acf_option() già controlla wp_option fallback in helpers.php,
 *      ma noi qui forziamo la sorgente "lanotte_opt_*" che è quella del
 *      pannello Personalizza Studio.
 */
add_filter('lanotte_acf_option_filter', function($value, $key, $default) {
    $opt = get_option('lanotte_opt_' . $key, null);
    if ($opt !== null && $opt !== '') return $opt;
    return $value;
}, 10, 3);

/**
 * Pagina admin
 */
add_action('admin_menu', function() {
    add_theme_page(
        'Personalizza Studio',
        '✏️ Personalizza Studio',
        'edit_theme_options',
        'lanotte-personalizza',
        'lanotte_personalizza_page'
    );
});

/**
 * Salvataggio
 */
add_action('admin_init', function() {
    if (!isset($_POST['lanotte_personalizza_save'])) return;
    if (!current_user_can('edit_theme_options')) return;
    check_admin_referer('lanotte_personalizza');

    $schema = lanotte_options_schema();
    foreach ($schema as $key => $def) {
        if (!isset($_POST['opt'][$key])) continue;
        $raw = $_POST['opt'][$key];

        switch ($def['type']) {
            case 'email':
                $val = sanitize_email($raw);
                break;
            case 'url':
                $val = esc_url_raw($raw);
                break;
            case 'textarea':
                $val = wp_kses($raw, [
                    'br' => [], 'strong' => [], 'em' => [], 'b' => [], 'i' => [], 'a' => ['href' => true, 'target' => true, 'rel' => true],
                ]);
                break;
            case 'image':
                $val = esc_url_raw($raw);
                break;
            default:
                $val = sanitize_text_field($raw);
        }
        update_option('lanotte_opt_' . $key, $val);
    }

    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Impostazioni salvate.</strong> <a href="' . esc_url(home_url('/')) . '" target="_blank">Vai alla home →</a></p></div>';
    });
});

function lanotte_personalizza_page() {
    $schema = lanotte_options_schema();
    $groups = [
        'contatti' => ['icon' => '📞', 'label' => 'Contatti',           'desc' => 'Telefono, email, PEC, indirizzo, orari, WhatsApp, area riservata.'],
        'social'   => ['icon' => '🌐', 'label' => 'Social',             'desc' => 'Link a Facebook, Instagram, LinkedIn (mostrati in topbar e footer).'],
        'hero'     => ['icon' => '🏠', 'label' => 'Hero Homepage',      'desc' => 'Titolo, testo, immagine di sfondo e bottoni del banner principale.'],
        'footer'   => ['icon' => '📜', 'label' => 'Footer',             'desc' => 'Testo dati studio, disclaimer aggiuntivo.'],
    ];
    $current_tab = $_GET['tab'] ?? 'contatti';
    if (!isset($groups[$current_tab])) $current_tab = 'contatti';
    ?>
    <div class="wrap">
      <h1>✏️ Personalizza Studio</h1>
      <p>Da qui modifichi i contenuti principali del sito senza toccare il codice. Le modifiche sono immediate dopo "Salva".</p>

      <h2 class="nav-tab-wrapper" style="margin-bottom:24px">
        <?php foreach ($groups as $gid => $g): ?>
        <a href="?page=lanotte-personalizza&tab=<?php echo esc_attr($gid); ?>" class="nav-tab <?php if ($current_tab === $gid) echo 'nav-tab-active'; ?>">
          <?php echo $g['icon']; ?> <?php echo esc_html($g['label']); ?>
        </a>
        <?php endforeach; ?>
        <a href="?page=lanotte-home-sections" class="nav-tab" style="margin-left:auto">🏠 Sezioni Home</a>
        <a href="?page=lanotte-setup" class="nav-tab">🔧 Setup</a>
      </h2>

      <form method="post">
        <?php wp_nonce_field('lanotte_personalizza'); ?>
        <input type="hidden" name="tab" value="<?php echo esc_attr($current_tab); ?>">

        <div class="card" style="max-width:880px;padding:20px 26px;background:#fff;border:1px solid #c3c4c7;border-radius:6px">
          <h2 style="margin-top:0;font-size:20px;font-weight:600">
            <?php echo $groups[$current_tab]['icon']; ?> <?php echo esc_html($groups[$current_tab]['label']); ?>
          </h2>
          <p class="description" style="margin-bottom:24px"><?php echo esc_html($groups[$current_tab]['desc']); ?></p>

          <table class="form-table">
            <?php foreach ($schema as $key => $def):
              if ($def['group'] !== $current_tab) continue;
              $val = lanotte_opt($key, '');
              if ($val === '') $val = $def['default'];
            ?>
            <tr>
              <th scope="row">
                <label for="lopt-<?php echo esc_attr($key); ?>"><?php echo esc_html($def['label']); ?></label>
              </th>
              <td>
                <?php if ($def['type'] === 'textarea'): ?>
                  <textarea id="lopt-<?php echo esc_attr($key); ?>" name="opt[<?php echo esc_attr($key); ?>]" rows="<?php echo (int)($def['rows'] ?? 3); ?>" class="large-text"><?php echo esc_textarea($val); ?></textarea>
                <?php elseif ($def['type'] === 'image'): ?>
                  <input id="lopt-<?php echo esc_attr($key); ?>" type="text" name="opt[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($val); ?>" class="large-text" placeholder="https://...">
                  <button type="button" class="button lanotte-media-pick" data-target="lopt-<?php echo esc_attr($key); ?>" style="margin-top:6px">📷 Scegli dalla Media Library</button>
                  <?php if ($val): ?>
                  <div style="margin-top:10px"><img src="<?php echo esc_url($val); ?>" alt="Anteprima" style="max-width:280px;max-height:120px;border:1px solid #ddd;padding:4px;background:#fff"></div>
                  <?php endif; ?>
                <?php elseif ($def['type'] === 'email'): ?>
                  <input id="lopt-<?php echo esc_attr($key); ?>" type="email" name="opt[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($val); ?>" class="regular-text">
                <?php elseif ($def['type'] === 'url'): ?>
                  <input id="lopt-<?php echo esc_attr($key); ?>" type="url" name="opt[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($val); ?>" class="regular-text" placeholder="https://...">
                <?php else: ?>
                  <input id="lopt-<?php echo esc_attr($key); ?>" type="text" name="opt[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($val); ?>" class="regular-text">
                <?php endif; ?>
                <?php if (!empty($def['hint'])): ?>
                  <p class="description"><?php echo wp_kses_post($def['hint']); ?></p>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </table>

          <p>
            <button type="submit" name="lanotte_personalizza_save" class="button button-primary button-large">💾 Salva impostazioni</button>
            <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="button button-secondary">Apri home in nuova scheda →</a>
          </p>
        </div>
      </form>
    </div>

    <script>
    jQuery(function($){
      // Media library picker per i campi immagine
      $(document).on('click', '.lanotte-media-pick', function(e){
        e.preventDefault();
        var targetId = $(this).data('target');
        var frame = wp.media({
          title: 'Scegli immagine',
          button: { text: 'Usa questa immagine' },
          multiple: false
        });
        frame.on('select', function(){
          var att = frame.state().get('selection').first().toJSON();
          $('#' + targetId).val(att.url);
        });
        frame.open();
      });
    });
    </script>
    <?php
}

/* Carica wp.media nella nostra pagina */
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'appearance_page_lanotte-personalizza') return;
    wp_enqueue_media();
});
