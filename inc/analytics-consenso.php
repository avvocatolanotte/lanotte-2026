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
 * Prima di avviare gtag.js il caricatore accoda analytics_storage concesso (solo quello: le categorie pubblicitarie
 * restano a CookieYes). Alla revoca cancella i cookie _ga*, spegne Analytics con ga-disable-<ID> e ricarica la pagina.
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

/** ID di misurazione GA4 di Site Kit, per spegnere Analytics nella pagina alla revoca (ga-disable-<ID>). */
function lanotte_gtag_id_misurazione() {
    $s = get_option('googlesitekit_analytics-4_settings');
    if (!is_array($s)) return [];
    $id = array_merge([(string) ($s['measurementID'] ?? '')], array_map('strval', (array) ($s['googleTagContainerDestinationIDs'] ?? [])));
    return array_values(array_unique(array_filter($id, function ($x) { return (bool) preg_match('/^G-[A-Z0-9]+$/', $x); })));
}

function lanotte_gtag_caricatore() {
    $js = <<<'JS'
<script id="lanotte-analytics-consenso">
(function () {
  var ID_GA4 = __ID_GA4__;
  var avviato = false;
  window.dataLayer = window.dataLayer || [];
  function g() { window.dataLayer.push(arguments); }
  function avvia() {
    if (avviato) return;
    var t = document.getElementById('google_gtagjs-js');
    var src = t && t.getAttribute('data-lanotte-src');
    if (!src) return;
    avviato = true;
    // Lo stato concesso entra nella coda prima di gtag.js: senza, alla visita successiva la prima page_view
    // può partire con analytics_storage negato se CookieYes ripristina la scelta dopo l'attesa di Site Kit.
    g('consent', 'update', { analytics_storage: 'granted' });
    var s = document.createElement('script');
    s.async = true;
    s.src = src;
    s.id = 'google_gtagjs-js-avviato';
    t.parentNode.insertBefore(s, t.nextSibling);
  }
  function cancellaGa() {
    var host = location.hostname.replace(/^www\./, '');
    document.cookie.split(';').forEach(function (c) {
      var n = c.trim().split('=')[0];
      if (!/^_ga(_|$)/.test(n)) return;
      ['', '; domain=.' + host, '; domain=' + host].forEach(function (d) {
        document.cookie = n + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/' + d;
      });
    });
  }
  function revoca() {
    cancellaGa();
    if (!avviato) return;
    // Con il solo consenso negato gtag.js continuerebbe a inviare ping senza cookie: si spegne e si ricarica.
    ID_GA4.forEach(function (id) { window['ga-disable-' + id] = true; });
    location.reload();
  }
  function sceltaSalvata() {
    var m = document.cookie.match(/(?:^|;\s*)cookieyes-consent=([^;]*)/);
    if (!m) return '';
    var v;
    try { v = decodeURIComponent(m[1]); } catch (e) { v = m[1]; }
    var a = v.match(/(?:^|,)analytics:(yes|no)(?:,|$)/);
    return a ? a[1] : '';
  }
  document.addEventListener('cookieyes_consent_update', function (e) {
    var d = e && e.detail;
    if (!d) return;
    if (d.accepted && d.accepted.indexOf('analytics') !== -1) avvia();
    else if (d.rejected && d.rejected.indexOf('analytics') !== -1) revoca();
  });
  document.addEventListener('cookieyes_banner_load', function (e) {
    var c = e && e.detail && e.detail.categories;
    if (c && c.analytics === true) avvia();
  });
  var scelta = sceltaSalvata();
  if (scelta === 'yes') avvia();
  else if (scelta === 'no') cancellaGa();
})();
</script>

JS;
    return str_replace('__ID_GA4__', wp_json_encode(lanotte_gtag_id_misurazione()), $js);
}

add_filter('script_loader_tag', function ($tag, $handle) {
    if ($handle !== 'google_gtagjs') return $tag;
    $inerte = lanotte_gtag_inerte($tag);
    if ($inerte === null) {
        error_log('lanotte analytics-consenso: tag gtag.js di Site Kit non riconosciuto, non stampato (nessuna misura finché non si corregge)');
        return "<!-- lanotte analytics-consenso: tag gtag.js non riconosciuto, non caricato -->\n";
    }
    // Il caricatore va subito dopo il tag inerte, prima degli script in linea di Site Kit: così, alla visita successiva,
    // l'aggiornamento del consenso precede il comando config nella coda di gtag.js.
    $n = preg_match_all('/<script\b[^>]*\sid=(["\'])google_gtagjs-js\1[^>]*>\s*<\/script>/', $inerte, $m, PREG_OFFSET_CAPTURE);
    if ($n !== 1) return $inerte . lanotte_gtag_caricatore();
    $fine = $m[0][0][1] + strlen($m[0][0][0]);
    return substr($inerte, 0, $fine) . "\n" . lanotte_gtag_caricatore() . substr($inerte, $fine);
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
// Priorità massima: l'integrazione WP Consent API di WooCommerce aggiunge su init (20) un filtro che restituisce
// wp_has_consent('marketing') ignorando il valore precedente, e con il tipo di consenso vuoto vale true
// (rilievo di Codex, tornata 6, verificato su WooCommerce 11.2.1 src/Internal/Integrations/WPConsentAPI.php).
add_filter('wc_order_attribution_allow_tracking', '__return_false', PHP_INT_MAX);

// Lo script di quell'integrazione può richiamare setOrderTracking(true) quando cambia il consenso «marketing»:
// si toglie ovunque, negozio compreso. Serve solo all'attribuzione degli ordini.
function lanotte_togli_integrazione_attribuzione() {
    wp_dequeue_script('wp-consent-api-integration');
}
add_action('wp_enqueue_scripts', 'lanotte_togli_integrazione_attribuzione', 100);
add_action('wp_print_footer_scripts', 'lanotte_togli_integrazione_attribuzione', 1);

