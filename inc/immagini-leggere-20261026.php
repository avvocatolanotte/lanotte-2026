<?php
/**
 * Immagini in evidenza leggere per cinque articoli (26/10/2026, punto 6 del restyling: peso).
 *
 * Problema misurato il 26/10/2026: cinque articoli hanno come immagine in evidenza un PNG opaco da 2,2 a 3,2 MB, senza il
 * formato lanotte-post-thumb. La scheda dell'articolo (template-parts/post-card.php) ripiega così sull'originale, e
 * l'apertura (single.php, formato full) lo usa intero. WPVibe non rigenera i formati delle immagini.
 *
 * Rimedio, con lo stesso metodo di immagini-evidenza-20261011.php: ogni articolo riceve un allegato nuovo, importato da
 * assets/img/blog/. È lo stesso disegno in JPEG (qualità 90, 4:4:4, stessa misura in pixel, scarto oltre 16/255 su meno
 * dell'1% dei pixel), e WordPress ne genera i formati. I PNG restano nella libreria: nulla si cancella. L'immagine in
 * evidenza precedente si annota in lanotte_immagini_leggere_20261026_precedenti per tornare indietro. Se nel frattempo
 * qualcuno ha scelto un'altra immagine, l'articolo non si tocca. Il PNG dentro il testo degli articoli 7993 e 8004 si
 * sostituisce a parte, come amministratore, perché i salvataggi anonimi passano da kses.
 *
 * Una volta sola (lanotte_editorial_once). «done» solo se ogni articolo, riletto, ha l'immagine nuova con il formato
 * lanotte-post-thumb generato e il suo file presente, un testo alternativo non vuoto, un URL che AIOSEO non taglia e, se
 * AIOSEO è attivo, la nuova immagine fra quelle che AIOSEO ha registrato. Altrimenti si ritenta alla richiesta successiva;
 * dopo tre tentativi lo stato diventa «errori» e si ferma. Esito voce per voce in lanotte_immagini_leggere_20261026_esito.
 * Testi, slug, date, categorie e canonical degli articoli non si toccano.
 */

if (!defined('ABSPATH')) exit;

/**
 * Articolo (slug) → immagine del tema, nome del file caricato, titolo e testo alternativo dell'allegato, ID dell'immagine
 * in evidenza attesa prima del cambio. Titoli = titoli degli articoli; testi alternativi di 7991 e 8005 = quelli già
 * pubblicati nel testo degli articoli.
 */
function lanotte_leggere_20261026_voci() {
    return [
        'crisi-dimpresa-studio-lanotte-ottiene-la-revoca-della-liquidazione-giudiziale' => [
            'asset'     => 'crisi-impresa-revoca-liquidazione-giudiziale.jpg',
            'nome_file' => 'crisi-impresa-revoca-liquidazione-giudiziale.jpg',
            'titolo'    => 'Crisi d’impresa: Studio LANOTTE ottiene la revoca della liquidazione giudiziale',
            'alt'       => 'Bilancia della giustizia su un tavolo in un’aula di tribunale, con la scritta «Grande successo in Corte d’Appello»',
            'vecchio'   => 7946,
        ],
        'palazzo-de-noia-terlizzi-in-vendita' => [
            'asset'     => 'palazzo-de-noia-terlizzi.jpg',
            'nome_file' => 'palazzo-de-noia-terlizzi.jpg',
            'titolo'    => 'Palazzo De Noia — Terlizzi in Vendita',
            'alt'       => 'Palazzo storico in pietra con balconi e ringhiere metalliche, fotografato di notte all’angolo di due strade',
            'vecchio'   => 7964,
        ],
        'prima-arrestipoi-capisci-lerroree-ti-scusi' => [
            'asset'     => 'arresto-errore-indagine-archiviata.jpg',
            'nome_file' => 'arresto-errore-indagine-archiviata.jpg',
            'titolo'    => 'Prima arresti, poi capisci l’errore e ti scusi?',
            'alt'       => 'Fumetto: un funzionario arrestato viene ascoltato dal giudice; nell’ultima vignetta mostra un documento con la scritta «Indagine archiviata»',
            'vecchio'   => 7981,
        ],
        'trattenere-tuo-figlio-puo-essere-reato' => [
            'asset'     => 'trattenere-figlio-reato-infografica.jpg',
            'nome_file' => 'trattenere-figlio-reato-infografica.jpg',
            'titolo'    => 'Il pianto del figlio non basta per violare gli accordi di separazione',
            'alt'       => 'Infografica: il pianto del bambino non è un lasciapassare - Cass. n. 9930/2026 - Studio Legale LANOTTE',
            'vecchio'   => 7991,
        ],
        'approvato-palestre-scolastiche-a-asd-e-ssd' => [
            'asset'     => 'palestre-scolastiche-asd-ssd.jpg',
            'nome_file' => 'palestre-scolastiche-asd-ssd.jpg',
            'titolo'    => 'Palestre scolastiche aperte ad ASD e SSD: la legge 53/2026',
            'alt'       => 'Vignetta: Palestre Scolastiche Aperte alle Società Sportive',
            'vecchio'   => 8005,
        ],
    ];
}

/**
 * Garantisce il formato lanotte-post-thumb dell'allegato. Una richiesta interrotta durante la generazione lascia nei
 * metadati larghezza e altezza ma non tutti i formati, e lanotte_evidenza_20261011_completa() in quel caso non rigenera
 * (rilievo di Codex, secondo giro): se il formato manca nei metadati, o c'è ma il file non è sul disco, lo si genera con
 * wp_update_image_subsizes() e si rilegge.
 */
function lanotte_leggere_20261026_formato($id, &$errore) {
    $file = (string) get_attached_file($id);
    $presente = function () use ($id, $file) {
        $meta  = wp_get_attachment_metadata($id);
        $thumb = is_array($meta) ? (string) ($meta['sizes']['lanotte-post-thumb']['file'] ?? '') : '';
        return $thumb !== '' && file_exists(path_join(dirname($file), $thumb));
    };
    if ($presente()) return true;

    $meta = wp_get_attachment_metadata($id);
    if (is_array($meta) && isset($meta['sizes']['lanotte-post-thumb'])) {
        unset($meta['sizes']['lanotte-post-thumb']); // voce senza file: va rifatta, e WordPress rifà solo ciò che manca nei metadati
        wp_update_attachment_metadata($id, $meta);
    }
    if (!function_exists('wp_update_image_subsizes')) require_once ABSPATH . 'wp-admin/includes/image.php';
    $esito = wp_update_image_subsizes($id);
    if (is_wp_error($esito)) { $errore = 'formato lanotte-post-thumb non generato per ' . $id . ': ' . $esito->get_error_message(); return false; }
    if (!$presente()) { $errore = 'formato lanotte-post-thumb non generato per ' . $id; return false; }
    return true;
}

function lanotte_leggere_20261026_esegui() {
    $opt = 'lanotte_immagini_leggere_20261026';
    if (get_option($opt) === 'errori') return;
    if (!function_exists('wp_upload_bits') || !function_exists('update_post_meta')) return;
    if (!function_exists('lanotte_evidenza_20261011_allegato')) return;

    // Il tentativo si conta all'inizio: anche uno interrotto dal tempo massimo di PHP avvicina lo stato «errori».
    $tentativi = (int) get_option($opt . '_tentativi', 0) + 1;
    update_option($opt . '_tentativi', $tentativi, false);

    $prefisso   = 'lanotte-leggere-20261026-';
    $voci       = lanotte_leggere_20261026_voci();
    $precedenti = (array) get_option($opt . '_precedenti', []);
    $esiti      = [];

    foreach ($voci as $slug => $v) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if (!$post instanceof WP_Post) { $esiti[$slug] = 'articolo non trovato'; continue; }

        // Si sostituisce solo l'immagine attesa (o la nostra, in una ripresa): una scelta fatta nel frattempo resta.
        $attuale = (int) get_post_thumbnail_id($post->ID);
        $nostra  = $attuale && get_post_meta($attuale, '_lanotte_source_asset', true) === $prefisso . $slug;
        if ($attuale !== (int) $v['vecchio'] && !$nostra) { $esiti[$slug] = 'immagine in evidenza cambiata nel frattempo (' . $attuale . '): non toccata'; continue; }

        $errore = '';
        $id = lanotte_evidenza_20261011_allegato((int) $post->ID, $slug, $v, $errore, $prefisso);
        if (!$id) { $esiti[$slug] = $errore ?: 'allegato non disponibile'; continue; }
        if (!wp_attachment_is_image($id)) { $esiti[$slug] = 'allegato ' . $id . ' non è un\'immagine'; continue; }

        $url = (string) wp_get_attachment_url($id);
        if ($url === '' || lanotte_evidenza_20261011_url_tagliato($url)) { $esiti[$slug] = 'URL non adatto ad AIOSEO: ' . $url; continue; }
        if (trim((string) get_post_meta($id, '_wp_attachment_image_alt', true)) === '') { $esiti[$slug] = 'testo alternativo vuoto'; continue; }

        // Il formato della scheda deve esistere davvero: è il motivo del lavoro (rilievo di Codex del 26/10).
        if (!lanotte_leggere_20261026_formato($id, $errore)) { $esiti[$slug] = $errore; continue; }

        // Riletta subito prima di scrivere: una scelta fatta durante l'importazione resta (rilievo di Codex, secondo giro).
        $attuale = (int) get_post_meta($post->ID, '_thumbnail_id', true);
        if ($attuale !== $id) {
            if ($attuale !== (int) $v['vecchio']) { $esiti[$slug] = 'immagine in evidenza cambiata nel frattempo (' . $attuale . '): non toccata'; continue; }
            // Si cambia solo con l'immagine precedente annotata e riletta: update_option() dà false anche se il valore
            // era già quello, quindi fa fede la rilettura.
            if (!isset($precedenti[$slug])) { $precedenti[$slug] = $attuale; update_option($opt . '_precedenti', $precedenti, false); }
            $annotati = (array) get_option($opt . '_precedenti', []);
            if ((int) ($annotati[$slug] ?? 0) !== (int) $v['vecchio']) { $esiti[$slug] = 'immagine precedente non annotata: non cambiata'; continue; }
            // Scrittura condizionata: avviene solo se l'immagine in evidenza è ancora quella appena letta.
            update_post_meta($post->ID, '_thumbnail_id', $id, (string) $attuale);
        }
        if ((int) get_post_meta($post->ID, '_thumbnail_id', true) !== $id) { $esiti[$slug] = 'immagine in evidenza non assegnata'; continue; }

        // Riscansione AIOSEO del solo articolo: cambiare l'immagine in evidenza non cambia post_modified.
        if (function_exists('aioseo')) {
            try {
                $sitemap = aioseo()->sitemap ?? null;
                $scanner = is_object($sitemap) ? ($sitemap->image ?? null) : null;
                if (!is_object($scanner) || !method_exists($scanner, 'scanPost')) { $esiti[$slug] = 'scansione AIOSEO non disponibile'; continue; }
                $scanner->scanPost($post->ID);
                $registrate = lanotte_evidenza_20261011_immagini_aioseo($post->ID);
                if ($registrate === null) { $esiti[$slug] = 'immagini AIOSEO non leggibili'; continue; }
                $nome = basename((string) parse_url($url, PHP_URL_PATH));
                if (strpos(str_replace('\/', '/', $registrate), $nome) === false) { $esiti[$slug] = 'AIOSEO non ha registrato ' . $nome; continue; }
            } catch (\Throwable $e) {
                $esiti[$slug] = 'scansione AIOSEO non riuscita: ' . $e->getMessage();
                continue;
            }
        }
        $esiti[$slug] = 'ok';
    }

    update_option($opt . '_esito', $esiti, false);
    $ok = count(array_filter($esiti, function ($e) { return $e === 'ok'; }));
    if (count($esiti) === count($voci) && $ok === count($voci)) { update_option($opt, 'done', false); return; }
    if ($tentativi >= 3) update_option($opt, 'errori', false);
    error_log('lanotte immagini leggere 20261026: tentativo ' . $tentativi . ', ' . $ok . '/' . count($voci) . ' ok: ' . wp_json_encode($esiti));
}

// wp_loaded: AIOSEO è già pronto per la riscansione.
add_action('wp_loaded', function () {
    if (!function_exists('lanotte_editorial_once')) return;
    lanotte_editorial_once('lanotte_immagini_leggere_20261026', 'lanotte_leggere_20261026_esegui');
}, 21);
