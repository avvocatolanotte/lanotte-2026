<?php
/**
 * Sezione "Lo Studio" — preview in home
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

$studio_img = LANOTTE_THEME_URI . '/assets/img/trani/palazzo-tribunale.jpg';
?>
<section class="block studio" id="studio">
  <div class="container studio-grid">
    <div class="studio-img" style="background-image:url('<?php echo esc_url($studio_img); ?>')">
      <div class="studio-img-badge"><strong>Foro</strong>di Trani</div>
    </div>
    <div>
      <div class="section-eyebrow">Lo Studio</div>
      <h2>Tradizione forense<br>e metodo multidisciplinare.</h2>
      <p class="lead">Fondato dall'Avv. Giuseppe LANOTTE, lo Studio opera stabilmente nel Foro di Trani e si avvale di corrispondenti qualificati per il patrocinio presso tutte le principali sedi giudiziarie italiane, oltre che per l'assistenza all'estero.</p>
      <p>La struttura unisce alla tradizione forense un'impostazione multidisciplinare che integra competenze civilistiche, commerciali, penali, tributarie e del lavoro. L'obiettivo è accompagnare il cliente con un interlocutore unico nella gestione di controversie, trattative e operazioni complesse.</p>
      <p>La metodologia privilegia l'analisi preventiva del rischio, la soluzione negoziata ove possibile e — in sede contenziosa — una difesa costruita con rigore metodologico.</p>
      <div class="studio-sign">
        <div>
          <div class="studio-sign-name">Avv. Giuseppe Lanotte</div>
          <div class="studio-sign-role">Titolare dello Studio</div>
        </div>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('lo-studio'))); ?>" class="btn btn-outline" style="margin-left:auto">Scopri di più →</a>
      </div>
    </div>
  </div>
</section>
