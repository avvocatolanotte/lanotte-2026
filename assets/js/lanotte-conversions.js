/**
 * Eventi di conversione per GA4/Google Ads: un clic, un evento, con il nome del canale (17/10/2026).
 * Funziona anche quando gtag viene inizializzato dopo il caricamento del tema.
 *
 *   contatto_whatsapp  collegamento WhatsApp con un destinatario (wa.me/<numero>, api.whatsapp.com/send?phone=…)
 *   contatto_telefono  collegamento tel:
 *   contatto_email     collegamento mailto: con un indirizzo (anche quello offuscato da Cloudflare)
 *   contatto_modulo    invio riuscito di Contact Form 7 (wpcf7mailsent)
 *   share              «Condividi» degli articoli (wa.me/?text=, mailto:?subject=, Facebook, LinkedIn): non è un contatto
 *
 * Il nome lo decide il canale, non il pulsante: data-lanotte-event e data-lanotte-cta-location diventano il parametro
 * «pulsante» (calc_whatsapp → contatto_whatsapp con pulsante=calc_whatsapp; barra in basso → pulsante=sticky-dock).
 * I collegamenti espliciti che non sono un canale (calc_contact e preventivo_marchio verso /contatti/, calc_service)
 * tengono il loro nome: portano alla pagina del modulo, il contatto si conta quando il modulo parte.
 *
 * Perché, misurato il 17/10/2026: lo stesso clic su WhatsApp usciva fino a quattro volte — contatto_whatsapp (snippet 10
 * di Code Snippets), contact_whatsapp o calc_whatsapp (qui), contact_click (footer.php), contact_link_click (Site Kit
 * dalla 1.186) — e due erano eventi chiave. Le condivisioni degli articoli contavano come contatti.
 */
(function () {
  'use strict';

  // Site Kit manda contact_link_click per ogni tel:, mailto: e WhatsApp e «contact» per ogni invio di Contact Form 7:
  // sono gli stessi clic e invii contati qui. Gli altri suoi eventi (read_article, outbound_link_click…) passano.
  var DOPPIONI_SITE_KIT = {contact_link_click: true, contact: true};

  function calculatorSlug() {
    var embed = document.querySelector('.lanotte-calcolatore-embed[data-calcolatore]');
    return embed ? embed.getAttribute('data-calcolatore') : '';
  }

  function track(name, params) {
    var p = Object.assign({transport_type: 'beacon'}, params || {});
    window.dataLayer = window.dataLayer || [];
    if (typeof window.gtag === 'function') {
      window.gtag('event', name, p);
    } else {
      window.dataLayer.push(Object.assign({event: name}, p));
    }
  }

  function parametri(link) {
    var p = {page_path: window.location.pathname};
    var calc = calculatorSlug();
    var pulsante = (link && (link.getAttribute('data-lanotte-event') || link.getAttribute('data-lanotte-cta-location'))) || '';
    if (calc) p.calculator = calc;
    if (pulsante) p.pulsante = pulsante;
    return p;
  }

  /** Canale del collegamento: {nome} per un contatto, {nome: 'share', metodo} per una condivisione, null altrimenti. */
  function canale(link) {
    var href = (link.getAttribute('href') || '').trim();
    var basso = href.toLowerCase();
    if (basso.indexOf('tel:') === 0) return {nome: 'contatto_telefono'};
    if (basso.indexOf('mailto:') === 0) {
      return /^mailto:[^?]*@/.test(basso) ? {nome: 'contatto_email'} : {nome: 'share', metodo: 'email'};
    }
    if (basso.indexOf('/cdn-cgi/l/email-protection') !== -1) return {nome: 'contatto_email'};

    var u;
    try { u = new URL(href, window.location.href); } catch (e) { return null; }
    var host = u.hostname.replace(/^www\./, '').toLowerCase();
    var whatsapp = u.protocol === 'whatsapp:' || host === 'wa.me' || host === 'api.whatsapp.com' || host === 'web.whatsapp.com';
    if (whatsapp) {
      var destinatario = host === 'wa.me'
        ? /^\/(\+?\d{6,}|(message|qr)\/[^/]+)/i.test(u.pathname)
        : /\d{6,}/.test(u.searchParams.get('phone') || '');
      return destinatario ? {nome: 'contatto_whatsapp'} : {nome: 'share', metodo: 'whatsapp'};
    }
    if (link.closest('.post-share')) return {nome: 'share', metodo: host.split('.')[0]};
    return null;
  }

  document.addEventListener('click', function (event) {
    filtraSiteKit();
    var link = event.target && event.target.closest ? event.target.closest('a[href]') : null;
    if (!link) return;

    var c = canale(link);
    var params = parametri(link);
    if (c && c.nome === 'share') {
      params.method = c.metodo;
      track('share', params);
    } else if (c) {
      track(c.nome, params);
    } else if (link.getAttribute('data-lanotte-event')) {
      delete params.pulsante;
      track(link.getAttribute('data-lanotte-event'), params);
    }
  });

  document.addEventListener('wpcf7mailsent', function (event) {
    filtraSiteKit();
    var params = {page_path: window.location.pathname};
    var id = event && event.detail && event.detail.contactFormId;
    if (id) params.form_id = String(id);
    track('contatto_modulo', params);
  });

  // Site Kit passa da _googlesitekit.gtagEvent e lo rilegge a ogni clic: lo si avvolge una volta sola, appena lo script
  // gira, a DOMContentLoaded e all'inizio di ogni clic e invio del modulo. Questi gestori sono registrati prima di quelli
  // di Site Kit (script nel footer, i suoi sono differiti), quindi il filtro c'è anche se gtagEvent arrivasse tardi
  // (rilievo di Codex sulla 1.0.152).
  function filtraSiteKit() {
    var sk = window._googlesitekit;
    if (!sk || typeof sk.gtagEvent !== 'function' || sk.gtagEvent.lanotteFiltro) return;
    var originale = sk.gtagEvent;
    var filtrato = function (name) {
      if (Object.prototype.hasOwnProperty.call(DOPPIONI_SITE_KIT, name)) return;
      return originale.apply(this, arguments);
    };
    filtrato.lanotteFiltro = true;
    sk.gtagEvent = filtrato;
  }
  filtraSiteKit();

  document.addEventListener('lanotte:calculation', function (event) {
    var action = event.detail && event.detail.action;
    if (!action) return;
    var params = parametri(null);
    track(action, params);
    if (action === 'preview_open') {
      track('calculation_complete', params);
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    filtraSiteKit();
    var subject = new URLSearchParams(window.location.search).get('argomento');
    if (!subject || window.location.pathname.indexOf('/contatti') !== 0) return;

    var input = document.querySelector('input[name="your-subject"], input[name="oggetto"], input[placeholder^="Oggetto"]');
    if (!input || input.value) return;
    input.value = 'Verifica calcolo: ' + subject.replace(/-/g, ' ');
    input.dispatchEvent(new Event('change', {bubbles: true}));
  });
})();
