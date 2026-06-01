<?php
/**
 * Card di un articolo del blog — usata in home e archive
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$cats = get_the_category();
$cat = $cats ? $cats[0]->name : '';
$thumb = get_the_post_thumbnail_url(get_the_ID(), 'lanotte-post-thumb');
$default_bg = 'linear-gradient(135deg,#0E1A33,#1a2a4a)';
?>
<a class="post" href="<?php the_permalink(); ?>">
  <div class="post-img" style="<?php if ($thumb): ?>background-image:url('<?php echo esc_url($thumb); ?>')<?php else: ?>background:<?php echo $default_bg; ?><?php endif; ?>"></div>
  <div class="post-body">
    <div class="post-meta">
      <?php echo esc_html($cat); ?>
      <span>· <?php echo esc_html(get_the_date('j F Y')); ?></span>
    </div>
    <h4><?php the_title(); ?></h4>
    <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_the_content(), 22, '…')); ?></p>
    <span class="post-link">Leggi l'articolo →</span>
  </div>
</a>
