<?php
/**
 * Archive: tutte le aree di competenza
 *
 * @package lanotte-2026
 */
get_header();
?>

<section class="hero-internal">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1>Tredici aree di competenza,<br>un solo interlocutore.</h1>
    <p class="subtitle">Materia civile, penale, commerciale, tributaria e del lavoro, integrate dalla collaborazione di colleghi specializzati per la giurisdizione di legittimità e per il diritto internazionale.</p>
  </div>
</section>

<section class="block">
  <div class="container">
    <div class="areas-grid">
      <?php while (have_posts()): the_post(); ?>
        <?php get_template_part('template-parts/area-card'); ?>
      <?php endwhile; ?>
    </div>

    <?php if (function_exists('paginate_links')): ?>
    <div class="pagination" style="text-align:center;margin-top:48px">
      <?php echo paginate_links(['prev_text' => '←', 'next_text' => '→']); ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php get_template_part('template-parts/section-ctastrip'); ?>

<?php get_footer();
