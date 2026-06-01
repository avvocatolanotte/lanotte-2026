<?php
/**
 * Helper functions del tema
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/**
 * Restituisce l'URL della scheda ACF Options Page (se ACF Pro è attivo)
 */
function lanotte_acf_option($key, $default = '') {
    // 1. Cerca prima nelle opzioni del pannello "Personalizza Studio" (massima priorità — editing autonomo dell'avvocato)
    $opt = get_option('lanotte_opt_' . $key, null);
    if ($opt !== null && $opt !== '') return $opt;

    // 2. Cerca in ACF Options Page (se ACF Pro attivo)
    if (function_exists('get_field')) {
        $val = get_field($key, 'option');
        if (!empty($val)) return $val;
    }

    // 3. Default hardcoded
    return $default;
}

/**
 * Telefono unico, usato in più posti
 */
function lanotte_phone($raw = false) {
    $phone = lanotte_acf_option('studio_telefono', '+39 0883 1955533');
    if ($raw) return preg_replace('/[^\d+]/', '', $phone);
    return $phone;
}

/**
 * WhatsApp link
 */
function lanotte_whatsapp_url() {
    // 1. Numero WhatsApp dedicato dal pannello Personalizza
    $wa = lanotte_acf_option('studio_whatsapp', '');
    if ($wa) {
        $tel = preg_replace('/[^\d+]/', '', $wa);
    } else {
        // 2. Fallback al telefono studio
        $tel = lanotte_phone(true);
    }
    $tel = ltrim($tel, '+');
    return 'https://wa.me/' . $tel;
}

/**
 * Email principale
 */
function lanotte_email() {
    return lanotte_acf_option('studio_email', 'info@studiolegalelanotte.it');
}

/**
 * Email PEC
 */
function lanotte_pec() {
    return lanotte_acf_option('studio_pec', 'studiolegalelanotte@legalmail.it');
}

/**
 * Orari studio (testo)
 */
function lanotte_orari() {
    return lanotte_acf_option('studio_orari', 'Lun · Mer · Ven 9-13 / 16-21');
}

/**
 * Indirizzo studio
 */
function lanotte_indirizzo() {
    return lanotte_acf_option('studio_indirizzo', 'Viale Falcone e Borsellino, 75 — 76121 Barletta (BT)');
}

/**
 * Restituisce un'icona SVG inline dalla cartella assets/icons/
 */
function lanotte_icon($name, $class = '') {
    $file = LANOTTE_THEME_DIR . '/assets/icons/' . sanitize_file_name($name) . '.svg';
    if (!file_exists($file)) return '';
    $svg = file_get_contents($file);
    if ($class) {
        $svg = preg_replace('/<svg /', '<svg class="' . esc_attr($class) . '" ', $svg, 1);
    }
    return $svg;
}

/**
 * Stampa il logo brand con catena di fallback:
 *  1. Logo Customizer (Aspetto → Personalizza → Identità sito → Logo)
 *  2. Logo ACF Branding (Opzioni → Branding → Logo principale)
 *  3. File SVG nel tema (assets/img/logo.svg)
 *  4. Fallback testuale "Lanotte & Partners"
 *
 * @param string $variante  'normal' (default) | 'dark' (per sfondi scuri) | 'compact' (favicon-style)
 */
function lanotte_brand($variante = 'normal') {
    // 1. Customizer (priorità massima — è la via "standard WP")
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        echo wp_get_attachment_image(
            $custom_logo_id,
            'full',
            false,
            ['class' => 'brand-logo brand-logo-customizer', 'alt' => get_bloginfo('name') . ' — Studio Legale']
        );
        return;
    }

    // 2. ACF Branding (variante scura/chiara/compact)
    if (function_exists('get_field')) {
        $field = $variante === 'dark' ? 'logo_dark' : ($variante === 'compact' ? 'logo_compact' : 'logo_principale');
        $logo_acf = get_field($field, 'option');
        if ($logo_acf && !empty($logo_acf['url'])) {
            $alt = $logo_acf['alt'] ?: (get_bloginfo('name') . ' — Studio Legale');
            printf(
                '<img src="%s" alt="%s" class="brand-logo brand-logo-acf brand-logo-%s" width="%d" height="%d">',
                esc_url($logo_acf['url']),
                esc_attr($alt),
                esc_attr($variante),
                (int)($logo_acf['width']  ?? 280),
                (int)($logo_acf['height'] ?? 86)
            );
            return;
        }
    }

    // 3. File brand nel tema — PNG ufficiale per variante, con fallback SVG
    $variants = [
        'normal'  => ['logo.png',         'logo-fallback.svg',      '4:1', 280, 70],
        'dark'    => ['logo-dark.png',    'logo-dark-fallback.svg', '4:1', 280, 70],
        'compact' => ['logo-compact.png', 'logo-fallback.svg',      '1:1', 80,  80],
    ];
    $cfg = $variants[$variante] ?? $variants['normal'];
    $candidates = [
        ['file' => $cfg[0], 'class_suffix' => 'png'],
        ['file' => $cfg[1], 'class_suffix' => 'svg'],
    ];
    foreach ($candidates as $c) {
        $path = LANOTTE_THEME_DIR . '/assets/img/' . $c['file'];
        if (!file_exists($path)) continue;
        $uri  = LANOTTE_THEME_URI . '/assets/img/' . $c['file'];
        printf(
            '<img src="%s?v=%s" alt="%s" class="brand-logo brand-logo-%s brand-logo-%s" width="%d" height="%d">',
            esc_url($uri),
            esc_attr(filemtime($path)),
            esc_attr(get_bloginfo('name') . ' — Studio Legale'),
            esc_attr($c['class_suffix']),
            esc_attr($variante),
            (int)$cfg[3],
            (int)$cfg[4]
        );
        return;
    }

    // 4. Fallback testuale
    ?>
    <div class="brand-mark">L&amp;</div>
    <div>
      <div class="brand-name"><?php echo esc_html(get_bloginfo('name')); ?><small>Studio Legale</small></div>
    </div>
    <?php
}

/**
 * Restituisce l'URL del logo per uso lato server (PDF, email, schema.org).
 * Usa la stessa catena di fallback di lanotte_brand().
 */
function lanotte_logo_url($variante = 'normal') {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $img = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($img) return $img[0];
    }
    if (function_exists('get_field')) {
        $field = $variante === 'dark' ? 'logo_dark' : ($variante === 'compact' ? 'logo_compact' : 'logo_principale');
        $logo_acf = get_field($field, 'option');
        if ($logo_acf && !empty($logo_acf['url'])) return $logo_acf['url'];
    }
    $variant_files = [
        'normal'  => ['logo.png', 'logo-fallback.svg'],
        'dark'    => ['logo-dark.png', 'logo-dark-fallback.svg'],
        'compact' => ['logo-compact.png', 'logo-fallback.svg'],
    ];
    $files = $variant_files[$variante] ?? $variant_files['normal'];
    foreach ($files as $f) {
        $p = LANOTTE_THEME_DIR . '/assets/img/' . $f;
        if (file_exists($p)) return LANOTTE_THEME_URI . '/assets/img/' . $f;
    }
    return '';
}

/**
 * Breadcrumbs semplice (no plugin)
 */
function lanotte_breadcrumbs() {
    if (is_front_page()) return;
    echo '<div class="breadcrumbs"><a href="' . esc_url(home_url('/')) . '">Home</a>';

    if (is_singular('area')) {
        echo '<span>›</span><a href="' . esc_url(get_post_type_archive_link('area')) . '">Aree di Competenza</a>';
        echo '<span>›</span>' . esc_html(get_the_title());
    } elseif (is_post_type_archive('area')) {
        echo '<span>›</span>Aree di Competenza';
    } elseif (is_singular('post')) {
        echo '<span>›</span><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Rassegna</a>';
        echo '<span>›</span>' . esc_html(get_the_title());
    } elseif (is_home() || is_archive()) {
        echo '<span>›</span>' . esc_html(wp_get_document_title());
    } elseif (is_page()) {
        echo '<span>›</span>' . esc_html(get_the_title());
    } elseif (is_search()) {
        echo '<span>›</span>Risultati ricerca: ' . esc_html(get_search_query());
    } elseif (is_404()) {
        echo '<span>›</span>Pagina non trovata';
    }

    echo '</div>';
}

/**
 * Calcola tempo lettura articolo
 */
function lanotte_reading_time($post_id = null) {
    $content = get_post_field('post_content', $post_id ?: get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $minutes = max(1, ceil($word_count / 220));
    return $minutes . ' min di lettura';
}

/**
 * Pulizia: rimuovi i tag <p> automatici attorno alle immagini negli articoli
 */
add_filter('the_content', function($content) {
    return preg_replace('/<p>(\s*(?:<a [^>]+>)?\s*<img [^>]+>\s*(?:<\/a>)?\s*)<\/p>/i', '<figure>$1</figure>', $content);
});
