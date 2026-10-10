<?php
/**
 * Servizi online (WooCommerce): ritocchi di presentazione.
 */

if (!defined('ABSPATH')) exit;

// Servizi di marchi e proprietà intellettuale: deposito nazionale UIBM,
// marchio internazionale (Madrid), parere in materia di PI.
function lanotte_servizi_pi_ids() {
    return [8488, 7647, 409];
}

// Sulle loro schede i «prodotti correlati» erano presi dalla categoria comune
// «Consulenze e pratiche» (costituzione ASD, prospetto ISTAT…): lì si mostrano
// soltanto gli altri servizi dello stesso ambito. WooCommerce applica il filtro
// anche ai risultati che tiene in cache.
add_filter('woocommerce_related_products', function($related, $product_id) {
    $pi = lanotte_servizi_pi_ids();
    if (!in_array((int) $product_id, $pi, true)) return $related;
    return array_values(array_diff($pi, [(int) $product_id]));
}, 10, 2);

// Servizi sui marchi senza acquisto online (decisioni dell'Avvocato del 10/10/2026):
// ogni marchio ha la sua storia, lo Studio studia il caso e manda un preventivo
// personalizzato.
// - 8488 deposito nazionale: il deposito si paga solo se la ricerca di anteriorità
//   è favorevole; resta visibile il compenso base del caso semplice (507,52 €, CPA e
//   IVA incluse, coerente con il prezzo del negozio, che è IVA inclusa).
// - 7647 marchio internazionale: compenso a partire da 1.800 € oltre IVA e CPA. Il
//   negozio intende i prezzi IVA inclusa: il prezzo del prodotto non si mostra e non
//   va nei dati strutturati, altrimenti direbbe 1.800 € IVA compresa.
function lanotte_servizi_su_preventivo() {
    return [
        8488 => [
            'etichetta' => null, // usa il prezzo del negozio
            'argomento' => 'deposito-marchio',
            'whatsapp'  => 'Buongiorno, vorrei un preventivo per il deposito di un marchio.',
            'nota'      => 'Ogni marchio ha la sua storia: il compenso si definisce dopo un primo esame del segno. Il deposito si paga solo se la ricerca di anteriorità è favorevole.',
        ],
        7647 => [
            'etichetta' => 'Compenso a partire da 1.800 € oltre IVA e CPA <small>(tasse ufficiali a parte; preventivo personalizzato)</small>',
            'argomento' => 'marchio-internazionale',
            'whatsapp'  => 'Buongiorno, vorrei un preventivo per un marchio internazionale.',
            'nota'      => 'Ogni marchio ha la sua storia: il compenso si definisce dopo l\'esame del marchio di base, dei Paesi da designare e delle classi.',
        ],
    ];
}

function lanotte_servizi_su_preventivo_ids() {
    return array_keys(lanotte_servizi_su_preventivo());
}

function lanotte_is_servizio_su_preventivo($product) {
    return $product && in_array((int) $product->get_id(), lanotte_servizi_su_preventivo_ids(), true);
}

add_filter('woocommerce_is_purchasable', function($purchasable, $product) {
    return lanotte_is_servizio_su_preventivo($product) ? false : $purchasable;
}, 10, 2);

add_filter('woocommerce_get_price_html', function($price_html, $product) {
    if (!lanotte_is_servizio_su_preventivo($product)) return $price_html;
    $dati = lanotte_servizi_su_preventivo()[(int) $product->get_id()];
    if ($dati['etichetta']) return '<span class="lanotte-prezzo-base">' . $dati['etichetta'] . '</span>';
    if (!is_product()) return $price_html;
    return '<span class="lanotte-prezzo-base">Compenso base per il caso semplice: ' . $price_html
        . ' <small>(CPA e IVA incluse; tasse ufficiali a parte; per gli altri casi preventivo personalizzato)</small></span>';
}, 10, 2);

// Dati strutturati: niente offerta con prezzo per i servizi il cui prezzo del negozio
// non coincide con quello scritto (7647). Per 8488 l'offerta resta: 507,52 € IVA inclusa.
add_filter('woocommerce_structured_data_product', function($markup, $product) {
    if (!lanotte_is_servizio_su_preventivo($product)) return $markup;
    if (lanotte_servizi_su_preventivo()[(int) $product->get_id()]['etichetta']) unset($markup['offers']);
    return $markup;
}, 10, 2);

add_action('woocommerce_single_product_summary', function() {
    global $product;
    if (!lanotte_is_servizio_su_preventivo($product)) return;

    $dati = lanotte_servizi_su_preventivo()[(int) $product->get_id()];
    $contatti = add_query_arg(['argomento' => $dati['argomento']], home_url('/contatti/'));
    $whatsapp = lanotte_whatsapp_url();
    $whatsapp .= (strpos($whatsapp, '?') === false ? '?' : '&')
        . 'text=' . rawurlencode($dati['whatsapp']);

    echo '<div class="lanotte-preventivo-cta">'
        . '<p>' . esc_html($dati['nota']) . '</p>'
        . '<p><a class="btn btn-primary" data-lanotte-event="preventivo_marchio" href="' . esc_url($contatti) . '">Richieda un preventivo personalizzato</a> '
        . '<a class="btn btn-ghost" data-lanotte-event="preventivo_marchio_whatsapp" href="' . esc_url($whatsapp) . '" target="_blank" rel="noopener">Scriva su WhatsApp</a></p>'
        . '</div>';
}, 31);
