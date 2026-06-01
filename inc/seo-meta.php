<?php
/**
 * SEO meta per pagina/area — titoli e descrizioni ottimizzati (focus Barletta).
 *
 * Si integra con AIOSEO tramite i filtri ufficiali `aioseo_title` /
 * `aioseo_description`. Fallback nativo (document_title_parts + meta description)
 * se AIOSEO non è attivo. Mappa per slug di pagina e per slug di area.
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

function lanotte_seo_map() {
    $brand = 'LANOTTE & Partners';
    return [
        // === HOME ===
        '_home' => [
            't' => 'Studio Legale a Barletta (Foro di Trani) | ' . $brand,
            'd' => 'Studio legale a Barletta: assistenza in diritto civile, penale, famiglia, impresa e proprietà intellettuale. Foro di Trani. Preventivo scritto.',
        ],
        // === PAGINE ===
        'lo-studio' => [
            't' => 'Lo Studio · Avvocati a Barletta e Trani | ' . $brand,
            'd' => 'Studio Legale LANOTTE & Partners a Barletta, Foro di Trani: diritto civile, penale, d\'impresa e proprietà intellettuale (UIBM, EUIPO, OMPI).',
        ],
        'onorari' => [
            't' => 'Onorari e Servizi Online · Avvocato a Barletta | ' . $brand,
            'd' => 'Trasparenza sui compensi: preventivo scritto ex art. 13 L. 247/2012. Consulenze e servizi legali online dello Studio a Barletta e Trani.',
        ],
        'contatti' => [
            't' => 'Contatti · Studio Legale a Barletta | ' . $brand,
            'd' => 'Contatta lo Studio Legale a Barletta (Foro di Trani): telefono, WhatsApp, email e modulo. Sede in Viale Falcone e Borsellino. Risposta in 24 ore.',
        ],
        'calcolatori' => [
            't' => 'Calcolatori Giuridici Gratuiti · Avvocato Barletta | ' . $brand,
            'd' => '16 calcolatori giuridici gratuiti: parcella forense, danni, ISTAT, interessi, scadenze, contributo unificato. Studio Legale a Barletta e Trani.',
        ],
        'casi-studio' => [
            't' => 'Casi Studio · Scenari Illustrativi | ' . $brand,
            'd' => 'Scenari illustrativi che mostrano il metodo dello Studio nelle varie materie del diritto. Esempi a fini divulgativi. Avvocato a Barletta e Trani.',
        ],
        'penale-urgenza' => [
            't' => 'Penale d\'Urgenza H24 a Barletta | ' . $brand,
            'd' => 'Assistenza penale d\'urgenza per arresti, fermi e perquisizioni a Barletta e nel Foro di Trani. Reperibilità telefonica anche notturna e festiva.',
        ],
        'carriere' => [
            't' => 'Carriere · Cerchiamo Avvocati a Barletta | ' . $brand,
            'd' => 'Opportunità di collaborazione con lo Studio Legale LANOTTE & Partners a Barletta. Invia la candidatura a info@studiolegalelanotte.it.',
        ],
        'glossario' => [
            't' => 'Glossario Giuridico · Studio Legale | ' . $brand,
            'd' => 'Glossario giuridico con i termini legali spiegati in modo chiaro, a cura dello Studio Legale LANOTTE & Partners di Barletta (Foro di Trani).',
        ],
        'newsletter' => [
            't' => 'Newsletter Giuridica · Studio Legale | ' . $brand,
            'd' => 'Iscriviti alla newsletter dello Studio Legale LANOTTE & Partners di Barletta: aggiornamenti e approfondimenti giuridici, senza spam.',
        ],
        'privacy' => [
            't' => 'Privacy Policy | Studio Legale ' . $brand,
            'd' => 'Informativa sul trattamento dei dati personali dello Studio Legale LANOTTE & Partners, Barletta (Foro di Trani), ai sensi del Reg. UE 2016/679.',
        ],
        'cookie' => [
            't' => 'Cookie Policy | Studio Legale ' . $brand,
            'd' => 'Informativa sull\'uso dei cookie del sito dello Studio Legale LANOTTE & Partners, Barletta (Foro di Trani).',
        ],
        'credits' => [
            't' => 'Credits | Studio Legale ' . $brand,
            'd' => 'Attribuzioni di immagini, tipografia e risorse del sito dello Studio Legale LANOTTE & Partners, Barletta.',
        ],
        // === AREE (per slug) — focus Barletta + Foro di Trani ===
        'diritto-penale' => [
            't' => 'Avvocato Penalista a Barletta e Trani | ' . $brand,
            'd' => 'Difesa penale a Barletta in ogni grado: indagini, misure cautelari, dibattimento, parte civile. Reperibilità per urgenze. Preventivo scritto.',
        ],
        'diritto-civile' => [
            't' => 'Avvocato Civilista a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato civilista a Barletta: contratti, recupero crediti, locazioni, responsabilità e risarcimenti. Assistenza stragiudiziale e giudiziale.',
        ],
        'famiglia-successioni' => [
            't' => 'Avvocato Famiglia e Successioni a Barletta | ' . $brand,
            'd' => 'Separazione, divorzio, affidamento, eredità e divisioni a Barletta e Trani. Soluzioni consensuali e tutela del patrimonio. Preventivo scritto.',
        ],
        'condominio' => [
            't' => 'Avvocato Condominialista a Barletta | ' . $brand,
            'd' => 'Avvocato per il condominio a Barletta: impugnazione delibere, spese, decreti ingiuntivi e lavori. Assistenza a condòmini e amministratori.',
        ],
        'impresa' => [
            't' => 'Avvocato Diritto d\'Impresa a Barletta | ' . $brand,
            'd' => 'Avvocato d\'impresa a Barletta: contratti commerciali, società, recupero crediti e crisi d\'impresa. Consulenza continuativa per aziende.',
        ],
        'infortunistica-malasanita' => [
            't' => 'Risarcimento Danni e Malasanità a Barletta | ' . $brand,
            'd' => 'Avvocato per risarcimento danni a Barletta: sinistri stradali, infortuni e responsabilità medica. Valutazione medico-legale e contestazione offerte.',
        ],
        'lavoro' => [
            't' => 'Avvocato del Lavoro a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato del lavoro a Barletta: licenziamenti, differenze retributive, demansionamento. Tutela di lavoratori e aziende. Preventivo scritto.',
        ],
        'tributario' => [
            't' => 'Avvocato Tributarista a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato tributarista a Barletta: cartelle, accertamenti, ricorsi e riscossione. Difesa innanzi alla Corte di Giustizia Tributaria.',
        ],
        'proprieta-intellettuale' => [
            't' => 'Avvocato Marchi e Brevetti UIBM/EUIPO | ' . $brand,
            'd' => 'Registrazione e tutela di marchi, brevetti e design davanti a UIBM, EUIPO e OMPI. Opposizioni e contraffazione. Studio a Barletta (Foro di Trani).',
        ],
        'bancario' => [
            't' => 'Avvocato Diritto Bancario a Barletta | ' . $brand,
            'd' => 'Avvocato per il diritto bancario a Barletta: anatocismo, usura, mutui, fideiussioni e segnalazioni CRIF. Perizia econometrica e azione giudiziale.',
        ],
        'internazionale-privato' => [
            't' => 'Avvocato Internazionale a Barletta e Trani | ' . $brand,
            'd' => 'Contratti cross-border, successioni internazionali e riconoscimento di sentenze estere (Bruxelles I-bis, Roma I). Studio a Barletta (Foro di Trani).',
        ],
        'previdenza' => [
            't' => 'Avvocato Invalidità INPS e Legge 104 | ' . $brand,
            'd' => 'Ricorsi INPS, invalidità civile, Legge 104 e accompagnamento a Barletta. Accertamento tecnico preventivo ex art. 445-bis c.p.c.',
        ],
        'no-profit' => [
            't' => 'Avvocato ETS, RUNTS e ASD a Barletta | ' . $brand,
            'd' => 'Costituzione ETS, iscrizione RUNTS, statuti e ASD/SSD a Barletta e Trani. Consulenza legale e fiscale per associazioni. Preventivo scritto.',
        ],
    ];
}

/**
 * Chiave SEO della pagina/area correntemente visualizzata.
 */
function lanotte_seo_current_key() {
    if (is_front_page()) return '_home';
    if (is_post_type_archive('caso')) return 'casi-studio';
    $obj = get_queried_object();
    if ($obj instanceof WP_Post && !empty($obj->post_name)) return $obj->post_name;
    return '';
}

/* === Integrazione AIOSEO (filtri ufficiali) === */
add_filter('aioseo_title', function($title) {
    $map = lanotte_seo_map();
    $k = lanotte_seo_current_key();
    return ($k && isset($map[$k]['t'])) ? $map[$k]['t'] : $title;
});
add_filter('aioseo_description', function($desc) {
    $map = lanotte_seo_map();
    $k = lanotte_seo_current_key();
    return ($k && isset($map[$k]['d'])) ? $map[$k]['d'] : $desc;
});

/* === Fallback nativo se AIOSEO non è attivo === */
add_filter('document_title_parts', function($parts) {
    if (defined('AIOSEO_VERSION')) return $parts; // AIOSEO gestisce il title
    $map = lanotte_seo_map();
    $k = lanotte_seo_current_key();
    if ($k && isset($map[$k]['t'])) {
        $parts = ['title' => $map[$k]['t']];
    }
    return $parts;
}, 99);

add_action('wp_head', function() {
    if (defined('AIOSEO_VERSION')) return; // AIOSEO genera la meta description
    $map = lanotte_seo_map();
    $k = lanotte_seo_current_key();
    if ($k && isset($map[$k]['d'])) {
        echo '<meta name="description" content="' . esc_attr($map[$k]['d']) . '">' . "\n";
    }
}, 1);
