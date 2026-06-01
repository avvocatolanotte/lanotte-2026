<?php
/**
 * ISTAT FOI auto-update — wp_cron mensile, lato server (zero CORS).
 *
 * Strategia:
 *   1. Hook wp_cron `lanotte_istat_update` schedulato il 5 di ogni mese alle 04:00
 *   2. Fetch da API ISTAT SDMX (server-side, no restrizione browser)
 *   3. Salvataggio in wp_options `lanotte_istat_foi`
 *   4. Esposto al frontend via REST: GET /wp-json/lanotte/v1/istat-foi
 *   5. Pannello admin: Impostazioni Studio → Auto-update ISTAT
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

/* ============================================================
   COSTANTI
============================================================ */
const LANOTTE_ISTAT_OPTION    = 'lanotte_istat_foi';
const LANOTTE_ISTAT_LOG       = 'lanotte_istat_log';
const LANOTTE_ISTAT_CRON_HOOK = 'lanotte_istat_update';
const LANOTTE_ISTAT_API_URL   = 'https://esploradati.istat.it/SDMXWS/rest/data/IT1,165_271_DF_DCSP_FOI1B2015_5,1.0/.IFOI.0./';

/* ============================================================
   SCHEDULAZIONE CRON
============================================================ */
add_action('init', function() {
    if (!wp_next_scheduled(LANOTTE_ISTAT_CRON_HOOK)) {
        // Prima esecuzione: domani alle 04:00, poi mensile
        $next = strtotime('tomorrow 04:00:00');
        wp_schedule_event($next, 'monthly_lanotte', LANOTTE_ISTAT_CRON_HOOK);
    }
});

add_filter('cron_schedules', function($schedules) {
    $schedules['monthly_lanotte'] = [
        'interval' => 30 * DAY_IN_SECONDS,
        'display'  => __('Mensile (30 giorni) — Lanotte ISTAT'),
    ];
    return $schedules;
});

add_action(LANOTTE_ISTAT_CRON_HOOK, 'lanotte_istat_fetch_and_store');

/* ============================================================
   FETCH SERVER-SIDE (no CORS)
============================================================ */
function lanotte_istat_fetch_and_store() {
    $resp = wp_remote_get(LANOTTE_ISTAT_API_URL, [
        'timeout'   => 30,
        'headers'   => ['Accept' => 'application/vnd.sdmx.data+json;version=1.0.0'],
        'sslverify' => true,
    ]);

    if (is_wp_error($resp)) {
        lanotte_istat_log('ERRORE fetch: ' . $resp->get_error_message(), 'error');
        return false;
    }

    $code = wp_remote_retrieve_response_code($resp);
    if ($code !== 200) {
        lanotte_istat_log('HTTP ' . $code . ' da ISTAT', 'error');
        return false;
    }

    $body = wp_remote_retrieve_body($resp);
    $json = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        lanotte_istat_log('JSON malformato: ' . json_last_error_msg(), 'error');
        return false;
    }

    $indici = lanotte_istat_parse_sdmx($json);
    if (empty($indici)) {
        lanotte_istat_log('Nessun dato estratto dalla risposta SDMX', 'warn');
        return false;
    }

    $stored = [
        'indici'       => $indici,
        'fetched_at'   => current_time('mysql'),
        'fetched_count'=> count($indici),
        'last_month'   => max(array_keys($indici)),
        'source'       => 'istat-sdmx-api',
    ];
    update_option(LANOTTE_ISTAT_OPTION, $stored, false);
    lanotte_istat_log(sprintf('OK: %d indici aggiornati, ultimo mese: %s', count($indici), $stored['last_month']), 'ok');
    return true;
}

/* ============================================================
   PARSING SDMX-JSON
============================================================ */
function lanotte_istat_parse_sdmx($json) {
    $indici = [];
    $series = $json['dataSets'][0]['series'] ?? null;
    $times  = $json['structure']['dimensions']['observation'][0]['values'] ?? null;
    if (!$series || !$times) return [];

    foreach ($series as $serie) {
        if (empty($serie['observations'])) continue;
        foreach ($serie['observations'] as $timeIdx => $obs) {
            $month = $times[(int)$timeIdx]['id'] ?? null;
            $value = $obs[0] ?? null;
            if ($month && $value !== null) {
                $indici[$month] = (float)$value;
            }
        }
    }
    ksort($indici);
    return $indici;
}

/* ============================================================
   API PUBBLICA PER FRONTEND
============================================================ */
function lanotte_istat_get_data() {
    $data = get_option(LANOTTE_ISTAT_OPTION);
    if (!$data || empty($data['indici'])) {
        // Fallback: prova a caricare il JSON statico del tema
        $static = LANOTTE_THEME_DIR . '/assets/data/istat-foi.json';
        if (file_exists($static)) {
            $j = json_decode(file_get_contents($static), true);
            if ($j) {
                return [
                    'indici'     => array_merge(
                        $j['indici'] ?? [],
                        $j['indici_da_verificare'] ?? []
                    ),
                    'fetched_at' => $j['meta']['ultimo_aggiornamento_manuale'] ?? null,
                    'source'     => 'static-json-fallback',
                    'last_month' => null,
                ];
            }
        }
        return null;
    }
    return $data;
}

function lanotte_istat_get_indice($yyyymm) {
    $data = lanotte_istat_get_data();
    return $data['indici'][$yyyymm] ?? null;
}

/* ============================================================
   ENDPOINT REST: /wp-json/lanotte/v1/istat-foi
============================================================ */
add_action('rest_api_init', function() {
    register_rest_route('lanotte/v1', '/istat-foi', [
        'methods'  => 'GET',
        'callback' => function() {
            $data = lanotte_istat_get_data();
            if (!$data) return new WP_Error('not_found', 'Dati ISTAT non disponibili', ['status' => 404]);
            return [
                'meta' => [
                    'fetched_at' => $data['fetched_at'],
                    'source'     => $data['source'] ?? 'wp-option',
                    'last_month' => $data['last_month'] ?? max(array_keys($data['indici'])),
                ],
                'indici' => $data['indici'],
            ];
        },
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('lanotte/v1', '/istat-foi/(?P<mese>\d{4}-\d{2})', [
        'methods'  => 'GET',
        'callback' => function($req) {
            $idx = lanotte_istat_get_indice($req['mese']);
            if ($idx === null) return new WP_Error('not_found', 'Indice non disponibile per ' . $req['mese'], ['status' => 404]);
            return ['mese' => $req['mese'], 'indice' => $idx];
        },
        'permission_callback' => '__return_true',
    ]);
});

/* ============================================================
   LOG ROTAZIONE (max 50 voci)
============================================================ */
function lanotte_istat_log($msg, $level = 'info') {
    $log = get_option(LANOTTE_ISTAT_LOG, []);
    if (!is_array($log)) $log = [];
    array_unshift($log, [
        'time'    => current_time('mysql'),
        'level'   => $level,
        'message' => $msg,
    ]);
    $log = array_slice($log, 0, 50);
    update_option(LANOTTE_ISTAT_LOG, $log, false);
}

/* ============================================================
   PANNELLO ADMIN: Strumenti → Auto-update ISTAT
============================================================ */
add_action('admin_menu', function() {
    add_submenu_page(
        'tools.php',
        'Auto-update ISTAT FOI',
        '📊 Auto-update ISTAT',
        'manage_options',
        'lanotte-istat',
        'lanotte_istat_admin_page'
    );
});

function lanotte_istat_admin_page() {
    // Gestione azioni
    if (isset($_POST['lanotte_force_update']) && check_admin_referer('lanotte_istat')) {
        $ok = lanotte_istat_fetch_and_store();
        echo $ok
            ? '<div class="notice notice-success"><p>✓ Aggiornamento completato.</p></div>'
            : '<div class="notice notice-error"><p>✗ Aggiornamento fallito. Vedi log sotto.</p></div>';
    }
    if (isset($_POST['lanotte_clear_log']) && check_admin_referer('lanotte_istat')) {
        delete_option(LANOTTE_ISTAT_LOG);
        echo '<div class="notice notice-success"><p>Log azzerato.</p></div>';
    }
    if (isset($_POST['lanotte_manual_value']) && check_admin_referer('lanotte_istat')) {
        $mese = sanitize_text_field($_POST['lanotte_manual_mese'] ?? '');
        $val  = (float)($_POST['lanotte_manual_value_val'] ?? 0);
        if (preg_match('/^\d{4}-\d{2}$/', $mese) && $val >= 50 && $val <= 200) {
            $data = lanotte_istat_get_data() ?: ['indici' => []];
            $data['indici'][$mese] = $val;
            $data['source'] = 'manual-admin';
            $data['fetched_at'] = current_time('mysql');
            $data['last_month'] = max(array_keys($data['indici']));
            update_option(LANOTTE_ISTAT_OPTION, $data, false);
            lanotte_istat_log("Manuale: $mese = $val", 'info');
            echo '<div class="notice notice-success"><p>✓ Valore manuale salvato.</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Mese o valore non validi.</p></div>';
        }
    }

    $data = lanotte_istat_get_data();
    $log = get_option(LANOTTE_ISTAT_LOG, []);
    $next_run = wp_next_scheduled(LANOTTE_ISTAT_CRON_HOOK);
    ?>
    <div class="wrap">
        <h1>📊 Auto-update Indici ISTAT FOI</h1>
        <p>Aggiornamento mensile automatico degli indici FOI senza tabacchi dall'API ISTAT SDMX. Server-side: <strong>nessun problema CORS</strong>.</p>

        <div style="background:#fff;border:1px solid #ccd0d4;padding:20px;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Stato corrente</h2>
            <table class="widefat" style="margin-top:14px">
                <tr><th style="width:240px">Fonte attuale</th><td><code><?php echo esc_html($data['source'] ?? 'nessuna'); ?></code></td></tr>
                <tr><th>Ultimo aggiornamento</th><td><?php echo esc_html($data['fetched_at'] ?? 'mai'); ?></td></tr>
                <tr><th>Ultimo mese disponibile</th><td><strong><?php echo esc_html($data['last_month'] ?? '—'); ?></strong></td></tr>
                <tr><th>Totale indici memorizzati</th><td><?php echo $data ? count($data['indici']) : 0; ?></td></tr>
                <tr><th>Prossima esecuzione automatica</th><td>
                    <?php echo $next_run ? esc_html(wp_date('d/m/Y H:i', $next_run)) : 'non schedulato'; ?>
                </td></tr>
            </table>
        </div>

        <div style="background:#fff;border:1px solid #ccd0d4;padding:20px;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Azioni</h2>
            <form method="post" style="display:inline-block;margin-right:10px">
                <?php wp_nonce_field('lanotte_istat'); ?>
                <button type="submit" name="lanotte_force_update" class="button button-primary">
                    🔄 Forza aggiornamento ora (fetch ISTAT)
                </button>
            </form>
            <form method="post" style="display:inline-block">
                <?php wp_nonce_field('lanotte_istat'); ?>
                <button type="submit" name="lanotte_clear_log" class="button">Azzera log</button>
            </form>
        </div>

        <div style="background:#fff;border:1px solid #ccd0d4;padding:20px;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Inserisci valore manualmente</h2>
            <p>Se il fetch automatico fallisce o ti serve un valore prima della pubblicazione ISTAT.</p>
            <form method="post">
                <?php wp_nonce_field('lanotte_istat'); ?>
                <table class="form-table">
                    <tr>
                        <th><label>Mese (YYYY-MM)</label></th>
                        <td><input type="month" name="lanotte_manual_mese" required></td>
                    </tr>
                    <tr>
                        <th><label>Valore FOI</label></th>
                        <td><input type="number" name="lanotte_manual_value_val" step="0.1" min="50" max="200" required placeholder="Es. 122.9"></td>
                    </tr>
                </table>
                <button type="submit" name="lanotte_manual_value" class="button button-primary">Salva valore</button>
            </form>
        </div>

        <?php if ($data && !empty($data['indici'])): ?>
        <div style="background:#fff;border:1px solid #ccd0d4;padding:20px;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Indici memorizzati (ultimi 24 mesi)</h2>
            <table class="widefat striped">
                <thead><tr><th>Mese</th><th>Indice FOI</th></tr></thead>
                <tbody>
                <?php
                $sorted = $data['indici'];
                krsort($sorted);
                $sorted = array_slice($sorted, 0, 24, true);
                foreach ($sorted as $m => $v):
                ?>
                <tr><td><code><?php echo esc_html($m); ?></code></td><td><strong><?php echo esc_html($v); ?></strong></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div style="background:#fff;border:1px solid #ccd0d4;padding:20px;border-radius:4px;margin:20px 0">
            <h2 style="margin-top:0">Log eventi (ultimi 50)</h2>
            <?php if (empty($log)): ?>
                <p><em>Nessun evento registrato.</em></p>
            <?php else: ?>
            <table class="widefat striped">
                <thead><tr><th style="width:170px">Data</th><th style="width:80px">Livello</th><th>Messaggio</th></tr></thead>
                <tbody>
                <?php foreach ($log as $entry):
                    $color = ['ok'=>'#16a34a','error'=>'#dc2626','warn'=>'#ca8a04','info'=>'#3b82f6'][$entry['level']] ?? '#64748b';
                ?>
                <tr>
                    <td><?php echo esc_html($entry['time']); ?></td>
                    <td><span style="color:<?php echo $color; ?>;font-weight:600;text-transform:uppercase"><?php echo esc_html($entry['level']); ?></span></td>
                    <td><?php echo esc_html($entry['message']); ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div style="background:#fffbeb;border-left:4px solid #f59e0b;padding:14px 20px;margin:20px 0;border-radius:0 4px 4px 0">
            <strong>API REST esposta:</strong><br>
            <code>GET /wp-json/lanotte/v1/istat-foi</code> — tutti gli indici<br>
            <code>GET /wp-json/lanotte/v1/istat-foi/2026-04</code> — singolo mese<br>
            Usabile dai calcolatori frontend (no CORS perché stesso dominio).
        </div>
    </div>
    <?php
}

/* ============================================================
   DISATTIVAZIONE TEMA: rimuovi cron
============================================================ */
register_deactivation_hook(__FILE__, function() {
    wp_clear_scheduled_hook(LANOTTE_ISTAT_CRON_HOOK);
});
