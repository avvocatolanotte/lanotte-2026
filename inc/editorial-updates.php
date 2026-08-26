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
