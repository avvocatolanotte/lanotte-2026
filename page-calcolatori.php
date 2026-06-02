<?php
/**
 * Template Name: Calcolatori (hub)
 * Template Post Type: page
 *
 * @package lanotte-2026
 */
get_header();

$calc_base = LANOTTE_THEME_URI . '/calcolatori';
?>

<section style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);color:#fff;padding:80px 0 70px">
  <div class="container">
    <nav style="font-size:13px;color:#cbd5e1;margin-bottom:14px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:#cbd5e1">Home</a> <span style="opacity:.5">›</span> <span style="color:#b89968">Calcolatori</span></nav>
    <span style="display:inline-block;padding:6px 14px;background:rgba(184,153,104,.18);border:1px solid rgba(184,153,104,.4);border-radius:2px;font-size:11px;letter-spacing:.14em;color:#d4b87f;font-weight:600;text-transform:uppercase;margin-bottom:18px">16 strumenti professionali · Tutti con PDF carta intestata</span>
    <h1 style="font-family:var(--serif);font-size:54px;font-weight:600;line-height:1.05;margin:0 0 22px;color:#fff">Calcolatori<br><em style="font-style:italic;color:#d4b87f">giuridici e patrimoniali</em></h1>
    <p style="font-size:17px;line-height:1.65;color:#cbd5e1;max-width:780px;margin:0">Parcelle, scadenze, lesioni, ISTAT, interessi, contestazioni bollette. Indici e tassi <strong style="color:#fff">aggiornati automaticamente</strong> dalle fonti ufficiali. Output PDF con carta intestata Studio.</p>
  </div>
</section>

<section style="background:#fef9e7;border-bottom:1px solid #f0e9dc;padding:18px 0">
  <div class="container" style="display:flex;align-items:flex-start;gap:14px">
    <svg width="22" height="22" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <div style="font-size:13.5px;color:#78350f;line-height:1.55"><strong>Valori indicativi.</strong> I calcolatori riproducono normativa e parametri ufficiali ma il risultato va verificato. Ex art. 14 c.d.f. non costituiscono parere legale.</div>
  </div>
</section>

<section style="background:#fafaf7;padding:60px 0">
  <div class="container">

    <div class="cat-header">
      <div class="cat-eyebrow">Categoria 1 di 4</div>
      <h2 class="cat-title">Compensi e onorari forensi</h2>
      <p class="cat-subtitle">Parametri DM 55/2014 aggiornati al DM 147/2022. Per fasi del giudizio, materia e valore.</p>
    </div>
    <div class="calc-grid">
      <a href="<?php echo esc_url("$calc_base/parcella-civile.html"); ?>" class="calc-card cat-1"><div class="calc-icon">⚖️</div><h3>Parcella Civile</h3><p>Tribunale, Corte d'Appello, Cassazione</p><span class="calc-tag">DM 55/2014</span></a>
      <a href="<?php echo esc_url("$calc_base/parcella-penale.html"); ?>" class="calc-card cat-1"><div class="calc-icon">🔨</div><h3>Parcella Penale</h3><p>Indagini, dibattimento, gravame</p><span class="calc-tag">DM 55/2014</span></a>
      <a href="<?php echo esc_url("$calc_base/stragiudiziale.html"); ?>" class="calc-card cat-1"><div class="calc-icon">🤝</div><h3>Stragiudiziale</h3><p>Mediazione, negoziazione assistita</p><span class="calc-tag">DM 55/2014 + D.Lgs. 28/2010</span></a>
      <a href="<?php echo esc_url("$calc_base/sfratti.html"); ?>" class="calc-card cat-1"><div class="calc-icon">🏠</div><h3>Procedimento Sfratto</h3><p>Finita locazione / morosità / opposizione</p><span class="calc-tag">DM 55/2014 + L. 392/1978</span></a>
    </div>

    <div class="cat-header" style="margin-top:64px">
      <div class="cat-eyebrow">Categoria 2 di 4</div>
      <h2 class="cat-title">Lesioni e danni</h2>
      <p class="cat-subtitle">Tabelle Milano 2024 e TUN DPR 12/2025. Formula Balthazard per menomazioni preesistenti.</p>
    </div>
    <div class="calc-grid">
      <a href="<?php echo esc_url("$calc_base/micropermanenti.html"); ?>" class="calc-card cat-2"><div class="calc-icon">🩺</div><h3>Micropermanenti</h3><p>1-9 punti IP · DM 18/7/2025</p><span class="calc-tag">Art. 139 CdA</span></a>
      <a href="<?php echo esc_url("$calc_base/macropermanenti.html"); ?>" class="calc-card cat-2"><div class="calc-icon">🦴</div><h3>Macropermanenti</h3><p>10-100 punti IP · TUN DPR 12/2025</p><span class="calc-tag">TUN + Milano</span></a>
      <a href="<?php echo esc_url("$calc_base/danni-preesistenti.html"); ?>" class="calc-card cat-2"><div class="calc-icon">📊</div><h3>Coesistenti / Concorrenti</h3><p>Formula Balthazard · Sottrazione monetaria</p><span class="calc-tag">Cass. SU 28986/2019</span></a>
    </div>

    <div class="cat-header" style="margin-top:64px">
      <div class="cat-eyebrow">Categoria 3 di 4 · ⚡ Auto-aggiornamento</div>
      <h2 class="cat-title">Aggiornamenti monetari e interessi</h2>
      <p class="cat-subtitle">Indici ISTAT FOI e tassi MEF aggiornati dalle fonti ufficiali. Cache locale + fallback JSON.</p>
    </div>
    <div class="calc-grid">
      <a href="<?php echo esc_url("$calc_base/istat-locazione.html"); ?>" class="calc-card cat-3 highlight"><span class="calc-badge">⚡ ISTAT</span><div class="calc-icon">🏘️</div><h3>Aumento ISTAT Locazione</h3><p>Canone al 75% FOI · Bozza richiesta scritta</p><span class="calc-tag">Art. 32 L. 392/1978</span></a>
      <a href="<?php echo esc_url("$calc_base/mantenimento-istat.html"); ?>" class="calc-card cat-3 highlight"><span class="calc-badge">⚡ ISTAT</span><div class="calc-icon">👨‍👩‍👧</div><h3>Adeguamento Mantenimento</h3><p>Coniuge/figli al 100% FOI · Arretrati</p><span class="calc-tag">Artt. 156 + 337-ter c.c.</span></a>
      <a href="<?php echo esc_url("$calc_base/svalutazione.html"); ?>" class="calc-card cat-3 highlight"><span class="calc-badge">⚡ ISTAT + MEF</span><div class="calc-icon">💰</div><h3>Svalutazione Monetaria</h3><p>FOI + interessi legali sul capitale rivalutato</p><span class="calc-tag">Art. 1224 c.c. + Cass. SU 1712/1995</span></a>
      <a href="<?php echo esc_url("$calc_base/interessi-legali.html"); ?>" class="calc-card cat-3 highlight"><span class="calc-badge">⚡ MEF</span><div class="calc-icon">📈</div><h3>Interessi Legali</h3><p>Tassi MEF dal 1942 ad oggi · Per scaglione</p><span class="calc-tag">Art. 1284 c.c.</span></a>
      <a href="<?php echo esc_url("$calc_base/interessi-moratori.html"); ?>" class="calc-card cat-3 highlight"><span class="calc-badge">⚡ MEF</span><div class="calc-icon">⏰</div><h3>Interessi Moratori B2B</h3><p>BCE + 8 punti · €40 spese recupero art. 6</p><span class="calc-tag">D.Lgs. 231/2002</span></a>
    </div>

    <div class="cat-header" style="margin-top:64px">
      <div class="cat-eyebrow">Categoria 4 di 4</div>
      <h2 class="cat-title">Strumenti procedurali e contestazioni</h2>
      <p class="cat-subtitle">Scadenze processuali e bollette utenze. Bozze di reclamo pronte da inviare.</p>
    </div>
    <div class="calc-grid">
      <a href="<?php echo esc_url("$calc_base/scadenze.html"); ?>" class="calc-card cat-4"><div class="calc-icon">📅</div><h3>Scadenze Processuali</h3><p>Sospensione feriale · Google Calendar + .ics</p><span class="calc-tag">L. 742/1969 + art. 155 c.p.c.</span></a>
      <a href="<?php echo esc_url("$calc_base/aqp.html"); ?>" class="calc-card cat-4"><div class="calc-icon">💧</div><h3>Bolletta AQP — Verifica + Reclamo</h3><p>Verifica calcolo, perdite occulte, reclamo ARERA</p><span class="calc-tag">Delibera ARERA 547/2019 + 655/2015</span></a>
      <a href="<?php echo esc_url("$calc_base/contributo-unificato.html"); ?>" class="calc-card cat-4"><div class="calc-icon">🏛️</div><h3>Contributo Unificato</h3><p>Tasse giudiziarie per valore e tipo di causa</p><span class="calc-tag">DPR 115/2002 art. 13</span></a>
      <a href="<?php echo esc_url("$calc_base/timeline-marchio.html"); ?>" class="calc-card cat-4"><div class="calc-icon">™️</div><h3>Timeline Marchio UIBM/EUIPO</h3><p>Date stimate deposito → registrazione + opposizione</p><span class="calc-tag">Reg. UE 2017/1001 + CPI</span></a>
    </div>

    <div style="margin-top:60px;padding:40px;background:linear-gradient(135deg,var(--navy) 0%,#1a2a4a 100%);border-radius:8px;color:#fff;text-align:center">
      <h3 style="font-family:var(--serif);font-size:26px;color:#fff;margin:0 0 12px">Vuoi un preventivo scritto sul tuo caso?</h3>
      <p style="color:#cbd5e1;font-size:15px;max-width:580px;margin:0 auto 24px;line-height:1.6">I calcolatori forniscono valori indicativi. Per un preventivo personalizzato ex art. 13 L. 247/2012 contattaci.</p>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('contatti'))); ?>" class="btn btn-primary">Richiedi un preventivo →</a>
    </div>

  </div>
</section>

<style>
.cat-header{margin-bottom:24px;text-align:center}
.cat-eyebrow{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:6px}
.cat-title{font-family:var(--serif);font-size:32px;color:var(--navy);font-weight:600;margin:0 0 10px}
.cat-subtitle{font-size:15px;color:#475569;line-height:1.6;max-width:680px;margin:0 auto}
.calc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px}
.calc-card{background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:28px 24px;text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:all .25s;position:relative;border-top:4px solid var(--gold)}
.calc-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px -14px rgba(15,23,42,.18);border-color:var(--gold)}
.calc-card.cat-1{border-top-color:#0f172a}
.calc-card.cat-2{border-top-color:#9d174d}
.calc-card.cat-3{border-top-color:#065f46}
.calc-card.cat-3.highlight{background:linear-gradient(180deg,#fdfbf5 0%,#fff 100%);border:1px solid #f0e9dc;border-top:4px solid #065f46}
.calc-card.cat-4{border-top-color:#1e3a8a}
.calc-icon{font-size:36px;margin-bottom:12px;line-height:1}
.calc-card h3{font-family:var(--serif);font-size:19px;color:var(--navy);font-weight:600;margin:0 0 8px;line-height:1.25}
.calc-card p{font-size:13.5px;line-height:1.5;color:#475569;margin:0 0 14px;flex-grow:1}
.calc-tag{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8;font-weight:600;padding-top:12px;border-top:1px solid #f1f5f9}
.calc-badge{position:absolute;top:-10px;right:14px;background:#065f46;color:#fff;font-size:10px;letter-spacing:.06em;font-weight:700;padding:4px 9px;border-radius:2px;text-transform:uppercase}
@media (max-width:600px){.calc-grid{grid-template-columns:1fr}.cat-title{font-size:24px}}
</style>

<?php get_footer();
