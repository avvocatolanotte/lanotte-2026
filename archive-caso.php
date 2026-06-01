<?php
/**
 * Archivio "Casi Studio" — elenco degli Scenari illustrativi pubblicati.
 *
 * @package lanotte-2026
 */
get_header();
?>

<section class="hero-internal" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;padding:80px 0 60px">
  <div class="container">
    <?php lanotte_breadcrumbs(); ?>
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(184,153,104,.18);border:1px solid rgba(184,153,104,.4);border-radius:2px;padding:6px 14px;margin-bottom:16px">
      <svg width="14" height="14" fill="none" stroke="#d4b87f" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
      <span style="font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#d4b87f;font-weight:700">Scenari illustrativi</span>
    </div>
    <h1 style="color:#fff;font-size:clamp(28px,4.5vw,46px);line-height:1.1;margin:0 0 16px">Casi Studio</h1>
    <p class="subtitle" style="color:#cbd5e1;max-width:720px">Esempi illustrativi che mostrano il metodo di lavoro dello Studio nelle diverse materie. Scenari ipotetici a fini divulgativi, non casi reali.</p>
  </div>
</section>

<!-- Banner deontologico -->
<div style="background:#fef9e7;border-bottom:1px solid #f0e9dc;padding:14px 0">
  <div class="container" style="display:flex;align-items:flex-start;gap:12px;max-width:900px">
    <svg width="20" height="20" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <p style="margin:0;font-size:13px;color:#78350f;line-height:1.55"><strong>Casi non reali.</strong> Gli scenari descritti sono esempi puramente illustrativi e di fantasia, elaborati a fini divulgativi. Non costituiscono casi realmente trattati né rappresentano una previsione o garanzia di risultato.</p>
  </div>
</div>

<section style="background:#fafaf7;padding:60px 0">
  <div class="container">
    <?php if (have_posts()): ?>
    <div class="casi-grid">
      <?php while (have_posts()): the_post();
        $aree = get_the_terms(get_the_ID(), 'caso_area');
        $area_name = ($aree && !is_wp_error($aree)) ? $aree[0]->name : '';
      ?>
      <a href="<?php the_permalink(); ?>" class="caso-card">
        <span class="caso-badge">Scenario illustrativo</span>
        <?php if ($area_name): ?><span class="caso-area"><?php echo esc_html($area_name); ?></span><?php endif; ?>
        <h2><?php the_title(); ?></h2>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
        <span class="caso-link">Leggi lo scenario →</span>
      </a>
      <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '← Precedenti', 'next_text' => 'Successivi →']); ?>
    <?php else: ?>
    <div class="container" style="text-align:center;padding:40px 0">
      <p style="font-size:16px;color:#64748b">Nessuno scenario pubblicato al momento.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

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

<style>
.casi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:22px;max-width:1100px;margin:0 auto}
.caso-card{display:flex;flex-direction:column;background:#fff;border:1px solid #e5e7eb;border-top:3px solid var(--gold);border-radius:8px;padding:28px 26px;text-decoration:none;transition:all .22s}
.caso-card:hover{transform:translateY(-4px);box-shadow:0 18px 38px -18px rgba(15,23,42,.2);border-color:var(--gold)}
.caso-badge{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:6px}
.caso-area{font-size:12.5px;color:#94a3b8;margin-bottom:8px}
.caso-card h2{font-family:var(--serif);font-size:21px;color:var(--navy);font-weight:600;margin:0 0 12px;line-height:1.3}
.caso-card p{font-size:14px;line-height:1.6;color:#475569;margin:0 0 16px;flex-grow:1}
.caso-link{font-size:13.5px;font-weight:600;color:var(--gold)}
@media (max-width:600px){.casi-grid{grid-template-columns:1fr}}
</style>

<?php get_footer();
