# Relazione intervento conversioni - 16/06/2026

## Problema rilevato

Il sito riceve visite e clic dagli annunci, ma la chiamata non e abbastanza evidente in ogni momento della navigazione. Il telefono compare in topbar, header e contatti, ma non rimane sempre disponibile come azione primaria, soprattutto da mobile.

## Intervento applicato

E stata sostituita la vecchia bolla WhatsApp singola con una barra fissa di conversione:

- bottone `Chiama ora` con numero dello Studio;
- bottone `WhatsApp` con messaggio precompilato;
- layout compatto desktop in basso a destra;
- layout mobile a barra inferiore sempre visibile;
- esclusione automatica da carrello, checkout e area pagamenti per non disturbare procedure di acquisto/pagamento.

## Tracciamento

E stato aggiunto un evento JavaScript leggero:

- nome evento: `contact_click`;
- metodi tracciati: `call`, `whatsapp`;
- posizione: `sticky-dock` per la nuova barra, `site-link` per gli altri link telefono/WhatsApp gia presenti nel sito;
- compatibile con `gtag` e `dataLayer`, se presenti.

## Verifiche consigliate

1. Svuotare cache LiteSpeed e Cloudflare.
2. Verificare da mobile che la barra non copra contenuti o moduli.
3. In GA4/GTM controllare l'arrivo dell'evento `contact_click`.
4. In Google Ads configurare o verificare una conversione basata sui click telefono/WhatsApp, se non gia presente.
5. Rivalutare dopo 7-10 giorni: clic su CTA, chiamate effettive, costo per contatto.

## Nota

L'intervento aumenta la visibilita dell'azione di contatto e migliora la misurazione. Non modifica le campagne Google Ads, le parole chiave o la verifica inserzionista.

