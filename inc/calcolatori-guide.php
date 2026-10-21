<?php
/**
 * Guide sotto i calcolatori (21/10/2026).
 *
 * Misura del 21/10/2026: le pagine dei calcolatori più viste e meno cliccate hanno 530-950 parole, contro le 1.000-1.600
 * dei siti che le precedono su Google (miolegale.it), e nessuna spiegazione del metodo, della formula o delle fonti. Qui
 * una guida per calcolatore, scritta nel file content/guide-calcolatori/<slug>.html: come si calcola, un esempio con i
 * numeri del calcolatore, i valori in vigore, le fonti lette con la data, autore e data di aggiornamento.
 *
 * Lo shortcode [lanotte_guida_calcolatore] sta nel contenuto di ogni calcolatore: senza file non stampa nulla, quindi una
 * guida nuova richiede solo il file. [lanotte_tabella_tassi] stampa i tassi dagli stessi file dei calcolatori
 * (assets/data/interessi-*.json), così la tabella della guida non invecchia.
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/** Percorso della guida del calcolatore, o null se non c'è o lo slug non è valido. */
function lanotte_guida_calcolatore_file($slug) {
    $slug = (string) $slug;
    if (!preg_match('~^[a-z0-9-]+$~', $slug)) return null;
    $file = LANOTTE_THEME_DIR . '/content/guide-calcolatori/' . $slug . '.html';
    return is_readable($file) ? $file : null;
}

add_shortcode('lanotte_guida_calcolatore', function ($atts) {
    $atts = shortcode_atts(['slug' => ''], $atts, 'lanotte_guida_calcolatore');
    // Lo slug si controlla com'è scritto, senza normalizzarlo prima (rilievo Codex su 3a987b3).
    $file = lanotte_guida_calcolatore_file((string) $atts['slug']);
    if (!$file) return '';
    $html = (string) file_get_contents($file);
    if (trim($html) === '') return '';
    return do_shortcode($html);
});

/**
 * Tabella dei tassi più recenti, dal più nuovo: tipo «moratori» (semestri, BCE, tasso di mora, fonte) o «legali»
 * (anni, tasso, fonte). Solo righe già iniziate alla data di oggi (Roma). Vuota se il file manca.
 */
function lanotte_tabella_tassi_html($tipo, $righe = 6, $oggi = null, $dati = null) {
    $tipo = $tipo === 'legali' ? 'legali' : 'moratori';
    $righe = max(1, min(20, (int) $righe));
    if ($oggi === null) $oggi = function_exists('wp_date') ? wp_date('Y-m-d', null, new DateTimeZone('Europe/Rome')) : gmdate('Y-m-d');
    if ($dati === null) $dati = function_exists('lanotte_dv_json') ? lanotte_dv_json('interessi-' . $tipo . '.json') : null;
    $tassi = is_array($dati['tassi'] ?? null) ? $dati['tassi'] : [];
    $tassi = array_values(array_filter($tassi, function ($t) use ($oggi) {
        // Date solo nel formato AAAA-MM-GG: con uno spazio iniziale (« 2027-01-01») il confronto fra stringhe farebbe
        // passare un semestre futuro (rilievo Codex su 3a987b3).
        return is_array($t) && is_string($t['dal'] ?? null) && is_string($t['al'] ?? null)
            && preg_match('~^\d{4}-\d{2}-\d{2}$~', $t['dal']) && preg_match('~^\d{4}-\d{2}-\d{2}$~', $t['al'])
            && $t['dal'] <= $oggi;
    }));
    usort($tassi, function ($a, $b) { return strcmp($b['dal'], $a['dal']); });
    $tassi = array_slice($tassi, 0, $righe);
    if (!$tassi) return '';

    $data = function ($iso) { return preg_match('~^(\d{4})-(\d{2})-(\d{2})$~', $iso, $m) ? $m[3] . '/' . $m[2] . '/' . $m[1] : $iso; };
    if ($tipo === 'moratori') {
        $testa = '<tr><th scope="col">Periodo</th><th scope="col">Tasso BCE</th><th scope="col">Tasso di mora</th><th scope="col">Fonte</th></tr>';
        $corpo = '';
        foreach ($tassi as $t) {
            if (!is_numeric($t['saggio_bce'] ?? null) || !is_numeric($t['moratorio'] ?? null)) continue;
            $corpo .= '<tr><td>' . esc_html($data($t['dal']) . ' – ' . $data($t['al'])) . '</td><td>'
                . esc_html(number_format((float) $t['saggio_bce'], 2, ',', '.')) . '%</td><td><strong>'
                . esc_html(number_format((float) $t['moratorio'], 2, ',', '.')) . '%</strong></td><td>'
                . esc_html((string) ($t['norma'] ?? '')) . '</td></tr>';
        }
        $titolo = 'Tasso degli interessi di mora (D.Lgs. 231/2002), ultimi semestri';
    } else {
        $testa = '<tr><th scope="col">Periodo</th><th scope="col">Tasso legale</th><th scope="col">Fonte</th></tr>';
        $corpo = '';
        foreach ($tassi as $t) {
            if (!is_numeric($t['tasso'] ?? null)) continue;
            $tasso = function_exists('lanotte_dv_tasso') ? lanotte_dv_tasso($t['tasso']) : (string) $t['tasso'];
            $corpo .= '<tr><td>' . esc_html($data($t['dal']) . ' – ' . $data($t['al'])) . '</td><td><strong>'
                . esc_html($tasso) . '%</strong></td><td>' . esc_html((string) ($t['norma'] ?? '')) . '</td></tr>';
        }
        $titolo = 'Tasso degli interessi legali (art. 1284 c.c.), ultimi anni';
    }
    if ($corpo === '') return '';
    return '<div class="lanotte-calc-guida-tabella"><table><caption>' . esc_html($titolo) . '</caption><thead>' . $testa
        . '</thead><tbody>' . $corpo . '</tbody></table></div>';
}

add_shortcode('lanotte_tabella_tassi', function ($atts) {
    $atts = shortcode_atts(['tipo' => 'moratori', 'righe' => 6], $atts, 'lanotte_tabella_tassi');
    return lanotte_tabella_tassi_html($atts['tipo'], $atts['righe']);
});
