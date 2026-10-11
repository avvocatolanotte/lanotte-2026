<?php
/**
 * Correzioni puntuali dei contenuti salvati nel database (revisione completa del sito, ottobre 2026).
 * Il testo originale di ogni campo modificato resta nell'opzione "<lotto>_originali" (ID|campo => testo).
 *
 * Ogni lotto è un elenco di voci: tipo di contenuto, slug, campo, testo da cercare, testo nuovo,
 * occorrenze attese (di regola 1). Il lotto gira una sola volta (lanotte_editorial_once).
 *
 * La prova che regge ogni voce:
 * - il testo cercato e il campo vengono confrontati dopo una normalizzazione che non cambia il
 *   senso (entità HTML, apostrofi e virgolette tipografiche, spazi): così il testo copiato dalla
 *   pagina pubblicata trova il testo salvato;
 * - la sostituzione avviene solo se le occorrenze sono esattamente quelle attese e se il tratto
 *   trovato non contiene tag HTML (una sostituzione non deve mai rompere il markup);
 * - altrimenti la voce è saltata. Nessuna voce saltata viene registrata come applicata.
 * L'esito di ogni voce resta nell'opzione "<lotto>_esito"; il riepilogo in "<lotto>_riepilogo".
 */

if (!defined('ABSPATH')) exit;

/** Carattere normalizzato: apostrofi e virgolette tipografiche, spazi speciali. */
function lanotte_corr_norm_char($ch) {
    static $mappa = [
        "\u{2019}" => "'", "\u{2018}" => "'", "\u{201A}" => "'", "\u{201B}" => "'", "\u{2032}" => "'",
        "\u{201C}" => '"', "\u{201D}" => '"', "\u{201E}" => '"', "\u{00AB}" => '"', "\u{00BB}" => '"',
        "\u{00A0}" => ' ', "\u{2009}" => ' ', "\u{202F}" => ' ', "\t" => ' ', "\r" => ' ', "\n" => ' ',
        "\u{2013}" => '-', "\u{2014}" => '-',
    ];
    return $mappa[$ch] ?? $ch;
}

/**
 * Restituisce [testo normalizzato, mappa] dove mappa[i] = [inizio, fine) in byte del testo
 * originale per il byte i del testo normalizzato. Gli spazi consecutivi diventano uno solo.
 */
function lanotte_corr_mappa($raw) {
    $norm = '';
    $mappa = [];
    $len = strlen($raw);
    $i = 0;
    while ($i < $len) {
        $inizio = $i;
        $ch = null;
        if ($raw[$i] === '&' && preg_match('/\G&(#\d{1,7}|#x[0-9a-fA-F]{1,6}|[a-zA-Z][a-zA-Z0-9]{1,31});/', $raw, $m, 0, $i)) {
            $dec = html_entity_decode($m[0], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ($dec !== $m[0] && mb_strlen($dec, 'UTF-8') === 1) {
                $ch = $dec;
                $i += strlen($m[0]);
            }
        }
        if ($ch === null) {
            if (!preg_match('/\G./su', $raw, $m, 0, $i)) { $ch = $raw[$i]; $i++; }
            else { $ch = $m[0]; $i += strlen($m[0]); }
        }
        $ch = lanotte_corr_norm_char($ch);
        if ($ch === ' ' && substr($norm, -1) === ' ') {
            // spazio ripetuto: allarga lo spazio precedente
            $mappa[count($mappa) - 1][1] = $i;
            continue;
        }
        $norm .= $ch;
        for ($b = 0, $n = strlen($ch); $b < $n; $b++) $mappa[] = [$inizio, $i];
    }
    return [$norm, $mappa];
}

function lanotte_corr_normalizza($testo) {
    return trim(lanotte_corr_mappa((string) $testo)[0]);
}

/** Trova le occorrenze di $cerca in $raw; restituisce un elenco di [inizio, fine) in byte di $raw. */
function lanotte_corr_trova($raw, $cerca) {
    list($norm, $mappa) = lanotte_corr_mappa($raw);
    $ago = lanotte_corr_normalizza($cerca);
    if ($ago === '') return [];
    $trovate = [];
    $pos = 0;
    while (($p = strpos($norm, $ago, $pos)) !== false) {
        $trovate[] = [$mappa[$p][0], $mappa[$p + strlen($ago) - 1][1]];
        $pos = $p + strlen($ago);
    }
    return $trovate;
}

/**
 * Applica a un testo le voci che lo riguardano. Restituisce [testo nuovo, esiti].
 * Funzione pura: nessun accesso al database (si prova in locale).
 */
function lanotte_corr_applica_testo($raw, array $voci) {
    $esiti = [];
    foreach ($voci as $k => $v) {
        $attese = isset($v['attese']) ? (int) $v['attese'] : 1;
        // Voce che conserva il testo cercato e vi aggiunge qualcosa (es. una nota in coda): se il testo
        // nuovo è già presente, la voce è già stata applicata e non va ripetuta (ripresa dopo un'interruzione).
        $ago = lanotte_corr_normalizza($v['cerca']);
        $nuovo_norm = lanotte_corr_normalizza($v['sostituisci']);
        if ($ago !== '' && $nuovo_norm !== '' && strpos($nuovo_norm, $ago) !== false
            && count(lanotte_corr_trova($raw, $v['sostituisci'])) >= $attese) {
            $esiti[$k] = ['esito' => 'già presente', 'trovate' => count(lanotte_corr_trova($raw, $v['sostituisci']))];
            continue;
        }
        $trovate = lanotte_corr_trova($raw, $v['cerca']);
        if (count($trovate) !== $attese) {
            $esiti[$k] = ['esito' => count($trovate) === 0 ? 'non trovata' : 'occorrenze diverse', 'trovate' => count($trovate), 'attese' => $attese];
            continue;
        }
        $markup = false;
        foreach ($trovate as $t) {
            if (strpbrk(substr($raw, $t[0], $t[1] - $t[0]), '<>') !== false) { $markup = true; break; }
        }
        if ($markup) { $esiti[$k] = ['esito' => 'attraversa markup', 'trovate' => count($trovate)]; continue; }
        // sostituzione dalla fine all'inizio, per non spostare le posizioni ancora da usare
        foreach (array_reverse($trovate) as $t) {
            $raw = substr($raw, 0, $t[0]) . $v['sostituisci'] . substr($raw, $t[1]);
        }
        $esiti[$k] = ['esito' => 'applicata', 'trovate' => count($trovate)];
    }
    return [$raw, $esiti];
}

/**
 * Esegue un lotto sul database, un contenuto alla volta, in modo riprendibile.
 * Dopo ogni contenuto salva esiti, originali e contenuti già lavorati: se la richiesta si interrompe,
 * la successiva riprende da dove era arrivata. Si ferma da sé dopo $limite_s secondi e prosegue alla
 * richiesta seguente. Il lotto è marcato «done» solo quando tutti i contenuti sono stati lavorati.
 */
function lanotte_corr_esegui_lotto($lotto, array $voci, $limite_s = 20) {
    if (!function_exists('wp_update_post')) return;
    $inizio = microtime(true);
    $esiti     = get_option($lotto . '_esito', []);         if (!is_array($esiti)) $esiti = [];
    $originali = get_option($lotto . '_originali', []);     if (!is_array($originali)) $originali = [];
    $fatti     = get_option($lotto . '_gruppi_fatti', []);  if (!is_array($fatti)) $fatti = [];
    $gruppi = [];
    foreach ($voci as $k => $v) {
        $chiave = $v['tipo'] . '|' . $v['slug'] . '|' . $v['campo'];
        $gruppi[$chiave][$k] = $v;
    }
    $finito = true;
    kses_remove_filters(); // il contenuto esistente non deve essere filtrato dal salvataggio
    foreach ($gruppi as $chiave => $gruppo) {
        if (isset($fatti[$chiave])) continue;
        if (microtime(true) - $inizio > $limite_s) { $finito = false; break; }
        list($tipo, $slug, $campo) = explode('|', $chiave);
        $post = get_page_by_path($slug, OBJECT, $tipo);
        if (!$post instanceof WP_Post || !in_array($campo, ['post_content', 'post_excerpt', 'post_title'], true)) {
            foreach ($gruppo as $k => $v) $esiti[$k] = ['esito' => 'contenuto non trovato', 'slug' => $slug, 'tipo' => $tipo];
        } else {
            list($nuovo, $parziali) = lanotte_corr_applica_testo((string) $post->$campo, $gruppo);
            $applicate = array_filter($parziali, function ($e) { return $e['esito'] === 'applicata'; });
            if ($applicate && $nuovo !== $post->$campo) {
                // L'originale si salva PRIMA della modifica e non si sovrascrive mai.
                $id_campo = $post->ID . '|' . $campo;
                if (!isset($originali[$id_campo])) {
                    $originali[$id_campo] = (string) $post->$campo;
                    update_option($lotto . '_originali', $originali, false);
                }
                $r = wp_update_post(['ID' => $post->ID, $campo => $nuovo], true);
                if (is_wp_error($r)) {
                    foreach ($applicate as $k => $e) $parziali[$k] = ['esito' => 'errore di salvataggio', 'errore' => $r->get_error_message()];
                } else {
                    clean_post_cache($post->ID);
                    $verifica = get_post($post->ID);
                    if (!$verifica || $verifica->$campo !== $nuovo) {
                        foreach ($applicate as $k => $e) $parziali[$k] = ['esito' => 'salvato ma diverso dall\'atteso'];
                    }
                }
            }
            foreach ($parziali as $k => $e) $esiti[$k] = $e + ['slug' => $slug, 'tipo' => $tipo, 'campo' => $campo, 'post_id' => $post->ID];
        }
        $fatti[$chiave] = true;
        update_option($lotto . '_esito', $esiti, false);
        update_option($lotto . '_gruppi_fatti', $fatti, false);
    }
    kses_init();
    if (!$finito) return; // si riprende alla prossima richiesta
    ksort($esiti);
    $conteggio = array_count_values(array_map(function ($e) { return $e['esito']; }, $esiti));
    update_option($lotto . '_riepilogo', ['voci' => count($voci), 'esiti' => $conteggio, 'quando' => current_time('mysql')], false);
    update_option($lotto, 'done', false);
}

add_action('init', function () {
    if (!function_exists('lanotte_editorial_once')) return;
    $lotti = require __DIR__ . '/correzioni-contenuti-dati.php';
    foreach ($lotti as $lotto => $voci) {
        if (!$voci) continue;
        lanotte_editorial_once($lotto, function () use ($lotto, $voci) {
            lanotte_corr_esegui_lotto($lotto, $voci);
        });
    }
}, 70);
