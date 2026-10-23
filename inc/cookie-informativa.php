<?php
/**
 * Collegamento all'informativa sui cookie nel banner di CookieYes (23/10/2026).
 *
 * Le linee guida del Garante sui cookie (10/06/2021, § 7.1, punto iii) chiedono nel banner un collegamento
 * all'informativa estesa. Nel banner del sito non c'era (rilievo di Codex del 22/10): nel plugin il collegamento
 * «Politica sui cookie» esiste ma è spento e senza indirizzo, e si accende solo scrivendo nel database (tabella
 * cky_banners), operazione che chiede ogni volta l'approvazione dell'Avvocato entro 10 minuti. Il plugin non offre filtri
 * per farlo dal tema: il banner nasce da un modello in <script type="text/template"> letto dal suo JavaScript.
 *
 * Qui il collegamento si aggiunge in fondo al testo del banner, appena il plugin lo mostra. Se il banner ha già un
 * collegamento all'informativa (il plugin acceso in futuro, o questo script già passato) non si aggiunge nulla.
 * Le pagine /widget/ non chiamano wp_footer(), quindi lì non c'è né banner né script.
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

add_action('wp_footer', function () {
    if (is_admin()) return;
    $url = home_url('/cookie/');
    ?>
<script id="lanotte-cookie-informativa">
(function () {
  var URL = <?php echo wp_json_encode($url); ?>;
  function aggiungi() {
    var des = document.querySelector('.cky-consent-container .cky-notice-des');
    if (!des) return false;
    var banner = des.closest('.cky-consent-container');
    if (banner.querySelector('a[href*="/cookie/"], a.cky-policy')) return true;
    var dove = des.querySelector('p:last-of-type') || des;
    var a = document.createElement('a');
    a.href = URL;
    a.className = 'cky-policy lanotte-cky-policy';
    a.target = '_blank';
    a.rel = 'noopener';
    a.textContent = 'Politica sui cookie';
    dove.appendChild(document.createTextNode(' '));
    dove.appendChild(a);
    return true;
  }
  if (aggiungi()) return;
  var osservatore = new MutationObserver(function () { if (aggiungi()) osservatore.disconnect(); });
  osservatore.observe(document.documentElement, { childList: true, subtree: true });
  setTimeout(function () { osservatore.disconnect(); }, 20000);
})();
</script>
    <?php
}, 100);
