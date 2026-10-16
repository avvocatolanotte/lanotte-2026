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

        // Il tipo si legge dal file: le immagini del blog non sono più solo JPEG (PNG dall'11/10/2026).
        $filetype = wp_check_filetype($upload['file']);
        $attachment_id = wp_insert_attachment([
            'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
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

function lanotte_editorial_get_or_create_category($slug, $name) {
    $category = get_category_by_slug($slug);
    if ($category instanceof WP_Term) return (int) $category->term_id;
    if (!function_exists('wp_insert_term')) return 0;

    $created = wp_insert_term($name, 'category', ['slug' => $slug]);
    if (is_wp_error($created) || empty($created['term_id'])) return 0;

    return (int) $created['term_id'];
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
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

add_action('init', function() {
    if (get_option('lanotte_article_bolletta_elettrica_condominio_20260827') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'bolletta-elettrica-condominiale-ripartizione-spese';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/consumi-elettrici-condominiali-ripartizione.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Bolletta elettrica condominiale: come ripartire consumi, quote fisse e parti comuni',
        'post_name'     => $slug,
        'post_excerpt'  => 'Contatore unico, contatori di sottrazione, quota fissa e consumi comuni: schema pratico per capire quando il rendiconto condominiale è contestabile.',
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
    $category_id = lanotte_editorial_get_or_create_category('comunione-condominio', 'comunione-condominio');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_bolletta_elettrica_condominio_20260827', 'done', false);
}, 28);

add_action('init', function() {
    if (get_option('lanotte_article_bolletta_elettrica_condominio_featured_20260827') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('bolletta-elettrica-condominiale-ripartizione-spese', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'bolletta-elettrica-condominiale-ripartizione.jpg',
        'Bolletta elettrica condominiale e ripartizione delle spese',
        'Schema della ripartizione della bolletta elettrica condominiale tra consumi privati parti comuni e costi fissi',
        'lanotte-bolletta-elettrica-condominiale-ripartizione-2026'
    );

    if ($updated) {
        update_option('lanotte_article_bolletta_elettrica_condominio_featured_20260827', 'done', false);
    }
}, 29);

add_action('init', function() {
    if (get_option('lanotte_article_categories_fix_20260827') === 'done') return;
    if (!function_exists('wp_set_post_categories')) return;

    $successioni_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    $condominio_id = lanotte_editorial_get_or_create_category('comunione-condominio', 'comunione-condominio');

    $conto = get_page_by_path('conto-corrente-svuotato-prima-della-morte-rimedi-eredi', OBJECT, 'post');
    if ($conto instanceof WP_Post && $successioni_id) {
        wp_set_post_categories((int) $conto->ID, [$successioni_id], false);
    }

    $bolletta = get_page_by_path('bolletta-elettrica-condominiale-ripartizione-spese', OBJECT, 'post');
    if ($bolletta instanceof WP_Post && $condominio_id) {
        wp_set_post_categories((int) $bolletta->ID, [$condominio_id], false);
    }

    update_option('lanotte_article_categories_fix_20260827', 'done', false);
}, 30);

add_action('init', function() {
    if (get_option('lanotte_article_bolletta_elettrica_refresh_20260827') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    $post = get_page_by_path('bolletta-elettrica-condominiale-ripartizione-spese', OBJECT, 'post');
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/consumi-elettrici-condominiali-ripartizione.html';
    if (!$post instanceof WP_Post || !is_readable($content_file)) return;

    $result = wp_update_post([
        'ID'           => (int) $post->ID,
        'post_content' => file_get_contents($content_file),
    ], true);

    if (!is_wp_error($result)) {
        update_option('lanotte_article_bolletta_elettrica_refresh_20260827', 'done', false);
    }
}, 31);

add_action('init', function() {
    if (get_option('lanotte_article_imposta_successione_20260828') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'imposta-di-successione-2026-aliquote-franchigie-esempi';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/imposta-successione-2026-aliquote-franchigie-esempi.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Imposta di successione 2026: aliquote, franchigie ed esempi di calcolo',
        'post_name'     => $slug,
        'post_excerpt'  => 'Come calcolare l\'imposta di successione nel 2026: attivo netto, quote, franchigie, aliquote, immobili, agevolazione prima casa ed esempi pratici.',
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_imposta_successione_20260828', 'done', false);
}, 32);

add_action('init', function() {
    if (get_option('lanotte_article_imposta_successione_featured_20260828') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('imposta-di-successione-2026-aliquote-franchigie-esempi', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'imposta-successione-2026-aliquote-franchigie.jpg',
        'Imposta di successione 2026 aliquote franchigie ed esempi',
        'Schema per calcolare imposta di successione 2026 con attivo netto quota erede franchigia aliquota e immobili',
        'lanotte-imposta-successione-2026-aliquote-franchigie'
    );

    if ($updated) {
        update_option('lanotte_article_imposta_successione_featured_20260828', 'done', false);
    }
}, 33);

add_action('init', function() {
    if (get_option('lanotte_article_successione_immobili_20260829') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'successione-con-immobili-imposte-volture-documenti';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/successione-immobili-imposte-volture-documenti.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Successione con immobili: imposte, volture e documenti da controllare',
        'post_name'     => $slug,
        'post_excerpt'  => 'Guida pratica alla successione con immobili: documenti, valore catastale, imposte ipotecaria e catastale, prima casa, volture ed errori da evitare.',
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_successione_immobili_20260829', 'done', false);
}, 34);

add_action('init', function() {
    if (get_option('lanotte_article_successione_immobili_featured_20260829') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('successione-con-immobili-imposte-volture-documenti', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'successione-immobili-imposte-volture-documenti.jpg',
        'Successione con immobili imposte volture e documenti',
        'Schema pratico della successione con immobili tra documenti voltura imposte e agevolazione prima casa',
        'lanotte-successione-immobili-imposte-volture-documenti-2026'
    );

    if ($updated) {
        update_option('lanotte_article_successione_immobili_featured_20260829', 'done', false);
    }
}, 35);

add_action('init', function() {
    if (get_option('lanotte_article_legittima_lesa_20260830') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'quota-legittima-lesa-erede-escluso-rimedi-termini';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/quota-legittima-lesa-erede-escluso-rimedi-termini.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Quota di legittima lesa: rimedi e termini per l\'erede escluso',
        'post_name'     => $slug,
        'post_excerpt'  => 'Figli, coniuge e altri legittimari: come verificare la lesione di legittima, quali documenti raccogliere e quando valutare l\'azione di riduzione.',
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_legittima_lesa_20260830', 'done', false);
}, 36);

add_action('init', function() {
    if (get_option('lanotte_article_legittima_lesa_featured_20260830') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('quota-legittima-lesa-erede-escluso-rimedi-termini', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'quota-legittima-lesa-erede-escluso-rimedi-termini.jpg',
        'Quota di legittima lesa erede escluso rimedi e termini',
        'Schema sulla quota di legittima lesa con testamento donazioni azione di riduzione e termini',
        'lanotte-quota-legittima-lesa-erede-escluso-rimedi-termini-2026'
    );

    if ($updated) {
        update_option('lanotte_article_legittima_lesa_featured_20260830', 'done', false);
    }
}, 37);

add_action('init', function() {
    if (get_option('lanotte_article_eredita_debiti_20260831') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'eredita-con-debiti-beneficio-inventario-rinuncia';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/eredita-con-debiti-beneficio-inventario-rinuncia.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Eredità con debiti: beneficio d\'inventario o rinuncia',
        'post_name'     => $slug,
        'post_excerpt'  => 'Guida pratica per capire cosa fare quando l\'eredità contiene debiti: accettazione pura, beneficio d\'inventario, rinuncia, termini ed errori da evitare.',
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_eredita_debiti_20260831', 'done', false);
}, 38);

add_action('init', function() {
    if (get_option('lanotte_article_eredita_debiti_featured_20260831') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('eredita-con-debiti-beneficio-inventario-rinuncia', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'eredita-con-debiti-beneficio-inventario-rinuncia.jpg',
        'Eredita con debiti beneficio inventario o rinuncia',
        'Schema pratico sull eredita con debiti tra accettazione beneficio d inventario rinuncia e accettazione tacita',
        'lanotte-eredita-con-debiti-beneficio-inventario-rinuncia-2026'
    );

    if ($updated) {
        update_option('lanotte_article_eredita_debiti_featured_20260831', 'done', false);
    }
}, 39);

add_action('init', function() {
    if (get_option('lanotte_article_divisione_ereditaria_20260901') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'divisione-ereditaria-eredi-non-trovano-accordo';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/divisione-ereditaria-eredi-non-accordo.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Divisione ereditaria: cosa fare se gli eredi non trovano un accordo',
        'post_name'     => $slug,
        'post_excerpt'  => 'Guida pratica alla divisione ereditaria: comunione tra coeredi, accordo, mediazione, divisione giudiziale, immobili indivisibili e conguagli.',
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
    $category_id = lanotte_editorial_get_or_create_category('successioni', 'Successioni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_divisione_ereditaria_20260901', 'done', false);
}, 40);

add_action('init', function() {
    if (get_option('lanotte_article_divisione_ereditaria_featured_20260901') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('divisione-ereditaria-eredi-non-trovano-accordo', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'divisione-ereditaria-eredi-non-accordo.jpg',
        'Divisione ereditaria quando gli eredi non trovano accordo',
        'Schema pratico della divisione ereditaria tra comunione accordo mediazione giudice quote e conguaglio',
        'lanotte-divisione-ereditaria-eredi-non-accordo-2026'
    );

    if ($updated) {
        update_option('lanotte_article_divisione_ereditaria_featured_20260901', 'done', false);
    }
}, 41);

add_action('init', function() {
    if (get_option('lanotte_article_adeguamento_istat_mantenimento_20260902') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'mancato-adeguamento-istat-assegno-mantenimento-arretrati';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/mancato-adeguamento-istat-assegno-mantenimento.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Mancato adeguamento ISTAT dell\'assegno di mantenimento: arretrati e recupero',
        'post_name'     => $slug,
        'post_excerpt'  => 'Come verificare il mancato adeguamento ISTAT dell\'assegno di mantenimento, calcolare gli arretrati e chiedere il pagamento delle differenze.',
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
    $category_id = lanotte_editorial_get_or_create_category('diritto-di-famiglia', 'Diritto di famiglia');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_adeguamento_istat_mantenimento_20260902', 'done', false);
}, 42);

add_action('init', function() {
    if (get_option('lanotte_article_adeguamento_istat_mantenimento_featured_20260902') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('mancato-adeguamento-istat-assegno-mantenimento-arretrati', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'mancato-adeguamento-istat-assegno-mantenimento.jpg',
        'Mancato adeguamento ISTAT assegno di mantenimento',
        'Schema pratico su assegno di mantenimento indice FOI ISTAT rivalutazione arretrati e recupero',
        'lanotte-mancato-adeguamento-istat-assegno-mantenimento-2026'
    );

    if ($updated) {
        update_option('lanotte_article_adeguamento_istat_mantenimento_featured_20260902', 'done', false);
    }
}, 43);

add_action('init', function() {
    if (get_option('lanotte_article_danno_biologico_tun_milano_20260903') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'danno-biologico-tun-tabelle-milano-2026';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/danno-biologico-tun-tabelle-milano-2026.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Danno biologico 2026: TUN o Tabelle di Milano?',
        'post_name'     => $slug,
        'post_excerpt'  => 'Come scegliere tra Tabella Unica Nazionale e Tabelle di Milano nel calcolo del danno biologico: data evento, responsabilità, invalidità e personalizzazione.',
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
    $category_id = lanotte_editorial_get_or_create_category('risarcimento-danni', 'Risarcimento danni');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_danno_biologico_tun_milano_20260903', 'done', false);
}, 44);

add_action('init', function() {
    if (get_option('lanotte_article_danno_biologico_tun_milano_featured_20260903') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('danno-biologico-tun-tabelle-milano-2026', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'danno-biologico-tun-tabelle-milano-2026.jpg',
        'Danno biologico 2026 TUN o Tabelle di Milano',
        'Schema pratico per scegliere tra Tabella Unica Nazionale e Tabelle di Milano nel calcolo del danno biologico',
        'lanotte-danno-biologico-tun-tabelle-milano-2026'
    );

    if ($updated) {
        update_option('lanotte_article_danno_biologico_tun_milano_featured_20260903', 'done', false);
    }
}, 45);

add_action('init', function() {
    if (get_option('lanotte_article_impugnare_delibera_condominiale_20260905') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'impugnare-delibera-condominiale-termini-mediazione-nullita';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/impugnare-delibera-condominiale-2026.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Impugnare una delibera condominiale: termini, nullità e mediazione',
        'post_name'     => $slug,
        'post_excerpt'  => 'Guida pratica per capire quando una delibera condominiale è annullabile, quando è nulla, quali sono i termini e perché serve la mediazione.',
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
    $category_id = lanotte_editorial_get_or_create_category('condominio', 'Condominio');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_impugnare_delibera_condominiale_20260905', 'done', false);
}, 46);

add_action('init', function() {
    if (get_option('lanotte_article_impugnare_delibera_condominiale_featured_20260905') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('impugnare-delibera-condominiale-termini-mediazione-nullita', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'impugnare-delibera-condominiale-2026.jpg',
        'Impugnare una delibera condominiale',
        'Schema pratico su termini nullità e mediazione per impugnare una delibera condominiale',
        'lanotte-impugnare-delibera-condominiale-2026'
    );

    if ($updated) {
        update_option('lanotte_article_impugnare_delibera_condominiale_featured_20260905', 'done', false);
    }
}, 47);

add_action('init', function() {
    if (get_option('lanotte_editorial_internal_links_fix_20260915') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    $replacements = [
        'https://studiolegalelanotte.it/fondo-speciale-condominiale-2026/' => 'https://studiolegalelanotte.it/lavori-straordinari-in-condominio-obbligatorio-costituire-il-fondo-speciale/',
        '/aree/risarcimento-danni/' => '/aree/infortunistica-malasanita/',
        '/aree/diritto-di-famiglia/' => '/aree/famiglia-successioni/',
    ];

    $slugs = [
        'impugnare-delibera-condominiale-termini-mediazione-nullita',
        'danno-biologico-tun-tabelle-milano-2026',
        'mancato-adeguamento-istat-assegno-mantenimento-arretrati',
    ];

    foreach ($slugs as $slug) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if (!$post instanceof WP_Post) continue;

        $updated = strtr($post->post_content, $replacements);
        if ($updated === $post->post_content) continue;

        wp_update_post([
            'ID' => (int) $post->ID,
            'post_content' => $updated,
        ]);
    }

    update_option('lanotte_editorial_internal_links_fix_20260915', 'done', false);
}, 48);

add_action('init', function() {
    if (get_option('lanotte_article_opposizione_decreto_ingiuntivo_20260920') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'opposizione-decreto-ingiuntivo-40-giorni-cosa-fare';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/opposizione-decreto-ingiuntivo-40-giorni.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Opposizione a decreto ingiuntivo: 40 giorni per decidere e cosa verificare prima',
        'post_name'     => $slug,
        'post_excerpt'  => 'Da quando si contano i 40 giorni, che cosa succede se scadono, quando il decreto è già esecutivo e le cinque verifiche da fare prima di opporsi, pagare o trattare.',
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
    $category_id = lanotte_editorial_get_or_create_category('diritto-civile', 'Diritto civile');
    if ($category_id) {
        wp_set_post_categories($post_id, [$category_id], false);
    }

    update_option('lanotte_article_opposizione_decreto_ingiuntivo_20260920', 'done', false);
}, 42);

add_action('init', function() {
    if (get_option('lanotte_article_opposizione_decreto_ingiuntivo_featured_20260920') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('opposizione-decreto-ingiuntivo-40-giorni-cosa-fare', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'opposizione-decreto-ingiuntivo-2026.jpg',
        'Opposizione a decreto ingiuntivo: 40 giorni per decidere',
        'Schema in tre passaggi: notifica, quaranta giorni con sospensione feriale, scelta tra opposizione pagamento e accordo',
        'lanotte-opposizione-decreto-ingiuntivo-2026'
    );

    if ($updated) {
        update_option('lanotte_article_opposizione_decreto_ingiuntivo_featured_20260920', 'done', false);
    }
}, 43);

add_action('init', function() {
    if (get_option('lanotte_article_modifica_collocamento_figli_20261009') === 'done') return;
    if (!function_exists('wp_insert_post')) return;

    $slug = 'modifica-collocamento-figli-conflitto-genitoriale-ctu';
    $content_file = LANOTTE_THEME_DIR . '/content/editorials/modifica-collocamento-figli-conflitto-genitoriale-ctu.html';
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    $published = current_time('mysql');
    $post_data = [
        'post_title'    => 'Quando il collocamento dei figli può cambiare: conflitto genitoriale, CTU e bigenitorialità',
        'post_name'     => $slug,
        'post_excerpt'  => 'Affidamento condiviso confermato e collocamento prevalente modificato: un caso seguito dallo Studio su condotte concrete, CTU, bigenitorialità e mantenimento.',
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
    $category_id = lanotte_editorial_get_or_create_category('diritto-di-famiglia', 'Diritto di famiglia');
    if (!$category_id) return;

    $assigned = wp_set_post_categories($post_id, [$category_id], false);
    if (is_wp_error($assigned) || empty($assigned)) return;

    // wp_set_post_categories() restituisce term_taxonomy_id, non term_id.
    $category = get_term($category_id, 'category');
    if (!$category instanceof WP_Term) return;
    if (!in_array((int) $category->term_taxonomy_id, array_map('intval', (array) $assigned), true)) return;

    update_option('lanotte_article_modifica_collocamento_figli_20261009', 'done', false);
}, 49);

add_action('init', function() {
    if (get_option('lanotte_article_modifica_collocamento_figli_featured_20261009') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path('modifica-collocamento-figli-conflitto-genitoriale-ctu', OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    $updated = lanotte_editorial_import_image(
        (int) $post->ID,
        'modifica-collocamento-figli-conflitto-genitoriale-ctu.jpg',
        'Modifica del collocamento dei figli e bigenitorialità',
        'Modifica del collocamento dei figli e tutela della bigenitorialità',
        'lanotte-modifica-collocamento-figli-conflitto-genitoriale-ctu-2026'
    );

    if ($updated) {
        update_option('lanotte_article_modifica_collocamento_figli_featured_20261009', 'done', false);
    }
}, 50);


/**
 * Registra un articolo editoriale del tema (una sola volta).
 * $status 'future' con $date futura programma l'uscita; con data passata WordPress pubblica subito.
 */
/**
 * Esegue $callback una sola volta per $option, anche con richieste simultanee:
 * GET_LOCK di MySQL è atomico (add_option non lo è), e dentro il blocco lo stato
 * «done» si rilegge dal database. Il blocco si rilascia sempre, anche su errore.
 */
function lanotte_editorial_once($option, callable $callback) {
    if (get_option($option) === 'done') return;
    global $wpdb;
    $lock = 'lanotte_ed_' . md5($option);
    $preso = $wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s, 0)', $lock));
    if ($preso === null) {
        // Errore, non contesa: va scritto nel log, altrimenti l'aggiornamento salta in silenzio.
        error_log('lanotte_editorial_once: GET_LOCK non riuscito per ' . $option . ' (' . $wpdb->last_error . ')');
        return;
    }
    if ((int) $preso !== 1) return; // un'altra richiesta sta già lavorando
    try {
        $stato = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", $option));
        if ($wpdb->last_error !== '') {
            // Stato illeggibile: NULL qui non significa «mai fatto». Meglio rinviare che rifare.
            error_log('lanotte_editorial_once: stato illeggibile per ' . $option . ' (' . $wpdb->last_error . ')');
            return;
        }
        if ($stato !== 'done') $callback();
    } finally {
        $wpdb->query($wpdb->prepare('SELECT RELEASE_LOCK(%s)', $lock));
    }
}

function lanotte_editorial_register_article($option, $slug, $title, $excerpt, $content_file, $category_slug, $category_name, $status = 'publish', $date = '') {
    lanotte_editorial_once($option, function() use ($option, $slug, $title, $excerpt, $content_file, $category_slug, $category_name, $status, $date) {
        lanotte_editorial_register_article_now($option, $slug, $title, $excerpt, $content_file, $category_slug, $category_name, $status, $date);
    });
}

function lanotte_editorial_register_article_now($option, $slug, $title, $excerpt, $content_file, $category_slug, $category_name, $status = 'publish', $date = '') {
    $stato = (string) get_option($option);
    if ($stato === 'done' || strpos($stato, 'saltato') === 0) return;
    if (!function_exists('wp_insert_post')) return;

    $content_file = LANOTTE_THEME_DIR . '/content/editorials/' . $content_file;
    if (!is_readable($content_file)) return;

    $existing = get_page_by_path($slug, OBJECT, 'post');
    $post_id = $existing instanceof WP_Post ? (int) $existing->ID : 0;
    // Un articolo con lo stesso slug si aggiorna solo se porta il marcatore di questa registrazione (ripresa dopo
    // un'interruzione); un articolo nato altrove non si tocca e la registrazione diventa «saltato» (revisione di
    // Codex, 11/10/2026). Limite noto: se un articolo creato da qui viene corretto a mano prima che la registrazione
    // arrivi a «done» (es. categoria non assegnata), la ripresa lo riscrive con il file del tema.
    if ($post_id && get_post_meta($post_id, '_lanotte_editoriale', true) !== $option) {
        error_log('lanotte_editorial: «' . $slug . '» esiste già e non è stato creato da ' . $option . ': non lo sovrascrivo.');
        update_option($option, 'saltato: articolo già esistente (' . $post_id . ')', false);
        return;
    }
    $when = $date !== '' ? $date : current_time('mysql');
    $post_data = [
        'post_title'    => $title,
        'post_name'     => $slug,
        'post_excerpt'  => $excerpt,
        'post_content'  => file_get_contents($content_file),
        'post_status'   => $status,
        'post_type'     => 'post',
        'post_author'   => 1,
        'post_date'     => $when,
        'post_date_gmt' => get_gmt_from_date($when),
        'meta_input'    => ['_lanotte_editoriale' => $option],
    ];

    // wp_slash: WordPress toglie le barre rovesciate ai dati che riceve (come nel lotto delle correzioni, B3).
    if ($post_id) {
        $post_data['ID'] = $post_id;
        $result = wp_update_post(wp_slash($post_data), true);
    } else {
        $result = wp_insert_post(wp_slash($post_data), true);
    }

    if (is_wp_error($result) || !$result) return;

    $post_id = (int) $result;
    $category_id = lanotte_editorial_get_or_create_category($category_slug, $category_name);
    if (!$category_id) return;

    $assigned = wp_set_post_categories($post_id, [$category_id], false);
    if (is_wp_error($assigned) || empty($assigned)) return;

    // wp_set_post_categories() restituisce term_taxonomy_id, non term_id.
    $category = get_term($category_id, 'category');
    if (!$category instanceof WP_Term) return;
    if (!in_array((int) $category->term_taxonomy_id, array_map('intval', (array) $assigned), true)) return;

    update_option($option, 'done', false);
}

/**
 * Ogni articolo programmato deve avere nel cron il suo evento di uscita (publish_future_post).
 * Il 16/10/2026 la delibera del 27/10 risultava «done» ma senza evento: le registrazioni della stessa richiesta
 * scrivono l'opzione «cron» una dopo l'altra e una richiesta concorrente può riscriverla con una copia vecchia.
 * Il controllo gira al più ogni 10 minuti e rimette l'evento mancante all'ora di post_date_gmt; se quell'ora è già
 * passata pubblica come avrebbe fatto il cron (check_and_publish_future_post). Ogni intervento va nel log.
 */
function lanotte_editorial_ripara_uscite_programmate() {
    if (get_transient('lanotte_uscite_programmate_controllo')) return;
    set_transient('lanotte_uscite_programmate_controllo', 1, 10 * MINUTE_IN_SECONDS);

    $ids = get_posts([
        'post_type'        => 'post',
        'post_status'      => 'future',
        'fields'           => 'ids',
        'orderby'          => 'date',
        'order'            => 'ASC', // i più vicini per primi: oltre il limite restano fuori i più lontani (Codex, 16/10)
        'posts_per_page'   => 50,
        'no_found_rows'    => true,
        'suppress_filters' => true,
    ]);
    foreach ($ids as $id) {
        $id = (int) $id;
        if (wp_next_scheduled('publish_future_post', [$id]) !== false) continue;
        // Si accetta solo una data reale, riletta identica: strtotime prenderebbe «» per adesso, «0000-00-00» per il
        // passato remoto e «2026-02-30» per il 2 marzo, e l'articolo uscirebbe subito o nel giorno sbagliato (Codex, 16/10).
        $gmt = (string) get_post_field('post_date_gmt', $id);
        $data = DateTime::createFromFormat('!Y-m-d H:i:s', $gmt, new DateTimeZone('UTC'));
        $quando = ($data && $data->format('Y-m-d H:i:s') === $gmt) ? $data->getTimestamp() : false;
        if (!$quando) {
            error_log('lanotte_editorial: articolo ' . $id . ' programmato senza evento e senza data valida: non ripristinato.');
            continue;
        }
        if ($quando <= time()) {
            check_and_publish_future_post($id);
            // Il core non restituisce l'esito: lo stato si rilegge dal database, non dalla cache (Codex, 16/10).
            global $wpdb;
            $stato = $wpdb->get_var($wpdb->prepare("SELECT post_status FROM {$wpdb->posts} WHERE ID = %d", $id));
            error_log('lanotte_editorial: articolo ' . $id . ' programmato per ' . gmdate('Y-m-d H:i', $quando) . ' UTC senza evento e con ora passata: '
                . ($stato === 'publish' ? 'pubblicato ora' : 'pubblicazione NON riuscita, stato «' . $stato . '»'));
            continue;
        }
        $esito = wp_schedule_single_event($quando, 'publish_future_post', [$id], true);
        error_log('lanotte_editorial: evento di uscita mancante per l\'articolo ' . $id . ' (' . gmdate('Y-m-d H:i', $quando) . ' UTC): '
            . (is_wp_error($esito) ? 'NON ripristinato: ' . $esito->get_error_message() : 'ripristinato'));
    }
}
add_action('init', 'lanotte_editorial_ripara_uscite_programmate', 99);

function lanotte_editorial_register_featured($option, $slug, $asset, $title, $alt, $source_key) {
    lanotte_editorial_once($option, function() use ($option, $slug, $asset, $title, $alt, $source_key) {
        lanotte_editorial_register_featured_now($option, $slug, $asset, $title, $alt, $source_key);
    });
}

function lanotte_editorial_register_featured_now($option, $slug, $asset, $title, $alt, $source_key) {
    if (get_option($option) === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $post = get_page_by_path($slug, OBJECT, 'post');
    if (!$post instanceof WP_Post) return;

    if (lanotte_editorial_import_image((int) $post->ID, $asset, $title, $alt, $source_key)) {
        update_option($option, 'done', false);
    }
}

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_impugnare_testamento_20261009',
        'impugnare-testamento-motivi-termini',
        'Quando si può impugnare un testamento e con quali termini?',
        'Quando contestare un testamento per forma, incapacità o inganno. Quali termini si applicano e come tutelare la quota di legittima.',
        'impugnare-testamento-motivi-termini.html',
        'successioni',
        'Successioni'
    );
}, 51);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_impugnare_testamento_featured_20261009',
        'impugnare-testamento-motivi-termini',
        'impugnare-testamento-motivi-termini.jpg',
        'Impugnare un testamento: motivi e termini',
        'Schema in tre punti: difetti di forma, vizi della volontà e lesione della legittima con i relativi termini',
        'lanotte-impugnare-testamento-motivi-termini-2026'
    );
}, 52);

// Uscita programmata: venerdì 23 ottobre 2026 alle 9:00 italiane.
// WordPress qui lavora in UTC (fuso vuoto in Impostazioni): 07:00 UTC = 9:00 CEST.
add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_assegno_divorzile_20261009',
        'assegno-divorzile-criteri-revisione-convivenza',
        'Assegno divorzile: come si stabilisce e quando cambia?',
        'Criteri dell’assegno divorzile, importo e revisione: cosa conta per il giudice e quali effetti hanno nuove nozze e convivenza stabile.',
        'assegno-divorzile-criteri-revisione-convivenza.html',
        'diritto-di-famiglia',
        'Diritto di famiglia',
        'future',
        '2026-10-23 07:00:00'
    );
}, 53);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_assegno_divorzile_featured_20261009',
        'assegno-divorzile-criteri-revisione-convivenza',
        'assegno-divorzile-criteri-revisione-convivenza.jpg',
        'Assegno divorzile: criteri, revisione e convivenza',
        'Schema in tre punti: criteri dell’assegno divorzile, revisione per giustificati motivi e effetti della nuova convivenza',
        'lanotte-assegno-divorzile-criteri-revisione-convivenza-2026'
    );
}, 54);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_verificare_marchio_20261010',
        'come-verificare-marchio-gia-registrato',
        'Come verificare se un marchio è già registrato?',
        'Come cercare un marchio nelle banche dati UIBM, EUIPO, TMview e WIPO. Differenze tra segni identici e simili e limiti della ricerca.',
        'come-verificare-marchio-gia-registrato.html',
        'proprieta-intellettuale',
        'Proprietà intellettuale'
    );
}, 55);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_verificare_marchio_featured_20261010_v4_20261011',
        'come-verificare-marchio-gia-registrato',
        'come-verificare-marchio-gia-registrato-fumetto-v4-2026.jpg',
        'Come verificare se un marchio è già registrato',
        'Fumetto in tre vignette: un creativo disegna il logo su un quaderno, due professionisti controllano con una lente d’ingrandimento una griglia di marchi su uno schermo, poi mostrano il logo al termine della verifica',
        'lanotte-come-verificare-marchio-gia-registrato-2026-fumetto-v4-2026'
    );
}, 56);

// Inizialmente programmata per il 19/10; pubblicata il 10/10 insieme alle guide sul contenzioso
// che vi rimandano (revisione Codex 1, rilievo 5). Sul sito l'opzione risulta già «done».
add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_costo_marchio_20261010',
        'quanto-costa-registrare-marchio',
        'Quanto costa registrare un marchio?',
        'Tasse per registrare un marchio in Italia, nell’UE e all’estero: classi, rinnovi, onorario professionale e possibili costi successivi.',
        'quanto-costa-registrare-marchio.html',
        'proprieta-intellettuale',
        'Proprietà intellettuale'
    );
}, 57);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_costo_marchio_featured_20261010_v4_20261011',
        'quanto-costa-registrare-marchio',
        'quanto-costa-registrare-marchio-fumetto-v4-2026.jpg',
        'Quanto costa registrare un marchio',
        'Fumetto in tre vignette: due professionisti valutano i costi di registrazione di un marchio sopra una mappa dell’Italia con una piccola pila di monete, poi dell’Unione europea con una pila più alta, infine del mondo con la pila più alta',
        'lanotte-quanto-costa-registrare-marchio-2026-fumetto-v4-2026'
    );
}, 58);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_opposizione_marchio_termini_costi_20261010',
        'opposizione-marchio-termini-costi',
        'Opposizione a un marchio: termini, costi e difese',
        'Opposizione UIBM ed EUIPO: termini, costi, conciliazione e difese per chi contesta una domanda di marchio o riceve un’opposizione.',
        'opposizione-marchio-termini-costi.html',
        'proprieta-intellettuale',
        'Proprietà intellettuale'
    );
}, 59);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_opposizione_marchio_termini_costi_featured_20261010_v4_20261011',
        'opposizione-marchio-termini-costi',
        'opposizione-marchio-termini-costi-fumetto-v4-2026.jpg',
        'Opposizione a un marchio: termini, costi e difese',
        'Fumetto in tre vignette: un imprenditore esamina preoccupato una confezione con un segno simile al proprio, una professionista lavora alle carte davanti a un calendario con il termine evidenziato in rosso, infine uno scudo dorato con il marchio davanti alla confezione simile, raffigurata in frantumi',
        'lanotte-opposizione-marchio-termini-costi-2026-fumetto-v4-2026'
    );
}, 60);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_nullita_decadenza_marchio_uibm_20261010',
        'nullita-decadenza-marchio-uibm',
        'Nullità e decadenza del marchio davanti all’UIBM',
        'Nullità e decadenza del marchio davanti all’UIBM: chi può agire, costi, non uso, conciliazione, difese e ricorso alla Commissione.',
        'nullita-decadenza-marchio-uibm.html',
        'proprieta-intellettuale',
        'Proprietà intellettuale'
    );
}, 61);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_nullita_decadenza_marchio_uibm_featured_20261010_v4_20261011',
        'nullita-decadenza-marchio-uibm',
        'nullita-decadenza-marchio-uibm-fumetto-v4-2026.jpg',
        'Nullità e decadenza del marchio davanti all’UIBM',
        'Fumetto in tre vignette: un titolare mostra con orgoglio l’attestato del proprio marchio, una clessidra e un marchio coperto di polvere e ragnatele indicano il non uso, infine in una discussione tra avvocati la tavola con il marchio si sgretola',
        'lanotte-nullita-decadenza-marchio-uibm-2026-fumetto-v4-2026'
    );
}, 62);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_marchio_copiato_cosa_fare_20261010',
        'marchio-copiato-cosa-fare',
        'Marchio copiato: cosa fare',
        'Marchio copiato o diffida ricevuta: raccolta delle prove, misure urgenti e causa. Come valutare i diritti e la competenza del Tribunale di Bari.',
        'marchio-copiato-cosa-fare.html',
        'proprieta-intellettuale',
        'Proprietà intellettuale'
    );
}, 63);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_marchio_copiato_cosa_fare_featured_20261010_v4_20261011',
        'marchio-copiato-cosa-fare',
        'marchio-copiato-cosa-fare-fumetto-v4-2026.jpg',
        'Marchio copiato: cosa fare',
        'Fumetto in tre vignette: un imprenditore scopre in negozio confezioni di profumo che copiano il suo marchio, ne raccoglie le prove fotografandole con lo smartphone insieme a scontrini e pagine web, infine consegna il fascicolo a un’avvocata nel suo studio',
        'lanotte-marchio-copiato-cosa-fare-2026-fumetto-v4-2026'
    );
}, 64);

// Pagina d'area «Proprietà intellettuale» riscritta come pagina del contenzioso marchi
// (10/10/2026). Il seed aggiorna il contenuto di un'area solo se è vuoto o incompleto:
// qui si sostituisce una volta sola. Il sottotitolo sta anche in inc/seed-data.php,
// perché il seed riscrive il campo «tagline» a ogni cambio di versione.
add_action('init', function() {
    lanotte_editorial_once('lanotte_area_proprieta_intellettuale_20261010', 'lanotte_area_proprieta_intellettuale_aggiorna');
}, 65);

function lanotte_area_proprieta_intellettuale_aggiorna() {
    if (!function_exists('wp_update_post')) return;

    $file = LANOTTE_THEME_DIR . '/content/editorials/area-proprieta-intellettuale.html';
    $area = get_page_by_path('proprieta-intellettuale', OBJECT, 'area');
    if (!is_readable($file) || !$area instanceof WP_Post) return;

    $tagline = 'Assistenza nel contenzioso sui marchi e nel deposito, con studio del segno e valutazione del caso.';
    $result = wp_update_post([
        'ID'           => (int) $area->ID,
        'post_content' => file_get_contents($file),
        'post_excerpt' => $tagline,
    ], true);
    if (is_wp_error($result) || !$result) return;

    if (function_exists('update_field')) update_field('tagline', $tagline, (int) $area->ID);
    update_option('lanotte_area_proprieta_intellettuale_20261010', 'done', false);
}

// Data editoriale fissa all'11/10/2026, 07:00 UTC (9:00 italiane), già trascorsa: con una data
// futura WordPress trasformerebbe «publish» in «future» e programmerebbe l'uscita.
add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_registro_morosi_ddl_1896_20261011',
        'registro-inquilini-morosi-riforma-sfratti-ddl-1896',
        'Tempi più difficili per gli inquilini morosi? Registro nazionale e riforma degli sfratti',
        'Il registro degli inquilini morosi è solo un emendamento al DDL S.1896, non votato: stato dell’iter, regole vigenti sullo sfratto e garanzie privacy.',
        'registro-inquilini-morosi-riforma-sfratti-ddl-1896.html',
        'locazioni',
        'Locazioni',
        'publish',
        '2026-10-11 07:00:00'
    );
}, 66);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_registro_morosi_ddl_1896_featured_20261011',
        'registro-inquilini-morosi-riforma-sfratti-ddl-1896',
        'registro-inquilini-morosi-riforma-sfratti-2026.png',
        'Registro degli inquilini morosi e riforma degli sfratti',
        'Illustrazione di un registro chiuso da un lucchetto davanti a un palazzo di giustizia, con un uomo che legge un documento sulla casa e due donne che parlano sulla soglia di uno studio',
        'lanotte-registro-inquilini-morosi-riforma-sfratti-2026'
    );
}, 67);

// Tre articoli di attualità del 13/10/2026 (fonti lette in testo integrale; revisione Codex; sì dell'Avvocato prima del push).
// Uscite programmate alle 9:00 italiane (fuso del sito = UTC, gmt_offset 0): fideiussione 20/10 e riparazione 22/10 (entrata in vigore del D.Lgs. 176/2026) alle 07:00 UTC con l'ora legale;
// delibera 27/10 alle 08:00 UTC, perché l'ora legale finisce il 25/10. Date decise dall'Avvocato il 16/10.
add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_fideiussione_abi_20261013',
        'fideiussione-modulo-abi-nullita-parziale-cassazione-2026',
        'Fideiussione su modulo ABI: quando si può contestare?',
        'Per la Cassazione (ord. 26244/2026) la fideiussione su modulo ABI è di regola nulla soltanto nelle clausole dell’intesa vietata: che cosa deve provare il fideiussore e quali documenti servono.',
        'fideiussione-bancaria-modello-abi-cassazione-2026.html',
        'diritto-bancario',
        'Diritto bancario',
        'future',
        '2026-10-20 07:00:00'
    );
}, 68);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_fideiussione_abi_featured_20261013',
        'fideiussione-modulo-abi-nullita-parziale-cassazione-2026',
        'fideiussione-bancaria-modello-abi-2026.jpg',
        'Fideiussione su modulo ABI: nullità solo parziale',
        'Contratto con penna stilografica su una scrivania di legno, accanto a una cartellina blu e a una pila di estratti conto',
        'lanotte-fideiussione-modulo-abi-2026'
    );
}, 69);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_delibera_revocata_20261013',
        'delibera-condominiale-impugnata-revocata-spese',
        'Delibera condominiale impugnata e poi revocata: chi paga le spese?',
        'Se la delibera impugnata viene sostituita eliminando il vizio iniziale, la causa si chiude per cessata materia del contendere e le spese seguono la soccombenza virtuale (Cass. ord. 25790/2026).',
        'delibera-condominiale-impugnata-revocata-cassazione-2026.html',
        'comunione-condominio',
        'Comunione e condominio',
        'future',
        '2026-10-27 08:00:00'
    );
}, 70);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_delibera_revocata_featured_20261013',
        'delibera-condominiale-impugnata-revocata-spese',
        'delibera-condominiale-revocata-2026.jpg',
        'Delibera condominiale impugnata e poi revocata',
        'Cartellina con un verbale d’assemblea, una penna, un mazzo di chiavi e il plastico di un palazzo residenziale su una scrivania',
        'lanotte-delibera-condominiale-revocata-2026'
    );
}, 71);

add_action('init', function() {
    lanotte_editorial_register_article(
        'lanotte_article_diritto_riparazione_20261013',
        'diritto-alla-riparazione-dlgs-176-2026',
        'Diritto alla riparazione: che cosa cambia per i consumatori dal 22 ottobre 2026',
        'D.Lgs. 176/2026: obbligo di riparazione del fabbricante per lavatrici, frigoriferi, smartphone e altri beni, modulo europeo con prezzo e tempi, dodici mesi in più di garanzia se si sceglie la riparazione.',
        'diritto-alla-riparazione-dlgs-176-2026.html',
        'diritto-civile',
        'Diritto civile',
        'future',
        '2026-10-22 07:00:00'
    );
}, 72);

add_action('init', function() {
    lanotte_editorial_register_featured(
        'lanotte_article_diritto_riparazione_featured_20261013',
        'diritto-alla-riparazione-dlgs-176-2026',
        'diritto-alla-riparazione-2026.jpg',
        'Diritto alla riparazione dei beni',
        'Smartphone aperto su un tappetino blu con cacciaviti di precisione, pinzette e piccole parti di ricambio ordinate',
        'lanotte-diritto-alla-riparazione-2026'
    );
}, 73);
