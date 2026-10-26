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
    <h1 style="margin-left:auto;margin-right:auto">Pagina non trovata</h1><?php /* .hero-internal h1 è largo al massimo 880 px e attaccato a sinistra: qui va centrato come il resto */ ?>
    <p class="subtitle" style="margin:0 auto">La pagina richiesta non esiste o è stata spostata. Torni alla home o cerchi ciò che Le serve.</p>
    <?php /* 26/10/2026 (punto 13 del restyling): il testo invita a cercare, quindi il campo di ricerca deve esserci. */ ?>
    <div style="max-width:480px;margin:32px auto 0"><?php get_search_form(); ?></div>
    <div style="margin-top:40px;display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Pagina iniziale</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('area')); ?>" class="btn btn-ghost">Aree di competenza</a>
    </div>
  </div>
</section>

<?php get_footer();
