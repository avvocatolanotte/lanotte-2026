<?php
/**
 * Shortcode per contenuti dinamici nei post/page editabili da WP Admin
 *
 * Permette di inserire nel contenuto di una pagina valori che cambiano
 * dinamicamente (telefono studio, email, indirizzo) senza hardcoding.
 *
 * Uso: nell'editor WP scrivi semplicemente [phone] o [contatti-url]
 * e WP sostituirà col valore corrente delle opzioni del tema.
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/* === CONTATTI DINAMICI === */

add_shortcode('phone', function($atts) {
    $a = shortcode_atts(['raw' => '0'], $atts);
    return esc_html(lanotte_phone((bool)$a['raw']));
});

add_shortcode('phone-link', function() {
    return sprintf('<a href="tel:%s">%s</a>',
        esc_attr(lanotte_phone(true)),
        esc_html(lanotte_phone())
    );
});

add_shortcode('email', function() {
    return esc_html(lanotte_email());
});

add_shortcode('email-link', function() {
    return sprintf('<a href="mailto:%s">%s</a>',
        esc_attr(lanotte_email()),
        esc_html(lanotte_email())
    );
});

add_shortcode('pec', function() {
    return esc_html(lanotte_pec());
});

add_shortcode('indirizzo', function() {
    return nl2br(esc_html(lanotte_indirizzo()));
});

add_shortcode('orari', function() {
    return esc_html(lanotte_orari());
});

add_shortcode('whatsapp-url', function() {
    return esc_url(lanotte_whatsapp_url());
});

add_shortcode('whatsapp-link', function($atts, $content = null) {
    if (!$content) $content = 'Scrivici su WhatsApp';
    return sprintf('<a href="%s" target="_blank" rel="noopener">%s</a>',
        esc_url(lanotte_whatsapp_url()),
        wp_kses_post($content)
    );
});

/* === LINK A PAGINE WP (dinamico — sopravvive a cambi slug) === */

add_shortcode('page-url', function($atts) {
    $a = shortcode_atts(['slug' => 'contatti'], $atts);
    $page = get_page_by_path(sanitize_title($a['slug']));
    return $page ? esc_url(get_permalink($page)) : '#';
});

add_shortcode('page-link', function($atts, $content = null) {
    $a = shortcode_atts(['slug' => 'contatti', 'class' => ''], $atts);
    $page = get_page_by_path(sanitize_title($a['slug']));
    if (!$page) return $content;
    if (!$content) $content = get_the_title($page);
    $class_attr = $a['class'] ? ' class="' . esc_attr($a['class']) . '"' : '';
    return sprintf('<a href="%s"%s>%s</a>',
        esc_url(get_permalink($page)),
        $class_attr,
        wp_kses_post($content)
    );
});

/* === ASSET DEL TEMA === */

add_shortcode('theme-img', function($atts) {
    $a = shortcode_atts(['file' => '', 'alt' => '', 'class' => ''], $atts);
    if (!$a['file']) return '';
    $url = LANOTTE_THEME_URI . '/assets/img/' . ltrim($a['file'], '/');
    return sprintf('<img src="%s" alt="%s" class="%s" loading="lazy">',
        esc_url($url),
        esc_attr($a['alt']),
        esc_attr($a['class'])
    );
});

/* === HELPER: anno corrente, anno fondazione, ecc === */

add_shortcode('year', function() {
    return esc_html(date('Y'));
});

/* === DOC: pagina admin che elenca shortcode disponibili === */

add_action('admin_menu', function() {
    add_submenu_page(
        'tools.php',
        'Shortcode Lanotte',
        '🔧 Shortcode Lanotte',
        'edit_posts',
        'lanotte-shortcodes',
        'lanotte_shortcodes_help_page'
    );
});

function lanotte_shortcodes_help_page() {
    $rows = [
        ['code' => '[phone]', 'desc' => 'Telefono studio (testo)', 'esempio' => lanotte_phone()],
        ['code' => '[phone-link]', 'desc' => 'Telefono studio (link cliccabile)', 'esempio' => 'link tel:'],
        ['code' => '[email]', 'desc' => 'Email (testo)', 'esempio' => lanotte_email()],
        ['code' => '[email-link]', 'desc' => 'Email (link cliccabile)', 'esempio' => 'link mailto:'],
        ['code' => '[pec]', 'desc' => 'PEC studio', 'esempio' => lanotte_pec()],
        ['code' => '[indirizzo]', 'desc' => 'Indirizzo studio', 'esempio' => lanotte_indirizzo()],
        ['code' => '[orari]', 'desc' => 'Orari ricevimento', 'esempio' => lanotte_orari()],
        ['code' => '[whatsapp-url]', 'desc' => 'URL WhatsApp', 'esempio' => 'https://wa.me/...'],
        ['code' => '[whatsapp-link]Testo bottone[/whatsapp-link]', 'desc' => 'Link WhatsApp con testo custom', 'esempio' => 'link wa.me'],
        ['code' => '[page-url slug="contatti"]', 'desc' => 'URL di una pagina WP (per nome slug)', 'esempio' => 'sopravvive a cambi slug'],
        ['code' => '[page-link slug="onorari"]Testo[/page-link]', 'desc' => 'Link a pagina WP', 'esempio' => 'usa slug WP'],
        ['code' => '[theme-img file="trani/cattedrale.jpg" alt="..."]', 'desc' => 'Immagine dal tema', 'esempio' => 'percorso /assets/img/'],
        ['code' => '[year]', 'desc' => 'Anno corrente', 'esempio' => date('Y')],
    ];
    ?>
    <div class="wrap">
      <h1>🔧 Shortcode Lanotte — guida rapida</h1>
      <p>Puoi inserire questi shortcode nel contenuto di qualsiasi pagina o articolo. WordPress li sostituirà automaticamente con il valore corrente.</p>
      <p><strong>Esempio:</strong> nella pagina Contatti puoi scrivere: <code>Chiamaci al [phone] o scrivici a [email]</code></p>

      <table class="widefat striped" style="margin-top:20px;max-width:980px">
        <thead><tr><th>Shortcode</th><th>Cosa fa</th><th>Esempio output</th></tr></thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><code style="font-size:13px;background:#f0e9dc;padding:3px 7px;border-radius:3px"><?php echo esc_html($r['code']); ?></code></td>
            <td><?php echo esc_html($r['desc']); ?></td>
            <td style="color:#646970"><?php echo esc_html($r['esempio']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <h2 style="margin-top:30px">Perché usarli?</h2>
      <p>Se domani cambi numero di telefono o indirizzo, lo modifichi UNA volta sola da <a href="<?php echo esc_url(admin_url('themes.php?page=lanotte-personalizza')); ?>">Personalizza Studio</a> e si aggiorna automaticamente in tutte le pagine che usano lo shortcode.</p>
    </div>
    <?php
}
