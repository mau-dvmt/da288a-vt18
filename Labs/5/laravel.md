# Labb 5, Laravel

I denna labb ska vi titta närmre på Laravel och bygga vår första webbapplikation med ett GUI. Laborationen kommer vara uppbyggd stegvis och kommer kräva att ni tittar nämre och lär er att hitta i [Laravels dokumentation](https://laravel.com/docs/5.6). Tacksamt nog är Laravel ett väldokumenterat ramverk med både tydliga förklaring och mycket kodexempel. Så vid varje del i laboration så kommer det att refereras till olika delar av Laravels dokumentation, där ni förväntas att hitta svar på eventuella frågor.

Laravel är _storebror_ till ramverket [Lumen](lumen.laravel.com) och således kommer du att känna igen er mycket, speciellt från [föregående laboration](../4/lumen.md).

Den kod som vi skrev till tillhörande föreläsning hittar nu här: [https://github.com/Tibbelit/da288a-laravel-movie-example](https://github.com/Tibbelit/da288a-laravel-movie-example).

## 1. Förberedelser

### 1.1. Installera laravel-installeraren
```bash
composer global require "laravel/installer"
```

### 1.2. Skapa ett nytt Laravel-projekt
Skapa ett nytt Laravel-projekt som ni exempelvis kallar för `Lab5` genom:
```bash
laravel new Lab5
```
Alternativt:
```bash
composer create-project --prefer-dist laravel/laravel Lab5
```
Testa så att projektet installerats korrekt genom att i *terminalen* navigera till mappen `public` och starta upp en webbserver där genom:
```php
php -S localhost:8080
```
Surfa sedan till [http://localhost:8080/](http://localhost:8080/) för att se att allt fungerar som det ska.

Utförliggare dokumentation finns under [installation](https://laravel.com/docs/5.6/installation) i Laravels dokumentation.

*Om du inte gjort föregående laboration kan du behöva installera memcached. Instruktioner för detta hitta ni [här](../4/lumen.md#12-installera-memcached).*

## 2. Labbuppgiften - Att bygga ett webb-GUI till våra produkter

### 2.1. Sätta upp databasen
Vi kommer i denna labb att utgå från samma case (med *product* som resurs), men istället för att göra ett API (med `JSON`-svar) så ska vi göra en webbapplikation som returnerar en webbsida (genom HTML / CSS, och ev. JavaScript).

**Vi kommer bara att hantera resursen `produkt` i denna laboration, så det räcker med att du använder den migrationen för den tabellen, och seeds för den tabellen.**

- Börja med att skapa en ny databas genom `phpMyAdmin` (som du surfade till genom [http://localhost/phpmyadmin](http://localhost/phpmyadmin))
- Konfigurera sedan er `.env`-fil med de korrekta uppgifterna till databasen (glöm inte att döpa om `.env.example` till `.env` om detta inte gjordes automatiskt under installationen av laravel)

#### Migration

Utgå från [migrations-filen för produkter som du skapde i förra laborationen](../4/lumen.md#212-skapa-migrations) och kopiera den (som ligger i mappen `database/migrations`) från Lumen-projektet till ditt nyskapade Laravel-projekt. Som du kanske ser finns det redan `migrations`-filer i ditt Laravel-projekt (som förbereder användharntering och login), som du kan ta bort, då vårt projekt ej kommer att använda sig utav inloggning. Kör sedan:
```bash
php artisan migrate
```

Utförliggare dokumentation finns under [migrations](https://laravel.com/docs/5.4/migrations) i Laravels dokumentation.

#### Seeds
Skapa en ny databas-seed genom:
```bash
php aristan make:seed ProductTableSeed
```

Kopiera sedan innehållet från [seeds-filen för produkter som du skapade i förra laborationen](../4/lumen.md#213-skapa-seeding) (som ligger i mappen `database`) och klistra in detta i den nyskapade `ProductTableSeed`. Glöm sedan inte att i filen `databaseSeeder.php` att ange vilka `seeds` som ska köras (i functionen `run()`):
```php
$this->call(MoviesTableSeeder::class);
```

Utförliggare dokumentation finns under [seeding](https://laravel.com/docs/5.6/seeding) i Laravels dokumentation.

### 2.2. Skapa routes, controllers, models

Mer information om [routes](https://laravel.com/docs/5.6/routing), [controllers](https://laravel.com/docs/5.6/controllers) för [resurser](https://laravel.com/docs/5.6/controllers#resource-controllers) i Laravels dokumentation.

#### 2.2.1. Skapa Routes
**Notera att routes i Laravel skiljer sig något från Lumen**

##### Lumen
```php
$app->get("/", ...);
```

##### Laravel
```php
Route::get("/", ...);
```

Vi ska nu skapa de `routes` som vår webbapplikation ska innehålla. Vi vill ha routes för följande URLer:
- products (GET)
    - [Vy] Lista upp alla produkter
- products (POST)
    - Skapa en ny produkt
- products/create (GET)
    - [Vy] Skapa en ny produkt
- products/{id} (GET)
    - [Vy] Visa detaljer om en specifik produkt
- products/{id} (PUT)
    - Uppdatera en produkt
- products/{id} (DELETE)
    - Radera en produkt
- products/{id}/edit (GET)
    - [Vy] Redigera en produkt

**[Vy]** ovan innebär att en webbsida returneras.

Vi kan antingen skapa dessa vyer manuellt - eller så kan vi låta Laravel göra detta för oss! Detta gör du genom att skriva följande i vår `routes/web.php`:
```php
Route::resource('/products', 'ProductController');
```

#### 2.2.2. Skapa Controller
Nu behöver vi ju skapa vår `ProductController`. Eftersom att den ska representera en resurs, så kan vi använda `PHP Artisan`för att skapa en "färdig" controller till oss genom:
```bash
php artisan make:controller ProductController --resource
```

``--resource`` tillägget ovan gör att funktioner för [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) skapas inuti er controller.

#### 2.2.3. Skapa Model
Vi ska nu även skapa vår modell av en produkt. Vi kan även här använda oss utav `PHP artisan`:
```bash
php artisan make:model Product
```
Notera att detta automatiskt ([genom ORM](https://laravel.com/docs/5.6/eloquent)) knyter modellen till tabellen `producs` i databasen. Vill du använda ett annat tabellnamn så står det i [dokumentationen](https://laravel.com/docs/5.6/eloquent#eloquent-model-conventions) hur man gör detta.

Så! Nu har vi skapat `routes`, `controller`, `model` för vår webbapplikation! Kvar är nu **logiken** och **vyerna**.

Utförliggare dokumentation finns under [models](https://laravel.com/docs/5.6/eloquent#defining-models) i Laravels dokumentation.

### 3. Vyer och logik

#### 3.1. Vyer
För att läsa om hur hur man arbetar med templates i Laravel, se [dokumentation för templates](https://laravel.com/docs/5.6/blade). En god idé kan sedan vara att dela upp sin template i olika delar, så att vi kan återanvända t.ex. sidhuvud och sidfot i de olika webbsidorna som vår tjänst erbjuder.

För att komma igång med vyer så börjar du med att gå in i `ProductController` och i funktionen `index` returnera vyn `index` enligt:
```php
public function index()
{
    return view("index");
}
```

Skapa sedan denna vy genom att skapa filen `index.blade.php` i mappen `resources/views/index.blade.php`. Testa nu att skriva något i filen, t.ex.
```html
<h1>Alla produkter</h1>
<p>Nedan listas alla produkter upp</p>
```

Surfa sedan till `localhost:8080/products` (eller den port som du kör på) och se resultatet av din vy! För att bygga enkla och snygga gränssnitt så rekommenderar vi att du använder ett CSS-ramver, t.ex. [Bootstrap](http://getbootstrap.com/). Där finns också [färdiga mallar](http://getbootstrap.com/getting-started/#template) att utgå från. Välj en som du tycker passar - eller bygg er egen mall om du är bekväma med det.

#### 3.2. Logik
För att skicka med data till vyerna så kan man skicka med en array som andra argument. Då anger man i arrayen en nyckel (variabelns namn som sedan kan användas i vyn) och värdet för variabeln. Nedan finns ett exempel att utgå från för att skicka med en lista på alla produkter till vår vy:
```php
public function index()
{
    $products = Product::all();

    return view("index", [
        "products" => $products
    ]);
}
```
Vi kan sedan skriva ut alla produkter i vår template genom `foreach`-loop i vår template:
```php
@foreach ($products as $product)
    {{ $product->title }}
@endforeach
```

### 4. Bygg klart er applikation
Vi ska nu bygga klart er webbapplikation, genom att komplettera de routes som vi skapat (du kan se era routes genom `php artisan route:list`):
```bash
+--------+-----------+-------------------------+------------------+------------------------------------------------+--------------+
| Domain | Method    | URI                     | Name             | Action                                         | Middleware   |
+--------+-----------+-------------------------+------------------+------------------------------------------------+--------------+
|        | GET|HEAD  | products                | products.index   | App\Http\Controllers\ProductController@index   | web          |
|        | POST      | products                | products.store   | App\Http\Controllers\ProductController@store   | web          |
|        | GET|HEAD  | products/create         | products.create  | App\Http\Controllers\ProductController@create  | web          |
|        | GET|HEAD  | products/{product}      | products.show    | App\Http\Controllers\ProductController@show    | web          |
|        | PUT|PATCH | products/{product}      | products.update  | App\Http\Controllers\ProductController@update  | web          |
|        | DELETE    | products/{product}      | products.destroy | App\Http\Controllers\ProductController@destroy | web          |
|        | GET|HEAD  | products/{product}/edit | products.edit    | App\Http\Controllers\ProductController@edit    | web          |
+--------+-----------+-------------------------+------------------+------------------------------------------------+--------------+
```
Alltså vyer för att:
- products (GET)
    - [Vy] Lista upp alla produkter
- products (POST)
    - Skapa en ny produkt
- products/create (GET)
    - [Vy] Skapa en ny produkt
- products/{id} (GET)
    - [Vy] Visa detaljer om en specifik produkt
- products/{id} (PUT)
    - Uppdatera en produkt
- products/{id} (DELETE)
    - Radera en produkt
- products/{id}/edit (GET)
    - [Vy] Redigera en produkt

Behöver du inspiration, så titta gärna på det exempel som vi byggde på förra föreläsningen som även finns här: [https://github.com/Tibbelit/da288a-laravel-movie-example](https://github.com/Tibbelit/da288a-laravel-movie-example)

Har du frågor på dessa punkterna så fråga gärna labbhandledaren!
