<?php
/**
 * Studio Legale Lanotte & Partners — Tema "lanotte-2026"
 *
 * @package lanotte-2026
 * @author  Studio Legale Lanotte & Partners
 */

if (!defined('ABSPATH')) exit;

define('LANOTTE_THEME_VERSION', '1.0.56');
define('LANOTTE_THEME_DIR', get_template_directory());
define('LANOTTE_THEME_URI', get_template_directory_uri());

/* ========================================================================
   SETUP
======================================================================== */

add_action('after_setup_theme', 'lanotte_setup');
function lanotte_setup() {
    load_theme_textdomain('lanotte-2026', LANOTTE_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');

    // Logo personalizzabile da Aspetto → Personalizza → Identità del sito → Logo
    add_theme_support('custom-logo', [
        'height'               => 86,
        'width'                => 280,
        'flex-height'          => true,
        'flex-width'           => true,
        'unlink-homepage-logo' => false,
        'header-text'          => ['site-title', 'site-description'],
    ]);

    // Favicon e icone (oltre al "site icon" nativo WP)
    add_theme_support('site-icon');

    // Image sizes per le aree e per il team
    add_image_size('lanotte-area-icon', 64, 64, true);
    add_image_size('lanotte-partner', 480, 600, true);
    add_image_size('lanotte-hero', 1920, 900, true);
    add_image_size('lanotte-post-thumb', 800, 500, true);

    // Menus
    register_nav_menus([
        'primary'   => __('Menu principale', 'lanotte-2026'),
        'footer-1'  => __('Footer · Aree', 'lanotte-2026'),
        'footer-2'  => __('Footer · Studio', 'lanotte-2026'),
        'footer-3'  => __('Footer · Contatti', 'lanotte-2026'),
        'legal'     => __('Footer · Note legali', 'lanotte-2026'),
    ]);
}

/* ========================================================================
   ASSETS (CSS + Google Fonts)
======================================================================== */

add_action('wp_enqueue_scripts', 'lanotte_enqueue_assets');
function lanotte_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('lanotte-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@300;400;500;600;700&display=swap', [], null);

    // CSS principale con cache-busting su filemtime (forza il refresh ad ogni update)
    $css_path = LANOTTE_THEME_DIR . '/assets/style.css';
    $css_ver  = file_exists($css_path) ? filemtime($css_path) : LANOTTE_THEME_VERSION;
    wp_enqueue_style('lanotte-main', LANOTTE_THEME_URI . '/assets/style.css', [], $css_ver);

    // CSS dinamico con i colori override (da Branding)
    if (function_exists('get_field')) {
        $navy = get_field('color_navy_override', 'option');
        $gold = get_field('color_gold_override', 'option');
        if ($navy || $gold) {
            $css = ':root{';
            if ($navy) $css .= '--navy:' . esc_attr($navy) . ';';
            if ($gold) $css .= '--gold:' . esc_attr($gold) . ';';
            $css .= '}';
            wp_add_inline_style('lanotte-main', $css);
        }
    }

    // Preconnect fonts
    add_filter('wp_resource_hints', function($hints, $type){
        if ('preconnect' === $type) {
            $hints[] = ['href' => 'https://fonts.googleapis.com', 'crossorigin'];
            $hints[] = ['href' => 'https://fonts.gstatic.com',    'crossorigin'];
        }
        return $hints;
    }, 10, 2);
}

/* ========================================================================
   APPLE TOUCH ICON CUSTOM (dal Branding ACF)
======================================================================== */
add_action('wp_head', function(){
    if (function_exists('get_field')) {
        $apple = get_field('apple_touch_icon', 'option');
        if ($apple) {
            echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($apple) . '">' . "\n";
        }
    }
}, 5);

/* ========================================================================
   PARTI MODULARI
======================================================================== */

require_once LANOTTE_THEME_DIR . '/inc/custom-post-types.php';
require_once LANOTTE_THEME_DIR . '/inc/acf-config.php';
require_once LANOTTE_THEME_DIR . '/inc/schema.php';
require_once LANOTTE_THEME_DIR . '/inc/security.php';
require_once LANOTTE_THEME_DIR . '/inc/helpers.php';
require_once LANOTTE_THEME_DIR . '/inc/seed-data.php';
require_once LANOTTE_THEME_DIR . '/inc/istat-cron.php';
require_once LANOTTE_THEME_DIR . '/inc/homepage-builder.php';
require_once LANOTTE_THEME_DIR . '/inc/theme-options.php';
require_once LANOTTE_THEME_DIR . '/inc/shortcodes.php';
require_once LANOTTE_THEME_DIR . '/inc/casi-studio-seed.php';
require_once LANOTTE_THEME_DIR . '/inc/seed-clienti-team.php';
require_once LANOTTE_THEME_DIR . '/inc/seo-meta.php';
require_once LANOTTE_THEME_DIR . '/inc/performance.php';
require_once LANOTTE_THEME_DIR . '/inc/calcolatori-router.php';

/* ========================================================================
   WIDGET AREAS
======================================================================== */

add_action('widgets_init', 'lanotte_widgets_init');
function lanotte_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar Blog', 'lanotte-2026'),
        'id'            => 'blog-sidebar',
        'description'   => __('Sidebar della pagina Rassegna e dei singoli articoli.', 'lanotte-2026'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ]);
}

/* ========================================================================
   EXCERPT
======================================================================== */

add_filter('excerpt_length', function() { return 28; });
add_filter('excerpt_more',   function() { return '…'; });

/* ========================================================================
   BODY CLASS
======================================================================== */

add_filter('body_class', function($classes) {
    if (is_singular('area')) $classes[] = 'area-detail-page';
    return $classes;
});
