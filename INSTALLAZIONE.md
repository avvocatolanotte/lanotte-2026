# Tema Lanotte 2026 — Guida operativa

> Tema WordPress personalizzato per lo Studio Legale Lanotte & Partners. Sostituisce `lanotte-child` + tema `Attorna` + plugin `Slider Revolution`.

---

## 0 · Prima di tutto: BACKUP

**Obbligatorio**, prima di toccare qualsiasi cosa.

1. WordPress → Plugin → Aggiungi nuovo → cerca **"UpdraftPlus"** → Installa → Attiva
2. UpdraftPlus → "Esegui backup adesso" → spunta sia DB che file → Esegui
3. Scarica il backup sul tuo Mac
4. (Opzionale) Backup completo via cPanel/Plesk → File Manager → comprimi `/public_html/` e scarica

---

## 1 · Installa i plugin richiesti

Vai su **Plugin → Aggiungi nuovo** e installa+attiva nell'ordine:

| Plugin | Perché | Costo |
|---|---|---|
| **Advanced Custom Fields PRO** | Per modificare le sezioni dal pannello | ~49 €/anno ([acf-pro](https://www.advancedcustomfields.com/pro/)) |
| **WP Staging** (gratis) | Per clonare il sito attuale in staging | Gratis |
| **Complianz** (gratis) | Cookie banner GDPR | Gratis |

Mantieni attivi i plugin esistenti: **AIOSEO, Contact Form 7, LiteSpeed Cache, Newsletter**.

---

## 2 · Clona il sito su staging (consigliato)

Per testare in sicurezza prima di toccare il sito vivo:

1. **WP Staging** → Crea nuovo Staging → conferma
2. Aspetta 5-15 minuti che cloni tutto
3. WP Staging ti dà un URL tipo `https://www.studiolegalelanotte.it/staging-1/`
4. Accedi a quell'URL con le tue credenziali admin

**Da qui in poi, tutto si fa sullo staging**, non sul sito vivo.

---

## 3 · Carica il tema

1. Sullo staging: **Aspetto → Temi → Aggiungi nuovo → Carica tema**
2. Seleziona il file `lanotte-2026.zip` (te lo do io insieme a questa guida)
3. **Installa ora**
4. **Attiva** il tema "Lanotte 2026"

⚠️ La home potrebbe sembrare "vuota" inizialmente. È normale: i contenuti vanno popolati con il passo 4.

---

## 4 · Crea le pagine + le 13 aree (automatico, 1 click)

Il tema include uno **script di seed** che crea tutto in automatico.

Vai a questo URL (sostituisci lo staging):
```
https://www.studiolegalelanotte.it/staging-1/wp-admin/?lanotte_seed=1
```

Risultato:
- Crea le 13 aree di competenza con testi, FAQ, sezioni
- Crea le pagine: Lo Studio, Onorari, Contatti, Privacy, Cookie
- Crea la pagina "Rassegna Giuridica" e la imposta come pagina blog
- Crea la "Home" e la imposta come homepage statica

Se è tutto OK vedrai un avviso verde "Seed completato".

---

## 5 · Configura il menu principale

WordPress → **Aspetto → Menu**:

1. Crea nuovo menu "Menu Principale"
2. Aggiungi nell'ordine: Home · Lo Studio · Aree di Competenza · Onorari · Rassegna · Contatti
3. In "Posizione del tema" spunta **Menu principale**
4. Salva

(Crea anche menu separati per Footer Aree, Footer Studio, Footer Contatti se vuoi personalizzarli — altrimenti sono auto-popolati)

---

## 6 · Compila i tuoi dati da ACF

WordPress → menu sinistro → **Impostazioni Studio**:

### Contatti & Identità
- Telefono studio
- Email
- PEC
- Orari
- Indirizzo
- Social: FB, IG, LinkedIn
- **Google Business Profile URL** (importante per SEO)

### Homepage Sezioni
- Hero: titolo, lead, immagine di sfondo, 3 statistiche
- **HERO · Shortcode Contact Form 7**: incolla qui lo shortcode del form esistente (es. `[contact-form-7 id="123" title="Contatti"]`)
- Sezione "Foro di Trani": testi e 4 immagini
- 4 Principi etici
- CTA strip

### Recensioni & Trust
- Recensioni Google reali (testo, autore, stelle)
- Media stelle complessiva
- Numero totale recensioni

---

## 7 · Verifica funzionamento

Test rapidi sullo staging:

- [ ] Home si vede correttamente con la cattedrale, le 9 aree, "Foro di Trani"
- [ ] Cliccando un'area di competenza si apre la pagina dedicata con FAQ
- [ ] Pagina Onorari mostra le 3 tariffe
- [ ] Pagina Contatti mostra il form (configura prima il CF7)
- [ ] Pagina Rassegna mostra gli articoli del blog
- [ ] Footer è a 4 colonne
- [ ] Mobile: testa da telefono → menu burger funziona, layout OK
- [ ] Tasto WhatsApp flottante apre la chat
- [ ] Click su telefono nell'header avvia chiamata da mobile

---

## 8 · Go-live (dal sito staging al sito vivo)

Quando lo staging è perfetto:

### Opzione A: Push da WP Staging (consigliata)

1. WP Staging → "Push to Live"
2. Conferma (richiederà password admin)
3. WP Staging copia tutto sul sito vero

### Opzione B: Manuale

1. Backup nuovamente il sito vivo (UpdraftPlus)
2. Sito vivo: Plugin → disattiva e cancella **Slider Revolution**
3. Sito vivo: Aspetto → Temi → carica e attiva `lanotte-2026.zip`
4. Sito vivo: visita `?lanotte_seed=1` per popolare contenuti (se non già fatti via push)
5. Cancella tema **Attorna** e **lanotte-child** dalle voci dei temi

---

## 9 · Operazioni post go-live

- [ ] LiteSpeed Cache → Cache → Purga tutto
- [ ] Cloudflare → Cache → Purga tutto
- [ ] Search Console → invia di nuovo la sitemap (AIOSEO la rigenera automaticamente)
- [ ] Disinstalla Slider Revolution se ancora presente
- [ ] Verifica che il telefono sia uniformato (era discrepante)
- [ ] Aggiungi Google Business Profile URL nello schema
- [ ] Attiva Complianz per il banner cookie
- [ ] Configura Google Analytics 4 in AIOSEO

---

## 10 · Manutenzione futura

### Aggiungere un'area di competenza
WordPress → menu sinistro → **Aree** → Aggiungi nuova → compila titolo, tagline, lead, sezioni, FAQ → Pubblica. Comparirà automaticamente in home e nell'indice.

### Modificare un'area esistente
Aree → seleziona l'area → modifica → Aggiorna. Modifiche immediate.

### Aggiungere un avvocato / collaboratore (NUOVO)
WordPress → menu sinistro → **Professionisti** → Aggiungi nuovo:
1. **Titolo**: nome e cognome (es. "Mario Rossi")
2. **Foto**: imposta immagine in evidenza (formato quadrato consigliato, min. 400×400)
3. **Campi a destra**:
   - Ruolo (Titolare / Partner esterno / Of Counsel / Associato / Praticante / Commercialista)
   - Specializzazione (max 80 caratteri)
   - Titolo professionale (Avv. / Dott.ssa / Prof. Avv.)
   - Iscrizione Albo
   - Bio breve (max 280 caratteri)
   - Email, telefono, LinkedIn, CV PDF
   - Lingue parlate (checkbox multipla)
   - Aree collegate (link alle 13 Aree di Competenza)
   - Visibile sì/no
4. **Attributi pagina → Ordine**: 0 = appare primo, 10 = secondo, 20 = terzo, ecc.
5. Pubblica → comparirà automaticamente in Lo Studio.

### Aggiungere/togliere un cliente istituzionale (NUOVO)
WordPress → menu sinistro → **Clienti** → Aggiungi nuovo:
1. **Titolo**: nome del cliente (es. "International Taekwon-Do Federation")
2. **Campi**:
   - **Logo**: carica immagine PNG/JPG/SVG (sfondo trasparente preferito, min. 200×80)
   - **URL sito ufficiale**: es. `https://itf-tkd.org/`
   - **Descrizione**: testo alt/title (max 120 caratteri)
   - **Settore**: Sport, Immobiliare, No Profit, Impresa, PA, Professionisti, E-commerce
   - **Cliente dal (anno)**: opzionale
   - **Mostra in homepage**: spunta se vuoi nel riquadro "I nostri clienti istituzionali"
   - **Consenso alla pubblicazione**: OBBLIGATORIO spuntare (deontologia + GDPR)
3. **Attributi pagina → Ordine**: posizione nel grid
4. Pubblica → il logo apparirà tra i 6+ in home.

⚠️ **Massimo consigliato**: 6-8 loghi in evidenza nella home. Per averne di più crea una pagina dedicata `/clienti/`.

### Cambiare il logo del sito (NUOVO)
Tre modi, in ordine di priorità (vince quello caricato per primo):

**Modo 1 — WordPress Customizer (più semplice)**
1. WP → **Aspetto → Personalizza → Identità del sito → Logo**
2. Carica il nuovo logo (PNG o SVG, idealmente 560×172 px o multipli)
3. Anteprima dal vivo a destra → **Pubblica**

**Modo 2 — Pannello Branding dedicato (più completo)**
1. WP → **Impostazioni Studio → 🎨 Branding e immagini**
2. Tab "Loghi":
   - **Logo principale** — quello in header
   - **Logo per sfondi scuri** — versione bianco/oro per footer/topbar
   - **Logo compatto** — versione quadrata 512×512 per social/badge
   - **Logo per PDF carta intestata** — alta risoluzione (min. 600×180) per i calcolatori
3. Salva → effettivo immediato su tutto il sito + nei nuovi PDF generati

**Modo 3 — File diretto** (solo per sviluppatori)
- Sostituisci `/wp-content/themes/lanotte-2026/assets/img/logo.svg` via FTP
- È il fallback se non hai caricato nulla dal pannello

### Cambiare favicon e icone (NUOVO)
- **Favicon principale**: WP → Aspetto → Personalizza → **Icona del sito** (formato 512×512, WordPress genera automaticamente tutti i sotto-formati)
- **Apple Touch Icon** (iOS bookmarks): Impostazioni Studio → 🎨 Branding → tab "Favicon e icone" → carica 180×180

### Cambiare immagini globali (NUOVO)
WP → **Impostazioni Studio → 🎨 Branding e immagini → tab "Immagini globali"**:
- **Hero default**: sfondo della home (attualmente cattedrale di Trani)
- **Immagine Open Graph**: 1200×630 per condivisioni social (Facebook/WhatsApp/LinkedIn)
- **Placeholder**: per articoli senza immagine in evidenza

### Caricare immagini nella Libreria Media
- WP → **Media → Aggiungi nuovo** → trascina file (singoli o multipli)
- Per usare un'immagine in una pagina: **Pagine → Modifica** → blocco Immagine → seleziona dalla libreria
- Per usare nei pannelli (CPT, Branding): cliccando "Aggiungi immagine" si apre la stessa libreria
- WordPress genera automaticamente: thumbnail (150×150), medium (300×300), large (1024×1024), full (originale)

### Aggiungere/togliere un servizio online (NUOVO)
WordPress → menu sinistro → **Servizi online** → Aggiungi nuovo:
1. **Titolo**: nome del servizio (es. "Consulenza in videocall")
2. **Sottotitolo**: dettaglio (es. "30 minuti su Google Meet")
3. **Descrizione breve**: 2-3 righe per la card
4. **Categoria filtro**: Consulenza / Civile / Penale / Impresa / Famiglia / Contratti / IP / Tributario / Internazionale
5. **Area collegata**: collega a una delle 13 Aree (crea link)
6. **Icona**: SVG inline (preferito) o emoji
7. **Gradiente icona**: navy / amber / red / green / pink / blue / purple
8. **Caratteristiche**: ripetitore con max 5 voci (es. "Verbalizzazione scritta", "Calendario online")
9. **Codice SKU**: codice univoco (es. `CONS-VIDEOCALL-30`) — usato nel carrello
10. **Prezzo orientativo** (opzionale): es. "da € 80 + IVA". ⚠️ Ricorda: art. 13 L. 247/2012 → preventivo scritto personalizzato, no listini fissi
11. **In evidenza**: spunta per badge "★ In evidenza"
12. **Servizio attivo**: deseleziona per nasconderlo temporaneamente
13. Pubblica → compare in `/servizi-online/`.

### Pubblicare un articolo del blog
Articoli → Aggiungi nuovo → titolo, contenuto, categoria, immagine in evidenza → Pubblica. Comparirà in Rassegna e in fondo alla home.

### Cambiare titolo dell'hero
Impostazioni Studio → Homepage Sezioni → modifica i campi → Salva.

### Aggiungere una recensione
Impostazioni Studio → Recensioni & Trust → aggiungi recensione → Salva.

### Cambiare i colori
File `assets/style.css`, modifica le CSS custom properties in `:root`:
- `--navy` (blu principale)
- `--gold` (oro)
- `--cream` (sfondo chiaro)

---

## 11 · Panoramica dei pannelli admin

Dopo l'installazione di v2 vedrai questi menu nel pannello WordPress:

| Menu | Contenuto | Esempi |
|---|---|---|
| **Articoli** | Rassegna giuridica | Note di commento, sentenze, scadenze |
| **Aree** | 13 aree di competenza | Diritto Civile, Penale, Impresa, IP, ecc. |
| **Professionisti** ⭐ NUOVO | Team Studio | Giuseppe Lanotte (Titolare), Cristina De Lillo (Partner), Ruggiero Lanotte (Commercialista) |
| **Clienti** ⭐ NUOVO | Loghi istituzionali | ITF, FQ Quinto, Federico Gym, Condominiocasa, Prenota in Puglia, Puglia Fideiussioni |
| **Servizi online** ⭐ NUOVO | Catalogo carrello | Consulenza videocall, Parere scritto, Diffida, Marchio UE, ecc. |
| **Pagine** | Pagine statiche | Lo Studio, Onorari, Contatti, Privacy, Cookie |
| **Opzioni Studio** | Contatti globali | Telefono, email, PEC, indirizzo, social |
| **Opzioni Homepage** | Sezioni home | Hero, trust bar, Foro Trani, principi |
| **Opzioni Recensioni** | Testimonial Google | 5 recensioni reali, media, totale |

---

## ⚠️ Cose da NON fare

- ❌ Non modificare i file PHP del tema dal pannello WordPress (editor file disabilitato per sicurezza)
- ❌ Non eliminare il file `acf-json/` (contiene la configurazione dei campi)
- ❌ Non installare di nuovo Slider Revolution
- ❌ Non riattivare xmlrpc.php (è bloccato per sicurezza)

---

## Hai bisogno d'aiuto?

Tutti i file di sviluppo sono in `/Users/giuseppelanotte/lanotte-2026/`.
Lo ZIP pronto al caricamento è `/Users/giuseppelanotte/lanotte-2026.zip`.

Quando uno step ti dà problemi, riprendi qui la conversazione e mandami lo screenshot dell'errore: ti guido passo-passo.
