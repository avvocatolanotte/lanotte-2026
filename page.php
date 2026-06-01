<?php
/**
 * Template pagina standard — wrapper minimale per WP page content.
 *
 * Architettura "content-first":
 *  - Il design (hero, sezioni, layout) è scritto come HTML in `post_content`
 *    della pagina ed editabile da WP Admin → Pagine
 *  - Il template fornisce solo: header, breadcrumb (se non c'è già un hero
 *    full-width nel post_content), the_content(), footer
 *  - Featured image della pagina = sfondo automatico del titolo hero
 *  - Shortcode dinamici disponibili: [phone] [email] [pec] [whatsapp-url] ecc.
 *
 * Pagine speciali con SOLO logica dinamica (contatti, calcolatori) hanno
 * il proprio page-<slug>.php che chiama get_template_part() di sezioni
 * specifiche dopo the_content().
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$content   = get_the_content();

// Auto-detect: se il post_content inizia già con un <section> di hero,
// non mostriamo l'hero standard del template (evita doppio hero).
$has_custom_hero = (bool) preg_match('/^\s*<section[^>]*(hero|banner|cover)/i', trim($content));

// Pagine legal: layout più stretto + class "legal-content"
$is_legal = is_page(['privacy', 'cookie', 'privacy-policy', 'cookie-policy', 'credits']);
?>

<?php if (!$has_custom_hero): ?>
<section class="hero-internal page-hero<?php echo $thumb_url ? ' has-image' : ''; ?>"
  <?php if ($thumb_url): ?>style="background-image:linear-gradient(135deg,rgba(15,23,42,.86),rgba(30,41,59,.74)),url('<?php echo esc_url($thumb_url); ?>');background-size:cover;background-position:center"<?php endif; ?>>
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1><?php the_title(); ?></h1>
    <?php
    // Subtitle opzionale: shortcode {{subtitle}} o ACF
    $subtitle = function_exists('get_field') ? get_field('subtitle') : '';
    if ($subtitle): ?>
      <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($is_legal): ?>
<article class="legal-content">
  <div class="container" style="max-width:840px">
    <?php if ($updated = (function_exists('get_field') ? get_field('updated_date') : '')): ?>
      <p class="updated"><strong>Ultimo aggiornamento:</strong> <?php echo esc_html($updated); ?></p>
    <?php endif; ?>
    <?php the_content(); ?>
  </div>
</article>
<?php else: ?>
<div class="page-body">
  <?php the_content(); ?>
</div>
<?php endif; ?>

<style>
.page-hero.has-image{padding:90px 0 70px;color:#fff}
.page-hero.has-image h1{color:#fff;text-shadow:0 2px 10px rgba(0,0,0,.3)}
.page-hero.has-image .breadcrumbs a,.page-hero.has-image .breadcrumbs span{color:#cbd5e1 !important}
.page-body > section:first-child,
.page-body > div:first-child{padding-top:0}
</style>

<?php endwhile; get_footer();
