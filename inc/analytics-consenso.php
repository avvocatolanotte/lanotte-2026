<?php
/**
 * Google Analytics in modalità di base: nessuna richiesta a Google prima del consenso statistico
 * (decisione dell'Avvocato, 11/10/2026).
 *
 * Perché serve: Site Kit stampa gtag.js su ogni pagina e il Consent Mode che imposta è quello avanzato.
 * Misurato l'11/10/2026 con il consenso già rifiutato (cookie CookieYes «analytics:no»): gtag.js caricato e
 * una richiesta a region1.google-analytics.com/g/collect con gcs=G100 (ping senza cookie).
 *
 * Che cosa fa: il tag di Site Kit (handle google_gtagjs) esce inerte — type="text/plain", indirizzo spostato in
 * data-lanotte-src — e un caricatore lo avvia solo quando CookieYes registra il consenso alla categoria
 * «analytics»: dal cookie cookieyes-consent (visite successive), dall'evento cookieyes_consent_update (scelta
 * fatta nella pagina) o da cookieyes_banner_load. Gli script in linea di Site Kit restano: riempiono solo il
 * dataLayer e non fanno richieste di rete; gtag.js li elabora quando viene avviato.
 *
 * Perché non data-cookieyes: dopo un consenso parziale (es. solo «funzionali») CookieYes ripristina tutti gli
 * script bloccati senza ricontrollarne la categoria (banner.js, funzione di ripristino dei _backupNodes),
 * quindi Analytics partirebbe anche con le statistiche rifiutate.
 *
 * Se il tag non si riconosce non si stampa: meglio nessuna misura che una misura senza consenso. Il guasto
 * va nel log e lascia un commento nella pagina, così la prova in tre tempi lo vede.
 */

if (!defined('ABSPATH')) exit;

/**
 * Rende inerte il tag esterno di gtag.js. Restituisce null se non trova esattamente un tag
 * <script id="google_gtagjs-js" src="…">: il chiamante allora non stampa nulla.
 */
function lanotte_gtag_inerte($tag) {
    if (!class_exists('WP_HTML_Tag_Processor')) return null;
    $p = new WP_HTML_Tag_Processor($tag);
    $trovati = 0;
    while ($p->next_tag('script')) {
        if ($p->get_attribute('id') !== 'google_gtagjs-js') continue;
        $src = $p->get_attribute('src');
        if (!is_string($src) || $src === '') return null;
        $p->remove_attribute('src');
        $p->remove_attribute('async');
        $p->remove_attribute('defer');
        $p->set_attribute('type', 'text/plain');
        $p->set_attribute('data-lanotte-src', $src);
        $trovati++;
    }
    return $trovati === 1 ? $p->get_updated_html() : null;
}

function lanotte_gtag_caricatore() {
    return <<<'HTML'
<script id="lanotte-analytics-consenso">
(function () {
  var avviato = false;
  function avvia() {
    if (avviato) return;
    var t = document.getElementById('google_gtagjs-js');
    var src = t && t.getAttribute('data-lanotte-src');
    if (!src) return;
    avviato = true;
    var s = document.createElement('script');
    s.async = true;
    s.src = src;
    s.id = 'google_gtagjs-js-avviato';
    t.parentNode.insertBefore(s, t.nextSibling);
  }
  function statisticheAccettate() {
    var m = document.cookie.match(/(?:^|;\s*)cookieyes-consent=([^;]*)/);
    if (!m) return false;
    var v;
    try { v = decodeURIComponent(m[1]); } catch (e) { v = m[1]; }
    return /(?:^|,)analytics:yes(?:,|$)/.test(v);
  }
  document.addEventListener('cookieyes_consent_update', function (e) {
    var a = e && e.detail && e.detail.accepted;
    if (a && a.indexOf('analytics') !== -1) avvia();
  });
  document.addEventListener('cookieyes_banner_load', function (e) {
    var c = e && e.detail && e.detail.categories;
    if (c && c.analytics === true) avvia();
  });
  if (statisticheAccettate()) avvia();
})();
</script>

HTML;
}

add_filter('script_loader_tag', function ($tag, $handle) {
    if ($handle !== 'google_gtagjs') return $tag;
    $inerte = lanotte_gtag_inerte($tag);
    if ($inerte === null) {
        error_log('lanotte analytics-consenso: tag gtag.js di Site Kit non riconosciuto, non stampato (nessuna misura finché non si corregge)');
        return "<!-- lanotte analytics-consenso: tag gtag.js non riconosciuto, non caricato -->\n";
    }
    return $inerte . lanotte_gtag_caricatore();
}, 99, 2);

/*
 * Attribuzione degli ordini di WooCommerce spenta (11/10/2026).
 * Misurato: sourcebuster-js e wc-order-attribution si caricavano su tutte le pagine e scrivevano i cookie sbjs_*
 * (fonte della visita, referrer, user agent, pagine viste) prima di qualsiasi scelta, anche dopo «Rifiuta tutto»:
 * WooCommerce li classifica «marketing» e li revoca solo se il WP Consent API definisce un tipo di consenso, che
 * sul sito è vuoto. La cookie policy dice che prima della scelta si usano solo cookie tecnici e che cookie di
 * marketing non se ne usano. Con il filtro a false lo script di WooCommerce non li scrive e cancella quelli già
 * presenti (setOrderTracking(false)); gli ordini restano, senza la fonte della visita.
 */
add_filter('wc_order_attribution_allow_tracking', '__return_false');

