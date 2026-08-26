<?php
/**
 * Bonifica SEO della rassegna: doppioni, slug deboli e redirect 301.
 */

if (!defined('ABSPATH')) exit;

function lanotte_blog_cleanup_redirects() {
    return [
        'richiesta-documentazione-bancaria' => [
            'target_id' => 450,
            'target'    => 'accesso-alla-documentazione-bancaria',
            'reason'    => 'Doppione esatto del contenuto bancario.',
        ],
        'uso-della-cosa-comune-limiti' => [
            'target_id' => 486,
            'target'    => 'luso-della-cosa-comune-parte-ciascun-condomino',
            'reason'    => 'Sovrapposizione forte sul tema art. 1102 c.c.',
        ],
        'come-difendere-i-figli-dalle-guerre-tra-genitori' => [
            'target_id' => 7713,
            'target'    => 'figli-orfani-di-un-padre-vivo',
            'reason'    => 'Cluster alienazione/conflitto genitoriale.',
        ],
        'il-padre-che-non-mantiene-i-figli-deve-risarcire-lex-fonte-il-padre-che-non-mantiene-i-figli-deve-risarcire-lex' => [
            'target_id' => 741,
            'target'    => 'assegno-di-mantenimento-non-pagato-e-reato-cassazione-penale-sez-vi-sentenza-12-12-2018-n-55744',
            'reason'    => 'Slug rotto e articolo troppo debole; destinazione tematica sul mantenimento non pagato.',
        ],
        '434-2' => [
            'target_id' => 434,
            'target'    => 'responsabilita-medica-onere-probatorio-struttura-sanitaria',
            'reason'    => 'Vecchio slug numerico.',
        ],
        '586-2' => [
            'target_id' => 586,
            'target'    => 'nuovi-modelli-deposito-domande-brevetto',
            'reason'    => 'Vecchio slug numerico.',
        ],
    ];
}

function lanotte_blog_cleanup_slug_updates() {
    return [
        434 => 'responsabilita-medica-onere-probatorio-struttura-sanitaria',
        586 => 'nuovi-modelli-deposito-domande-brevetto',
    ];
}

function lanotte_blog_cleanup_draft_sources() {
    return [
        490,  // richiesta-documentazione-bancaria
        448,  // uso-della-cosa-comune-limiti
        7741, // come-difendere-i-figli-dalle-guerre-tra-genitori
        792,  // slug rotto padre/mantenimento
    ];
}

function lanotte_unpaid_maintenance_article_content() {
    return <<<'HTML'
<!-- wp:paragraph -->
<p><em>Articolo aggiornato al 26 agosto 2026.</em></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Quando l'assegno di mantenimento non viene pagato, oppure viene versato solo in parte o con continui ritardi, il beneficiario non deve limitarsi ad attendere. Il provvedimento del giudice, anche temporaneo, e l'accordo di negoziazione assistita costituiscono la base per chiedere le somme arretrate e, nei casi previsti, ottenere che il pagamento futuro sia eseguito direttamente dal datore di lavoro o da un altro terzo.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Occorre però distinguere il <strong>recupero civile del credito</strong> dagli eventuali <strong>profili penali</strong>. Il mancato pagamento non deve essere affrontato con iniziative autonome: chi è obbligato non può sospendere o ridurre unilateralmente l'assegno e chi deve riceverlo deve scegliere lo strumento più adatto alla situazione concreta.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Cosa fare quando l'assegno di mantenimento non viene pagato</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Il primo passaggio è ricostruire con precisione il credito. È utile raccogliere:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>il provvedimento di separazione, divorzio o affidamento, oppure l'accordo di negoziazione assistita;</li><li>gli estratti conto dai quali risultano i pagamenti mancanti o incompleti;</li><li>le ricevute delle spese straordinarie eventualmente anticipate;</li><li>i messaggi e le comunicazioni scambiate tra le parti;</li><li>il calcolo della rivalutazione ISTAT, se prevista dal titolo.</li></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Una volta quantificate le somme, normalmente si procede con una <strong>formale costituzione in mora</strong>. La diffida deve indicare le mensilità non corrisposte, gli eventuali aggiornamenti e il termine entro cui adempiere. Un conteggio incompleto o non documentato può rendere più difficile la fase successiva.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Per una prima verifica degli aggiornamenti è disponibile il <a href="https://studiolegalelanotte.it/calcolatori/mantenimento-istat/">calcolatore della rivalutazione ISTAT dell'assegno di mantenimento</a>. Il risultato è informativo e deve essere controllato sul provvedimento applicabile al singolo caso.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Pagamento diretto da parte del datore di lavoro o di un altro terzo</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>L'art. 473-bis.37 del codice di procedura civile prevede uno strumento particolarmente efficace. Dopo la costituzione in mora del debitore, quando l'inadempimento dura da almeno trenta giorni, il creditore può notificare il provvedimento o l'accordo di negoziazione assistita ai terzi che devono corrispondere periodicamente somme all'obbligato, chiedendo il <strong>versamento diretto dell'assegno</strong>.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Il caso più frequente è quello del datore di lavoro, ma la norma può riguardare anche altri soggetti tenuti a pagamenti periodici. La comunicazione deve essere effettuata correttamente anche nei confronti del debitore. Dal mese successivo alla notificazione il terzo è tenuto al pagamento; se non adempie, la legge consente di agire direttamente nei suoi confronti.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Precetto, pignoramento e garanzie sul patrimonio</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>I provvedimenti in materia di contributo economico sono immediatamente esecutivi. In presenza di arretrati è quindi possibile valutare la notifica dell'atto di precetto e l'esecuzione forzata, ad esempio mediante pignoramento di conto corrente, stipendio, pensione, crediti o altri beni, nel rispetto delle regole e dei limiti previsti per ciascuna forma di espropriazione.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>L'art. 473-bis.36 c.p.c. consente inoltre, quando ricorrono i presupposti, l'iscrizione di ipoteca giudiziale, la richiesta di una garanzia personale o reale e l'autorizzazione al sequestro di beni o crediti del debitore. La scelta tra pagamento diretto, pignoramento e misure di garanzia dipende dalla continuità dell'inadempimento, dalla situazione patrimoniale e dall'urgenza di proteggere il beneficiario e i figli.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Gli arretrati dell'assegno di mantenimento si prescrivono?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Le singole rate dell'assegno sono prestazioni periodiche e, in via generale, sono soggette alla prescrizione quinquennale prevista dall'art. 2948 c.c. Il termine deve essere verificato per ciascuna mensilità e può essere interrotto da atti idonei. Per questo è sconsigliabile lasciare trascorrere molto tempo senza una contestazione formale.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Prescrizione, decorrenza e validità degli atti interruttivi richiedono comunque una valutazione concreta, soprattutto quando vi siano procedimenti ancora pendenti, accordi successivi o pagamenti parziali.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Il mancato pagamento è sempre reato?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Non ogni singolo ritardo produce automaticamente una responsabilità penale.</strong> Tuttavia, l'omesso o parziale adempimento può integrare, secondo le circostanze, la violazione degli obblighi di assistenza familiare prevista dagli artt. 570 e 570-bis del codice penale.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>L'art. 570-bis c.p. riguarda la sottrazione agli obblighi economici stabiliti in caso di separazione, divorzio, nullità del matrimonio e affidamento condiviso dei figli. Quando vengono fatti mancare i mezzi di sussistenza ai figli minori o inabili possono inoltre assumere rilievo le previsioni dell'art. 570 c.p. L'accertamento penale considera la durata e l'entità dell'inadempimento, la volontà dell'obbligato, le sue effettive risorse e le esigenze dei beneficiari.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>La difficoltà economica non autorizza comunque a smettere di pagare di propria iniziativa. La più recente giurisprudenza della Corte di cassazione ribadisce che l'obbligato non può compensare unilateralmente l'assegno con propri crediti né destinarne arbitrariamente una parte ad altre spese. Anche l'adempimento parziale può assumere rilievo penale, in relazione al caso concreto.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Cosa deve fare chi non riesce più a pagare</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Perdita del lavoro, malattia, riduzione stabile del reddito o nuove e documentate esigenze familiari possono giustificare una richiesta di revisione. Fino a quando il provvedimento non viene modificato, però, l'importo originario rimane dovuto. Non sono sufficienti un accordo verbale, una decisione unilaterale o la semplice comunicazione all'altro genitore.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Chi si trova in una situazione di reale difficoltà deve quindi attivarsi tempestivamente per chiedere al giudice la modifica delle condizioni oppure formalizzare un accordo attraverso gli strumenti consentiti dalla legge.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Come si calcola l'importo da recuperare</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Il conteggio può comprendere le rate non versate, le differenze dovute per pagamenti parziali, la rivalutazione prevista, gli interessi e le spese straordinarie documentate e rimborsabili. Prima di iniziare un'azione è necessario leggere attentamente il titolo e verificare quali voci siano realmente esigibili.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Per una valutazione preliminare dell'importo corrente può essere utile anche il <a href="https://studiolegalelanotte.it/calcolatori/mantenimento-orientativo/">calcolatore orientativo del mantenimento</a>. Non sostituisce il provvedimento del giudice e non determina automaticamente il credito.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Domande frequenti</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Basta una sola mensilità non pagata per procedere?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>La rata scaduta può essere richiesta, ma lo strumento più adatto dipende dal titolo e dalla situazione. Per il pagamento diretto del terzo l'art. 473-bis.37 c.p.c. richiede la costituzione in mora e un inadempimento di almeno trenta giorni.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Posso chiedere direttamente al datore di lavoro di pagarmi?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Sì, quando ricorrono i requisiti di legge e la notificazione viene eseguita correttamente. Non è sufficiente una richiesta informale all'azienda.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Il genitore può ridurre l'assegno perché sostiene direttamente alcune spese?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>In linea generale non può modificare unilateralmente quanto stabilito dal provvedimento. Eventuali pagamenti diretti, accordi o compensazioni devono essere valutati e documentati.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La denuncia sostituisce il recupero degli arretrati?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>No. Il procedimento penale e il recupero civile perseguono finalità differenti. Per ottenere concretamente le somme può essere necessario attivare gli strumenti civili ed esecutivi.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Assistenza per il recupero dell'assegno di mantenimento</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lo Studio Legale Lanotte &amp; Partners assiste nella verifica del titolo, nel calcolo delle somme, nella diffida, nel pagamento diretto da parte del terzo e nelle procedure esecutive, oltre che nella valutazione degli eventuali profili penali. Per esaminare la documentazione è possibile <a href="https://studiolegalelanotte.it/contatti/">richiedere un appuntamento con lo Studio</a> oppure consultare l'area dedicata a <a href="https://studiolegalelanotte.it/aree/famiglia-successioni/">famiglia e successioni</a>.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><em>Le informazioni presenti in questa pagina hanno carattere generale e informativo, sono aggiornate alla data indicata e non sostituiscono la consulenza legale sul caso concreto.</em></p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><strong>Riferimenti:</strong> artt. 570 e 570-bis c.p.; artt. 473-bis.36 e 473-bis.37 c.p.c.; art. 2948 c.c.; D.Lgs. 1 marzo 2018, n. 21; Corte di cassazione, Sez. VI penale, sentenza n. 534/2026.</p>
<!-- /wp:paragraph -->
HTML;
}

function lanotte_set_unpaid_maintenance_featured_image() {
    $source_key = 'lanotte-assegno-mantenimento-non-pagato-2026';
    $attachment_id = (int) get_option('lanotte_article_741_featured_media_20260826', 0);

    if (!$attachment_id) {
        $attachments = get_posts([
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_key'       => '_lanotte_source_asset',
            'meta_value'     => $source_key,
        ]);
        $attachment_id = isset($attachments[0]) ? (int) $attachments[0] : 0;
    }

    if (!$attachment_id) {
        $source = LANOTTE_THEME_DIR . '/assets/img/blog/assegno-mantenimento-non-pagato-2026.jpg';
        if (!is_readable($source)) return false;

        $upload = wp_upload_bits(
            'assegno-mantenimento-non-pagato-2026.jpg',
            null,
            file_get_contents($source)
        );
        if (!empty($upload['error'])) return false;

        $attachment_id = wp_insert_attachment([
            'post_mime_type' => 'image/jpeg',
            'post_title'     => 'Assegno di mantenimento non pagato: recupero degli arretrati',
            'post_content'   => '',
            'post_status'    => 'inherit',
        ], $upload['file'], 741, true);

        if (is_wp_error($attachment_id)) return false;

        require_once ABSPATH . 'wp-admin/includes/image.php';
        $metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        if ($metadata) wp_update_attachment_metadata($attachment_id, $metadata);

        update_post_meta(
            $attachment_id,
            '_wp_attachment_image_alt',
            'Consulenza legale per il recupero dell\'assegno di mantenimento non pagato'
        );
        update_post_meta($attachment_id, '_lanotte_source_asset', $source_key);
    }

    if ((int) get_post_thumbnail_id(741) !== $attachment_id && !set_post_thumbnail(741, $attachment_id)) {
        return false;
    }

    update_option('lanotte_article_741_featured_media_20260826', $attachment_id, false);
    return true;
}

function lanotte_blog_cleanup_target_url($entry) {
    if (!empty($entry['target_id'])) {
        $permalink = get_permalink((int) $entry['target_id']);
        if ($permalink) return $permalink;
    }

    return home_url('/' . trim($entry['target'], '/') . '/');
}

add_action('template_redirect', function() {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $slug = trim(basename(untrailingslashit($path)), '/');
    if (!$slug) return;

    $redirects = lanotte_blog_cleanup_redirects();
    if (!isset($redirects[$slug])) return;

    wp_safe_redirect(lanotte_blog_cleanup_target_url($redirects[$slug]), 301);
    exit;
}, 0);

add_action('init', function() {
    if (get_option('lanotte_blog_cleanup_20260616') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    foreach (lanotte_blog_cleanup_slug_updates() as $post_id => $new_slug) {
        $post = get_post((int) $post_id);
        if (!$post instanceof WP_Post || $post->post_type !== 'post') continue;
        if ($post->post_name === $new_slug) continue;

        wp_update_post([
            'ID'        => (int) $post_id,
            'post_name' => $new_slug,
        ]);
    }

    foreach (lanotte_blog_cleanup_draft_sources() as $post_id) {
        $post = get_post((int) $post_id);
        if (!$post instanceof WP_Post || $post->post_type !== 'post') continue;
        if ($post->post_status !== 'publish') continue;

        wp_update_post([
            'ID'          => (int) $post_id,
            'post_status' => 'draft',
        ]);
    }

    update_option('lanotte_blog_cleanup_20260616', 'done', false);
}, 20);

add_action('init', function() {
    if (get_option('lanotte_article_741_refresh_20260826') === 'done') return;
    if (!function_exists('wp_update_post')) return;

    $post = get_post(741);
    if (!$post instanceof WP_Post || $post->post_type !== 'post') return;

    $result = wp_update_post([
        'ID'           => 741,
        'post_title'   => 'Assegno di mantenimento non pagato: come recuperare gli arretrati e quando è reato',
        'post_excerpt' => 'Guida aggiornata al recupero dell\'assegno di mantenimento non pagato: diffida, pagamento diretto, pignoramento, prescrizione e conseguenze penali.',
        'post_content' => lanotte_unpaid_maintenance_article_content(),
    ], true);

    if (!is_wp_error($result)) {
        update_option('lanotte_article_741_refresh_20260826', 'done', false);
    }
}, 21);

add_action('init', function() {
    if (get_option('lanotte_article_741_featured_20260826') === 'done') return;
    if (!function_exists('wp_upload_bits') || !function_exists('set_post_thumbnail')) return;

    if (lanotte_set_unpaid_maintenance_featured_image()) {
        update_option('lanotte_article_741_featured_20260826', 'done', false);
    }
}, 22);
