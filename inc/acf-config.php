<?php
/**
 * Configurazione ACF: Options page + cartella di salvataggio dei JSON
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/* ============================================================
   ACF: salva i field group come JSON nel tema (versionabile)
============================================================ */
add_filter('acf/settings/save_json', function($path){
    return LANOTTE_THEME_DIR . '/acf-json';
});
add_filter('acf/settings/load_json', function($paths){
    unset($paths[0]);
    $paths[] = LANOTTE_THEME_DIR . '/acf-json';
    return $paths;
});

/* ============================================================
   ACF: Options Page "Studio Legale"
============================================================ */
add_action('acf/init', function(){
    if (!function_exists('acf_add_options_page')) return;

    acf_add_options_page([
        'page_title'    => 'Impostazioni Studio',
        'menu_title'    => 'Impostazioni Studio',
        'menu_slug'     => 'lanotte-settings',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-admin-customizer',
        'position'      => 3,
        'redirect'      => false,
    ]);

    acf_add_options_sub_page([
        'page_title'    => 'Contatti & Identità',
        'menu_title'    => 'Contatti & Identità',
        'parent_slug'   => 'lanotte-settings',
    ]);
    acf_add_options_sub_page([
        'page_title'    => 'Homepage Sezioni',
        'menu_title'    => 'Homepage Sezioni',
        'parent_slug'   => 'lanotte-settings',
    ]);
    acf_add_options_sub_page([
        'page_title'    => 'Recensioni & Trust',
        'menu_title'    => 'Recensioni & Trust',
        'parent_slug'   => 'lanotte-settings',
    ]);
    acf_add_options_sub_page([
        'page_title'    => 'Branding e immagini',
        'menu_title'    => '🎨 Branding e immagini',
        'parent_slug'   => 'lanotte-settings',
    ]);
});

/* ============================================================
   Avviso se ACF Pro non è attivo (per il cliente)
============================================================ */
add_action('admin_notices', function(){
    if (!function_exists('get_field') && current_user_can('manage_options')) {
        echo '<div class="notice notice-warning"><p>';
        echo '<strong>Tema Lanotte 2026:</strong> ACF Pro non è attivo. Installa e attiva ';
        echo '<a href="https://www.advancedcustomfields.com/pro/" target="_blank">Advanced Custom Fields Pro</a> ';
        echo 'per gestire le sezioni della homepage e i campi delle aree di competenza dal pannello.';
        echo '</p></div>';
    }
});
