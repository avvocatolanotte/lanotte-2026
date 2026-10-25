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
 * L'attesa del banner non ha scadenza: finisce quando il collegamento è nel banner.
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
  // Nessuna scadenza: se CookieYes arriva tardi il banner deve comunque avere il collegamento (rilievo di Codex
  // del 23/10). Il plugin non emette un evento di banner pronto; l'osservatore si stacca al primo inserimento.
  var osservatore = new MutationObserver(function () { if (aggiungi()) osservatore.disconnect(); });
  osservatore.observe(document.documentElement, { childList: true, subtree: true });
})();
</script>
    <?php
}, 100);

// Il collegamento «Riveda le scelte sui cookie» del piè di pagina (footer.php) riapre le preferenze di CookieYes con la sua
// funzione pubblica; se CookieYes non è caricato il collegamento porta alla Cookie Policy.
add_action('wp_footer', function () {
    if (is_admin()) return;
    ?>
<script id="lanotte-cookie-scelte">
document.addEventListener('click', function (e) {
  var a = e.target.closest ? e.target.closest('.lanotte-cookie-scelte') : null;
  if (!a || typeof window.revisitCkyConsent !== 'function') return;
  // Cmd/Ctrl/Shift/Alt-clic e clic non principali restano al browser (nuova scheda, ecc.): rilievo di Codex.
  if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
  e.preventDefault();
  window.revisitCkyConsent();
});
</script>
    <?php
}, 100);
