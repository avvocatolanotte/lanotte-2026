<?php
/**
 * Pagine WordPress e shortcode per i calcolatori.
 *
 * Ogni strumento resta nel tema come motore HTML/JS, ma viene pubblicato
 * dentro una vera pagina WordPress tramite shortcode.
 */

if (!defined('ABSPATH')) exit;

function lanotte_calcolatori_map() {
    return [
        'aqp'                  => 'aqp.html',
        'contributo-unificato' => 'contributo-unificato.html',
        'danni-preesistenti'   => 'danni-preesistenti.html',
        'interessi-legali'     => 'interessi-legali.html',
        'interessi-moratori'   => 'interessi-moratori.html',
        'istat-locazione'      => 'istat-locazione.html',
        'macropermanenti'      => 'macropermanenti.html',
        'mantenimento-istat'   => 'mantenimento-istat.html',
        'micropermanenti'      => 'micropermanenti.html',
        'opposizione-decreto-ingiuntivo' => 'opposizione-decreto-ingiuntivo.html',
        'parcella-civile'      => 'parcella-civile.html',
        'parcella-penale'      => 'parcella-penale.html',
        'pignoramento-stipendio-pensione' => 'pignoramento-stipendio-pensione.html',
        'prescrizione-crediti' => 'prescrizione-crediti.html',
        'scadenze'             => 'scadenze.html',
        'spese-straordinarie-figli' => 'spese-straordinarie-figli.html',
        'sfratti'              => 'sfratti.html',
        'stragiudiziale'       => 'stragiudiziale.html',
        'svalutazione'         => 'svalutazione.html',
        'timeline-marchio'     => 'timeline-marchio.html',
    ];
}

function lanotte_calcolatore_url($slug) {
    return home_url('/calcolatori/' . sanitize_title($slug) . '/');
}

function lanotte_inline_calcolatore_theme_scripts($html) {
    $theme_uri = preg_quote(LANOTTE_THEME_URI, '~');

    return preg_replace_callback(
        '~<script\s+src=["\']' . $theme_uri . '/assets/js/([^"\']+\.js)["\']\s*></script>~i',
        function($match) {
            $relative = ltrim($match[1], '/');
            if (strpos($relative, '..') !== false) {
                return $match[0];
            }

            $base = realpath(LANOTTE_THEME_DIR . '/assets/js');
            $path = realpath(LANOTTE_THEME_DIR . '/assets/js/' . $relative);
            if (!$base || !$path || strpos($path, $base) !== 0 || !is_readable($path)) {
                return $match[0];
            }

            $code = file_get_contents($path);
            if ($code === false) {
                return $match[0];
            }

            $code = str_replace('</script>', '<\/script>', $code);
            return '<script data-lanotte-inline-asset="' . esc_attr($relative) . '">' . "\n" . $code . "\n" . '</script>';
        },
        $html
    );
}

add_action('init', function() {
    add_rewrite_tag('%lanotte_calcolatori_sitemap%', '1');
    add_rewrite_rule('^lanotte-calcolatori\.xml$', 'index.php?lanotte_calcolatori_sitemap=1', 'top');
}, 9);

add_filter('query_vars', function($vars) {
    $vars[] = 'lanotte_calcolatori_sitemap';
    return $vars;
});

add_action('template_redirect', function() {
    if (!get_query_var('lanotte_calcolatori_sitemap')) return;

    status_header(200);
    header('Content-Type: application/xml; charset=UTF-8');
    nocache_headers();

    $urls = [
        [
            'loc' => home_url('/calcolatori/'),
            'lastmod' => gmdate(DATE_W3C),
        ],
    ];

    foreach (lanotte_calcolatori_map() as $slug => $filename) {
        $file = LANOTTE_THEME_DIR . '/calcolatori/' . $filename;
        $urls[] = [
            'loc' => lanotte_calcolatore_url($slug),
            'lastmod' => is_readable($file) ? gmdate(DATE_W3C, filemtime($file)) : gmdate(DATE_W3C),
        ];
    }

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $url) {
        echo "\t<url>\n";
        echo "\t\t<loc>" . esc_url($url['loc']) . "</loc>\n";
        echo "\t\t<lastmod>" . esc_html($url['lastmod']) . "</lastmod>\n";
        echo "\t</url>\n";
    }
    echo "</urlset>\n";
    exit;
}, 0);

function lanotte_render_calcolatore($slug) {
    $slug = sanitize_title($slug);
    $map = lanotte_calcolatori_map();
    if (!isset($map[$slug])) {
        return '';
    }

    $file = LANOTTE_THEME_DIR . '/calcolatori/' . $map[$slug];
    if (!is_readable($file)) {
        return '';
    }

    $html = file_get_contents($file);
    $html = str_replace(
        ['../assets/', './assets/'],
        LANOTTE_THEME_URI . '/assets/',
        $html
    );

    if (preg_match('~</header>\s*(.*?)\s*<!-- FOOTER -->~is', $html, $match)) {
        $html = $match[1];
    } elseif (preg_match('~<body[^>]*>(.*?)</body>~is', $html, $match)) {
        $html = $match[1];
    }

    $data_status = '';
    if (preg_match('~<div\s+id=["\']dataStatus["\'][^>]*>.*?</div>~is', $html, $status_match)) {
        $data_status = $status_match[0];
    }

    // La pagina WordPress fornisce gia titolo, intro SEO e avvertenze.
    // Qui incorporiamo solo lo strumento, evitando doppio hero/H1.
    $html = preg_replace('~^\s*<section\b[^>]*>.*?</section>\s*~is', '', $html, 2);
    if ($data_status && strpos($html, 'id="dataStatus"') === false && strpos($html, "id='dataStatus'") === false) {
        $html = preg_replace('~(<div\s+class=["\']calc-block["\'])~i', $data_status . "\n\n" . '$1', $html, 1);
    }
    $html = lanotte_inline_calcolatore_theme_scripts($html);

    return '<div class="lanotte-calcolatore-embed" data-calcolatore="' . esc_attr($slug) . '">' . $html . '</div>';
}

add_shortcode('lanotte_calcolatore', function($atts) {
    $atts = shortcode_atts(['slug' => ''], $atts, 'lanotte_calcolatore');
    return lanotte_render_calcolatore($atts['slug']);
});

function lanotte_calcolatori_pages_data() {
    return [
        'interessi-legali' => [
            'title' => 'Calcolo interessi legali',
            'keyword' => 'calcolo interessi legali',
            'service' => 'Recupero crediti',
            'intro' => 'Il calcolatore degli interessi legali consente di stimare gli interessi maturati su un credito secondo il saggio legale previsto dall\'art. 1284 c.c., con suddivisione automatica per periodi e tassi annuali. E utile per recupero crediti, diffide, conteggi su somme dovute e verifiche preliminari prima di un atto giudiziale.',
            'faq' => [
                ['Quando si applicano gli interessi legali?', 'Di regola quando una somma di denaro e dovuta e non e previsto un diverso tasso convenzionale o speciale.'],
                ['Il calcolo prevede anatocismo?', 'No. Il calcolo e a capitalizzazione semplice, salvo diverse verifiche sul caso concreto.'],
                ['Serve un avvocato?', 'Per importi contestati, prescrizione, decorrenza della mora o atti giudiziali e opportuno far verificare il conteggio.'],
            ],
        ],
        'mantenimento-istat' => [
            'title' => 'Calcolo rivalutazione ISTAT assegno di mantenimento',
            'keyword' => 'calcolo rivalutazione ISTAT assegno mantenimento',
            'service' => 'Famiglia e separazioni',
            'intro' => 'Il calcolatore aggiorna l\'assegno di mantenimento secondo l\'indice ISTAT FOI, normalmente al 100% salvo diversa previsione nel provvedimento o nell\'accordo. Serve per verificare adeguamenti annuali, arretrati e differenze mensili dovute per coniuge o figli.',
            'faq' => [
                ['L\'adeguamento ISTAT e automatico?', 'Solo se previsto da sentenza, decreto omologato, accordo o negoziazione assistita.'],
                ['Si usa il 100% o il 75%?', 'Per il mantenimento si usa di regola il 100%, salvo clausola diversa.'],
                ['Posso chiedere arretrati?', 'Dipende dal titolo, dalla decorrenza e dalla prescrizione: il conteggio va verificato prima della richiesta.'],
            ],
        ],
        'svalutazione' => [
            'title' => 'Calcolo rivalutazione monetaria ISTAT',
            'keyword' => 'calcolo rivalutazione monetaria ISTAT',
            'service' => 'Recupero crediti e risarcimenti',
            'intro' => 'Lo strumento calcola la rivalutazione monetaria secondo indice ISTAT FOI e, se richiesto, gli interessi legali sul capitale via via rivalutato. E utile per crediti di valore, risarcimenti, conguagli e conteggi preliminari in sede stragiudiziale o giudiziale.',
            'faq' => [
                ['Che differenza c\'e tra interessi e rivalutazione?', 'Gli interessi remunerano il ritardo; la rivalutazione aggiorna il valore reale della somma nel tempo.'],
                ['Quando si sommano interessi e rivalutazione?', 'Nei crediti di valore, secondo criteri giurisprudenziali da verificare sul caso concreto.'],
                ['Il risultato e definitivo?', 'No, e un conteggio orientativo che va controllato con documenti, decorrenze e titolo del credito.'],
            ],
        ],
        'macropermanenti' => [
            'title' => 'Calcolo danno biologico tabelle Milano e TUN',
            'keyword' => 'calcolo danno biologico tabelle Milano',
            'service' => 'Infortunistica e risarcimento danni',
            'intro' => 'Il calcolatore stima il danno biologico per lesioni macropermanenti, confrontando Tabelle di Milano e Tabella Unica Nazionale quando applicabile. Il risultato dipende da invalidita permanente, eta, temporanea, personalizzazione e voci patrimoniali documentate.',
            'faq' => [
                ['Quando si usano le Tabelle di Milano?', 'Per molte liquidazioni del danno non patrimoniale, salvo ambiti con tabelle normative specifiche.'],
                ['Quando si usa la TUN?', 'Per le macrolesioni da circolazione nei casi in cui la Tabella Unica Nazionale e applicabile.'],
                ['Serve una perizia medico-legale?', 'Si. I punti di invalidita e le ricadute soggettive devono essere valutati da un medico-legale.'],
            ],
        ],
        'micropermanenti' => [
            'title' => 'Calcolo lesioni micropermanenti',
            'keyword' => 'calcolo micropermanenti',
            'service' => 'Infortunistica stradale',
            'intro' => 'Il calcolatore consente di stimare il risarcimento per lesioni di lieve entita, da 1 a 9 punti di invalidita permanente, secondo l\'art. 139 del Codice delle Assicurazioni e i valori aggiornati. Include danno permanente, temporaneo e voci patrimoniali inserite.',
            'faq' => [
                ['Cosa sono le micropermanenti?', 'Sono lesioni con invalidita permanente fino a 9 punti.'],
                ['Il danno morale e incluso?', 'Lo strumento e orientativo: eventuali personalizzazioni o ulteriori voci vanno valutate caso per caso.'],
                ['Il calcolo vale per ogni sinistro?', 'E pensato soprattutto per sinistri da circolazione, secondo l\'ambito dell\'art. 139 CdA.'],
            ],
        ],
        'danni-preesistenti' => [
            'title' => 'Calcolo danni preesistenti e menomazioni concorrenti',
            'keyword' => 'calcolo danno biologico preesistenze',
            'service' => 'Risarcimento danni',
            'intro' => 'Lo strumento aiuta a distinguere menomazioni coesistenti e concorrenti, applicando criteri di calcolo medico-legale e la sottrazione monetaria quando la preesistenza incide sul danno attuale. E utile nei casi di invalidita gia presente prima del sinistro.',
            'faq' => [
                ['Che cosa sono le menomazioni concorrenti?', 'Sono preesistenze che incidono sullo stesso organo o funzione danneggiata dal nuovo fatto.'],
                ['Basta sottrarre le percentuali?', 'No, spesso occorre sottrarre valori monetari e non semplici punti percentuali.'],
                ['Serve consulenza tecnica?', 'Si, per classificare correttamente la preesistenza e quantificare il danno risarcibile.'],
            ],
        ],
        'interessi-moratori' => [
            'title' => 'Calcolo interessi di mora',
            'keyword' => 'calcolo interessi di mora',
            'service' => 'Recupero crediti commerciali',
            'intro' => 'Il calcolatore stima gli interessi moratori nelle transazioni commerciali ai sensi del D.Lgs. 231/2002, applicando il tasso BCE maggiorato di otto punti. E pensato per fatture scadute tra imprese o verso pubbliche amministrazioni.',
            'faq' => [
                ['Vale per debiti tra privati?', 'No, per rapporti civili ordinari si usano di regola gli interessi legali.'],
                ['Da quando decorrono gli interessi moratori?', 'Di regola dal giorno successivo alla scadenza del pagamento, salvo casi particolari.'],
                ['Sono previste spese di recupero?', 'Il D.Lgs. 231/2002 prevede anche una somma forfettaria minima per costi di recupero.'],
            ],
        ],
        'istat-locazione' => [
            'title' => 'Calcolo aumento ISTAT canone di locazione',
            'keyword' => 'calcolo aumento ISTAT affitto',
            'service' => 'Locazioni',
            'intro' => 'Lo strumento calcola l\'aggiornamento ISTAT del canone di locazione secondo indice FOI e percentuale prevista dal contratto. Aiuta locatore e conduttore a verificare aumenti, decorrenze e importi mensili aggiornati.',
            'faq' => [
                ['L\'aumento ISTAT e sempre dovuto?', 'Serve una clausola contrattuale che lo preveda.'],
                ['Si applica il 75% o il 100%?', 'Dipende dal tipo di contratto e dalla clausola pattuita.'],
                ['Si possono chiedere arretrati?', 'Dipende da contratto, richiesta, decorrenza e prescrizione.'],
            ],
        ],
        'parcella-civile' => [
            'title' => 'Calcolo parcella avvocato civile',
            'keyword' => 'calcolo parcella avvocato civile',
            'service' => 'Onorari e preventivi',
            'intro' => 'Il calcolatore stima il compenso dell\'avvocato in materia civile secondo i parametri forensi, per scaglione, ufficio giudiziario e fasi dell\'attivita. Il risultato e orientativo e deve essere formalizzato in preventivo scritto.',
            'faq' => [
                ['Il calcolo coincide con il preventivo?', 'No, e una base orientativa da adattare a complessita, urgenza e attivita effettiva.'],
                ['Posso selezionare solo alcune fasi?', 'Si, lo strumento consente di includere o escludere le fasi svolte.'],
                ['IVA e CPA sono incluse?', 'Sono opzioni selezionabili nel calcolatore.'],
            ],
        ],
        'parcella-penale' => [
            'title' => 'Calcolo parcella avvocato penale',
            'keyword' => 'calcolo parcella avvocato penale',
            'service' => 'Difesa penale',
            'intro' => 'Il calcolatore stima i compensi del difensore penale secondo i parametri forensi, distinguendo ufficio, fase e tipologia di procedimento. Il valore finale richiede sempre valutazione professionale e preventivo.',
            'faq' => [
                ['Le fasi sono sempre tutte dovute?', 'No, dipende dall\'attivita effettivamente svolta nel procedimento.'],
                ['Il rito speciale cambia il compenso?', 'Puo incidere e va valutato nel caso concreto.'],
                ['Il calcolo include urgenze o trasferte?', 'No, eventuali voci ulteriori vanno inserite nel preventivo professionale.'],
            ],
        ],
        'stragiudiziale' => [
            'title' => 'Calcolo compenso stragiudiziale, mediazione e negoziazione assistita',
            'keyword' => 'calcolo compenso mediazione negoziazione assistita',
            'service' => 'Mediazione e trattative',
            'intro' => 'Lo strumento stima il compenso per attivita stragiudiziale, pareri, trattative, transazioni, mediazione e negoziazione assistita secondo i parametri forensi aggiornati. Per le procedure ADR considera fasi e maggiorazioni previste in caso di accordo.',
            'faq' => [
                ['Mediazione e negoziazione hanno parametri separati?', 'Si, le procedure ADR hanno una tabella specifica con fasi proprie.'],
                ['Cosa succede se si raggiunge un accordo?', 'Si considera la fase di conciliazione e la maggiorazione prevista sui compensi rilevanti.'],
                ['Il valore e vincolante?', 'No, e una stima da formalizzare in preventivo scritto.'],
            ],
        ],
        'sfratti' => [
            'title' => 'Calcolo compenso procedimento di sfratto',
            'keyword' => 'calcolo parcella sfratto',
            'service' => 'Locazioni e sfratti',
            'intro' => 'Il calcolatore stima il compenso per procedimenti di sfratto per morosita o finita locazione, distinguendo convalida, sanatoria, termine di grazia e opposizione. Serve per una prima valutazione dei costi professionali.',
            'faq' => [
                ['Lo sfratto ha parametri propri?', 'Si, i procedimenti speciali hanno criteri specifici nei parametri forensi.'],
                ['Cosa cambia se c\'e opposizione?', 'Il giudizio puo proseguire con attivita ulteriore e compensi diversi.'],
                ['Sono incluse tasse e contributo unificato?', 'No, il calcolo riguarda il compenso professionale salvo opzioni accessorie.'],
            ],
        ],
        'contributo-unificato' => [
            'title' => 'Calcolo contributo unificato',
            'keyword' => 'calcolo contributo unificato',
            'service' => 'Costi giudiziari',
            'intro' => 'Lo strumento calcola il contributo unificato civile in base a valore, tipo di procedimento e competenza. E utile per stimare le spese vive iniziali di una causa, un decreto ingiuntivo, un appello o un\'esecuzione.',
            'faq' => [
                ['Il contributo varia per valore?', 'Si, nel processo civile ordinario dipende dallo scaglione di valore della causa.'],
                ['Appello e Cassazione costano di piu?', 'Di regola sono previste maggiorazioni rispetto al primo grado.'],
                ['Sono previste esenzioni?', 'Si, alcune materie o condizioni possono comportare esenzione o riduzione.'],
            ],
        ],
        'scadenze' => [
            'title' => 'Calcolo scadenze processuali',
            'keyword' => 'calcolo scadenze processuali',
            'service' => 'Processo civile',
            'intro' => 'Il calcolatore aiuta a stimare termini processuali, giorni liberi, sospensione feriale e scadenze rilevanti. E uno strumento operativo utile, ma ogni termine va verificato sugli atti e sulla normativa applicabile.',
            'faq' => [
                ['La sospensione feriale si applica sempre?', 'No, alcune materie e procedimenti sono esclusi.'],
                ['Cosa sono i giorni liberi?', 'Sono termini in cui non si computano ne il giorno iniziale ne quello finale.'],
                ['Posso usare il risultato in giudizio?', 'Va sempre verificato dal difensore prima di depositi o notifiche.'],
            ],
        ],
        'opposizione-decreto-ingiuntivo' => [
            'title' => 'Calcolo termine opposizione decreto ingiuntivo',
            'keyword' => 'calcolo opposizione decreto ingiuntivo 40 giorni',
            'service' => 'Recupero crediti e opposizioni',
            'intro' => 'Il calcolatore stima la scadenza per proporre opposizione a decreto ingiuntivo partendo dalla data di notifica, con termine ordinario di quaranta giorni e opzioni per termini ridotti, aumentati o notifiche all\'estero. Include sospensione feriale e proroga al primo giorno non festivo quando applicabili.',
            'faq' => [
                ['Qual e il termine ordinario per opporsi?', 'Di regola il decreto ingiuntivo assegna quaranta giorni dalla notifica, salvo diversa indicazione del giudice.'],
                ['Il termine puo essere diverso?', 'Si, l\'art. 641 c.p.c. consente termini ridotti o aumentati e prevede regole specifiche per intimati residenti all\'estero.'],
                ['La sospensione feriale si applica sempre?', 'Va verificata in base alla materia e al rito: lo strumento consente di attivarla o disattivarla.'],
            ],
        ],
        'pignoramento-stipendio-pensione' => [
            'title' => 'Calcolo pignoramento stipendio e pensione',
            'keyword' => 'calcolo pignoramento stipendio pensione quinto pignorabile',
            'service' => 'Esecuzioni e recupero crediti',
            'intro' => 'Lo strumento stima la quota mensile pignorabile su stipendio o pensione distinguendo crediti ordinari, riscossione esattoriale e crediti alimentari. Per le pensioni considera la soglia impignorabile prevista dall\'art. 545 c.p.c., pari al doppio dell\'assegno sociale con minimo di mille euro.',
            'faq' => [
                ['Quanto si puo pignorare sullo stipendio?', 'Per crediti ordinari la quota tipica e un quinto del netto, salvi concorsi, alimenti e discipline speciali.'],
                ['La pensione ha una soglia protetta?', 'Si, resta impignorabile l\'importo pari al doppio dell\'assegno sociale, con minimo di 1.000 euro mensili.'],
                ['I debiti fiscali seguono gli stessi limiti?', 'Per la riscossione esattoriale si applicano soglie speciali: un decimo, un settimo o un quinto in base all\'importo.'],
            ],
        ],
        'prescrizione-crediti' => [
            'title' => 'Calcolo prescrizione crediti',
            'keyword' => 'calcolo prescrizione crediti',
            'service' => 'Recupero crediti e contestazioni',
            'intro' => 'Il calcolatore stima la data di prescrizione di alcune categorie ricorrenti di credito, distinguendo termine ordinario decennale, prescrizioni quinquennali, triennali e biennali. Consente di indicare un eventuale ultimo atto interruttivo e di verificare se il termine risulta ancora pendente o gia decorso.',
            'faq' => [
                ['La prescrizione e sempre di dieci anni?', 'No, il termine ordinario decennale vale salvo prescrizioni brevi previste dalla legge.'],
                ['Una diffida interrompe la prescrizione?', 'Puo interromperla se contiene una richiesta idonea e viene provata ricezione e contenuto.'],
                ['Il calcolatore decide se il credito e prescritto?', 'No, serve una verifica su titolo, decorrenza, atti interruttivi, riconoscimenti di debito e giudizi pendenti.'],
            ],
        ],
        'spese-straordinarie-figli' => [
            'title' => 'Calcolo riparto spese straordinarie figli',
            'keyword' => 'calcolo spese straordinarie figli separazione',
            'service' => 'Famiglia e separazioni',
            'intro' => 'Lo strumento ripartisce le spese straordinarie per i figli secondo la percentuale prevista da accordo, sentenza o decreto, calcolando quota di ciascun genitore, rimborso dovuto e promemoria documentale. E utile per spese mediche, scolastiche, sportive e altre voci non ordinarie.',
            'faq' => [
                ['La percentuale e sempre 50 e 50?', 'No, conta il provvedimento o l\'accordo: il calcolatore consente anche riparti 70/30, 100/0 o personalizzati.'],
                ['Serve autorizzazione preventiva?', 'Dipende dalla voce di spesa e dal provvedimento; molte spese non urgenti richiedono confronto preventivo.'],
                ['Posso chiedere il rimborso senza documenti?', 'Di regola occorrono ricevute, fatture, prova del pagamento e comunicazione all\'altro genitore.'],
            ],
        ],
        'aqp' => [
            'title' => 'Calcolo e verifica bolletta AQP',
            'keyword' => 'contestazione bolletta AQP',
            'service' => 'Utenze e consumatori',
            'intro' => 'Lo strumento aiuta a verificare importi anomali in bolletta AQP, consumi, perdite occulte e possibili profili di reclamo. Serve per preparare una prima contestazione documentata prima dell\'eventuale assistenza legale.',
            'faq' => [
                ['Quando conviene contestare la bolletta?', 'Quando vi sono consumi anomali, errori di lettura, conguagli non chiari o perdite occulte.'],
                ['Serve prima un reclamo?', 'Di regola e opportuno inviare reclamo scritto al gestore.'],
                ['Il calcolatore decide la controversia?', 'No, aiuta a ordinare i dati e stimare le contestazioni.'],
            ],
        ],
        'timeline-marchio' => [
            'title' => 'Calcolo tempi deposito marchio',
            'keyword' => 'tempi registrazione marchio',
            'service' => 'Marchi e proprieta intellettuale',
            'intro' => 'Il calcolatore ricostruisce una timeline indicativa per deposito, pubblicazione, opposizione e registrazione di un marchio UIBM o EUIPO. Aiuta imprese e professionisti a programmare il lancio del segno distintivo.',
            'faq' => [
                ['Il marchio e protetto subito?', 'La tutela piena dipende dalla procedura e dall\'esito della domanda, ferma la data di deposito.'],
                ['Quanto dura il periodo di opposizione?', 'Dipende dalla procedura nazionale o europea applicabile.'],
                ['Serve una ricerca di anteriorita?', 'Si, e consigliabile prima del deposito per ridurre rischi di opposizione.'],
            ],
        ],
    ];
}

function lanotte_current_calcolatore_data() {
    if (!is_page()) return null;
    $post = get_post();
    if (!$post instanceof WP_Post) return null;

    $parent = $post->post_parent ? get_post($post->post_parent) : null;
    if (!$parent instanceof WP_Post || $parent->post_name !== 'calcolatori') return null;

    $data = lanotte_calcolatori_pages_data();
    return $data[$post->post_name] ?? null;
}

function lanotte_calcolatore_page_content($slug, array $data) {
    $faq = '';
    foreach ($data['faq'] as $item) {
        $faq .= '<details><summary>' . esc_html($item[0]) . '</summary><p>' . esc_html($item[1]) . '</p></details>';
    }

    return '<section class="lanotte-calc-seo-intro"><p>' . esc_html($data['intro']) . '</p>'
        . '<p>Per usare correttamente lo strumento inserisci i dati richiesti, controlla il risultato e scarica o stampa il report solo dopo aver verificato l\'anteprima. Il calcolo e pensato per una prima valutazione operativa, utile prima di una diffida, di una trattativa, di un ricorso o di una richiesta di preventivo.</p>'
        . '<p>Quando il conteggio incide su diritti, prescrizioni, termini processuali, risarcimenti o somme contestate, e opportuno farlo verificare da un avvocato. Lo Studio puo controllare documenti, decorrenze, titolo del credito o provvedimento giudiziale e trasformare il risultato in una richiesta formale.</p>'
        . '<p><strong>Query principale:</strong> ' . esc_html($data['keyword']) . '. <strong>Servizio collegato:</strong> ' . esc_html($data['service']) . '.</p></section>'
        . '[lanotte_calcolatore slug="' . esc_attr($slug) . '"]'
        . '<section class="lanotte-calc-seo-faq"><h2>Domande frequenti</h2>' . $faq . '<p><em>Strumento indicativo: non sostituisce la consulenza legale e va verificato sul caso concreto.</em></p><p><a class="btn btn-primary" href="' . esc_url(home_url('/contatti/')) . '">Richiedi una verifica dello Studio</a></p></section>';
}

add_action('init', function() {
    if (get_option('lanotte_calcolatori_pages_version') === LANOTTE_THEME_VERSION) return;
    if (!function_exists('wp_insert_post')) return;

    $parent = get_page_by_path('calcolatori');
    if (!$parent) return;

    foreach (lanotte_calcolatori_pages_data() as $slug => $data) {
        if (!isset(lanotte_calcolatori_map()[$slug])) continue;

        $page = get_page_by_path('calcolatori/' . $slug, OBJECT, 'page');
        $postarr = [
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_parent'  => (int) $parent->ID,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => lanotte_calcolatore_page_content($slug, $data),
        ];

        if ($page) {
            $postarr['ID'] = (int) $page->ID;
            wp_update_post($postarr);
            $post_id = (int) $page->ID;
        } else {
            $post_id = wp_insert_post($postarr);
        }

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_aioseo_title', $data['title'] . ' | Studio Legale Lanotte');
            update_post_meta($post_id, '_aioseo_description', wp_trim_words($data['intro'], 28, '...'));
        }
    }

    update_option('lanotte_calcolatori_pages_version', LANOTTE_THEME_VERSION, false);
}, 30);

function lanotte_area_calcolatori_links($slug) {
    $groups = [
        'diritto-civile' => [
            'interessi-legali' => 'Calcolo interessi legali',
            'interessi-moratori' => 'Calcolo interessi di mora',
            'svalutazione' => 'Rivalutazione monetaria ISTAT',
            'contributo-unificato' => 'Contributo unificato',
            'prescrizione-crediti' => 'Prescrizione crediti',
            'opposizione-decreto-ingiuntivo' => 'Opposizione decreto ingiuntivo',
        ],
        'impresa' => [
            'interessi-moratori' => 'Interessi moratori B2B',
            'interessi-legali' => 'Interessi legali',
            'svalutazione' => 'Rivalutazione monetaria',
            'prescrizione-crediti' => 'Prescrizione crediti',
            'opposizione-decreto-ingiuntivo' => 'Opposizione decreto ingiuntivo',
        ],
        'famiglia-successioni' => [
            'mantenimento-istat' => 'Rivalutazione ISTAT mantenimento',
            'spese-straordinarie-figli' => 'Spese straordinarie figli',
            'stragiudiziale' => 'Mediazione e negoziazione assistita',
            'scadenze' => 'Scadenze processuali',
        ],
        'infortunistica-malasanita' => [
            'micropermanenti' => 'Lesioni micropermanenti',
            'macropermanenti' => 'Danno biologico Tabelle Milano e TUN',
            'danni-preesistenti' => 'Danni preesistenti e concorrenti',
        ],
        'condominio' => [
            'stragiudiziale' => 'Mediazione civile',
            'interessi-legali' => 'Interessi legali',
            'contributo-unificato' => 'Contributo unificato',
        ],
        'bancario' => [
            'interessi-legali' => 'Interessi legali',
            'interessi-moratori' => 'Interessi di mora',
            'svalutazione' => 'Rivalutazione monetaria',
            'pignoramento-stipendio-pensione' => 'Pignoramento stipendio e pensione',
            'prescrizione-crediti' => 'Prescrizione crediti',
        ],
        'lavoro' => [
            'pignoramento-stipendio-pensione' => 'Pignoramento stipendio',
            'prescrizione-crediti' => 'Prescrizione crediti',
        ],
        'previdenza' => [
            'pignoramento-stipendio-pensione' => 'Pignoramento pensione',
        ],
        'proprieta-intellettuale' => [
            'timeline-marchio' => 'Timeline deposito marchio',
            'scadenze' => 'Scadenze processuali',
        ],
    ];

    return $groups[$slug] ?? [];
}

add_filter('the_content', function($content) {
    if (!is_singular('area') || !in_the_loop() || !is_main_query()) return $content;

    $post = get_post();
    if (!$post instanceof WP_Post) return $content;

    $links = lanotte_area_calcolatori_links($post->post_name);
    if (!$links) return $content;

    $html = '<section class="lanotte-area-tools"><h2>Strumenti utili collegati</h2><p>Calcolatori gratuiti per una prima verifica orientativa del caso.</p><div class="lanotte-area-tools-grid">';
    foreach ($links as $slug => $label) {
        $html .= '<a href="' . esc_url(lanotte_calcolatore_url($slug)) . '">' . esc_html($label) . '</a>';
    }
    $html .= '</div></section>';

    return $content . $html;
}, 18);

add_action('template_redirect', function() {
    $request = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = $request ? wp_parse_url($request, PHP_URL_PATH) : '';
    if (!$path || strpos($path, '/calcolatori/') === false || substr($path, -5) !== '.html') return;

    $slug = sanitize_title(basename($path, '.html'));
    if (isset(lanotte_calcolatori_map()[$slug])) {
        wp_safe_redirect(lanotte_calcolatore_url($slug), 301);
        exit;
    }
}, 1);

add_action('init', function() {
    $key = 'lanotte_calcolatori_rewrite_version';
    if (get_option($key) === LANOTTE_THEME_VERSION) return;
    flush_rewrite_rules(false);
    update_option($key, LANOTTE_THEME_VERSION, false);
}, 20);

add_filter('robots_txt', function($output, $public) {
    $sitemap = 'Sitemap: ' . home_url('/lanotte-calcolatori.xml');
    if (strpos($output, $sitemap) === false) {
        $output = rtrim($output) . "\n" . $sitemap . "\n";
    }
    return $output;
}, 10, 2);
