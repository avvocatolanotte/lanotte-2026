<?php
/**
 * Single "Caso Studio" — Scenario illustrativo
 *
 * IMPORTANTE (deontologia): questi sono casi IMMAGINARI a scopo illustrativo,
 * non risultati reali. L'etichetta e il disclaimer sono OBBLIGATORI e visibili
 * (artt. 17, 35 c.d.f. — informazione veritiera, divieto di promesse di esito).
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();
$aree = get_the_terms(get_the_ID(), 'caso_area');
$area_name = ($aree && !is_wp_error($aree)) ? $aree[0]->name : '';
?>

<section class="hero-internal" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;padding:80px 0 60px">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(184,153,104,.18);border:1px solid rgba(184,153,104,.4);border-radius:2px;padding:6px 14px;margin-bottom:16px">
      <svg width="14" height="14" fill="none" stroke="#d4b87f" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
      <span style="font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#d4b87f;font-weight:700">Scenario illustrativo</span>
    </div>
    <?php if ($area_name): ?><div style="font-size:13px;color:#cbd5e1;margin-bottom:8px"><?php echo esc_html($area_name); ?></div><?php endif; ?>
    <h1 style="color:#fff;font-size:clamp(26px,4vw,40px);line-height:1.15;margin:0"><?php the_title(); ?></h1>
  </div>
</section>

<!-- Banner deontologico -->
<div style="background:#fef9e7;border-bottom:1px solid #f0e9dc;padding:14px 0">
  <div class="container" style="display:flex;align-items:flex-start;gap:12px;max-width:860px">
    <svg width="20" height="20" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <p style="margin:0;font-size:13px;color:#78350f;line-height:1.55"><strong>Caso non reale.</strong> Lo scenario qui descritto è puramente illustrativo e di fantasia: serve a spiegare il metodo di lavoro dello Studio e non rappresenta un caso effettivamente trattato né costituisce promessa o garanzia di un determinato risultato.</p>
  </div>
</div>

<article class="caso-content">
  <div class="container" style="max-width:820px">
    <?php the_content(); ?>
  </div>
</article>

<section class="ctastrip">
  <div class="container ctastrip-inner">
    <div>
      <h3>Hai una situazione simile?</h3>
      <p>Ogni caso reale è diverso. Raccontaci il tuo: ti diciamo se e come possiamo assisterti, con preventivo scritto ex art. 13 L. 247/2012.</p>
    </div>
    <div class="ctastrip-actions">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-gold">Scrivi allo Studio</a>
      <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" class="btn btn-ghost" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>

<!-- Altri scenari -->
<section style="background:var(--cream);padding:50px 0">
  <div class="container">
    <div style="text-align:center;margin-bottom:28px">
      <div class="section-eyebrow">Altri scenari illustrativi</div>
      <h2 style="font-family:var(--serif);font-size:26px;color:var(--navy);margin:6px 0 0">Continua a leggere</h2>
    </div>
    <div class="blog-grid">
      <?php
      $related = new WP_Query([
          'post_type'      => 'caso',
          'posts_per_page' => 3,
          'post__not_in'   => [get_the_ID()],
          'orderby'        => 'rand',
      ]);
      while ($related->have_posts()): $related->the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="caso-card" style="display:block;background:#fff;border:1px solid var(--border);border-top:3px solid var(--gold);padding:24px;text-decoration:none;transition:all .2s">
          <span style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);font-weight:700">Scenario illustrativo</span>
          <h3 style="font-family:var(--serif);font-size:19px;color:var(--navy);margin:8px 0 0;line-height:1.3"><?php the_title(); ?></h3>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<style>
.caso-content{padding:50px 0}
.caso-content h2{font-family:var(--serif);font-size:clamp(20px,2.6vw,26px);color:var(--navy);font-weight:600;margin:32px 0 12px;padding-left:14px;border-left:3px solid var(--gold)}
.caso-content h2:first-child{margin-top:0}
.caso-content p{font-size:16.5px;line-height:1.75;color:#334155;margin:0 0 18px}
.caso-content strong{color:#1d2c4a}
.caso-card:hover{transform:translateY(-3px);box-shadow:0 16px 32px -16px rgba(15,23,42,.18)}
@media (max-width:600px){.caso-content p{font-size:15.5px}}
</style>

<?php endwhile; get_footer();
