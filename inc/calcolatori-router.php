<?php
/**
 * Pretty URL per i calcolatori statici.
 *
 * Espone i file in /calcolatori/*.html come vere route WordPress:
 * /calcolatori/parcella-civile/
 */

if (!defined('ABSPATH')) exit;

function lanotte_calcolatori_map() {
    return [
        'aqp'                  => 'aqp.html',
        'contributo-unificato' => 'contributo-unificato.html',
        'danni-preesistenti'   => 'danni-preesistenti.html',
        'interessi-legali'     => 'interessi-legali.html',
        'interessi-moratori'   => 'interessi-moratori.html',
        'istat-locazione'      => 'istat-locazione.html',
        'macropermanenti'      => 'macropermanenti.html',
        'mantenimento-istat'   => 'mantenimento-istat.html',
        'micropermanenti'      => 'micropermanenti.html',
        'parcella-civile'      => 'parcella-civile.html',
        'parcella-penale'      => 'parcella-penale.html',
        'scadenze'             => 'scadenze.html',
        'sfratti'              => 'sfratti.html',
        'stragiudiziale'       => 'stragiudiziale.html',
        'svalutazione'         => 'svalutazione.html',
        'timeline-marchio'     => 'timeline-marchio.html',
    ];
}

function lanotte_calcolatore_url($slug) {
    return home_url('/calcolatori/' . sanitize_title($slug) . '/');
}

add_action('init', function() {
    add_rewrite_tag('%lanotte_calcolatore%', '([^&]+)');
    add_rewrite_rule('^calcolatori/([^/]+)/?$', 'index.php?lanotte_calcolatore=$matches[1]', 'top');
}, 9);

add_filter('query_vars', function($vars) {
    $vars[] = 'lanotte_calcolatore';
    return $vars;
});

add_action('template_redirect', function() {
    $slug = sanitize_title(get_query_var('lanotte_calcolatore'));
    if (!$slug) return;

    $map = lanotte_calcolatori_map();
    if (!isset($map[$slug])) {
        status_header(404);
        nocache_headers();
        include get_404_template();
        exit;
    }

    $file = LANOTTE_THEME_DIR . '/calcolatori/' . $map[$slug];
    if (!is_readable($file)) {
        status_header(404);
        nocache_headers();
        include get_404_template();
        exit;
    }

    status_header(200);
    header('Content-Type: text/html; charset=UTF-8');
    $html = file_get_contents($file);
    $html = str_replace(
        ['../assets/', './assets/'],
        LANOTTE_THEME_URI . '/assets/',
        $html
    );
    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    exit;
});

add_action('template_redirect', function() {
    $request = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = $request ? wp_parse_url($request, PHP_URL_PATH) : '';
    if (!$path || strpos($path, '/calcolatori/') === false || substr($path, -5) !== '.html') return;

    $slug = sanitize_title(basename($path, '.html'));
    if (isset(lanotte_calcolatori_map()[$slug])) {
        wp_safe_redirect(lanotte_calcolatore_url($slug), 301);
        exit;
    }
}, 1);

add_action('init', function() {
    $key = 'lanotte_calcolatori_rewrite_version';
    if (get_option($key) === LANOTTE_THEME_VERSION) return;
    flush_rewrite_rules(false);
    update_option($key, LANOTTE_THEME_VERSION, false);
}, 20);
