# Systém na správu zvukovej techniky a logistiky

Matúš Pytel

5ZYI31

## Stručný opis projektu
SonusBox je špecializovaný webový informačný systém navrhnutý pre potreby zvukárov. Projekt rieši dlhodobý problém neprehľadnej evidencie náchylnej zvukárskej techniky, absenciu sledovania jej technického stavu (poškodenia, servis) a neefektívne plánovanie logistiky pri nakladaní techniky do prepravných boxov a tých do vozidiel pred vystúpeniami.

Hlavným účelom aplikácie je centralizovať správu skladových zásob techniky (mikrofóny, mixpulty, kabeláž), prepravných boxov, poskytnúť operatívny prehľad o aktuálnej dostupnosti jednotlivých zariadení v reálnom čase a umožniť plánovanie vyťaženia vozidiel. Taktiež bude obsahovať prehľad servisovanej techniky a jej aktuálny stav.

## Role v projekte
Návštevník:
- Zobrazenie úvodnej landing page s predstavením systému a prihlásenie.

Technik:
- Má prístup k zoznamom techniky, boxov a vozidiel, môže vyhľadávať a filtrovať zariadenia, meniť prevádzkový stav techniky (napr. označiť mikrofón ako V servise alebo Poškodený) a nahrávať fotografie poškodení.

Šofér:
- Má prístup k zoznamu vozidiel, môže meniť ich prevádzkový stav a rieši servis vozidiel.

Správca skladu / admin:
- Má plné oprávnenia v celom systéme. Vykonáva kompletnú správu (CRUD) nad technikou, boxami, kategóriami techniky a vozidlami, spravuje používateľské kontá, priraďuje roly a dohliada na integritu dát.

## Prípady použitia podľa rolí
Návštevník:
- Návštevník si zobrazí úvodnú landing page s predstavením systému.
- Návštevník sa prihlási do systému.

Technik:
- Technik si zobrazí zoznam techniky, boxov a vozidiel.
- Technik vyhľadá zariadenie podľa názvu, kategórie alebo sériového čísla.
- Technik vyfiltruje techniku podľa stavu (dostupná, v servise, poškodená) alebo kategórie.
- Technik zmení prevádzkový stav zariadenia (napr. označí mikrofón ako V servise alebo Poškodený).
- Technik nahrá fotografiu poškodenia k zariadeniu.
- Technik si zobrazí detail boxu a zoznam techniky, ktorá sa v ňom nachádza.
- Technik si zobrazí prehľad servisovanej techniky.

Šofér:
- Šofér si zobrazí zoznam vozidiel a ich aktuálny stav.
- Šofér zmení prevádzkový stav vozidla (dostupné, v servise, mimo prevádzky).
- Šofér zaeviduje servis vozidla (dátum, popis, náklady).
- Šofér si zobrazí, ktoré boxy sú priradené k jeho vozidlu.

Správca skladu (admin):
- Admin vytvorí, upraví a zmaže techniku (CRUD).
- Admin spravuje kategórie techniky (mikrofóny, mixpulty, kabeláž, …).
- Admin vytvorí box a priradí do neho techniku.
- Admin priradí boxy do vozidla a naplánuje jeho vyťaženie pred vystúpením.
- Admin spravuje vozidlá (CRUD).
- Admin spravuje fotografie techniky (nahratie, zmazanie).
- Admin vytvorí používateľské konto a priradí mu rolu.
- Admin upraví alebo deaktivuje používateľské konto.
- Admin si zobrazí prehľad dostupnosti techniky a servisných záznamov.

## Plánované entity
**users**
- **Účel:** prihlasovanie a riadenie prístupu podľa rolí.
- **Atribúty:** id, name, email (unikátny), password_hash, role (admin / technik / sofer), is_active, created_at.
- **Vzťahy:** môže vytvárať servisné záznamy a nahrávať fotografie.

**categories**
- **Účel:** zatriedenie techniky do skupín.
- **Atribúty:** id, name (unikátny), description.
- **Vzťahy:** 1 kategória má viac kusov techniky.

**equipment**
- **Účel:** evidencia jednotlivých zariadení.
- **Atribúty:** id, name, manufacturer, model, serial_number (unikátne), status (dostupná / v servise / poškodená), note, acquired_at, category_id, box_id.
- **Vzťahy:** patrí do jednej kategórie, môže byť v jednom boxe (alebo vo sklade), môže mať viac servisných záznamov a fotografií.

**equipment_photos**
- **Účel:** fotografie poškodení a vzhľadu techniky (upload súborov).
- **Atribúty:** id, equipment_id, file_name, caption, uploaded_by, uploaded_at.
- **Vzťahy:** patrí jednej technike a nahral ju jeden používateľ.

**boxes**
- **Účel:** prepravná jednotka, do ktorej sa nakladá technika.
- **Atribúty:** id, code (unikátny), description, vehicle_id.
- **Vzťahy:** obsahuje viac kusov techniky, je priradený maximálne k jednému vozidlu (alebo vo sklade).

**vehicles**
- **Účel:** evidencia vozidiel na prepravu techniky.
- **Atribúty:** id, name, capacity (max. počet boxov), status (dostupné / v servise / mimo prevádzky).
- **Vzťahy:** prevezie viac boxov, má viac servisných záznamov.

**equipment_service**
- **Účel:** história servisu techniky.
- **Atribúty:** id, equipment_id, description, date_from, date_to (NULL = servis prebieha), cost, user_id.
- **Vzťahy:** patrí jednej technike a vytvoril ho jeden používateľ.

**vehicle_service**
- **Účel:** história servisu vozidiel.
- **Atribúty:** id, vehicle_id, description, date_from, date_to, cost, user_id.
- **Vzťahy:** patrí jednému vozidlu a vytvoril ho jeden používateľ.

## Vzťahy medzi entitami
- **categories – equipment (1:N):** jedna kategória obsahuje viac kusov techniky, každý kus patrí do jednej kategórie.
- **boxes – equipment (1:N):** jeden box obsahuje viac kusov techniky, technika môže byť naraz len v jednom boxe (alebo v žiadnom, ak je v sklade).
- **vehicles – boxes (1:N):** jedno vozidlo prevezie viac boxov, box je naraz priradený maximálne k jednému vozidlu.
- **equipment – equipment_service (1:N):** jedna technika môže mať viac servisných záznamov.
- **vehicles – vehicle_service (1:N):** jedno vozidlo môže mať viac servisných záznamov.
- **equipment – equipment_photos (1:N):** jedna technika môže mať viac fotografií.
- **users – equipment_service / vehicle_service / equipment_photos (1:N):** používateľ môže vytvoriť viac záznamov a nahrať viac fotografií.
- **Rola:** každý používateľ má práve jednu rolu, uloženú ako stĺpec `role` v tabuľke `users`.

## Hlavné stránky aplikácie
- **Landing page** – predstavenie systému, základné informácie a tlačidlo na prihlásenie (verejná).
- **Prihlásenie** – formulár pre prihlásenie používateľa (asynchrónne, AJAX).
- **Dashboard** – rýchly prehľad: počet dostupnej techniky, techniky v servise, poškodenej techniky, stav vozidiel.
- **Zoznam techniky** – tabuľka s vyhľadávaním a filtrovaním podľa stavu a kategórie (AJAX), zmena stavu priamo v tabuľke.
- **Detail / formulár techniky** – zobrazenie detailu, galéria fotografií, história servisu, pridanie a úprava.
- **Zoznam boxov a detail boxu** – obsah boxu, jeho priradenie k vozidlu, pridávanie a odoberanie techniky.
- **Zoznam vozidiel a detail vozidla** – stav vozidla, priradené boxy, servisné záznamy.
- **Prehľad servisu** – zoznam techniky a vozidiel, ktoré sú aktuálne v servise.
- **Správa kategórií** – správa kategórií techniky (admin).
- **Správa používateľov** – zoznam kont, vytváranie, úprava, priraďovanie rolí (admin).

## Rozdelenie funkcionality

**Základné funkcie**
- Prihlásenie a odhlásenie, autorizácia podľa rolí (návštevník, technik, šofér, admin).
- Landing page pre návštevníka.
- CRUD pre techniku, boxy, kategórie a vozidlá (admin).
- Zoznamy techniky, boxov a vozidiel s vyhľadávaním a filtrovaním.
- Zmena prevádzkového stavu techniky (technik) a vozidiel (šofér).
- Priradenie techniky do boxu a boxov do vozidla.
- Nahrávanie a správa fotografií techniky (upload súborov).
- Evidencia servisu techniky a vozidiel.
- Správa používateľov a rolí (admin).
- Prehľad servisovanej techniky.
- Asynchrónna komunikácia (AJAX): filtrovanie/vyhľadávanie v tabuľke techniky, zmena stavu zariadenia bez znovunačítania stránky a prihlásenie.
- Validácia vstupov na strane servera aj klienta (typ aj platná hodnota), ochrana proti SQL injection, heslá uložené ako hash.
- Responzívny dizajn a spustenie v prostredí Docker s importom ukážkových dát.

**Rozširujúce funkcie**
- Dashboard so štatistikami a grafmi dostupnosti.
- Plánovanie akcií (entita Event) a automatická kontrola dostupnosti techniky na dané obdobie.
- Kontrola kapacity vozidla a upozornenie na jeho preťaženie.
- Export zoznamu naloženej techniky do PDF.
- Notifikácie pri poškodení techniky alebo blížiacom sa servise.
- Záznam histórie zmien.
