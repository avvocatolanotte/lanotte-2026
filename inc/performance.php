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

// Alcuni plugin registrano gli asset dopo wp_enqueue_scripts: seconda pulizia
// prima della stampa, limitata alle pagine che non usano WooCommerce.
add_action('wp_print_styles', 'lanotte_dequeue_nonessential_wc_assets', 999);
add_action('wp_print_footer_scripts', 'lanotte_dequeue_nonessential_wc_assets', 1);
add_action('wp_footer', 'lanotte_dequeue_nonessential_wc_assets', 19);
function lanotte_dequeue_nonessential_wc_assets() {
    if (!class_exists('WooCommerce')) return;

    $needs_wc =
        (function_exists('is_woocommerce') && is_woocommerce()) ||
        (function_exists('is_cart') && is_cart()) ||
        (function_exists('is_checkout') && is_checkout()) ||
        (function_exists('is_account_page') && is_account_page()) ||
        is_page(['onorari', 'carrello', 'checkout', 'servizi-online', 'area-pagamenti']);
    if ($needs_wc) return;

    foreach (['wc-blocks-style', 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen'] as $handle) {
        wp_dequeue_style($handle);
    }
    foreach (['woocommerce', 'wc-cart-fragments', 'wc-add-to-cart', 'sourcebuster-js', 'wc-order-attribution', 'wc-order-attribution-js', 'googlesitekit-events-provider-woocommerce'] as $handle) {
        wp_dequeue_script($handle);
    }
}

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

/* 4. Contact Form 7 e reCAPTCHA solo dove c'è il modulo (26/09/2026)
   Misurato: gli script di Contact Form 7 e di Google reCAPTCHA (api.js più il modulo
   di CF7) si caricavano su tutte le pagine, mentre l'unico modulo è in /contatti/.
   Su ogni altra pagina erano peso inutile e una chiamata a Google non necessaria;
   il badge reCAPTCHA, in più, finiva sotto il tasto WhatsApp della barra mobile. */
add_action('wp_enqueue_scripts', 'lanotte_cf7_solo_contatti', 100);
add_action('wp_print_footer_scripts', 'lanotte_cf7_solo_contatti', 1);
function lanotte_cf7_solo_contatti() {
    if (is_page('contatti')) return;
    foreach (['google-recaptcha', 'wpcf7-recaptcha', 'contact-form-7', 'googlesitekit-events-provider-contact-form-7'] as $h) {
        wp_dequeue_script($h);
    }
    wp_dequeue_style('contact-form-7');
}

/* 5. Immagini incorporate in base64 -> file veri (26/09/2026)
   Misurato: /palazzo-de-noia-terlizzi-in-vendita/ pesava 5,07 MB, di cui il 97% in
   19 immagini incorporate nel testo come data:image;base64. Il browser le riscarica a
   ogni visita (non si possono mettere in cache) e la pagina non si apre su rete lenta.
   Qui, alla prima visualizzazione, ogni immagine incorporata oltre i 20 KB viene
   salvata una volta in wp-content/uploads/lanotte-inline/ (nome = impronta SHA-1 del
   contenuto) e servita da lì. Il contenuto nel database NON viene toccato: togliendo
   questo filtro la pagina torna esattamente com'era. Se un file non si può scrivere,
   quell'immagine resta incorporata: la pagina non si rompe mai. */
add_filter('the_content', 'lanotte_estrai_immagini_incorporate', 20);
function lanotte_estrai_immagini_incorporate($content) {
    if (strpos($content, 'data:image/') === false) return $content;
    $up = wp_upload_dir();
    if (!empty($up['error'])) return $content;
    $dir = trailingslashit($up['basedir']) . 'lanotte-inline';
    $url = trailingslashit($up['baseurl']) . 'lanotte-inline';
    if (!is_dir($dir) && !wp_mkdir_p($dir)) return $content;
    $ext = ['png' => 'png', 'jpeg' => 'jpg', 'jpg' => 'jpg', 'gif' => 'gif', 'webp' => 'webp'];
    return preg_replace_callback(
        '#data:image/(png|jpe?g|gif|webp);base64,([A-Za-z0-9+/=\s]{20000,})#',
        function ($m) use ($dir, $url, $ext) {
            $bin = base64_decode(preg_replace('/\s+/', '', $m[2]), true);
            if ($bin === false || @getimagesizefromstring($bin) === false) return $m[0];
            $name = sha1($bin) . '.' . $ext[strtolower($m[1])];
            $path = $dir . '/' . $name;
            if (!file_exists($path) && @file_put_contents($path, $bin, LOCK_EX) !== strlen($bin)) {
                @unlink($path);
                return $m[0];
            }
            return esc_url($url . '/' . $name);
        },
        $content
    );
}
