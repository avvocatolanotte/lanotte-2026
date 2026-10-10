<?php
/**
 * Pagina Contatti: precompila oggetto e traccia del messaggio quando si arriva
 * con ?argomento=… (calcolatori, scheda del deposito marchio, guide sui marchi).
 * Fino al 10/10/2026 il parametro arrivava ma nessuno lo leggeva.
 */

if (!defined('ABSPATH')) exit;

add_action('wp_footer', function() {
    if (!is_page('contatti')) return;
    ?>
<script>
(function () {
  var a = (new URLSearchParams(window.location.search).get('argomento') || '').toLowerCase().replace(/[^a-z0-9-]/g, '');
  if (!a) return;
  var temi = {
    'deposito-marchio': {
      s: 'Preventivo per il deposito di un marchio',
      m: 'Segno (nome ed eventuale logo):\nProdotti o servizi:\nTerritori (Italia, Unione europea, altri Paesi):\nIl marchio è già in uso? Da quando?\n'
    },
    'marchi': {
      s: 'Marchi: richiesta di esame del caso',
      m: 'Marchio interessato:\nChe cosa è successo (opposizione, diffida, imitazione, altro):\nDate o scadenze note:\n'
    }
  };
  var t = temi[a] || { s: 'Richiesta dalla pagina: ' + a.replace(/-/g, ' '), m: '' };
  var oggetto = document.querySelector('input[name="your-subject"]');
  var messaggio = document.querySelector('textarea[name="your-message"]');
  if (oggetto && !oggetto.value) oggetto.value = t.s;
  if (messaggio && !messaggio.value && t.m) messaggio.value = t.m;
})();
</script>
    <?php
}, 50);
