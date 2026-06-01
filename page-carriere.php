<?php
/**
 * Template Name: Carriere
 *
 * @package lanotte-2026
 */
get_header();
while (have_posts()): the_post();

$hero_bg          = LANOTTE_THEME_URI . '/assets/img/trani/corte-appello-puglie.jpg';
$candidatura_mail = 'mailto:' . lanotte_email() . '?subject=Candidatura%20Studio%20Lanotte';
?>

<section class="hero-internal" style="background-image:linear-gradient(135deg,rgba(14,26,51,.88) 0%,rgba(26,42,74,.78) 100%),url('<?php echo esc_url($hero_bg); ?>');background-size:cover;background-position:center;padding:110px 0 80px;color:#fff">
  <div class="container" style="position:relative;z-index:2">
    <?php lanotte_breadcrumbs(); ?>
    <div class="carriere-badge">⚖️ Cerchiamo nuovi avvocati</div>
    <h1 style="color:#fff;font-size:clamp(28px,5vw,48px);line-height:1.15;margin:8px 0 14px">Unisciti allo Studio.<br>Cresci con un team multidisciplinare.</h1>
    <p class="subtitle" style="color:#d4d8e0;max-width:760px">Cerchiamo avvocati, praticanti e partner che condividano i nostri principi: indipendenza, segreto professionale, verità del compenso, continuità del rapporto. Lavoriamo in modo serio, con metodo, su pratiche di valore.</p>
  </div>
</section>

<!-- PROFILI CERCATI -->
<section class="block">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Posizioni aperte</div>
      <h2>Tre profili che stiamo cercando</h2>
      <p>Lo Studio sta crescendo. Cerchiamo professionisti motivati per integrare le nostre aree di competenza, sia per attività ricorrente sia per progetti specifici.</p>
    </div>
    <div class="carriere-profili-grid">

      <div class="carriere-profilo">
        <div class="carriere-tag carriere-tag-soft">⏱️ Tempo pieno</div>
        <div class="carriere-num">01</div>
        <h3>Avvocato Associato</h3>
        <p>Avvocato con almeno 3-5 anni di esperienza in una delle nostre 13 aree. Capacità di gestire autonomamente fascicoli civili o penali di media complessità, redigere atti, partecipare a udienze, interfacciarsi con il cliente.</p>
        <div class="carriere-req">
          <div class="carriere-req-title">Requisiti</div>
          <ul>
            <li>✓ Iscrizione Albo Avvocati</li>
            <li>✓ Padronanza scrittura forense</li>
            <li>✓ Specializzazione in 1-2 aree</li>
            <li>✓ Disponibilità a udienze in BAT/Bari</li>
            <li>✓ Inglese giuridico (gradito)</li>
          </ul>
        </div>
      </div>

      <div class="carriere-profilo carriere-profilo-featured">
        <div class="carriere-tag carriere-tag-gold">📚 Praticantato</div>
        <div class="carriere-num">02</div>
        <h3>Praticante Avvocato</h3>
        <p>Laureato in Giurisprudenza, con voto di laurea minimo 105/110. Curiosità, voglia di imparare, disponibilità ad approfondire le materie. Lo Studio offre un percorso strutturato di 18 mesi con turn-over nelle aree principali.</p>
        <div class="carriere-req">
          <div class="carriere-req-title">Cosa offriamo</div>
          <ul>
            <li>✓ Compenso adeguato fin dal 1° anno</li>
            <li>✓ Tutor dedicato per ciascuna area</li>
            <li>✓ Esposizione a procedure complete</li>
            <li>✓ Formazione interna sui sistemi</li>
            <li>✓ Possibilità di assunzione post-esame</li>
          </ul>
        </div>
      </div>

      <div class="carriere-profilo">
        <div class="carriere-tag carriere-tag-soft">🤝 Of Counsel</div>
        <div class="carriere-num">03</div>
        <h3>Partner / Of Counsel</h3>
        <p>Avvocato senior con clientela propria e specializzazione consolidata. Possibilità di integrazione come partner equity oppure of counsel su progetti specifici, mantenendo autonomia della propria attività.</p>
        <div class="carriere-req">
          <div class="carriere-req-title">Idealmente</div>
          <ul>
            <li>✓ Specializzazione complementare</li>
            <li>✓ Clientela propria di qualità</li>
            <li>✓ 10+ anni di esperienza</li>
            <li>✓ Cassazionista (gradito)</li>
            <li>✓ Sede aggiuntiva sul territorio</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- COSA OFFRIAMO / VALORI -->
<section class="block" style="background:var(--cream)">
  <div class="container">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Perché lavorare con noi</div>
      <h2>Cosa offriamo</h2>
      <p>Lo Studio non è una catena di montaggio: lavoriamo con metodo, su pratiche di valore, con clienti che ci scelgono per la nostra reputazione.</p>
    </div>
    <div class="carriere-offer-grid">
      <div class="carriere-offer">
        <h4>⚖️ Pratiche di valore</h4>
        <p>Non gestiamo migliaia di fascicoli "a basso valore": preferiamo poche pratiche curate. Avrai esposizione a casi complessi sin dai primi mesi.</p>
      </div>
      <div class="carriere-offer">
        <h4>📚 Crescita strutturata</h4>
        <p>Tutor dedicato, formazione continua, partecipazione a convegni e corsi di specializzazione. Lo Studio investe sui giovani professionisti.</p>
      </div>
      <div class="carriere-offer">
        <h4>🤝 Ambiente collaborativo</h4>
        <p>Confronto continuo sui fascicoli, riunioni settimanali, condivisione del know-how interno. Il successo è di squadra, non individuale.</p>
      </div>
      <div class="carriere-offer">
        <h4>💼 Compenso trasparente</h4>
        <p>Retribuzione conforme ai parametri di legge e di mercato. Bonus annuale legato ai risultati. Niente esperienze gratuite o sottopagate.</p>
      </div>
      <div class="carriere-offer">
        <h4>🖥️ Strumenti professionali</h4>
        <p>Software gestionale Cliens, accessi a banche dati (One LEGALE, DeJure), tecnologia per smart working e udienze da remoto. Niente più carta volante.</p>
      </div>
      <div class="carriere-offer">
        <h4>🏛️ Posizione strategica</h4>
        <p>Sede a Barletta nel cuore della BAT, a 15 minuti dal Tribunale di Trani, 45 minuti da Bari. Foro di Trani: tradizione e prossimità al cliente.</p>
      </div>
    </div>
  </div>
</section>

<!-- COME CANDIDARSI -->
<section class="block">
  <div class="container" style="max-width:780px">
    <div class="section-title">
      <div class="divider-dot"></div>
      <div class="section-eyebrow">Come candidarti</div>
      <h2>La nostra procedura di selezione</h2>
    </div>
    <div class="carriere-timeline">
      <div class="carriere-step">
        <div class="carriere-step-num">1</div>
        <h4>Invia CV e lettera motivazionale</h4>
        <p>Manda CV aggiornato + breve lettera (max 1 pagina) che indichi: posizione di interesse, aree di specializzazione, motivazione, eventuali disponibilità geografiche.<br><strong>Email:</strong> <a href="mailto:<?php echo esc_attr(lanotte_email()); ?>?subject=Candidatura%20-%20[Profilo]%20-%20[Nome%20Cognome]" style="color:var(--gold)"><?php echo esc_html(lanotte_email()); ?></a></p>
      </div>
      <div class="carriere-step">
        <div class="carriere-step-num">2</div>
        <h4>Screening e primo colloquio</h4>
        <p>Tutte le candidature vengono valutate entro 15 giorni. I profili in linea ricevono invito a un primo colloquio conoscitivo (in studio o in videocall).</p>
      </div>
      <div class="carriere-step">
        <div class="carriere-step-num">3</div>
        <h4>Prova pratica</h4>
        <p>A seconda della posizione, possiamo proporre una breve prova: parere su un caso, redazione di un atto introduttivo, simulazione di colloquio con cliente. Tempo richiesto: 3-5 ore.</p>
      </div>
      <div class="carriere-step" style="margin-bottom:0">
        <div class="carriere-step-num">4</div>
        <h4>Colloquio finale e proposta</h4>
        <p>Incontro con i partner per definire ruolo, condizioni economiche, percorso di crescita. Riceverai una <strong>proposta scritta</strong> entro 7 giorni dall'ultimo colloquio.</p>
      </div>
    </div>

    <div class="carriere-cta-box">
      <h3>Candidature spontanee benvenute</h3>
      <p>Anche se non hai un profilo perfettamente in linea con quelli sopra, mandaci la tua candidatura. Valutiamo regolarmente nuovi inserimenti su tutte le aree.</p>
      <a href="<?php echo esc_url($candidatura_mail); ?>" class="btn btn-primary">Candidati</a>
    </div>
  </div>
</section>

<style>
.carriere-badge{display:inline-block;background:var(--gold);color:#fff;padding:6px 14px;font-size:11px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;margin-bottom:18px}

/* === PROFILI === */
.carriere-profili-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:40px}
.carriere-profilo{background:#fff;border:1px solid var(--border);padding:36px 28px;border-top:4px solid var(--gold);position:relative}
.carriere-profilo-featured{border:1px solid var(--gold);box-shadow:0 24px 50px -20px rgba(184,153,104,.4)}
.carriere-tag{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:5px 10px;border-radius:2px}
.carriere-tag-soft{background:var(--cream);color:var(--navy)}
.carriere-tag-gold{background:var(--gold);color:#fff}
.carriere-num{font-family:var(--serif);font-size:48px;color:var(--gold);font-weight:600;line-height:1;margin-bottom:12px}
.carriere-profilo h3{font-family:var(--serif);font-size:24px;color:var(--navy);font-weight:600;margin-bottom:14px}
.carriere-profilo > p{font-size:14px;color:var(--text-muted);line-height:1.65;margin-bottom:20px}
.carriere-req{border-top:1px solid var(--border);padding-top:18px}
.carriere-req-title{font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:10px}
.carriere-req ul{list-style:none;padding:0;margin:0;font-size:13.5px;color:var(--text)}
.carriere-req li{padding:5px 0}

/* === OFFER === */
.carriere-offer-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;margin:32px auto 0;max-width:980px}
.carriere-offer{background:#fff;padding:28px;border-top:3px solid var(--gold)}
.carriere-offer h4{font-family:var(--serif);font-size:20px;color:var(--navy);margin-bottom:10px}
.carriere-offer p{font-size:14px;color:var(--text-muted);line-height:1.65}

/* === TIMELINE CANDIDATURA === */
.carriere-timeline{position:relative;padding-left:36px;border-left:2px solid var(--gold);margin-top:32px}
.carriere-step{margin-bottom:32px;position:relative}
.carriere-step-num{position:absolute;left:-48px;width:28px;height:28px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
.carriere-step h4{font-family:var(--serif);font-size:20px;color:var(--navy);margin-bottom:6px}
.carriere-step p{color:var(--text-muted);line-height:1.65}

/* === CTA SPONTANEE === */
.carriere-cta-box{margin-top:48px;padding:32px;background:var(--cream);border-top:3px solid var(--gold);text-align:center}
.carriere-cta-box h3{font-family:var(--serif);font-size:24px;color:var(--navy);margin-bottom:10px}
.carriere-cta-box p{color:var(--text-muted);margin-bottom:24px}

/* === MOBILE === */
@media (max-width:980px){
  .carriere-profili-grid{grid-template-columns:1fr;gap:18px;max-width:560px;margin:32px auto 0}
}
@media (max-width:680px){
  .carriere-offer-grid{grid-template-columns:1fr;gap:14px}
  .carriere-profilo{padding:28px 22px}
  .carriere-profilo h3{font-size:21px}
  .carriere-num{font-size:38px}
  .carriere-offer{padding:22px 20px}
  .carriere-timeline{padding-left:28px}
  .carriere-step-num{left:-40px}
  .carriere-cta-box{padding:24px 20px}
}
</style>

<?php endwhile; get_footer();
