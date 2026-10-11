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
 * - la sostituzione avviene solo se le occorrenze sono esattamente quelle attese, se il tratto
 *   trovato non contiene tag HTML e, quando cade dentro un tag (un attributo), se il testo nuovo ha la
 *   stessa sequenza di virgolette e di «=» del tratto sostituito e nessuna parentesi angolare (una
 *   sostituzione non deve mai rompere il markup);
 * - altrimenti la voce è saltata. Nessuna voce saltata viene registrata come applicata.
 * Sul database (lanotte_corr_esegui_lotto):
 * - l'originale si salva PRIMA della modifica e si rilegge: se non risulta salvato, il campo non si tocca;
 * - il campo si salva con wp_slash (WordPress toglie le barre: senza, "\201C" diventerebbe "201C");
 * - dopo il salvataggio il campo si rilegge: se non è il testo atteso si ripristina il testo di prima;
 * - un contenuto è «fatto» solo se tutte le sue voci sono applicate o già presenti; altrimenti si
 *   ritenta alla richiesta successiva, al massimo 3 volte, poi resta tra i «falliti»;
 * - il lotto diventa «done» solo se non c'è alcun fallito; con falliti diventa «errori» e si ferma.
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
        $markup = false; $attributo = false;
        foreach ($trovate as $t) {
            if (strpbrk(substr($raw, $t[0], $t[1] - $t[0]), '<>') !== false) { $markup = true; break; }
            // Dentro un tag (es. title="…" o alt="…") il testo nuovo deve avere la stessa sequenza di virgolette e
            // di «=» del tratto che sostituisce e nessuna parentesi angolare: così non apre né chiude attributi.
            $prima = substr($raw, 0, $t[0]);
            $lt = strrpos($prima, '<'); $gt = strrpos($prima, '>');
            if ($lt !== false && ($gt === false || $lt > $gt)) {
                $scheletro = function ($x) { return preg_replace('/[^"\'=]/', '', $x); };
                if (strpbrk($v['sostituisci'], '<>') !== false
                    || $scheletro($v['sostituisci']) !== $scheletro(substr($raw, $t[0], $t[1] - $t[0]))) { $attributo = true; break; }
            }
        }
        if ($markup) { $esiti[$k] = ['esito' => 'attraversa markup', 'trovate' => count($trovate)]; continue; }
        if ($attributo) { $esiti[$k] = ['esito' => 'virgolette dentro un tag', 'trovate' => count($trovate)]; continue; }
        // sostituzione dalla fine all'inizio, per non spostare le posizioni ancora da usare
        foreach (array_reverse($trovate) as $t) {
            $raw = substr($raw, 0, $t[0]) . $v['sostituisci'] . substr($raw, $t[1]);
        }
        $esiti[$k] = ['esito' => 'applicata', 'trovate' => count($trovate)];
    }
    return [$raw, $esiti];
}

/** Esiti che contano come riusciti: solo questi rendono «fatto» un contenuto. */
function lanotte_corr_riuscita($e) {
    return is_array($e) && in_array($e['esito'] ?? '', ['applicata', 'già presente'], true);
}

/** Salva un campo di un post con le barre che WordPress si aspetta, poi lo rilegge. Restituisce true se il campo è $testo. */
function lanotte_corr_salva_campo($id, $campo, $testo, &$errore) {
    $r = wp_update_post(wp_slash(['ID' => $id, $campo => $testo]), true);
    if (is_wp_error($r)) { $errore = $r->get_error_message(); return false; }
    clean_post_cache($id);
    $letto = get_post($id);
    if (!$letto || (string) $letto->$campo !== $testo) { $errore = 'il campo riletto non coincide'; return false; }
    return true;
}

/**
 * Esegue un lotto sul database, un contenuto alla volta, in modo riprendibile.
 * Dopo ogni contenuto salva esiti, originali, contenuti fatti e tentativi: se la richiesta si interrompe,
 * la successiva riprende da dove era arrivata. Si ferma da sé dopo $limite_s secondi e prosegue alla
 * richiesta seguente. Il lotto è «done» solo se tutte le voci di tutti i contenuti sono riuscite;
 * se qualche contenuto fallisce per $max_tentativi volte il lotto diventa «errori» (e non si ripete più).
 */
function lanotte_corr_esegui_lotto($lotto, array $voci, $limite_s = 20, $max_tentativi = 3) {
    if (!function_exists('wp_update_post')) return;
    if (get_option($lotto) === 'errori') return; // concluso con errori: si legge l'esito, non si ritenta
    $inizio = microtime(true);
    $esiti     = get_option($lotto . '_esito', []);         if (!is_array($esiti)) $esiti = [];
    $originali = get_option($lotto . '_originali', []);     if (!is_array($originali)) $originali = [];
    $fatti     = get_option($lotto . '_gruppi_fatti', []);  if (!is_array($fatti)) $fatti = [];
    $tentativi = get_option($lotto . '_tentativi', []);     if (!is_array($tentativi)) $tentativi = [];
    $falliti   = get_option($lotto . '_falliti', []);       if (!is_array($falliti)) $falliti = [];
    $gruppi = [];
    foreach ($voci as $k => $v) {
        $chiave = $v['tipo'] . '|' . $v['slug'] . '|' . $v['campo'];
        $gruppi[$chiave][$k] = $v;
    }
    $finito = true;
    kses_remove_filters(); // il contenuto esistente non deve essere filtrato dal salvataggio
    try {
        foreach ($gruppi as $chiave => $gruppo) {
            if (isset($fatti[$chiave]) || isset($falliti[$chiave])) continue;
            if (microtime(true) - $inizio > $limite_s) { $finito = false; break; }
            list($tipo, $slug, $campo) = explode('|', $chiave);
            // Le voci già riuscite in un tentativo precedente non si ripetono (il loro testo cercato non c'è più).
            $da_fare = array_filter($gruppo, function ($v, $k) use ($esiti) { return !lanotte_corr_riuscita($esiti[$k] ?? null); }, ARRAY_FILTER_USE_BOTH);
            $post = get_page_by_path($slug, OBJECT, $tipo);
            if (!$post instanceof WP_Post || !in_array($campo, ['post_content', 'post_excerpt', 'post_title'], true)) {
                foreach ($da_fare as $k => $v) $esiti[$k] = ['esito' => 'contenuto non trovato', 'slug' => $slug, 'tipo' => $tipo];
            } else {
                $prima = (string) $post->$campo;
                list($nuovo, $parziali) = lanotte_corr_applica_testo($prima, $da_fare);
                $applicate = array_filter($parziali, function ($e) { return $e['esito'] === 'applicata'; });
                if ($applicate && $nuovo !== $prima) {
                    $id_campo = $post->ID . '|' . $campo;
                    $errore = '';
                    // L'originale si salva PRIMA della modifica, non si sovrascrive mai e si rilegge.
                    if (!array_key_exists($id_campo, $originali)) {
                        $originali[$id_campo] = $prima;
                        update_option($lotto . '_originali', $originali, false);
                        $riletti = get_option($lotto . '_originali', []);
                        if (!is_array($riletti) || !array_key_exists($id_campo, $riletti) || $riletti[$id_campo] !== $prima) {
                            unset($originali[$id_campo]);
                            $errore = 'originale non salvato: campo non modificato';
                        }
                    }
                    if ($errore === '' && !lanotte_corr_salva_campo($post->ID, $campo, $nuovo, $errore)) {
                        // Salvataggio fallito o diverso dall'atteso: si rimette il testo di prima e lo si verifica.
                        $err_ripristino = '';
                        $errore = 'salvataggio non riuscito (' . $errore . '); '
                            . (lanotte_corr_salva_campo($post->ID, $campo, $prima, $err_ripristino)
                                ? 'testo di prima ripristinato'
                                : 'RIPRISTINO NON RIUSCITO (' . $err_ripristino . '): usare l\'originale in ' . $lotto . '_originali');
                    }
                    if ($errore !== '') foreach ($applicate as $k => $e) $parziali[$k] = ['esito' => 'errore', 'errore' => $errore];
                }
                foreach ($parziali as $k => $e) $esiti[$k] = $e + ['slug' => $slug, 'tipo' => $tipo, 'campo' => $campo, 'post_id' => $post->ID];
            }
            $tutte = true;
            foreach ($gruppo as $k => $v) if (!lanotte_corr_riuscita($esiti[$k] ?? null)) { $tutte = false; break; }
            if ($tutte) {
                $fatti[$chiave] = true;
            } else {
                $tentativi[$chiave] = ($tentativi[$chiave] ?? 0) + 1;
                if ($tentativi[$chiave] >= $max_tentativi) $falliti[$chiave] = true;
                else $finito = false; // si ritenta alla prossima richiesta
            }
            update_option($lotto . '_esito', $esiti, false);
            update_option($lotto . '_gruppi_fatti', $fatti, false);
            update_option($lotto . '_tentativi', $tentativi, false);
            update_option($lotto . '_falliti', $falliti, false);
        }
    } finally {
        kses_init();
    }
    if (!$finito) return; // si riprende (o si ritenta) alla prossima richiesta
    ksort($esiti);
    $conteggio = array_count_values(array_map(function ($e) { return $e['esito']; }, $esiti));
    $riuscite = count(array_filter($esiti, 'lanotte_corr_riuscita'));
    update_option($lotto . '_riepilogo', ['voci' => count($voci), 'riuscite' => $riuscite, 'esiti' => $conteggio,
        'contenuti' => count($gruppi), 'falliti' => array_keys($falliti), 'quando' => current_time('mysql')], false);
    // «done» solo se ogni voce è riuscita; altrimenti «errori», che ferma i tentativi e resta visibile.
    update_option($lotto, ($falliti || $riuscite !== count($voci)) ? 'errori' : 'done', false);
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
