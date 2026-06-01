<?php
/**
 * Footer globale
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;
?>

<!-- FOOTER -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <?php
        $dark_logo = lanotte_logo_url('dark');
        if ($dark_logo): ?>
          <img src="<?php echo esc_url($dark_logo); ?>" alt="Lanotte &amp; Partners — Studio Legale" class="footer-logo" style="max-width:240px;height:auto;margin-bottom:16px;display:block">
        <?php else: ?>
          <div class="footer-brand">Lanotte &amp; Partners<small>Studio Legale</small></div>
        <?php endif; ?>
        <p><?php echo wp_kses_post(lanotte_acf_option('footer_intro', 'Avv. Giuseppe LANOTTE — Iscritto all\'Ordine degli Avvocati di Trani.<br>C.F.: LNTGPP78B01L328P · P.IVA: 06731750722')); ?></p>
        <p style="margin-top:14px"><strong style="color:#fff">Sede:</strong> <?php echo esc_html(lanotte_indirizzo()); ?></p>
        <div class="footer-social">
          <?php $fb = lanotte_acf_option('social_facebook',  'https://www.facebook.com/studiolegalelanotte/'); ?>
          <?php $ig = lanotte_acf_option('social_instagram', 'https://www.instagram.com/studio_legale_lanotte'); ?>
          <?php $ln = lanotte_acf_option('social_linkedin'); ?>
          <?php if ($fb): ?><a href="<?php echo esc_url($fb); ?>" aria-label="Facebook" target="_blank" rel="noopener"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.99 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a><?php endif; ?>
          <?php if ($ig): ?><a href="<?php echo esc_url($ig); ?>" aria-label="Instagram" target="_blank" rel="noopener"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a><?php endif; ?>
          <?php if ($ln): ?><a href="<?php echo esc_url($ln); ?>" aria-label="LinkedIn" target="_blank" rel="noopener"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg></a><?php endif; ?>
        </div>
      </div>

      <div>
        <h5>Aree</h5>
        <?php if (has_nav_menu('footer-1')): ?>
          <?php wp_nav_menu(['theme_location' => 'footer-1', 'container' => false, 'depth' => 1]); ?>
        <?php else: ?>
        <ul>
          <?php
          $aree = get_posts(['post_type' => 'area', 'numberposts' => 6, 'orderby' => 'menu_order', 'order' => 'ASC']);
          foreach ($aree as $a) {
              echo '<li><a href="' . esc_url(get_permalink($a)) . '">' . esc_html(get_the_title($a)) . '</a></li>';
          }
          ?>
        </ul>
        <?php endif; ?>
      </div>

      <div>
        <h5>Studio</h5>
        <?php if (has_nav_menu('footer-2')): ?>
          <?php wp_nav_menu(['theme_location' => 'footer-2', 'container' => false, 'depth' => 1]); ?>
        <?php else: ?>
        <ul>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('lo-studio'))); ?>">Chi siamo</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('carriere'))); ?>">Carriere · Cerchiamo avvocati</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('onorari'))); ?>">Onorari</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Rassegna giuridica</a></li>
          <?php $casi_url = get_post_type_archive_link('caso'); if ($casi_url): ?>
          <li><a href="<?php echo esc_url($casi_url); ?>">Casi studio</a></li>
          <?php endif; ?>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('newsletter'))); ?>">Newsletter</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('glossario'))); ?>">Glossario giuridico</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('calcolatori'))); ?>">Calcolatori</a></li>
          <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('penale-urgenza'))); ?>" style="color:#ef4444;font-weight:600">Penale d'urgenza H24</a></li>
        </ul>
        <?php endif; ?>
      </div>

      <div>
        <h5>Contatti</h5>
        <?php if (has_nav_menu('footer-3')): ?>
          <?php wp_nav_menu(['theme_location' => 'footer-3', 'container' => false, 'depth' => 1]); ?>
        <?php else: ?>
        <ul>
          <li><a href="tel:<?php echo esc_attr(lanotte_phone(true)); ?>"><?php echo esc_html(lanotte_phone()); ?></a></li>
          <li><a href="mailto:<?php echo esc_attr(lanotte_email()); ?>"><?php echo esc_html(lanotte_email()); ?></a></li>
          <li><a href="mailto:<?php echo esc_attr(lanotte_pec()); ?>">PEC studio</a></li>
          <li><span style="color:#94a3b8"><?php echo esc_html(lanotte_orari()); ?></span></li>
        </ul>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer-bottom">
      <div>© <?php echo esc_html(date('Y')); ?> Studio Legale Lanotte &amp; Partners · Tutti i diritti riservati</div>
      <div>
        <?php if (has_nav_menu('legal')): ?>
          <?php wp_nav_menu(['theme_location' => 'legal', 'container' => false, 'depth' => 1, 'items_wrap' => '%3$s']); ?>
        <?php else: ?>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy'))); ?>">Privacy</a>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('cookie'))); ?>">Cookie</a>
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('credits'))); ?>">Credits</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</footer>

<a href="<?php echo esc_url(lanotte_whatsapp_url()); ?>" class="wa-float" aria-label="WhatsApp" target="_blank" rel="noopener">
  <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
