<?php
// Dati aree estratti dal sito live - per integrazione in seed-data.php
// Sorgente: https://www.studiolegalelanotte.it/aree-di-competenza/...
// Estratti il 2026-05-27 - 13 aree, contenuti sintetizzati e arricchiti con riferimenti normativi

return [

    'diritto-penale' => [
        'lead' => 'Difesa dell\'indagato, dell\'imputato e tutela della persona offesa in ogni fase del procedimento penale, dalle indagini preliminari al giudizio d\'appello; per la fase di legittimità lo Studio si avvale della collaborazione di penalisti cassazionisti.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste l\'indagato sin dalle prime attività di indagine, garantendo la presenza del difensore negli interrogatori, nelle perquisizioni e nei sequestri, nonché nell\'eventuale incidente probatorio. La strategia difensiva è costruita sull\'esame del fascicolo del pubblico ministero, sull\'analisi delle prove a carico e sull\'individuazione tempestiva degli elementi a discarico. In sede dibattimentale lo Studio cura l\'esame e il controesame dei testimoni, la formulazione delle eccezioni di rito e di merito, la discussione finale. Particolare attenzione è riservata alla difesa della persona offesa attraverso la costituzione di parte civile e la quantificazione del danno risarcibile.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Reati contro la persona (lesioni, minacce, atti persecutori, maltrattamenti in famiglia)</li><li>Reati contro il patrimonio (furto, truffa, appropriazione indebita, ricettazione)</li><li>Reati colposi (omicidio e lesioni stradali, infortuni sul lavoro)</li><li>Reati informatici e in materia di privacy</li><li>Reati tributari e fallimentari</li><li>Misure cautelari personali e reali, riesame e appello cautelare</li><li>Esecuzione penale, misure alternative alla detenzione</li><li>Difesa innanzi al Giudice di Pace penale</li></ul>',
            ],
            [
                'h' => 'Procedimenti speciali',
                'body' => '<p>Lo Studio fornisce assistenza nei riti speciali (giudizio abbreviato, applicazione della pena su richiesta, decreto penale di condanna, sospensione del procedimento con messa alla prova), valutando in concreto la convenienza processuale di ciascuna opzione e il relativo trattamento sanzionatorio.</p>',
            ],
            [
                'h' => 'Tempistica e primo colloquio',
                'body' => '<p>Nei procedimenti penali il tempo è un elemento decisivo. Si raccomanda di contattare lo Studio non appena si abbia notizia dell\'iscrizione nel registro degli indagati o dell\'attivazione di un procedimento. Il primo colloquio è coperto da segreto professionale anche in caso di mancato conferimento dell\'incarico.</p>',
            ],
            [
                'h' => 'Assistenza nella fase iniziale: indagini, perquisizioni, sequestri',
                'body' => '<p>Quando una persona riceve un invito a comparire, un avviso di garanzia, un decreto di perquisizione o un sequestro, la prima valutazione deve essere tempestiva e documentata. Lo Studio assiste indagati, imputati e persone offese nella fase delle indagini preliminari, curando l\'analisi degli atti disponibili, la verifica della regolarità delle notifiche e l\'impostazione della linea difensiva nel rispetto della presunzione di innocenza.</p>',
            ],
            [
                'h' => 'Le fasi del procedimento penale e i tempi della difesa',
                'body' => '<p>La difesa tecnica non comincia con il processo: comincia con la notizia di reato. Lo Studio segue l\'assistito dall\'iscrizione nel registro ex art. 335 c.p.p. fino all\'eventuale giudizio di cassazione, articolando l\'attività secondo la fase: indagini preliminari (interrogatorio, memorie ex art. 415-bis c.p.p., investigazioni difensive ex artt. 391-bis ss. c.p.p.), udienza preliminare, dibattimento ordinario o riti alternativi (giudizio abbreviato, applicazione della pena ex art. 444 c.p.p., decreto penale, messa alla prova ex art. 168-bis c.p.). Ogni fase richiede scelte strategiche che incidono in modo irreversibile sul prosieguo: una memoria tempestiva, un\'investigazione difensiva ben documentata o l\'esercizio della facoltà di non rispondere possono modificare radicalmente l\'esito del giudizio.</p>',
            ],
            [
                'h' => 'Misure cautelari personali e impugnazioni de libertate',
                'body' => '<p>Le misure cautelari personali (arresti domiciliari, custodia in carcere, divieto di dimora, allontanamento dalla casa familiare, obbligo di firma) incidono sui diritti fondamentali e richiedono una difesa immediata. Lo Studio assiste l\'indagato e l\'imputato nella richiesta di riesame ex art. 309 c.p.p., nell\'appello cautelare ex art. 310 c.p.p. e nel ricorso per cassazione ex art. 311 c.p.p., nonché nelle istanze di sostituzione, attenuazione o revoca della misura.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Ho ricevuto un avviso di garanzia: devo rispondere subito?', 'a' => 'Non sempre. È necessario prima esaminare l\'atto, comprendere il reato contestato e valutare se rendere dichiarazioni, depositare memorie o attendere ulteriori sviluppi.'],
            ['q' => 'Sono indagato: devo presentarmi spontaneamente al Pubblico Ministero?', 'a' => 'La scelta è strategica e va valutata con il difensore. L\'art. 374 c.p.p. consente la presentazione spontanea, ma il momento e le modalità incidono sulla difesa successiva. Prima di rendere dichiarazioni è opportuno acquisire copia del fascicolo accessibile e ponderare l\'opportunità di avvalersi della facoltà di non rispondere ex art. 64 c.p.p.'],
            ['q' => 'Cosa cambia con la Riforma Cartabia (D.lgs. 150/2022) per la difesa penale?', 'a' => 'La riforma ha ampliato la procedibilità a querela per molti reati, esteso la messa alla prova anche su iniziativa del Pubblico Ministero, rafforzato i riti alternativi e introdotto l\'improcedibilità per superamento dei termini del giudizio di impugnazione. Sono leve difensive da valutare caso per caso.'],
            ['q' => 'Cos\'è l\'investigazione difensiva e quando è opportuna?', 'a' => 'Le investigazioni difensive ex artt. 391-bis ss. c.p.p. consentono al difensore di acquisire dichiarazioni, documenti e rilievi tecnici da utilizzare nel procedimento. Sono utili nei reati fondati sulla prova testimoniale o tecnica e possono essere depositate nel fascicolo del difensore con efficacia probatoria.'],
            ['q' => 'Posso essere assistito anche nella fase di esecuzione della pena?', 'a' => 'Sì. La difesa prosegue innanzi al Magistrato e al Tribunale di sorveglianza per affidamento in prova, detenzione domiciliare, semilibertà, liberazione anticipata e permessi premio, nonché nei procedimenti di esecuzione, compresa la giustizia riparativa ex Titolo IV del D.lgs. 150/2022.'],
            ['q' => 'Quando conviene costituirsi parte civile?', 'a' => 'Quando dal reato deriva un danno patrimoniale o non patrimoniale e vi sono elementi sufficienti per chiederne il risarcimento nel processo penale.'],
        ],
    ],

    'diritto-civile' => [
        'lead' => 'Consulenza preventiva, assistenza stragiudiziale e patrocinio nel contenzioso civile innanzi al Giudice di Pace, al Tribunale di Trani e alla Corte d\'Appello di Bari; per la fase di legittimità lo Studio si avvale della collaborazione di civilisti cassazionisti.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>L\'area civile costituisce il nucleo storico dell\'attività dello Studio. La prassi quotidiana spazia dalle obbligazioni e dai contratti alla responsabilità extracontrattuale, dal diritto delle locazioni al recupero del credito, dalla tutela del consumatore alle controversie in materia di servizi e forniture. Particolare cura è riservata alla redazione e alla revisione dei contratti, alla composizione stragiudiziale delle controversie attraverso lo strumento della mediazione e della negoziazione assistita, e alla predisposizione di atti giudiziali conformi ai requisiti di sinteticità e chiarezza imposti dal D.M. n. 110/2023.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Obbligazioni, contratti, inadempimento e risoluzione</li><li>Recupero crediti: decreti ingiuntivi, opposizioni ed esecuzioni forzate</li><li>Locazioni ad uso abitativo e commerciale, sfratti, morosità</li><li>Tutela del consumatore e clausole vessatorie</li><li>Responsabilità contrattuale ed extracontrattuale</li><li>Diritti reali, comunione, usucapione, servitù</li><li>Mediazione civile e negoziazione assistita</li><li>Procedimenti monitori e sommari di cognizione</li></ul>',
            ],
            [
                'h' => 'Il rito civile dopo la Riforma Cartabia',
                'body' => '<p>Lo Studio aggiorna costantemente la propria pratica alle modifiche introdotte dal D.lgs. n. 149/2022 in materia di processo civile, con particolare attenzione al procedimento semplificato di cognizione, all\'udienza di trattazione e al regime delle preclusioni nel rinnovato art. 171-ter c.p.c.</p>',
            ],
            [
                'h' => 'Strumenti deflattivi',
                'body' => '<p>Prima di intraprendere un\'azione giudiziale lo Studio valuta sempre la praticabilità degli strumenti deflattivi: mediazione obbligatoria, negoziazione assistita, transazione.</p>',
            ],
            [
                'h' => 'Recupero del credito: dalla diffida all\'esecuzione forzata',
                'body' => '<p>Lo Studio segue imprese e privati nelle controversie patrimoniali secondo un percorso a tre tappe. La fase stragiudiziale si avvia con diffida ad adempiere mediante PEC o raccomandata e, ove dovuto, con mediazione obbligatoria ex art. 5 D.lgs. 28/2010 o negoziazione assistita ex D.L. 132/2014. La fase monitoria si articola con ricorso per decreto ingiuntivo ex artt. 633 ss. c.p.c., con eventuale provvisoria esecutività ex art. 642 c.p.c. La fase esecutiva comprende il pignoramento mobiliare, immobiliare e presso terzi, l\'azione revocatoria ex art. 2901 c.c. e l\'azione surrogatoria ex art. 2900 c.c. quando il debitore sottrae beni alla garanzia patrimoniale.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Prima di iniziare una causa civile è utile inviare una diffida?', 'a' => 'Spesso sì. Una diffida ben redatta può chiarire le contestazioni, interrompere la prescrizione e favorire una soluzione stragiudiziale.'],
            ['q' => 'Quando è obbligatoria la mediazione prima di una causa civile?', 'a' => 'La mediazione è condizione di procedibilità per le materie dell\'art. 5 D.lgs. 28/2010 (come modif. dal D.lgs. 149/2022): condominio, diritti reali, divisione, successioni, patti di famiglia, locazione, comodato, affitto d\'azienda, responsabilità medica e sanitaria, diffamazione a mezzo stampa, contratti assicurativi, bancari e finanziari e altre. Il mancato esperimento determina improcedibilità.'],
            ['q' => 'Quanto tempo ho per recuperare un credito prima che si prescriva?', 'a' => 'La regola generale è la prescrizione decennale ex art. 2946 c.c., con numerose ipotesi brevi: cinque anni per i crediti periodici ex art. 2948 c.c., tre anni per le prestazioni professionali, un anno per vettore e mediatore. Servono atti interruttivi tempestivi ex art. 2943 c.c. con riferimento specifico al credito.'],
            ['q' => 'Devo per forza fare causa o esistono alternative?', 'a' => 'Il contenzioso è una delle opzioni. Lo Studio valuta la praticabilità di negoziazione assistita, mediazione, arbitrato e convenzione di assistenza tecnica, scegliendo lo strumento più coerente con l\'obiettivo, i tempi di recupero stimati e la consistenza patrimoniale della controparte.'],
            ['q' => 'È possibile avere un parere scritto prima di agire?', 'a' => 'Sì. Il parere scritto consente di valutare documenti, rischi e possibili strategie prima di assumere iniziative.'],
        ],
    ],

    'famiglia-successioni' => [
        'lead' => 'Una delle materie più delicate dello Studio, in cui la dimensione tecnica si intreccia con i rapporti personali. Riservatezza assoluta e attenzione preminente alla tutela dei minori e delle persone più fragili.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste i propri clienti nelle procedure di separazione personale dei coniugi, di divorzio e di modifica delle condizioni, sia nella forma consensuale sia in quella giudiziale. Si privilegia, ove possibile, la soluzione concordata, che consente di ridurre i tempi e di preservare i rapporti residui tra le parti, in particolare nell\'interesse dei figli minori. L\'attività si estende ai procedimenti relativi alla responsabilità genitoriale, all\'affidamento dei figli, alla determinazione dell\'assegno di mantenimento per il coniuge e per i figli e alle questioni relative alla casa familiare.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Separazione personale dei coniugi, consensuale e giudiziale</li><li>Divorzio congiunto e contenzioso</li><li>Negoziazione assistita in materia familiare</li><li>Modifica delle condizioni di separazione e divorzio</li><li>Affidamento dei figli e regolamentazione del diritto di visita</li><li>Mantenimento del coniuge e dei figli</li><li>Unioni civili e convivenze di fatto (L. 76/2016)</li><li>Tribunale per i minorenni e procedimenti de potestate</li><li>Successione legittima e testamentaria; azioni di riduzione e collazione; divisioni ereditarie</li></ul>',
            ],
            [
                'h' => 'Tutela dei minori',
                'body' => '<p>Nelle controversie che coinvolgono figli minori lo Studio privilegia un approccio collaborativo, valuta l\'opportunità del ricorso alla mediazione familiare e mantiene costante il dialogo con il coordinatore genitoriale ove nominato.</p>',
            ],
            [
                'h' => 'Primo colloquio',
                'body' => '<p>In materia familiare il primo colloquio è dedicato all\'ascolto e alla valutazione delle alternative percorribili, prima di qualunque atto formale.</p>',
            ],
            [
                'h' => 'Separazione e divorzio: rito unitario, congiunto e negoziazione assistita',
                'body' => '<p>Dall\'entrata in vigore della Riforma Cartabia (D.lgs. 149/2022) le procedure di separazione e divorzio possono essere proposte con ricorso unico ai sensi degli artt. 473-bis e ss. c.p.c., consentendo di unificare separazione, divorzio e regolamentazione dei rapporti con i figli, anche non coniugali. Lo Studio assiste entrambi i coniugi nei procedimenti contenziosi e congiunti, nella negoziazione assistita familiare ex art. 6 D.L. 132/2014 e nelle separazioni/divorzi davanti all\'ufficiale di stato civile (art. 12), quando ne sussistono i presupposti (assenza di figli minori, maggiorenni non autosufficienti o con disabilità grave; assenza di patti di trasferimento patrimoniale).</p>',
            ],
            [
                'h' => 'Pianificazione successoria e tutela del patrimonio familiare',
                'body' => '<p>La pianificazione successoria non è solo redazione del testamento. Lo Studio assiste nella valutazione integrata degli strumenti civilistici e fiscali: testamento olografo, pubblico e segreto (artt. 601 ss. c.c.), patto di famiglia ex artt. 768-bis ss. c.c. per il trasferimento generazionale dell\'azienda o delle partecipazioni, donazioni con effetti sulla legittima (artt. 553 ss. c.c.), fondo patrimoniale ex artt. 167 ss. c.c., trust regolato dalla Convenzione dell\'Aja del 1985, polizze vita e vincoli di destinazione ex art. 2645-ter c.c. Per le successioni internazionali si applica il Reg. UE 650/2012 (legge applicabile, professio iuris, certificato successorio europeo).</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Posso ottenere separazione o divorzio davanti all\'Ufficiale di Stato Civile?', 'a' => 'Sì, ex art. 12 D.L. 132/2014, ma a condizioni rigorose: assenza di figli minorenni, maggiorenni non autosufficienti o con handicap grave, e assenza di trasferimenti patrimoniali (l\'assegno periodico non rientra nel divieto). Richiede comunque la consulenza preventiva di un legale.'],
            ['q' => 'In una separazione si può modificare l\'assegno già stabilito?', 'a' => 'Sì, se sopravvengono fatti nuovi e rilevanti, come variazioni reddituali, nuove esigenze dei figli o mutamenti della situazione abitativa.'],
            ['q' => 'Cosa succede ai diritti successori del coniuge separato?', 'a' => 'Il coniuge separato senza addebito conserva i diritti successori ex artt. 565 e 581 c.c., compresa la legittima ex art. 540 c.c. Il coniuge separato con addebito ha diritto solo a un assegno vitalizio ex art. 548 c.c. se godeva degli alimenti. Con il divorzio si estinguono i diritti successori.'],
            ['q' => 'Il testamento olografo scritto al computer e firmato a mano è valido?', 'a' => 'No. L\'art. 602 c.c. richiede che sia interamente scritto, datato e sottoscritto di pugno dal testatore. La scrittura meccanica determina la nullità: in tali casi è opportuno il testamento pubblico ex art. 603 c.c. davanti al notaio.'],
            ['q' => 'Mio padre ha donato un immobile a un solo figlio: posso contestare dopo la morte?', 'a' => 'L\'azione di riduzione (artt. 553 ss. c.c.) consente ai legittimari lesi di reintegrare la quota aggredendo le donazioni in vita; si prescrive in dieci anni dall\'accettazione dell\'eredità da parte del beneficiario. Va distinta dall\'azione di restituzione contro i terzi acquirenti ex art. 563 c.c.'],
            ['q' => 'Se un coerede occupa un immobile ereditario, cosa si può fare?', 'a' => 'È possibile chiedere una regolamentazione dell\'uso, un\'indennità o avviare le iniziative per la divisione, previa valutazione dei titoli e della situazione possessoria.'],
        ],
    ],

    'condominio' => [
        'lead' => 'Consulenza e assistenza giudiziale a condomìni, amministratori e singoli condòmini in tutte le controversie relative alle parti comuni, alle delibere assembleari e alla gestione del fabbricato.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio collabora stabilmente con amministratori di condominio del territorio, fornendo consulenza giuridica continuativa, assistenza alle assemblee e patrocinio nelle controversie civili. Particolare attenzione è dedicata alla mediazione obbligatoria, condizione di procedibilità per le controversie in materia di condominio ai sensi dell\'art. 5 del D.lgs. n. 28/2010, e al recupero giudiziale delle quote condominiali insolute mediante decreto ingiuntivo provvisoriamente esecutivo ex art. 63 disp. att. c.c.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Impugnazione delle delibere assembleari (art. 1137 c.c.)</li><li>Recupero quote condominiali con decreto ingiuntivo ex art. 63 disp. att.</li><li>Controversie sulle parti comuni (lastrici, facciate, scale, ascensori)</li><li>Opere innovative, sopraelevazioni, modifiche d\'uso</li><li>Distacco dall\'impianto centralizzato di riscaldamento</li><li>Regolamento di condominio: predisposizione, modifica, interpretazione</li><li>Nomina, revoca e responsabilità dell\'amministratore</li><li>Mediazione obbligatoria in materia condominiale</li><li>Rapporti di vicinato, immissioni, distanze, servitù</li></ul>',
            ],
            [
                'h' => 'Collaborazione con Condominiocasa',
                'body' => '<p>L\'attività in materia condominiale beneficia della collaborazione con lo Studio di Amministrazione Condominiale «Condominiocasa», curato dalla Dott.ssa Cristina DE LILLO, che consente di affiancare alla difesa legale una gestione tecnico-amministrativa professionale del fabbricato.</p>',
            ],
            [
                'h' => 'Mediazione obbligatoria',
                'body' => '<p>Prima di promuovere il giudizio in materia condominiale è necessario esperire il procedimento di mediazione presso un Organismo accreditato. Lo Studio assiste il cliente in tutte le fasi.</p>',
            ],
            [
                'h' => 'Impugnazione delle delibere assembleari: termini, legittimazione, vizi',
                'body' => '<p>L\'impugnazione ex art. 1137 c.c. ha termini perentori: trenta giorni dalla deliberazione per dissenzienti e astenuti, dalla comunicazione per gli assenti. La giurisprudenza distingue le delibere nulle (assenza di oggetto, oggetto impossibile o illecito, mancata convocazione, materie estranee alla competenza assembleare ex art. 1135 c.c.) — impugnabili senza limiti di tempo — dalle delibere annullabili (vizi di convocazione, costituzione, voto), soggette al termine breve. Lo Studio assiste nella scelta tra impugnazione, mediazione obbligatoria e ricorso al giudice competente in funzione del valore e dell\'oggetto.</p>',
            ],
            [
                'h' => 'Lavori straordinari, superbonus e responsabilità dell\'amministratore',
                'body' => '<p>I bonus edilizi hanno generato notevole contenzioso: validità delle delibere ex art. 119, comma 9-bis, D.L. 34/2020 (maggioranze agevolate), responsabilità di amministratore e impresa per vizi e ritardi, cessione del credito e sconto in fattura, riparto delle spese tra condòmini non aderenti. Lo Studio assiste condòmini e amministratori nelle controversie su affidamenti, recesso, escussione delle garanzie e azioni di responsabilità ex art. 1130-bis c.c.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Quanto tempo ho per impugnare una delibera condominiale?', 'a' => 'Per le delibere annullabili il termine è di 30 giorni ex art. 1137 c.c., con decorrenza dalla deliberazione per dissenzienti e astenuti e dalla comunicazione per gli assenti. Le delibere nulle (oggetto impossibile o illecito, mancata convocazione, materie estranee alla competenza assembleare) sono impugnabili senza limiti di tempo.'],
            ['q' => 'Chi paga le spese legali se il condominio agisce in giudizio?', 'a' => 'Le spese gravano sul condominio secondo i millesimi (art. 1123 c.c.), salvo che la delibera autorizzativa, in materia eccedente l\'ordinaria amministrazione, sia stata adottata senza la maggioranza ex art. 1136 c.c. Il condòmino dissenziente o assente può, in alcune ipotesi, sottrarsi alle spese del giudizio successivo ex art. 1132 c.c.'],
            ['q' => 'Posso chiedere al condominio i danni da infiltrazioni dalle parti comuni?', 'a' => 'Sì. Le parti comuni sono custodite dal condominio ex art. 2051 c.c., con responsabilità oggettiva. È risarcibile il danno patrimoniale e, ove provato, non patrimoniale. Per il lastrico solare in uso esclusivo si applica Cass. S.U. 9449/2016 (un terzo al titolare dell\'uso, due terzi al condominio).'],
            ['q' => 'L\'amministratore può fare causa senza autorizzazione dell\'assemblea?', 'a' => 'Per gli atti rientranti nelle attribuzioni ex art. 1130 c.c. (riscossione contributi, manutenzione ordinaria, atti conservativi) la legittimazione sussiste senza delibera. Per le controversie eccedenti l\'ordinaria amministrazione è necessaria l\'autorizzazione assembleare, a pena di inefficacia del mandato.'],
            ['q' => 'Si può derogare al criterio millesimale di ripartizione delle spese?', 'a' => 'Sì, ma solo con il consenso unanime dei condòmini, in delibera o regolamento contrattuale. Le sole tabelle ricognitive possono essere approvate o modificate a maggioranza ex art. 1136, comma 2, c.c., come chiarito da Cass. S.U. 18477/2010.'],
            ['q' => 'Posso oppormi a un decreto ingiuntivo per spese condominiali?', 'a' => 'Sì, ma occorre verificare titolo, delibera, riparto, approvazione del consuntivo o preventivo e i termini di opposizione.'],
        ],
    ],

    'impresa' => [
        'lead' => 'Assistenza alle imprese di ogni dimensione, dalla costituzione societaria alla contrattualistica commerciale, dalla gestione del contenzioso ordinario alla composizione delle crisi.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste l\'imprenditore in tutte le fasi della vita dell\'impresa: scelta della forma giuridica, redazione dello statuto e dei patti parasociali, operazioni straordinarie (conferimenti, trasformazioni, fusioni, scissioni), gestione delle assemblee e delle delibere, controversie tra soci. Particolare cura è dedicata alla predisposizione e alla negoziazione dei contratti commerciali, con clausole adeguate al diritto applicabile, anche in contesti transfrontalieri.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Costituzione e modifica di società di persone e di capitali</li><li>Patti parasociali, sindacati di voto e di blocco</li><li>Operazioni straordinarie: fusioni, scissioni, trasformazioni</li><li>Contrattualistica commerciale italiana e cross-border</li><li>Contratti di distribuzione, agenzia, franchising</li><li>Responsabilità degli amministratori e dei sindaci</li><li>Recupero crediti commerciali e contenzioso d\'impresa</li><li>Crisi d\'impresa e procedure di composizione negoziata (D.lgs. 14/2019)</li></ul>',
            ],
            [
                'h' => 'Codice della crisi',
                'body' => '<p>Lo Studio offre assistenza nella valutazione preventiva degli indicatori di crisi previsti dal Codice della crisi d\'impresa e dell\'insolvenza (D.lgs. 14/2019 e successive modifiche), nella composizione negoziata, nella predisposizione di piani attestati di risanamento e di accordi di ristrutturazione.</p>',
            ],
            [
                'h' => 'Governance e tutela degli asset aziendali',
                'body' => '<p>Dal singolo accordo commerciale alle operazioni straordinarie, affianchiamo l\'impresa per garantire che ogni scelta strategica sia giuridicamente solida. Curiamo la redazione di patti parasociali, contratti di rete e accordi di riservatezza (NDA), lavorando in sinergia con le competenze dello Studio in materia di proprietà intellettuale per valorizzare e proteggere il know-how e gli asset intangibili aziendali.</p>',
            ],
            [
                'h' => 'Consulenza continuativa',
                'body' => '<p>Per le imprese che lo richiedano lo Studio attiva un rapporto di consulenza continuativa, con monitoraggio costante della contrattualistica corrente e gestione preventiva del contenzioso potenziale.</p>',
            ],
            [
                'h' => 'Composizione negoziata e strumenti di regolazione della crisi',
                'body' => '<p>Il Codice della Crisi d\'Impresa e dell\'Insolvenza (D.lgs. 14/2019, come modif. dal D.lgs. 83/2022 di recepimento della Direttiva UE 2019/1023 e dal D.lgs. 136/2024) ha riformato la disciplina dell\'insolvenza superando la Legge Fallimentare. Lo Studio assiste l\'imprenditore individuale e collettivo negli strumenti previsti: composizione negoziata ex artt. 12 ss. con piattaforma telematica ed esperto indipendente, concordato semplificato ex art. 25-sexies, piano attestato di risanamento ex art. 56, accordi di ristrutturazione ex artt. 57 ss., concordato preventivo in continuità o liquidatorio ex artt. 84 ss., liquidazione giudiziale ex artt. 121 ss. Attenzione all\'obbligo di assetti organizzativi, amministrativi e contabili adeguati ex art. 2086, comma 2, c.c.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Come posso tutelare le informazioni riservate durante una trattativa commerciale?', 'a' => 'Attraverso la redazione di accordi di riservatezza (Non-Disclosure Agreement) personalizzati, corredati da clausole penali idonee a dissuadere la violazione e a quantificare in anticipo il danno risarcibile.'],
            ['q' => 'Quando un\'impresa deve attivare la composizione negoziata?', 'a' => 'È attivabile su iniziativa dell\'imprenditore (artt. 12-25-quinquies del Codice della Crisi) in presenza di squilibrio patrimoniale o economico-finanziario che rende probabile la crisi o l\'insolvenza, ma con ragionevole prospettiva di risanamento. È riservata, sospende le segnalazioni e si avvale di un esperto indipendente designato presso le Camere di Commercio.'],
            ['q' => 'L\'amministratore di una S.r.l. risponde con il patrimonio personale dei debiti?', 'a' => 'Di regola no, ma esistono ipotesi di responsabilità personale: violazione del dovere di gestione ex artt. 2392 e 2476 c.c., responsabilità verso i creditori ex art. 2394 c.c., omessa attivazione tempestiva degli strumenti di regolazione della crisi ex art. 3 del Codice della Crisi, con i correlati profili ex art. 2486 c.c.'],
            ['q' => 'Una S.r.l.s. limita davvero la responsabilità?', 'a' => 'La S.r.l. semplificata (art. 2463-bis c.c.) consente la costituzione con capitale anche inferiore a 10.000 euro, ma non esonera dagli obblighi di adeguatezza degli assetti né dalle responsabilità di amministratori e soci. La scelta del tipo va calibrata sull\'attività e sui rischi prevedibili.'],
            ['q' => 'Un contratto commerciale standard è sufficiente?', 'a' => 'Spesso no. Le clausole su pagamenti, penali, recesso, foro competente e responsabilità vanno adattate al rapporto concreto.'],
            ['q' => 'Lo Studio assiste anche ASD, SSD e imprese sportive?', 'a' => 'Sì, con attenzione ai contratti e ai rapporti con fornitori, sponsor, collaboratori e pubbliche amministrazioni.'],
        ],
    ],

    'infortunistica-malasanita' => [
        'lead' => 'Tutela del danneggiato e gestione del contenzioso assicurativo nelle controversie relative al risarcimento del danno alla persona, da circolazione stradale, da attività medica e da inadempimento contrattuale.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste il danneggiato in tutte le fasi del procedimento di liquidazione del danno derivante da sinistro stradale: richiesta di risarcimento ai sensi dell\'art. 145 del Codice delle Assicurazioni Private (D.lgs. 209/2005), procedimento di indennizzo diretto, eventuale giudizio civile, esecuzione del titolo. In materia di responsabilità medica lo Studio opera in conformità alla Legge n. 24/2017 («Legge Gelli-Bianco»), curando la fase preprocessuale (richiesta di accesso alla documentazione sanitaria, accertamento tecnico preventivo ex art. 696-bis c.p.c.) e l\'eventuale giudizio risarcitorio.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Risarcimento del danno da circolazione stradale</li><li>Responsabilità del vettore e del committente</li><li>Responsabilità sanitaria della struttura e del professionista</li><li>Responsabilità del produttore e da prodotto difettoso</li><li>Responsabilità professionale di avvocati, notai, commercialisti, ingegneri</li><li>Danno biologico, patrimoniale, morale, parentale</li><li>Accertamento tecnico preventivo ex art. 696-bis c.p.c.</li><li>Contenzioso con compagnie assicurative</li></ul>',
            ],
            [
                'h' => 'Tabelle e quantificazione del danno',
                'body' => '<p>La quantificazione del danno non patrimoniale è effettuata con riferimento alle Tabelle del Tribunale di Milano, riconosciute dalla giurisprudenza di legittimità come parametro tendenzialmente uniforme su tutto il territorio nazionale.</p>',
            ],
            [
                'h' => 'Documenti utili al primo colloquio',
                'body' => '<p>Per la prima valutazione del caso è utile portare: copia del verbale, documentazione sanitaria completa, fatture e ricevute, corrispondenza con la compagnia assicurativa, indicazioni dei testimoni.</p>',
            ],
            [
                'h' => 'Il percorso del risarcimento: dall\'ATP ex art. 696-bis all\'azione di merito',
                'body' => '<p>La Legge 24/2017 (Gelli-Bianco) ha riformato la responsabilità sanitaria distinguendo la responsabilità contrattuale della struttura (artt. 1218 e 1228 c.c.) da quella extracontrattuale del sanitario (art. 2043 c.c., salvo obbligazione personale col paziente). L\'art. 8 ha introdotto una condizione di procedibilità: l\'azione deve essere preceduta, a scelta del paziente, dall\'accertamento tecnico preventivo ex art. 696-bis c.p.c. (a finalità conciliative) o dalla mediazione ex D.lgs. 28/2010. Lo Studio segue tutte le fasi: acquisizione della cartella clinica, valutazione medico-legale di parte, procedimento conciliativo, azione di merito contro struttura, sanitario e compagnia assicurativa.</p>',
            ],
            [
                'h' => 'Infortuni stradali, sul lavoro e da prodotto difettoso',
                'body' => '<p>L\'area comprende lesioni e decessi da: sinistri stradali (artt. 2054 c.c., D.lgs. 209/2005, risarcimento diretto e CARD), infortuni sul lavoro con azione differenziale verso il datore oltre l\'indennizzo INAIL, caduta in luogo aperto al pubblico ex art. 2051 c.c., danno da cose in custodia e insidia stradale, responsabilità da prodotto difettoso ex D.lgs. 206/2005. La quantificazione avviene con le Tabelle di Milano per macropermanenti e danni morali, o le tabelle del D.M. 22/07/2019 per le micropermanenti da sinistro ex art. 139 Cod. Ass.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Dopo un incidente devo accettare subito l\'offerta dell\'assicurazione?', 'a' => 'No. È opportuno verificare se l\'offerta copre tutte le voci di danno documentabili, comprese spese, postumi, danno morale e conseguenze lavorative.'],
            ['q' => 'Entro quando posso chiedere il risarcimento per responsabilità sanitaria?', 'a' => 'Dieci anni per la responsabilità contrattuale della struttura (art. 2946 c.c.); cinque anni per quella extracontrattuale del sanitario (art. 2947 c.c.). La prescrizione decorre dalla manifestazione del danno e dalla percezione della sua riconducibilità alla condotta sanitaria; per i decessi, dalla data del decesso per gli eredi.'],
            ['q' => 'La cartella clinica non mi è stata ancora consegnata: cosa posso fare?', 'a' => 'L\'accesso è disciplinato dalla L. 241/1990, dalla normativa privacy e dalla L. 24/2017 (art. 4: la struttura fornisce la documentazione entro sette giorni dalla richiesta, con integrazioni entro trenta). Il rifiuto o il ritardo si fanno valere con istanza alla Direzione sanitaria e, in caso di inerzia, con ricorso al Garante privacy o al TAR.'],
            ['q' => 'Il responsabile del sinistro è scappato: posso ottenere il risarcimento?', 'a' => 'Sì. In caso di veicolo non identificato, non assicurato o assicurato presso compagnia in liquidazione, ci si rivolge al Fondo di Garanzia per le Vittime della Strada ex art. 283 D.lgs. 209/2005, tramite l\'impresa designata indicata da CONSAP, entro i termini di prescrizione del diritto.'],
            ['q' => 'Come si quantifica il danno biologico permanente?', 'a' => 'In base a tabelle medico-legali (Milano per invalidità oltre il 9%, D.M. 22/07/2019 per le micropermanenti ex art. 139 Cod. Ass.), in funzione di età, percentuale di invalidità e, ove provata, personalizzazione. Si aggiungono danno morale, danno da perdita parentale e danni patrimoniali (spese mediche, perdita di reddito presente e futura).'],
            ['q' => 'È vero che si paga solo "a risarcimento ottenuto"?', 'a' => 'Il Codice Deontologico (art. 25) consente di pattuire il compenso anche in funzione del risultato, ma vieta il patto di quota lite e impone il preventivo scritto ex art. 13 L. 247/2012. Lo Studio illustra le opzioni praticabili (forfait, a fasi, parametri D.M. 55/2014) e gli oneri della consulenza tecnica di parte.'],
        ],
    ],

    'lavoro' => [
        'lead' => 'Tutela del lavoratore e assistenza al datore di lavoro in tutte le fasi del rapporto, dalla costituzione alla cessazione, con particolare attenzione al contenzioso individuale e alla composizione conciliativa.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste lavoratori subordinati, parasubordinati ed autonomi, nonché datori di lavoro privati, nelle vertenze relative alla costituzione, allo svolgimento e alla cessazione del rapporto di lavoro. La pratica copre tanto la fase stragiudiziale, con tentativi di conciliazione in sede sindacale o presso l\'Ispettorato Territoriale del Lavoro, quanto il giudizio innanzi al Tribunale in funzione di Giudice del Lavoro.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Impugnazione dei licenziamenti individuali e collettivi (artt. 18 L. 300/1970 e D.lgs. 23/2015)</li><li>Demansionamento e dequalificazione professionale (art. 2103 c.c.)</li><li>Mobbing, straining e condotte vessatorie sul luogo di lavoro</li><li>Dimissioni per giusta causa e per fatti concludenti</li><li>Differenze retributive, TFR, lavoro straordinario, festività</li><li>Trasferimenti, sanzioni disciplinari, contestazioni</li><li>Contratti a termine, di somministrazione e di apprendistato</li><li>Conciliazioni in sede sindacale e protetta ex art. 411 c.p.c.</li></ul>',
            ],
            [
                'h' => 'Tutele crescenti e Jobs Act',
                'body' => '<p>La disciplina del rapporto di lavoro a tempo indeterminato è oggi articolata su un doppio binario: l\'art. 18 dello Statuto dei Lavoratori per i rapporti sorti prima del 7 marzo 2015 e il D.lgs. 23/2015 per quelli successivi. Lo Studio valuta in concreto il regime applicabile e la convenienza tra reintegrazione e indennità risarcitoria.</p>',
            ],
            [
                'h' => 'Termini di impugnazione',
                'body' => '<p>Il licenziamento deve essere impugnato, a pena di decadenza, entro 60 giorni dalla ricezione della comunicazione, seguiti dal deposito del ricorso giudiziale entro i successivi 180 giorni.</p>',
            ],
            [
                'h' => 'Impugnazione del licenziamento: termini, regimi sanzionatori, riti',
                'body' => '<p>L\'impugnazione richiede tempestività: la L. 183/2010 ha introdotto il doppio termine di sessanta giorni per l\'impugnazione stragiudiziale (atto scritto al datore) e centottanta giorni per il deposito del ricorso o la richiesta di conciliazione. Le tutele variano per data di assunzione e numero di dipendenti: per gli assunti fino al 6 marzo 2015 si applica l\'art. 18 L. 300/1970 (come novellato dalla L. 92/2012); per gli assunti dal 7 marzo 2015 il D.lgs. 23/2015 (tutele crescenti), nel testo risultante dagli interventi della Corte Costituzionale (sentt. 194/2018, 150/2020, 59/2021, 22/2024). Il rito è quello del lavoro (artt. 409 ss. c.p.c.).</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Cosa devo fare entro 60 giorni dal licenziamento?', 'a' => 'Inviare al datore un atto scritto di impugnazione che manifesti la volontà di contestare l\'atto, a pena di decadenza ex art. 6 L. 604/1966 (raccomandata A/R o PEC). Poi, entro centottanta giorni, depositare il ricorso giudiziale o avviare la conciliazione.'],
            ['q' => 'Posso essere licenziato durante la malattia?', 'a' => 'Durante il periodo di comporto previsto dal CCNL il lavoratore non può essere licenziato per superamento dell\'assenza giustificata. Resta possibile il licenziamento per giusta causa o giustificato motivo soggettivo, con onere probatorio del datore. Cautele particolari per i lavoratori disabili (Cass. 9095/2023) per evitare discriminazioni indirette.'],
            ['q' => 'Demansionamento e mobbing: che tutele ho?', 'a' => 'Il demansionamento (art. 2103 c.c.) consente l\'azione per il ripristino delle mansioni e il risarcimento del danno patrimoniale e non patrimoniale. Il mobbing è qualificato dalla giurisprudenza come comportamento vessatorio sistematico (Cass. 10037/2015) fonte di responsabilità ex art. 2087 c.c., con onere probatorio rigoroso a carico del lavoratore.'],
            ['q' => 'Posso chiedere differenze retributive se le buste paga sono firmate?', 'a' => 'La firma non esclude automaticamente la possibilità di contestare importi, mansioni o orari, se vi sono elementi contrari.'],
            ['q' => 'Lo Studio assiste anche le aziende?', 'a' => 'Sì, per contratti, contestazioni disciplinari, gestione del contenzioso e prevenzione del rischio.'],
        ],
    ],

    'tributario' => [
        'lead' => 'Difesa del contribuente nei procedimenti di accertamento, riscossione e nel contenzioso innanzi alle Corti di Giustizia Tributaria, alla luce della riforma di cui al D.lgs. 220/2023.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste il contribuente — persona fisica o impresa — nelle fasi del procedimento tributario, dalla risposta agli inviti al contraddittorio fino al ricorso giurisdizionale. Particolare attenzione è dedicata all\'esame degli atti impositivi sotto il profilo della motivazione, della corretta applicazione delle aliquote e della legittimità del procedimento accertativo. L\'attività è svolta in collaborazione con il Dott. Ruggiero LANOTTE, commercialista dello Studio, per le perizie econometriche e le verifiche contabili.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Avvisi di accertamento IRPEF, IRES, IRAP, IVA</li><li>Cartelle di pagamento, intimazioni, iscrizioni ipotecarie</li><li>Fermi amministrativi e pignoramenti</li><li>Istanze di sgravio, rateizzazione, sospensione</li><li>Definizioni agevolate, rottamazioni, saldo e stralcio</li><li>Ricorsi alla Corte di Giustizia Tributaria di primo e secondo grado</li><li>Ricorsi per cassazione tributaria in collaborazione con cassazionisti</li><li>Tributi locali: IMU, TARI, TASI</li></ul>',
            ],
            [
                'h' => 'Riforma del processo tributario',
                'body' => '<p>Il D.lgs. n. 220/2023, in attuazione della legge delega n. 111/2023, ha riformato profondamente il giudizio tributario, introducendo la magistratura tributaria professionale e modificando il regime delle prove (artt. 7 e 7-bis D.lgs. 546/1992).</p>',
            ],
            [
                'h' => 'Termine di impugnazione',
                'body' => '<p>Il ricorso avverso gli atti dell\'Amministrazione finanziaria deve essere proposto, a pena di inammissibilità, entro 60 giorni dalla notificazione dell\'atto.</p>',
            ],
            [
                'h' => 'Cartelle, avvisi di accertamento e riscossione',
                'body' => '<p>Lo Studio assiste contribuenti, imprese e professionisti nella verifica di cartelle di pagamento, intimazioni, fermi amministrativi, ipoteche, pignoramenti, avvisi di accertamento e tributi locali. L\'analisi riguarda notifica, prescrizione, decadenza, importi richiesti, ente creditore e strumenti di tutela amministrativa o giudiziale.</p>',
            ],
            [
                'h' => 'Il processo tributario dopo la riforma 2022 e i decreti attuativi 2023',
                'body' => '<p>Il processo tributario è disciplinato dal D.lgs. 546/1992, innovato dalla L. 130/2022 (magistratura tributaria professionale e Corti di giustizia tributaria di primo e secondo grado), dal D.lgs. 220/2023 (attuazione della delega fiscale L. 111/2023) e dal D.lgs. 219/2023 (riforma dello Statuto del contribuente, L. 212/2000). Novità: generalizzazione del processo telematico, prova testimoniale scritta nei limiti dell\'art. 7, comma 4, riforma della revocazione, ampliamento della definizione agevolata, conciliazione giudiziale rafforzata. Lo Studio assiste nell\'intero ciclo: ricorso, reclamo/mediazione, conciliazione, appello, cassazione, esecuzione e rimborsi.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Quanto tempo ho per impugnare una cartella esattoriale?', 'a' => 'Sessanta giorni dalla notifica ex art. 21 D.lgs. 546/1992. Il termine è sospeso nel periodo feriale (1-31 agosto) ex L. 742/1969. Per gli atti sotto soglia può essere obbligatoria la fase di mediazione/reclamo ex art. 17-bis, salvo quanto disposto dal D.lgs. 220/2023.'],
            ['q' => 'Posso sospendere la cartella prima della decisione del giudice?', 'a' => 'Sì. È possibile l\'istanza di sospensione amministrativa ad Agenzia delle Entrate-Riscossione (effetti limitati) o, col ricorso, l\'istanza di sospensione giudiziale ex art. 47 D.lgs. 546/1992 quando l\'esecuzione possa derivare un danno grave e irreparabile. Il giudice decide con ordinanza.'],
            ['q' => 'Serve l\'avvocato per il ricorso tributario?', 'a' => 'La difesa tecnica è obbligatoria per le controversie di valore superiore a 3.000 euro (art. 12 D.lgs. 546/1992). Per le materie penali tributarie (D.lgs. 74/2000) l\'assistenza è sempre necessaria. Lo Studio offre assistenza integrata civilistica, tributaria e penale tributaria.'],
            ['q' => 'Una cartella vecchia può essere prescritta?', 'a' => 'Può esserlo, ma occorre verificare la natura del credito, le notifiche successive e gli eventuali atti interruttivi.'],
            ['q' => 'Lo Studio segue anche i tributi locali?', 'a' => 'Sì, comprese le controversie su IMU, TARI, avvisi comunali e riscossione locale.'],
        ],
    ],

    'proprieta-intellettuale' => [
        'lead' => 'Tutela dei segni distintivi, del marchio nazionale ed europeo, del diritto d\'autore e dei segreti commerciali, davanti agli uffici brevettuali italiani (UIBM) e dell\'Unione europea (EUIPO).',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio opera direttamente innanzi all\'EUIPO di Alicante per il deposito, l\'opposizione e il contenzioso sui marchi dell\'Unione europea ai sensi del Reg. UE 2017/1001, e presso l\'UIBM per il deposito e la difesa dei marchi nazionali. La consulenza copre tanto la fase amministrativa di registrazione quanto la difesa giudiziale contro la contraffazione e la concorrenza sleale. In materia di diritto d\'autore lo Studio assiste autori, editori e imprese culturali nella tutela delle opere dell\'ingegno e nella contrattualistica editoriale.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Ricerca di anteriorità e valutazione di registrabilità</li><li>Deposito di marchi nazionali presso UIBM</li><li>Deposito di marchi dell\'Unione Europea presso EUIPO</li><li>Opposizioni alla registrazione di marchi</li><li>Procedimenti di nullità e decadenza</li><li>Contraffazione e concorrenza sleale (artt. 2598 ss. c.c.)</li><li>Diritto d\'autore e diritti connessi</li><li>Contratti di licenza, cessione e merchandising</li><li>Tutela dei segreti commerciali (D.lgs. 63/2018)</li></ul>',
            ],
            [
                'h' => 'EUIPO — Marchio dell\'Unione Europea',
                'body' => '<p>Lo Studio è abilitato al patrocinio diretto innanzi all\'EUIPO. Il marchio UE produce effetti unitari in tutti i 27 Stati membri ed è spesso preferibile, in chiave di costo-beneficio, a una pluralità di depositi nazionali.</p>',
            ],
            [
                'h' => 'Prima del deposito',
                'body' => '<p>Prima del deposito di un marchio è opportuno commissionare una ricerca di anteriorità: una verifica preventiva consente di evitare opposizioni e di contenere i costi del procedimento.</p>',
            ],
            [
                'h' => 'Strategia di tutela: dal deposito UIBM alla protezione internazionale',
                'body' => '<p>La tutela del marchio si costruisce per cerchi concentrici geografici. La registrazione presso l\'UIBM (D.lgs. 30/2005 — Codice della Proprietà Industriale, come modif. dal D.lgs. 15/2019) garantisce l\'esclusiva sul territorio italiano. Il marchio dell\'Unione Europea presso l\'EUIPO (Reg. UE 2017/1001) conferisce protezione unitaria nei 27 Stati membri. Il sistema di Madrid gestito dall\'OMPI/WIPO consente l\'estensione a oltre 130 Paesi. Lo Studio assiste nella ricerca di anteriorità, nella scelta delle classi di Nizza, nel deposito, nella gestione di opposizioni e rifiuti d\'ufficio, nelle azioni di decadenza per non uso ex artt. 24 e 26 C.P.I. e nella tutela in contraffazione davanti alle Sezioni Specializzate in materia di impresa.</p>',
            ],
            [
                'h' => 'Brevetti, design e contenzioso davanti al Tribunale delle Imprese',
                'body' => '<p>Per i titoli brevettuali lo Studio coordina la consulenza giuridica con quella tecnica dei consulenti in proprietà industriale abilitati (mandatari UIBM, EPO, EUIPO). Il brevetto per invenzione è regolato dagli artt. 45 ss. C.P.I. e, per la dimensione europea, dalla Convenzione di Monaco del 1973, con il brevetto europeo unitario operativo dal 1° giugno 2023 e il Tribunale Unificato dei Brevetti (UPC). Per il design si applicano il C.P.I. (artt. 31 ss.) e il Reg. UE 6/2002. Il contenzioso è riservato alle Sezioni Specializzate in materia di impresa ex D.lgs. 168/2003.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Conviene registrare prima in Italia o direttamente come marchio UE?', 'a' => 'Dipende dal mercato effettivo e programmato. Se l\'attività è solo nazionale può bastare il deposito italiano; se il brand opera o intende operare nell\'Unione europea può essere utile valutare il marchio UE.'],
            ['q' => 'Posso registrare un marchio uguale al mio nome o cognome?', 'a' => 'Sì, con cautele: il nome civile altrui è registrabile solo col consenso dell\'avente diritto (art. 8 C.P.I.) e non deve essere descrittivo. La registrazione del proprio cognome, se di rilievo, può essere oggetto di opposizione di omonimi titolari di marchi anteriori; in caso di omonimia commerciale operano i limiti dell\'art. 21 C.P.I.'],
            ['q' => 'Cosa succede se qualcuno copia il mio marchio o design?', 'a' => 'Si attivano gli strumenti del C.P.I.: diffida, descrizione e sequestro ex artt. 128-130, inibitoria ex art. 131, misura cautelare ex art. 700 c.p.c., azione di merito davanti alla Sezione Specializzata con risarcimento (artt. 124-125 C.P.I., anche per retroversione degli utili). Per le opere d\'ingegno è esperibile la tutela penale ex artt. 171 ss. L. 633/1941.'],
            ['q' => 'Per quanto dura la protezione di un marchio?', 'a' => 'Dieci anni dalla data di deposito, rinnovabile indefinitamente per periodi di dieci anni (artt. 16-17 C.P.I. e Reg. UE 2017/1001). La protezione è subordinata all\'uso effettivo entro cinque anni: in difetto il titolare può subire la decadenza per non uso ex art. 24 C.P.I.'],
            ['q' => 'Cosa cambia con il Tribunale Unificato dei Brevetti (UPC)?', 'a' => 'Dal 1° giugno 2023 l\'UPC è competente per il brevetto europeo con effetto unitario e, salvo opt-out, per i brevetti europei classici nel periodo transitorio. Le decisioni hanno effetto in tutti gli Stati partecipanti. Lo Studio assiste nella valutazione opt-in/opt-out e nella strategia processuale.'],
            ['q' => 'Posso tutelare il nome di un evento sportivo o di una ASD/SSD?', 'a' => 'Sì, se il segno ha i requisiti di legge e viene correttamente individuato rispetto a servizi, merchandising, eventi, formazione o attività sportive.'],
        ],
    ],

    'bancario' => [
        'lead' => 'Tutela del cliente nei rapporti con le banche e con gli intermediari finanziari, contestazioni di anatocismo, usura, segnalazioni in Centrale dei Rischi e patrocinio davanti all\'Arbitro Bancario Finanziario (ABF).',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste il correntista, l\'imprenditore e il consumatore nella verifica della corretta applicazione delle condizioni economiche del rapporto bancario, con particolare riferimento ai profili dell\'anatocismo (art. 120 TUB) e dell\'usura sopravvenuta. L\'analisi tecnica del rapporto è svolta in collaborazione con il Dott. Ruggiero LANOTTE, commercialista, specializzato nella perizia econometrica sui rapporti bancari.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Contestazione di anatocismo bancario</li><li>Usura originaria e usura sopravvenuta</li><li>Mutui: piani di ammortamento, ammortamento alla francese, TAEG</li><li>Contratti di leasing finanziario</li><li>Polizze assicurative collegate a finanziamenti (PPI)</li><li>Segnalazioni illegittime in Centrale dei Rischi</li><li>Cancellazione da Crif e altri sistemi informativi creditizi</li><li>Ricorso all\'Arbitro Bancario Finanziario (ABF)</li></ul>',
            ],
            [
                'h' => 'Ammortamento alla francese',
                'body' => '<p>Lo Studio aggiorna costantemente la propria pratica alle ultime pronunce di legittimità, tra cui la sentenza Cass. SS.UU. n. 15130/2024 sulla validità dei piani di ammortamento alla francese.</p>',
            ],
            [
                'h' => 'Perizia econometrica',
                'body' => '<p>Per valutare la fondatezza di una contestazione bancaria è generalmente necessaria una perizia tecnica sul rapporto. Lo Studio coordina l\'attività dei consulenti contabili.</p>',
            ],
            [
                'h' => 'Anatocismo, usura e contenzioso bancario: strumenti di tutela',
                'body' => '<p>Il contenzioso bancario richiede perizia econometrica specializzata. L\'anatocismo è regolato dall\'art. 120, comma 2, TUB (D.lgs. 385/1993) e dalla delibera CICR del 3 agosto 2016. L\'usura opera in chiave oggettiva (TEG superiore al tasso soglia ex L. 108/1996 e D.M. trimestrali MEF) e soggettiva. La giurisprudenza ha ridefinito molti profili: fideiussioni omnibus su schema ABI (Cass. S.U. 41994/2021, parziale nullità), mutuo solutorio (Cass. S.U. 5841/2023), cumulo interessi corrispettivi e moratori (Cass. S.U. 19597/2020). Lo Studio assiste correntisti, mutuatari e garanti con consulenza tecnica di parte e azione davanti al giudice ordinario o all\'Arbitro Bancario Finanziario (ABF).</p>',
            ],
        ],
        'faq' => [
            ['q' => 'Posso contestare un decreto ingiuntivo della banca?', 'a' => 'Sì, entro i termini di legge, verificando contratto, estratti conto, saldo richiesto e documentazione prodotta.'],
            ['q' => 'Come faccio a sapere se la banca ha applicato tassi usurari?', 'a' => 'Serve una perizia econometrica che ricalcoli il TEG (interessi corrispettivi, di mora, commissioni e oneri) raffrontandolo col tasso soglia trimestrale del MEF. La Cassazione (S.U. 19597/2020) ha precisato che il superamento del tasso soglia degli interessi moratori non determina automaticamente la nullità delle clausole sugli interessi corrispettivi.'],
            ['q' => 'Cos\'è l\'Arbitro Bancario Finanziario e quando conviene?', 'a' => 'È un organismo di risoluzione stragiudiziale presso la Banca d\'Italia, competente per controversie fino a 200.000 euro. Le decisioni non sono vincolanti ma molto autorevoli e l\'inadempimento dell\'intermediario è pubblicato. Spesso utile come alternativa o passaggio preliminare al contenzioso.'],
            ['q' => 'Ho firmato una fideiussione omnibus: posso liberarmi?', 'a' => 'La Cassazione S.U. 41994/2021 ha chiarito che le fideiussioni omnibus su schema ABI 2002, in contrasto con la L. 287/1990, sono parzialmente nulle nelle clausole che riproducono il contenuto anticoncorrenziale (deroga agli artt. 1939, 1955 e 1957 c.c.). La nullità non travolge l\'intero contratto ma incide sulla posizione del garante.'],
            ['q' => 'La segnalazione in CRIF o a sofferenza può essere contestata?', 'a' => 'Può esserlo se mancano i presupposti, le comunicazioni, la correttezza del dato o la proporzionalità della segnalazione.'],
            ['q' => 'Serve sempre una perizia?', 'a' => 'Non sempre, ma nelle controversie su interessi, saldi e rapporti bancari complessi è spesso utile.'],
        ],
    ],

    'internazionale-privato' => [
        'lead' => 'Assistenza nelle controversie con elementi di estraneità: successioni transfrontaliere, riconoscimento ed esecuzione di sentenze estere, cooperazione giudiziaria civile nello spazio dell\'Unione europea.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste cittadini italiani e stranieri nelle questioni civili a carattere transfrontaliero, applicando il sistema di diritto internazionale privato fondato sulla Legge n. 218/1995 e sui Regolamenti europei in materia di obbligazioni contrattuali ed extracontrattuali (Roma I e Roma II), competenza giurisdizionale (Bruxelles I-bis) e successioni (Reg. UE 650/2012). La pratica si estende a giurisdizioni extra-UE tramite reti di corrispondenti: tra le esperienze più recenti dello Studio rientra la consulenza giuridica resa per un ricorso civile in Argentina.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Successioni transfrontaliere ai sensi del Reg. UE n. 650/2012</li><li>Certificato Successorio Europeo e sua circolazione</li><li>Riconoscimento ed esecuzione di sentenze straniere (Bruxelles I-bis)</li><li>Determinazione della legge applicabile ai contratti internazionali</li><li>Sottrazione internazionale di minori (Convenzione dell\'Aja 1980)</li><li>Divorzi e separazioni transfrontaliere (Reg. UE 2019/1111)</li><li>Notificazioni di atti giudiziari ed extragiudiziari all\'estero</li><li>Assunzione delle prove all\'estero (Reg. UE 2020/1783)</li></ul>',
            ],
            [
                'h' => 'Spazio giudiziario europeo',
                'body' => '<p>La cooperazione giudiziaria nello spazio UE consente la circolazione automatica dei provvedimenti civili, fatte salve le limitate ipotesi di rifiuto del riconoscimento per ragioni di ordine pubblico.</p>',
            ],
            [
                'h' => 'Contrattualistica cross-border ed esecuzione in Europa',
                'body' => '<p>Il mercato non ha confini, e nemmeno la nostra assistenza. Supportiamo le imprese nei processi di internazionalizzazione gestendo la contrattualistica in lingua, le procedure per il recupero del credito transfrontaliero e la produzione di traduzioni documentali fedeli e rigorose, essenziali per gli atti destinati a procedimenti internazionali o comunitari. Lo Studio cura altresì gli adempimenti documentali correlati (apostille, legalizzazioni, traduzioni asseverate).</p>',
            ],
            [
                'h' => 'Quale giurisdizione?',
                'body' => '<p>Nelle questioni transfrontaliere la prima domanda è sempre l\'individuazione del giudice competente e della legge applicabile. Lo Studio fornisce, in sede di primo colloquio, una valutazione tecnica preliminare di entrambi i profili.</p>',
            ],
            [
                'h' => 'Rapporti familiari, successori e contrattuali con elementi esteri',
                'body' => '<p>Lo Studio assiste persone, famiglie, imprese e soggetti stranieri in controversie o pratiche con elementi internazionali: beni all\'estero, eredi residenti in Paesi diversi, contratti con controparti straniere, riconoscimento di atti, documenti esteri, procure, traduzioni e coordinamento con professionisti di altri ordinamenti.</p>',
            ],
            [
                'h' => 'Contratti internazionali, giurisdizione e riconoscimento delle sentenze',
                'body' => '<p>L\'attività si articola su tre profili. Legge applicabile e giurisdizione: clausole di scelta della legge ex Reg. CE 593/2008 (Roma I) per i contratti e di proroga di giurisdizione ex art. 25 Reg. UE 1215/2012 (Bruxelles I-bis); per le obbligazioni extracontrattuali il Reg. CE 864/2007 (Roma II); per i rapporti familiari i Reg. UE 1259/2010, 650/2012, 2016/1103 e 2016/1104. Riconoscimento ed esecuzione delle sentenze straniere: regime automatico per le decisioni UE ex Reg. UE 1215/2012; delibazione ex artt. 64 ss. L. 218/1995 per gli Stati extra-UE. Arbitrato internazionale: clausole compromissorie e riconoscimento dei lodi esteri ex Convenzione di New York del 1958.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'In caso di lite con un fornitore estero, quale giudice è competente?', 'a' => 'Dipende dalle clausole del contratto e dai regolamenti europei, in particolare dal Reg. Bruxelles I-bis. È essenziale inserire fin dall\'inizio una clausola chiara di foro competente e di legge applicabile, per evitare incertezze costose.'],
            ['q' => 'Posso scegliere la legge straniera applicabile al mio contratto B2B?', 'a' => 'Sì. Il Reg. CE 593/2008 (Roma I) consente la libera scelta della legge applicabile ai contratti commerciali, coi limiti delle norme di applicazione necessaria (art. 9) e dell\'ordine pubblico (art. 21). Per consumatori, lavoratori e assicurati la scelta non può privare la parte debole della protezione delle norme imperative di residenza.'],
            ['q' => 'Come si notifica un atto giudiziario in un altro Paese dell\'Unione europea?', 'a' => 'Attraverso i regolamenti europei sulle notificazioni, che consentono la trasmissione diretta tra le autorità competenti degli Stati membri, riducendo tempi e costi rispetto alle procedure tradizionali.'],
            ['q' => 'Come faccio valere in Italia una sentenza di divorzio estera?', 'a' => 'Per le sentenze UE si applica il Reg. UE 2019/1111 (Bruxelles II-ter) con riconoscimento automatico salvo iscrizione nei registri di stato civile. Per le extra-UE il regime ex artt. 64-67 L. 218/1995, con riconoscimento automatico se ricorrono i requisiti e delibazione ex art. 67 in caso di contestazione.'],
            ['q' => 'Una successione con beni all\'estero segue sempre la legge italiana?', 'a' => 'Non necessariamente. Occorre verificare residenza, cittadinanza, ubicazione dei beni e norme applicabili, anche alla luce del Reg. UE 650/2012.'],
            ['q' => 'Le clausole arbitrali nei contratti internazionali valgono in Italia?', 'a' => 'Sì. La Convenzione di New York del 1958, recepita con L. 62/1968, garantisce il riconoscimento dei lodi pronunciati in oltre 170 Stati aderenti, salvo limitate ipotesi di rifiuto (art. V). Per l\'arbitrato interno con elementi di internazionalità si applicano gli artt. 832 ss. c.p.c.'],
        ],
    ],

    'previdenza' => [
        'lead' => 'Assistenza nelle controversie con gli enti previdenziali e assicurativi pubblici, dal riconoscimento dell\'invalidità civile all\'indennizzo per infortunio sul lavoro e malattia professionale.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio assiste i lavoratori e i loro aventi causa nei procedimenti per il riconoscimento delle prestazioni previdenziali e assistenziali, nonché nelle controversie con l\'INAIL per l\'indennizzo da infortunio sul lavoro e malattia professionale. La pratica copre la fase amministrativa (ricorso in via gerarchica) e quella giudiziale innanzi al Tribunale in funzione di Giudice del Lavoro.</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Infortuni sul lavoro: indennizzo del danno biologico e patrimoniale</li><li>Malattie professionali tabellate e non tabellate</li><li>Rendite vitalizie INAIL e revisione del grado di inabilità</li><li>Ricorsi per il riconoscimento dell\'invalidità civile</li><li>Indennità di accompagnamento e Legge 104/1992</li><li>Ricorsi avverso provvedimenti INPS in materia di pensione</li><li>Pensione di inabilità e assegno ordinario di invalidità</li><li>Forme di previdenza complementare</li></ul>',
            ],
            [
                'h' => 'Danno differenziale',
                'body' => '<p>L\'azione civile per il risarcimento del danno differenziale rispetto all\'indennizzo INAIL consente di ottenere il ristoro integrale del pregiudizio subito, in conformità alla giurisprudenza consolidata della Corte di Cassazione.</p>',
            ],
            [
                'h' => 'Tempistica',
                'body' => '<p>I termini di impugnazione dei provvedimenti INPS e INAIL sono brevi: si consiglia di contattare lo Studio tempestivamente alla ricezione dell\'atto.</p>',
            ],
            [
                'h' => 'L\'accertamento tecnico preventivo obbligatorio ex art. 445-bis c.p.c.',
                'body' => '<p>Il contenzioso in materia di invalidità civile, cecità, sordità, handicap (L. 104/1992), disabilità per il collocamento mirato (L. 68/1999) e pensione di inabilità (L. 222/1984) deve essere preceduto, ex art. 445-bis c.p.c., dall\'accertamento tecnico preventivo obbligatorio: il giudice nomina un CTU medico-legale che esamina il ricorrente e formula una relazione, sulla cui base le parti possono accettare o contestare. Il ricorso (ATP o merito) va proposto entro sei mesi dalla notifica del verbale impugnato. Lo Studio assiste dalla richiesta amministrativa all\'INPS fino al contenzioso, coordinando il consulente medico legale di parte.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'L\'INPS mi ha riconosciuto una percentuale inferiore: posso ricorrere?', 'a' => 'Sì. Il verbale si impugna con ricorso giudiziale preceduto dall\'accertamento tecnico preventivo ex art. 445-bis c.p.c., entro sei mesi dalla notifica. La fase ATP è obbligatoria. Le richieste di revisione anticipata per aggravamento si presentano invece in via amministrativa.'],
            ['q' => 'Posso avere la Legge 104 senza invalidità civile riconosciuta?', 'a' => 'Sì. Lo stato di handicap grave ex art. 3, comma 3, L. 104/1992 e l\'invalidità civile sono accertati con procedure distinte, anche se contestuali davanti alla stessa commissione INPS. Si può avere l\'handicap grave senza percentuale di invalidità sufficiente per l\'assegno, e viceversa.'],
            ['q' => 'Quanto dura il procedimento di ricorso?', 'a' => 'La procedura ex art. 445-bis c.p.c. ha tempi variabili: in media l\'ATP si conclude in nove-quindici mesi dal deposito del ricorso. In caso di contestazione e prosecuzione nel merito, i tempi del primo grado si attestano su uno-tre anni ulteriori.'],
            ['q' => 'Serve un medico legale?', 'a' => 'Nei casi sanitari è spesso opportuno acquisire una valutazione medico-legale prima di iniziare il giudizio.'],
        ],
    ],

    'no-profit' => [
        'lead' => 'Assistenza alle associazioni, alle fondazioni, agli enti del Terzo Settore e alle società sportive dilettantistiche, con particolare attenzione alla riforma introdotta dal D.lgs. 117/2017 e dal D.lgs. 36/2021.',
        'sezioni' => [
            [
                'h' => 'L\'attività dello Studio',
                'body' => '<p>Lo Studio fornisce consulenza nella costituzione, nella trasformazione e nella riorganizzazione degli enti del Terzo Settore secondo il Codice del Terzo Settore (D.lgs. n. 117/2017), seguendo l\'iter di iscrizione al Registro Unico Nazionale del Terzo Settore (RUNTS) e curando l\'adeguamento statutario degli enti preesistenti. In materia sportiva lo Studio assiste società e associazioni sportive dilettantistiche nelle fasi di costituzione, di iscrizione al RASD e di adeguamento alla riforma dello sport (D.lgs. n. 36/2021).</p>',
            ],
            [
                'h' => 'Materie trattate',
                'body' => '<ul><li>Costituzione di associazioni, fondazioni, ETS, APS e ODV</li><li>Iscrizione e tenuta del RUNTS</li><li>Adeguamento statutario ex D.lgs. 117/2017</li><li>Costituzione di società sportive dilettantistiche (SSD)</li><li>Iscrizione al Registro Nazionale Attività Sportive Dilettantistiche</li><li>Rapporti con tesserati e collaboratori sportivi (D.lgs. 36/2021)</li><li>Giustizia sportiva endofederale e procedimenti dinanzi al Collegio di Garanzia CONI</li></ul>',
            ],
            [
                'h' => 'Diritto sportivo internazionale',
                'body' => '<p>Lo Studio assiste federazioni e comitati nazionali nelle controversie sovranazionali: tra i mandati seguiti rientrano la International Taekwon-Do Federation di Vienna (ITF) e il Comitato Nazionale Taekwon-Do della Repubblica Popolare Democratica di Corea.</p>',
            ],
            [
                'h' => 'Adeguamento RUNTS',
                'body' => '<p>Gli enti preesistenti hanno l\'onere di adeguare il proprio statuto alle previsioni del Codice del Terzo Settore. Lo Studio fornisce un servizio completo di revisione statutaria, predisposizione della delibera assembleare e iscrizione al RUNTS.</p>',
            ],
            [
                'h' => 'Costituzione, adeguamento e iscrizione al RUNTS degli Enti del Terzo Settore',
                'body' => '<p>Il Codice del Terzo Settore (D.lgs. 117/2017, come modif. da ultimo per i profili fiscali col D.L. 73/2022 e gli interventi 2024-2025) ha istituito una disciplina organica per le organizzazioni non lucrative. L\'iscrizione al Registro Unico Nazionale del Terzo Settore (RUNTS), operativo dal 23 novembre 2021, è condizione per la qualifica di ETS e per il regime fiscale agevolato. Lo Studio assiste associazioni, fondazioni, comitati e imprese sociali nella scelta del tipo (ODV, APS, ETS generico, Impresa Sociale ex D.lgs. 112/2017, Ente Filantropico), nella redazione degli statuti ex artt. 21 ss. CTS, nell\'adeguamento degli statuti preesistenti (maggioranze semplificate ex art. 101 CTS) e nei rapporti con l\'Ufficio del RUNTS e l\'Agenzia delle Entrate.</p>',
            ],
        ],
        'faq' => [
            ['q' => 'La mia associazione deve obbligatoriamente diventare ETS?', 'a' => 'No. La qualifica è opzionale: comporta obblighi (statutari, contabili, di pubblicità e trasparenza) compensati da benefici (regime fiscale agevolato, 5x1000, convenzioni con la P.A. ex artt. 55-57 CTS, accesso a fondi riservati). La scelta va valutata su missione, dimensioni e modello operativo.'],
            ['q' => 'Cosa cambia per le ONLUS dopo la riforma?', 'a' => 'Il regime ONLUS (D.lgs. 460/1997) cesserà con la piena operatività del titolo X del CTS (previa autorizzazione UE alle agevolazioni). Nel transitorio le ONLUS possono mantenere il proprio regime o transitare al regime ETS: la scelta richiede una valutazione tecnica caso per caso.'],
            ['q' => 'Quali obblighi di trasparenza e rendicontazione ha un ETS?', 'a' => 'Gli ETS depositano al RUNTS il bilancio di esercizio (o rendiconto di cassa per gli enti minori) ex D.M. 5 marzo 2020. Sopra un milione di euro di ricavi si pubblica il bilancio sociale. Oltre determinate soglie sono obbligatori l\'organo di controllo ex art. 30 CTS e la revisione legale.'],
            ['q' => 'Una ASD può essere anche ETS?', 'a' => 'In alcuni casi sì, ma la scelta richiede una valutazione coordinata tra normativa sportiva, fiscale e del Terzo settore.'],
            ['q' => 'È utile aggiornare lo statuto?', 'a' => 'Sì, soprattutto quando l\'ente svolge attività strutturate, riceve contributi, gestisce volontari o intende iscriversi a registri pubblici.'],
        ],
    ],

];
