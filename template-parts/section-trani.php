<?php
/**
 * Sezione "Foro di Trani" — home
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$trani = function_exists('get_field') ? get_field('trani', 'option') : null;

$eyebrow  = $trani['eyebrow']  ?? 'Radicamento territoriale';
$titolo   = $trani['titolo']   ?? 'Iscritti al Foro di Trani.<br>Una tradizione forense<br>che dura dal 1779.';
$corpo    = $trani['corpo']    ?? '<p>Lo Studio opera stabilmente presso il Tribunale di Trani, il Tribunale di Bari e la Corte d\'Appello di Bari, con rete di corrispondenti per la giurisdizione di legittimità e per il diritto internazionale.</p>';
$citaz    = $trani['citazione'] ?? '«Populus Tranensis pecunia sua restituit» — la lapide del 1792 testimonia la lunga tradizione civica e giuridica della città.';
$bg       = $trani['bg_image'] ?? (LANOTTE_THEME_URI . '/assets/img/trani/cattedrale-trani.jpg');
$img1     = $trani['img1']     ?? (LANOTTE_THEME_URI . '/assets/img/trani/lapide-latina.jpg');
$img2     = $trani['img2']     ?? (LANOTTE_THEME_URI . '/assets/img/trani/stemma-aquila.jpg');
$img3     = $trani['img3']     ?? (LANOTTE_THEME_URI . '/assets/img/trani/palazzo-tribunale.jpg');
?>
<section class="trani-section" style="background:var(--navy);color:#fff;padding:0;position:relative;overflow:hidden">
  <div style="background-image:linear-gradient(135deg,rgba(14,26,51,.82) 0%,rgba(14,26,51,.55) 60%,rgba(14,26,51,.85) 100%),url('<?php echo esc_url($bg); ?>');background-size:cover;background-position:center;padding:96px 0">
    <div class="container" style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center">
      <div>
        <div class="section-eyebrow" style="color:var(--gold-light)"><?php echo esc_html($eyebrow); ?></div>
        <h2 style="font-family:var(--serif);font-size:clamp(30px,3.5vw,42px);font-weight:600;line-height:1.15;margin-bottom:20px;color:#fff"><?php echo wp_kses_post($titolo); ?></h2>
        <div style="font-size:17px;color:#e2e8f0;line-height:1.7;margin-bottom:18px;font-weight:300"><?php echo wp_kses_post($corpo); ?></div>
        <?php if ($citaz): ?>
        <p style="font-size:15px;color:#cbd5e1;line-height:1.7;font-style:italic"><?php echo esc_html($citaz); ?></p>
        <?php endif; ?>
        <div style="margin-top:32px;display:flex;gap:40px;border-top:1px solid rgba(255,255,255,.12);padding-top:24px">
          <div><strong style="font-family:var(--serif);font-size:30px;color:var(--gold);display:block;line-height:1">3</strong><span style="font-size:13px;color:#cbd5e1">Sedi giudiziarie principali</span></div>
          <div><strong style="font-family:var(--serif);font-size:30px;color:var(--gold);display:block;line-height:1">5</strong><span style="font-size:13px;color:#cbd5e1">Città servite in BAT</span></div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;height:480px">
        <div style="background-image:url('<?php echo esc_url($img1); ?>');background-size:cover;background-position:center;border-top:3px solid var(--gold)"></div>
        <div style="display:grid;grid-template-rows:1fr 1fr;gap:16px">
          <div style="background-image:url('<?php echo esc_url($img2); ?>');background-size:cover;background-position:center;background-color:var(--paper);border-top:3px solid var(--gold)"></div>
          <div style="background-image:url('<?php echo esc_url($img3); ?>');background-size:cover;background-position:center;border-top:3px solid var(--gold)"></div>
        </div>
      </div>
    </div>
  </div>
</section>
