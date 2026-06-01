<?php
/**
 * Template Name: Crediti immagini
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();
?>

<section class="hero-internal" style="padding:80px 0 60px;color:#fff;background:linear-gradient(135deg,var(--navy),#1a2a4a)">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,44px);line-height:1.15;margin:8px 0 14px">Crediti delle immagini</h1>
    <p class="subtitle" style="color:#d4d8e0;max-width:760px">Attribuzioni e licenze delle fotografie utilizzate sul sito, come previsto dalle licenze Creative Commons.</p>
  </div>
</section>

<section class="block">
  <div class="container">
    <article class="legal-content credits-content">
      <p class="updated">Ultimo aggiornamento: maggio 2026</p>

      <h2>Fotografie del Foro di Trani e del Palazzo del Tribunale</h2>
      <ul>
        <li><strong>Cattedrale di Trani</strong> (Basilica di San Nicola Pellegrino) — fotografia di proprietà dello Studio.</li>
        <li><strong>Interno del Palazzo del Tribunale di Trani</strong> (atrio con lucernario) — fotografia di proprietà dello Studio.</li>
        <li><strong>Lapide latina del 1792</strong> "POPVLVS TRANENSIS PECVNIA SVA RESTITVIT" — fotografia di proprietà dello Studio (Palazzo del Tribunale di Trani).</li>
        <li><strong>Stemma marmoreo con aquila</strong> — fotografia di proprietà dello Studio (Palazzo del Tribunale di Trani).</li>
        <li><strong>Facciata della Corte d'Appello delle Puglie</strong> (Trani, sede storica 1817-1923) — fotografia di proprietà dello Studio.</li>
        <li><strong>Facciata notturna del Palazzo del Tribunale</strong> — fotografia di proprietà dello Studio.</li>
      </ul>

      <h2>Fotografie di Barletta</h2>
      <p>Le immagini del Castello Svevo e della Cattedrale di Santa Maria Maggiore di Barletta sono state ottenute da Wikimedia Commons con licenza Creative Commons.</p>
      <ul>
        <li><strong>Castello Svevo di Barletta</strong> (ponte e fossato) — <a href="https://commons.wikimedia.org/wiki/File:Castle_of_Barletta_05.jpg" target="_blank" rel="noopener">Castle_of_Barletta_05.jpg</a>, Wikimedia Commons, licenza Creative Commons.</li>
        <li><strong>Castello Svevo e Cattedrale di Santa Maria Maggiore</strong> — <a href="https://commons.wikimedia.org/wiki/File:Il_castello_guarda_la_cattedrale.jpg" target="_blank" rel="noopener">Il_castello_guarda_la_cattedrale.jpg</a>, Wikimedia Commons, licenza Creative Commons.</li>
      </ul>

      <h2>Fotografie di Bari</h2>
      <ul>
        <li><strong>Castello Normanno-Svevo di Bari</strong> — <a href="https://commons.wikimedia.org/wiki/File:Bari_-_Castello_Normanno-Svevo_-_2024-09-28_18-23-57_001.jpg" target="_blank" rel="noopener">Castello Normanno-Svevo</a>, Wikimedia Commons, licenza Creative Commons.</li>
        <li><strong>Basilica di San Nicola, Bari</strong> — <a href="https://commons.wikimedia.org/wiki/File:Bari_BW_2016-10-19_13-35-11_stitch.jpg" target="_blank" rel="noopener">Basilica San Nicola</a>, Wikimedia Commons, licenza Creative Commons (Berthold Werner).</li>
      </ul>

      <h2>Ritratti dei professionisti</h2>
      <ul>
        <li><strong>Avv. Giuseppe Lanotte</strong>, <strong>Dott.ssa Cristina De Lillo</strong>, <strong>Dott. Ruggiero Lanotte</strong> — ritratti di proprietà dei rispettivi professionisti, già in uso sul sito ufficiale dello Studio dal 2019.</li>
      </ul>

      <h2>Tipografia</h2>
      <ul>
        <li><strong>Cormorant Garamond</strong> — Catharsis Fonts, distribuita da Google Fonts con licenza Open Font License (OFL).</li>
        <li><strong>Inter</strong> — Rasmus Andersson, distribuita da Google Fonts con licenza Open Font License (OFL).</li>
      </ul>

      <h2>Icone</h2>
      <p>Icone SVG inline ispirate alle famiglie open source <em>Heroicons</em> (MIT License) e <em>Feather Icons</em> (MIT License).</p>

      <h2>Segnalazioni</h2>
      <p>Per richieste di attribuzione, rimozione o aggiunta di crediti, scrivere a <a href="mailto:<?php echo esc_attr(lanotte_email()); ?>"><?php echo esc_html(lanotte_email()); ?></a>.</p>
    </article>
  </div>
</section>

<style>
.credits-content{max-width:820px;margin:0 auto;padding:0 4px}
.credits-content .updated{font-size:13px;color:var(--text-muted);font-style:italic;margin-bottom:24px}
.credits-content h2{font-family:var(--serif);font-size:22px;color:var(--navy);font-weight:600;margin:32px 0 12px;padding-bottom:8px;border-bottom:2px solid var(--gold);display:inline-block}
.credits-content h2:first-of-type{margin-top:0}
.credits-content p{font-size:15.5px;line-height:1.7;color:var(--text);margin:0 0 14px}
.credits-content ul{list-style:none;padding:0;margin:0 0 18px;display:flex;flex-direction:column;gap:10px}
.credits-content li{padding:12px 16px 12px 32px;background:#fff;border-left:3px solid var(--gold);font-size:14.5px;line-height:1.6;color:var(--text);position:relative}
.credits-content li::before{content:"📷";position:absolute;left:10px;top:12px;font-size:14px}
.credits-content a{color:var(--gold);font-weight:500}
.credits-content a:hover{text-decoration:underline}
.credits-content strong{color:var(--navy)}

@media (max-width:680px){
  .credits-content h2{font-size:19px;margin:26px 0 10px}
  .credits-content p{font-size:14.5px}
  .credits-content li{font-size:13.5px;padding:10px 14px 10px 30px}
}
</style>

<?php endwhile; get_footer();
