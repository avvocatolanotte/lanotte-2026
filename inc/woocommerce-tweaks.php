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

// Deposito del marchio nazionale: niente acquisto online (decisione dell'Avvocato
// del 10/10/2026). Ogni marchio ha la sua storia: lo Studio studia il caso e manda
// un preventivo personalizzato; il deposito si paga solo se la ricerca di
// anteriorità è favorevole. Il prezzo resta visibile come compenso base del caso
// semplice (marchio denominativo, una classe).
function lanotte_servizi_su_preventivo_ids() {
    return [8488];
}

function lanotte_is_servizio_su_preventivo($product) {
    return $product && in_array((int) $product->get_id(), lanotte_servizi_su_preventivo_ids(), true);
}

add_filter('woocommerce_is_purchasable', function($purchasable, $product) {
    return lanotte_is_servizio_su_preventivo($product) ? false : $purchasable;
}, 10, 2);

add_filter('woocommerce_get_price_html', function($price_html, $product) {
    if (!lanotte_is_servizio_su_preventivo($product) || !is_product()) return $price_html;
    return '<span class="lanotte-prezzo-base">Compenso base per il caso semplice: ' . $price_html
        . ' <small>(CPA e IVA incluse; tasse ufficiali a parte; per gli altri casi preventivo personalizzato)</small></span>';
}, 10, 2);

add_action('woocommerce_single_product_summary', function() {
    global $product;
    if (!lanotte_is_servizio_su_preventivo($product)) return;

    $contatti = add_query_arg(['argomento' => 'deposito-marchio'], home_url('/contatti/'));
    $whatsapp = lanotte_whatsapp_url();
    $whatsapp .= (strpos($whatsapp, '?') === false ? '?' : '&')
        . 'text=' . rawurlencode('Buongiorno, vorrei un preventivo per il deposito di un marchio.');

    echo '<div class="lanotte-preventivo-cta">'
        . '<p>Ogni marchio ha la sua storia: il compenso si definisce dopo un primo esame del segno. Il deposito si paga solo se la ricerca di anteriorità è favorevole.</p>'
        . '<p><a class="btn btn-primary" data-lanotte-event="preventivo_marchio" href="' . esc_url($contatti) . '">Richieda un preventivo personalizzato</a> '
        . '<a class="btn btn-ghost" data-lanotte-event="preventivo_marchio_whatsapp" href="' . esc_url($whatsapp) . '" target="_blank" rel="noopener">Scriva su WhatsApp</a></p>'
        . '</div>';
}, 31);
