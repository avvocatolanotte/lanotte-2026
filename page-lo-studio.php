<?php
/**
 * Template Name: Lo Studio
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$hero_bg = LANOTTE_THEME_URI . '/assets/img/trani/cattedrale-trani.jpg';
?>

<section class="hero-internal" style="background-image:linear-gradient(135deg,rgba(14,26,51,.88) 0%,rgba(26,42,74,.78) 100%),url('<?php echo esc_url($hero_bg); ?>');background-size:cover;background-position:center 60%;padding:90px 0 70px;color:#fff">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <h1 style="font-size:clamp(30px,5vw,52px);color:#fff;margin:8px 0 14px">Lo Studio Legale<br>Lanotte &amp; Partners</h1>
    <p class="subtitle" style="color:#d4d8e0;max-width:720px">Studio iscritto al Foro di Trani · Sede in Barletta · Attività multidisciplinare in materia civile, penale, commerciale, del lavoro e tributaria.</p>
  </div>
</section>

<?php
// Se l'admin ha aggiunto contenuto custom in WP, lo mostra (e la CSS difensiva
// del header garantisce comunque la responsività). Altrimenti, fallback ricco.
$has_custom_content = trim(strip_tags(get_the_content())) !== '';
if ($has_custom_content):
?>
<section class="block">
  <div class="container" style="max-width:880px">
    <div class="legal-content" style="padding:0">
      <?php the_content(); ?>
    </div>
  </div>
</section>
<?php else: ?>

<!-- INTRO RICCA -->
<section style="background:#fff;padding:60px 0">
  <div class="container" style="max-width:900px">
    <div class="section-eyebrow" style="text-align:center;margin-bottom:8px">Studio Legale</div>
    <h2 style="font-family:var(--serif);font-size:clamp(26px,4vw,38px);color:var(--navy);text-align:center;font-weight:600;margin:0 0 30px;line-height:1.2">Una professione antica,<br>un metodo presente.</h2>

    <p style="font-size:16.5px;line-height:1.75;color:#334155;margin:0 0 18px">Lo <strong>Studio Legale LANOTTE &amp; Partners</strong> ha sede in Barletta, in Viale Falcone e Borsellino, 75. L'attività si svolge principalmente nel Foro di Trani, con assistenza estesa al Foro di Bari per la fase di appello e su tutto il territorio nazionale tramite una rete consolidata di corrispondenti.</p>

    <p style="font-size:16.5px;line-height:1.75;color:#334155;margin:0 0 18px">L'Avv. <strong>Giuseppe LANOTTE</strong>, titolare dello Studio, esercita la professione con un approccio interdisciplinare: la formazione civilistica si integra con un'immutata pratica penalistica e con la consulenza alle imprese, alle associazioni del terzo settore e alle società sportive dilettantistiche.</p>

    <p style="font-size:16.5px;line-height:1.75;color:#334155;margin:0">Lo Studio assiste persone fisiche, famiglie, professionisti, imprese ed enti, garantendo continuità del rapporto e seguito personale del titolare o di chi del mandato. Le questioni complesse sono trattate con il supporto di colleghi consulenti, ciascuno specializzato nella materia di competenza, secondo un modello collaborativo orientato alla tutela effettiva dell'assistito.</p>
  </div>
</section>

<!-- VOCAZIONE INTERNAZIONALE -->
<section style="background:var(--cream);padding:60px 0">
  <div class="container" style="max-width:900px">
    <h3 style="font-family:var(--serif);font-size:clamp(22px,3.2vw,30px);color:var(--navy);font-weight:600;margin:0 0 20px">Una vocazione internazionale</h3>
    <p style="font-size:16px;line-height:1.7;color:#334155;margin:0 0 18px">Una parte significativa dell'attività dello Studio ha vocazione internazionale.</p>
    <ul class="lo-studio-list">
      <li>Nel campo della <strong>proprietà intellettuale</strong>, lo Studio opera direttamente innanzi all'<strong>EUIPO</strong> di Alicante per il deposito e la difesa dei marchi dell'Unione europea (Reg. UE 2017/1001) e per il contenzioso sulla proprietà industriale UE.</li>
      <li>Nel campo del <strong>diritto sportivo internazionale</strong>, lo Studio assiste, tra gli altri, la <em>International Taekwon-Do Federation di Vienna (ITF)</em> e il Comitato Nazionale Taekwon-Do della Repubblica Popolare Democratica di Corea.</li>
      <li>La <strong>pratica extra-europea</strong> si svolge per il tramite di reti di corrispondenti locali. Tra le esperienze più recenti rientra la consulenza giuridica resa per un ricorso civile in Argentina.</li>
    </ul>
  </div>
</section>

<!-- PATROCINIO -->
<section style="background:#fff;padding:60px 0">
  <div class="container" style="max-width:900px">
    <h3 style="font-family:var(--serif);font-size:clamp(22px,3.2vw,30px);color:var(--navy);font-weight:600;margin:0 0 20px">Patrocinio innanzi alle giurisdizioni superiori</h3>
    <p style="font-size:16px;line-height:1.7;color:#334155;margin:0 0 18px">Per il patrocinio innanzi alle giurisdizioni superiori — Corte Suprema di Cassazione, Consiglio di Stato e Corte di Cassazione tributaria — lo Studio si avvale stabilmente della collaborazione di professionisti abilitati al patrocinio in Cassazione, individuati di volta in volta in base alla specifica materia trattata.</p>
    <p style="font-size:16px;line-height:1.7;color:#334155;margin:0">La pratica forense è esercitata nel rigoroso rispetto del Codice Deontologico Forense e dei principi di indipendenza, lealtà processuale e segreto professionale.</p>
  </div>
</section>

<!-- TEAM TITOLARE -->
<section style="background:var(--cream);padding:60px 0">
  <div class="container">
    <div class="section-eyebrow" style="text-align:center;margin-bottom:8px">I Professionisti</div>
    <h3 style="font-family:var(--serif);font-size:clamp(24px,3.5vw,34px);color:var(--navy);text-align:center;font-weight:600;margin:0 0 36px">Il team</h3>

    <?php
    $ruolo_labels = ['titolare'=>'Avvocato titolare','commercialista'=>'Consulente fiscale','partner-esterno'=>'Partner esterno','of-counsel'=>'Of Counsel','associato'=>'Avvocato associato','collaboratore'=>'Collaboratore','praticante'=>'Praticante'];
    $team_q = new WP_Query(['post_type'=>'team','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
    if ($team_q->have_posts()): ?>
    <div class="ls-team-grid">
      <?php while ($team_q->have_posts()): $team_q->the_post();
        $tid    = get_the_ID();
        $titolo = function_exists('lanotte_team_meta') ? lanotte_team_meta($tid,'titolo','titolo') : '';
        $ruolo  = function_exists('lanotte_team_meta') ? lanotte_team_meta($tid,'ruolo','ruolo') : '';
        $bio    = function_exists('lanotte_team_meta') ? lanotte_team_meta($tid,'bio','bio_breve') : '';
        $foto   = function_exists('lanotte_team_foto') ? lanotte_team_foto($tid) : '';
        $badge  = $ruolo_labels[$ruolo] ?? 'Professionista';
        $nome   = trim(($titolo ? $titolo.' ' : '') . get_the_title());
        if (!$bio) $bio = get_the_excerpt();
      ?>
      <article class="ls-team-card">
        <?php if ($foto): ?><div class="ls-team-photo" style="background-image:url('<?php echo esc_url($foto); ?>')"></div><?php endif; ?>
        <div class="ls-team-badge"><?php echo esc_html($badge); ?></div>
        <h4><?php echo esc_html($nome); ?></h4>
        <?php if ($bio): ?><p><?php echo esc_html($bio); ?></p><?php endif; ?>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?>
    <div class="ls-team-grid">
      <article class="ls-team-card">
        <div class="ls-team-badge">Avvocato titolare</div>
        <h4>Avv. Giuseppe LANOTTE</h4>
        <p>Civilista, penalista e tributarista, iscritto all'Albo degli Avvocati di Trani dal 2011. Aree di pratica prevalenti: condominio, famiglia e successioni, responsabilità civile, diritto delle locazioni, diritto d'impresa.</p>
      </article>
      <article class="ls-team-card">
        <div class="ls-team-badge">Consulente fiscale</div>
        <h4>Dott. Ruggiero LANOTTE</h4>
        <p>Dottore commercialista. Affianca lo Studio nelle consulenze fiscali e tributarie, nella predisposizione del bilancio, nella valutazione d'azienda, nelle perizie asseverative.</p>
      </article>
    </div>
    <?php endif; ?>

    <h3 style="font-family:var(--serif);font-size:clamp(22px,3vw,28px);color:var(--navy);text-align:center;font-weight:600;margin:48px 0 24px">Collaborazioni esterne</h3>
    <p style="text-align:center;font-size:14.5px;color:#64748b;max-width:620px;margin:0 auto 28px;line-height:1.6">Lo Studio si avvale di collaboratori stabili con professionalità di comprovata esperienza, individuati per materia.</p>

    <div class="ls-collab-grid">
      <article class="ls-collab-card">
        <div class="ls-collab-tag">Patrocinio innanzi a giurisdizioni superiori</div>
        <h5>Avvocati cassazionisti specializzati</h5>
        <p>Per i gradi di legittimità innanzi alla Corte di Cassazione, al Consiglio di Stato e alla Corte di Cassazione tributaria, lo Studio si avvale di colleghi cassazionisti specializzati, distintamente per il ramo civile, penale, amministrativo e tributario.</p>
      </article>

      <article class="ls-collab-card">
        <div class="ls-collab-tag">Consulenza tecnica</div>
        <h5>CTP e periti di parte</h5>
        <p>Lo Studio collabora con una rete di consulenti tecnici di parte (ingegneri, medici legali, periti contabili) per le perizie asseverative sui rapporti bancari, le valutazioni del danno alla persona e le verifiche tecnico-strutturali nei procedimenti civili.</p>
      </article>
    </div>
  </div>
</section>

<!-- I NOSTRI TERRITORI: Trani · Barletta · Bari -->
<section style="background:#fff;padding:60px 0">
  <div class="container">
    <div style="text-align:center;margin-bottom:36px">
      <div class="section-eyebrow">I nostri territori</div>
      <h2 style="font-family:var(--serif);font-size:clamp(26px,3.5vw,36px);color:var(--navy);font-weight:600;margin:8px 0 12px">Trani · Barletta · Bari</h2>
      <p style="font-size:15.5px;color:#475569;max-width:660px;margin:0 auto;line-height:1.65">Lo Studio opera fra tre città legate da una storia giuridica antica, oggi unite dall'asse forense del Distretto di Bari.</p>
    </div>
    <div class="territori-grid">
      <div class="terr-card">
        <div class="terr-img" style="background-image:url('<?php echo esc_url(LANOTTE_THEME_URI); ?>/assets/img/trani/cattedrale-trani.jpg')"></div>
        <div class="terr-info">
          <div class="terr-tag">Foro · Iscrizione</div>
          <h4>Trani</h4>
          <p>Foro di iscrizione dello Studio. Sede storica della Corte d'Appello delle Puglie dal 1817 al 1923. Tribunale ordinario competente per l'intera provincia BAT.</p>
        </div>
      </div>
      <div class="terr-card">
        <div class="terr-img" style="background-image:url('<?php echo esc_url(LANOTTE_THEME_URI); ?>/assets/img/barletta/castello-cattedrale.jpg')"></div>
        <div class="terr-info">
          <div class="terr-tag">Sede</div>
          <h4>Barletta</h4>
          <p>Sede operativa dello Studio in Viale Falcone e Borsellino 75. Città storica del Foro di Trani, con il Castello Svevo e la Cattedrale di Santa Maria Maggiore a definirne l'identità civica.</p>
        </div>
      </div>
      <div class="terr-card">
        <div class="terr-img" style="background-image:url('<?php echo esc_url(LANOTTE_THEME_URI); ?>/assets/img/bari/castello-bari.jpg')"></div>
        <div class="terr-info">
          <div class="terr-tag">Corte d'Appello</div>
          <h4>Bari</h4>
          <p>Capoluogo regionale, sede della Corte d'Appello dal 1923 con giurisdizione su Bari, Foggia, Lecce, Taranto e Trani. Lo Studio opera presso le sue sedi giudiziarie nel secondo grado.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DOVE ESERCITIAMO: Sedi giudiziarie -->
<section style="background:var(--cream);padding:60px 0;border-top:1px solid #f0e9dc">
  <div class="container">
    <div style="text-align:center;margin-bottom:36px">
      <div class="section-eyebrow">Sedi giudiziarie</div>
      <h2 style="font-family:var(--serif);font-size:clamp(26px,3.5vw,36px);color:var(--navy);font-weight:600;margin:8px 0 12px">Dove esercitiamo</h2>
      <p style="font-size:15.5px;color:#475569;max-width:680px;margin:0 auto;line-height:1.65">Lo Studio opera stabilmente presso il Foro di Trani e, tramite corrispondenti qualificati, presso le principali sedi giudiziarie italiane.</p>
    </div>
    <div class="sedi-grid">
      <div class="sedi-photos">
        <div class="sedi-photo" style="background-image:url('<?php echo esc_url(LANOTTE_THEME_URI); ?>/assets/img/trani/corte-appello-puglie.jpg')">
          <div class="sedi-photo-caption">
            <div class="sedi-photo-tag">Sezione Penale &amp; Procura</div>
            <h4>Tribunale Penale di Trani</h4>
            <small>Sede della Procura della Repubblica · ex Corte d'Appello delle Puglie (1817-1923)</small>
          </div>
        </div>
        <div class="sedi-photo" style="background-image:url('<?php echo esc_url(LANOTTE_THEME_URI); ?>/assets/img/trani/palazzo-tribunale.jpg')">
          <div class="sedi-photo-caption">
            <div class="sedi-photo-tag">Sezione Civile</div>
            <h4>Tribunale di Trani</h4>
            <small>Tribunale ordinario competente per l'intera provincia BAT</small>
          </div>
        </div>
      </div>
      <div class="sedi-list">
        <h3>Foro di Trani come sede principale.</h3>
        <ul>
          <li><strong>Tribunale di Trani</strong><span>Sede di esercizio</span></li>
          <li><strong>Corte d'Appello di Bari</strong><span>II° grado</span></li>
          <li><strong>Altre sedi e Cassazione</strong><span>Tramite corrispondenti</span></li>
        </ul>
        <p class="sedi-note">Per la giurisdizione di legittimità e per le sedi giudiziarie fuori dal Foro di Trani, lo Studio si avvale di corrispondenti qualificati attivati caso per caso. In materia di <strong>marchi, brevetti e design</strong> lo Studio opera anche a livello internazionale: <strong>UIBM</strong>, <strong>EUIPO</strong> e <strong>OMPI/WIPO</strong>.</p>
        <div class="sedi-lingue">
          <div class="sedi-lingue-label">Lingue di lavoro</div>
          <p>🇮🇹 Italiano · 🇬🇧 Inglese · 🇪🇸 Spagnolo<br><small>Altre lingue tramite interpreti professionali</small></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- QUATTRO VALORI NON NEGOZIABILI -->
<section style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);color:#fff;padding:70px 0">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px">
      <div class="section-eyebrow" style="color:#d4b87f">Principi etici</div>
      <h2 style="font-family:var(--serif);font-size:clamp(26px,3.5vw,38px);color:#fff;font-weight:600;margin:8px 0 0">Quattro valori non negoziabili</h2>
    </div>
    <div class="valori-grid">
      <div class="valore">
        <div class="valore-num">I</div>
        <h4>Indipendenza</h4>
        <p>L'avvocato esercita la professione con indipendenza, lealtà, correttezza e diligenza. Lo Studio non accetta mandati che possano compromettere la libertà di giudizio.</p>
        <small>Art. 9 c.d.f.</small>
      </div>
      <div class="valore">
        <div class="valore-num">II</div>
        <h4>Segreto professionale</h4>
        <p>Quanto appreso dall'assistito è coperto da segreto in modo assoluto. Comunicazioni su canali sicuri e tracciati.</p>
        <small>Art. 28 c.d.f. · Artt. 200 c.p.p. e 622 c.p.</small>
      </div>
      <div class="valore">
        <div class="valore-num">III</div>
        <h4>Verità del compenso</h4>
        <p>Preventivo scritto sin dal primo incontro, ai sensi dell'art. 13 c. 5 L. 247/2012 (come modif. da L. 124/2017). I patti di quota lite sono vietati dall'art. 29 c. 4 c.d.f.</p>
        <small>Art. 29 c.d.f. · L. 247/2012</small>
      </div>
      <div class="valore">
        <div class="valore-num">IV</div>
        <h4>Continuità del rapporto</h4>
        <p>Le pratiche sono seguite personalmente dal titolare in ogni fase del mandato, con il supporto di colleghi consulenti specializzati per materia.</p>
        <small>&nbsp;</small>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

<?php get_template_part('template-parts/section-ctastrip'); ?>

<style>
.lo-studio-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:14px}
.lo-studio-list li{padding:16px 18px 16px 44px;background:#fff;border-radius:6px;border-left:3px solid var(--gold);font-size:15.5px;line-height:1.65;color:#334155;position:relative}
.lo-studio-list li::before{content:"✓";position:absolute;left:16px;top:16px;width:20px;height:20px;color:var(--gold);font-weight:700}

.ls-team-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;max-width:840px;margin:0 auto}
.ls-team-card{background:#fff;border:1px solid #e5e7eb;border-top:3px solid var(--gold);border-radius:8px;padding:28px 26px;transition:all .2s;overflow:hidden}
.ls-team-photo{width:88px;height:88px;border-radius:50%;background-size:cover;background-position:center top;margin-bottom:16px;border:3px solid #f0e9dc}
.ls-team-card:hover{box-shadow:0 14px 28px -16px rgba(15,23,42,.18);transform:translateY(-2px)}
.ls-team-badge{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:12px}
.ls-team-card h4{font-family:var(--serif);font-size:22px;color:var(--navy);font-weight:600;margin:0 0 12px;line-height:1.25}
.ls-team-card p{font-size:14.5px;line-height:1.65;color:#475569;margin:0}

.ls-collab-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;max-width:1000px;margin:0 auto}
.ls-collab-card{background:#fff;border:1px solid #e5e7eb;border-radius:6px;padding:24px 22px;display:flex;flex-direction:column}
.ls-collab-tag{font-size:10.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:10px;line-height:1.4}
.ls-collab-card h5{font-family:var(--serif);font-size:17px;color:var(--navy);font-weight:600;margin:0 0 10px;line-height:1.3}
.ls-collab-card p{font-size:13.5px;line-height:1.6;color:#475569;margin:0 0 12px;flex-grow:1}
.ls-collab-card small{font-size:12.5px;color:#64748b}
.ls-collab-card small a{color:var(--gold);text-decoration:none;font-weight:600}

@media (max-width:900px){
  .ls-team-grid{grid-template-columns:1fr;gap:16px;max-width:520px}
  .ls-collab-grid{grid-template-columns:1fr;gap:14px;max-width:520px}
  .ls-team-card{padding:24px 20px}
  .ls-collab-card{padding:22px 18px}
}
@media (max-width:600px){
  .lo-studio-list li{padding:14px 16px 14px 40px;font-size:14.5px}
  .ls-team-card h4{font-size:20px}
}

/* ===== TERRITORI ===== */
.territori-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:1100px;margin:0 auto}
.terr-card{background:#fff;border:1px solid #e5e7eb;border-radius:6px;overflow:hidden;transition:all .25s}
.terr-card:hover{transform:translateY(-3px);box-shadow:0 16px 32px -16px rgba(15,23,42,.18)}
.terr-img{aspect-ratio:4/3;background-size:cover;background-position:center}
.terr-info{padding:22px 24px;border-top:3px solid var(--gold)}
.terr-tag{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:6px}
.terr-info h4{font-family:var(--serif);font-size:22px;color:var(--navy);font-weight:600;margin:0 0 8px}
.terr-info p{font-size:14px;line-height:1.6;color:#475569;margin:0}

/* ===== SEDI ===== */
.sedi-grid{display:grid;grid-template-columns:1.3fr 1fr;gap:32px;align-items:stretch;max-width:1100px;margin:0 auto}
.sedi-photos{display:grid;grid-template-rows:1fr 1fr;gap:14px;min-height:440px}
.sedi-photo{background-size:cover;background-position:center;border-top:3px solid var(--gold);position:relative;min-height:220px}
.sedi-photo-caption{position:absolute;left:0;right:0;bottom:0;padding:18px 22px;background:linear-gradient(to top,rgba(14,26,51,.95),transparent 80%);color:#fff}
.sedi-photo-tag{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#d4b87f;font-weight:600;margin-bottom:2px}
.sedi-photo-caption h4{font-family:var(--serif);font-size:20px;font-weight:600;margin:0 0 4px;color:#fff}
.sedi-photo-caption small{font-size:11.5px;color:#cbd5e1;font-style:italic;line-height:1.4}
.sedi-list{background:#fff;padding:30px 32px;border-top:3px solid var(--gold);display:flex;flex-direction:column;justify-content:center;border-radius:6px}
.sedi-list h3{font-family:var(--serif);font-size:22px;color:var(--navy);font-weight:600;margin:0 0 18px;line-height:1.3}
.sedi-list ul{list-style:none;padding:0;margin:0 0 16px}
.sedi-list ul li{padding:11px 0;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px}
.sedi-list ul li:last-child{border-bottom:0}
.sedi-list ul li strong{color:var(--navy);font-size:14.5px}
.sedi-list ul li span{font-size:12.5px;color:#64748b}
.sedi-note{font-size:13px;color:#64748b;margin:0;line-height:1.6;font-style:italic;padding-top:14px;border-top:1px solid #f1f5f9}
.sedi-lingue{margin-top:18px;padding-top:18px;border-top:1px solid #f1f5f9}
.sedi-lingue-label{font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:8px}
.sedi-lingue p{margin:0;font-size:14px;color:#334155;line-height:1.5}
.sedi-lingue p small{font-size:12px;color:#64748b}

/* ===== VALORI ===== */
.valori-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;max-width:1100px;margin:0 auto}
.valore{background:rgba(255,255,255,.04);padding:28px 24px;border-top:3px solid var(--gold);border-radius:4px;backdrop-filter:blur(6px)}
.valore-num{font-family:var(--serif);font-size:38px;color:var(--gold);font-weight:600;line-height:1;margin-bottom:14px}
.valore h4{font-family:var(--serif);font-size:19px;color:#fff;font-weight:600;margin:0 0 12px}
.valore p{font-size:13.5px;line-height:1.6;color:#cbd5e1;margin:0 0 12px}
.valore small{font-size:11px;color:#94a3b8;letter-spacing:.04em}

@media (max-width:1000px){
  .valori-grid{grid-template-columns:repeat(2,1fr)}
}
@media (max-width:780px){
  .territori-grid{grid-template-columns:1fr;max-width:480px}
  .sedi-grid{grid-template-columns:1fr;gap:18px}
  .sedi-photos{min-height:auto}
  .sedi-photo{min-height:200px}
  .sedi-list{padding:24px 22px}
}
@media (max-width:600px){
  .valori-grid{grid-template-columns:1fr;max-width:420px}
  .terr-info{padding:18px 20px}
  .terr-info h4{font-size:20px}
}
</style>

<?php endwhile; get_footer();
