<?php
/**
 * Sezione "4 principi etici" — home
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$principi = function_exists('get_field') ? get_field('principi', 'option') : null;
if (!$principi) {
    $principi = [
        ['numero' => '01', 'titolo' => 'Indipendenza', 'descrizione' => 'L\'avvocato è autonomo nelle valutazioni tecniche e nelle scelte processuali. Non accettiamo mandati che possano comprometterne la libertà di giudizio.', 'riferimento' => ''],
        ['numero' => '02', 'titolo' => 'Segreto professionale', 'descrizione' => 'Quanto appreso dall\'assistito è coperto da segreto in modo assoluto. Comunicazioni su canali sicuri e tracciati.', 'riferimento' => 'Art. 13 c.d.f. · Artt. 200 c.p.p. e 622 c.p.'],
        ['numero' => '03', 'titolo' => 'Verità del compenso', 'descrizione' => 'Preventivo scritto sin dal primo incontro, conforme all\'art. 13 L. 247/2012. Lo Studio non applica patti di quota lite.', 'riferimento' => 'Art. 25 c.d.f.'],
        ['numero' => '04', 'titolo' => 'Continuità del rapporto', 'descrizione' => 'Le pratiche sono seguite personalmente dal titolare in ogni fase del mandato, con il supporto di colleghi consulenti specializzati per materia.', 'riferimento' => ''],
    ];
}
?>
<section class="block principles">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow" style="color:var(--gold-light)">Il nostro impegno</div>
      <h2>Quattro principi non negoziabili</h2>
      <p>Valori che caratterizzano il rapporto con il cliente e la qualità della prestazione professionale.</p>
    </div>
    <div class="principles-grid">
      <?php foreach ($principi as $p): ?>
      <div class="principle">
        <div class="principle-num"><?php echo esc_html($p['numero']); ?></div>
        <h4><?php echo esc_html($p['titolo']); ?></h4>
        <p><?php echo esc_html($p['descrizione']); ?>
          <?php if (!empty($p['riferimento'])): ?>
            <small><?php echo esc_html($p['riferimento']); ?></small>
          <?php endif; ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
