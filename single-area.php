<?php
/**
 * Single area di competenza
 *
 * Rendering basato su post_content (HTML strutturato dal seed: lead + sezioni + FAQ).
 * Compatibile con ACF Free + Pro (non dipende da repeater fields).
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$tagline      = function_exists('get_field') ? get_field('tagline') : '';
$show_urgency = function_exists('get_field') ? (bool) get_field('show_urgency') : false;
if (!$tagline) $tagline = get_the_excerpt();
?>

<section class="hero-internal">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <h1><?php the_title(); ?></h1>
    <?php if ($tagline): ?>
      <p class="subtitle"><?php echo esc_html($tagline); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="area-detail">
  <div class="container">
    <div class="area-detail-grid">
      <article class="area-article">
        <?php
        // Rendering principale: il post_content contiene già lead-p + h2 + body + FAQ
        // strutturati dal seed. È la fonte di verità unica.
        if (get_the_content()) {
            the_content();
        } else {
            // Fallback solo se il post è stato svuotato manualmente
            $lead = function_exists('get_field') ? get_field('lead') : '';
            if ($lead) echo '<p class="lead-p">' . nl2br(esc_html($lead)) . '</p>';
        }
        ?>
      </article>

      <aside class="area-sidebar">
        <div class="sidebar-card">
          <h4>Hai un caso urgente?</h4>
          <p>Contatta lo Studio: rispondiamo entro 24 ore lavorative. Per il penale è attiva la reperibilità H24.</p>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-primary">Richiedi consulenza</a>
        </div>

        <div class="sidebar-card" style="background:#fff;border:1px solid var(--border);padding:24px">
          <h4>Altre aree</h4>
          <ul class="sidebar-list">
            <?php
            $others = get_posts([
                'post_type'      => 'area',
                'numberposts'    => 12,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'post__not_in'   => [get_the_ID()],
            ]);
            foreach ($others as $o):
            ?>
            <li><a href="<?php echo esc_url(get_permalink($o)); ?>"><?php echo esc_html(get_the_title($o)); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <?php if ($show_urgency): ?>
        <div class="sidebar-card" style="background:var(--navy);color:#fff;border-top-color:var(--gold);padding:24px">
          <h4 style="color:#fff">Penale d'urgenza</h4>
          <p style="color:#cbd5e1">Arresti, fermi, convalide: reperibilità telefonica anche notturna e festiva.</p>
          <a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>" class="btn btn-gold" style="background:var(--gold)">📞 Chiama subito</a>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</section>

<section class="ctastrip">
  <div class="container ctastrip-inner">
    <div>
      <h3>Vuoi un parere su <?php echo esc_html(strtolower(get_the_title())); ?>?</h3>
      <p>Prima valutazione o consulenza con preventivo scritto: scegli tu.</p>
    </div>
    <div class="ctastrip-actions">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-gold">Scrivi allo Studio</a>
      <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" class="btn btn-ghost" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>

<style>
.area-article{font-size:16px;line-height:1.7;color:#334155}
.area-article > .lead-p,
.area-article > p:first-child{font-size:18px;line-height:1.7;color:#1d2c4a;margin:0 0 26px;padding-left:14px;border-left:3px solid var(--gold);font-weight:500}
.area-article h2{font-family:var(--serif);font-size:clamp(22px,3vw,28px);color:var(--navy);font-weight:600;margin:38px 0 16px;line-height:1.25}
.area-article h2:first-of-type{margin-top:26px}
.area-article h3{font-family:var(--serif);font-size:20px;color:var(--navy);font-weight:600;margin:28px 0 12px}
.area-article p{margin:0 0 16px}
.area-article ul,.area-article ol{padding-left:22px;margin:0 0 18px}
.area-article li{margin-bottom:8px;line-height:1.65}
.area-article strong{color:#1d2c4a;font-weight:600}
.area-article .faq{margin-top:18px;display:flex;flex-direction:column;gap:14px}
.area-article .faq-item{background:#fafaf7;border-left:3px solid var(--gold);padding:18px 22px;border-radius:0 6px 6px 0}
.area-article .faq-q{font-weight:600;color:var(--navy);font-size:16px;margin-bottom:8px;line-height:1.45}
.area-article .faq-a{font-size:14.5px;line-height:1.6;color:#475569}
.area-article .faq-a p:last-child{margin-bottom:0}

@media (max-width:900px){
  .area-detail-grid{grid-template-columns:1fr !important}
  .area-sidebar{margin-top:32px}
}
@media (max-width:600px){
  .area-article{font-size:15.5px}
  .area-article > .lead-p,
  .area-article > p:first-child{font-size:16.5px;padding-left:12px}
  .area-article .faq-item{padding:14px 16px}
}
</style>

<?php endwhile; get_footer();
