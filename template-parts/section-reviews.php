<?php
/**
 * Sezione "Recensioni" — home
 *
 * Decisione dell'Avvocato (10/10/2026): nel sito non si riportano testimonianze né nomi di
 * assistiti; si indica il voto pubblico del profilo Google con la data della rilevazione e il
 * collegamento al profilo, dove le recensioni si leggono per intero.
 * Voto e numero vanno aggiornati a mano con la data: un dato senza data invecchia in silenzio.
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$google_voto       = '5,0';
$google_recensioni = 58;
$google_rilevato   = '10 ottobre 2026';
$google_url        = 'https://www.google.com/maps?cid=11964124714583216065';
?>
<section class="block">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Valutazioni pubbliche</div>
      <h2>Le recensioni su Google</h2>
      <p>Le recensioni dei clienti sono pubblicate sul profilo Google dello Studio, dove si possono leggere per intero.</p>
    </div>
    <div class="reviews-foot" style="text-align:center">
      <div class="stars" aria-hidden="true" style="font-size:22px;color:var(--gold)">★★★★★</div>
      <p style="margin:8px 0 18px"><strong><?php echo esc_html($google_voto); ?> su 5</strong> · <?php echo (int) $google_recensioni; ?> recensioni <span style="color:var(--text-muted)">(dato rilevato il <?php echo esc_html($google_rilevato); ?>)</span></p>
      <a class="btn btn-outline" href="<?php echo esc_url($google_url); ?>" target="_blank" rel="noopener">Legga le recensioni su Google</a>
    </div>
  </div>
</section>
