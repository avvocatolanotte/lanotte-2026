# Relazione miglioramento completo - 11 agosto 2026

## Obiettivo

Trasformare il traffico crescente di sito, calcolatori e social in richieste
misurabili, senza alterare il funzionamento degli strumenti o delle vendite
WooCommerce.

## Modifiche incluse nella versione 1.0.77

1. CTA contestuale sotto ogni calcolatore, con WhatsApp precompilato e accesso
   alla pagina contatti con argomento del calcolo.
2. Precompilazione dell'oggetto del modulo quando l'utente arriva da un
   calcolatore.
3. Eventi analitici aggiuntivi:
   - `calculation_complete`
   - `preview_open`
   - `report_print`
   - `pdf_download`
   - `calc_whatsapp`
   - `calc_contact`
   - `contact_phone`
   - `contact_whatsapp`
   - `contact_email`
   - `contact_form_submit`
4. Conservazione dell'evento storico `contact_click`, per non interrompere i
   confronti gia presenti in Analytics.
5. Informativa privacy visibile sotto Contact Form 7.
6. Redirect 301 dal vecchio URL della rivalutazione dell'assegno alla pagina
   canonica `/calcolatori/mantenimento-istat/`.
7. Seconda rimozione tardiva degli asset WooCommerce nelle pagine che non ne
   hanno bisogno, mantenendoli su prodotti, servizi online, carrello, checkout,
   account e onorari.

## Configurazione GA4 dopo la pubblicazione

Contrassegnare come eventi chiave:

- `contact_click` (gia utilizzato)
- `contact_form_submit`
- `calc_whatsapp`
- `calc_contact`

Gli eventi `calculation_complete`, `preview_open`, `report_print` e
`pdf_download` restano eventi di percorso: servono a misurare il passaggio dal
calcolo al contatto senza gonfiare il numero delle conversioni.

## Verifica dopo il deploy

1. Svuotare LiteSpeed e Cloudflare.
2. Aprire un calcolatore in finestra anonima e completare un conteggio.
3. Verificare anteprima, stampa e PDF.
4. Usare il pulsante WhatsApp sotto il calcolo e controllare il testo
   precompilato.
5. Aprire `Richiedi una verifica` e controllare l'oggetto del modulo.
6. In GA4 DebugView verificare gli eventi elencati sopra.
7. Controllare che il vecchio URL ISTAT restituisca 301.
8. Verificare carrello e checkout per confermare che gli asset WooCommerce
   restino caricati nelle pagine commerciali.

## Strategia consigliata

Ad agosto mantenere Google Ads in pausa. Usare il periodo per raccogliere una
base affidabile di eventi organici e social. Riattivare gradualmente la campagna
dal 25 agosto, inviando i gruppi di annunci alle pagine professionali piu
pertinenti e valutando il rendimento sui contatti reali, non sui soli clic.
