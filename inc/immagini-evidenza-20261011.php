<?php
/**
 * Immagini in evidenza nuove per sette articoli di diritto di famiglia (11/10/2026).
 *
 * Problema misurato l'11/10/2026: post-sitemap.xml conteneva 7 riferimenti a due JPG inesistenti (HTTP 404),
 * /2017/10/Mediation-scheiden-1.jpg e /2017/01/diritto-di-famiglia-e-minori-1.jpg. Gli articoli usavano come
 * immagine in evidenza gli allegati 569 (file Mediation-scheiden-1024x5761-1.jpg) e 297 (file
 * diritto-di-famiglia-e-minori-1600x580-1.jpg), entrambi esistenti; il nome sbagliato lo produce AIOSEO, che
 * per risalire all'originale toglie dall'URL ogni tratto «-NxN» o «-scaled» (WpUri::removeImageDimensions,
 * preg_replace('#(-[0-9]*x[0-9]*|-scaled)#', '', $url), AIOSEO 5.0.3) e così taglia «-1024x5761» e «-1600x580»,
 * che fanno parte del nome vero del file.
 *
 * Rimedio: ogni articolo riceve un allegato proprio, importato da assets/img/blog/ con un nome senza quei tratti e
 * un testo alternativo che descrive l'immagine; gli allegati di altri articoli non si toccano. Dopo l'assegnazione
 * si chiede ad AIOSEO di riscandire il singolo articolo: la sua scansione periodica non lo farebbe, perché cambiare
 * l'immagine in evidenza non cambia post_modified (che qui non si tocca).
 *
 * Una volta sola (lanotte_editorial_once). «done» solo se ogni articolo, riletto, ha l'immagine nuova, il file
 * esiste, il testo alternativo non è vuoto, l'URL non contiene il tratto tagliato da AIOSEO e, se AIOSEO è attivo,
 * le immagini registrate da AIOSEO contengono la nuova e nessuno dei due URL rotti. Altrimenti si ritenta alla
 * richiesta successiva; dopo tre tentativi lo stato diventa «errori» e si ferma. Esito voce per voce in
 * lanotte_immagini_evidenza_20261011_esito. Testi, slug, date, categorie e canonical degli articoli non si toccano.
 */

if (!defined('ABSPATH')) exit;

/** Articolo (slug) → immagine del tema, nome del file caricato, titolo e testo alternativo dell'allegato. */
function lanotte_evidenza_20261011_voci() {
    return [
        'separazione-o-divorzio-mediante-negoziazione-assistita-da-avvocati' => [
            'asset'     => 'assegno-mantenimento-non-pagato-2026.jpg',
            'nome_file' => 'negoziazione-assistita-separazione-divorzio.jpg',
            'titolo'    => 'Negoziazione assistita per la separazione e il divorzio',
            'alt'       => 'Due professionisti firmano documenti a una scrivania, accanto a una cartella aperta e a una calcolatrice',
        ],
        'divorzio-tempi-difficili-ne-faceva-un-affare' => [
            'asset'     => 'assegno-divorzile-criteri-revisione-convivenza.jpg',
            'nome_file' => 'assegno-divorzio-funzione-assistenziale-compensativa.jpg',
            'titolo'    => 'Assegno di divorzio: criteri, revisione e convivenza',
            'alt'       => 'Schema in tre punti sull’assegno divorzile: criteri, revisione per giustificati motivi ed effetti della nuova convivenza',
        ],
        'sottrazione-di-minore-per-la-madre-che-va-ad-abitare-lontano-dal-padre' => [
            'asset'     => 'modifica-collocamento-figli-conflitto-genitoriale-ctu.jpg',
            'nome_file' => 'trasferimento-residenza-figlio-genitori.jpg',
            'titolo'    => 'Trasferimento del figlio e rapporto con entrambi i genitori',
            'alt'       => 'Due case unite da un vialetto, con una bilancia sospesa nel cielo tra le due abitazioni',
        ],
        // Le quattro voci seguenti usano immagini create l'11/10/2026 per questi articoli (nessuna adeguata nel tema).
        'annullamento-del-matrimonio-errore' => [
            'asset'     => 'annullamento-matrimonio-errore.jpg',
            'nome_file' => 'annullamento-matrimonio-errore.jpg',
            'titolo'    => 'Annullamento del matrimonio per errore',
            'alt'       => 'Due fedi nuziali appoggiate su un fascicolo blu chiuso, sulla scrivania di uno studio legale',
        ],
        'adozione-revocazione-della-donazione-adozione-speciale' => [
            'asset'     => 'adozione-revocazione-donazione.jpg',
            'nome_file' => 'adozione-revocazione-donazione.jpg',
            'titolo'    => 'Adozione speciale e revocazione della donazione',
            'alt'       => 'Atto su carta pergamena con penna stilografica e sigillo dorato su una scrivania; sullo sfondo, incorniciato, il disegno di una famiglia fatto da un bambino',
        ],
        'il-potere-dufficio-del-giudice-di-disporre-le-indagini-tributarie-nella-separazione-i-presupposti' => [
            'asset'     => 'indagini-tributarie-separazione.jpg',
            'nome_file' => 'indagini-tributarie-separazione.jpg',
            'titolo'    => 'Indagini tributarie disposte dal giudice nella separazione',
            'alt'       => 'Dichiarazioni dei redditi ed estratti conto sparsi su una scrivania, con una lente d’ingrandimento e una calcolatrice',
        ],
        'riconoscimento-di-paternita-dna' => [
            'asset'     => 'riconoscimento-paternita-dna.jpg',
            'nome_file' => 'riconoscimento-paternita-dna.jpg',
            'titolo'    => 'Riconoscimento di paternità e prova del DNA',
            'alt'       => 'Kit per il test del DNA, con provetta e tampone, accanto a un fascicolo blu su una scrivania',
        ],
    ];
}

/** Tratto che AIOSEO toglie dall'URL di un allegato (vedi intestazione). */
function lanotte_evidenza_20261011_url_tagliato($url) {
    return (bool) preg_match('#(-[0-9]*x[0-9]*|-scaled)#', (string) parse_url((string) $url, PHP_URL_PATH));
}

/**
 * Completa e verifica un allegato dell'articolo: testo alternativo (scritto solo se vuoto) e metadati con larghezza e
 * altezza (generati se mancano). Vale sia per l'allegato appena creato sia per quello ritrovato in una ripresa: una
 * richiesta interrotta dopo la creazione, o una scrittura fallita, non deve lasciare un allegato incompleto che poi
 * risulti «ok» (rilievo di Codex, tornata 13).
 */
function lanotte_evidenza_20261011_completa($id, $file, array $v, &$errore) {
    if (trim((string) get_post_meta($id, '_wp_attachment_image_alt', true)) === '') {
        update_post_meta($id, '_wp_attachment_image_alt', $v['alt']);
        if (trim((string) get_post_meta($id, '_wp_attachment_image_alt', true)) === '') { $errore = 'testo alternativo non scritto'; return false; }
    }
    $meta = wp_get_attachment_metadata($id);
    if (!is_array($meta) || empty($meta['width']) || empty($meta['height'])) {
        if (!function_exists('wp_generate_attachment_metadata')) require_once ABSPATH . 'wp-admin/includes/image.php';
        $nuovi = wp_generate_attachment_metadata($id, $file);
        if (is_array($nuovi) && $nuovi) wp_update_attachment_metadata($id, $nuovi);
        $meta = wp_get_attachment_metadata($id);
        if (!is_array($meta) || empty($meta['width']) || empty($meta['height'])) { $errore = 'metadati dell\'immagine non generati'; return false; }
    }
    return true;
}

/**
 * Restituisce l'ID dell'allegato dell'articolo: quello già importato con la stessa chiave oppure uno nuovo.
 * 0 in caso di errore, con il motivo in $errore. Non tocca allegati di altri articoli.
 * $prefisso distingue i lavori successivi che riusano questa funzione (26/10/2026: immagini-leggere-20261026.php).
 */
function lanotte_evidenza_20261011_allegato($post_id, $slug, array $v, &$errore, $prefisso = 'lanotte-evidenza-20261011-') {
    $chiave = $prefisso . $slug;
    $trovati = get_posts([
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 2,
        'fields'         => 'ids',
        'meta_key'       => '_lanotte_source_asset',
        'meta_value'     => $chiave,
    ]);
    if (count($trovati) > 1) { $errore = 'più allegati con la chiave ' . $chiave; return 0; }
    if ($trovati) {
        $id = (int) $trovati[0];
        $file = get_attached_file($id);
        if (!$file || !file_exists($file)) { $errore = 'allegato ' . $id . ' senza file'; return 0; }
        return lanotte_evidenza_20261011_completa($id, $file, $v, $errore) ? $id : 0;
    }

    if (trim($v['alt']) === '') { $errore = 'testo alternativo non definito'; return 0; }
    $sorgente = LANOTTE_THEME_DIR . '/assets/img/blog/' . $v['asset'];
    if (!is_readable($sorgente)) { $errore = 'immagine del tema mancante: ' . $v['asset']; return 0; }
    $tipo = wp_check_filetype($v['nome_file']);
    if (strpos((string) $tipo['type'], 'image/') !== 0) { $errore = 'nome di file non immagine: ' . $v['nome_file']; return 0; }
    $dati = file_get_contents($sorgente);
    if ($dati === false || $dati === '') { $errore = 'immagine del tema illeggibile: ' . $v['asset']; return 0; }

    $upload = wp_upload_bits($v['nome_file'], null, $dati);
    if (!empty($upload['error'])) { $errore = 'caricamento non riuscito: ' . $upload['error']; return 0; }

    $id = wp_insert_attachment([
        'post_mime_type' => $tipo['type'],
        'post_title'     => $v['titolo'],
        'post_content'   => '',
        'post_status'    => 'inherit',
    ], $upload['file'], $post_id, true);
    if (is_wp_error($id) || !$id) {
        $errore = 'allegato non creato' . (is_wp_error($id) ? ': ' . $id->get_error_message() : '') . ' (file caricato: ' . $upload['file'] . ')';
        return 0;
    }
    $id = (int) $id;
    // Chiave e testo alternativo subito: una ripresa ritrova questo allegato invece di caricarne un altro.
    update_post_meta($id, '_lanotte_source_asset', $chiave);
    update_post_meta($id, '_wp_attachment_image_alt', $v['alt']);
    return lanotte_evidenza_20261011_completa($id, $upload['file'], $v, $errore) ? $id : 0;
}

/** Immagini registrate da AIOSEO per l'articolo, come testo JSON; null se AIOSEO non è disponibile. */
function lanotte_evidenza_20261011_immagini_aioseo($post_id) {
    if (!class_exists('\AIOSEO\Plugin\Common\Models\Post')) return null;
    $p = \AIOSEO\Plugin\Common\Models\Post::getPost($post_id);
    $img = $p->images ?? null;
    return is_string($img) ? $img : (string) wp_json_encode($img);
}

function lanotte_evidenza_20261011_esegui() {
    $opt = 'lanotte_immagini_evidenza_20261011';
    if (get_option($opt) === 'errori') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    $rotti = ['Mediation-scheiden-1.jpg', 'diritto-di-famiglia-e-minori-1.jpg'];
    $voci  = lanotte_evidenza_20261011_voci();
    $esiti = [];

    foreach ($voci as $slug => $v) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if (!$post instanceof WP_Post) { $esiti[$slug] = 'articolo non trovato'; continue; }

        $errore = '';
        $id = lanotte_evidenza_20261011_allegato((int) $post->ID, $slug, $v, $errore);
        if (!$id) { $esiti[$slug] = $errore ?: 'allegato non disponibile'; continue; }
        if (!wp_attachment_is_image($id)) { $esiti[$slug] = 'allegato ' . $id . ' non è un\'immagine'; continue; }

        $url = (string) wp_get_attachment_url($id);
        if ($url === '' || lanotte_evidenza_20261011_url_tagliato($url)) { $esiti[$slug] = 'URL non adatto ad AIOSEO: ' . $url; continue; }
        if (trim((string) get_post_meta($id, '_wp_attachment_image_alt', true)) === '') { $esiti[$slug] = 'testo alternativo vuoto'; continue; }

        if ((int) get_post_thumbnail_id($post->ID) !== $id) set_post_thumbnail($post->ID, $id);
        if ((int) get_post_meta($post->ID, '_thumbnail_id', true) !== $id) { $esiti[$slug] = 'immagine in evidenza non assegnata'; continue; }

        // Riscansione AIOSEO del solo articolo e controllo di ciò che AIOSEO ha registrato.
        if (function_exists('aioseo')) {
            try {
                $sitemap = aioseo()->sitemap ?? null;
                $scanner = is_object($sitemap) ? ($sitemap->image ?? null) : null;
                if (!is_object($scanner) || !method_exists($scanner, 'scanPost')) { $esiti[$slug] = 'scansione AIOSEO non disponibile'; continue; }
                $scanner->scanPost($post->ID);
                $registrate = lanotte_evidenza_20261011_immagini_aioseo($post->ID);
                if ($registrate === null) { $esiti[$slug] = 'immagini AIOSEO non leggibili'; continue; }
                $rotto = false;
                foreach ($rotti as $r) if (strpos($registrate, $r) !== false) $rotto = true;
                if ($rotto) { $esiti[$slug] = 'AIOSEO conserva un URL rotto'; continue; }
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
    $tentativi = (int) get_option($opt . '_tentativi', 0) + 1;
    update_option($opt . '_tentativi', $tentativi, false);
    if ($tentativi >= 3) update_option($opt, 'errori', false);
    error_log('lanotte immagini in evidenza 20261011: tentativo ' . $tentativi . ', ' . $ok . '/' . count($voci) . ' ok: ' . wp_json_encode($esiti));
}

// wp_loaded: AIOSEO è già pronto per la riscansione.
add_action('wp_loaded', function () {
    if (!function_exists('lanotte_editorial_once')) return;
    lanotte_editorial_once('lanotte_immagini_evidenza_20261011', 'lanotte_evidenza_20261011_esegui');
}, 20);
