<?php
/**
 * Card di un'area di competenza (usata in home + archive)
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$icon_svg = function_exists('get_field') ? get_field('icon_svg') : '';
$tagline  = function_exists('get_field') ? get_field('tagline') : '';
?>
<a class="area-card" href="<?php the_permalink(); ?>">
  <div class="area-icon">
    <?php
    if ($icon_svg) {
        echo wp_kses($icon_svg, [
            'svg'    => ['fill' => true, 'stroke' => true, 'stroke-width' => true, 'viewbox' => true, 'width' => true, 'height' => true],
            'path'   => ['d' => true, 'fill' => true, 'stroke' => true],
            'circle' => ['cx' => true, 'cy' => true, 'r' => true],
            'rect'   => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true],
            'line'   => ['x1' => true, 'y1' => true, 'x2' => true, 'y2' => true],
        ]);
    } else {
        echo '<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M3 21h18M5 21V8l7-5 7 5v13M9 21V11h6v10"/></svg>';
    }
    ?>
  </div>
  <h3><?php the_title(); ?></h3>
  <p><?php
    if ($tagline) {
        echo esc_html(wp_trim_words($tagline, 26, '…'));
    } else {
        echo esc_html(get_the_excerpt() ?: wp_trim_words(get_the_content(), 26, '…'));
    }
  ?></p>
  <span class="area-link">Scopri di più →</span>
</a>
