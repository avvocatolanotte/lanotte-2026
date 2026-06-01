<?php
/**
 * Hardening WP + Header sicurezza
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/* ============================================================
   Blocco XMLRPC (attack surface ridotta)
============================================================ */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function($headers){
    unset($headers['X-Pingback']);
    return $headers;
});
remove_action('wp_head', 'wp_xmlrpc_pingback');
remove_action('wp_head', 'rsd_link');

/* ============================================================
   Rimuovi WP version footprint
============================================================ */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
add_filter('script_loader_src', 'lanotte_remove_version_strings', 9999);
add_filter('style_loader_src',  'lanotte_remove_version_strings', 9999);
function lanotte_remove_version_strings($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

/* ============================================================
   Rimuovi REST API endpoint user enumeration
============================================================ */
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users']))         unset($endpoints['/wp/v2/users']);
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    return $endpoints;
});

/* ============================================================
   Disabilita user enumeration via ?author=N
============================================================ */
add_action('template_redirect', function() {
    if (!is_admin() && isset($_GET['author']) && is_numeric($_GET['author'])) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
});

/* ============================================================
   Security headers (se non già impostati via Cloudflare)
============================================================ */
add_action('send_headers', function(){
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()');
        // HSTS solo se sicuri che tutto sia HTTPS
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
});

/* ============================================================
   Rimuovi info utili agli attaccanti dai messaggi di errore login
============================================================ */
add_filter('login_errors', function() {
    return 'Credenziali non valide.';
});

/* ============================================================
   Limita tentativi di login (semplice rate-limit)
   Per protezione completa usare un plugin tipo Wordfence o Limit Login Attempts
============================================================ */
add_action('wp_login_failed', function($username) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!$ip) return;
    $key = 'login_fail_' . md5($ip);
    $count = (int) get_transient($key);
    set_transient($key, $count + 1, MINUTE_IN_SECONDS * 15);
    if ($count >= 5) {
        wp_die('Troppi tentativi di login. Riprova fra 15 minuti.', 'Bloccato', ['response' => 429]);
    }
});

/* ============================================================
   Disabilita editor file dal pannello admin
============================================================ */
if (!defined('DISALLOW_FILE_EDIT')) define('DISALLOW_FILE_EDIT', true);
