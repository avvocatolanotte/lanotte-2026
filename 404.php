<?php
/**
 * 404 — pagina non trovata
 *
 * @package lanotte-2026
 */
get_header();
?>

<section class="hero-internal" style="text-align:center;padding:120px 0">
  <div class="container">
    <div style="font-family:var(--serif);font-size:120px;color:var(--gold);line-height:1;margin-bottom:20px">404</div>
    <h1>Pagina non trovata</h1>
    <p class="subtitle" style="margin:0 auto">La pagina che stai cercando non esiste o è stata spostata. Torna alla home o cerca quello che ti serve.</p>
    <div style="margin-top:40px;display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Torna alla home</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="btn btn-ghost">Aree di competenza</a>
    </div>
  </div>
</section>

<?php get_footer();
