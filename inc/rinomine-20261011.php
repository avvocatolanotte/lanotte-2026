<?php
/**
 * Rinomine dell'11/10/2026 (decisioni dell'Avvocato): slug di due tag il cui nome citava una sentenza sbagliata e
 * slug dell'autore, che riproduceva l'indirizzo Gmail. I vecchi indirizzi sono reindirizzati da inc/blog-cleanup.php.
 *
 * Una volta sola (lanotte_editorial_once). «done» solo se ogni voce risulta, riletta dal database, con lo slug nuovo;
 * altrimenti si ritenta alla richiesta successiva e dopo tre tentativi lo stato diventa «errori» e si ferma.
 * L'esito voce per voce resta in lanotte_rinomine_20261011_esito. Idempotente: una voce già rinominata vale «ok».
 */

if (!defined('ABSPATH')) exit;

function lanotte_rinomine_20261011_esegui() {
    $opt = 'lanotte_rinomine_20261011';
    if (get_option($opt) === 'errori') return;
    $esiti = [];

    $tag = [
        209 => ['sentenza-n-9388-del-2022', 'ordinanza-n-9388-del-2023'],
        202 => ['sentenza-n-6532-del-2025', 'cass-ord-n-1486-del-2025'],
    ];
    foreach ($tag as $id => $slug) {
        list($da, $a) = $slug;
        $t = get_term($id, 'post_tag');
        if (!$t instanceof WP_Term) { $esiti["tag $id"] = 'tag non trovato'; continue; }
        if ($t->slug === $da) {
            $r = wp_update_term($id, 'post_tag', ['slug' => $a]);
            if (is_wp_error($r)) { $esiti["tag $id"] = 'errore: ' . $r->get_error_message(); continue; }
            clean_term_cache($id, 'post_tag');
            $t = get_term($id, 'post_tag');
        }
        $esiti["tag $id"] = ($t instanceof WP_Term && $t->slug === $a) ? 'ok' : 'slug inatteso: ' . ($t instanceof WP_Term ? $t->slug : '?');
    }

    // L'autore si identifica per ID (1: l'Avvocato, autore degli articoli; verificato l'11/10/2026 dallo schema
    // pubblico degli articoli con author=1), anche quando lo slug risulta già cambiato: così un altro utente con lo
    // slug nuovo non può far risultare «ok» una rinomina mai avvenuta (rilievo di Codex, tornata 9).
    $id_autore = 1;
    $da = 'avvocatolanottegmail-com';
    $a  = 'giuseppe-lanotte';
    $u  = get_user_by('id', $id_autore);
    if (!$u) {
        $esiti['autore'] = 'utente ' . $id_autore . ' non trovato';
    } elseif ($u->user_nicename === $a) {
        $esiti['autore'] = 'ok';
    } elseif ($u->user_nicename !== $da) {
        $esiti['autore'] = 'slug inatteso: ' . $u->user_nicename;
    } else {
        $occupato = get_user_by('slug', $a);
        if ($occupato && (int) $occupato->ID !== $id_autore) {
            $esiti['autore'] = 'slug nuovo già usato dall\'utente ' . (int) $occupato->ID;
        } else {
            // Solo lo slug pubblico: nome utente, email e password non si toccano.
            $r = wp_update_user(['ID' => $id_autore, 'user_nicename' => $a]);
            clean_user_cache($id_autore);
            $v = get_user_by('id', $id_autore);
            $esiti['autore'] = (!is_wp_error($r) && $v && $v->user_nicename === $a)
                ? 'ok' : 'non riuscito' . (is_wp_error($r) ? ': ' . $r->get_error_message() : '');
        }
    }

    update_option($opt . '_esito', $esiti, false);
    $tutte = count($esiti) === 3 && count(array_filter($esiti, function ($e) { return $e === 'ok'; })) === 3;
    if ($tutte) { update_option($opt, 'done', false); return; }
    $tentativi = (int) get_option($opt . '_tentativi', 0) + 1;
    update_option($opt . '_tentativi', $tentativi, false);
    if ($tentativi >= 3) update_option($opt, 'errori', false);
    error_log('lanotte rinomine 20261011: tentativo ' . $tentativi . ' non riuscito: ' . wp_json_encode($esiti));
}

add_action('init', function () {
    if (!function_exists('lanotte_editorial_once')) return;
    lanotte_editorial_once('lanotte_rinomine_20261011', 'lanotte_rinomine_20261011_esegui');
}, 71);
