<?php
/**
 * Homepage builder — sezioni riordinabili da WP Admin
 *
 * Aspetto → Sezioni Home permette di:
 *  - Trascinare le sezioni per riordinarle
 *  - Attivare/disattivare ogni sezione con una checkbox
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/**
 * Definizione canonica delle sezioni della home.
 * Ogni sezione ha:
 *  - id:       slug univoco salvato in option
 *  - label:    nome visibile in admin
 *  - desc:     descrizione breve
 *  - callback: funzione che renderizza la sezione (definita in front-page.php)
 *  - default_enabled: true/false
 *  - locked:   true se NON disattivabile (es. hero)
 */
function lanotte_home_sections_registry() {
    return [
        'hero' => [
            'label' => 'Hero (titolo + CTA)',
            'desc'  => 'Banner principale con titolo, testo intro e bottoni CTA.',
            'callback' => 'lanotte_render_section_hero',
            'default_enabled' => true,
            'locked' => true,
        ],
        'painpoint' => [
            'label' => 'Pain-point (Aziende / Privati)',
            'desc'  => 'Due grandi box orientati al bisogno: [Aziende] e [Privati], che smistano l\'utente verso le aree pertinenti.',
            'callback' => 'lanotte_render_section_painpoint',
            'default_enabled' => true,
        ],
        'risorse' => [
            'label' => 'Strumenti & Risorse',
            'desc'  => '4 card: Calcolatori, Casi Studio, Glossario, Rassegna giuridica — in alto, subito visibili.',
            'callback' => 'lanotte_render_section_risorse',
            'default_enabled' => true,
        ],
        'trustbar' => [
            'label' => 'Trust bar (4 punti)',
            'desc'  => 'Striscia con icone: iscrizione Ordine, preventivo scritto, segreto professionale, penale urgenza.',
            'callback' => 'lanotte_render_section_trustbar',
            'default_enabled' => true,
        ],
        'clienti' => [
            'label' => 'Clienti istituzionali',
            'desc'  => 'Logo wall con i 7 clienti principali (ITF, Federico II, Condominiocasa, ecc.).',
            'callback' => 'lanotte_render_section_clienti',
            'default_enabled' => true,
        ],
        'aree' => [
            'label' => 'Aree di competenza (preview)',
            'desc'  => 'Griglia con 9 aree di pratica + bottone "Vedi tutte le 13 aree".',
            'callback' => 'lanotte_render_section_aree',
            'default_enabled' => true,
        ],
        'trani' => [
            'label' => 'Foro di Trani (storia)',
            'desc'  => 'Sezione fotografica sul Foro di Trani con immagini storiche.',
            'callback' => 'lanotte_render_section_trani',
            'default_enabled' => true,
        ],
        'studio' => [
            'label' => 'Lo Studio (preview)',
            'desc'  => 'Anteprima della pagina Lo Studio con foto + intro + link.',
            'callback' => 'lanotte_render_section_studio',
            'default_enabled' => true,
        ],
        'principi' => [
            'label' => 'Quattro principi etici',
            'desc'  => 'Card con i 4 valori non negoziabili (indipendenza, segreto, compenso, continuità).',
            'callback' => 'lanotte_render_section_principi',
            'default_enabled' => true,
        ],
        'recensioni' => [
            'label' => 'Recensioni',
            'desc'  => 'Carosello di testimonianze (se popolato).',
            'callback' => 'lanotte_render_section_recensioni',
            'default_enabled' => false,
        ],
        'ctastrip' => [
            'label' => 'CTA Strip',
            'desc'  => 'Striscia full-width con call-to-action prima della rassegna.',
            'callback' => 'lanotte_render_section_ctastrip',
            'default_enabled' => true,
        ],
        'blog' => [
            'label' => 'Rassegna giuridica (3 articoli)',
            'desc'  => 'Anteprima degli ultimi 3 articoli del blog.',
            'callback' => 'lanotte_render_section_blog',
            'default_enabled' => true,
        ],
    ];
}

/**
 * Legge la configurazione dal DB. Restituisce array ordinato di
 * ['id' => 'hero', 'enabled' => true], ...
 * con merge dei default per sezioni nuove.
 */
function lanotte_home_sections_config() {
    $registry = lanotte_home_sections_registry();
    $saved = get_option('lanotte_home_sections', []);
    if (!is_array($saved)) $saved = [];

    $result = [];
    $known_ids = [];
    foreach ($saved as $item) {
        if (!isset($item['id'], $registry[$item['id']])) continue;
        $known_ids[] = $item['id'];
        $result[] = [
            'id' => $item['id'],
            'enabled' => !empty($item['enabled']),
        ];
    }
    // Aggiungi sezioni nuove (default_enabled) in coda
    foreach ($registry as $id => $def) {
        if (in_array($id, $known_ids, true)) continue;
        $result[] = [
            'id' => $id,
            'enabled' => !empty($def['default_enabled']),
        ];
    }
    return $result;
}

/**
 * Pagina admin: Aspetto → Sezioni Home
 */
add_action('admin_menu', function() {
    add_theme_page(
        'Sezioni Home',
        '🏠 Sezioni Home',
        'edit_theme_options',
        'lanotte-home-sections',
        'lanotte_home_sections_page'
    );
});

/**
 * Salva il form (POST)
 */
add_action('admin_init', function() {
    if (!isset($_POST['lanotte_home_sections_save'])) return;
    if (!current_user_can('edit_theme_options')) return;
    check_admin_referer('lanotte_home_sections');

    $order  = isset($_POST['section_order']) ? (array) $_POST['section_order'] : [];
    $enabled = isset($_POST['section_enabled']) ? (array) $_POST['section_enabled'] : [];
    $registry = lanotte_home_sections_registry();

    $config = [];
    foreach ($order as $id) {
        $id = sanitize_key($id);
        if (!isset($registry[$id])) continue;
        $is_locked = !empty($registry[$id]['locked']);
        $config[] = [
            'id' => $id,
            'enabled' => $is_locked ? true : in_array($id, $enabled, true),
        ];
    }
    update_option('lanotte_home_sections', $config);

    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible"><p><strong>✓ Ordine sezioni salvato.</strong></p></div>';
    });
});

function lanotte_home_sections_page() {
    $registry = lanotte_home_sections_registry();
    $config = lanotte_home_sections_config();
    ?>
    <div class="wrap">
      <h1>🏠 Sezioni Home — riordina e attiva/disattiva</h1>
      <p>Trascina le righe per cambiare l'ordine in cui appaiono in homepage. Spunta/togli la spunta per attivare o disattivare una sezione.</p>

      <form method="post" id="lanotte-sections-form">
        <?php wp_nonce_field('lanotte_home_sections'); ?>

        <ul id="lanotte-sortable" style="list-style:none;padding:0;max-width:780px;margin:24px 0">
          <?php foreach ($config as $item):
              $id = $item['id'];
              if (!isset($registry[$id])) continue;
              $def = $registry[$id];
              $is_locked = !empty($def['locked']);
              $enabled = $is_locked ? true : !empty($item['enabled']);
          ?>
          <li class="lanotte-sec-row" style="background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:14px 18px;margin-bottom:8px;display:flex;align-items:center;gap:14px;<?php echo $is_locked ? 'opacity:.92' : 'cursor:move'; ?>">
            <span class="dashicons dashicons-menu" style="color:#8c8f94;font-size:20px;<?php echo $is_locked ? 'opacity:.3' : ''; ?>"></span>
            <input type="hidden" name="section_order[]" value="<?php echo esc_attr($id); ?>">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;min-width:180px">
              <input type="checkbox" name="section_enabled[]" value="<?php echo esc_attr($id); ?>" <?php checked($enabled); ?> <?php disabled($is_locked); ?>>
              <strong style="font-size:14px"><?php echo esc_html($def['label']); ?></strong>
              <?php if ($is_locked): ?><span style="font-size:11px;background:#fef9e7;color:#92400e;padding:2px 7px;border-radius:3px;font-weight:600">FISSO</span><?php endif; ?>
            </label>
            <span style="font-size:13px;color:#646970;flex-grow:1;line-height:1.4"><?php echo esc_html($def['desc']); ?></span>
          </li>
          <?php endforeach; ?>
        </ul>

        <p>
          <button type="submit" name="lanotte_home_sections_save" class="button button-primary button-large">💾 Salva ordine sezioni</button>
          <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="button button-secondary">Vedi home →</a>
        </p>

        <details style="margin-top:30px;max-width:780px">
          <summary style="cursor:pointer;font-weight:600;color:#646970">⟳ Ripristina ordine predefinito</summary>
          <p style="margin:12px 0">Se vuoi tornare all'ordine iniziale del tema:</p>
          <button type="submit" name="lanotte_home_sections_reset" value="1" class="button"
            onclick="return confirm('Confermi il ripristino all\'ordine di default?');"
            formaction="<?php echo esc_url(admin_url('themes.php?page=lanotte-home-sections&reset=1')); ?>">
            Ripristina default
          </button>
        </details>
      </form>
    </div>

    <script>
    jQuery(function($){
      if ($.fn.sortable) {
        $('#lanotte-sortable').sortable({
          handle: '.dashicons-menu',
          axis: 'y',
          tolerance: 'pointer',
          placeholder: 'lanotte-sec-placeholder',
          forcePlaceholderSize: true,
          items: '> li:not(:has(.dashicons[style*="opacity:.3"]))', // blocca drag su locked
        });
      }
    });
    </script>
    <style>
    .lanotte-sec-placeholder{background:#fef9e7 !important;border:2px dashed #d4b87f !important;height:54px;margin-bottom:8px;border-radius:6px}
    .lanotte-sec-row.ui-sortable-helper{box-shadow:0 12px 28px -10px rgba(0,0,0,.2)}
    </style>
    <?php
}

/**
 * Reset all'ordine di default
 */
add_action('admin_init', function() {
    if (!isset($_GET['page'], $_GET['reset']) || $_GET['page'] !== 'lanotte-home-sections') return;
    if (!current_user_can('edit_theme_options')) return;
    delete_option('lanotte_home_sections');
    wp_safe_redirect(admin_url('themes.php?page=lanotte-home-sections'));
    exit;
});

/* Enqueue jQuery UI Sortable in admin (per la pagina) */
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'appearance_page_lanotte-home-sections') return;
    wp_enqueue_script('jquery-ui-sortable');
});
