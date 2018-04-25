# Labb 6, Laravel - middleware / authentication

I denna labb ska vi titta på närmre på hur vi kan skapa webbapplikationer med användarinloggning, samt hur vi kan använda Laravels inbygga middlewares för att kontrollera om våra besökare är inloggade eller inte.

## Upplägg på labben

1. Skapa ett nytt Laravel-projekt
2. Återanvänd era migrations och seeds (produkter) från förra labben
3. Bygg en webbapplikation om produkter (utgå från [labb 5](../5/laravel.md) i strukturen)
    - Som icke-inloggad ska man kunna visa alla produkter och specifik information om en produkt.
    - Som inloggad ska man (utöver ovan) kunna lägga till / redigera / radera produkter.

## 1. Skapa ett nytt Laravel-projekt
Ni skapar ett nytt projekt genom:
```bash
laravel new Lab6
```
(eller ange ert projektnamn genom att byta ut `Lab6` i kommandot ovan)

## 2. Återanvänd de migrations och seeds
Utgå från tidigare skapade migration och seeds, se följande instruktioner:
- [Migrations](../4/lumen.md#212-skapa-migrations)
- [Seeds](../4/lumen.md#213-skapa-seeding)

När ni skapat dessa så migrera databasen (notera att Laravel skeppas med två tabeller (`users` &amp; `remember_token`), dessa ska också migreras):
```bash
php artisan migrate
```
Populera sedan er databas genom:
```bash
php artisan db:seed
```

## 3. En webbsida med login

### 3.1. Skapa förutsättningar för login
Använd [Laravels auth-genrerare](https://laravel.com/docs/5.6/authentication#introduction) för att skapa grunderna för er inloggning (model/controller/middleware/views/etc.):
```bash
php artisan make:auth
```
Dubbelkolla sedan så att allt fungerar som det ska genom att starta en webbserver i `public`-mappen för adressen `localhost:8000`:
```bash
php -S localhost:8000
```
Surfa sedan till [http://localhost:8000](http://localhost:8000) för att dubbelkolla att allt fungerar. Testa även att skapa en användare och logga in för att kontrollera att allt fungerar som det ska.

### 3.2. Begränsa åtkomsten i er webbapplikation

Skapa följande routes:
- products (GET)
    - [Vy] Lista upp alla produkter
- **products (POST)**
    - Skapa en ny produkt
- **products/create (GET)**
    - [Vy] Skapa en ny produkt
- products/{id} (GET)
    - [Vy] Visa detaljer om en specifik produkt
- **products/{id} (PUT)**
    - Uppdatera en produkt
- **products/{id} (DELETE)**
    - Radera en produkt
- **products/{id}/edit (GET)**
    - [Vy] Redigera en produkt

De routes som är **fetstilta** ska endast gå att nå om man är inloggad. Tips är att läsa [Laravels dokumentation om middleware](https://laravel.com/docs/5.6/routing#route-groups).

Bygg sedan klart er webbapplikation! =) (Återigen, ni har troligvis byggt vyerna ovan redan i [Labb 5](../5/laravel.md), så utgå från dem).

## 4. Nu då?
Det är fritt fram att bygga vidare på sin applikation, vill ni ha inspiration för att komma vidare så prata gärna med någon av handledarna.
