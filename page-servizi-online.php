<?php
/**
 * Template Name: Servizi Online (catalogo)
 *
 * @package lanotte-2026
 */
get_header();

// Query servizi attivi
$servizi_q = new WP_Query([
    'post_type'      => 'servizio',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
    'meta_query'     => [[ 'key' => 'attivo', 'value' => '1', 'compare' => '=' ]],
]);

// Etichette categoria filtri (deve coincidere con field_servizio_categoria)
$cat_labels = [
    'consulenza'    => 'Consulenza',
    'civile'        => 'Civile',
    'penale'        => 'Penale',
    'impresa'       => 'Impresa',
    'famiglia'      => 'Famiglia',
    'contratti'     => 'Contratti',
    'ip'            => 'Marchi &amp; IP',
    'tributario'    => 'Tributario',
    'internazionale'=> 'Internazionale',
];
// Gradient palette per icona card
$gradients = [
    'navy'   => 'linear-gradient(135deg,#0f172a,#1e293b)',
    'amber'  => 'linear-gradient(135deg,#7c2d12,#9a3412)',
    'red'    => 'linear-gradient(135deg,#7f1d1d,#991b1b)',
    'green'  => 'linear-gradient(135deg,#064e3b,#065f46)',
    'pink'   => 'linear-gradient(135deg,#9d174d,#be185d)',
    'blue'   => 'linear-gradient(135deg,#1e3a8a,#1e40af)',
    'purple' => 'linear-gradient(135deg,#581c87,#6b21a8)',
];
// Colore secondario icona
$icon_colors = [
    'navy'=>'#d4b87f','amber'=>'#fed7aa','red'=>'#fecaca',
    'green'=>'#a7f3d0','pink'=>'#fbcfe8','blue'=>'#bfdbfe','purple'=>'#e9d5ff'
];
?>

<!-- HERO -->
<section style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);color:#fff;padding:80px 0 70px;position:relative;overflow:hidden">
  <div class="container" style="position:relative;z-index:1">
    <nav style="font-size:13px;color:#cbd5e1;margin-bottom:18px;letter-spacing:.04em">
      <a href="<?php echo esc_url(home_url('/')); ?>" style="color:#cbd5e1">Home</a>
      <span style="opacity:.5;margin:0 8px">›</span>
      <span style="color:#b89968">Servizi online</span>
    </nav>
    <h1 style="font-family:var(--serif);font-size:54px;font-weight:600;line-height:1.05;margin:0 0 22px;letter-spacing:-.5px">Servizi legali<br><em style="font-style:italic;color:#d4b87f">a richiesta online</em></h1>
    <p style="font-size:18px;line-height:1.6;color:#cbd5e1;max-width:580px;margin:0">Selezioni i servizi di interesse e li aggiunga alla richiesta. Riceverà un <strong style="color:#fff">preventivo scritto personalizzato</strong> entro 48 ore lavorative, conforme all'art. 13 L. 247/2012.</p>
  </div>
</section>

<!-- DISCLAIMER -->
<section style="background:#fef9e7;border-bottom:1px solid #f0e9dc;padding:18px 0">
  <div class="container" style="display:flex;align-items:flex-start;gap:14px">
    <svg width="22" height="22" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    <div style="font-size:13.5px;color:#78350f;line-height:1.55">
      <strong>Servizi non vendibili a prezzo fisso indeterminato.</strong> Ai sensi dell'art. 13 L. 247/2012 ogni prestazione è soggetta a <strong>preventivo scritto personalizzato</strong>.
    </div>
  </div>
</section>

<!-- FILTRI -->
<section style="background:rgba(255,255,255,.95);border-bottom:1px solid #e5e7eb;padding:22px 0;position:sticky;top:64px;z-index:20;backdrop-filter:blur(8px)">
  <div class="container" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
    <strong style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#64748b;font-weight:600;margin-right:10px">Filtra per area:</strong>
    <button class="srv-filter active" data-filter="all">Tutti i servizi</button>
    <?php foreach ($cat_labels as $key => $label): ?>
      <button class="srv-filter" data-filter="<?php echo esc_attr($key); ?>"><?php echo $label; ?></button>
    <?php endforeach; ?>
  </div>
</section>

<!-- CATALOGO -->
<section style="background:#fafaf7;padding:60px 0">
  <div class="container">
    <?php if ($servizi_q->have_posts()): ?>
    <div class="srv-grid" id="srvGrid">
      <?php while ($servizi_q->have_posts()): $servizi_q->the_post();
        $cat       = function_exists('get_field') ? get_field('categoria_filtro') : 'consulenza';
        $sku       = function_exists('get_field') ? get_field('sku') : 'svc-'.get_the_ID();
        $desc      = function_exists('get_field') ? get_field('descrizione_breve') : '';
        $icona     = function_exists('get_field') ? get_field('icona') : '';
        $gradient  = function_exists('get_field') ? get_field('gradient') : 'navy';
        $features  = function_exists('get_field') ? get_field('features') : [];
        $sottotit  = function_exists('get_field') ? get_field('sottotitolo') : '';
        $prezzo    = function_exists('get_field') ? get_field('prezzo_indicativo') : '';
        $evidenza  = function_exists('get_field') ? get_field('in_evidenza') : false;
        $area_id   = function_exists('get_field') ? get_field('area_collegata') : 0;
        $bg        = $gradients[$gradient] ?? $gradients['navy'];
        $ic_color  = $icon_colors[$gradient] ?? '#d4b87f';
        $cat_label = $cat_labels[$cat] ?? ucfirst($cat);
        $title     = get_the_title();
      ?>
      <article class="srv-card<?php echo $evidenza ? ' is-featured' : ''; ?>" data-cat="<?php echo esc_attr($cat); ?>" data-sku="<?php echo esc_attr($sku); ?>" data-name="<?php echo esc_attr($title); ?>">
        <?php if ($evidenza): ?><span class="srv-featured-tag">★ In evidenza</span><?php endif; ?>
        <div class="srv-icon" style="background:<?php echo esc_attr($bg); ?>">
          <?php if ($icona): echo wp_kses($icona, [
            'svg'=>['width'=>1,'height'=>1,'fill'=>1,'stroke'=>1,'stroke-width'=>1,'viewbox'=>1,'xmlns'=>1],
            'path'=>['d'=>1,'fill'=>1,'stroke'=>1],
            'circle'=>['cx'=>1,'cy'=>1,'r'=>1],
            'rect'=>['x'=>1,'y'=>1,'width'=>1,'height'=>1,'rx'=>1],
            'line'=>['x1'=>1,'y1'=>1,'x2'=>1,'y2'=>1]
          ]);
          else: ?>
          <svg width="22" height="22" fill="none" stroke="<?php echo esc_attr($ic_color); ?>" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
          <?php endif; ?>
        </div>
        <span class="srv-badge"><?php echo $cat_label; ?></span>
        <h3><?php echo esc_html($title); ?></h3>
        <?php if ($sottotit): ?><p class="srv-subtitle"><?php echo esc_html($sottotit); ?></p><?php endif; ?>
        <p><?php echo esc_html($desc); ?></p>
        <?php if ($features && is_array($features)): ?>
        <ul class="srv-feat">
          <?php foreach (array_slice($features, 0, 5) as $f): if (!empty($f['testo'])): ?>
          <li><?php echo esc_html($f['testo']); ?></li>
          <?php endif; endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if ($prezzo): ?>
        <div class="srv-prezzo"><?php echo esc_html($prezzo); ?> <small style="display:block;font-size:11px;color:#94a3b8;font-weight:400;margin-top:2px">Orientativo — preventivo personalizzato ex L. 247/2012</small></div>
        <?php endif; ?>
        <?php if ($area_id): $area_link = get_permalink($area_id); ?>
        <a href="<?php echo esc_url($area_link); ?>" class="srv-area-link">Vedi area di pratica →</a>
        <?php endif; ?>
        <button class="btn srv-add" type="button">Aggiungi alla richiesta
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:6px">
      <h3 style="font-family:var(--serif);color:var(--navy)">Catalogo in allestimento</h3>
      <p style="color:#64748b">I servizi online saranno pubblicati a breve. Per richieste immediate, ci contatti dalla pagina <a href="<?php echo esc_url(home_url('/contatti/')); ?>">Contatti</a>.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- WIDGET CARRELLO + STYLES + JS condivisi (uguali al prototipo statico) -->
<div id="srvCartWidget" class="cart-widget" style="display:none">
  <div class="cart-widget-head"><strong>Richiesta in preparazione</strong><button id="cwClose" aria-label="Chiudi">&times;</button></div>
  <ul id="cwList"></ul>
  <a href="<?php echo esc_url(home_url('/carrello/')); ?>" class="btn btn-primary cart-widget-cta">Procedi alla richiesta →</a>
</div>

<style>
.srv-filter{padding:8px 14px;border:1px solid #e5e7eb;background:#fff;color:#475569;font-size:13px;font-weight:500;border-radius:20px;cursor:pointer;transition:all .15s;font-family:inherit}
.srv-filter:hover{border-color:var(--gold);color:var(--navy)}
.srv-filter.active{background:var(--navy);color:#fff;border-color:var(--navy)}
.srv-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(330px,1fr));gap:22px}
.srv-card{background:#fff;border:1px solid #e5e7eb;border-radius:6px;padding:26px;transition:all .2s;display:flex;flex-direction:column;position:relative}
.srv-card:hover{border-color:var(--gold);box-shadow:0 12px 28px -16px rgba(15,23,42,.18);transform:translateY(-2px)}
.srv-card.is-added{border-color:var(--gold);background:#fdfbf5}
.srv-card.is-featured{border-color:var(--gold);box-shadow:0 6px 20px -8px rgba(184,153,104,.3)}
.srv-featured-tag{position:absolute;top:-10px;left:24px;background:var(--gold);color:#fff;font-size:10px;letter-spacing:.1em;font-weight:700;padding:4px 10px;border-radius:2px;text-transform:uppercase}
.srv-icon{width:46px;height:46px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:18px}
.srv-badge{position:absolute;top:24px;right:24px;font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);font-weight:700;padding:4px 8px;border:1px solid #f0e9dc;border-radius:2px;background:#faf8f3}
.srv-card h3{font-family:var(--serif);font-size:20px;color:var(--navy);font-weight:600;margin:0 0 6px;line-height:1.25}
.srv-subtitle{font-size:13px;color:#94a3b8;margin:0 0 10px;font-style:italic}
.srv-card > p{font-size:14px;line-height:1.55;color:#475569;margin:0 0 16px;flex-grow:1}
.srv-feat{list-style:none;padding:0;margin:0 0 16px;font-size:13px;color:#64748b;display:flex;flex-direction:column;gap:6px}
.srv-feat li{padding-left:18px;position:relative;line-height:1.4}
.srv-feat li::before{content:"✓";position:absolute;left:0;color:var(--gold);font-weight:700}
.srv-prezzo{font-family:var(--serif);font-size:18px;color:var(--navy);font-weight:600;padding:10px 0;border-top:1px dashed #e5e7eb;margin-bottom:10px}
.srv-area-link{font-size:12px;color:var(--gold);font-weight:600;margin-bottom:14px;display:inline-block}
.srv-add{background:#fff;border:1.5px solid var(--navy);color:var(--navy);font-size:13.5px;font-weight:600;padding:11px 16px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:3px;cursor:pointer;transition:all .15s;font-family:inherit;text-align:center;width:100%;margin-top:auto}
.srv-add:hover{background:var(--navy);color:#fff}
.srv-add.added{background:var(--gold);color:#fff;border-color:var(--gold)}
.cart-widget{position:fixed;bottom:24px;right:24px;width:340px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 20px 48px -16px rgba(15,23,42,.3);padding:18px;z-index:80}
.cart-widget-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #f1f5f9}
.cart-widget-head strong{color:var(--navy);font-size:14px}
#cwClose{background:none;border:0;font-size:22px;color:#94a3b8;cursor:pointer;line-height:1;padding:0 4px}
#cwList{list-style:none;padding:0;margin:0 0 12px;max-height:200px;overflow-y:auto}
#cwList li{font-size:13px;color:#475569;padding:6px 0;border-bottom:1px solid #f8fafc;display:flex;justify-content:space-between;align-items:center;gap:8px;line-height:1.3}
#cwList li button{background:none;border:0;color:#dc2626;cursor:pointer;font-size:16px;padding:0;line-height:1}
.cart-widget-cta{width:100%;text-align:center;display:block}
@media (max-width:600px){.cart-widget{left:16px;right:16px;width:auto;bottom:16px}}
</style>

<script>
(function(){
  const CART_KEY='lanotte_cart_v1';
  function getCart(){try{return JSON.parse(localStorage.getItem(CART_KEY))||[]}catch(e){return[]}}
  function setCart(arr){localStorage.setItem(CART_KEY,JSON.stringify(arr));renderCount();renderWidget();renderCardStates();}
  function addItem(sku,name){const c=getCart();if(c.find(i=>i.sku===sku))return;c.push({sku,name,addedAt:Date.now()});setCart(c);}
  function removeItem(sku){setCart(getCart().filter(i=>i.sku!==sku));}
  function renderCount(){const n=getCart().length;document.querySelectorAll('[data-cart-count]').forEach(el=>{el.textContent=n;el.setAttribute('data-cart-count',n);});}
  function renderCardStates(){
    const cart=getCart();
    document.querySelectorAll('.srv-card').forEach(card=>{
      const sku=card.dataset.sku, inCart=cart.some(i=>i.sku===sku);
      card.classList.toggle('is-added',inCart);
      const btn=card.querySelector('.srv-add');
      if(inCart){btn.classList.add('added');btn.innerHTML='✓ Aggiunto alla richiesta';}
      else{btn.classList.remove('added');btn.innerHTML='Aggiungi alla richiesta <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';}
    });
  }
  function renderWidget(){
    const w=document.getElementById('srvCartWidget'); if(!w)return;
    const cart=getCart(), list=document.getElementById('cwList');
    if(cart.length===0){w.style.display='none';return;} w.style.display='block';
    list.innerHTML=cart.map(i=>`<li><span>${i.name}</span><button data-rm="${i.sku}" aria-label="Rimuovi">×</button></li>`).join('');
    list.querySelectorAll('button[data-rm]').forEach(b=>b.onclick=()=>removeItem(b.dataset.rm));
  }
  document.querySelectorAll('.srv-filter').forEach(btn=>{
    btn.addEventListener('click',()=>{
      document.querySelectorAll('.srv-filter').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const f=btn.dataset.filter;
      document.querySelectorAll('.srv-card').forEach(card=>{card.style.display=(f==='all'||card.dataset.cat===f)?'flex':'none';});
    });
  });
  document.querySelectorAll('.srv-card').forEach(card=>{
    card.querySelector('.srv-add').addEventListener('click',()=>{
      const sku=card.dataset.sku, name=card.dataset.name;
      if(getCart().some(i=>i.sku===sku))removeItem(sku); else addItem(sku,name);
    });
  });
  const cw=document.getElementById('cwClose'); if(cw)cw.onclick=()=>{document.getElementById('srvCartWidget').style.display='none';};
  renderCount();renderWidget();renderCardStates();
})();
</script>

<?php get_footer();
