<?php
/**
 * Dati aggiornati nei titoli, nelle descrizioni e nelle pagine dei calcolatori (21/10/2026).
 *
 * Misura di Search Console (22/09–19/10/2026): su «calcolo interessi moratori», «adeguamento ISTAT affitto» e
 * «rivalutazione monetaria» il primo risultato mostra nel titolo il mese dell'ultimo indice o il tasso in vigore
 * («Adeguamento Istat Canone di Locazione Settembre 2026»), e le nostre pagine, in posizione 7-9, prendono lo 0,3-3%
 * dei clic. Qui il titolo e la descrizione per Google, e un riquadro nella pagina, leggono i valori dagli stessi file
 * che usano i calcolatori (assets/data/*.json): quando il file si aggiorna, si aggiornano anche loro, senza toccare il
 * tema. Le pagine generate dal router restano fisse (titolo H1 e introduzione): il dato vivo sta solo nei filtri SEO
 * e nello shortcode [lanotte_dato_vivo], che si calcolano a ogni richiesta.
 *
 * Variazione annua del FOI: stesso metodo di assets/js/lanotte-istat.js (rapporto degli indici come pubblicati,
 * arrotondato a 8 decimali, per il raccordo fra basi, poi ×100 −100 arrotondato a un decimale). Se un dato manca,
 * è fuori periodo o il conto non è sicuro, la parte che lo usa sparisce e resta il testo senza numeri: mai un
 * segnaposto in pagina, mai un numero inventato.
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/** Mesi in italiano, per «settembre 2026». */
function lanotte_dv_mese_testo($yyyymm) {
    static $mesi = ['gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];
    if (!preg_match('~^(\d{4})-(\d{2})$~', (string) $yyyymm, $m)) return null;
    $i = (int) $m[2] - 1;
    return isset($mesi[$i]) ? $mesi[$i] . ' ' . $m[1] : null;
}

/** Numero con la virgola e i decimali indicati: 10.4 → «10,40» con 2 decimali. */
function lanotte_dv_numero($valore, $decimali) {
    return number_format((float) $valore, $decimali, ',', '.');
}

/** Tasso come pubblicato, senza zeri inutili ma con almeno un decimale: 1.6 → «1,6», 2 → «2,0», 0.01 → «0,01». */
function lanotte_dv_tasso($valore) {
    $s = rtrim(rtrim(number_format((float) $valore, 4, '.', ''), '0'), '.');
    if (strpos($s, '.') === false) $s .= '.0';
    return str_replace('.', ',', $s);
}

/** Arrotondamento di num/den all'intero, metà lontano da zero (interi non negativi). */
function lanotte_dv_arrotonda($num, $den) {
    if (!is_int($num) || !is_int($den) || $den <= 0 || $num < 0) return null;
    if ($num > intdiv(PHP_INT_MAX - $den, 2)) return null;
    return intdiv(2 * $num + $den, 2 * $den);
}

/**
 * Variazione percentuale del FOI fra due mesi, in decimi di punto (40 = +4,0%), come lanotte-istat.js.
 * Ammessi solo rapporti con al più un cambio di base: oltre, gli interi di PHP potrebbero non bastare e si rinuncia.
 */
function lanotte_dv_variazione_decimi(array $pubblicati, $da, $a) {
    static $ordine = ['1995', '2010', '2015', '2025'];
    static $raccordi = ['1995' => [1373, 1000], '2010' => [1071, 1000], '2015' => [1214, 1000]];
    if (empty($pubblicati[$da]) || empty($pubblicati[$a])) return null;
    [$v1, $b1] = $pubblicati[$da];
    [$v2, $b2] = $pubblicati[$a];
    $i1 = array_search((string) $b1, $ordine, true);
    $i2 = array_search((string) $b2, $ordine, true);
    if ($i1 === false || $i2 === false || abs($i2 - $i1) > 1 || !($v1 > 0) || !($v2 > 0)) return null;

    $x1 = (int) round($v1 * 10000);
    $x2 = (int) round($v2 * 10000);
    $scala = 100000000;
    $num = lanotte_dv_arrotonda($x2 * $scala, $x1);
    $den = $scala;
    if ($num === null) return null;
    if ($i2 > $i1) { [$p, $q] = $raccordi[$ordine[$i1]]; $num *= $p; $den *= $q; }
    if ($i1 > $i2) { [$p, $q] = $raccordi[$ordine[$i2]]; $num *= $q; $den *= $p; }
    if (!is_int($num) || !is_int($den)) return null;

    // (rapporto × 1000 − 1000) arrotondato: variazione in decimi di punto. Il segno si tratta a parte.
    $diff = $num * 1000 - $den * 1000;
    if (!is_int($diff)) return null;
    $abs = lanotte_dv_arrotonda(abs($diff), $den);
    if ($abs === null) return null;
    return $diff < 0 ? -$abs : $abs;
}

/** Legge un file di dati del tema; null se manca o non è JSON. */
function lanotte_dv_json($nome) {
    $file = LANOTTE_THEME_DIR . '/assets/data/' . $nome;
    if (!is_readable($file)) return null;
    $d = json_decode((string) file_get_contents($file), true);
    return is_array($d) ? $d : null;
}

/** Riga di una tabella di tassi in vigore alla data (formato «AAAA-MM-GG», campi «dal» e «al»). */
function lanotte_dv_tasso_in_vigore($tassi, $oggi) {
    if (!is_array($tassi)) return null;
    foreach ($tassi as $riga) {
        if (!is_array($riga) || empty($riga['dal']) || empty($riga['al'])) continue;
        if ($riga['dal'] <= $oggi && $oggi <= $riga['al']) return $riga;
    }
    return null;
}

/**
 * Valori disponibili adesso, come segnaposti {nome} => testo. Un valore che non si può ricavare con certezza
 * semplicemente non c'è: le parti di testo che lo usano cadono (vedi lanotte_dv_testo).
 *
 * @param string|null $oggi data «AAAA-MM-GG» (solo per le prove; di norma la data di oggi a Roma)
 * @param array|null  $dati file già letti (solo per le prove): ['istat' => …, 'mora' => …, 'legali' => …]
 */
function lanotte_calcolatori_dati_vivi($oggi = null, $dati = null) {
    static $cache = null;
    $usa_cache = ($oggi === null && $dati === null);
    if ($usa_cache && $cache !== null) return $cache;

    if ($oggi === null) $oggi = function_exists('wp_date') ? wp_date('Y-m-d', null, new DateTimeZone('Europe/Rome')) : gmdate('Y-m-d');
    if ($dati === null) {
        $dati = [
            'istat'  => lanotte_dv_json('istat-foi.json'),
            'mora'   => lanotte_dv_json('interessi-moratori.json'),
            'legali' => lanotte_dv_json('interessi-legali.json'),
        ];
    }
    $v = [];

    // FOI: ultimo mese pubblicato e variazione su dodici mesi.
    $pub = is_array($dati['istat']['indici_pubblicati'] ?? null) ? $dati['istat']['indici_pubblicati'] : [];
    $pub = array_filter($pub, function ($x, $k) {
        return preg_match('~^\d{4}-\d{2}$~', (string) $k) && is_array($x) && isset($x[0], $x[1]) && is_numeric($x[0]);
    }, ARRAY_FILTER_USE_BOTH);
    if ($pub) {
        $mesi = array_keys($pub);
        sort($mesi);
        $ultimo = end($mesi);
        $testo = lanotte_dv_mese_testo($ultimo);
        if ($testo) {
            $v['foi_mese'] = $testo;
            $v['foi_indice'] = lanotte_dv_tasso($pub[$ultimo][0]) . ' (base ' . $pub[$ultimo][1] . '=100)';
            $prima = ((int) substr($ultimo, 0, 4) - 1) . substr($ultimo, 4);
            $decimi = lanotte_dv_variazione_decimi($pub, $prima, $ultimo);
            if ($decimi !== null) {
                $segno = $decimi < 0 ? '−' : '+';
                $v['foi_mese_prima'] = lanotte_dv_mese_testo($prima);
                $v['foi_var12'] = $segno . lanotte_dv_numero(abs($decimi) / 10, 1);
                // Aggiornamento al 75%: 75% della variazione, come aumento75() del calcolatore (3,4 → 2,55; 4,0 → 3,0).
                $v['foi_75'] = $segno . lanotte_dv_tasso(abs($decimi) * 75 / 1000);
            }
        }
    }

    // Interessi di mora (D.Lgs. 231/2002): tasso del semestre in corso.
    $mora = lanotte_dv_tasso_in_vigore($dati['mora']['tassi'] ?? null, $oggi);
    if ($mora && isset($mora['moratorio'], $mora['saggio_bce']) && is_numeric($mora['moratorio']) && is_numeric($mora['saggio_bce'])) {
        $mese_dal = substr($mora['dal'], 5, 2);
        $anno = substr($mora['dal'], 0, 4);
        // Solo semestri esatti dello stesso anno: 1/1–30/6 o 1/7–31/12. Una data finale sbagliata nel file (2027-12-31
        // su un semestre del 2026) non deve far presentare come vigente un tasso scaduto (rilievo Codex su dc5ed36).
        if ($mora['dal'] === $anno . '-01-01' && $mora['al'] === $anno . '-06-30' || $mora['dal'] === $anno . '-07-01' && $mora['al'] === $anno . '-12-31') {
            $v['mora_tasso'] = lanotte_dv_numero($mora['moratorio'], 2);
            $v['mora_bce'] = lanotte_dv_numero($mora['saggio_bce'], 2);
            $v['mora_semestre'] = ($mese_dal === '01' ? '1°' : '2°') . ' semestre ' . $anno;
            $v['mora_periodo'] = ($mese_dal === '01' ? 'dal 1° gennaio al 30 giugno ' : 'dal 1° luglio al 31 dicembre ') . $anno;
            if (!empty($mora['norma'])) $v['mora_norma'] = (string) $mora['norma'];
        }
    }

    // Interessi legali (art. 1284 c.c.): tasso dell'anno in corso.
    $leg = lanotte_dv_tasso_in_vigore($dati['legali']['tassi'] ?? null, $oggi);
    if ($leg && isset($leg['tasso']) && is_numeric($leg['tasso']) && substr($leg['dal'], 5) === '01-01' && substr($leg['al'], 5) === '12-31'
        && substr($leg['dal'], 0, 4) === substr($leg['al'], 0, 4)) {
        $v['legale_tasso'] = lanotte_dv_tasso($leg['tasso']);
        $v['legale_anno'] = substr($leg['dal'], 0, 4);
        if (!empty($leg['norma'])) $v['legale_norma'] = (string) $leg['norma'];
    }

    if ($usa_cache) $cache = $v;
    return $v;
}

/**
 * Compone un testo con i segnaposti {nome}. «[[A||B]]» vale A se tutti i suoi segnaposti hanno un valore, altrimenti
 * B (anche vuoto: «[[A||]]»). Fuori dalle doppie quadre ogni segnaposto deve avere un valore: se ne manca uno il
 * risultato è null e chi chiama usa il testo fisso.
 */
function lanotte_dv_testo($modello, array $valori) {
    if (!is_string($modello) || $modello === '') return null;
    $sostituisci = function ($s) use ($valori) {
        $mancante = false;
        $out = preg_replace_callback('~\{([a-z0-9_]+)\}~', function ($m) use ($valori, &$mancante) {
            if (!isset($valori[$m[1]]) || $valori[$m[1]] === '') { $mancante = true; return ''; }
            return $valori[$m[1]];
        }, $s);
        return $mancante ? null : $out;
    };
    $risultato = preg_replace_callback('~\[\[(.*?)\|\|(.*?)\]\]~s', function ($m) use ($sostituisci) {
        $a = $sostituisci($m[1]);
        if ($a !== null) return $a;
        $b = $sostituisci($m[2]);
        return $b !== null ? $b : '';
    }, $modello);
    if (!is_string($risultato) || strpos($risultato, '[[') !== false) return null;
    $finale = $sostituisci($risultato);
    return $finale === null ? null : trim(preg_replace('~\s{2,}~', ' ', $finale));
}

/**
 * Titoli e descrizioni per Google con il dato aggiornato, e riquadro in pagina. Solo dove il dato aiuta chi cerca:
 * il mese dell'ultimo indice, la variazione annua, il tasso in vigore. Testi informativi (art. 10 L. 247/2012).
 */
function lanotte_calcolatori_seo_vivo() {
    return [
        'interessi-moratori' => [
            'titolo' => 'Calcolo interessi di mora D.Lgs. 231/2002[[ – tasso {mora_tasso}%|| (gratuito)]]',
            'descrizione' => '[[Tasso di mora del {mora_semestre}: {mora_tasso}% (BCE {mora_bce}% + 8 punti). ||]]Calcolo gratuito degli interessi di mora sulle fatture pagate in ritardo, semestre per semestre, con i 40 € dell\'art. 6 D.Lgs. 231/2002.',
            'riquadro' => 'Tasso degli interessi di mora in vigore {mora_periodo}: <strong>{mora_tasso}%</strong> (saggio BCE {mora_bce}% + 8 punti[[; {mora_norma}||]]).',
        ],
        'interessi-legali' => [
            'titolo' => 'Calcolo interessi legali[[ {legale_anno} – tasso {legale_tasso}%||]] (art. 1284 c.c.)',
            'descrizione' => '[[Tasso di interesse legale {legale_anno}: {legale_tasso}%. ||]]Calcolo gratuito degli interessi legali su un credito, periodo per periodo con il tasso di ciascun anno (art. 1284 c.c.).',
            'riquadro' => 'Tasso di interesse legale per il {legale_anno}: <strong>{legale_tasso}%</strong>[[ ({legale_norma})||]].',
        ],
        'istat-locazione' => [
            'titolo' => 'Calcolo adeguamento ISTAT affitto[[ – FOI {foi_mese}||]] (gratuito)',
            'descrizione' => '[[Ultimo indice FOI, {foi_mese}: {foi_var12}% su un anno ({foi_75}% al 75%). ||]]Calcolo gratuito dell\'aggiornamento ISTAT del canone di locazione, per intero o al 75%, con decorrenza e nuovo canone mensile.',
            'riquadro' => 'Ultimo indice FOI senza tabacchi pubblicato dall\'ISTAT: <strong>{foi_mese}</strong>, {foi_indice}. Variazione rispetto a {foi_mese_prima}: <strong>{foi_var12}%</strong>; al 75%: <strong>{foi_75}%</strong>.',
        ],
        'svalutazione' => [
            'titolo' => 'Calcolo rivalutazione monetaria ISTAT e interessi[[ – FOI {foi_mese}|| (gratuito)]]',
            'descrizione' => '[[Indici ISTAT FOI aggiornati a {foi_mese} (variazione annua {foi_var12}%). ||]]Calcolo gratuito della rivalutazione monetaria di un importo e degli interessi legali sul capitale via via rivalutato.',
            'riquadro' => 'Indici ISTAT FOI senza tabacchi disponibili fino a <strong>{foi_mese}</strong> ({foi_indice})[[; variazione su dodici mesi: <strong>{foi_var12}%</strong>||]].',
        ],
        'mantenimento-istat' => [
            'descrizione' => 'Rivalutazione, adeguamento e aggiornamento ISTAT dell\'assegno di mantenimento per coniuge e figli[[ con gli indici FOI aggiornati a {foi_mese}||]]: il calcolatore gratuito quantifica nuovo importo, differenze mensili e arretrati.',
            'riquadro' => 'Indici ISTAT FOI senza tabacchi disponibili fino a <strong>{foi_mese}</strong> ({foi_indice})[[; variazione su dodici mesi: <strong>{foi_var12}%</strong>||]].',
        ],
    ];
}

/** Titolo e descrizione SEO del calcolatore, con il dato vivo se c'è; altrimenti quelli fissi del router. */
function lanotte_calcolatore_seo($slug, array $calc) {
    $vivo = lanotte_calcolatori_seo_vivo()[$slug] ?? [];
    $valori = lanotte_calcolatori_dati_vivi();
    $titolo = isset($vivo['titolo']) ? lanotte_dv_testo($vivo['titolo'], $valori) : null;
    $descrizione = isset($vivo['descrizione']) ? lanotte_dv_testo($vivo['descrizione'], $valori) : null;
    return [
        'title' => $titolo ?: $calc['title'],
        'description' => $descrizione ?: wp_trim_words($calc['intro'], 28, '...'),
    ];
}

/** Calcolatore della pagina corrente con titolo e descrizione SEO già composti; null fuori dai calcolatori. */
function lanotte_calcolatore_seo_corrente() {
    if (!function_exists('lanotte_current_calcolatore_data')) return null;
    $calc = lanotte_current_calcolatore_data();
    if (!$calc) return null;
    $post = get_post();
    return lanotte_calcolatore_seo($post ? $post->post_name : '', $calc);
}

/**
 * La pagina del calcolatore può restare nella cache di LiteSpeed: al cambio di semestre o d'anno il titolo e il riquadro
 * resterebbero quelli vecchi fino alla scadenza della cache (rilievo Codex su dc5ed36). Al più una volta l'ora si calcola
 * la firma dei valori; se è cambiata si svuota la cache delle pagine dei calcolatori che li mostrano.
 */
function lanotte_calcolatori_dati_vivi_controlla_cache() {
    if (get_transient('lanotte_dati_vivi_controllo')) return;
    set_transient('lanotte_dati_vivi_controllo', 1, HOUR_IN_SECONDS);
    $firma = md5((string) wp_json_encode(lanotte_calcolatori_dati_vivi()));
    $prima = get_option('lanotte_dati_vivi_firma');
    if ($prima === $firma) return;
    update_option('lanotte_dati_vivi_firma', $firma, false);
    if ($prima === false) return; // prima misura dopo l'installazione: il deploy ha già svuotato la cache
    foreach (array_keys(lanotte_calcolatori_seo_vivo()) as $slug) {
        $pagina = get_page_by_path('calcolatori/' . $slug, OBJECT, 'page');
        if ($pagina) do_action('litespeed_purge_post', (int) $pagina->ID);
    }
}
add_action('init', 'lanotte_calcolatori_dati_vivi_controlla_cache', 40);

/** [lanotte_dato_vivo slug="…"]: riquadro con il dato in vigore; vuoto se il dato non c'è. */
add_shortcode('lanotte_dato_vivo', function ($atts) {
    $atts = shortcode_atts(['slug' => ''], $atts, 'lanotte_dato_vivo');
    $vivo = lanotte_calcolatori_seo_vivo()[sanitize_title($atts['slug'])] ?? [];
    if (empty($vivo['riquadro'])) return '';
    $testo = lanotte_dv_testo($vivo['riquadro'], array_map('esc_html', lanotte_calcolatori_dati_vivi()));
    if (!$testo) return '';
    return '<p class="lanotte-dato-vivo">' . wp_kses($testo, ['strong' => []]) . '</p>';
});
