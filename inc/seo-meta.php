<?php
/**
 * SEO meta per pagina/area — titoli e descrizioni ottimizzati (focus Barletta).
 *
 * Si integra con AIOSEO tramite i filtri ufficiali `aioseo_title` /
 * `aioseo_description`. Fallback nativo (document_title_parts + meta description)
 * se AIOSEO non è attivo. Mappa per slug di pagina e per slug di area.
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

// Vecchia homepage importata: evita un duplicato indicizzabile della home attiva.
add_action('template_redirect', function() {
    if (!is_page('homepage-main')) return;

    wp_safe_redirect(home_url('/'), 301);
    exit;
}, 1);

// Vecchio slug usato per il recupero crediti: confluisce nell'area civile attiva.
add_action('template_redirect', function() {
    $path = wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (untrailingslashit((string) $path) !== '/aree/recupero-crediti') return;

    wp_safe_redirect(home_url('/aree/diritto-civile/'), 301);
    exit;
}, 1);

function lanotte_seo_map() {
    $brand = 'LANOTTE & Partners';
    return [
        // === HOME ===
        '_home' => [
            't' => 'Studio Legale a Barletta (Foro di Trani) | ' . $brand,
            'd' => 'Studio legale a Barletta: assistenza in diritto civile, penale, famiglia, impresa e proprietà intellettuale. Foro di Trani. Preventivo scritto.',
        ],
        // === PAGINE ===
        'lo-studio' => [
            't' => 'Lo Studio · Avvocati a Barletta e Trani | ' . $brand,
            'd' => 'Studio Legale LANOTTE & Partners a Barletta, Foro di Trani: diritto civile, penale, d\'impresa e proprietà intellettuale (UIBM, EUIPO, OMPI).',
        ],
        'onorari' => [
            't' => 'Onorari e Servizi Online · Avvocato a Barletta | ' . $brand,
            'd' => 'Trasparenza sui compensi: preventivo scritto ex art. 13 L. 247/2012. Consulenze e servizi legali online dello Studio a Barletta e Trani.',
        ],
        'contatti' => [
            't' => 'Contatti · Studio Legale a Barletta | ' . $brand,
            'd' => 'Contatta lo Studio Legale a Barletta (Foro di Trani): telefono, WhatsApp, email e modulo. Sede in Viale Falcone e Borsellino. Risposta in 24 ore.',
        ],
        'calcolatori' => [
            't' => 'Calcolatori Giuridici Gratuiti · Avvocato Barletta | ' . $brand,
            'd' => '23 calcolatori giuridici gratuiti: mantenimento, danni, interessi, scadenze, parcelle, successioni e contributo unificato. Studio Legale Lanotte.',
        ],
        'servizi-online' => [
            't' => 'Servizi Legali Online e Preventivo Scritto | ' . $brand,
            'd' => 'Richiedi servizi legali online con preventivo scritto personalizzato: consulenze, contratti, famiglia, impresa, penale, marchi e successioni.',
        ],
        'casi-studio' => [
            't' => 'Casi Studio · Scenari Illustrativi | ' . $brand,
            'd' => 'Scenari illustrativi che mostrano il metodo dello Studio nelle varie materie del diritto. Esempi a fini divulgativi. Avvocato a Barletta e Trani.',
        ],
        'penale-urgenza' => [
            't' => 'Penale d\'Urgenza H24 a Barletta | ' . $brand,
            'd' => 'Assistenza penale d\'urgenza per arresti, fermi e perquisizioni a Barletta e nel Foro di Trani. Reperibilità telefonica anche notturna e festiva.',
        ],
        'carriere' => [
            't' => 'Carriere · Cerchiamo Avvocati a Barletta | ' . $brand,
            'd' => 'Opportunità di collaborazione con lo Studio Legale LANOTTE & Partners a Barletta. Invia la candidatura a info@studiolegalelanotte.it.',
        ],
        'glossario' => [
            't' => 'Glossario Giuridico · Studio Legale | ' . $brand,
            'd' => 'Glossario giuridico con i termini legali spiegati in modo chiaro, a cura dello Studio Legale LANOTTE & Partners di Barletta (Foro di Trani).',
        ],
        'newsletter' => [
            't' => 'Newsletter Giuridica · Studio Legale | ' . $brand,
            'd' => 'Iscriviti alla newsletter dello Studio Legale LANOTTE & Partners di Barletta: aggiornamenti e approfondimenti giuridici, senza spam.',
        ],
        'avvocato-successioni-eredita' => [
            't' => 'Avvocato Successioni ed Eredità a Barletta | ' . $brand,
            'd' => 'Assistenza legale per successioni, eredità, divisioni, testamenti e quote di legittima a Barletta e in tutta Italia. Consulenza su appuntamento.',
        ],
        'privacy' => [
            't' => 'Privacy Policy | Studio Legale ' . $brand,
            'd' => 'Informativa sul trattamento dei dati personali dello Studio Legale LANOTTE & Partners, Barletta (Foro di Trani), ai sensi del Reg. UE 2016/679.',
        ],
        'cookie' => [
            't' => 'Cookie Policy | Studio Legale ' . $brand,
            'd' => 'Informativa sull\'uso dei cookie del sito dello Studio Legale LANOTTE & Partners, Barletta (Foro di Trani).',
        ],
        'credits' => [
            't' => 'Credits | Studio Legale ' . $brand,
            'd' => 'Attribuzioni di immagini, tipografia e risorse del sito dello Studio Legale LANOTTE & Partners, Barletta.',
        ],
        // === AREE (per slug) — focus Barletta + Foro di Trani ===
        'diritto-penale' => [
            't' => 'Avvocato Penalista a Barletta e Trani | ' . $brand,
            'd' => 'Difesa penale a Barletta in ogni grado: indagini, misure cautelari, dibattimento, parte civile. Reperibilità per urgenze. Preventivo scritto.',
        ],
        'diritto-civile' => [
            't' => 'Avvocato Civilista a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato civilista a Barletta: contratti, recupero crediti, locazioni, responsabilità e risarcimenti. Assistenza stragiudiziale e giudiziale.',
        ],
        'famiglia-successioni' => [
            't' => 'Avvocato Famiglia e Successioni a Barletta | ' . $brand,
            'd' => 'Separazione, divorzio, affidamento, eredità e divisioni a Barletta e Trani. Soluzioni consensuali e tutela del patrimonio. Preventivo scritto.',
        ],
        'condominio' => [
            't' => 'Avvocato Condominialista a Barletta | ' . $brand,
            'd' => 'Avvocato per il condominio a Barletta: impugnazione delibere, spese, decreti ingiuntivi e lavori. Assistenza a condòmini e amministratori.',
        ],
        'impresa' => [
            't' => 'Avvocato Diritto d\'Impresa a Barletta | ' . $brand,
            'd' => 'Avvocato d\'impresa a Barletta: contratti commerciali, società, recupero crediti e crisi d\'impresa. Consulenza continuativa per aziende.',
        ],
        'infortunistica-malasanita' => [
            't' => 'Risarcimento Danni e Malasanità a Barletta | ' . $brand,
            'd' => 'Avvocato per risarcimento danni a Barletta: sinistri stradali, infortuni e responsabilità medica. Valutazione medico-legale e contestazione offerte.',
        ],
        'lavoro' => [
            't' => 'Avvocato del Lavoro a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato del lavoro a Barletta: licenziamenti, differenze retributive, demansionamento. Tutela di lavoratori e aziende. Preventivo scritto.',
        ],
        'tributario' => [
            't' => 'Avvocato Tributarista a Barletta e Trani | ' . $brand,
            'd' => 'Avvocato tributarista a Barletta: cartelle, accertamenti, ricorsi e riscossione. Difesa innanzi alla Corte di Giustizia Tributaria.',
        ],
        'proprieta-intellettuale' => [
            't' => 'Avvocato Marchi e Brevetti UIBM/EUIPO | ' . $brand,
            'd' => 'Registrazione e tutela di marchi, brevetti e design davanti a UIBM, EUIPO e OMPI. Opposizioni e contraffazione. Studio a Barletta (Foro di Trani).',
        ],
        'bancario' => [
            't' => 'Avvocato Diritto Bancario a Barletta | ' . $brand,
            'd' => 'Avvocato per il diritto bancario a Barletta: anatocismo, usura, mutui, fideiussioni e segnalazioni CRIF. Perizia econometrica e azione giudiziale.',
        ],
        'internazionale-privato' => [
            't' => 'Avvocato Internazionale a Barletta e Trani | ' . $brand,
            'd' => 'Contratti cross-border, successioni internazionali e riconoscimento di sentenze estere (Bruxelles I-bis, Roma I). Studio a Barletta (Foro di Trani).',
        ],
        'previdenza' => [
            't' => 'Avvocato Invalidità INPS e Legge 104 | ' . $brand,
            'd' => 'Ricorsi INPS, invalidità civile, Legge 104 e accompagnamento a Barletta. Accertamento tecnico preventivo ex art. 445-bis c.p.c.',
        ],
        'no-profit' => [
            't' => 'Avvocato ETS, RUNTS e ASD a Barletta | ' . $brand,
            'd' => 'Costituzione ETS, iscrizione RUNTS, statuti e ASD/SSD a Barletta e Trani. Consulenza legale e fiscale per associazioni. Preventivo scritto.',
        ],
    ];
}

/*
 * La pagina Successioni storica contiene un vecchio blocco CSS salvato come
 * testo nel contenuto. Lo rimuoviamo in output: le regole vivono nel foglio
 * stile del tema e non finiscono più nel testo visibile o negli estratti.
 */
add_filter('the_content', function($content) {
    if (!is_page('avvocato-successioni-eredita')) return $content;

    return preg_replace(
        '#(<section[^>]*class=["\'][^"\']*\bsucc-hero\b[^"\']*["\'][^>]*>).*?(<div[^>]*class=["\'][^"\']*\bsucc-wrap\b[^"\']*\bsucc-hero-in\b[^"\']*["\'][^>]*>)#is',
        '$1$2',
        $content,
        1
    );
}, 5);

/**
 * Chiave SEO della pagina/area correntemente visualizzata.
 */
function lanotte_seo_current_key() {
    if (is_front_page()) return '_home';
    if (is_post_type_archive('caso')) return 'casi-studio';
    $obj = get_queried_object();
    if ($obj instanceof WP_Post && !empty($obj->post_name)) return $obj->post_name;
    if ($obj instanceof WP_Term && $obj->taxonomy === 'category') return 'cat:' . $obj->slug;
    return '';
}

/* === Integrazione AIOSEO (filtri ufficiali) === */
add_filter('aioseo_title', function($title) {
    if (function_exists('lanotte_current_calcolatore_data')) {
        $calc = lanotte_current_calcolatore_data();
        if ($calc) return $calc['title'] . ' | Studio Legale LANOTTE';
    }

    $map = lanotte_seo_map() + lanotte_seo_map_articoli();
    $k = lanotte_seo_current_key();
    if ($k && isset($map[$k]['t'])) return $map[$k]['t'];
    return lanotte_seo_suffisso_breve($title);
});
add_filter('aioseo_description', function($desc) {
    if (function_exists('lanotte_current_calcolatore_data')) {
        $calc = lanotte_current_calcolatore_data();
        if ($calc) return wp_trim_words($calc['intro'], 28, '...');
    }

    $map = lanotte_seo_map() + lanotte_seo_map_articoli();
    $k = lanotte_seo_current_key();
    return ($k && isset($map[$k]['d'])) ? $map[$k]['d'] : $desc;
});

/* === Fallback nativo se AIOSEO non è attivo === */
add_filter('document_title_parts', function($parts) {
    if (defined('AIOSEO_VERSION')) return $parts; // AIOSEO gestisce il title
    if (function_exists('lanotte_current_calcolatore_data')) {
        $calc = lanotte_current_calcolatore_data();
        if ($calc) return ['title' => $calc['title'] . ' | Studio Legale LANOTTE'];
    }

    $map = lanotte_seo_map() + lanotte_seo_map_articoli();
    $k = lanotte_seo_current_key();
    if ($k && isset($map[$k]['t'])) {
        $parts = ['title' => $map[$k]['t']];
    }
    return $parts;
}, 99);

add_action('wp_head', function() {
    if (defined('AIOSEO_VERSION')) return; // AIOSEO genera la meta description
    if (function_exists('lanotte_current_calcolatore_data')) {
        $calc = lanotte_current_calcolatore_data();
        if ($calc) {
            echo '<meta name="description" content="' . esc_attr(wp_trim_words($calc['intro'], 28, '...')) . '">' . "\n";
            return;
        }
    }

    $map = lanotte_seo_map() + lanotte_seo_map_articoli();
    $k = lanotte_seo_current_key();
    if ($k && isset($map[$k]['d'])) {
        echo '<meta name="description" content="' . esc_attr($map[$k]['d']) . '">' . "\n";
    }
}, 1);

/**
 * Titoli e descrizioni SEO di articoli e categorie (26/09/2026).
 *
 * Articoli: 55 titoli del vecchio blog superavano i 65 caratteri (fino a 200) e Google
 * li tagliava prima dell'argomento. Qui una versione breve e fedele al contenuto.
 * Categorie: chiavi con prefisso «cat:» perché diversi slug coincidono con quelli
 * delle aree (condominio, lavoro, previdenza…) e non devono prenderne il titolo.
 * Stessa logica di lanotte_seo_map(): 't' titolo, 'd' descrizione.
 */
function lanotte_seo_map_articoli() {
    return [
        // === CATEGORIE ===
        'cat:successioni' => ['t' => 'Successioni ed eredità: articoli e sentenze | LANOTTE & Partners', 'd' => 'Articoli e approfondimenti dello Studio Legale LANOTTE su successioni ed eredità: testamenti, quote di legittima, divisione ereditaria e rapporti tra eredi.'],
        'cat:penale' => ['t' => 'Diritto penale: articoli e sentenze | LANOTTE & Partners', 'd' => 'Approfondimenti di diritto e procedura penale: giurisprudenza, riforme e tutela di indagati, imputati e persone offese. Studio Legale LANOTTE, Barletta.'],
        'cat:lavoro' => ['t' => 'Diritto del lavoro: articoli | LANOTTE & Partners', 'd' => 'Diritto del lavoro: subordinazione, licenziamenti, retribuzione e contenzioso con il datore di lavoro. Approfondimenti dello Studio Legale LANOTTE.'],
        'cat:lavoro-notizie' => ['t' => 'Notizie di diritto del lavoro | LANOTTE & Partners', 'd' => 'Notizie e sentenze recenti di diritto del lavoro commentate dallo Studio Legale LANOTTE di Barletta, Foro di Trani.'],
        'cat:condominio' => ['t' => 'Condominio: articoli e sentenze | LANOTTE & Partners', 'd' => 'Diritto condominiale: assemblee, delibere, ripartizione delle spese, parti comuni e responsabilità del condominio.'],
        'cat:comunione-condominio' => ['t' => 'Comunione e condominio: sentenze | LANOTTE & Partners', 'd' => 'Sentenze su comunione e condominio: uso delle parti comuni, spese, impugnazione delle delibere e rapporti tra condomini.'],
        'cat:diritto-civile' => ['t' => 'Diritto civile: articoli | LANOTTE & Partners', 'd' => 'Approfondimenti di diritto civile: contratti, obbligazioni, proprietà, responsabilità e recupero dei crediti.'],
        'cat:immobili-in-vendita' => ['t' => 'Immobili in vendita | LANOTTE & Partners', 'd' => 'Annunci di immobili in vendita pubblicati dallo Studio Legale LANOTTE.'],
        'cat:materie-di-interesse' => ['t' => 'Materie di interesse giuridico | LANOTTE & Partners', 'd' => 'Temi giuridici di interesse generale: novità normative, orientamenti della giurisprudenza e guide pratiche dello Studio Legale LANOTTE.'],
        'cat:no-profit' => ['t' => 'Terzo settore, ASD e SSD | LANOTTE & Partners', 'd' => 'Terzo settore e sport dilettantistico: associazioni, ASD e SSD, enti non commerciali e relativi adempimenti.'],
        'cat:notizie' => ['t' => 'Notizie giuridiche e sentenze commentate | LANOTTE & Partners', 'd' => 'Rassegna di notizie giuridiche e sentenze commentate dallo Studio Legale LANOTTE di Barletta, Foro di Trani.'],
        'cat:diritto-bancario' => ['t' => 'Diritto bancario: sentenze | LANOTTE & Partners', 'd' => 'Diritto bancario: segnalazioni in Centrale Rischi, documentazione bancaria, interessi e contenzioso con gli istituti di credito.'],
        'cat:diritto-di-famiglia' => ['t' => 'Diritto di famiglia: sentenze | LANOTTE & Partners', 'd' => 'Separazione, divorzio, affidamento e mantenimento dei figli: sentenze di diritto di famiglia commentate dallo Studio Legale LANOTTE.'],
        'cat:locazioni' => ['t' => 'Locazioni: sentenze e novità | LANOTTE & Partners', 'd' => 'Locazioni abitative e commerciali: canoni, aggiornamento ISTAT, indennità di avviamento, sfratti e rilascio dell\'immobile.'],
        'cat:mediazione' => ['t' => 'Mediazione civile: sentenze | LANOTTE & Partners', 'd' => 'Mediazione civile e commerciale e negoziazione assistita: condizioni di procedibilità, procedura e conseguenze della mancata partecipazione.'],
        'cat:previdenza' => ['t' => 'Previdenza e assistenza | LANOTTE & Partners', 'd' => 'Previdenza e assistenza: pensioni, invalidità civile, prestazioni INPS e INAIL e relativo contenzioso.'],
        'cat:proprieta-intellettuale' => ['t' => 'Marchi e proprietà intellettuale | LANOTTE & Partners', 'd' => 'Marchi, brevetti e diritto d\'autore: registrazione, tutela, decadenza e contraffazione. Approfondimenti dello Studio Legale LANOTTE.'],
        'cat:responsabilita-civile' => ['t' => 'Responsabilità civile | LANOTTE & Partners', 'd' => 'Responsabilità civile e risarcimento del danno: incidenti, cadute, danni da cose in custodia e responsabilità contrattuale.'],
        'cat:responsabilita-medica' => ['t' => 'Responsabilità medica | LANOTTE & Partners', 'd' => 'Responsabilità medica e sanitaria: onere della prova, danno da errore medico e responsabilità della struttura sanitaria.'],
        'cat:risarcimento-danni' => ['t' => 'Risarcimento danni | LANOTTE & Partners', 'd' => 'Risarcimento del danno biologico, morale e patrimoniale: criteri di calcolo, Tabelle di Milano e Tabella Unica Nazionale.'],
        'cat:uncategorized' => ['t' => 'Approfondimenti giuridici | LANOTTE & Partners', 'd' => 'Approfondimenti giuridici dello Studio Legale LANOTTE su temi diversi, non ricondotti a una singola area.'],
        // === ARTICOLI ===
        'riconoscimento-della-retribuzione-professionale-docenti-rpd-in-favore-degli-insegnanti-precari-assunti-con-contratti-di-lavoro-a-tempo-determinato-brevi-e-saltuari' => ['t' => 'Retribuzione professionale docenti (RPD) ai precari a termine'],
        'false-partite-iva-presunzione-lavoro-subordinato' => ['t' => 'False partite IVA e presunzione di lavoro subordinato'],
        'ristrutturazione-il-cambio-di-sagoma-equivale-a-nuova-costruzione-orte-di-cassazione-nella-sentenza-n-20718-2018-depositata-il-13-agosto-2018' => ['t' => 'Ristrutturazione: il cambio di sagoma è nuova costruzione'],
        'quando-un-genitore-ostacola-il-rapporto-con-laltro-lelusione-dei-provvedimenti-sullaffidamento-e-lart-388-comma-2-del-codice-penale' => ['t' => 'Genitore che ostacola l\'affidamento: l\'art. 388 c.p.'],
        'le-parti-formalizzato-un-rapporto-autonomo-rivendicando-la-subordinazione-lavoratore-deve-provare-la-simulazione-del-contratto' => ['t' => 'Rapporto autonomo simulato: la prova della subordinazione'],
        'la-braga-raccordo-delle-tubature-ancora-pomo-della-discordia-cassazione-cambia-nuovamente-orientamento-attribuendolo-al-singolo' => ['t' => 'La braga in condominio: bene comune o del singolo?'],
        'locazioni-commerciali-lindennita-avviamento-rilascio-cassazione-lordinanza-n-242852017' => ['t' => 'Locazioni commerciali: indennità di avviamento e rilascio'],
        'il-responsabile-della-linea-internet-e-sempre-il-titolare-anche-per-condivisione-file-effettuata-da-terzi' => ['t' => 'File sharing illecito: risponde il titolare della linea'],
        'perche-proteggere-il-proprio-marchio' => ['t' => 'Perché registrare e proteggere il proprio marchio'],
        'il-potere-dufficio-del-giudice-di-disporre-le-indagini-tributarie-nella-separazione-i-presupposti' => ['t' => 'Separazione: le indagini tributarie disposte dal giudice'],
        'la-commissione-del-furto-in-ora-notturna-integra-gli-estremi-dellaggravante-di-minorata-difesa' => ['t' => 'Furto in ora notturna e aggravante della minorata difesa'],
        'linerzia-della-titolare-del-marchio-registrato-non-puo-invocata-titolo-decadenza' => ['t' => 'Marchio: l\'inerzia del titolare non basta per la decadenza'],
        'responsabilita-medica-onere-probatorio-struttura-sanitaria' => ['t' => 'Responsabilità medica: l\'onere della prova della struttura'],
        'investigazioni-difensive' => ['t' => 'Investigazioni difensive nel processo penale'],
        'trasferimento-del-minore-allestero-puo-avvenire-solo-col-consenso-dellaltro-genitore' => ['t' => 'Trasferimento del minore all\'estero: serve il consenso'],
        'punibile-gestore-del-bed-and-breakfast-non-comunica-le-generalita-degli-ospiti' => ['t' => 'B&B: punibile chi non comunica le generalità degli ospiti'],
        'lavori-straordinari-in-condominio-obbligatorio-costituire-il-fondo-speciale' => ['t' => 'Fondo speciale condominiale per i lavori straordinari'],
        'risarcimento-del-danno-parentale-dei-prossimi-congiunti-nozione-e-onere-della-prova' => ['t' => 'Danno parentale dei prossimi congiunti: nozione e prova'],
        'responsabilita-medica-imperito-imprudente-lomesso-approfondimento-diagnostico' => ['t' => 'Responsabilità medica e omesso approfondimento diagnostico'],
        'bolletta-elettrica-condominiale-ripartizione-spese' => ['t' => 'Bolletta elettrica condominiale: come si ripartisce'],
        'quando-perquisiscono-lo-studio-di-un-avvocato-chi-protegge-i-segreti-dei-clienti' => ['t' => 'Perquisizione dello studio legale: chi tutela i clienti'],
        'assegno-di-mantenimento-non-pagato-e-reato-cassazione-penale-sez-vi-sentenza-12-12-2018-n-55744' => ['t' => 'Assegno di mantenimento non pagato: arretrati e reato'],
        'opposizione-decreto-ingiuntivo-40-giorni-cosa-fare' => ['t' => 'Opposizione a decreto ingiuntivo: i 40 giorni e cosa fare'],
        'distanze-dovere-rispettare-le-distanze-edifici-pareti-finestrate' => ['t' => 'Distanze tra edifici con pareti finestrate: le regole'],
        'lautomobilista-non-e-responsabile-se-lattraversamento-del-pedone-e-improvviso' => ['t' => 'Pedone che attraversa all\'improvviso: chi è responsabile'],
        'crisi-dimpresa-studio-lanotte-ottiene-la-revoca-della-liquidazione-giudiziale' => ['t' => 'Crisi d\'impresa: revocata la liquidazione giudiziale'],
        'mero-ritardo-del-pagamento-non-legittima-la-segnalazione-centrale-rischi' => ['t' => 'Centrale Rischi: il solo ritardo non basta a segnalare'],
        'la-riforma-della-prescrizione-opportunita-e-limiti-di-una-norma-fondamentale' => ['t' => 'La riforma della prescrizione: opportunità e limiti'],
        'condanna-aggravata-lassicurazione-si-rende-latitante-alla-mediazione' => ['t' => 'Assicurazione assente in mediazione: condanna aggravata'],
        'mancato-adeguamento-istat-assegno-mantenimento-arretrati' => ['t' => 'Mancato adeguamento ISTAT del mantenimento: gli arretrati'],
        'difesa-della-legittima-proprieta-e-responsabilita-penale-il-caso-viaregio' => ['t' => 'Difesa della proprietà e responsabilità penale: Viareggio'],
        'meno-tasse-sportivi-dilettanti-cori-bande-musicali-dilettantistiche' => ['t' => 'Meno tasse per sportivi dilettanti, cori e bande musicali'],
        'genitore-disoccupato-non-esonerato-dallobbligo-mantenere-figli' => ['t' => 'Genitore disoccupato: resta l\'obbligo di mantenere i figli'],
        'addebito-rifiuto-volontario-di-intrattenere-rapporti-affettivi-e-sessuali' => ['t' => 'Addebito: il rifiuto di rapporti affettivi e sessuali'],
        'linserimento-dellavvocato-nella-costituzione-italiana-una-riflessione' => ['t' => 'L\'avvocato nella Costituzione italiana: una riflessione'],
        'sottrazione-di-minore-per-la-madre-che-va-ad-abitare-lontano-dal-padre' => ['t' => 'Sottrazione di minore se la madre si trasferisce lontano?'],
        'necessita-del-permesso-di-costruire-per-la-realizzazione-di-una-veranda' => ['t' => 'Veranda: serve il permesso di costruire? | LANOTTE & Partners'],
        'guard-rail-difettoso-comune-responsabile-caso-incidente-stradale' => ['t' => 'Guard rail difettoso: la responsabilità del Comune'],
        'valore-della-testimonianza-della-vittima-anche-nel-giudizio-abbreviato' => ['t' => 'La testimonianza della vittima nel giudizio abbreviato'],
        'imposta-di-successione-2026-aliquote-franchigie-esempi' => ['t' => 'Imposta di successione 2026: aliquote, franchigie, esempi'],
        'conto-corrente-svuotato-prima-della-morte-rimedi-eredi' => ['t' => 'Conto svuotato prima del decesso: i rimedi degli eredi'],
        'condominio-niente-risarcimento-la-caduta-frutto-disattenzione' => ['t' => 'Caduta in condominio per disattenzione: niente risarcimento'],
        'successione-con-immobili-imposte-volture-documenti' => ['t' => 'Successione con immobili: imposte, volture e documenti'],
        'trattenere-tuo-figlio-puo-essere-reato' => ['t' => 'Trattenere il figlio contro gli accordi può essere reato'],
        'divisione-ereditaria-eredi-non-trovano-accordo' => ['t' => 'Divisione ereditaria senza accordo tra gli eredi'],
        'separazione-o-divorzio-mediante-negoziazione-assistita-da-avvocati' => ['t' => 'Separazione e divorzio con negoziazione assistita'],
        'la-violazione-del-regolamento-condominiale-da-parte-del-conduttore' => ['t' => 'Regolamento condominiale violato dall\'inquilino'],
        'impugnare-delibera-condominiale-termini-mediazione-nullita' => ['t' => 'Impugnare una delibera condominiale: termini e nullità'],
        'consulenza-incontri-e-riunioni-a-distanza-con-sistemi-telematici' => ['t' => 'Consulenza legale e riunioni a distanza | LANOTTE & Partners'],
        'casa-coniugale-e-separazione-chi-paga-davvero-il-prezzo-piu-alto' => ['t' => 'Casa coniugale e separazione: chi sostiene i costi'],
        'guida-pratica-alla-separazione-consensuale-riduci-stress-e-tempi' => ['t' => 'Separazione consensuale: guida pratica | LANOTTE & Partners'],
        'negoziazione-assistita-risolvi-la-tua-separazione-rapidamente' => ['t' => 'Negoziazione assistita per la separazione: come funziona'],
        'la-procedura-di-composizione-della-crisi-da-sovraindebitamento' => ['t' => 'Crisi da sovraindebitamento: la procedura di composizione'],
        'quota-legittima-lesa-erede-escluso-rimedi-termini' => ['t' => 'Quota di legittima lesa: rimedi e termini | LANOTTE & Partners'],
        'condomino-moroso-vita-difficile-sospensione-utenze-comuni' => ['t' => 'Condomino moroso e sospensione dei servizi comuni'],
    ];
}

/* === Suffisso del titolo di sito (26/09/2026) ===
   AIOSEO aggiunge a articoli, categorie e archivi «- Studio Legale Lanotte & partners»:
   35 caratteri, cognome in minuscolo. Lo si sostituisce con «| LANOTTE & Partners»;
   se il titolo resta oltre i 65 caratteri il suffisso si toglie, perché su Google conta
   che si legga l'argomento. */
function lanotte_seo_suffisso_breve($title) {
    $core = preg_replace('/\s+[-|–]\s+Studio Legale Lanotte\s*(?:&amp;|&#038;|&)\s*partners\s*$/iu', '', (string) $title, 1, $n);
    if (!$n) return $title;
    $breve = $core . ' | LANOTTE & Partners';
    return mb_strlen($breve) <= 65 ? $breve : $core;
}

/* === Dati strutturati: un solo BreadcrumbList sulle schede prodotto (26/09/2026) ===
   Sulle schede dei servizi online uscivano due BreadcrumbList: quello di AIOSEO (nel
   grafo del sito) e quello di WooCommerce. Si tiene quello di AIOSEO. */
add_filter('woocommerce_structured_data_breadcrumblist', '__return_empty_array');

/* === Immagine social di riserva (26/09/2026) ===
   44 pagine uscivano senza og:image: 23 in cui AIOSEO stampa i tag social ma senza
   immagine (archivi, due calcolatori, due servizi, quattro articoli) e le 21 categorie,
   in cui AIOSEO non stampa alcun tag social. Condivisa su Facebook o WhatsApp, una
   pagina senza immagine diventa una riga grigia. Se l'immagine manca si usa la card del
   tema più vicina all'argomento (assets/img/social/, tutte 1200x630). */
function lanotte_social_card_slug() {
    $per_slug = [
        'inail' => 'infortunistica', 'mantenimento-orientativo' => 'mantenimento',
        'penale-parte-civile' => 'penale', 'previdenza-invalidita-negata' => 'previdenza',
        'deposito-marchio-nazionale-uibm' => 'marchio',
        'prospetto-rivalutazione-istat-arretrati' => 'mantenimento',
    ];
    $per_cat = [
        'successioni' => 'successioni', 'penale' => 'penale', 'lavoro' => 'lavoro',
        'lavoro-notizie' => 'lavoro', 'condominio' => 'condominio', 'comunione-condominio' => 'condominio',
        'diritto-bancario' => 'bancario', 'diritto-di-famiglia' => 'famiglia', 'locazioni' => 'civile',
        'mediazione' => 'civile', 'previdenza' => 'previdenza', 'proprieta-intellettuale' => 'proprieta-intellettuale',
        'responsabilita-civile' => 'danni', 'responsabilita-medica' => 'infortunistica',
        'risarcimento-danni' => 'danni', 'no-profit' => 'noprofit', 'diritto-civile' => 'civile',
    ];
    if (is_category()) {
        $t = get_queried_object();
        return ($t instanceof WP_Term && isset($per_cat[$t->slug])) ? $per_cat[$t->slug] : 'sito';
    }
    if (is_post_type_archive('product') || (function_exists('is_shop') && is_shop())) return 'onorari';
    if (is_singular()) {
        $p = get_queried_object();
        if ($p instanceof WP_Post) {
            if (isset($per_slug[$p->post_name])) return $per_slug[$p->post_name];
            if ($p->post_type === 'post') {
                foreach ((array) get_the_category($p->ID) as $c) {
                    if (isset($per_cat[$c->slug])) return $per_cat[$c->slug];
                }
            }
        }
    }
    return 'sito';
}
function lanotte_social_card_url() {
    return LANOTTE_THEME_URI . '/assets/img/social/' . lanotte_social_card_slug() . '.jpg';
}
add_filter('aioseo_facebook_tags', function ($tags) {
    $GLOBALS['lanotte_og_aioseo'] = true;
    if (!is_array($tags) || !empty($tags['og:image'])) return $tags;
    $url = lanotte_social_card_url();
    $tags['og:image'] = $url;
    $tags['og:image:secure_url'] = $url;
    $tags['og:image:width'] = 1200;
    $tags['og:image:height'] = 630;
    return $tags;
});
add_filter('aioseo_twitter_tags', function ($tags) {
    if (!is_array($tags) || !empty($tags['twitter:image'])) return $tags;
    $tags['twitter:image'] = lanotte_social_card_url();
    if (empty($tags['twitter:card']) || $tags['twitter:card'] === 'summary') $tags['twitter:card'] = 'summary_large_image';
    return $tags;
});
// Categorie: AIOSEO non passa dai tag social. Li stampiamo noi, solo se AIOSEO non l'ha fatto.
add_action('wp_head', function () {
    if (!is_category() || !empty($GLOBALS['lanotte_og_aioseo'])) return;
    $t = get_queried_object();
    if (!($t instanceof WP_Term)) return;
    $map  = lanotte_seo_map_articoli();
    $key  = 'cat:' . $t->slug;
    $tit  = isset($map[$key]['t']) ? $map[$key]['t'] : wp_get_document_title();
    $desc = isset($map[$key]['d']) ? $map[$key]['d'] : wp_strip_all_tags(term_description($t));
    $url  = get_term_link($t);
    $img  = lanotte_social_card_url();
    $out  = [
        'og:locale' => 'it_IT', 'og:site_name' => 'Studio Legale LANOTTE & Partners',
        'og:type' => 'website', 'og:title' => $tit, 'og:description' => $desc,
        'og:url' => is_wp_error($url) ? '' : $url,
        'og:image' => $img, 'og:image:secure_url' => $img, 'og:image:width' => '1200', 'og:image:height' => '630',
    ];
    foreach ($out as $p => $v) {
        if ($v === '' || $v === null) continue;
        printf('<meta property="%s" content="%s" />' . "\n", esc_attr($p), esc_attr($v));
    }
    printf('<meta name="twitter:card" content="summary_large_image" />' . "\n");
    printf('<meta name="twitter:title" content="%s" />' . "\n", esc_attr($tit));
    if ($desc) printf('<meta name="twitter:description" content="%s" />' . "\n", esc_attr($desc));
    printf('<meta name="twitter:image" content="%s" />' . "\n", esc_url($img));
}, 99);
