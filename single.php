<?php
/**
 * Single post — Rassegna Giuridica
 * Layout magazine-style, no duplicate featured image.
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();
$cats = get_the_category();
$cat = $cats ? $cats[0]->name : '';
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

// Detect if the post content already starts with an image (avoid duplicate render)
$content_raw = get_the_content();
$content_starts_with_img = (bool) preg_match('/^\s*<(figure|img|p[^>]*>\s*<img)/i', trim($content_raw));
?>

<section class="post-hero<?php echo $thumb_url ? ' has-image' : ''; ?>"<?php if ($thumb_url): ?> style="background-image:linear-gradient(180deg,rgba(15,23,42,.45) 0%,rgba(15,23,42,.85) 70%,rgba(15,23,42,.95) 100%),url('<?php echo esc_url($thumb_url); ?>')"<?php endif; ?>>
  <div class="container post-hero-inner">
    <?php lanotte_breadcrumbs(); ?>
    <?php if ($cat): ?><span class="post-cat"><?php echo esc_html($cat); ?></span><?php endif; ?>
    <h1 class="post-title"><?php the_title(); ?></h1>
    <div class="post-meta">
      <span><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18M8 2v4M16 2v4"/></svg> <?php echo esc_html(get_the_date('j F Y')); ?></span>
      <span><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a7 7 0 0114 0v1"/></svg> <?php the_author(); ?></span>
      <span><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> <?php echo esc_html(lanotte_reading_time()); ?></span>
    </div>
  </div>
</section>

<div class="post-wrap">
  <div class="container post-grid">

    <article class="post-content">
      <?php
      // Mostra l'immagine in evidenza SOLO se il contenuto non inizia già con un'immagine
      // (evita la duplicazione che si vedeva prima).
      if (!$content_starts_with_img && has_post_thumbnail() && !$thumb_url) {
          echo '<figure class="post-feat"><img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')) . '" alt="' . esc_attr(get_the_title()) . '"></figure>';
      }
      the_content();
      wp_link_pages();
      ?>

      <div class="post-share">
        <strong>Condividi:</strong>
        <a href="https://wa.me/?text=<?php echo rawurlencode(get_the_title() . ' — ' . get_permalink()); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 1.67c2.2 0 4.27.86 5.82 2.42a8.21 8.21 0 012.42 5.82c0 4.54-3.7 8.24-8.24 8.24-1.51 0-2.99-.39-4.27-1.13l-.3-.18-3.13.82.83-3.05-.2-.32a8.18 8.18 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="Facebook">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.99 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
        </a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
        </a>
        <a href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&body=<?php echo rawurlencode(get_permalink()); ?>" aria-label="Email">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </a>
      </div>
    </article>

    <aside class="post-sidebar">
      <div class="ps-card ps-cta">
        <h4>Vuoi un parere su questo tema?</h4>
        <p>Prima valutazione in studio o videocall. Risposta entro 24 ore.</p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-primary" style="width:100%">Prenota colloquio →</a>
        <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" target="_blank" rel="noopener" class="ps-wa">WhatsApp diretto →</a>
      </div>

      <div class="ps-card">
        <h4>📅 Pubblicato</h4>
        <p><?php echo esc_html(get_the_date('j F Y')); ?></p>
        <?php $modif = get_the_modified_date('U'); $pub = get_the_date('U'); if ($modif - $pub > 86400): ?>
        <p style="font-size:12.5px;color:#94a3b8;margin-top:6px">Aggiornato il <?php echo esc_html(get_the_modified_date('j F Y')); ?></p>
        <?php endif; ?>
      </div>

      <?php $tags = get_the_tags(); if ($tags): ?>
      <div class="ps-card">
        <h4>🏷 Tag</h4>
        <div class="ps-tags">
          <?php foreach ($tags as $t): ?>
            <a href="<?php echo esc_url(get_tag_link($t)); ?>"><?php echo esc_html($t->name); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </aside>

  </div>
</div>

<section class="ctastrip">
  <div class="container ctastrip-inner">
    <div>
      <h3>Vuoi un parere sulla tua situazione?</h3>
      <p>Consulenza riservata in studio o in videocall. Risposta entro 24 ore.</p>
    </div>
    <div class="ctastrip-actions">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-gold">Prenota colloquio</a>
      <a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" class="btn btn-ghost" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>

<!-- Articoli correlati -->
<section class="related-articles" style="background:var(--cream);padding:60px 0">
  <div class="container">
    <div style="text-align:center;margin-bottom:32px">
      <div class="section-eyebrow">Continua a leggere</div>
      <h2 style="font-family:var(--serif);font-size:clamp(24px,3vw,32px);color:var(--navy);font-weight:600;margin:8px 0 0">Altri articoli</h2>
    </div>
    <div class="blog-grid">
      <?php
      $cat_ids = wp_list_pluck($cats, 'term_id');
      $related = new WP_Query([
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'post__not_in'   => [get_the_ID()],
          'category__in'   => $cat_ids,
          'orderby'        => 'rand',
      ]);
      if (!$related->have_posts()) {
          $related = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => [get_the_ID()]]);
      }
      while ($related->have_posts()): $related->the_post();
          get_template_part('template-parts/post-card');
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
  </div>
</section>

<style>
.post-hero{background:#0f172a;color:#fff;padding:90px 0 60px;background-size:cover;background-position:center;position:relative}
.post-hero.has-image{padding:140px 0 70px;min-height:380px}
.post-hero-inner{position:relative;z-index:2;max-width:780px}
.post-hero .breadcrumbs{margin-bottom:18px}
.post-hero .breadcrumbs a,.post-hero .breadcrumbs span{color:#cbd5e1 !important}
.post-cat{display:inline-block;background:rgba(184,153,104,.2);color:#d4b87f;font-size:11px;letter-spacing:.14em;text-transform:uppercase;padding:5px 12px;border-radius:2px;font-weight:600;margin-bottom:16px}
.post-title{font-family:var(--serif);font-size:clamp(28px,4.5vw,46px);color:#fff;font-weight:600;line-height:1.15;margin:0 0 24px;text-shadow:0 2px 14px rgba(0,0,0,.25)}
.post-meta{display:flex;flex-wrap:wrap;gap:20px;font-size:13px;color:#cbd5e1}
.post-meta svg{color:#d4b87f}

.post-wrap{background:#fff;padding:60px 0}
.post-grid{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:48px;align-items:start;max-width:1180px}

.post-content{font-size:17px;line-height:1.75;color:#1f2937}
.post-content > .post-feat{margin:0 0 32px;border-radius:8px;overflow:hidden}
.post-content > .post-feat img{display:block;width:100%;height:auto}
.post-content h2{font-family:var(--serif);font-size:clamp(22px,2.6vw,30px);color:var(--navy);font-weight:600;margin:38px 0 16px;line-height:1.25}
.post-content h3{font-family:var(--serif);font-size:22px;color:var(--navy);font-weight:600;margin:32px 0 14px}
.post-content h4{font-size:18px;color:var(--navy);font-weight:600;margin:24px 0 10px}
.post-content p{margin:0 0 20px}
.post-content > p:first-of-type::first-letter{font-family:var(--serif);font-size:64px;line-height:.9;float:left;color:var(--gold);font-weight:600;margin:6px 14px 0 0}
.post-content ul,.post-content ol{padding-left:24px;margin:0 0 22px}
.post-content li{margin-bottom:8px;line-height:1.7}
.post-content blockquote{border-left:4px solid var(--gold);background:#fef9e7;padding:20px 26px;margin:30px 0;font-style:italic;font-size:18px;color:#5b3a05;border-radius:0 6px 6px 0}
.post-content blockquote p:last-child{margin:0}
.post-content strong{color:#1d2c4a;font-weight:600}
.post-content a{color:var(--navy);text-decoration:none;border-bottom:1px solid var(--gold);transition:all .15s}
.post-content a:hover{color:var(--gold)}
.post-content img{max-width:100%;height:auto;border-radius:6px;margin:16px 0}
.post-content figure{margin:24px 0}
.post-content figure figcaption{font-size:13px;color:#64748b;font-style:italic;text-align:center;margin-top:8px}

/* SHARE */
.post-share{margin-top:40px;padding-top:24px;border-top:1px solid #e5e7eb;display:flex;align-items:center;gap:14px;flex-wrap:wrap}
.post-share strong{font-size:13px;color:#64748b;letter-spacing:.04em;text-transform:uppercase;font-weight:700;letter-spacing:.1em}
.post-share a{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;background:#f1f5f9;color:var(--navy);border-radius:50%;text-decoration:none;border:0 !important;transition:all .2s}
.post-share a:hover{background:var(--gold);color:#fff;transform:translateY(-2px)}

/* SIDEBAR */
.post-sidebar{position:sticky;top:90px;display:flex;flex-direction:column;gap:18px}
.ps-card{background:#fafaf7;border:1px solid #e5e7eb;border-radius:6px;padding:22px 22px;border-top:3px solid var(--gold)}
.ps-card h4{font-family:var(--serif);font-size:17px;color:var(--navy);font-weight:600;margin:0 0 10px}
.ps-card p{font-size:14px;line-height:1.6;color:#475569;margin:0 0 12px}
.ps-card p:last-child{margin-bottom:0}
.ps-cta{background:linear-gradient(180deg,#fdfbf5 0%,#fff 100%);border-top-color:var(--gold)}
.ps-wa{display:block;text-align:center;font-size:13px;color:#16a34a;text-decoration:none;font-weight:600;margin-top:10px}
.ps-tags{display:flex;flex-wrap:wrap;gap:6px}
.ps-tags a{font-size:12px;background:#fff;color:var(--navy);border:1px solid #e5e7eb;padding:4px 10px;border-radius:3px;text-decoration:none;transition:all .15s}
.ps-tags a:hover{background:var(--gold);color:#fff;border-color:var(--gold)}

@media (max-width:900px){
  .post-grid{grid-template-columns:1fr;gap:32px}
  .post-sidebar{position:static;flex-direction:column;order:2}
  .post-hero.has-image{padding:90px 0 50px;min-height:auto}
  .post-content{font-size:16px}
  .post-content > p:first-of-type::first-letter{font-size:50px;margin:4px 10px 0 0}
}
@media (max-width:600px){
  .post-hero{padding:60px 0 40px}
  .post-hero.has-image{padding:80px 0 40px}
  .post-content{font-size:15.5px;line-height:1.7}
  .post-content blockquote{padding:16px 18px;font-size:15.5px}
  .post-meta{gap:14px;font-size:12px}
}
</style>

<?php endwhile; get_footer();
