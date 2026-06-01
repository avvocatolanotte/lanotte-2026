<?php
/**
 * Archive: Blog "Rassegna Giuridica"
 *
 * @package lanotte-2026
 */
get_header();
?>

<section class="hero-internal">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1>Rassegna Giuridica</h1>
    <p class="subtitle">Note di commento, aggiornamenti normativi, analisi di giurisprudenza. A cura dei professionisti dello Studio.</p>
  </div>
</section>

<section>
  <div class="container blog-layout">
    <div class="posts-list">
      <?php if (have_posts()): while (have_posts()): the_post();
          $thumb = get_the_post_thumbnail_url(get_the_ID(), 'lanotte-post-thumb');
          $cats = get_the_category();
          $cat = $cats ? $cats[0]->name : '';
      ?>
      <a class="post-large" href="<?php the_permalink(); ?>">
        <div class="post-img" style="<?php if ($thumb): ?>background-image:url('<?php echo esc_url($thumb); ?>')<?php else: ?>background:linear-gradient(135deg,#0E1A33,#1a2a4a)<?php endif; ?>"></div>
        <div class="post-body">
          <div class="post-meta">
            <?php echo esc_html($cat); ?>
            <span>· <?php echo esc_html(get_the_date('j F Y')); ?> · <?php echo esc_html(lanotte_reading_time()); ?></span>
          </div>
          <h4><?php the_title(); ?></h4>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_the_content(), 32, '…')); ?></p>
          <span class="post-link">Leggi l'articolo →</span>
        </div>
      </a>
      <?php endwhile; ?>

      <div class="pagination" style="text-align:center;margin-top:48px">
        <?php echo paginate_links(['prev_text' => '←', 'next_text' => '→']); ?>
      </div>
      <?php else: ?>
        <p>Nessun articolo pubblicato per ora.</p>
      <?php endif; ?>
    </div>

    <aside class="blog-sidebar">
      <?php if (is_active_sidebar('blog-sidebar')): ?>
        <?php dynamic_sidebar('blog-sidebar'); ?>
      <?php else: ?>
        <div>
          <h5>Categorie</h5>
          <ul class="cat-list">
            <?php
            $cats = get_categories(['orderby' => 'count', 'order' => 'DESC']);
            foreach ($cats as $c):
            ?>
            <li><a href="<?php echo esc_url(get_category_link($c)); ?>"><?php echo esc_html($c->name); ?></a><span class="count"><?php echo (int) $c->count; ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div>
          <h5>Articoli più letti</h5>
          <ul class="cat-list">
            <?php
            $popular = get_posts(['numberposts' => 3, 'orderby' => 'comment_count']);
            foreach ($popular as $p):
            ?>
            <li><a href="<?php echo esc_url(get_permalink($p)); ?>" style="font-size:13.5px;line-height:1.4"><?php echo esc_html(get_the_title($p)); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </aside>
  </div>
</section>

<?php get_footer();
