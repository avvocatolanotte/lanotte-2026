/**
 * Eventi di conversione uniformi per GA4/Google Ads.
 * Funziona anche quando gtag viene inizializzato dopo il caricamento del tema.
 */
(function () {
  'use strict';

  function calculatorSlug() {
    var embed = document.querySelector('.lanotte-calcolatore-embed[data-calcolatore]');
    return embed ? embed.getAttribute('data-calcolatore') : '';
  }

  function track(name, params) {
    window.dataLayer = window.dataLayer || [];
    if (typeof window.gtag === 'function') {
      window.gtag('event', name, params || {});
    } else {
      window.dataLayer.push(Object.assign({event: name}, params || {}));
    }
  }

  document.addEventListener('click', function (event) {
    var link = event.target.closest('a');
    if (!link) return;

    var href = link.getAttribute('href') || '';
    var explicitEvent = link.getAttribute('data-lanotte-event');
    var params = {page_path: window.location.pathname, calculator: calculatorSlug()};

    if (explicitEvent) {
      track(explicitEvent, params);
    } else if (href.indexOf('tel:') === 0) {
      track('contact_phone', params);
    } else if (/wa\.me|whatsapp/i.test(href)) {
      track('contact_whatsapp', params);
    } else if (href.indexOf('mailto:') === 0) {
      track('contact_email', params);
    }
  });

  document.addEventListener('lanotte:calculation', function (event) {
    var action = event.detail && event.detail.action;
    if (!action) return;
    var params = {page_path: window.location.pathname, calculator: calculatorSlug()};
    track(action, params);
    if (action === 'preview_open') {
      track('calculation_complete', params);
    }
  });

  document.addEventListener('wpcf7mailsent', function () {
    track('contact_form_submit', {page_path: window.location.pathname});
  });

  document.addEventListener('DOMContentLoaded', function () {
    var subject = new URLSearchParams(window.location.search).get('argomento');
    if (!subject || window.location.pathname.indexOf('/contatti') !== 0) return;

    var input = document.querySelector('input[name="your-subject"], input[name="oggetto"], input[placeholder^="Oggetto"]');
    if (!input || input.value) return;
    input.value = 'Verifica calcolo: ' + subject.replace(/-/g, ' ');
    input.dispatchEvent(new Event('change', {bubbles: true}));
  });
})();
