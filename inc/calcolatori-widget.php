<?php
/**
 * Calcolatori incorporabili (21/10/2026): /widget/<slug>/ e pagina «Incorpori i calcolatori» (/calcolatori/incorpora/).
 *
 * Perché: il primo risultato su quasi tutte le ricerche dei calcolatori ha i propri strumenti incorporati in siti terzi
 * con un collegamento in entrata, misurato il 21/10/2026; noi non ne abbiamo.
 *
 * /widget/<slug>/ è una pagina minima con il solo calcolatore (lanotte_render_calcolatore) e lo stile del tema:
 * niente wp_head()/wp_footer(), quindi niente intestazione, menu, piè di pagina, CookieYes, Site Kit, conversioni,
 * WhatsApp flottante né caratteri di Google. Un iframe su un sito altrui non deve tracciare né chiedere consensi.
 * Si può incorniciare da qualunque sito (Content-Security-Policy: frame-ancestors *, nessun X-Frame-Options:
 * l'eccezione è in inc/security.php); noindex e canonical alla pagina del calcolatore. Uno slug inesistente dà 404.
 *
 * Il collegamento che conta per Google è quello del codice da copiare, fuori dall'iframe: il testo è il nome dello
 * Studio e non una parola chiave, perché le norme di Google contro lo spam (lette il 21/10/2026, aggiornate al
 * 28/08/2026) vietano i collegamenti «keyword-rich, hidden, or low-quality» nei widget distribuiti su più siti.
 */

if (!defined('ABSPATH')) exit;

/** Slug del calcolatore se il percorso è /widget/<slug>/ di un calcolatore che esiste, altrimenti null. */
function lanotte_widget_slug($percorso) {
    if (!is_string($percorso) || !preg_match('~^/widget/([a-z0-9-]+)/?$~', $percorso, $m)) return null;
    return isset(lanotte_calcolatori_map()[$m[1]]) ? $m[1] : null;
}

/** Il percorso cade sotto /widget/, anche con uno slug inesistente o scritto male. */
function lanotte_widget_sotto($percorso) {
    return is_string($percorso) && (bool) preg_match('~^/widget(?:/|$)~', $percorso);
}

function lanotte_widget_percorso_richiesta() {
    return (string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
}

/**
 * Intestazioni sull'incorniciamento per il percorso: le sole pagine /widget/<slug>/ di un calcolatore esistente si
 * possono mostrare in un iframe di qualunque sito; tutto il resto, compresi i 404 sotto /widget/, resta SAMEORIGIN.
 */
function lanotte_intestazioni_cornice($percorso) {
    return lanotte_widget_slug($percorso) !== null
        ? ['Content-Security-Policy: frame-ancestors *']
        : ['X-Frame-Options: SAMEORIGIN'];
}

function lanotte_widget_url($slug) {
    return home_url('/widget/' . $slug . '/');
}

/** Nome del calcolatore per il codice e per la pagina: il titolo della pagina senza «(gratuito)». */
function lanotte_widget_nome($slug) {
    $titolo = lanotte_calcolatori_pages_data()[$slug]['title'] ?? $slug;
    return trim(preg_replace('~\s*\(gratuito\)\s*$~u', '', $titolo));
}

/** Pagina completa del widget: il calcolatore già composto e, in fondo, la riga con lo Studio. */
function lanotte_widget_documento($slug, $calcolatore) {
    $css = LANOTTE_THEME_DIR . '/assets/style.css';
    $css_url = LANOTTE_THEME_URI . '/assets/style.css' . (is_readable($css) ? '?ver=' . filemtime($css) : '');
    $pagina = lanotte_calcolatore_url($slug);

    // <base target="_blank">: i collegamenti del calcolatore aprono il sito dello Studio in una nuova scheda, mai dentro la
    // cornice del sito che lo ospita.
    return '<!DOCTYPE html>' . "\n"
        . '<html lang="it">' . "\n" . '<head>' . "\n"
        . '<meta charset="UTF-8">' . "\n"
        . '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n"
        . '<meta name="robots" content="noindex">' . "\n"
        . '<title>' . esc_html(lanotte_widget_nome($slug)) . ' — Studio Legale LANOTTE &amp; Partners</title>' . "\n"
        . '<link rel="canonical" href="' . esc_url($pagina) . '">' . "\n"
        . '<base target="_blank">' . "\n"
        . '<link rel="stylesheet" href="' . esc_url($css_url) . '">' . "\n"
        . '<style>body.lanotte-widget{background:#fff;margin:0}'
        . '.lanotte-widget section.block,.lanotte-widget section.block-sm{padding:24px 0}'
        . '.lanotte-widget .container{padding:0 16px}'
        . '.lanotte-widget-firma{margin:0;padding:12px 16px;border-top:1px solid #e5e7eb;font-size:13px;line-height:1.5;color:#475569;text-align:center}'
        . '.lanotte-widget-firma a{color:var(--navy);font-weight:600}</style>' . "\n"
        . '</head>' . "\n"
        . '<body class="lanotte-widget">' . "\n"
        . $calcolatore . "\n"
        . '<p class="lanotte-widget-firma">Calcolatore a cura di <a href="' . esc_url($pagina) . '" target="_blank" rel="noopener">Studio Legale LANOTTE &amp; Partners</a></p>' . "\n"
        . '</body>' . "\n" . '</html>' . "\n";
}

/**
 * Codice da copiare: l'iframe e, fuori dall'iframe, la riga con il collegamento alla pagina del calcolatore.
 * Altezza fissa con scorrimento interno, al più l'85% dello schermo (min() dove il browser lo conosce, altrimenti i pixel).
 * Niente altezza automatica: misurati il 21/10/2026, i calcolatori sono alti da 1.050 a 5.218 pixel e l'anteprima del
 * report (lanotte-preview.js, lanotte-pdf.js) è un riquadro fisso alto 100vh, che in una cornice alta quanto il
 * calcolatore si aprirebbe fuori dalla vista.
 */
function lanotte_widget_codice($slug, $altezza = 900) {
    $altezza = max(400, (int) $altezza);
    return '<iframe src="' . esc_url(lanotte_widget_url($slug)) . '" title="' . esc_attr(lanotte_widget_nome($slug)) . '"'
        . ' width="100%" height="' . $altezza . '" loading="lazy" style="width:100%;max-width:100%;height:' . $altezza . 'px;height:min(' . $altezza . 'px,85vh);border:0"></iframe>' . "\n"
        . '<p style="font-size:13px">Calcolatore a cura di <a href="' . esc_url(lanotte_calcolatore_url($slug)) . '" target="_blank" rel="noopener">Studio Legale LANOTTE &amp; Partners</a></p>';
}

add_action('template_redirect', function () {
    $percorso = lanotte_widget_percorso_richiesta();
    if (!lanotte_widget_sotto($percorso)) return;

    $slug = lanotte_widget_slug($percorso);
    $calcolatore = $slug !== null ? lanotte_render_calcolatore($slug) : '';
    if ($calcolatore === '') {
        // Slug inesistente o file del calcolatore illeggibile: 404 di WordPress. Senza togliere redirect_canonical,
        // /widget/tfr/ senza calcolatore verrebbe «indovinato» e mandato con un 301 su /calcolatori/tfr/ (misurato il
        // 21/10/2026 sul sito in linea, dove /widget/ non esiste ancora).
        global $wp_query;
        if (is_object($wp_query) && method_exists($wp_query, 'set_404')) $wp_query->set_404();
        remove_action('template_redirect', 'redirect_canonical');
        status_header(404);
        nocache_headers();
        return;
    }

    // WordPress ha già trattato la richiesta come 404 (nessuna pagina /widget/…) e mandato le intestazioni anti-cache.
    status_header(200);
    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: public, max-age=3600');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    header_remove('Pragma');
    header_remove('X-Frame-Options');
    header('X-Robots-Tag: noindex');
    echo lanotte_widget_documento($slug, $calcolatore);
    exit;
}, 0);

/* ============================================================
   Pagina pubblica «Incorpori i calcolatori nel Suo sito»
============================================================ */

function lanotte_widget_pagina_incorpora() {
    $voci = '';
    foreach (array_keys(lanotte_calcolatori_map()) as $slug) {
        $id = 'lanotte-codice-' . $slug;
        $voci .= '<details class="lanotte-incorpora-voce"><summary>' . esc_html(lanotte_widget_nome($slug)) . '</summary>'
            . '<p><a href="' . esc_url(lanotte_calcolatore_url($slug)) . '">Apra il calcolatore</a> per vederlo prima di incorporarlo.</p>'
            . '<label for="' . esc_attr($id) . '">Codice da incollare nella pagina</label>'
            // esc_textarea e non esc_html: esc_html non ricodifica «&amp;» e nella casella comparirebbe un codice diverso.
            . '<textarea id="' . esc_attr($id) . '" rows="5" readonly>' . esc_textarea(lanotte_widget_codice($slug)) . '</textarea>'
            . '<button type="button" class="btn btn-outline" data-lanotte-copia="' . esc_attr($id) . '">Copia il codice</button>'
            . '</details>';
    }

    return '<section class="lanotte-incorpora"><div class="container" style="max-width:860px">'
        . '<p>I calcolatori dello Studio si possono inserire in un altro sito, per esempio nella pagina di un\'associazione, di un ente o di un professionista. Basta copiare il codice del calcolatore scelto e incollarlo nella pagina, nella modalità che accetta il codice HTML.</p>'
        . '<h2>Come funziona</h2><ul>'
        . '<li>Il codice mostra il calcolatore in una cornice (iframe) larga quanto la colonna della pagina e alta 900 pixel, o meno sugli schermi piccoli; il calcolatore scorre al suo interno. L\'altezza si può modificare nel codice.</li>'
        . '<li>Sotto la cornice c\'è una riga con il nome dello Studio e il collegamento alla pagina del calcolatore: chiediamo di lasciarla visibile e invariata.</li>'
        . '<li>Il calcolatore incorporato non installa cookie e non usa strumenti di statistica o di pubblicità. Alcuni calcolatori conservano nel browser una copia degli indici e dei tassi pubblici, per non scaricarli a ogni uso; quelli che preparano il PDF scaricano la libreria jsPDF da cdnjs.cloudflare.com, e quelli basati sugli indici ISTAT possono leggerli dal sito dell\'ISTAT.</li>'
        . '<li>Indici, tassi e correzioni si pubblicano sul sito dello Studio: il calcolatore incorporato mostra sempre la versione in linea, senza interventi da parte Sua.</li>'
        . '<li>I risultati sono indicativi: non sostituiscono la consulenza legale e vanno verificati sul caso concreto.</li>'
        . '</ul><h2>I calcolatori</h2>' . $voci
        . '<p>Per domande sull\'incorporamento può scrivere allo Studio dalla pagina <a href="' . esc_url(home_url('/contatti/')) . '">Contatti</a>.</p>'
        . '</div></section>'
        . '<style>.lanotte-incorpora{padding:48px 0}.lanotte-incorpora ul{margin:0 0 32px;padding-left:20px;line-height:1.65}'
        . '.lanotte-incorpora-voce{border:1px solid #e5e7eb;border-radius:6px;padding:12px 16px;margin:0 0 10px;background:#fff}'
        . '.lanotte-incorpora-voce summary{cursor:pointer;font-weight:600;color:var(--navy)}'
        . '.lanotte-incorpora-voce label{display:block;font-size:13px;color:#475569;margin:8px 0 4px}'
        . '.lanotte-incorpora-voce textarea{width:100%;font:12px/1.5 ui-monospace,Menlo,Consolas,monospace;padding:8px;border:1px solid #cbd5e1;border-radius:4px;margin:0 0 8px}</style>'
        . '<script>document.addEventListener("click",function(e){var b=e.target.closest("[data-lanotte-copia]");if(!b)return;'
        . 'var t=document.getElementById(b.getAttribute("data-lanotte-copia"));if(!t)return;t.focus();t.select();'
        . 'function esito(ok){b.textContent=ok?"Codice copiato":"Codice selezionato: lo copi con Ctrl+C o Cmd+C";}'
        . 'function riserva(){var ok=false;try{ok=document.execCommand("copy");}catch(x){}esito(ok);}'
        . 'if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(t.value).then(function(){esito(true);},riserva);}else{riserva();}});</script>';
}

add_shortcode('lanotte_incorpora_calcolatori', 'lanotte_widget_pagina_incorpora');

function lanotte_widget_pagina_dati() {
    return [
        'title' => 'Incorpori i calcolatori nel Suo sito',
        'description' => 'Il codice per inserire i calcolatori dello Studio Legale LANOTTE & Partners in un altro sito: una cornice senza cookie né statistiche e una riga con il collegamento al calcolatore.',
    ];
}

/**
 * Crea o aggiorna la pagina /calcolatori/incorpora/ al cambio di versione del tema, come le pagine dei calcolatori
 * (inc/calcolatori-router.php). La versione si registra solo se la pagina risulta pubblicata con slug e titolo giusti;
 * se qualcosa non va si riprova al più una volta l'ora e il guasto va nel log.
 */
function lanotte_widget_crea_pagina() {
    if (get_option('lanotte_widget_incorpora_version') === LANOTTE_THEME_VERSION) return;
    if (!function_exists('wp_insert_post')) return;
    $adesso = (int) current_time('timestamp', true);
    if ($adesso - (int) get_option('lanotte_widget_incorpora_tentativo', 0) < HOUR_IN_SECONDS) return;

    $dati = lanotte_widget_pagina_dati();
    $parent = get_page_by_path('calcolatori');
    $salvata = null;
    if ($parent) {
        $page = get_page_by_path('calcolatori/incorpora', OBJECT, 'page');
        $postarr = [
            'post_title'   => $dati['title'],
            'post_name'    => 'incorpora',
            'post_parent'  => (int) $parent->ID,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '[lanotte_incorpora_calcolatori]',
        ];
        if ($page) {
            $postarr['ID'] = (int) $page->ID;
            $post_id = wp_update_post($postarr, true);
        } else {
            $post_id = wp_insert_post($postarr, true);
        }
        $salvata = $post_id && !is_wp_error($post_id) ? get_post((int) $post_id) : null;
    }

    if (!$salvata || $salvata->post_status !== 'publish' || $salvata->post_name !== 'incorpora' || $salvata->post_title !== $dati['title']) {
        update_option('lanotte_widget_incorpora_tentativo', $adesso, false);
        error_log('lanotte_widget: pagina calcolatori/incorpora non creata o non aggiornata per la versione ' . LANOTTE_THEME_VERSION
            . ($parent ? '' : ' (manca la pagina calcolatori)') . ': nuovo tentativo fra un\'ora');
        return;
    }
    update_post_meta($salvata->ID, '_aioseo_title', $dati['title'] . ' | Studio Legale LANOTTE');
    update_post_meta($salvata->ID, '_aioseo_description', $dati['description']);
    delete_option('lanotte_widget_incorpora_tentativo');
    update_option('lanotte_widget_incorpora_version', LANOTTE_THEME_VERSION, false);
}
add_action('init', 'lanotte_widget_crea_pagina', 31);
