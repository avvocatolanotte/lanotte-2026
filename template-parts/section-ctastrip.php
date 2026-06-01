<?php
/**
 * CTA strip — usata in home e in altre pagine
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$cta = function_exists('get_field') ? get_field('ctastrip', 'option') : null;
$titolo = $cta['titolo']  ?? 'Una consulenza riservata, in 24 ore.';
$sub    = $cta['sottotitolo'] ?? 'Raccontaci il tuo caso: un avvocato dello Studio ti ricontatta entro un giorno lavorativo con un primo orientamento.';
$btn_l  = $cta['btn1_label'] ?? 'Richiedi consulenza';
$btn_u  = $cta['btn1_url']   ?? get_permalink(get_page_by_path('contatti'));
?>
<section class="ctastrip">
  <div class="container ctastrip-inner">
    <div>
      <h3><?php echo esc_html($titolo); ?></h3>
      <p><?php echo esc_html($sub); ?></p>
    </div>
    <div class="ctastrip-actions">
      <a href="<?php echo esc_url($btn_u); ?>" class="btn btn-gold"><?php echo esc_html($btn_l); ?></a>
      <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" class="btn btn-ghost" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>
