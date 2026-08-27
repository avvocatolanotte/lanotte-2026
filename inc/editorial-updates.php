<?php
/**
 * Aggiornamenti editoriali distribuiti insieme al tema.
 */

if (!defined('ABSPATH')) exit;

function lanotte_editorial_import_image($post_id, $asset, $title, $alt, $source_key) {
    $attachments = get_posts([
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_key'       => '_lanotte_source_asset',
        'meta_value'     => $source_key,
    ]);
    $attachment_id = isset($attachments[0]) ? (int) $attachments[0] : 0;

    if (!$attachment_id) {
        $source = LANOTTE_THEME_DIR . '/assets/img/blog/' . $asset;
        if (!is_readable($source)) return false;

        $upload = wp_upload_bits($asset, null, file_get_contents($source));
        if (!empty($upload['error'])) return false;

        $attachment_id = wp_insert_attachment([
            'post_mime_type' => 'image/jpeg',
            'post_title'     => $title,
            'post_content'   => '',
            'post_status'    => 'inherit',
        ], $upload['file'], $post_id, true);
        if (is_wp_error($attachment_id)) return false;

        require_once ABSPATH . 'wp-admin/includes/image.php';
        $metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        if ($metadata) wp_update_attachment_metadata($attachment_id, $metadata);

        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt);
        update_post_meta($attachment_id, '_lanotte_source_asset', $source_key);
    }

    return (int) get_post_thumbnail_id($post_id) === $attachment_id
        || set_post_thumbnail($post_id, $attachment_id);
}

add_action('init', function() {
    if (get_option('lanotte_article_7754_refresh_20260826') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    $post = get_post(7754);
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/fondo-speciale-condominiale-2026.html';
    if (!$post instanceof WP_Post || $post->post_type !== 'post' || !is_readable($content_file)) return;

    $published = current_time('mysql');
    $result = wp_update_post([
        'ID'            => 7754,
        'post_title'    => 'Fondo speciale condominiale: una norma, nove sentenze e la parola «obbligatoriamente»',
        'post_excerpt'  => 'Il fondo speciale per i lavori straordinari è obbligatorio, ma nove decisioni del 2026 divergono su momento, finanziamento e sanatoria. Schema operativo e analisi completa.',
        'post_content'  => file_get_contents($content_file),
        'post_status'   => 'publish',
        'post_date'     => $published,
        'post_date_gmt' => get_gmt_from_date($published),
    ], true);

    if (!is_wp_error($result)) {
        update_option('lanotte_article_7754_refresh_20260826', 'done', false);
    }
}, 24);

add_action('init', function() {
    if (get_option('lanotte_article_7754_featured_20260826') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $updated = lanotte_editorial_import_image(
        7754,
        'fondo-speciale-condominiale-2026.jpg',
        'Fondo speciale condominiale per lavori straordinari',
        'Condominio in ristrutturazione e documenti per il fondo speciale obbligatorio',
        'lanotte-fondo-speciale-condominiale-2026'
    );

    if ($updated) {
        update_option('lanotte_article_7754_featured_20260826', 'done', false);
    }
}, 25);

add_action('init', function() {
    if (get_option('lanotte_article_conto_svuotato_20260827') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'conto-corrente-svuotato-prima-della-morte-rimedi-eredi';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/conto-corrente-svuotato-prima-della-morte.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Conto corrente svuotato prima della morte: cosa possono fare gli eredi',
        'post_name'     => $slug,
        'post_excerpt'  => 'Prelievi, bonifici, deleghe e conti cointestati prima del decesso: documenti da chiedere alla banca e rimedi civili per gli eredi.',
        'post_content'  => file_get_contents($content_file),
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_date'     => $published,
        'post_date_gmt' => get_gmt_from_date($published),
    ];

    if ($post_id) {
        $post_data['ID'] = $post_id;
        $result = wp_update_post($post_data, true);
    } else {
        $result = wp_insert_post($post_data, true);
    }

    if (is_wp_error($result) || !$result) return;

    $post_id = (int) $result;
    $category = get_category_by_slug('successioni');
    if ($category instanceof WP_Term) {
        wp_set_post_categories($post_id, [(int) $category->term_id], false);
    }

    update_option('lanotte_article_conto_svuotato_20260827', 'done', false);
}, 26);

add_action('init', function() {
    if (get_option('lanotte_article_conto_svuotato_featured_20260827') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('conto-corrente-svuotato-prima-della-morte-rimedi-eredi', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'conto-corrente-svuotato-prima-della-morte.jpg',
        'Conto corrente svuotato prima della morte',
        'Documenti bancari e pratica di successione esaminati su una scrivania legale',
        'lanotte-conto-corrente-svuotato-prima-della-morte-2026'
    );

    if ($updated) {
        update_option('lanotte_article_conto_svuotato_featured_20260827', 'done', false);
    }
}, 27);
