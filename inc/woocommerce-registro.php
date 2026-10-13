<?php
/**
 * Registro di cortesia nei testi di WooCommerce (negozio dei servizi, scheda del servizio, cassa,
 * messaggi ed email generati dal sito pubblico).
 *
 * La traduzione italiana di WooCommerce dà del «tu» («Aggiungi al carrello», «Il tuo ordine»,
 * «Hai un codice promozionale?»); il sito dà del «Lei». Si interviene sulla traduzione già fatta
 * (il testo italiano), solo nel dominio «woocommerce» e solo fuori dal pannello di amministrazione.
 * Misura del 13/10/2026 su /servizi-online/, sulla scheda di un servizio e su /checkout/ con un
 * servizio nel carrello: le frasi trovate sono nell'elenco $esatte qui sotto.
 *
 * Inoltre: il collegamento all'informativa nella cassa usciva con href="" perché WordPress non ha
 * una pagina della privacy impostata; se manca, si usa la pagina «privacy» del sito.
 */

if (!defined('ABSPATH')) exit;

/** Testo italiano di WooCommerce → stesso testo al «Lei». Funzione pura (si prova in locale). */
function lanotte_woo_lei($t) {
    if (!is_string($t) || $t === '') return $t;
    static $esatte = [
        'Leggi tutto'                                          => 'Dettagli del servizio',
        'Il tuo ordine'                                        => 'Riepilogo dell’ordine',
        'Hai un codice promozionale?'                          => 'Ha un codice promozionale?',
        'Fai clic qui per inserire il tuo codice promozionale' => 'Faccia clic qui per inserire il codice promozionale',
        'Inserisci il tuo codice promozionale'                 => 'Inserisca il codice promozionale',
        'Applica codice promozionale'                          => 'Applichi il codice promozionale',
        'Aggiorna totale'                                      => 'Aggiorni il totale',
        'Aggiorna Totale'                                      => 'Aggiorni il totale',
        'Aggiorna il Paese/la regione'                         => 'Aggiorni il Paese o la regione',
        'Effettua ordine'                                      => 'Effettui l’ordine',
        'Seleziona un paese / una regione…'                    => 'Scelga un Paese o una regione…',
        'Seleziona un\'opzione…'                               => 'Scelga un’opzione…',
        'Seleziona un’opzione…'                                => 'Scelga un’opzione…',
    ];
    if (isset($esatte[$t])) return $esatte[$t];

    // Imperativi all'inizio del testo o di una frase («. », «? », «! », «: »).
    static $imperativi = [
        'Aggiungi' => 'Aggiunga', 'Aggiorna' => 'Aggiorni', 'Applica' => 'Applichi', 'Effettua' => 'Effettui',
        'Inserisci' => 'Inserisca', 'Seleziona' => 'Selezioni', 'Scegli' => 'Scelga', 'Fai clic' => 'Faccia clic',
        'Clicca' => 'Clicchi', 'Procedi' => 'Proceda', 'Continua' => 'Continui', 'Torna' => 'Torni',
        'Visualizza' => 'Visualizzi', 'Vedi' => 'Veda', 'Leggi' => 'Legga', 'Controlla' => 'Controlli',
        'Riprova' => 'Riprovi', 'Svuota' => 'Svuoti', 'Completa' => 'Completi', 'Crea' => 'Crei',
        'Ricorda' => 'Ricordi', 'Accedi' => 'Acceda', 'Registrati' => 'Si registri', 'Rimuovi' => 'Rimuova',
        'Hai' => 'Ha', 'Puoi' => 'Può', 'Devi' => 'Deve', 'Vuoi' => 'Vuole',
        // non «Sei» da solo: a inizio frase può essere il numerale («Sei mesi…»)
    ];
    foreach ($imperativi as $tu => $lei) {
        $t = preg_replace('/(^|[.?!:]\s+)' . preg_quote($tu, '/') . '\b(?=\s)/u', '$1' . $lei, $t);
    }

    // Seconda persona dentro la frase: pronomi, verbi e possessivi (questi ultimi con l'iniziale maiuscola,
    // come nel resto del sito: «il Suo caso»).
    static $dentro = [
        '/\bassicurati\b/u'      => 'si assicuri',
        '/\bti venga\b/u'        => 'Le venga',
        '/\bti preghiamo\b/u'    => 'La preghiamo',
        '/\bti invieremo\b/u'    => 'Le invieremo',
        '/\bse non lo fai\b/u'   => 'se non lo fa',
        '/\bsei sicuro\b/u'      => 'è sicuro',
        '/(^|[.?!:]\s+)Sei sicuro\b/u' => '$1È sicuro',
        '/\bhai\b/u'             => 'ha',
        '/\bpuoi\b/u'            => 'può',
        '/\bdevi\b/u'            => 'deve',
        '/\bvuoi\b/u'            => 'vuole',
        '/\btuoi\b/u'            => 'Suoi',
        '/\btue\b/u'             => 'Sue',
        '/\btuo\b/u'             => 'Suo',
        '/\btua\b/u'             => 'Sua',
    ];
    return preg_replace(array_keys($dentro), array_values($dentro), $t);
}

/** Vale solo per il sito pubblico (anche le richieste AJAX della cassa); il pannello resta in originale. */
function lanotte_woo_lei_attivo($domain) {
    return $domain === 'woocommerce' && (!is_admin() || wp_doing_ajax());
}

add_filter('gettext', function ($traduzione, $testo, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, 20, 3);

add_filter('gettext_with_context', function ($traduzione, $testo, $contesto, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, 20, 4);

add_filter('ngettext', function ($traduzione, $singolare, $plurale, $numero, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, 20, 5);

// Il testo sulla privacy della cassa è un'opzione di WooCommerce, non passa da gettext.
add_filter('woocommerce_get_privacy_policy_text', function ($testo) {
    return is_admin() && !wp_doing_ajax() ? $testo : lanotte_woo_lei($testo);
}, 20);

// Pagina della privacy non impostata in WordPress: il collegamento nella cassa usciva vuoto.
add_filter('privacy_policy_url', function ($url) {
    if ($url) return $url;
    $pagina = get_page_by_path('privacy');
    return ($pagina instanceof WP_Post && $pagina->post_status === 'publish') ? get_permalink($pagina) : $url;
});
