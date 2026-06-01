<?php
/**
 * Custom Post Type: Area di Competenza
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

add_action('init', 'lanotte_register_area_cpt');
function lanotte_register_area_cpt() {
    $labels = [
        'name'                  => 'Aree di Competenza',
        'singular_name'         => 'Area di Competenza',
        'menu_name'             => 'Aree',
        'name_admin_bar'        => 'Area',
        'add_new'               => 'Aggiungi nuova',
        'add_new_item'          => 'Aggiungi nuova Area',
        'new_item'              => 'Nuova Area',
        'edit_item'             => 'Modifica Area',
        'view_item'             => 'Visualizza Area',
        'all_items'             => 'Tutte le Aree',
        'search_items'          => 'Cerca Aree',
        'not_found'             => 'Nessuna area trovata.',
        'not_found_in_trash'    => 'Nessuna area nel cestino.',
        'featured_image'        => 'Immagine in evidenza',
        'set_featured_image'    => 'Imposta immagine in evidenza',
        'archives'              => 'Tutte le Aree di Competenza',
    ];

    register_post_type('area', [
        'labels'             => $labels,
        'description'        => 'Aree di competenza dello Studio Legale Lanotte',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true, // Gutenberg
        'query_var'          => true,
        'rewrite'            => ['slug' => 'aree', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => 'aree',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'],
        'taxonomies'         => [],
    ]);
}

/* ============================================================
   Tassonomia opzionale: Categoria di Area
============================================================ */
add_action('init', 'lanotte_register_area_taxonomy');
function lanotte_register_area_taxonomy() {
    register_taxonomy('area_category', 'area', [
        'labels' => [
            'name' => 'Categorie Aree',
            'singular_name' => 'Categoria',
            'menu_name' => 'Categorie',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);
}

/* ============================================================
   Colonna admin: ordine + categoria
============================================================ */
add_filter('manage_area_posts_columns', function($cols){
    $new = [];
    foreach ($cols as $k => $v) {
        $new[$k] = $v;
        if ($k === 'title') {
            $new['area_order']    = 'Ordine';
            $new['area_category'] = 'Categoria';
        }
    }
    return $new;
});

add_action('manage_area_posts_custom_column', function($col, $post_id){
    if ($col === 'area_order') {
        echo (int) get_post_field('menu_order', $post_id);
    } elseif ($col === 'area_category') {
        $terms = get_the_terms($post_id, 'area_category');
        if ($terms && !is_wp_error($terms)) {
            echo esc_html(implode(', ', wp_list_pluck($terms, 'name')));
        }
    }
}, 10, 2);

add_filter('manage_edit-area_sortable_columns', function($cols){
    $cols['area_order'] = 'menu_order';
    return $cols;
});

/* ============================================================
   Ordine default in archive: per menu_order ASC
============================================================ */
add_action('pre_get_posts', function($q){
    if (!is_admin() && $q->is_main_query() && (is_post_type_archive('area') || $q->is_tax('area_category'))) {
        $q->set('orderby', 'menu_order');
        $q->set('order',   'ASC');
        $q->set('posts_per_page', 24);
    }
});

/* ============================================================
   CPT: TEAM / PROFESSIONISTI
============================================================ */
add_action('init', 'lanotte_register_team_cpt');
function lanotte_register_team_cpt() {
    register_post_type('team', [
        'labels' => [
            'name'               => 'Professionisti',
            'singular_name'      => 'Professionista',
            'menu_name'          => 'Professionisti',
            'add_new'            => 'Aggiungi nuovo',
            'add_new_item'       => 'Aggiungi nuovo Professionista',
            'new_item'           => 'Nuovo Professionista',
            'edit_item'          => 'Modifica Professionista',
            'view_item'          => 'Visualizza Professionista',
            'all_items'          => 'Tutti i Professionisti',
            'search_items'       => 'Cerca Professionisti',
            'not_found'          => 'Nessun professionista trovato.',
            'not_found_in_trash' => 'Nessun professionista nel cestino.',
            'featured_image'     => 'Foto professionista',
            'set_featured_image' => 'Imposta foto',
        ],
        'description'        => 'Avvocati e professionisti dello Studio (titolare, partner esterni, of counsel, praticanti).',
        'public'             => true,
        'publicly_queryable' => false,    // non hanno pagine singole indicizzate
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
    ]);
}

/* ============================================================
   CPT: CLIENTI ISTITUZIONALI
============================================================ */
add_action('init', 'lanotte_register_cliente_cpt');
function lanotte_register_cliente_cpt() {
    register_post_type('cliente', [
        'labels' => [
            'name'               => 'Clienti',
            'singular_name'      => 'Cliente',
            'menu_name'          => 'Clienti',
            'add_new'            => 'Aggiungi nuovo',
            'add_new_item'       => 'Aggiungi nuovo Cliente',
            'new_item'           => 'Nuovo Cliente',
            'edit_item'          => 'Modifica Cliente',
            'view_item'          => 'Visualizza Cliente',
            'all_items'          => 'Tutti i Clienti',
            'search_items'       => 'Cerca Clienti',
            'not_found'          => 'Nessun cliente trovato.',
            'not_found_in_trash' => 'Nessun cliente nel cestino.',
            'featured_image'     => 'Logo cliente',
            'set_featured_image' => 'Imposta logo',
        ],
        'description'        => 'Clienti istituzionali e sponsor dello Studio (loghi in homepage).',
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
    ]);
}

/* ============================================================
   CPT: SERVIZI ONLINE
============================================================ */
add_action('init', 'lanotte_register_servizio_cpt');
function lanotte_register_servizio_cpt() {
    register_post_type('servizio', [
        'labels' => [
            'name'               => 'Servizi online',
            'singular_name'      => 'Servizio',
            'menu_name'          => 'Servizi online',
            'add_new'            => 'Aggiungi nuovo',
            'add_new_item'       => 'Aggiungi nuovo Servizio',
            'new_item'           => 'Nuovo Servizio',
            'edit_item'          => 'Modifica Servizio',
            'view_item'          => 'Visualizza Servizio',
            'all_items'          => 'Tutti i Servizi',
            'search_items'       => 'Cerca Servizi',
            'not_found'          => 'Nessun servizio trovato.',
            'not_found_in_trash' => 'Nessun servizio nel cestino.',
        ],
        'description'        => 'Catalogo dei servizi online a richiesta preventivo (ex art. 13 L. 247/2012).',
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-cart',
        'supports'           => ['title', 'editor', 'page-attributes'],
    ]);

    /* ============================================================
       CPT: Calcolatore (le 14 card del hub /calcolatori/)
    ============================================================ */
    register_post_type('calcolatore', [
        'labels' => [
            'name'               => 'Calcolatori',
            'singular_name'      => 'Calcolatore',
            'menu_name'          => 'Calcolatori',
            'add_new'            => 'Aggiungi nuovo',
            'add_new_item'       => 'Nuovo Calcolatore',
            'edit_item'          => 'Modifica Calcolatore',
            'all_items'          => 'Tutti i Calcolatori',
            'search_items'       => 'Cerca Calcolatori',
        ],
        'description'        => 'Card cliccabili nell\'hub /calcolatori/ — link agli strumenti HTML statici nel tema.',
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'hierarchical'       => false,
        'menu_position'      => 9,
        'menu_icon'          => 'dashicons-calculator',
        'supports'           => ['title', 'editor', 'page-attributes'],
    ]);

    /* ============================================================
       CPT: Caso (Scenari illustrativi — casi studio anonimizzati)
    ============================================================ */
    register_post_type('caso', [
        'labels' => [
            'name'               => 'Casi Studio',
            'singular_name'      => 'Caso Studio',
            'menu_name'          => 'Casi Studio',
            'add_new'            => 'Aggiungi nuovo',
            'add_new_item'       => 'Nuovo Scenario Illustrativo',
            'edit_item'          => 'Modifica Scenario',
            'all_items'          => 'Tutti i Casi Studio',
            'search_items'       => 'Cerca Casi Studio',
        ],
        'description'        => 'Scenari illustrativi (casi immaginari) che mostrano il metodo dello Studio. NON sono casi reali.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => 'casi-studio',
        'rewrite'            => ['slug' => 'casi-studio', 'with_front' => false],
        'hierarchical'       => false,
        'menu_position'      => 10,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'excerpt', 'page-attributes'],
    ]);
}

/* ============================================================
   Tassonomia: Area del Caso Studio (collega caso → area di pratica)
============================================================ */
add_action('init', function() {
    register_taxonomy('caso_area', 'caso', [
        'labels' => [
            'name'          => 'Aree (casi studio)',
            'singular_name' => 'Area',
            'menu_name'     => 'Aree',
        ],
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => ['slug' => 'casi-studio-area'],
        'show_in_rest'      => true,
    ]);
});

/* ============================================================
   Tassonomia: Categoria Calcolatore
============================================================ */
add_action('init', function() {
    register_taxonomy('calcolatore_categoria', 'calcolatore', [
        'labels' => [
            'name'          => 'Categorie calcolatori',
            'singular_name' => 'Categoria',
            'menu_name'     => 'Categorie',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);
});

/* ============================================================
   Tassonomia: Categoria Servizio (collega ai filtri)
============================================================ */
add_action('init', function() {
    register_taxonomy('servizio_categoria', 'servizio', [
        'labels' => [
            'name'          => 'Categorie servizi',
            'singular_name' => 'Categoria',
            'menu_name'     => 'Categorie',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);
});

/* ============================================================
   Ordinamento default per i 3 nuovi CPT (menu_order ASC)
============================================================ */
add_action('pre_get_posts', function($q){
    if (is_admin() && $q->is_main_query()) {
        $screen_post_type = $q->get('post_type');
        if (in_array($screen_post_type, ['team', 'cliente', 'servizio'], true)) {
            $q->set('orderby', 'menu_order');
            $q->set('order', 'ASC');
        }
    }
});

/* ============================================================
   Colonna admin: ordine + foto/logo per Team e Clienti
============================================================ */
foreach (['team', 'cliente'] as $cpt_thumb) {
    add_filter("manage_{$cpt_thumb}_posts_columns", function($cols){
        $new = ['cb' => $cols['cb'], 'lanotte_thumb' => 'Foto'];
        foreach ($cols as $k => $v) {
            if ($k !== 'cb') $new[$k] = $v;
        }
        $new['lanotte_order'] = 'Ordine';
        return $new;
    });
    add_action("manage_{$cpt_thumb}_posts_custom_column", function($col, $post_id){
        if ($col === 'lanotte_thumb' && has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, [60, 60], ['style' => 'border-radius:4px;object-fit:cover']);
        } elseif ($col === 'lanotte_order') {
            echo (int) get_post_field('menu_order', $post_id);
        }
    }, 10, 2);
}
