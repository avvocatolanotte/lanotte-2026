<?php
/**
 * Seed dei Clienti istituzionali e del Team dentro i rispettivi CPT.
 *
 * OBIETTIVO: rendere i contenuti "vecchi" (prima hardcoded come fallback)
 * dei post VERI ed editabili/eliminabili dalla bacheca WordPress.
 *
 * Il logo/foto iniziale è salvato come post meta (URL asset del tema).
 * Il rendering preferisce: campo ACF 'logo'/foto → immagine in evidenza →
 * meta URL seedato. Così l'avvocato può sostituire l'immagine da WP.
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

/* === CLIENTI === */
function lanotte_clienti_data() {
    $base = LANOTTE_THEME_URI . '/assets/img/clienti/';
    return [
        ['title' => 'ITF — International Taekwon-Do Federation', 'logo' => $base . 'itf-mondiale.svg', 'url' => 'https://itf-tkd.org/', 'desc' => 'ITF — International Taekwon-Do Federation (Vienna)'],
        ['title' => 'Taekwondo ITF Italia — Fitsport', 'logo' => $base . 'taekwondo-itf.jpg', 'url' => '', 'desc' => 'Taekwondo ITF Italia · Fitsport'],
        ['title' => 'FQ Quinto', 'logo' => $base . 'fq-quinto.png', 'url' => '', 'desc' => 'FQ Quinto'],
        ['title' => 'S.S.D. Federico II di Svevia', 'logo' => $base . 'federico-gym.svg', 'url' => '', 'desc' => 'S.S.D. Federico II di Svevia — Centro Sportivo'],
        ['title' => 'Condominiocasa.it', 'logo' => $base . 'condominiocasa.jpg', 'url' => 'https://www.condominiocasa.it/', 'desc' => 'Condominiocasa.it · Amministrazione Condomini e Immobili'],
        ['title' => 'Puglia Fideiussioni', 'logo' => $base . 'puglia-fideiussioni.jpg', 'url' => '', 'desc' => 'Puglia Fideiussioni'],
        ['title' => 'Prenota in Puglia', 'logo' => $base . 'prenota-in-puglia.png', 'url' => '', 'desc' => 'Prenota in Puglia'],
    ];
}

function lanotte_seed_clienti() {
    if (!post_type_exists('cliente')) return 0;
    // Seed solo se il CPT è completamente vuoto (non sovrascrive scelte dell'utente)
    $existing = get_posts(['post_type' => 'cliente', 'numberposts' => 1, 'post_status' => 'any', 'fields' => 'ids']);
    if (!empty($existing)) return 0;
    $count = 0;
    foreach (lanotte_clienti_data() as $i => $c) {
        $id = wp_insert_post([
            'post_type'   => 'cliente',
            'post_status' => 'publish',
            'post_title'  => $c['title'],
            'post_excerpt'=> $c['desc'],
            'menu_order'  => $i + 1,
        ]);
        if (is_wp_error($id) || !$id) continue;
        update_post_meta($id, '_lanotte_logo_url', $c['logo']);
        if ($c['url']) update_post_meta($id, '_lanotte_url', $c['url']);
        $count++;
    }
    return $count;
}

/* === TEAM / PROFESSIONISTI === */
function lanotte_team_data() {
    $base = LANOTTE_THEME_URI . '/assets/img/';
    return [
        ['title' => 'Giuseppe Lanotte', 'titolo' => 'Avv.', 'ruolo' => 'titolare', 'foto' => $base . 'giuseppe-lanotte.jpg',
         'spec' => 'Civile · Penale · Tributario · Proprietà industriale',
         'bio' => 'Iscritto all\'Albo degli Avvocati di Trani dal 2011. Attività multidisciplinare con esperienza in diritto penale, civile, commerciale e proprietà industriale (marchi, brevetti, design davanti a UIBM, EUIPO, OMPI). Per il giudizio di Cassazione si avvale di colleghi cassazionisti.',
         'email' => 'info@studiolegalelanotte.it'],
        ['title' => 'Ruggiero Lanotte', 'titolo' => 'Dott.', 'ruolo' => 'commercialista', 'foto' => $base . 'ruggiero-lanotte.jpg',
         'spec' => 'Consulente fiscale · Terzo Settore',
         'bio' => 'Dottore commercialista in collaborazione esterna. Affianca lo Studio nelle consulenze fiscali e tributarie, nella predisposizione del bilancio, nella valutazione d\'azienda e nelle perizie asseverative utili al contenzioso bancario e tributario.',
         'email' => ''],
        ['title' => 'Cristina De Lillo', 'titolo' => 'Dott.ssa', 'ruolo' => 'partner-esterno', 'foto' => $base . 'cristina-de-lillo.jpg',
         'spec' => 'Diritto e amministrazione condominiale',
         'bio' => 'In collaborazione esterna con lo Studio. Si occupa di amministrazione condominiale e gestione immobiliare e dei relativi contenziosi: impugnazione delibere, riparto spese, recupero crediti condominiali, revisione dei rendiconti.',
         'email' => ''],
    ];
}

function lanotte_seed_team() {
    if (!post_type_exists('team')) return 0;
    $existing = get_posts(['post_type' => 'team', 'numberposts' => 1, 'post_status' => 'any', 'fields' => 'ids']);
    if (!empty($existing)) return 0;
    $count = 0;
    foreach (lanotte_team_data() as $i => $t) {
        $id = wp_insert_post([
            'post_type'   => 'team',
            'post_status' => 'publish',
            'post_title'  => $t['title'],
            'post_excerpt'=> $t['spec'],
            'menu_order'  => $i + 1,
        ]);
        if (is_wp_error($id) || !$id) continue;
        update_post_meta($id, '_lanotte_photo_url', $t['foto']);
        update_post_meta($id, '_lanotte_titolo', $t['titolo']);
        update_post_meta($id, '_lanotte_ruolo', $t['ruolo']);
        update_post_meta($id, '_lanotte_spec', $t['spec']);
        update_post_meta($id, '_lanotte_bio', $t['bio']);
        if ($t['email']) update_post_meta($id, '_lanotte_email', $t['email']);
        update_post_meta($id, 'visibile', '1'); // compat con query esistenti
        $count++;
    }
    return $count;
}

/* === HELPER RENDERING (priorità: ACF → featured image → meta seedato) === */
function lanotte_cliente_logo($post_id) {
    if (function_exists('get_field')) {
        $l = get_field('logo', $post_id);
        if ($l) return is_array($l) ? ($l['url'] ?? '') : $l;
    }
    if (has_post_thumbnail($post_id)) return get_the_post_thumbnail_url($post_id, 'medium');
    return get_post_meta($post_id, '_lanotte_logo_url', true);
}
function lanotte_cliente_url($post_id) {
    if (function_exists('get_field')) { $u = get_field('url', $post_id); if ($u) return $u; }
    return get_post_meta($post_id, '_lanotte_url', true);
}
function lanotte_team_foto($post_id) {
    if (has_post_thumbnail($post_id)) return get_the_post_thumbnail_url($post_id, 'medium_large');
    if (function_exists('get_field')) { $f = get_field('foto', $post_id); if ($f) return is_array($f) ? ($f['url'] ?? '') : $f; }
    return get_post_meta($post_id, '_lanotte_photo_url', true);
}
function lanotte_team_meta($post_id, $key, $acf_key = null) {
    $m = get_post_meta($post_id, '_lanotte_' . $key, true);
    if ($m) return $m;
    if (function_exists('get_field') && $acf_key) { $v = get_field($acf_key, $post_id); if ($v) return $v; }
    return '';
}
