<?php
/**
 * Sezione "Recensioni" — home
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$reviews = function_exists('get_field') ? get_field('recensioni', 'option') : null;
$avg     = function_exists('get_field') ? get_field('media_recensioni', 'option') : '4.9 / 5';
$total   = function_exists('get_field') ? get_field('totale_recensioni', 'option') : 47;

if (!$reviews) {
    $reviews = [
        ['testo' => 'Professionalità, chiarezza e disponibilità anche fuori orario. Mi sono sentito tutelato in ogni fase del procedimento.', 'stelle' => 5, 'autore' => 'Marco P.', 'fonte' => 'Recensione Google · 2026'],
        ['testo' => 'Hanno gestito una vicenda ereditaria complessa con metodo e umanità. Preventivo trasparente, nessuna sorpresa.', 'stelle' => 5, 'autore' => 'Laura C.', 'fonte' => 'Recensione Google · 2026'],
        ['testo' => 'Consulenza preziosa per la mia impresa: contrattualistica, recupero crediti, formazione interna. Un riferimento solido.', 'stelle' => 5, 'autore' => 'Antonio R.', 'fonte' => 'Cliente azienda · 2025'],
    ];
}
?>
<section class="block">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Cosa dicono i clienti</div>
      <h2>Recensioni verificate</h2>
      <p>Selezione dalle valutazioni pubbliche su Google e dai feedback ricevuti al termine del mandato.</p>
    </div>
    <div class="reviews-grid">
      <?php foreach ($reviews as $r):
          $stars = (int) ($r['stelle'] ?? 5);
          $initial = strtoupper(mb_substr($r['autore'] ?? '?', 0, 1));
      ?>
      <div class="review">
        <div class="stars"><?php echo str_repeat('★', $stars); ?></div>
        <p class="review-text"><?php echo esc_html($r['testo']); ?></p>
        <div class="review-author">
          <div class="review-avatar"><?php echo esc_html($initial); ?></div>
          <div>
            <strong><?php echo esc_html($r['autore']); ?></strong>
            <span><?php echo esc_html($r['fonte'] ?? ''); ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php if ($avg): ?>
    <div class="reviews-foot"><strong><?php echo esc_html($avg); ?></strong> <?php if ($total): ?>su <?php echo (int) $total; ?> recensioni<?php endif; ?></div>
    <?php endif; ?>
  </div>
</section>
