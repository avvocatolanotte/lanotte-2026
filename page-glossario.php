<?php
/**
 * Template Name: Glossario Giuridico
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$contatti_url = get_permalink(get_page_by_path('contatti'));
$famiglia_url = get_permalink(get_page_by_path('aree/famiglia-successioni'));
$bancario_url = get_permalink(get_page_by_path('aree/bancario'));
$penale_url   = get_permalink(get_page_by_path('aree/diritto-penale'));
$lavoro_url   = get_permalink(get_page_by_path('aree/lavoro'));
$infort_url   = get_permalink(get_page_by_path('aree/infortunistica-malasanita'));

// Fallback se le pagine ACF/CPT non esistono ancora
$famiglia_url = $famiglia_url ?: home_url('/aree/famiglia-successioni/');
$bancario_url = $bancario_url ?: home_url('/aree/bancario/');
$penale_url   = $penale_url   ?: home_url('/aree/diritto-penale/');
$lavoro_url   = $lavoro_url   ?: home_url('/aree/lavoro/');
$infort_url   = $infort_url   ?: home_url('/aree/infortunistica-malasanita/');
$contatti_url = $contatti_url ?: home_url('/contatti/');
?>

<section class="hero-internal" style="padding:80px 0 60px;color:#fff;background:linear-gradient(135deg,var(--navy),#1a2a4a)">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,48px);line-height:1.15;margin:8px 0 14px">Glossario Giuridico.<br>Le parole della giustizia, spiegate.</h1>
    <p class="subtitle" style="color:#d4d8e0;max-width:760px">Definizioni in linguaggio chiaro dei termini più ricorrenti negli atti giudiziari, nei documenti notarili e nelle pratiche legali. Pensato per chi non è avvocato.</p>
  </div>
</section>

<!-- BARRA RICERCA / NAVIGAZIONE -->
<section class="glossario-toolbar">
  <div class="container">
    <div class="glossario-toolbar-grid">
      <input type="search" id="glossario-search" placeholder="Cerca un termine (es. usucapione, decreto ingiuntivo, prescrizione…)" oninput="filtraGlossario(this.value)" class="glossario-search">
      <div class="glossario-az">
        <a href="#A">A</a><a href="#C">C</a><a href="#D">D</a><a href="#E">E</a><a href="#F">F</a><a href="#G">G</a><a href="#I">I</a><a href="#L">L</a><a href="#M">M</a><a href="#N">N</a><a href="#O">O</a><a href="#P">P</a><a href="#Q">Q</a><a href="#R">R</a><a href="#S">S</a><a href="#T">T</a><a href="#U">U</a>
      </div>
    </div>
  </div>
</section>

<section class="block">
  <div class="container" style="max-width:880px">

    <div class="glossario-letter" id="A">A</div>

    <div class="glossario-term" data-term="affidamento condiviso">
      <h3>Affidamento condiviso <small>Diritto di Famiglia</small></h3>
      <p>Modalità di affido dei figli minori (introdotta dalla L. 54/2006) in cui entrambi i genitori esercitano la responsabilità genitoriale e assumono di comune accordo le decisioni di maggiore interesse per i figli (art. 337-ter c.c.). È la <strong>regola</strong> in caso di separazione o divorzio; l'affidamento esclusivo è l'eccezione, giustificata solo da un pregiudizio concreto per il minore.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($famiglia_url); ?>">Famiglia e Successioni</a> · bigenitorialità · affido super-esclusivo</div>
    </div>

    <div class="glossario-term" data-term="anatocismo">
      <h3>Anatocismo <small>Diritto Bancario</small></h3>
      <p>Pratica con cui gli interessi maturati su una somma capitalizzano e producono a loro volta interessi ("interessi sugli interessi"). Vietato in via generale dall'art. 1283 c.c., è stato per anni applicato dalle banche nei conti correnti. Oggi contestabile in giudizio.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($bancario_url); ?>">Diritto Bancario</a> · usura · tasso soglia</div>
    </div>

    <div class="glossario-term" data-term="avviso di garanzia">
      <h3>Avviso di garanzia <small>Diritto Penale</small></h3>
      <p>Comunicazione formale (art. 369 c.p.p.) con cui il PM informa l'indagato di essere iscritto nel registro delle notizie di reato. Non è una condanna né un'imputazione: significa che è iniziata un'indagine. Va affidata immediatamente la difesa a un avvocato di fiducia.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($penale_url); ?>">Diritto Penale</a> · indagato · interrogatorio di garanzia</div>
    </div>

    <div class="glossario-letter" id="C">C</div>

    <div class="glossario-term" data-term="cassazione">
      <h3>Cassazione <small>Procedura Generale</small></h3>
      <p>Corte Suprema italiana, situata a Roma. Giudica il <strong>solo aspetto giuridico</strong> della sentenza (non i fatti), per garantire l'uniforme interpretazione della legge. Ricorrere richiede un avvocato "cassazionista" (iscritto all'albo speciale).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> appello · legittimità · sezioni unite</div>
    </div>

    <div class="glossario-term" data-term="contraddittorio">
      <h3>Contraddittorio <small>Procedura Generale</small></h3>
      <p>Principio cardine del giusto processo (art. 111 Cost.): le parti devono potersi confrontare davanti al giudice, ognuna con i propri argomenti. Il giudice, salvo che la legge disponga altrimenti, non può decidere su una domanda se la controparte non è stata regolarmente citata (art. 101 c.p.c.); in alcuni casi previsti dalla legge, come il decreto ingiuntivo, il contraddittorio si instaura dopo il provvedimento.</p>
    </div>

    <div class="glossario-term" data-term="custodia cautelare">
      <h3>Custodia cautelare <small>Diritto Penale</small></h3>
      <p>Misura cautelare personale (art. 285 c.p.p.) consistente nella detenzione in carcere prima del giudizio. Richiede gravi indizi di colpevolezza e specifiche esigenze cautelari (pericolo per le prove, di fuga o di commissione di gravi reati: artt. 273 e 274 c.p.p.) e può essere disposta solo quando le altre misure, anche applicate insieme, risultano inadeguate (art. 275, comma 3, c.p.p.).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> arresti domiciliari · interrogatorio di garanzia · riesame</div>
    </div>

    <div class="glossario-letter" id="D">D</div>

    <div class="glossario-term" data-term="decreto ingiuntivo">
      <h3>Decreto ingiuntivo <small>Procedura Civile</small></h3>
      <p>Provvedimento del giudice (art. 633 c.p.c.) che ordina al debitore di pagare una somma certa, liquida ed esigibile entro il termine indicato nel decreto, di regola 40 giorni dalla notificazione (art. 641 c.p.c.). Se non viene proposta opposizione, diventa <strong>titolo esecutivo</strong> e si può procedere a pignoramento. Procedura rapida, basata su prova scritta del credito.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> opposizione a decreto ingiuntivo · titolo esecutivo · precetto</div>
    </div>

    <div class="glossario-term" data-term="diffida">
      <h3>Diffida <small>Procedura Generale</small></h3>
      <p>Atto formale con cui si intima a un altro soggetto di tenere o smettere un certo comportamento (es. pagare un debito, smettere di disturbare, eseguire un contratto), generalmente con minaccia di azione legale in difetto. Non ha valore esecutivo ma è propedeutica al contenzioso.</p>
    </div>

    <div class="glossario-term" data-term="domiciliari">
      <h3>Domiciliari (arresti) <small>Diritto Penale</small></h3>
      <p>Misura cautelare alternativa al carcere (art. 284 c.p.p.): l'indagato resta presso il proprio domicilio o altro luogo privato, con divieto di allontanarsi senza autorizzazione del giudice. Può essere consentito uscire per lavoro, studio o terapie.</p>
    </div>

    <div class="glossario-letter" id="E">E</div>

    <div class="glossario-term" data-term="esecuzione forzata">
      <h3>Esecuzione forzata <small>Procedura Civile</small></h3>
      <p>Procedimento (artt. 474 e ss. c.p.c.) con cui il creditore ottiene coattivamente il soddisfacimento del proprio credito, una volta munito di titolo esecutivo. Tipologie: pignoramento mobiliare, immobiliare, presso terzi (es. stipendio).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> precetto · pignoramento · titolo esecutivo</div>
    </div>

    <div class="glossario-letter" id="F">F</div>

    <div class="glossario-term" data-term="fermo">
      <h3>Fermo <small>Diritto Penale</small></h3>
      <p>Misura precautelare disposta dal pubblico ministero o, nei casi previsti dalla legge, dalla polizia giudiziaria (art. 384 c.p.p.) nei confronti di chi è gravemente indiziato di reato, quando c'è pericolo di fuga. Deve essere convalidato dal GIP entro 96 ore, altrimenti la persona deve essere rilasciata.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> arresto · convalida · interrogatorio di garanzia</div>
    </div>

    <div class="glossario-letter" id="G">G</div>

    <div class="glossario-term" data-term="gip">
      <h3>GIP (Giudice per le Indagini Preliminari) <small>Diritto Penale</small></h3>
      <p>Giudice che interviene nella fase delle indagini per autorizzare atti che incidono sui diritti fondamentali (per esempio intercettazioni e misure cautelari). Le perquisizioni durante le indagini sono di regola disposte dal pubblico ministero con decreto motivato (art. 247 c.p.p.). Diverso dal GUP (Giudice dell'udienza preliminare) e dal giudice del dibattimento.</p>
    </div>

    <div class="glossario-letter" id="I">I</div>

    <div class="glossario-term" data-term="impugnazione">
      <h3>Impugnazione <small>Procedura Generale</small></h3>
      <p>Rimedio con cui una parte contesta un provvedimento davanti al giudice indicato dalla legge: un giudice superiore (appello, ricorso per Cassazione) o, in alcuni casi, lo stesso ufficio (opposizione, revocazione).</p>
    </div>

    <div class="glossario-term" data-term="indagato">
      <h3>Indagato <small>Diritto Penale</small></h3>
      <p>Soggetto a cui è attribuito un reato durante la fase delle indagini preliminari, prima dell'imputazione formale. Lo "status" comporta diritti di difesa (es. nomina del difensore di fiducia, deposito di memorie).</p>
    </div>

    <div class="glossario-term" data-term="interrogatorio di garanzia">
      <h3>Interrogatorio di garanzia <small>Diritto Penale</small></h3>
      <p>Interrogatorio della persona sottoposta a misura cautelare (art. 294 c.p.p.): se il giudice non vi ha già provveduto, avviene entro 5 giorni dall'inizio della custodia in carcere ed entro 10 giorni dall'esecuzione o notificazione delle altre misure. La persona può rispondere o avvalersi della facoltà di non rispondere; il difensore ha l'obbligo di intervenire.</p>
    </div>

    <div class="glossario-letter" id="L">L</div>

    <div class="glossario-term" data-term="legittima">
      <h3>Legittima <small>Successioni</small></h3>
      <p>Quota di eredità riservata per legge a determinati eredi (coniuge, figli, ascendenti), che il testatore non può pretermettere. Se viene violata, l'erede legittimario può proporre <strong>azione di riduzione</strong> per recuperare la sua quota.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($famiglia_url); ?>">Famiglia e Successioni</a> · disponibile · azione di riduzione</div>
    </div>

    <div class="glossario-letter" id="M">M</div>

    <div class="glossario-term" data-term="mediazione">
      <h3>Mediazione (civile e commerciale) <small>Procedura Civile</small></h3>
      <p>Procedura conciliativa (D.Lgs. 28/2010) gestita da un organismo accreditato, con un mediatore terzo che facilita l'accordo tra le parti. Obbligatoria per molte materie (condominio, locazioni, diritti reali, sanità, contratti bancari) come condizione di procedibilità della causa.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> negoziazione assistita · ADR · condizione di procedibilità</div>
    </div>

    <div class="glossario-term" data-term="mobbing">
      <h3>Mobbing <small>Diritto del Lavoro</small></h3>
      <p>Condotta vessatoria, sistematica e prolungata posta in essere sul luogo di lavoro per emarginare, umiliare o estromettere un lavoratore. Configura responsabilità contrattuale e/o extracontrattuale del datore di lavoro. Va provato con elementi concreti (testimoni, documenti).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($lavoro_url); ?>">Diritto del Lavoro</a> · demansionamento · straining</div>
    </div>

    <div class="glossario-letter" id="N">N</div>

    <div class="glossario-term" data-term="naspi">
      <h3>NASpI <small>Lavoro / Previdenza</small></h3>
      <p>Nuova Assicurazione Sociale per l'Impiego, indennità erogata dall'INPS al lavoratore subordinato che perde involontariamente l'occupazione. Durata variabile in base alla contribuzione, non spetta in caso di dimissioni volontarie (salvo eccezioni: giusta causa, maternità, ecc.).</p>
    </div>

    <div class="glossario-term" data-term="negoziazione assistita">
      <h3>Negoziazione assistita <small>Procedura Civile</small></h3>
      <p>Procedura (DL 132/2014) in cui le parti, con l'assistenza obbligatoria dei rispettivi avvocati, cercano un accordo prima di andare in giudizio. È condizione di procedibilità per il risarcimento del danno da circolazione di veicoli e natanti e per le domande di pagamento di somme fino a 50.000 € fuori dalle materie della mediazione obbligatoria (art. 3 D.L. 132/2014); per separazione, divorzio e modifica delle condizioni è una facoltà (art. 6).</p>
    </div>

    <div class="glossario-letter" id="O">O</div>

    <div class="glossario-term" data-term="opposizione">
      <h3>Opposizione (a decreto ingiuntivo) <small>Procedura Civile</small></h3>
      <p>Atto con cui il debitore destinatario di un decreto ingiuntivo contesta la pretesa creditoria, instaurando il giudizio ordinario di cognizione. Di regola va proposta entro 40 giorni dalla notificazione, salvo il diverso termine fissato nel decreto (art. 641 c.p.c.); se il decreto è provvisoriamente esecutivo, il creditore può procedere all'esecuzione anche prima della scadenza (art. 642 c.p.c.).</p>
    </div>

    <div class="glossario-letter" id="P">P</div>

    <div class="glossario-term" data-term="patteggiamento">
      <h3>Patteggiamento <small>Diritto Penale</small></h3>
      <p>Rito speciale (art. 444 c.p.p.) con cui imputato e PM concordano una pena su richiesta, sottoposta poi al vaglio del giudice. Comporta sconto fino a un terzo della pena e altre agevolazioni. Non c'è dibattimento.</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> rito abbreviato · decreto penale · oblazione</div>
    </div>

    <div class="glossario-term" data-term="pignoramento">
      <h3>Pignoramento <small>Esecuzione</small></h3>
      <p>Atto esecutivo con cui un creditore "vincola" beni del debitore (mobili, immobili, conti correnti, stipendi, crediti verso terzi) per poi liquidarli e soddisfare il proprio credito. Tipologie: presso il debitore, presso terzi, immobiliare.</p>
    </div>

    <div class="glossario-term" data-term="precetto">
      <h3>Precetto <small>Esecuzione</small></h3>
      <p>Atto preliminare al pignoramento (art. 480 c.p.c.) con cui il creditore intima formalmente al debitore di adempiere entro 10 giorni, sotto minaccia di esecuzione forzata. Deve indicare il titolo esecutivo e la somma dovuta.</p>
    </div>

    <div class="glossario-term" data-term="prescrizione">
      <h3>Prescrizione <small>Procedura Generale</small></h3>
      <p>Estinzione di un diritto o di un'azione per inerzia prolungata del titolare. Termini variabili: 5 anni (risarcimento da fatto illecito), 10 anni (ordinaria), 1 anno dalla consegna (garanzia per vizi nella vendita, art. 1495 c.c.), 2 anni (danni da circolazione di veicoli, art. 2947 c.c.). Si interrompe con atti di costituzione in mora.</p>
    </div>

    <div class="glossario-letter" id="Q">Q</div>

    <div class="glossario-term" data-term="querela">
      <h3>Querela <small>Diritto Penale</small></h3>
      <p>Manifestazione di volontà della persona offesa da un reato perseguibile a querela, finalizzata all'avvio del procedimento penale. Il termine ordinario è di 3 mesi dalla notizia del fatto, salvo termini diversi previsti dalla legge (art. 124 c.p.); la querela può essere rimessa, estinguendo il reato, salvo i casi in cui la legge la rende irrevocabile.</p>
    </div>

    <div class="glossario-letter" id="R">R</div>

    <div class="glossario-term" data-term="rito abbreviato">
      <h3>Rito abbreviato <small>Diritto Penale</small></h3>
      <p>Rito speciale (art. 438 c.p.p.) deciso allo stato degli atti, senza dibattimento. In caso di condanna la pena è diminuita di un terzo per i delitti e della metà per le contravvenzioni; se né l'imputato né il difensore impugnano la sentenza, è ridotta di un ulteriore sesto in fase di esecuzione (art. 442, commi 2 e 2-bis, c.p.p.). Scelta strategica: conviene quando le prove d'indagine sono deboli o quando la condanna è probabile e si vuole limitare il danno.</p>
    </div>

    <div class="glossario-term" data-term="riesame">
      <h3>Riesame <small>Diritto Penale</small></h3>
      <p>Impugnazione davanti al tribunale del riesame. Per le misure coercitive la richiesta si propone entro 10 giorni dall'esecuzione o notificazione dell'ordinanza (art. 309 c.p.p.); per il sequestro entro 10 giorni dall'esecuzione o dalla conoscenza del sequestro (art. 324 c.p.p.). Le altre ordinanze sulle misure cautelari personali, come quelle interdittive, si impugnano con l'appello (art. 310 c.p.p.).</p>
    </div>

    <div class="glossario-term" data-term="risarcimento del danno">
      <h3>Risarcimento del danno <small>Diritto Civile</small></h3>
      <p>Obbligo del responsabile di un fatto illecito o di un inadempimento di reintegrare la sfera giuridica del danneggiato. Comprende il danno patrimoniale (danno emergente e lucro cessante) e il danno non patrimoniale (danno biologico e sofferenza morale). Per il danno alla salute da circolazione e responsabilità sanitaria si applicano le tabelle di legge (art. 139 CdA e Tabella Unica Nazionale, D.P.R. 12/2025); la Cassazione indica la TUN come parametro equitativo anche negli altri casi (Cass. civ., sez. III, 7 aprile 2026, n. 8630).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($infort_url); ?>">Infortunistica</a> · responsabilità · CTU medico-legale</div>
    </div>

    <div class="glossario-letter" id="S">S</div>

    <div class="glossario-term" data-term="separazione">
      <h3>Separazione (personale dei coniugi) <small>Diritto di Famiglia</small></h3>
      <p>Istituto (artt. 150 e ss. c.c.) con cui i coniugi cessano la convivenza pur mantenendo il vincolo matrimoniale. Può essere consensuale o giudiziale, con o senza addebito. Dopo 12 mesi (6 se consensuale) si può chiedere il divorzio.</p>
    </div>

    <div class="glossario-term" data-term="sequestro">
      <h3>Sequestro <small>Diritto Penale</small></h3>
      <p>Il sequestro probatorio (art. 253 c.p.p.) è un mezzo di ricerca della prova sul corpo del reato e sulle cose pertinenti necessarie per accertare i fatti; il sequestro preventivo (art. 321 c.p.p.) è una misura cautelare reale sulle cose la cui libera disponibilità può aggravare le conseguenze del reato o di cui è consentita la confisca. Il riesame si propone entro 10 giorni dall'esecuzione o dalla conoscenza del sequestro (art. 324 c.p.p.).</p>
    </div>

    <div class="glossario-letter" id="T">T</div>

    <div class="glossario-term" data-term="titolo esecutivo">
      <h3>Titolo esecutivo <small>Esecuzione</small></h3>
      <p>Documento che attribuisce il diritto a procedere a esecuzione forzata (art. 474 c.p.c.). Esempi: sentenza, decreto ingiuntivo non opposto, atto pubblico notarile, assegno bancario protestato, cambiale.</p>
    </div>

    <div class="glossario-term" data-term="trust">
      <h3>Trust <small>Successioni / Internazionale</small></h3>
      <p>Istituto di origine anglosassone con cui un disponente trasferisce beni a un trustee, che li gestisce nell'interesse di uno o più beneficiari. Utilizzato per pianificazione successoria, protezione patrimoniale, tutela di soggetti deboli. In Italia riconosciuto dalla Convenzione dell'Aja.</p>
    </div>

    <div class="glossario-letter" id="U">U</div>

    <div class="glossario-term" data-term="usucapione">
      <h3>Usucapione <small>Diritto Civile</small></h3>
      <p>Modo di acquisto della proprietà o di altro diritto reale per il <strong>possesso continuato</strong> di una cosa per un certo periodo (in genere 20 anni, ridotti a 10 in alcuni casi). Esempio classico: chi possiede pacificamente un terreno per 20 anni ne diventa proprietario per usucapione, anche contro il proprietario formale.</p>
    </div>

    <div class="glossario-term" data-term="usura">
      <h3>Usura <small>Diritto Bancario / Penale</small></h3>
      <p>Reato di chi si fa dare o promettere interessi o altri vantaggi usurari (art. 644 c.p.). Sono sempre usurari gli interessi oltre la soglia di legge, calcolata sul tasso effettivo globale medio rilevato trimestralmente dal Ministero dell'economia, sentita la Banca d'Italia (art. 2 L. 108/1996); sono usurari anche interessi inferiori alla soglia ma sproporzionati, quando chi li dà o li promette è in difficoltà economica o finanziaria (cosiddetta usura in concreto). Nel mutuo la clausola di interessi usurari è nulla e non sono dovuti interessi (art. 1815 c.c.).</p>
      <div class="vedi-anche"><strong>Vedi anche:</strong> <a href="<?php echo esc_url($bancario_url); ?>">Diritto Bancario</a> · anatocismo · tasso soglia</div>
    </div>

    <div class="glossario-cta-box">
      <h3>Non trovi il termine che cerchi?</h3>
      <p>Stiamo arricchendo il glossario settimanalmente. Ci scriva se un termine non è chiaro: lo aggiungeremo al prossimo aggiornamento.</p>
      <a href="<?php echo esc_url($contatti_url); ?>" class="btn btn-outline">Suggerisci un termine</a>
    </div>

  </div>
</section>

<style>
/* === TOOLBAR RICERCA + A-Z === */
.glossario-toolbar{background:#fff;border-bottom:1px solid var(--border);padding:24px 0;position:sticky;top:0;z-index:10}
.glossario-toolbar-grid{display:grid;grid-template-columns:1fr auto;gap:24px;align-items:center;max-width:1100px;margin:0 auto}
.glossario-search{width:100%;padding:14px 20px;border:1px solid var(--border);background:var(--paper);font-family:inherit;font-size:15px;border-radius:2px}
.glossario-az{display:flex;gap:6px;flex-wrap:wrap;font-size:12px}
.glossario-az a{padding:6px 10px;background:var(--cream);color:var(--navy);text-decoration:none;font-weight:700;letter-spacing:.05em;border-radius:2px}
.glossario-az a:hover{background:var(--gold);color:#fff}

/* === VOCI === */
.glossario-letter{font-family:var(--serif);font-size:72px;color:var(--gold);font-weight:600;line-height:1;margin:48px 0 20px;padding-left:14px;border-left:6px solid var(--gold)}
.glossario-term{background:#fff;border:1px solid var(--border);padding:24px 28px;margin-bottom:14px;border-left:3px solid var(--gold);scroll-margin-top:140px}
.glossario-term h3{font-family:var(--serif);font-size:21px;color:var(--navy);font-weight:600;margin-bottom:8px;display:flex;align-items:baseline;gap:12px;flex-wrap:wrap}
.glossario-term h3 small{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);font-weight:700;background:var(--cream);padding:3px 8px;border-radius:2px}
.glossario-term p{color:var(--text);line-height:1.7;font-size:15px;margin-bottom:8px}
.glossario-term .vedi-anche{font-size:13px;color:var(--text-muted);margin-top:10px;padding-top:10px;border-top:1px dashed var(--border)}
.glossario-term .vedi-anche strong{color:var(--navy)}
.glossario-term .vedi-anche a{color:var(--gold);font-weight:500}

/* === CTA SUGGERISCI === */
.glossario-cta-box{text-align:center;margin-top:48px;padding:32px;background:var(--cream);border-top:3px solid var(--gold)}
.glossario-cta-box h3{font-family:var(--serif);font-size:22px;color:var(--navy);margin-bottom:8px}
.glossario-cta-box p{color:var(--text-muted);margin-bottom:18px}

/* === MOBILE === */
@media (max-width:768px){
  .glossario-toolbar-grid{grid-template-columns:1fr;gap:14px}
  .glossario-az{justify-content:flex-start}
}
@media (max-width:680px){
  .glossario-letter{font-size:54px;margin:36px 0 14px}
  .glossario-term{padding:20px 22px}
  .glossario-term h3{font-size:18px;gap:8px}
  .glossario-term p{font-size:14.5px}
  .glossario-az a{padding:5px 8px;font-size:11.5px}
  .glossario-cta-box{padding:24px 18px}
}
</style>

<script>
function filtraGlossario(q) {
  q = (q || '').toLowerCase().trim();
  document.querySelectorAll('.glossario-term').forEach(function(el){
    var text = el.innerText.toLowerCase();
    el.style.display = (!q || text.indexOf(q) !== -1) ? '' : 'none';
  });
  // Nasconde le lettere senza voci visibili
  document.querySelectorAll('.glossario-letter').forEach(function(letter){
    var next = letter.nextElementSibling;
    var anyVisible = false;
    while (next && !next.classList.contains('glossario-letter')) {
      if (next.classList.contains('glossario-term') && next.style.display !== 'none') {
        anyVisible = true;
        break;
      }
      next = next.nextElementSibling;
    }
    letter.style.display = (!q || anyVisible) ? '' : 'none';
  });
}
</script>

<?php endwhile; get_footer();
