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
        'imposta-successione'  => 'imposta-successione.html',
        'quote-ereditarie'     => 'quote-ereditarie.html',
        'usufrutto-nuda-proprieta' => 'usufrutto-nuda-proprieta.html',
        'interessi-legali'     => 'interessi-legali.html',
        'interessi-moratori'   => 'interessi-moratori.html',
        'istat-locazione'      => 'istat-locazione.html',
        'macropermanenti'      => 'macropermanenti.html',
        'mantenimento-orientativo' => 'mantenimento-orientativo.html',
        'mantenimento-istat'   => 'mantenimento-istat.html',
        'micropermanenti'      => 'micropermanenti.html',
        'inail'                => 'inail.html',
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
        'costi-marchio'        => 'costi-marchio.html',
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

    // I div di stato (dataStatus/istatStatus) vivono nelle prime <section> del
    // file, che sotto vengono rimosse: vanno estratti prima e re-iniettati poi,
    // altrimenti lo startup JS crasha su null e il calcolatore resta muto.
    $status_divs = [];
    foreach (['dataStatus', 'istatStatus'] as $status_id) {
        if (preg_match('~<div\s+id=["\']' . $status_id . '["\'][^>]*>.*?</div>~is', $html, $status_match)) {
            $status_divs[$status_id] = $status_match[0];
        }
    }

    // La pagina WordPress fornisce gia titolo e introduzione SEO.
    // Alcuni calcolatori includono stili prima del hero: rimuoviamo quindi
    // hero e disclaimer per marcatori, evitando H1 e testi duplicati.
    $hero_removed = 0;
    $html = preg_replace(
        '~<section\b[^>]*class=["\'][^"\']*\bhero-internal\b[^"\']*["\'][^>]*>.*?</section>\s*~is',
        '',
        $html,
        1,
        $hero_removed
    );
    if ($hero_removed) {
        $html = preg_replace(
            '~\s*<!--\s*DISCLAIMER ESTESO\s*-->\s*<section\b[^>]*>.*?</section>\s*~is',
            '',
            $html,
            1
        );
    } else {
        $html = preg_replace('~^\s*<section\b[^>]*>.*?</section>\s*~is', '', $html, 2);
    }
    foreach ($status_divs as $status_id => $status_div) {
        if (strpos($html, 'id="' . $status_id . '"') !== false || strpos($html, "id='" . $status_id . "'") !== false) continue;
        $count = 0;
        $html = preg_replace('~(<div\s+class=["\']calc-block["\'])~i', $status_div . "\n\n" . '$1', $html, 1, $count);
        if (!$count) $html = $status_div . "\n\n" . $html;
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
            'title' => 'Calcolo interessi legali 2026 – art. 1284 c.c. (gratuito)',
            'keyword' => 'calcolo interessi legali',
            'service' => 'Recupero crediti',
            'intro' => 'Il calcolatore degli interessi legali consente di stimare gli interessi maturati su un credito secondo il saggio legale previsto dall\'art. 1284 c.c., con suddivisione automatica per periodi e tassi annuali. È utile per recupero crediti, diffide, conteggi su somme dovute e verifiche preliminari prima di un atto giudiziale.',
            'faq' => [
                ['Quando si applicano gli interessi legali?', 'Di regola quando una somma di denaro è dovuta e non è previsto un diverso tasso convenzionale o speciale.'],
                ['Il calcolo prevede anatocismo?', 'No. Il calcolo è a capitalizzazione semplice, salvo diverse verifiche sul caso concreto.'],
                ['Serve un avvocato?', 'Per importi contestati, prescrizione, decorrenza della mora o atti giudiziali è opportuno far verificare il conteggio.'],
            ],
        ],
        'imposta-successione' => [
            'title' => 'Calcolo imposta di successione 2026 (gratuito)',
            'keyword' => 'calcolo imposta di successione',
            'service' => 'Successioni ed eredità in tutta Italia',
            'intro' => 'Il calcolatore completo stima l\'imposta di successione per singolo beneficiario partendo da attivo, passività, quota, rapporto di parentela, immobili, donazioni pregresse e agevolazione prima casa. Applica in via informativa aliquote e franchigie vigenti e segnala i casi particolari che richiedono verifica professionale secondo il D.Lgs. 346/1990 e il D.Lgs. 139/2024.',
            'faq' => [
                ['La franchigia vale per ogni erede?', 'Sì. La franchigia si applica alla quota di ciascun beneficiario: 1.000.000 di euro per coniuge e linea retta, 100.000 per fratelli e sorelle, 1.500.000 per beneficiari con disabilità grave (L. 104/1992).'],
                ['Con i benefici prima casa cosa cambia?', 'Le imposte ipotecaria e catastale si pagano in misura fissa di 200 euro ciascuna, invece del 2% e dell\'1% sul valore catastale degli immobili.'],
                ['Chi calcola e versa l\'imposta?', 'Dal 2025 l\'imposta è in autoliquidazione: si versa sulla base della dichiarazione, da presentare entro dodici mesi, salvo controlli dell\'Agenzia delle Entrate.'],
            ],
        ],
        'quote-ereditarie' => [
            'title' => 'Calcolo quote ereditarie e quota di legittima 2026 (gratuito)',
            'keyword' => 'calcolo quote ereditarie',
            'service' => 'Successioni ed eredità in tutta Italia',
            'intro' => 'Il calcolatore indica chi eredita e in quale quota quando non c\'è testamento (successione legittima, artt. 565-586 c.c.) e quanto spetta comunque a coniuge, figli e ascendenti se c\'è un testamento (quota di legittima, artt. 536-548 c.c.). Considera la parte dell\'unione civile, la rappresentazione dei discendenti, i fratelli unilaterali e, se indicati, beni, debiti e donazioni.',
            'faq' => [
                ['Chi eredita se non c\'è testamento?', 'Il coniuge o la parte dell\'unione civile, i figli e i loro discendenti; in mancanza di figli, genitori e altri ascendenti, fratelli e sorelle; poi gli altri parenti fino al sesto grado e infine lo Stato (artt. 565-586 c.c.).'],
                ['Quanto spetta di legittima ai figli?', 'Un figlio solo ha diritto alla metà del patrimonio, più figli insieme ai due terzi (art. 537 c.c.). Con il coniuge: un figlio e il coniuge un terzo ciascuno; con più figli, ai figli la metà e al coniuge un quarto (art. 542 c.c.).'],
                ['I fratelli hanno diritto alla legittima?', 'No. Fratelli e sorelle ereditano solo senza testamento e in mancanza di figli: i legittimari sono il coniuge, i figli e, in mancanza di figli, gli ascendenti (artt. 536 e 538 c.c.).'],
            ],
        ],
        'usufrutto-nuda-proprieta' => [
            'title' => 'Calcolo usufrutto e nuda proprietà 2026 – coefficienti in vigore (gratuito)',
            'keyword' => 'calcolo usufrutto',
            'service' => 'Successioni ed eredità in tutta Italia',
            'intro' => 'Il calcolatore determina il valore fiscale dell\'usufrutto vitalizio, dell\'uso o dell\'abitazione e della nuda proprietà in base all\'età del titolare, con il prospetto dei coefficienti previsto per l\'imposta di registro e per l\'imposta di successione e donazione. Considera anche il diritto intestato a due persone, con o senza accrescimento.',
            'faq' => [
                ['Il tasso legale del 2026 cambia il valore dell\'usufrutto?', 'No. Il tasso legale 2026 è dell\'1,6%, ma ai fini dell\'imposta di registro e dell\'imposta di successione e donazione non si può assumere un saggio inferiore al 2,5% (art. 46, comma 5-ter, d.P.R. 131/1986; art. 17, comma 1-ter, d.lgs. 346/1990): restano quindi i coefficienti calcolati al 2,5%.'],
                ['Come si calcola la nuda proprietà?', 'È la differenza tra il valore della piena proprietà e quello dell\'usufrutto, che si ottiene moltiplicando il valore della piena proprietà per il 2,5% e per il coefficiente della fascia di età dell\'usufruttuario (art. 48 d.P.R. 131/1986).'],
                ['E se gli usufruttuari sono due?', 'Si considera l\'età del più giovane se l\'usufrutto passa al superstite (accrescimento), quella del meno giovane se cessa alla morte di uno qualsiasi dei due (art. 46, terzo comma, d.P.R. 131/1986).'],
            ],
        ],
        'mantenimento-istat' => [
            'title' => 'Calcolo rivalutazione ISTAT assegno di mantenimento 2026 (gratuito)',
            'keyword' => 'calcolo rivalutazione ISTAT assegno mantenimento',
            'service' => 'Famiglia e separazioni',
            'intro' => 'Rivalutazione, adeguamento e aggiornamento ISTAT dell\'assegno di mantenimento per coniuge e figli: il calcolatore gratuito applica gli indici FOI ufficiali e quantifica differenze mensili e arretrati maturati. Il calcolatore aggiorna l\'assegno di mantenimento secondo l\'indice ISTAT FOI, normalmente al 100% salvo diversa previsione nel provvedimento o nell\'accordo. Serve per verificare adeguamenti annuali, arretrati e differenze mensili dovute per coniuge o figli.',
            'faq' => [
                ['L\'adeguamento ISTAT è automatico?', 'Per i figli sì: l\'assegno è adeguato automaticamente agli indici ISTAT, salvo un diverso parametro indicato dalle parti o dal giudice (art. 337-ter c.c.). Per il coniuge divorziato la sentenza deve fissare un criterio di adeguamento (art. 5, comma 7, L. 898/1970); per il coniuge separato conta quanto previsto dal provvedimento o dall\'accordo.'],
                ['Si usa il 100% o il 75%?', 'Per il mantenimento si usa di regola il 100%, salvo clausola diversa.'],
                ['Posso chiedere arretrati?', 'Dipende dal titolo, dalla decorrenza e dalla prescrizione: il conteggio va verificato prima della richiesta.'],
            ],
        ],
        'mantenimento-orientativo' => [
            'title' => 'Calcolo orientativo assegno di mantenimento figli 2026 (gratuito)',
            'keyword' => 'calcolo assegno di mantenimento figli',
            'service' => 'Famiglia e separazioni',
            'intro' => 'Lo strumento elabora una forchetta puramente orientativa considerando redditi, fabbisogno indicato, tempi di permanenza e spese dirette. Non esiste una formula vincolante: l\'assegno e determinato dal giudice o concordato dalle parti secondo i criteri dell\'art. 337-ter c.c.',
            'faq' => [
                ['Il risultato determina l\'assegno dovuto?', 'No. È una simulazione matematica informativa e non anticipa la decisione del giudice.'],
                ['Comprende le spese straordinarie?', 'No. Le spese straordinarie devono essere disciplinate e ripartite separatamente.'],
                ['Quali elementi vanno verificati?', 'Redditi effettivi, patrimonio, esigenze dei figli, casa familiare, tempi di cura e circostanze concrete.'],
            ],
        ],
        'svalutazione' => [
            'title' => 'Calcolo rivalutazione monetaria ISTAT e interessi 2026 (gratuito)',
            'keyword' => 'calcolo rivalutazione monetaria ISTAT',
            'service' => 'Recupero crediti e risarcimenti',
            'intro' => 'Lo strumento calcola la rivalutazione monetaria secondo indice ISTAT FOI e, se richiesto, gli interessi legali sul capitale via via rivalutato. È utile per crediti di valore, risarcimenti, conguagli e conteggi preliminari in sede stragiudiziale o giudiziale.',
            'faq' => [
                ['Che differenza c\'e tra interessi e rivalutazione?', 'Gli interessi remunerano il ritardo; la rivalutazione aggiorna il valore reale della somma nel tempo.'],
                ['Quando si sommano interessi e rivalutazione?', 'Nei crediti di valore, con interessi sul capitale via via rivalutato (Cass. SU 1712/1995); nei crediti di lavoro l\'art. 429, comma 3, c.p.c. prevede interessi legali e rivalutazione dalla maturazione del diritto.'],
                ['Il risultato è definitivo?', 'No, è un conteggio orientativo che va controllato con documenti, decorrenze e titolo del credito.'],
            ],
        ],
        'macropermanenti' => [
            'title' => 'Calcolo danno biologico macropermanenti 2026 – Tabelle Milano e TUN (gratuito)',
            'keyword' => 'calcolo danno biologico tabelle Milano',
            'service' => 'Infortunistica e risarcimento danni',
            'intro' => 'Calcolatore gratuito del danno biologico per lesioni macropermanenti, da 10 a 100 punti, secondo la Tabella Unica Nazionale, con le Tabelle di Milano 2024 a confronto: inserendo età, punti di invalidità e giorni di inabilità si ottiene subito la stima. Il calcolatore fornisce una stima online del risarcimento del danno biologico per lesioni macropermanenti da 10 a 100 punti. Lo strumento usa la Tabella Unica Nazionale prevista dal D.P.R. 12/2025, direttamente per i sinistri stradali e la responsabilità sanitaria successivi al 5 marzo 2025 e come parametro equitativo negli altri casi (Cass. civ., sez. III, 7 aprile 2026, n. 8630). Inserendo punti di invalidità permanente, età e giorni di inabilità temporanea si ottiene subito il dettaglio del danno permanente, temporaneo e della sofferenza soggettiva media. Le opzioni avanzate permettono inoltre di simulare personalizzazione, spese documentate e perdita di reddito. Il calcolo è gratuito, resta sul dispositivo e può essere controllato in anteprima prima di stampare o salvare il report. La quantificazione definitiva richiede sempre una perizia medico-legale e la verifica giuridica del caso concreto.',
            'faq' => [
                ['Quando si usa la Tabella Unica Nazionale?', 'Si applica direttamente alle lesioni da 10 a 100 punti derivanti da circolazione di veicoli o responsabilità sanitaria, per i sinistri successivi al 5 marzo 2025 (D.P.R. 12/2025). Negli altri casi, compresi i sinistri anteriori e gli altri illeciti, la Cassazione la indica come parametro della liquidazione equitativa, da cui il giudice può discostarsi solo motivando su circostanze peculiari (Cass. civ., sez. III, 7 aprile 2026, n. 8630).'],
                ['A che cosa servono le Tabelle di Milano?', 'Nel calcolatore sono un termine di confronto. Dopo la sentenza n. 8630/2026 il riferimento per le macropermanenti è la TUN anche fuori dal suo ambito diretto; le Tabelle di Milano possono restare utili per voci che la TUN non disciplina.'],
                ['Dove trovo i punti di invalidità e i giorni di inabilità?', 'Sono normalmente indicati nella relazione medico-legale. Se non sono ancora stati valutati, il calcolo può essere soltanto una simulazione.'],
                ['La personalizzazione aumenta sempre il risarcimento?', 'No. Deve dipendere da conseguenze specifiche del caso, essere allegata e provata; non è una maggiorazione automatica.'],
                ['Serve una perizia medico-legale?', 'Sì. I punti di invalidità, i giorni di inabilità e le ricadute concrete devono essere valutati da un medico-legale.'],
            ],
        ],
        'micropermanenti' => [
            'title' => 'Calcolo danno biologico micropermanenti 2026 – lesioni da 1 a 9 punti (gratuito)',
            'keyword' => 'calcolo micropermanenti',
            'service' => 'Infortunistica stradale',
            'intro' => 'Calcolatore gratuito del danno biologico per lesioni micropermanenti, da 1 a 9 punti di invalidità permanente, secondo l\'art. 139 del Codice delle Assicurazioni e i valori aggiornati: inserendo età e punti si ottiene la stima del danno permanente, del danno temporaneo e delle voci patrimoniali indicate.',
            'faq' => [
                ['Cosa sono le micropermanenti?', 'Sono lesioni con invalidità permanente fino a 9 punti.'],
                ['Il danno morale è incluso?', 'L\'art. 139 del Codice delle assicurazioni non prevede una voce separata per il danno morale: l\'importo è esaustivo del danno non patrimoniale conseguente alle lesioni (art. 139, comma 3). Se la menomazione incide in modo rilevante su specifici aspetti dinamico-relazionali documentati, o causa una sofferenza psico-fisica di particolare intensità, il giudice può aumentarlo fino al 20%, con motivazione; l\'aumento va allegato e provato.'],
                ['Il calcolo vale per ogni sinistro?', 'È pensato per i sinistri da circolazione di veicoli e natanti (art. 139 CdA) e per la responsabilità sanitaria, che rinvia agli stessi valori (art. 7, comma 4, L. 24/2017).'],
            ],
        ],
        'inail' => [
            'title' => 'Calcolo indennizzo INAIL 2026: verifica orientativa (gratuito)',
            'keyword' => 'calcolo indennizzo INAIL',
            'service' => 'Infortuni sul lavoro e malattie professionali',
            'intro' => 'Lo strumento identifica la prestazione INAIL potenzialmente applicabile: nessun indennizzo permanente sotto il 6%, capitale dal 6% al 15% e rendita dal 16%. Il regime INAIL è distinto dal risarcimento civilistico e la quantificazione definitiva compete all\'Istituto.',
            'faq' => [
                ['Quando spetta il capitale?', 'Per menomazioni riconosciute da INAIL comprese tra il 6% e il 15%.'],
                ['Quando spetta la rendita?', 'Dal 16% al 100%, con quota biologica ed eventuale quota patrimoniale.'],
                ['E uguale al risarcimento civile?', 'No. Sono sistemi diversi e il danno differenziale richiede una valutazione separata.'],
            ],
        ],
        'danni-preesistenti' => [
            'title' => 'Calcolo danni preesistenti e menomazioni concorrenti 2026 (gratuito)',
            'keyword' => 'calcolo danno biologico preesistenze',
            'service' => 'Risarcimento danni',
            'intro' => 'Lo strumento aiuta a distinguere menomazioni coesistenti e concorrenti, applicando criteri di calcolo medico-legale e la sottrazione monetaria quando la preesistenza incide sul danno attuale. È utile nei casi di invalidità già presente prima del sinistro.',
            'faq' => [
                ['Che cosa sono le menomazioni concorrenti?', 'Sono menomazioni i cui effetti invalidanti risultano più gravi se associate ad altre, anche se riguardano organi diversi (Cass. civ., sez. III, 11 novembre 2019, n. 28986).'],
                ['Basta sottrarre le percentuali?', 'No, spesso occorre sottrarre valori monetari e non semplici punti percentuali.'],
                ['Serve consulenza tecnica?', 'Sì, per classificare correttamente la preesistenza e quantificare il danno risarcibile.'],
            ],
        ],
        'interessi-moratori' => [
            'title' => 'Calcolo interessi moratori 2026 – interessi di mora D.Lgs. 231/2002 (gratuito)',
            'keyword' => 'calcolo interessi di mora',
            'service' => 'Recupero crediti commerciali',
            'intro' => 'Calcolatore gratuito degli interessi moratori (interessi di mora) sulle fatture pagate in ritardo, ai sensi del D.Lgs. 231/2002: tasso BCE maggiorato di otto punti, aggiornato semestralmente dal MEF e applicato periodo per periodo. Vale per le transazioni commerciali tra imprese e verso la Pubblica Amministrazione; per le cessioni di prodotti agricoli e alimentari soggette al d.lgs. 198/2021 il saggio è maggiorato di ulteriori quattro punti.',
            'faq' => [
                ['Vale per debiti tra privati?', 'No, per rapporti civili ordinari si usano di regola gli interessi legali.'],
                ['Da quando decorrono gli interessi moratori?', 'Di regola dal giorno successivo alla scadenza del pagamento, salvo casi particolari.'],
                ['Sono previste spese di recupero?', 'Il D.Lgs. 231/2002 prevede anche una somma forfettaria minima per costi di recupero.'],
            ],
        ],
        'istat-locazione' => [
            'title' => 'Calcolo aumento ISTAT canone di locazione 2026 (gratuito)',
            'keyword' => 'calcolo aumento ISTAT affitto',
            'service' => 'Locazioni',
            'intro' => 'Lo strumento calcola l\'aggiornamento ISTAT del canone di locazione secondo indice FOI e percentuale prevista dal contratto. Aiuta locatore e conduttore a verificare aumenti, decorrenze e importi mensili aggiornati.',
            'faq' => [
                ['L\'aumento ISTAT è sempre dovuto?', 'Serve una clausola contrattuale che lo preveda.'],
                ['Si applica il 75% o il 100%?', 'Dipende dal tipo di contratto e dalla clausola pattuita.'],
                ['Si possono chiedere arretrati?', 'Dipende da contratto, richiesta, decorrenza e prescrizione.'],
            ],
        ],
        'parcella-civile' => [
            'title' => 'Calcolo parcella avvocato civile 2026 (gratuito)',
            'keyword' => 'calcolo parcella avvocato civile',
            'service' => 'Onorari e preventivi',
            'intro' => 'Calcolatore gratuito della parcella dell\'avvocato civile secondo i parametri forensi (DM 55/2014 e aggiornamenti): scaglione di valore, ufficio giudiziario e fasi dell\'attività, con il compenso tabellare di ogni fase. Il risultato è orientativo e va formalizzato in un preventivo scritto, come previsto dall\'art. 13 della legge 247/2012.',
            'faq' => [
                ['Il calcolo coincide con il preventivo?', 'No, è una base orientativa da adattare a complessità, urgenza e attività effettiva.'],
                ['Posso selezionare solo alcune fasi?', 'Sì, lo strumento consente di includere o escludere le fasi svolte.'],
                ['IVA e CPA sono incluse?', 'Sono opzioni selezionabili nel calcolatore.'],
            ],
        ],
        'parcella-penale' => [
            'title' => 'Calcolo parcella avvocato penale 2026 (gratuito)',
            'keyword' => 'calcolo parcella avvocato penale',
            'service' => 'Difesa penale',
            'intro' => 'Il calcolatore stima i compensi del difensore penale secondo i parametri forensi, distinguendo ufficio, fase e tipologia di procedimento. Il valore finale richiede sempre valutazione professionale e preventivo.',
            'faq' => [
                ['Le fasi sono sempre tutte dovute?', 'No, dipende dall\'attività effettivamente svolta nel procedimento.'],
                ['Il rito speciale cambia il compenso?', 'Può incidere e va valutato nel caso concreto.'],
                ['Il calcolo include urgenze o trasferte?', 'No, eventuali voci ulteriori vanno inserite nel preventivo professionale.'],
            ],
        ],
        'stragiudiziale' => [
            'title' => 'Calcolo compenso stragiudiziale e mediazione 2026 (gratuito)',
            'keyword' => 'calcolo compenso mediazione negoziazione assistita',
            'service' => 'Mediazione e trattative',
            'intro' => 'Lo strumento stima il compenso per attività stragiudiziale, pareri, trattative, transazioni, mediazione e negoziazione assistita secondo i parametri forensi aggiornati. Per le procedure ADR considera fasi e maggiorazioni previste in caso di accordo.',
            'faq' => [
                ['Mediazione e negoziazione hanno parametri separati?', 'Sì, le procedure ADR hanno una tabella specifica con fasi proprie.'],
                ['Cosa succede se si raggiunge un accordo?', 'Si considera la fase di conciliazione e la maggiorazione prevista sui compensi rilevanti.'],
                ['Il valore è vincolante?', 'No, è una stima da formalizzare in preventivo scritto.'],
            ],
        ],
        'sfratti' => [
            'title' => 'Calcolo compenso procedimento di sfratto 2026 (gratuito)',
            'keyword' => 'calcolo parcella sfratto',
            'service' => 'Locazioni e sfratti',
            'intro' => 'Il calcolatore stima il compenso per procedimenti di sfratto per morosità o finita locazione, distinguendo convalida, sanatoria, termine di grazia e opposizione. Serve per una prima valutazione dei costi professionali.',
            'faq' => [
                ['Lo sfratto ha parametri propri?', 'Sì, i procedimenti speciali hanno criteri specifici nei parametri forensi.'],
                ['Cosa cambia se c\'e opposizione?', 'Il giudizio può proseguire con attività ulteriore e compensi diversi.'],
                ['Sono incluse tasse e contributo unificato?', 'No, il calcolo riguarda il compenso professionale salvo opzioni accessorie.'],
            ],
        ],
        'contributo-unificato' => [
            'title' => 'Calcolo contributo unificato 2026 (gratuito)',
            'keyword' => 'calcolo contributo unificato',
            'service' => 'Costi giudiziari',
            'intro' => 'Lo strumento calcola il contributo unificato civile in base a valore, tipo di procedimento e competenza. È utile per stimare le spese vive iniziali di una causa, un decreto ingiuntivo, un appello o un\'esecuzione.',
            'faq' => [
                ['Il contributo varia per valore?', 'Sì, nel processo civile ordinario dipende dallo scaglione di valore della causa.'],
                ['Appello e Cassazione costano di più?', 'Di regola sono previste maggiorazioni rispetto al primo grado.'],
                ['Sono previste esenzioni?', 'Sì, alcune materie o condizioni possono comportare esenzione o riduzione.'],
            ],
        ],
        'scadenze' => [
            'title' => 'Calcolo termini processuali 2026 – scadenze e sospensione feriale (gratuito)',
            'keyword' => 'calcolo termini processuali',
            'service' => 'Processo civile',
            'intro' => 'Il calcolatore dei termini processuali stima le scadenze del processo civile (costituzione del convenuto, memorie dell\'art. 171-ter, conclusionali e repliche, appello, ricorso per cassazione, opposizione a decreto ingiuntivo) e del riesame penale, con sospensione feriale e proroga dei festivi. È uno strumento operativo utile, ma ogni termine va verificato sugli atti e sulla normativa applicabile.',
            'faq' => [
                ['La sospensione feriale si applica sempre?', 'No, alcune materie e procedimenti sono esclusi.'],
                ['Cosa sono i giorni liberi?', 'Sono termini in cui non si computano né il giorno iniziale né quello finale.'],
                ['Posso usare il risultato in giudizio?', 'Va sempre verificato dal difensore prima di depositi o notifiche.'],
            ],
        ],
        'opposizione-decreto-ingiuntivo' => [
            'title' => 'Calcolo termini opposizione decreto ingiuntivo: 40 giorni dalla notifica (gratuito)',
            'keyword' => 'calcolo opposizione decreto ingiuntivo 40 giorni',
            'service' => 'Recupero crediti e opposizioni',
            'intro' => 'Ha ricevuto un decreto ingiuntivo? Il calcolatore gratuito individua la scadenza per l\'opposizione (art. 641 c.p.c.): 40 giorni dalla notifica, termini ridotti o aumentati, sospensione feriale. Il calcolatore stima la scadenza per proporre opposizione a decreto ingiuntivo partendo dalla data di notifica, con termine ordinario di quaranta giorni e opzioni per termini ridotti, aumentati o notifiche all\'estero. Include sospensione feriale e proroga al primo giorno non festivo quando applicabili.',
            'faq' => [
                ['Qual è il termine ordinario per opporsi?', 'Di regola il decreto ingiuntivo assegna quaranta giorni dalla notifica, salvo diversa indicazione del giudice.'],
                ['Il termine può essere diverso?', 'Sì, l\'art. 641 c.p.c. consente termini ridotti o aumentati e prevede regole specifiche per intimati residenti all\'estero.'],
                ['La sospensione feriale si applica sempre?', 'Va verificata in base alla materia e al rito: lo strumento consente di attivarla o disattivarla.'],
            ],
        ],
        'pignoramento-stipendio-pensione' => [
            'title' => 'Calcolo pignoramento stipendio e pensione 2026 (gratuito)',
            'keyword' => 'calcolo pignoramento stipendio pensione quinto pignorabile',
            'service' => 'Esecuzioni e recupero crediti',
            'intro' => 'Lo strumento stima la quota mensile pignorabile su stipendio o pensione distinguendo crediti ordinari, riscossione esattoriale e crediti alimentari. Per le pensioni considera la soglia impignorabile prevista dall\'art. 545 c.p.c., pari al doppio dell\'assegno sociale con minimo di mille euro.',
            'faq' => [
                ['Quanto si può pignorare sullo stipendio?', 'Per crediti ordinari la quota tipica è un quinto del netto, salvi concorsi, alimenti e discipline speciali.'],
                ['La pensione ha una soglia protetta?', 'Sì, resta impignorabile l\'importo pari al doppio dell\'assegno sociale, con minimo di 1.000 euro mensili.'],
                ['I debiti fiscali seguono gli stessi limiti?', 'Per la riscossione esattoriale si applicano soglie speciali: un decimo, un settimo o un quinto in base all\'importo.'],
            ],
        ],
        'prescrizione-crediti' => [
            'title' => 'Calcolo prescrizione crediti 2026 (gratuito)',
            'keyword' => 'calcolo prescrizione crediti',
            'service' => 'Recupero crediti e contestazioni',
            'intro' => 'Il calcolatore stima la data di prescrizione di alcune categorie ricorrenti di credito, distinguendo termine ordinario decennale, prescrizioni quinquennali, triennali e biennali. Consente di indicare fino a tre atti interruttivi, esaminati in ordine di data, e di verificare se il termine risulta ancora pendente o già decorso: un atto compiuto dopo la scadenza non riapre il termine.',
            'faq' => [
                ['La prescrizione è sempre di dieci anni?', 'No, il termine ordinario decennale vale salvo prescrizioni brevi previste dalla legge.'],
                ['Una diffida interrompe la prescrizione?', 'Può interromperla se contiene una richiesta idonea e se ne provano ricezione e contenuto, purché arrivi prima che la prescrizione sia compiuta.'],
                ['Se il termine scade di sabato, si proroga?', 'No: per la prescrizione si proroga solo il termine che scade in giorno festivo (art. 2963 c.c.); il sabato non lo è. La proroga del sabato riguarda gli atti del processo civile.'],
                ['Il calcolatore decide se il credito è prescritto?', 'No, serve una verifica su titolo, decorrenza, atti interruttivi, riconoscimenti di debito e giudizi pendenti.'],
            ],
        ],
        'spese-straordinarie-figli' => [
            'title' => 'Calcolo riparto spese straordinarie figli 2026 (gratuito)',
            'keyword' => 'calcolo spese straordinarie figli separazione',
            'service' => 'Famiglia e separazioni',
            'intro' => 'Lo strumento ripartisce le spese straordinarie per i figli secondo la percentuale prevista da accordo, sentenza o decreto, calcolando quota di ciascun genitore, rimborso dovuto e promemoria documentale. È utile per spese mediche, scolastiche, sportive e altre voci non ordinarie.',
            'faq' => [
                ['La percentuale è sempre 50 e 50?', 'No, conta il provvedimento o l\'accordo: il calcolatore consente anche riparti 70/30, 100/0 o personalizzati.'],
                ['Serve autorizzazione preventiva?', 'Dipende dalla voce di spesa e dal provvedimento; molte spese non urgenti richiedono confronto preventivo.'],
                ['Posso chiedere il rimborso senza documenti?', 'Di regola occorrono ricevute, fatture, prova del pagamento e comunicazione all\'altro genitore.'],
            ],
        ],
        'aqp' => [
            'title' => 'Calcolo e verifica bolletta AQP 2026 (gratuito)',
            'keyword' => 'contestazione bolletta AQP',
            'service' => 'Utenze e consumatori',
            'intro' => 'Lo strumento aiuta a verificare importi anomali in bolletta AQP, consumi, perdite occulte e possibili profili di reclamo. Serve per preparare una prima contestazione documentata prima dell\'eventuale assistenza legale.',
            'faq' => [
                ['Quando conviene contestare la bolletta?', 'Quando vi sono consumi anomali, errori di lettura, conguagli non chiari o perdite occulte.'],
                ['Serve prima un reclamo?', 'Di regola è opportuno inviare un reclamo scritto al gestore.'],
                ['Il calcolatore decide la controversia?', 'No, aiuta a ordinare i dati e stimare le contestazioni.'],
            ],
        ],
        'timeline-marchio' => [
            'title' => 'Calcolo tempi deposito marchio UIBM ed EUIPO 2026 (gratuito)',
            'keyword' => 'tempi registrazione marchio',
            'service' => 'Marchi e proprietà intellettuale',
            'intro' => 'Il calcolatore ricostruisce una timeline indicativa per deposito, pubblicazione, opposizione e registrazione di un marchio UIBM o EUIPO. Aiuta imprese e professionisti a programmare il lancio del segno distintivo.',
            'faq' => [
                ['Il marchio è protetto subito?', 'La tutela piena dipende dalla procedura e dall\'esito della domanda, ferma la data di deposito.'],
                ['Quanto dura il periodo di opposizione?', 'Dipende dalla procedura nazionale o europea applicabile.'],
                ['Serve una ricerca di anteriorità?', 'Sì, è consigliabile prima del deposito per ridurre rischi di opposizione.'],
            ],
        ],
        'costi-marchio' => [
            'title' => 'Costi del marchio 2026: tasse UIBM, EUIPO e WIPO (gratuito)',
            'keyword' => 'costo registrazione marchio',
            'service' => 'Marchi e proprietà intellettuale',
            'intro' => 'Il calcolatore somma le tasse e i diritti degli uffici per deposito, rinnovo, opposizione, nullità e decadenza di un marchio italiano (UIBM), dell\'Unione europea (EUIPO) o internazionale (WIPO). Gli importi ufficiali sono stati verificati il 10 ottobre 2026; il compenso professionale si definisce con un preventivo personalizzato.',
            'faq' => [
                ['Quanto costano le tasse per un marchio italiano in una classe?', 'Per il deposito telematico: 101 euro di tassa e 48 euro di imposta di bollo, più 34 euro se l\'operazione è affidata a un professionista con lettera d\'incarico.'],
                ['Il calcolatore comprende il compenso dello Studio?', 'No: calcola le sole tasse degli uffici. Il compenso si definisce dopo l\'esame del segno, con un preventivo personalizzato.'],
                ['Perché per il marchio internazionale il totale è una simulazione?', 'Il calcolatore applica il regime standard; molti Paesi prevedono tasse individuali che lo sostituiscono e possono dare importi più alti o più bassi. L\'importo esatto si ottiene con il calcolatore ufficiale WIPO.'],
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

    $whatsapp_message = rawurlencode(
        'Buongiorno, ho utilizzato il calcolatore "' . $data['title']
        . '" e vorrei far verificare il risultato allo Studio.'
    );
    $whatsapp_url = lanotte_whatsapp_url() . (strpos(lanotte_whatsapp_url(), '?') === false ? '?' : '&') . 'text=' . $whatsapp_message;

    $guidance = $slug === 'macropermanenti'
        ? '<p><strong>Che cosa serve:</strong> tipo e data dell\'evento, punti riconosciuti, età alla data del fatto e giorni di inabilità indicati nella relazione medico-legale. Le spese e la perdita di reddito sono facoltative.</p>'
        : '<p>Per usare correttamente lo strumento inserisca i dati richiesti, controlli il risultato e scarichi o stampi il report solo dopo aver verificato l\'anteprima. Il calcolo è pensato per una prima valutazione operativa.</p><p>Quando il conteggio incide su diritti, prescrizioni, termini processuali, risarcimenti o somme contestate, è opportuno farlo verificare da un avvocato.</p>';

    return '<section class="lanotte-calc-seo-intro"><p>' . esc_html($data['intro']) . '</p>' . $guidance . '</section>'
        . '[lanotte_calcolatore slug="' . esc_attr($slug) . '"]'
        . '<section class="lanotte-calc-conversion" data-calc-slug="' . esc_attr($slug) . '">'
        . '<div><p class="lanotte-calc-conversion-kicker">Verifica professionale</p><h2>Desidera verificare il risultato?</h2>'
        . '<p>Può inviare il calcolo allo Studio: verifichiamo documenti, decorrenze e regole applicabili prima che il risultato venga utilizzato.</p></div>'
        . '<div class="lanotte-calc-conversion-actions">'
        . '<a class="btn btn-primary" data-lanotte-event="calc_whatsapp" href="' . esc_url($whatsapp_url) . '" target="_blank" rel="noopener">Invii su WhatsApp</a>'
        . '<a class="btn btn-ghost" data-lanotte-event="calc_contact" href="' . esc_url(add_query_arg(['argomento' => $slug], home_url('/contatti/'))) . '">Richieda una verifica</a>'
        . '</div></section>'
        . '<section class="lanotte-calc-seo-faq"><h2>Domande frequenti</h2>' . $faq . '<p><em>Strumento indicativo: non sostituisce la consulenza legale e va verificato sul caso concreto.</em></p><p><a class="btn btn-primary" href="' . esc_url(home_url('/contatti/')) . '">Richieda una verifica dello Studio</a></p></section>';
}

add_action('template_redirect', function() {
    $path = wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    $legacy_paths = [
        '/calcolatori/rivalutazione-istat-assegno-mantenimento',
        '/calcolatori/adeguamento-istat-mantenimento',
    ];

    if (!in_array(untrailingslashit((string) $path), $legacy_paths, true)) return;

    wp_safe_redirect(lanotte_calcolatore_url('mantenimento-istat'), 301);
    exit;
}, 1);

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
            update_post_meta($post_id, '_aioseo_title', $data['title'] . ' | Studio Legale LANOTTE');
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
            'imposta-successione' => 'Imposta di successione',
            'quote-ereditarie' => 'Quote ereditarie e legittima',
            'usufrutto-nuda-proprieta' => 'Usufrutto e nuda proprietà',
            'mantenimento-orientativo' => 'Stima orientativa mantenimento figli',
            'mantenimento-istat' => 'Rivalutazione ISTAT mantenimento',
            'spese-straordinarie-figli' => 'Spese straordinarie figli',
            'stragiudiziale' => 'Mediazione e negoziazione assistita',
            'scadenze' => 'Termini processuali',
        ],
        'infortunistica-malasanita' => [
            'inail' => 'Indennizzo INAIL',
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
            'costi-marchio' => 'Costi ufficiali del marchio',
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

function lanotte_successione_calcolatore_cta() {
    return '<aside class="lanotte-successione-calc-cta" aria-label="Calcolatore imposta di successione">'
        . '<div><p class="lanotte-successione-calc-kicker">Strumento gratuito</p>'
        . '<h2>Calcolo delle imposte di successione</h2>'
        . '<p>Simulazione con attivo, passività, quota, parentela, franchigie, immobili e agevolazione prima casa. Il risultato è esclusivamente informativo e richiede una verifica professionale.</p></div>'
        . '<div class="lanotte-successione-calc-actions"><a class="btn btn-primary" href="' . esc_url(lanotte_calcolatore_url('imposta-successione')) . '">Calcoli l’imposta</a>'
        . '<a class="btn btn-ghost" href="' . esc_url(lanotte_calcolatore_url('quote-ereditarie')) . '">Calcoli le quote ereditarie</a></div>'
        . '</aside>';
}

function lanotte_post_is_about_succession() {
    if (!is_singular('post')) return false;

    $post = get_post();
    if (!$post instanceof WP_Post) return false;
    $terms = wp_get_post_categories($post->ID, ['fields' => 'all']);
    $category_text = implode(' ', array_map(function($term) {
        return $term->name . ' ' . $term->slug;
    }, $terms));
    $haystack = remove_accents($post->post_title . ' ' . $post->post_name . ' ' . $category_text);

    // «legittima difesa» non riguarda le successioni (il caso ROGGERO mostrava il riquadro per errore).
    return (bool) preg_match('/succession|eredita|ereditari|testament|legittimari|legittima(?![\s-]+difesa)|donazion|coerede/i', $haystack);
}

add_filter('the_content', function($content) {
    if (!in_the_loop() || !is_main_query()) return $content;
    if (is_page('avvocato-successioni-eredita') || lanotte_post_is_about_succession()) {
        return $content . lanotte_successione_calcolatore_cta();
    }
    return $content;
}, 19);

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
