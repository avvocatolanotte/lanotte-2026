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
    <h1><?php echo esc_html(wp_get_document_title()); ?></h1>
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
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
