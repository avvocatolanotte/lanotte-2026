<?php
/**
 * Bonifica SEO della rassegna: doppioni, slug deboli e redirect 301.
 */

if (!defined('ABSPATH')) exit;

function lanotte_blog_cleanup_redirects() {
    return [
        'richiesta-documentazione-bancaria' => [
            'target_id' => 450,
            'target'    => 'accesso-alla-documentazione-bancaria',
            'reason'    => 'Doppione esatto del contenuto bancario.',
        ],
        'uso-della-cosa-comune-limiti' => [
            'target_id' => 486,
            'target'    => 'luso-della-cosa-comune-parte-ciascun-condomino',
            'reason'    => 'Sovrapposizione forte sul tema art. 1102 c.c.',
        ],
        'come-difendere-i-figli-dalle-guerre-tra-genitori' => [
            'target_id' => 7713,
            'target'    => 'figli-orfani-di-un-padre-vivo',
            'reason'    => 'Cluster alienazione/conflitto genitoriale.',
        ],
        'il-padre-che-non-mantiene-i-figli-deve-risarcire-lex-fonte-il-padre-che-non-mantiene-i-figli-deve-risarcire-lex' => [
            'target_id' => 741,
            'target'    => 'assegno-di-mantenimento-non-pagato-e-reato-cassazione-penale-sez-vi-sentenza-12-12-2018-n-55744',
            'reason'    => 'Slug rotto e articolo troppo debole; destinazione tematica sul mantenimento non pagato.',
        ],
        '434-2' => [
            'target_id' => 434,
            'target'    => 'responsabilita-medica-onere-probatorio-struttura-sanitaria',
            'reason'    => 'Vecchio slug numerico.',
        ],
        '586-2' => [
            'target_id' => 586,
            'target'    => 'nuovi-modelli-deposito-domande-brevetto',
            'reason'    => 'Vecchio slug numerico.',
        ],
    ];
}

function lanotte_blog_cleanup_slug_updates() {
    return [
        434 => 'responsabilita-medica-onere-probatorio-struttura-sanitaria',
        586 => 'nuovi-modelli-deposito-domande-brevetto',
    ];
}

function lanotte_blog_cleanup_draft_sources() {
    return [
        490,  // richiesta-documentazione-bancaria
        448,  // uso-della-cosa-comune-limiti
        7741, // come-difendere-i-figli-dalle-guerre-tra-genitori
        792,  // slug rotto padre/mantenimento
    ];
}

function lanotte_blog_cleanup_target_url($entry) {
    if (!empty($entry['target_id'])) {
        $permalink = get_permalink((int) $entry['target_id']);
        if ($permalink) return $permalink;
    }

    return home_url('/' . trim($entry['target'], '/') . '/');
}

add_action('template_redirect', function() {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $slug = trim(basename(untrailingslashit($path)), '/');
    if (!$slug) return;

    $redirects = lanotte_blog_cleanup_redirects();
    if (!isset($redirects[$slug])) return;

    wp_safe_redirect(lanotte_blog_cleanup_target_url($redirects[$slug]), 301);
    exit;
}, 0);

add_action('init', function() {
    if (get_option('lanotte_blog_cleanup_20260616') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    foreach (lanotte_blog_cleanup_slug_updates() as $post_id => $new_slug) {
        $post = get_post((int) $post_id);
        if (!$post instanceof WP_Post || $post->post_type !== 'post') continue;
        if ($post->post_name === $new_slug) continue;

        wp_update_post([
            'ID'        => (int) $post_id,
            'post_name' => $new_slug,
        ]);
    }

    foreach (lanotte_blog_cleanup_draft_sources() as $post_id) {
        $post = get_post((int) $post_id);
        if (!$post instanceof WP_Post || $post->post_type !== 'post') continue;
        if ($post->post_status !== 'publish') continue;

        wp_update_post([
            'ID'          => (int) $post_id,
            'post_status' => 'draft',
        ]);
    }

    update_option('lanotte_blog_cleanup_20260616', 'done', false);
}, 20);

