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
