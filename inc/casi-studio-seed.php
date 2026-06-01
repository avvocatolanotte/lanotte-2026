<?php
/**
 * Seed dei 13 "Scenari illustrativi" (casi studio immaginari).
 * Creati come BOZZE (draft) — l'avvocato li rilegge e pubblica da WP.
 * Deontologia: scenari ipotetici, non casi reali (artt. 17, 35 c.d.f.).
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;

function lanotte_casi_studio_data() {
    return [
        ['slug' => 'penale-parte-civile', 'area' => 'Diritto Penale', 'title' => 'Costituzione di parte civile della persona offesa',
         'contesto' => 'Si consideri il caso ipotetico della Sig.ra ROSSI, aggredita all\'uscita da un locale al culmine di un diverbio e refertata al pronto soccorso con lesioni guaribili in alcune settimane. Provata anche sul piano psicologico, ella non intende soltanto che l\'autore del fatto risponda penalmente, ma anche conseguire il ristoro delle spese mediche sostenute e del danno patito.',
         'approccio' => 'In uno scenario di questo tipo l\'impostazione muove dal deposito di una querela circostanziata e dalla partecipazione alle indagini quale persona offesa ex artt. 90 ss. c.p.p., per giungere alla costituzione di parte civile ai sensi degli artt. 76 e 78 c.p.p., da perfezionare entro i termini di cui all\'art. 79 c.p.p. La difesa cura l\'allegazione del danno non patrimoniale e patrimoniale e valuta l\'eventuale richiesta di provvisionale.',
         'profilo' => 'L\'aspetto più istruttivo riguarda il raccordo fra azione penale e azione civile: la scelta di agire nel processo penale anziché in sede civile autonoma incide su oneri probatori, tempi ed effetti del giudicato ex art. 651 c.p.p.',
         'lezione' => 'Tutelare la vittima significa presidiare per tempo i profili sia punitivi sia risarcitori, scegliendo consapevolmente la sede più efficiente.'],

        ['slug' => 'civile-opposizione-di', 'area' => 'Diritto Civile', 'title' => 'Opposizione a decreto ingiuntivo',
         'contesto' => 'Ipotizziamo che la Azienda Alfa S.r.l. si veda notificare un decreto ingiuntivo per il saldo di una fornitura di merce che assume in parte difettosa e già tempestivamente contestata, sì da reputare il credito non dovuto o comunque sovrastimato nel conteggio posto a base del ricorso monitorio.',
         'approccio' => 'In una situazione simile si verifica anzitutto il rispetto del termine di quaranta giorni per proporre opposizione ex art. 641 c.p.c. L\'atto contesta i presupposti del credito e l\'idoneità della prova scritta ex art. 633 c.p.c., eccepisce l\'inadempimento della controparte ex art. 1460 c.c. e affronta la provvisoria esecutività ex artt. 648 e 649 c.p.c., con istanza di sospensione fondata sul fumus dell\'opposizione e sul periculum derivante dall\'esecuzione.',
         'profilo' => 'Rileva la corretta distribuzione dell\'onere della prova: nel giudizio di opposizione l\'opposto, pur formalmente convenuto, conserva la veste sostanziale di attore e deve provare il proprio credito.',
         'lezione' => 'Contro un\'ingiunzione i termini sono stretti e perentori: una reazione tempestiva e tecnicamente fondata è la condizione per discutere il merito.',
         'riferimento' => 'Il principio è consolidato in giurisprudenza: cfr. <em>Cass. SS.UU. n. 19246/2010</em>, secondo cui l\'opposizione a decreto ingiuntivo non è impugnazione del decreto ma instaura un ordinario giudizio di cognizione, nel quale il creditore opposto conserva la veste sostanziale di attore e l\'onere di provare il credito azionato.'],

        ['slug' => 'famiglia-piano-genitoriale', 'area' => 'Famiglia e Successioni', 'title' => 'Separazione con figli e piano genitoriale',
         'contesto' => 'Si consideri il caso ipotetico dei coniugi BIANCHI, genitori di due figli in età scolare, giunti alla decisione di separarsi pur conservando un dialogo civile. Le maggiori incertezze riguardano la collocazione prevalente dei figli, la scansione dei tempi di permanenza presso ciascun genitore, comprese le festività, e la misura del contributo al mantenimento, in un quadro in cui entrambi desiderano restare pienamente presenti nella vita dei minori.',
         'approccio' => 'In uno scenario di questo genere si privilegia, ove possibile, la via consensuale, redigendo gli accordi e il piano genitoriale ora previsto dall\'art. 473-bis.12 c.p.c. introdotto dalla riforma Cartabia, nel quadro dell\'affidamento condiviso e della bigenitorialità ex artt. 337-ter e 337-quater c.c.',
         'profilo' => 'L\'elemento centrale è il piano genitoriale, che traduce in calendario concreto la cura della prole e diviene parametro di valutazione dell\'interesse del minore.',
         'lezione' => 'Un accordo dettagliato e realistico previene il contenzioso futuro più di ogni formula generica.'],

        ['slug' => 'condominio-impugnazione-delibera', 'area' => 'Diritto Condominiale', 'title' => 'Impugnazione di delibera assembleare',
         'contesto' => 'Ipotizziamo che il condòmino VERDI, rientrato dal lavoro, rinvenga nella cassetta postale il verbale di un\'assemblea cui non aveva potuto partecipare, dal quale apprende l\'approvazione di un\'ingente spesa straordinaria per il rifacimento della facciata, deliberata con maggioranze che, alla lettura del riparto delle quote millesimali, gli appaiono insufficienti.',
         'approccio' => 'In una vicenda simile si verifica con precisione il termine di trenta giorni previsto dall\'art. 1137 c.c. per l\'impugnazione, distinguendo le delibere annullabili da quelle nulle. L\'azione è preceduta dall\'esame del verbale, dei quorum e dalla mediazione obbligatoria in materia condominiale ex art. 5 D.Lgs. 28/2010.',
         'profilo' => 'Decisiva è la distinzione fra nullità e annullabilità: solo per le delibere annullabili opera la decadenza dei trenta giorni, mentre la nullità è deducibile senza limiti di tempo.',
         'lezione' => 'Davanti a una delibera contestabile, qualificarne il vizio è il primo passo: determina se e quando si può ancora agire.'],

        ['slug' => 'impresa-patto-parasociale', 'area' => 'Diritto d\'Impresa', 'title' => 'Patto parasociale e responsabilità dell\'amministratore',
         'contesto' => 'Si consideri il caso ipotetico della Beta S.r.l., a ristretta base familiare, i cui soci avevano a suo tempo sottoscritto un patto parasociale per disciplinare le decisioni strategiche e le condizioni di trasferimento delle quote. Alla lettura di un bilancio in perdita, alcuni di essi sollevano dubbi sull\'operato dell\'amministratore, cui imputano scelte gestorie avventate e operazioni concluse senza il preventivo confronto previsto dal patto.',
         'approccio' => 'In uno scenario di questo tipo l\'analisi distingue il piano del patto parasociale, con efficacia obbligatoria fra le parti ex art. 2341-bis c.c., dal piano sociale, e valuta l\'esercizio dell\'azione di responsabilità ex artt. 2392 e 2476 c.c., considerando la business judgment rule.',
         'profilo' => 'Il punto qualificante è il confine della business judgment rule: l\'amministratore risponde del metodo della decisione, non dell\'esito economico sfavorevole in sé.',
         'lezione' => 'Nei rapporti societari conviene presidiare per iscritto governance e doveri, perché è su quei parametri che si misura la responsabilità.',
         'riferimento' => 'Il principio è consolidato in giurisprudenza: cfr. <em>Cass. SS.UU. n. 27993/2018</em>, in tema di natura contrattuale dell\'azione sociale di responsabilità verso l\'amministratore, con il conseguente riparto dell\'onere probatorio che addossa al gestore la prova liberatoria di aver agito diligentemente.'],

        ['slug' => 'infortunistica-offerta-incongrua', 'area' => 'Infortunistica e Malasanità', 'title' => 'Sinistro stradale con offerta assicurativa incongrua',
         'contesto' => 'Ipotizziamo che il Sig. NERI, investito mentre attraversava la strada o coinvolto in una collisione, abbia riportato la frattura di un arto con necessità di intervento chirurgico e di un lungo percorso riabilitativo, residuandone postumi permanenti. A guarigione clinica avvenuta, l\'assicurazione del responsabile gli formula un\'offerta risarcitoria che egli reputa non proporzionata né all\'invalidità accertata né al periodo di inabilità sofferto.',
         'approccio' => 'In una situazione simile si attiva la procedura prevista dal Codice delle assicurazioni private (D.Lgs. 209/2005), con richiesta di risarcimento corredata della documentazione clinica e di una valutazione medico-legale di parte, per poi valutare l\'azione giudiziale ove l\'offerta resti incongrua. La quantificazione muove dalle voci del danno biologico permanente e temporaneo, patrimoniale e morale, secondo le pertinenti tabelle.',
         'profilo' => 'Centrale è l\'accertamento del nesso causale e la prova del danno mediante perizia, che costituisce il fondamento tecnico della pretesa.',
         'lezione' => 'Una prima offerta non è un punto di arrivo: la sua congruità si valuta solo su basi medico-legali documentate.',
         'riferimento' => 'Il principio è consolidato in giurisprudenza: cfr. <em>Cass. SS.UU. n. 581/2008</em>, che governa l\'accertamento del nesso causale in sede civile secondo il criterio del «più probabile che non»; quanto alla liquidazione del danno biologico secondo le Tabelle di Milano si veda, nella giurisprudenza di merito del distretto, <em>Trib. Trani n. 572/2026</em>.'],

        ['slug' => 'lavoro-impugnazione-licenziamento', 'area' => 'Diritto del Lavoro', 'title' => 'Impugnazione del licenziamento',
         'contesto' => 'Si consideri il caso ipotetico della Sig.ra GIALLI, impiegata da diversi anni presso la medesima azienda, che riceva una lettera di licenziamento motivata con ragioni a suo avviso pretestuose o sproporzionate rispetto ai fatti contestati. Convinta dell\'ingiustizia del provvedimento e preoccupata per la perdita della retribuzione, ella intende contestarne tempestivamente la legittimità.',
         'approccio' => 'In uno scenario di questo tipo l\'impostazione muove dall\'impugnazione stragiudiziale entro sessanta giorni e dal successivo deposito del ricorso entro centottanta giorni, secondo i termini di decadenza dell\'art. 6 L. 604/1966, individuando il regime sanzionatorio applicabile fra art. 18 St. lav. e D.Lgs. 23/2015.',
         'profilo' => 'L\'aspetto più delicato è la duplice decadenza: il mancato rispetto anche di uno solo dei due termini preclude l\'azione, a prescindere dal merito.',
         'lezione' => 'Nel licenziamento il calendario conta quanto le ragioni: la prima difesa è non lasciar maturare le decadenze.',
         'riferimento' => 'Sul regime sanzionatorio applicabile è di riferimento <em>Corte cost. n. 194/2018</em>, che ha dichiarato l\'illegittimità del meccanismo di liquidazione dell\'indennità ancorato in via automatica alla sola anzianità di servizio nel contratto a tutele crescenti, restituendo al giudice la valutazione equitativa del risarcimento.'],

        ['slug' => 'tributario-avviso-accertamento', 'area' => 'Diritto Tributario', 'title' => 'Ricorso avverso avviso di accertamento',
         'contesto' => 'Ipotizziamo che la Gamma S.n.c., piccola impresa a conduzione familiare, si veda notificare un avviso di accertamento con cui l\'Amministrazione finanziaria, muovendo da scostamenti rispetto agli indici di settore e da movimentazioni bancarie ritenute non giustificate, rettifica i redditi dichiarati e presume l\'esistenza di ricavi occulti, con ripresa a tassazione e applicazione di sanzioni.',
         'approccio' => 'In una vicenda simile si verifica il termine di sessanta giorni per proporre ricorso ex art. 21 D.Lgs. 546/1992 dinanzi alla Corte di giustizia tributaria, esaminando i vizi propri dell\'atto (difetto di motivazione, contraddittorio preventivo ex art. 6-bis L. 212/2000) e valutando gli strumenti deflattivi.',
         'profilo' => 'Rileva la tenuta delle presunzioni poste a base dell\'accertamento, che devono possedere i requisiti di gravità, precisione e concordanza.',
         'lezione' => 'Un accertamento si contesta su due fronti, la forma dell\'atto e la solidità della prova presuntiva, entro termini rigorosi.',
         'riferimento' => 'Sul contraddittorio preventivo è di riferimento <em>Cass. SS.UU. n. 24823/2015</em>, che ne delineò i confini nel regime previgente; l\'obbligo è oggi generalizzato dall\'art. 6-bis L. 212/2000, introdotto dalla riforma dello Statuto del contribuente.'],

        ['slug' => 'ip-opposizione-marchio-euipo', 'area' => 'Proprietà Intellettuale', 'title' => 'Opposizione a un marchio dell\'Unione europea in sede EUIPO',
         'contesto' => 'Si consideri il caso ipotetico del titolare del marchio anteriore "Loripina", consolidato sul mercato per una determinata categoria di prodotti, che nel monitorare il bollettino dei marchi si avveda della pubblicazione di una domanda di marchio dell\'Unione europea dal segno assai simile, depositata per prodotti affini da un richiedente operante in area ispanofona, con conseguente timore di sviamento della clientela.',
         'approccio' => 'In uno scenario di questo tipo si propone opposizione dinanzi all\'EUIPO entro il termine di tre mesi dalla pubblicazione ex art. 46 Reg. UE 2017/1001, fondandola sul rischio di confusione ex art. 8, par. 1, lett. b). L\'impostazione cura la comparazione fra segni e prodotti, la prova dell\'uso e il deposito di memorie di replica, gestendo le traduzioni in spagnolo nel rispetto del regime linguistico.',
         'profilo' => 'L\'elemento più istruttivo è la valutazione globale del rischio di confusione, che impone di apprezzare congiuntamente somiglianza dei segni, affinità merceologica e carattere distintivo del marchio anteriore.',
         'lezione' => 'Difendere un marchio in sede europea richiede rigore comparativo, padronanza del regime linguistico e gestione puntuale dei termini procedurali.'],

        ['slug' => 'bancario-anatocismo-usura', 'area' => 'Diritto Bancario', 'title' => 'Anatocismo e usura su mutuo',
         'contesto' => 'Ipotizziamo che il Sig. BIANCHI, che alcuni anni addietro aveva acceso un mutuo per l\'acquisto della casa, si accorga, confrontando le rate effettivamente pagate con il piano di ammortamento iniziale, di un costo del finanziamento più elevato del previsto, e sospetti che il rapporto sia gravato da addebiti illegittimi per effetto di anatocismo o del superamento del tasso-soglia usurario.',
         'approccio' => 'In una situazione simile l\'analisi muove dall\'acquisizione della documentazione contrattuale e dei piani di ammortamento, per sottoporli a perizia econometrica volta a verificare il rispetto della L. 108/1996 e dell\'art. 644 c.p. nonché il divieto di anatocismo ex art. 1283 c.c., valutando l\'azione di ripetizione dell\'indebito ex art. 2033 c.c.',
         'profilo' => 'Il fulcro è la perizia tecnica, poiché la fondatezza della contestazione dipende dal corretto calcolo del costo effettivo del finanziamento e dal confronto con i parametri normativi.',
         'lezione' => 'Nei rapporti bancari le ragioni si dimostrano con i numeri: senza una verifica tecnica documentata la contestazione resta un\'ipotesi.',
         'riferimento' => 'In tema di anatocismo bancario è di riferimento <em>Cass. SS.UU. n. 24418/2010</em>, in punto di illegittimità della capitalizzazione degli interessi e di disciplina della ripetizione delle somme indebitamente addebitate sul conto.'],

        ['slug' => 'internazionale-foro-competente', 'area' => 'Internazionale Privato', 'title' => 'Contratto cross-border e foro competente',
         'contesto' => 'Si consideri il caso ipotetico della Delta S.r.l., impresa italiana che, sulla base di una corrispondenza commerciale e di condizioni generali mai discusse in dettaglio, abbia stipulato un contratto di fornitura con una società avente sede in altro Stato dell\'Unione europea. A fronte di una merce consegnata in ritardo e difforme, e di pagamenti rimasti insoluti, l\'impresa deve agire per l\'inadempimento della controparte estera e si interroga su quale giudice possa adire.',
         'approccio' => 'In uno scenario di questo tipo l\'analisi muove dall\'individuazione del giudice competente secondo il Reg. UE 1215/2012 (Bruxelles I-bis), verificando una valida clausola di proroga ex art. 25 e, in difetto, il foro speciale del luogo di esecuzione ex art. 7 n. 1; parallelamente si determina la legge applicabile secondo il Reg. Roma I.',
         'profilo' => 'L\'aspetto qualificante è la netta distinzione fra giurisdizione e legge applicabile, governate da regolamenti diversi e da criteri non sovrapponibili.',
         'lezione' => 'Nelle controversie transfrontaliere la prima partita si gioca su giurisdizione e legge applicabile, da definire prima ancora del merito.'],

        ['slug' => 'previdenza-invalidita-negata', 'area' => 'Diritto Previdenziale', 'title' => 'Ricorso per invalidità civile negata',
         'contesto' => 'Ipotizziamo che il Sig. NERI, affetto da una patologia invalidante che ne ha progressivamente ridotto l\'autonomia e la capacità lavorativa, riceva un verbale con cui la competente commissione medica gli riconosce una percentuale di invalidità inferiore alla soglia utile alle provvidenze, o gliela nega del tutto, in apparente contrasto con la documentazione clinica in suo possesso.',
         'approccio' => 'In una vicenda simile l\'impostazione muove dall\'esame del verbale sanitario e dalla raccolta della documentazione clinica, per promuovere l\'accertamento tecnico preventivo obbligatorio ex art. 445-bis c.p.c., con valutazione della corrispondenza fra patologie e percentuali tabellari tramite il consulente di parte.',
         'profilo' => 'Il punto centrale è l\'accertamento tecnico preventivo, che concentra la controversia sull\'aspetto medico-legale e ne condiziona l\'esito.',
         'lezione' => 'Un diniego sanitario non è definitivo: si supera con una documentazione clinica solida e una verifica peritale ben presidiata.'],

        ['slug' => 'noprofit-ets-runts', 'area' => 'No Profit / Terzo Settore', 'title' => 'Costituzione di un ETS e iscrizione al RUNTS',
         'contesto' => 'Si consideri il caso ipotetico di un gruppo di volontari che, dopo aver per qualche tempo operato in forma spontanea sul territorio a sostegno di persone fragili, intenda dotarsi di una veste giuridica stabile costituendo un\'associazione per finalità di utilità sociale, così da poter stipulare convenzioni, raccogliere fondi e accedere alle agevolazioni proprie dell\'ente del Terzo settore.',
         'approccio' => 'In uno scenario di questo tipo l\'impostazione muove dalla redazione di atto costitutivo e statuto conformi al Codice del Terzo settore (D.Lgs. 117/2017), con clausole su finalità civiche e solidaristiche, assenza di scopo di lucro e devoluzione del patrimonio, in vista dell\'iscrizione al RUNTS e della scelta della qualifica più adeguata.',
         'profilo' => 'L\'elemento qualificante è la redazione statutaria, poiché l\'iscrizione al RUNTS e l\'accesso ai benefici dipendono dalla puntuale conformità delle clausole ai requisiti di legge.',
         'lezione' => 'Nel Terzo settore la forma è sostanza: uno statuto ben costruito è la condizione per qualifica, agevolazioni e operatività dell\'ente.'],
    ];
}

/**
 * Seed dei casi studio come BOZZE. Eseguito dal seeder generale.
 */
function lanotte_seed_casi_studio() {
    if (!post_type_exists('caso')) return 0;
    $count = 0;
    foreach (lanotte_casi_studio_data() as $i => $c) {
        if (get_page_by_path($c['slug'], OBJECT, 'caso')) continue; // già presente
        $html  = '<h2>Il contesto</h2>' . "\n" . '<p>' . $c['contesto'] . '</p>' . "\n\n";
        $html .= '<h2>L\'approccio dello Studio</h2>' . "\n" . '<p>' . $c['approccio'] . '</p>' . "\n\n";
        $html .= '<h2>Il profilo tecnico</h2>' . "\n" . '<p>' . $c['profilo'] . '</p>' . "\n\n";
        $html .= '<h2>Cosa se ne ricava</h2>' . "\n" . '<p>' . $c['lezione'] . '</p>';
        if (!empty($c['riferimento'])) {
            $html .= "\n\n" . '<h2>Riferimento giurisprudenziale</h2>' . "\n" . '<p>' . $c['riferimento'] . '</p>';
        }
        $post_id = wp_insert_post([
            'post_type'    => 'caso',
            'post_status'  => 'draft', // BOZZA: l'avvocato rilegge e pubblica
            'post_title'   => $c['title'],
            'post_name'    => $c['slug'],
            'post_content' => $html,
            'post_excerpt' => $c['contesto'],
            'menu_order'   => $i + 1,
        ]);
        if (is_wp_error($post_id) || !$post_id) continue;
        // Tassonomia area
        if (taxonomy_exists('caso_area')) {
            wp_set_object_terms($post_id, $c['area'], 'caso_area');
        }
        $count++;
    }
    return $count;
}
