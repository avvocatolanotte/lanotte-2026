# Relazione bonifica blog - 16/06/2026

## Interventi tecnici applicati

Sono stati predisposti redirect 301 permanenti per i doppioni e gli URL deboli individuati nell'analisi della rassegna.

| Vecchio URL | Nuova destinazione | Intervento |
|---|---|---|
| `/richiesta-documentazione-bancaria/` | `/accesso-alla-documentazione-bancaria/` | Redirect 301 + vecchio articolo in bozza |
| `/uso-della-cosa-comune-limiti/` | `/luso-della-cosa-comune-parte-ciascun-condomino/` | Redirect 301 + vecchio articolo in bozza |
| `/come-difendere-i-figli-dalle-guerre-tra-genitori/` | `/figli-orfani-di-un-padre-vivo/` | Redirect 301 + vecchio articolo in bozza |
| `/il-padre-che-non-mantiene-i-figli-deve-risarcire-lex-fonte-il-padre-che-non-mantiene-i-figli-deve-risarcire-lex/` | `/assegno-di-mantenimento-non-pagato-e-reato-cassazione-penale-sez-vi-sentenza-12-12-2018-n-55744/` | Redirect 301 + vecchio articolo in bozza |
| `/434-2/` | `/responsabilita-medica-onere-probatorio-struttura-sanitaria/` | Rinomina slug + redirect 301 |
| `/586-2/` | `/nuovi-modelli-deposito-domande-brevetto/` | Rinomina slug + redirect 301 |

La logica e contenuta in `inc/blog-cleanup.php` e viene eseguita una sola volta per:

- rinominare gli slug numerici;
- mettere in bozza i vecchi contenuti duplicati/deboli;
- mantenere attivi i redirect 301 anche dopo la messa in bozza.

## Perche questi interventi sono sicuri

- Non viene cancellato contenuto dal database: gli articoli assorbiti vengono messi in bozza, quindi restano recuperabili.
- Ogni vecchio URL ha una destinazione tematicamente coerente.
- I redirect 301 trasferiscono il segnale SEO verso la pagina da tenere.
- Gli slug numerici vengono sostituiti con slug descrittivi.

## Attivita editoriali da fare in seconda fase

Questi interventi non sono stati automatizzati per evitare fusioni editoriali non controllate:

1. Cluster mantenimento figli: creare un articolo pilastro unico su obblighi, assegno non pagato, maggiorenni e genitore disoccupato.
2. Cluster negoziazione/separazione: tenere l'articolo madre sulla negoziazione assistita e differenziare la guida pratica alla separazione consensuale.
3. Responsabilita medica: distinguere meglio l'articolo sull'onere probatorio da quello sulla colpa medica.
4. Articoli sotto 400 parole ma unici: ampliarli a 400-600 parole con base normativa, caso pratico, quando rivolgersi all'avvocato e FAQ.

## Verifiche post-pubblicazione

Dopo il deploy:

1. aprire ciascun vecchio URL e verificare che restituisca redirect 301;
2. controllare che i nuovi URL siano indicizzabili;
3. svuotare cache LiteSpeed e Cloudflare;
4. rigenerare sitemap se necessario;
5. in Search Console richiedere nuova scansione degli URL principali.

