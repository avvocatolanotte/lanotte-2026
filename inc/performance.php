<?php
/**
 * Ottimizzazione performance: rimozione bloat legacy + caricamento condizionale.
 *
 * - Rimuove gli asset del vecchio page-builder GoodLayers (non usati dal tema).
 * - Carica gli asset WooCommerce SOLO dove servono (carrello/checkout/account/onorari).
 * - Disabilita lo script emoji di WordPress.
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

/* 1. Rimuovi asset GoodLayers / gdlr (legacy, non usati dal nuovo tema) */
add_action('wp_enqueue_scripts', function () {
    global $wp_styles, $wp_scripts;
    foreach ([$wp_styles, $wp_scripts] as $coll) {
        if (!$coll || empty($coll->registered)) continue;
        foreach ($coll->registered as $handle => $obj) {
            $src = is_object($obj) && isset($obj->src) ? (string) $obj->src : '';
            if (stripos($handle, 'gdlr') !== false || stripos($handle, 'goodlayers') !== false
                || stripos($src, 'goodlayers') !== false || stripos($src, 'gdlr-core') !== false) {
                wp_dequeue_style($handle);
                wp_dequeue_script($handle);
            }
        }
    }
}, 100);

/* 2. WooCommerce: asset solo dove servono */
add_action('wp_enqueue_scripts', function () {
    if (!class_exists('WooCommerce')) return;

    $needs_wc =
        (function_exists('is_woocommerce') && is_woocommerce()) ||
        (function_exists('is_cart')        && is_cart()) ||
        (function_exists('is_checkout')    && is_checkout()) ||
        (function_exists('is_account_page')&& is_account_page()) ||
        is_page(['onorari', 'carrello', 'checkout', 'servizi-online', 'area-pagamenti']);

    if ($needs_wc) return;

    foreach ([
        'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen',
        'wc-blocks-style', 'wc-blocks-vendors-style', 'brands-styles',
    ] as $h) wp_dequeue_style($h);

    foreach ([
        'wc-cart-fragments', 'woocommerce', 'wc-add-to-cart',
        'jquery-blockui', 'js-cookie', 'wc-jquery-ui-touchpunch', 'wc-add-to-cart-variation',
    ] as $h) wp_dequeue_script($h);
}, 99);

/* 3. Disabilita lo script emoji (peso inutile) */
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
});

/* 4. Rimuovi querystring ver dai asset statici per migliore caching (opzionale, soft) */
add_filter('style_loader_src', 'lanotte_keep_ver_static', 15);
add_filter('script_loader_src', 'lanotte_keep_ver_static', 15);
function lanotte_keep_ver_static($src) {
    // Mantiene ?ver per gli asset del tema (cache-busting su update) ma è no-op altrove.
    return $src;
}
