<?php
/**
 * Fallback principale del tema
 *
 * @package lanotte-2026
 */
get_header();
?>

<section class="hero-internal">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1><?php echo is_search() ? esc_html(sprintf('Risultati per «%s»', get_search_query(false))) : esc_html(wp_get_document_title()); ?></h1>
  </div>
</section>

<section class="block">
  <div class="container">
    <?php if (have_posts()): ?>
    <div class="blog-grid">
      <?php while (have_posts()): the_post(); ?>
        <?php get_template_part('template-parts/post-card'); ?>
      <?php endwhile; ?>
    </div>
    <div class="pagination" style="text-align:center;margin-top:48px">
      <?php echo paginate_links(['prev_text' => '←', 'next_text' => '→']); ?>
    </div>
    <?php else: ?>
      <p>Nessun contenuto trovato.</p>
      <?php if (is_search()): // 26/10/2026: dopo una ricerca senza risultati si può riprovare senza tornare indietro ?>
        <div style="max-width:480px;margin-top:20px"><?php get_search_form(); ?></div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
