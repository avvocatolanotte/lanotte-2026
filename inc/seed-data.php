<?php
/**
 * Seed dei contenuti iniziali per il tema:
 * - 13 aree di competenza (con tagline, lead, sezioni, FAQ)
 * - Pagine fondamentali (Lo Studio, Onorari, Contatti, Privacy, Cookie)
 *
 * Esecuzione MANUALE: aprire /wp-admin/?lanotte_seed=1 da utente admin
 * (sicuro, non si esegue automaticamente).
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/* Trigger 0: AUTO-SEED all'attivazione del tema (più potente) */
add_action('after_switch_theme', 'lanotte_force_seed_now', 20);
// Priorità 20: DEVE girare DOPO la registrazione dei CPT (init priorità 10),
// altrimenti post_type_exists('caso'/'cliente'/'team') è false e il seed salta.
add_action('init', 'lanotte_auto_seed_if_first_load', 20);

function lanotte_force_seed_now() {
    // Esegue immediatamente alla prima attivazione del tema
    $seeded = lanotte_seed_run();
    update_option('lanotte_seeded_at', current_time('mysql'));
    update_option('lanotte_seeded_count', $seeded);
}

function lanotte_auto_seed_if_first_load() {
    // Verifica che il tema sia davvero attivo
    if (get_option('stylesheet') !== 'lanotte-2026') return;

    // Determina se serve seed:
    //  1) mai eseguito prima
    //  2) versione tema cambiata rispetto a quella seedata (es. upload v14 sopra v13)
    //  3) manca almeno una pagina critica (es. Calcolatori aggiunta dopo)
    $theme = wp_get_theme('lanotte-2026');
    $current_version = $theme->exists() ? $theme->get('Version') : '';
    $seeded_version  = get_option('lanotte_seeded_version', '');
    $seeded_at       = get_option('lanotte_seeded_at');

    $required_slugs = ['lo-studio', 'onorari', 'contatti', 'privacy', 'cookie', 'rassegna', 'calcolatori', 'penale-urgenza', 'carriere', 'glossario', 'newsletter', 'credits'];
    $missing_page = false;
    foreach ($required_slugs as $slug) {
        if (!get_page_by_path($slug)) { $missing_page = true; break; }
    }

    $needs_seed = (!$seeded_at)
                  || ($current_version && $current_version !== $seeded_version)
                  || $missing_page;

    if (!$needs_seed) return;

    $seeded = lanotte_seed_run();
    update_option('lanotte_seeded_at', current_time('mysql'));
    update_option('lanotte_seeded_count', $seeded);
    update_option('lanotte_seeded_version', $current_version);

    // Flush rewrite rules per registrare i nuovi permalink dei CPT
    flush_rewrite_rules();
}

/* Trigger 1: URL ?lanotte_seed=1 (admin OR frontend) — manuale */
add_action('init', 'lanotte_maybe_run_seed', 20);
add_action('admin_init', 'lanotte_maybe_run_seed', 5);

function lanotte_maybe_run_seed() {
    if (!isset($_GET['lanotte_seed'])) return;
    if (!current_user_can('manage_options')) return;
    if (get_transient('lanotte_seed_running')) return;
    set_transient('lanotte_seed_running', 1, 60);

    $seeded = lanotte_seed_run();
    update_option('lanotte_seeded_at', current_time('mysql'));

    add_action('admin_notices', function() use ($seeded) {
        echo '<div class="notice notice-success is-dismissible"><p>';
        echo '<strong>✅ Lanotte 2026 — Seed completato!</strong> ';
        echo 'Inseriti/verificati: ' . esc_html($seeded['aree']) . ' aree e ' . esc_html($seeded['pagine']) . ' pagine.';
        echo ' <a href="' . esc_url(home_url('/')) . '">Vai alla home →</a>';
        echo '</p></div>';
    });

    // Se sei in frontend, redirect a /wp-admin/ con messaggio
    if (!is_admin()) {
        wp_safe_redirect(admin_url('?lanotte_seed_done=1'));
        exit;
    }
}

/* Trigger 2: admin notice persistente con bottone fino a seed completato */
add_action('admin_notices', function() {
    if (!current_user_can('manage_options')) return;
    if (get_option('lanotte_seeded_at')) return; // già seedato
    if (get_page_by_path('onorari')) return; // pagina onorari esiste già

    $seed_url = wp_nonce_url(admin_url('?lanotte_seed=1'), 'lanotte_seed');
    echo '<div class="notice notice-warning"><p>';
    echo '<strong>⚙️ Lanotte 2026 — Setup iniziale necessario.</strong><br>';
    echo 'Crea automaticamente: pagina Onorari, Lo Studio, Contatti, Privacy, Cookie, Rassegna + 13 Aree di Competenza.<br><br>';
    echo '<a href="' . esc_url($seed_url) . '" class="button button-primary button-large">▶️ ESEGUI SETUP INIZIALE</a>';
    echo '</p></div>';
});

/* Trigger 3: pagina dedicata in Strumenti */
add_action('admin_menu', function() {
    add_submenu_page(
        'tools.php',
        'Lanotte Setup',
        '🔧 Lanotte Setup',
        'manage_options',
        'lanotte-setup',
        'lanotte_setup_page'
    );
});

function lanotte_setup_page() {
    if (isset($_POST['lanotte_run_seed']) && check_admin_referer('lanotte_seed_form')) {
        $seeded = lanotte_seed_run();
        update_option('lanotte_seeded_at', current_time('mysql'));
        echo '<div class="notice notice-success"><p><strong>✅ Seed completato!</strong> ' . $seeded['aree'] . ' aree, ' . $seeded['pagine'] . ' pagine.</p></div>';
    }

    $aree_count = wp_count_posts('area');
    $aree_pubblicate = is_object($aree_count) ? $aree_count->publish : 0;
    $pagine_create = 0;
    foreach (['lo-studio', 'onorari', 'contatti', 'privacy', 'cookie', 'rassegna'] as $slug) {
        if (get_page_by_path($slug)) $pagine_create++;
    }
    ?>
    <div class="wrap">
        <h1>🔧 Lanotte 2026 — Setup Iniziale</h1>
        <p>Click sul bottone qui sotto per creare automaticamente tutte le pagine e le 13 Aree di Competenza con contenuti pre-popolati.</p>

        <div style="background:#fff;padding:20px;border:1px solid #ccd0d4;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Stato attuale</h2>
            <table class="widefat">
                <tr><th>Aree pubblicate</th><td><strong><?php echo $aree_pubblicate; ?></strong> / 13</td></tr>
                <tr><th>Pagine principali</th><td><strong><?php echo $pagine_create; ?></strong> / 6 (Lo Studio, Onorari, Contatti, Privacy, Cookie, Rassegna)</td></tr>
                <tr><th>Ultimo seed</th><td><?php echo esc_html(get_option('lanotte_seeded_at', 'mai eseguito')); ?></td></tr>
            </table>
        </div>

        <form method="post">
            <?php wp_nonce_field('lanotte_seed_form'); ?>
            <button type="submit" name="lanotte_run_seed" class="button button-primary button-hero" style="font-size:18px;padding:8px 30px">
                ▶️ ESEGUI / RIPETI SETUP
            </button>
            <p class="description">Sicuro da rieseguire — non duplica contenuti esistenti, crea solo quelli mancanti.</p>
        </form>

        <h2 style="margin-top:40px">URL alternative per seed</h2>
        <ul>
            <li>Frontend: <code><?php echo home_url('/?lanotte_seed=1'); ?></code></li>
            <li>Admin: <code><?php echo admin_url('?lanotte_seed=1'); ?></code></li>
        </ul>
    </div>
    <?php
}

/**
 * Pulizia delle pagine residue del VECCHIO sito (clonato da live).
 * Le sposta nel CESTINO (recuperabili da Pagine → Cestino), non le cancella.
 * Esegue una sola volta (guardia option). Colpisce solo slug noti del
 * vecchio sito, MAI gli slug del nuovo tema.
 */
function lanotte_cleanup_old_site_pages() {
    if (get_option('lanotte_old_pages_cleaned')) return 0;

    // Slug del VECCHIO sito da rimuovere (duplicati/orfani). NON includere mai
    // gli slug nuovi: lo-studio, onorari, contatti, privacy, cookie, rassegna,
    // calcolatori, penale-urgenza, carriere, glossario, newsletter, credits.
    $old_slugs = [
        'consulenze-e-pratiche',
        'servizi-principali',
        'aree-di-competenza',
        'privacy-policy',
        'cookie-policy',
        'rassegna-giuridica',
        'lostudio',
        'lo-studio-2', 'contatti-2', 'privacy-2', 'home-2', // tipici suffissi di duplicati WP
    ];

    $trashed = 0;
    foreach ($old_slugs as $slug) {
        $page = get_page_by_path($slug);
        if (!$page) continue;
        // Cestina anche i figli (es. servizi-principali/no-profit)
        $children = get_posts([
            'post_type'   => 'page',
            'post_parent' => $page->ID,
            'numberposts' => -1,
            'post_status' => 'any',
            'fields'      => 'ids',
        ]);
        foreach ($children as $cid) { wp_trash_post($cid); $trashed++; }
        wp_trash_post($page->ID);
        $trashed++;
    }

    update_option('lanotte_old_pages_cleaned', current_time('mysql'));
    if ($trashed) update_option('lanotte_old_pages_trashed_count', $trashed);
    return $trashed;
}

function lanotte_seed_run() {
    $count_aree = 0; $count_pagine = 0;

    /* === PULIZIA PAGINE VECCHIO SITO (una tantum, nel cestino) === */
    if (function_exists('lanotte_cleanup_old_site_pages')) {
        lanotte_cleanup_old_site_pages();
    }

    /* === AREE === */
    $aree = lanotte_seed_aree_data();

    // Override / arricchimento da contenuti live importati dal sito attuale.
    // Se il file /inc/aree-content-live.php esiste, sovrascrive lead/sezioni/faq
    // per gli slug presenti, mantenendo titolo/tagline/urgency.
    $live_file = LANOTTE_THEME_DIR . '/inc/aree-content-live.php';
    if (file_exists($live_file)) {
        $live_data = include $live_file;
        if (is_array($live_data)) {
            foreach ($aree as $idx => $area) {
                if (isset($live_data[$area['slug']])) {
                    $patch = $live_data[$area['slug']];
                    if (!empty($patch['lead']))    $aree[$idx]['lead']    = $patch['lead'];
                    if (!empty($patch['sezioni'])) $aree[$idx]['sezioni'] = $patch['sezioni'];
                    if (!empty($patch['faq']))     $aree[$idx]['faq']    = $patch['faq'];
                }
            }
        }
    }
    foreach ($aree as $i => $a) {
        // Costruisco l'HTML completo del contenuto (compatibile ACF free + Pro)
        $html_content = '';
        if (!empty($a['lead'])) {
            $html_content .= '<p class="lead-p">' . nl2br(esc_html($a['lead'])) . '</p>' . "\n\n";
        }
        foreach (($a['sezioni'] ?? []) as $s) {
            if (!empty($s['h'])) {
                $html_content .= '<h2>' . esc_html($s['h']) . '</h2>' . "\n";
            }
            if (!empty($s['body'])) {
                $html_content .= $s['body'] . "\n\n";
            }
        }
        if (!empty($a['faq'])) {
            $html_content .= '<h2>Domande frequenti</h2>' . "\n";
            $html_content .= '<div class="faq">' . "\n";
            foreach ($a['faq'] as $f) {
                $html_content .= '<div class="faq-item">' . "\n";
                $html_content .= '  <div class="faq-q">' . esc_html($f['q']) . '</div>' . "\n";
                $html_content .= '  <div class="faq-a">' . wp_kses_post($f['a']) . '</div>' . "\n";
                $html_content .= '</div>' . "\n";
            }
            $html_content .= '</div>' . "\n";
        }

        $existing = get_page_by_path($a['slug'], OBJECT, 'area');

        if ($existing) {
            // Area già esistente: aggiorna post_content SE
            //  - è vuoto / troppo corto (bug precedente), OPPURE
            //  - manca la sezione FAQ (rendering incompleto), OPPURE
            //  - manca almeno una sezione <h2> oltre alle FAQ (sezioni perse)
            // Salta aggiornamento se l'admin ha messo meta _lanotte_user_edited=1
            $user_edited = get_post_meta($existing->ID, '_lanotte_user_edited', true);
            $current_content = $existing->post_content;
            $has_faq         = strpos($current_content, 'Domande frequenti') !== false;
            $h2_count        = substr_count($current_content, '<h2');
            $needs_update    = !$user_edited && (
                strlen(trim(strip_tags($current_content))) < 80 ||
                !$has_faq ||
                $h2_count < 2
            );
            if ($needs_update) {
                wp_update_post([
                    'ID'           => $existing->ID,
                    'post_content' => $html_content,
                    'post_excerpt' => $a['tagline'],
                ]);
            }
            $post_id = $existing->ID;
        } else {
            $post_id = wp_insert_post([
                'post_type'    => 'area',
                'post_status'  => 'publish',
                'post_title'   => $a['title'],
                'post_name'    => $a['slug'],
                'post_content' => $html_content,
                'menu_order'   => $i + 1,
                'post_excerpt' => $a['tagline'],
            ]);
            if (is_wp_error($post_id) || !$post_id) continue;
        }

        // Se ACF Pro è disponibile, popola anche i campi (per editing da admin)
        if (function_exists('update_field')) {
            update_field('tagline', $a['tagline'], $post_id);
            update_field('lead',    $a['lead'],    $post_id);
            update_field('show_urgency', !empty($a['urgency']), $post_id);

            $sezioni_value = [];
            foreach (($a['sezioni'] ?? []) as $s) {
                $sezioni_value[] = ['titolo' => $s['h'], 'contenuto' => $s['body']];
            }
            update_field('sezioni', $sezioni_value, $post_id);

            $faq_value = [];
            foreach (($a['faq'] ?? []) as $f) {
                $faq_value[] = ['domanda' => $f['q'], 'risposta' => $f['a']];
            }
            update_field('faq', $faq_value, $post_id);
        }
        $count_aree++;
    }

    /* === PAGINE === */
    $pagine = [
        ['title' => 'Lo Studio',        'slug' => 'lo-studio',     'template' => 'page-lo-studio.php'],
        ['title' => 'Onorari',          'slug' => 'onorari',       'template' => 'page-onorari.php'],
        ['title' => 'Contatti',         'slug' => 'contatti',      'template' => 'page-contatti.php'],
        ['title' => 'Privacy',          'slug' => 'privacy',       'template' => ''],
        ['title' => 'Cookie',           'slug' => 'cookie',        'template' => ''],
        ['title' => 'Rassegna Giuridica','slug' => 'rassegna',     'template' => '', 'set_blog' => true],
        ['title' => 'Calcolatori',      'slug' => 'calcolatori',   'template' => 'page-calcolatori.php'],
        ['title' => 'Penale d\'Urgenza H24', 'slug' => 'penale-urgenza',  'template' => 'page-penale-urgenza.php'],
        ['title' => 'Carriere',         'slug' => 'carriere',      'template' => 'page-carriere.php'],
        ['title' => 'Glossario Giuridico','slug' => 'glossario',   'template' => 'page-glossario.php'],
        ['title' => 'Newsletter',       'slug' => 'newsletter',    'template' => 'page-newsletter.php'],
        ['title' => 'Credits',          'slug' => 'credits',       'template' => 'page-credits.php'],
    ];
    // Slug delle pagine speciali che hanno un template strutturato e NON devono
    // mostrare post_content (rendono il template direttamente).
    // NB: 'lo-studio' è ESCLUSO — preserviamo eventuale contenuto manuale; il template
    // ha un fallback ricco quando post_content è vuoto.
    $template_driven = ['onorari', 'contatti', 'calcolatori', 'penale-urgenza', 'carriere', 'glossario', 'newsletter', 'credits'];

    foreach ($pagine as $p) {
        $existing = get_page_by_path($p['slug']);
        if ($existing) {
            // Pulizia: se la pagina è template-driven ma ha post_content sporco
            // (ereditato da seed/import precedenti, blocchi non responsive), lo svuotiamo.
            if (in_array($p['slug'], $template_driven, true) && !empty($existing->post_content)) {
                wp_update_post([
                    'ID'           => $existing->ID,
                    'post_content' => '',
                ]);
            }
            // Assicura il template corretto
            if (!empty($p['template'])) {
                update_post_meta($existing->ID, '_wp_page_template', $p['template']);
            }
            continue;
        }
        $page_id = wp_insert_post([
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_title'  => $p['title'],
            'post_name'   => $p['slug'],
            'post_content' => '',
        ]);
        if (is_wp_error($page_id) || !$page_id) continue;
        if (!empty($p['template'])) {
            update_post_meta($page_id, '_wp_page_template', $p['template']);
        }
        if (!empty($p['set_blog'])) {
            update_option('show_on_front', 'page');
            update_option('page_for_posts', $page_id);
        }
        $count_pagine++;
    }

    /* === HOME COME PAGE === */
    if ($home = get_page_by_path('home')) {
        update_option('page_on_front', $home->ID);
    } else {
        $home_id = wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Home', 'post_name' => 'home']);
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }

    /* === CASI STUDIO (bozze) === */
    if (function_exists('lanotte_seed_casi_studio')) {
        lanotte_seed_casi_studio();
    }

    /* === CLIENTI + TEAM nei CPT (editabili da bacheca) === */
    if (function_exists('lanotte_seed_clienti')) lanotte_seed_clienti();
    if (function_exists('lanotte_seed_team'))    lanotte_seed_team();

    return ['aree' => $count_aree, 'pagine' => $count_pagine];
}

function lanotte_seed_aree_data() {
    return [
        [
            'slug' => 'diritto-penale', 'title' => 'Diritto Penale',
            'tagline' => 'Difesa in ogni grado di giudizio, reperibilità H24 per arresti e fermi.',
            'lead' => 'Il diritto penale è il ramo del diritto che si occupa di quelle infrazioni talmente gravi da essere sanzionate con le pene, prima fra tutte la sottrazione della libertà.',
            'urgency' => true,
            'sezioni' => [
                ['h' => 'Cosa facciamo', 'body' => '<p>Assistiamo persone fisiche, professionisti e imprese in ogni fase del procedimento penale, dalle indagini preliminari al giudizio di legittimità.</p><ul><li><strong>Misure cautelari</strong> personali e reali</li><li><strong>Riti speciali</strong>: patteggiamento, abbreviato, decreto penale</li><li><strong>Difesa in dibattimento</strong> davanti a Tribunale, Corte d\'Assise, GdP</li><li><strong>Appello e Cassazione</strong></li><li><strong>Esecuzione penale</strong>: misure alternative</li></ul>'],
                ['h' => 'Penale d\'urgenza · Reperibilità H24', 'body' => '<p>Per <strong>arresti, fermi e convalide</strong> è attiva una linea di reperibilità telefonica anche notturna e festiva.</p>'],
            ],
            'faq' => [
                ['q' => 'Mi è stato notificato un avviso di garanzia: cosa devo fare?', 'a' => 'L\'avviso di garanzia significa che è iscritto un procedimento penale a tuo carico. È fondamentale nominare subito un difensore di fiducia.'],
                ['q' => 'Posso scegliere il rito abbreviato anche se sono innocente?', 'a' => 'Sì. Il rito abbreviato comporta uno sconto di pena fino a un terzo. La scelta va valutata caso per caso con il difensore.'],
                ['q' => 'Quanto costa una difesa penale?', 'a' => 'Forniamo preventivo scritto sin dal primo incontro, conforme all\'art. 13 L. 247/2012, sulla base dei parametri DM 55/2014.'],
            ],
        ],
        [
            'slug' => 'diritto-civile', 'title' => 'Diritto Civile',
            'tagline' => 'Obbligazioni, responsabilità contrattuale, locazioni, diritti reali, esecuzione forzata.',
            'lead' => 'Il diritto civile è il cuore dell\'attività ordinaria di uno studio legale: regola i rapporti tra privati, le obbligazioni contrattuali, la responsabilità extracontrattuale, i diritti reali, le successioni e l\'esecuzione forzata.',
            'sezioni' => [
                ['h' => 'Cosa facciamo', 'body' => '<ul><li><strong>Contrattualistica civile</strong>: compravendita, locazione, comodato, mandato</li><li><strong>Responsabilità civile</strong> contrattuale ed extracontrattuale</li><li><strong>Locazioni</strong>: sfratto per morosità, finita locazione, mediazione</li><li><strong>Diritti reali</strong>: usucapione, servitù, comunione, divisione</li><li><strong>Esecuzione forzata</strong>: precetti, pignoramenti</li><li><strong>Recupero crediti</strong> giudiziale e stragiudiziale</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto dura una causa civile?', 'a' => 'Dipende dal Tribunale e dalla complessità. Una causa ordinaria di primo grado richiede mediamente 2-4 anni.'],
                ['q' => 'Cos\'è il decreto ingiuntivo?', 'a' => 'È un provvedimento del giudice che ordina al debitore di pagare entro 40 giorni una somma certa, liquida ed esigibile.'],
            ],
        ],
        [
            'slug' => 'famiglia-successioni', 'title' => 'Famiglia e Successioni',
            'tagline' => 'Separazioni, divorzi, eredità, divisioni, tutele e amministrazione di sostegno.',
            'lead' => 'Le questioni familiari e successorie sono fra le più delicate. Lo Studio affronta separazioni, divorzi, accordi sui figli e successioni ereditarie con un approccio che privilegia la soluzione negoziata.',
            'sezioni' => [
                ['h' => 'Diritto di famiglia', 'body' => '<ul><li>Separazioni e divorzi consensuali e giudiziali</li><li>Negoziazione assistita</li><li>Affidamento dei figli, assegno di mantenimento</li><li>Convivenze di fatto e unioni civili</li><li>Amministrazione di sostegno</li></ul>'],
                ['h' => 'Successioni ed eredità', 'body' => '<ul><li>Pubblicazione testamenti, accettazione e rinuncia</li><li>Successione legittima e testamentaria</li><li>Divisione ereditaria giudiziale e stragiudiziale</li><li>Azione di riduzione per lesione della legittima</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto costa una separazione consensuale?', 'a' => 'Una separazione consensuale con accordi semplici può chiudersi con costi contenuti tramite negoziazione assistita.'],
                ['q' => 'Il coniuge separato eredita?', 'a' => 'Sì, il coniuge separato senza addebito conserva i diritti successori.'],
            ],
        ],
        [
            'slug' => 'condominio', 'title' => 'Diritto Condominiale',
            'tagline' => 'Assistenza ad amministratori e condòmini, contenzioso, mediazione obbligatoria.',
            'lead' => 'Siamo partner di www.condominiocasa.it per l\'amministrazione condominiale professionale. Lo Studio assiste tanto gli amministratori quanto i singoli condòmini.',
            'sezioni' => [
                ['h' => 'Cosa facciamo', 'body' => '<ul><li>Impugnazione di delibere assembleari</li><li>Recupero crediti condominiali (decreto ingiuntivo ex art. 63)</li><li>Lavori straordinari: contratti, contenzioso</li><li>Liti tra condòmini</li><li>Mediazione obbligatoria ex D.Lgs. 28/2010</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto tempo ho per impugnare una delibera?', 'a' => '30 giorni dalla data dell\'assemblea (per dissenzienti o astenuti) o dalla comunicazione del verbale (per assenti).'],
            ],
        ],
        [
            'slug' => 'impresa', 'title' => 'Diritto d\'Impresa',
            'tagline' => 'Project financing, recupero crediti, contrattualistica, ufficio legale in outsourcing.',
            'lead' => 'Lo Studio assiste imprese, startup e professionisti nella gestione legale ordinaria e nelle operazioni straordinarie.',
            'sezioni' => [
                ['h' => 'Servizi per l\'impresa', 'body' => '<ul><li>Project financing</li><li>Contrattualistica nazionale e internazionale</li><li>Recupero crediti</li><li>Ufficio legale in outsourcing</li><li>Operazioni straordinarie (M&amp;A, cessioni)</li><li>Crisi d\'impresa (composizione negoziata)</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Cos\'è l\'outsourcing legale?', 'a' => 'È la gestione esterna delle incombenze legali ordinarie dell\'azienda tramite un pacchetto mensile a tariffa concordata.'],
            ],
        ],
        [
            'slug' => 'infortunistica-malasanita', 'title' => 'Infortunistica e Malasanità',
            'tagline' => 'Sinistri stradali gravi e mortali, infortuni sul lavoro, responsabilità medica.',
            'lead' => 'Lo Studio assiste vittime di sinistri stradali, infortuni sul lavoro e sportivi, e casi di responsabilità medica.',
            'sezioni' => [
                ['h' => 'Sinistri stradali', 'body' => '<ul><li>Sinistri gravi e mortali (anche penale)</li><li>Risarcimento danni patrimoniali e non patrimoniali</li><li>Procedura di risarcimento diretto (CARD)</li><li>Sinistri con veicoli non identificati</li></ul>'],
                ['h' => 'Malasanità', 'body' => '<ul><li>Errore diagnostico, terapeutico, chirurgico</li><li>Mancato consenso informato</li><li>Legge Gelli-Bianco</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto tempo ho per chiedere il risarcimento?', 'a' => '2 anni dal sinistro per i danni materiali (5 anni se c\'è reato).'],
            ],
        ],
        [
            'slug' => 'lavoro', 'title' => 'Diritto del Lavoro',
            'tagline' => 'Contenzioso individuale e collettivo, licenziamenti, mobbing, vertenze sindacali.',
            'lead' => 'Lo Studio assiste lavoratori e aziende in ogni tipo di controversia lavoristica.',
            'sezioni' => [
                ['h' => 'Per il lavoratore', 'body' => '<ul><li>Impugnazione licenziamenti</li><li>Demansionamento e mobbing</li><li>Differenze retributive, TFR</li><li>Naspi e prestazioni INPS</li></ul>'],
                ['h' => 'Per l\'azienda', 'body' => '<ul><li>Contrattualistica</li><li>Licenziamenti disciplinari</li><li>Procedure: contestazioni, audizioni</li><li>Crisi e ristrutturazioni</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto tempo ho per impugnare un licenziamento?', 'a' => '60 giorni per l\'impugnazione stragiudiziale; poi 180 giorni per il deposito del ricorso giudiziale.'],
            ],
        ],
        [
            'slug' => 'tributario', 'title' => 'Diritto Tributario',
            'tagline' => 'Accertamenti, contenzioso fiscale, rateizzazioni, definizioni agevolate.',
            'lead' => 'L\'area fiscale è guidata dal Dott. Ruggiero LANOTTE. Lo Studio assiste persone fisiche e imprese davanti all\'Agenzia delle Entrate e alle Corti di Giustizia Tributaria.',
            'sezioni' => [
                ['h' => 'Servizi tributari', 'body' => '<ul><li>Avvisi di accertamento</li><li>Cartelle esattoriali, rateizzazione, definizione agevolata</li><li>Contenzioso davanti alla Corte di Giustizia Tributaria</li><li>Reati tributari</li><li>Strumenti deflativi</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Cosa fare se ricevo un accertamento?', 'a' => 'Hai 60 giorni per presentare osservazioni o aderire (con sconto delle sanzioni). Poi 60 giorni per ricorrere.'],
            ],
        ],
        [
            'slug' => 'proprieta-intellettuale', 'title' => 'Proprietà Intellettuale',
            'tagline' => 'Marchi, brevetti, design davanti a UIBM, EUIPO e OMPI. Tutela contro contraffazione.',
            'lead' => 'Lo Studio è specializzato in tutela e contenzioso della proprietà industriale, davanti a UIBM, EUIPO e OMPI.',
            'sezioni' => [
                ['h' => 'Servizi IP', 'body' => '<ul><li>Ricerche di anteriorità</li><li>Deposito marchio nazionale, UE e internazionale</li><li>Brevetti, modelli, disegni</li><li>Opposizione e cancellazione marchio</li><li>Contenzioso: contraffazione, concorrenza sleale</li><li>Tutela del know-how</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto dura un marchio?', 'a' => '10 anni dalla data di deposito, rinnovabili indefinitamente.'],
            ],
        ],
        [
            'slug' => 'bancario', 'title' => 'Diritto Bancario',
            'tagline' => 'Anatocismo, usura, contestazione di rapporti bancari, opposizione a esecuzioni.',
            'lead' => 'Lo Studio assiste cittadini e imprese nel contenzioso con istituti di credito.',
            'sezioni' => [
                ['h' => 'Servizi', 'body' => '<ul><li>Verifica tecnica dei rapporti bancari</li><li>Anatocismo</li><li>Usura bancaria</li><li>Mutui: clausole vessatorie</li><li>Opposizione a decreto ingiuntivo</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Cos\'è il tasso soglia usurario?', 'a' => 'È il limite oltre cui il tasso applicato diventa usurario, trimestralmente pubblicato dalla Banca d\'Italia.'],
            ],
        ],
        [
            'slug' => 'internazionale-privato', 'title' => 'Internazionale Privato',
            'tagline' => 'Riconoscimento sentenze estere, cittadinanza, contratti transfrontalieri.',
            'lead' => 'Lo Studio gestisce questioni con elementi di estraneità: matrimoni misti, sentenze estere, contratti transfrontalieri, cittadinanza.',
            'sezioni' => [
                ['h' => 'Aree', 'body' => '<ul><li>Cittadinanza italiana</li><li>Matrimoni misti e divorzi internazionali</li><li>Sottrazione internazionale di minori (Aja 1980)</li><li>Riconoscimento sentenze estere</li><li>Contratti internazionali</li><li>Successioni internazionali</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Una sentenza di divorzio estera vale in Italia?', 'a' => 'Sì, ma va trascritta. Per i Paesi UE è automatica.'],
            ],
        ],
        [
            'slug' => 'previdenza', 'title' => 'Diritto Previdenziale',
            'tagline' => 'Pensioni, invalidità, contenzioso INPS e INAIL.',
            'lead' => 'Lo Studio assiste i cittadini nei rapporti con gli enti previdenziali per il riconoscimento di pensioni, invalidità, infortuni.',
            'sezioni' => [
                ['h' => 'Materie trattate', 'body' => '<ul><li>Pensione di vecchiaia, anticipata, reversibilità</li><li>Invalidità civile</li><li>Legge 104/1992</li><li>Indennità di accompagnamento</li><li>Infortuni INAIL</li><li>Naspi</li></ul>'],
            ],
            'faq' => [
                ['q' => 'Quanto tempo ho per ricorrere contro un verbale INPS?', 'a' => 'Dopo istanza amministrativa (entro 90 gg), hai 6 mesi per il ricorso giudiziale.'],
            ],
        ],
        [
            'slug' => 'no-profit', 'title' => 'No Profit · Terzo Settore',
            'tagline' => 'Associazioni sportive, ETS, costituzione, statuti, regime fiscale agevolato.',
            'lead' => 'Lo Studio assiste ASD/SSD, ETS, ODV, APS, fondazioni e cooperative sociali, dalla costituzione alla gestione.',
            'sezioni' => [
                ['h' => 'Servizi', 'body' => '<ul><li>Costituzione di associazioni e fondazioni</li><li>Iscrizione RUNTS</li><li>Adeguamento statuti (D.Lgs. 117/2017)</li><li>Riforma dello sport (D.Lgs. 36/2021)</li><li>Convenzioni con enti pubblici</li></ul>'],
            ],
            'faq' => [
                ['q' => 'La mia ASD deve adeguarsi alla Riforma dello Sport?', 'a' => 'Sì, salvo limitate eccezioni. L\'inquadramento dei collaboratori sportivi è cambiato dal 2023.'],
            ],
        ],
    ];
}
