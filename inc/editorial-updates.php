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
