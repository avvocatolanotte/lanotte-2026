<?php
/**
 * Registro di cortesia nei testi di WooCommerce (negozio dei servizi, scheda del servizio, cassa,
 * parametri degli script, email al cliente) e collegamento all'informativa nella cassa.
 *
 * La traduzione italiana di WooCommerce dà del «tu» («Aggiungi al carrello», «Il tuo ordine»,
 * «Hai un codice promozionale?»); il sito dà del «Lei». Si interviene sulla traduzione già fatta
 * (il testo italiano), solo nel dominio «woocommerce», solo nel sito pubblico (comprese le richieste
 * /?wc-ajax= della cassa, che non sono pannello) e nelle email destinate al cliente. Il pannello di
 * amministrazione, comprese le sue richieste AJAX, resta nella traduzione originale.
 * Misura del 13/10/2026: /servizi-online/, la scheda di un servizio e /checkout/ con un servizio nel
 * carrello (frasi in $esatte). Per i testi non misurati valgono regole generiche con una guardia:
 * se dopo la conversione resta una forma al «tu», si restituisce la frase originale intera, mai una
 * frase mista (rilievo di Codex, 13/10/2026).
 *
 * Testi degli script (WooPayments e WordPress): v. lanotte_woo_lei_esatta() più sotto.
 *
 * Collegamento all'informativa: wp_page_for_privacy_policy = 3, pagina inesistente (misura del
 * 13/10/2026), quindi WooCommerce stampava <a href="">. Se la pagina impostata non è pubblicata si
 * usa la pagina «privacy» del sito.
 */

if (!defined('ABSPATH')) exit;

/** Forme al «tu» che, se restano dopo la conversione, rendono la frase mista. */
function lanotte_woo_residuo_tu($t) {
    // i segnaposti si attaccano alle parole («%1$sAggiorna Totale%2$s»): si neutralizzano prima
    $t = preg_replace('/%(\d+\$)?[sd]/u', ' ', $t);
    return (bool) preg_match('/\b(inserisci|seleziona|scegli|clicca|premi|digita|controlla|assicurati|riprova|accedi|'
        . 'registrati|procedi|continua|torna|aggiungi|aggiorna|applica|effettua|completa|crea|ricorda|visualizza|'
        . 'vedi|leggi|usa|utilizza|imposta|elimina|rimuovi|svuota|paga|ordina|contatta|contattaci|scrivici|fai|'
        . 'hai|sei|puoi|devi|vuoi|tuo|tua|tuoi|tue|ti|te)\b/iu', $t);
}

/** Testo italiano di WooCommerce → stesso testo al «Lei». Funzione pura (si prova in locale). */
function lanotte_woo_lei($t) {
    if (!is_string($t) || $t === '') return $t;
    static $esatte = [
        // negozio e scheda del servizio
        'Leggi tutto'                                          => 'Dettagli del servizio',
        'Visualizza carrello'                                  => 'Visualizzi il carrello',
        'Ordina in base al più recente'                        => 'Più recenti',
        'Seleziona una valutazione'                            => 'Selezioni una valutazione',
        'Visualizza la galleria di immagini a schermo intero'  => 'Visualizzi la galleria di immagini a schermo intero',
        'Mostra password'                                      => 'Mostri la password',
        'Nascondi password'                                    => 'Nasconda la password',
        // cassa
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
        // selettore dei Paesi (parametri dello script)
        'Elimina 1 carattere'                                  => 'Elimini 1 carattere',
        'Elimina %qty% caratteri'                              => 'Elimini %qty% caratteri',
        'Inserisci 1 o più caratteri'                          => 'Inserisca 1 o più caratteri',
        'Inserisci %qty% o più caratteri'                      => 'Inserisca %qty% o più caratteri',
        'Puoi selezionare solo 1 articolo'                     => 'Può selezionare solo 1 articolo',
        'Puoi selezionare solo %qty% articoli'                 => 'Può selezionare solo %qty% articoli',
    ];
    if (isset($esatte[$t])) return $esatte[$t];

    $originale = $t;

    // Imperativi all'inizio del testo o di una frase («. », «? », «! », «: »), solo se seguiti da altre
    // parole: i comandi di una parola («Rimuovi», «Accedi») restano. Non «Sei»: può essere il numerale.
    static $imperativi = [
        'Aggiungi' => 'Aggiunga', 'Aggiorna' => 'Aggiorni', 'Applica' => 'Applichi', 'Effettua' => 'Effettui',
        'Inserisci' => 'Inserisca', 'Seleziona' => 'Selezioni', 'Scegli' => 'Scelga', 'Fai clic' => 'Faccia clic',
        'Clicca' => 'Clicchi', 'Procedi' => 'Proceda', 'Continua' => 'Continui', 'Torna' => 'Torni',
        'Visualizza' => 'Visualizzi', 'Vedi' => 'Veda', 'Leggi' => 'Legga', 'Controlla' => 'Controlli',
        'Riprova' => 'Riprovi', 'Svuota' => 'Svuoti', 'Completa' => 'Completi', 'Crea' => 'Crei',
        'Ricorda' => 'Ricordi', 'Accedi' => 'Acceda', 'Registrati' => 'Si registri', 'Rimuovi' => 'Rimuova',
        'Hai' => 'Ha', 'Puoi' => 'Può', 'Devi' => 'Deve', 'Vuoi' => 'Vuole',
    ];
    foreach ($imperativi as $tu => $lei) {
        $t = preg_replace('/(^|[.?!:]\s+)' . preg_quote($tu, '/') . '\b(?=\s)/u', '$1' . $lei, $t);
    }

    // Seconda persona dentro la frase: pronomi, verbi e possessivi (con l'iniziale maiuscola, come nel
    // resto del sito: «il Suo caso»).
    static $dentro = [
        '/%1\$sAggiorna Totale%2\$s/u'  => '%1$sAggiorni il totale%2$s',   // nome del pulsante, come la sua etichetta
        '/\bassicurati\b/u'              => 'si assicuri',
        '/\bti venga\b/u'                => 'Le venga',
        '/\bti preghiamo\b/u'            => 'La preghiamo',
        '/\bti invieremo\b/u'            => 'Le invieremo',
        '/\bse non lo fai\b/u'           => 'se non lo fa',
        '/(^|[.?!:]\s+)Sei sicuro\b/u'   => '$1È sicuro',
        '/\bsei sicuro\b/u'              => 'è sicuro',
        '/\bhai\b/u'                     => 'ha',
        '/\bpuoi\b/u'                    => 'può',
        '/\bdevi\b/u'                    => 'deve',
        '/\bvuoi\b/u'                    => 'vuole',
        '/\btuoi\b/u'                    => 'Suoi',
        '/\btue\b/u'                     => 'Sue',
        '/\btuo\b/u'                     => 'Suo',
        '/\btua\b/u'                     => 'Sua',
    ];
    $t = preg_replace(array_keys($dentro), array_values($dentro), $t);

    // Guardia: niente frasi a metà fra «tu» e «Lei». Se resta una forma al «tu», vale l'originale.
    if ($t !== $originale && lanotte_woo_residuo_tu($t)) return $originale;
    return $t;
}

/**
 * Email WooCommerce in corso: null (nessuna), 'cliente' o 'amministratore'. Lo impostano i filtri di
 * cambio lingua, che WooCommerce applica in setup_locale()/restore_locale() di ogni email, anche quelle
 * all'amministratore (WC_Email_New_Order::trigger). Il contesto dell'email prevale su quello della
 * richiesta: un «nuovo ordine» all'amministratore nato dalla cassa resta nella traduzione originale.
 */
$GLOBALS['lanotte_woo_email'] = null;

/** Vale nel sito pubblico (anche /?wc-ajax=) e nelle email al cliente; mai nel pannello né nelle email all'amministratore. */
function lanotte_woo_lei_attivo($domain) {
    if ($domain !== 'woocommerce') return false;
    $email = $GLOBALS['lanotte_woo_email'] ?? null;
    if ($email === 'cliente') return true;
    if ($email === 'amministratore') return false;
    return !is_admin();
}

/*
 * Priorità 200: TranslatePress (attivo, lingua predefinita it_IT) aggancia gli stessi filtri a 100 e,
 * se nel suo archivio c'è una traduzione della stringa, la rimette al posto di quella ricevuta
 * (includes/gettext/class-process-gettext.php, righe 203-204 del trunk letto il 13/10/2026; il suo
 * archivio ha «Il tuo ordine», «Hai un codice promozionale?», … in stato 2). Con la 20 la 1.0.141
 * pubblicata non cambiava nulla. Nella lingua predefinita TranslatePress non aggiunge marcatori (riga 274).
 */
const LANOTTE_WOO_LEI_PRIORITA = 200;

add_filter('gettext', function ($traduzione, $testo, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, LANOTTE_WOO_LEI_PRIORITA, 3);

add_filter('gettext_with_context', function ($traduzione, $testo, $contesto, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, LANOTTE_WOO_LEI_PRIORITA, 4);

add_filter('ngettext', function ($traduzione, $singolare, $plurale, $numero, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, LANOTTE_WOO_LEI_PRIORITA, 5);

add_filter('ngettext_with_context', function ($traduzione, $singolare, $plurale, $numero, $contesto, $domain) {
    return lanotte_woo_lei_attivo($domain) ? lanotte_woo_lei($traduzione) : $traduzione;
}, LANOTTE_WOO_LEI_PRIORITA, 6);

/*
 * WooPayments e testi degli script. Misura del 13/10/2026 sull'HTML servito (scheda del servizio 513, carrello e cassa
 * con il servizio nel carrello, frammento /?wc-ajax=update_order_review): 9 testi al «tu», da due strade.
 * 1) Traduzioni JSON degli script (wp_set_script_translations): WCPAY_EXPRESS_CHECKOUT_ECE (dominio
 *    woocommerce-payments) e wp-api-fetch (dominio default, di WordPress). Non passano da gettext: si correggono con
 *    load_script_translations, solo nei testi tradotti; chiavi e struttura dei dati restano.
 * 2) Configurazione PHP di WooPayments 11.2.0 (genericErrorMessage e testingInstructions, in wcpay_upe_config, in
 *    wcpayConfig e nel frammento della cassa, tutti da get_payment_fields_js_config): __() nel dominio
 *    woocommerce-payments, quindi gettext a priorità 200 come per WooCommerce.
 * Solo frasi esatte, per dominio: sui testi dei pagamenti nessuna regola generica.
 */
function lanotte_woo_lei_esatta($t, $domain) {
    static $esatte = [
        'woocommerce-payments' => [
            // traduzioni JSON dello script del pagamento rapido (WCPAY_EXPRESS_CHECKOUT_ECE)
            'Aggiornamento dei dati di pagamento. Prova di nuovo a breve.'
                => 'Aggiornamento dei dati di pagamento. Riprovi a breve.',
            'Questo pagamento rapido è iniziato in %1$s e non può passare a %2$s per l\'indirizzo selezionato. Scegli un indirizzo di spedizione diverso o usa il pagamento regolare per pagare %2$s.'
                => 'Questo pagamento rapido è iniziato in %1$s e non può passare a %2$s per l\'indirizzo selezionato. Scelga un indirizzo di spedizione diverso o usi il pagamento regolare per pagare %2$s.',
            'Si è verificato un errore durante l\'elaborazione del prodotto con questo metodo di pagamento. Aggiungi il prodotto al carrello.'
                => 'Si è verificato un errore durante l\'elaborazione del prodotto con questo metodo di pagamento. Aggiunga il prodotto al carrello.',
            'Seleziona le opzioni del prodotto prima di procedere.'
                => 'Selezioni le opzioni del prodotto prima di procedere.',
            'Siamo spiacenti, questo prodotto non è disponibile. Scegli un\'altra combinazione.'
                => 'Siamo spiacenti, questo prodotto non è disponibile. Scelga un\'altra combinazione.',
            // configurazione PHP (gettext)
            'Si è verificato un problema durante l\'elaborazione del pagamento. Controlla la tua posta in arrivo dell\'e-mail e aggiorna la pagina per riprovare.'
                => 'Si è verificato un problema durante l\'elaborazione del pagamento. Controlli la Sua casella di posta elettronica e aggiorni la pagina per riprovare.',
            'Usa la carta di prova <number>%s</number> o consulta la nostra <a>guida al servizio</a>.'
                => 'Usi la carta di prova <number>%s</number> o consulti la nostra <a>guida al servizio</a>.',
            'Clicca per copiare il numero di prova negli appunti'
                => 'Faccia clic per copiare il numero di prova negli appunti',
            'Copia negli appunti'
                => 'Copi negli appunti',
        ],
        'default' => [
            // traduzioni JSON di wp-api-fetch (WordPress)
            'Impossibile connettersi. Verifica la connessione a Internet.'
                => 'Impossibile connettersi. Verifichi la connessione a Internet.',
            'Caricamento dei media fallito. Se si tratta di una foto oppure di un\'immagine grande, ridimensionala e riprova.'
                => 'Caricamento dei media fallito. Se si tratta di una foto oppure di un\'immagine grande, la ridimensioni e riprovi.',
        ],
    ];
    return (is_string($t) && isset($esatte[$domain][$t])) ? $esatte[$domain][$t] : $t;
}

/**
 * Traduzioni JSON di uno script (formato Jed) → stesso JSON con i testi tradotti al «Lei». Si toccano solo i valori
 * (le forme tradotte), mai le chiavi; se nulla cambia o il JSON non si legge, si restituisce il testo ricevuto, intatto.
 */
function lanotte_woo_lei_json_script($json, $domain) {
    if (!is_string($json) || $json === '') return $json;
    $dati = json_decode($json);   // oggetti, non array: un {} vuoto resta {}
    if (!is_object($dati) || !isset($dati->locale_data) || !is_object($dati->locale_data)) return $json;
    $cambi = [];
    foreach ($dati->locale_data as $gruppo => $messaggi) {
        if (!is_object($messaggi)) continue;
        foreach ($messaggi as $chiave => $forme) {
            if ($chiave === '' || !is_array($forme)) continue;   // '' = intestazione
            foreach ($forme as $i => $forma) {
                $nuova = lanotte_woo_lei_esatta($forma, $domain);
                if ($nuova !== $forma) $cambi[] = [$gruppo, $chiave, $i, $nuova];
            }
        }
    }
    if (!$cambi) return $json;
    foreach ($cambi as [$gruppo, $chiave, $i, $nuova]) $dati->locale_data->{$gruppo}->{$chiave}[$i] = $nuova;
    $nuovo = wp_json_encode($dati);
    return is_string($nuovo) ? $nuovo : $json;
}

add_filter('load_script_translations', function ($json, $file, $handle, $domain) {
    if (!in_array($domain, ['woocommerce-payments', 'default'], true) || !lanotte_woo_lei_attivo('woocommerce')) return $json;
    return lanotte_woo_lei_json_script($json, $domain);
}, LANOTTE_WOO_LEI_PRIORITA, 4);

add_filter('gettext', function ($traduzione, $testo, $domain) {
    return ($domain === 'woocommerce-payments' && lanotte_woo_lei_attivo('woocommerce'))
        ? lanotte_woo_lei_esatta($traduzione, $domain) : $traduzione;
}, LANOTTE_WOO_LEI_PRIORITA, 3);

// Email al cliente: WooCommerce le racchiude fra setup_locale() e restore_locale(), che applicano
// questi filtri con l'oggetto email. Si segna il contesto e si restituisce il booleano ricevuto.
add_filter('woocommerce_allow_switching_email_locale', function ($consenti, $email = null) {
    if (is_object($email) && method_exists($email, 'is_customer_email')) {
        $GLOBALS['lanotte_woo_email'] = $email->is_customer_email() ? 'cliente' : 'amministratore';
    }
    return $consenti;
}, 20, 2);
add_filter('woocommerce_allow_restoring_email_locale', function ($consenti, $email = null) {
    $GLOBALS['lanotte_woo_email'] = null;
    return $consenti;
}, 20, 2);

// Il testo sulla privacy della cassa è un'opzione di WooCommerce, non passa da gettext.
add_filter('woocommerce_get_privacy_policy_text', function ($testo) {
    return lanotte_woo_lei_attivo('woocommerce') ? lanotte_woo_lei($testo) : $testo;
}, 20);

/** ID della pagina della privacy da usare: quello impostato se pubblicato, altrimenti la pagina «privacy». */
function lanotte_pagina_privacy_id($id) {
    $id = (int) $id;
    if ($id > 0 && get_post_status($id) === 'publish') return $id;
    $pagina = get_page_by_path('privacy');
    return ($pagina instanceof WP_Post && $pagina->post_status === 'publish') ? (int) $pagina->ID : $id;
}

// WooCommerce costruisce il collegamento con wc_privacy_policy_page_id() e get_permalink().
add_filter('woocommerce_privacy_policy_page_id', 'lanotte_pagina_privacy_id', 20);

// Stesso rimedio per il collegamento di WordPress (get_privacy_policy_url), se servito vuoto.
add_filter('privacy_policy_url', function ($url) {
    if ($url) return $url;
    $id = lanotte_pagina_privacy_id(0);
    return $id ? get_permalink($id) : $url;
});
