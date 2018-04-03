# Kursens verktyg

För att kunna genomföra kursens laborationer och inlämningsuppgifter behöver du installera ett antal verktyg (se kursbokens appendix A och B). Precis som kursbokens författare föreslår vi att du använder dig av en virtuell maskin med Linux-distributionen Ubuntu 16.04. Vi har skapat en färdig virtuell maskin som du hämtar från [http://vm.idioti.se/WebbutvecklingMedRamverk.ova](http://vm.idioti.se/WebbutvecklingMedRamverk.ova). Filen är stor (2,3 GB) och tar en stund att packas upp av VirtualBox, så avsätt tid till detta. Användarnamn och lösenord i den virtuella maskinen är *student/student*.

Vill du hellre installera kursens verktyg på annat sätt (exempelvis på macOS eller Windows) går det också bra, men vi lärare ger ingen support på det. [XAMPP](https://www.apachefriends.org/index.html) är ett bra programpaket för detta.

## Installation av VirtualBox

För att köra den virtuella maskinen behöver du först installera VirtualBox, som är gratis. Det görs lite olika sätt, beroende på vilket operativsystem du använder.

### Windows
Hämta installationsfilen på [http://download.virtualbox.org/virtualbox/5.1.18/VirtualBox-5.1.18-114002-Win.exe](). Följ sedan instruktionerna hos [VirtualBox.org](https://www.virtualbox.org/manual/ch02.html#installation_windows).

### macOS
Hämta installationsfilen på [http://download.virtualbox.org/virtualbox/5.1.18/VirtualBox-5.1.18-114002-OSX.dmg](). Följ sedan instruktionerna hos [VirtualBox.org](https://www.virtualbox.org/manual/ch02.html#idm856).

### Linux
Installationsanvisningar och nedladdningar finns hos [https://www.virtualbox.org/wiki/Linux_Downloads](https://www.virtualbox.org/wiki/Linux_Downloads).

## Uppstart av den virtuella maskinen

När du laddat ner den virtuella maskinen och installerat VirtualBox måste du importera den virtuella maskinen. Gör det genom att gå till *Arkiv*-menyn och sedan välja *Importera appliance*. Välj sedan filen som du laddat ner och följ guiden. När du är klar, markera den virtuella maskinen och klicka på *Starta*. Du loggas in automatiskt. Om du är inaktiv, kan den virtuella maskinen låsas och du behöver ange ett lösenord för att få åtkomst till maskinen igen. Det lösenordet är *student*.

### Eventuellt problem med VT-x/AMD-V under Windows

Om du kör Windows, kan du stöta på ett problem med VT-x/AMD-V när du startar den virtuella maskinen. Om du gör det, följ [den här guiden](http://druss.co/2015/06/fix-vt-x-is-not-available-verr_vmx_no_vmx-in-virtualbox/) för att åtgärda problemet.

## Installation av verktygen

Samtliga verktyg installeras genom terminalen (*Systemverktyg* -> *MATE-terminal*). Terminalen är ett text-baserat gränssnitt, vilket gör att kommandon kan kopieras rakt in i terminalen.

De kommandon som skrivs ut nedan föregås av ett `$`. Detta ska du inte skriva in, utan anger bara att det som beskrivs är en terminal.

Kommandona består av tre delar:

* `apt-get`, som är Ubuntus pakethanterare (ungefär som ett riktigt kraftfullt installationsprogram).
* `install`, som anger att vi vill installera ett nytt paket (eller program).
* `package_name`, som är namnet på det paket som vi vill installera.

Som du snart ser, föregås alla kommandon även av ordet `sudo`. Det står för *"super user do"* och används för att använda administrationsrättigheter för det aktuella kommandot. Du måste därför ange även detta ord när du skriver in ett kommando. När ett lösenord efterfrågas, anger du *student*.

### Apache

Apache är den webbserver som vi kommer att använda oss av under kursen. Den är en klassisk webbserver som fungerar väldigt bra och är något så när enkel att konfigurera. Installera genom att skriva

```
$ sudo apt-get install apache2
```

i terminalen. Testa genom att öppna Firefox och gå till [http://localhost](http://localhost). Ser du en webbsida, har allt fungerat bra. Våra HTML-dokument ligger i */var/www/html*, vilket är standardplatsen för Apaches webbdokument i Debian-baserade Linuxdistributioner, som exempelvis Ubuntu. Den här platsen går att byta ut, men det ligger utanför den här guiden.

### MySQL

Vi använder oss av databasmotorn MySQL. Installera den genom att skriva

```
$ sudo apt-get install mysql-server
```

i terminalen. Ange ett root-lösenord, exempelvis *supersecret*.

### PHP

Vi behöver installera PHP för att kunna skriva några program. Vi installerar PHP för både webben och för CLI genom att skriva

```
$ sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql php-cli
```

i terminalen. Testa din installation av PHP genom att skapa en fil med texteditorn `nano`:

```
$ sudo nano /var/www/html/info.php
```

Fyll filen med följande enkla PHP-skript:

```
<?php
phpinfo();
?>
```

När du är klar, sparar du filen (**ctrl + o** och sedan enter) och avslutar programmet (**ctrl + x**).

Funktionen `phpinfo()` skriver ut information om din PHP-installation och konfiguration. Gå nu in på [http://localhost/info.php](http://localhost/info.php) med Firefox. Om du ser en en jättelång lila-grå lista med information, har allt gått bra.

På en produktionsserver vill du inte ha info.php-filen liggandes. Gör det därför till en vana att ta bort den genom att skriva

```
$ sudo rm /var/www/html/info.php
```

i terminalen.

### PHPMyAdmin

PHPMyAdmin används för att titta på databasen genom webbläsaren. Skriv in

```
$ sudo apt-get install phpmyadmin
```

i terminalen.

Du kommer att få en fråga om vilken webbserver som ska konfigureras automatiskt. Välj där *apache2* välj genom att trycka ner space-tangenten, sedan enter. Du kommer också att få en fråga om att konfigurera en databas för PHPMyAdmin med modulen *dbconfig-common*. Svara *Ja* på den frågan och ange det lösenord som du angav tidigare (troligtvis *supersecret*).

Testa genom att öppna Firefox och gå till [http://localhost/phpmyadmin](http://localhost/phpmyadmin).

### Composer

Composer är skrivet i PHP och hanteras inte av Ubuntus pakethanterare. Vi måste istället använda PHP för att installera det. Först måste filen hämtas. För detta använder vi oss av programmet `wget`:

```
$ wget https://getcomposer.org/composer.phar
```

Filen måste nu flyttas till sin rätta plats och få ett vettigt namn. Observera att du behöver ha högre rättigheter för detta, så nu behöver vi använda vår gamla kompis sudo igen:

```
$ sudo mv composer.phar /usr/local/bin/composer
```

Nu måste filen göras körbar, vilket i Linux görs så här:

```
$ sudo chmod +x /usr/local/bin/composer
```

Du kan nu köra Composer i valfritt projekt genom att skriva

```
$ composer
```

## Konfiguration

Om du bara ska använda din virtuella maskin som en utvecklingsmaskin, behöver du inte göra någon ytterligare konfiguration. Vill du däremot öppna upp din webbplats för omvärlden, behöver du konfigurera din maskin för detta.

### Konfigurera Apache

Apache konfigureras genom att ändra i någon av dess konfigurationsfiler. Den viktigaste filen heter */etc/apache2/apache2.conf*, i vilken grundläggande konfiguration görs. Här importeras även andra konfigurationsfiler för enskilda webbplatser.

#### Globalt servernamn

För att kunna serva webbsidor på ett korrekt sätt, måste serverns namn eller IP-adress ställas in. Öppna konfigurationsfilen genom att skriva

```
$ sudo nano /etc/apache2/apache2.conf
```

i terminalen. Gå till sista raden i filen, där du anger ditt domännamn eller publika IP-nummer. Om du äger en domän som du kan peka på din webbserver som du vill använda, ange den här. Om du exempelvis äger *kalleanka.nu*, skriver du så här:

```
ServerName www.kalleanka.nu
```

Har du ingen domän, anger du din servers publika IP-adress. Om din publika IP-adress är 12.34.56.78, skriver du:

```
ServerName 12.34.56.78
```

När du är klar, sparar du filen och avslutar nano.

#### Föredra PHP framför HTML

Vid en normal installation kommer Apache att leta efter *index.html* innan den letar efter *index.php*. I de flesta fall vill du leta efter *index.php* och köra den, och använda *index.html* som en fallback. För att göra detta måste vi vi ändra i ytterligare en konfigurationsfil, nämligen */etc/apache2/mods-enabled/dir.conf*. Öppna filen med nano:

```
$ sudo nano /etc/apache2/mods-enabled/dir.conf
```

Leta sedan upp raderna

```
<IfModule mod_dir.c>
    DirectoryIndex index.html index.cgi index.pl index.php index.xhtml index.htm
</IfModule>
```

och flytta `index.php` till den första positionen efter DirectoryIndex. Raderna ska nu se ut så här:

```
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```

Spara filen och starta om Apache.

#### Starta om Apache

Du startar om Apache genom att skriva följande i terminalen:

```
$ sudo systemctl restart apache2
```

Om du vill starta eller avsluta din webbserver utan att starta om den, kan du ange

```
$ sudo systemctl stop apache2
$ sudo systemctl start apache2
```

i din terminal.

### Konfigurera brandväggen

Din Ubuntu-maskin kommer att blockera alla anrop till din webbserver om du inte öppnar upp brandväggen för omvärlden. Ubuntu använder brandväggen *iptables* och konfigurationsverktyget *UFW*. Vi öppnar upp brandväggen med följande kommando:

```
$ sudo ufw allow in ”Apache Full”
```

### Konfigurera MySQL

När du installerade MySQL valde du troligtvis ett enkelt lösenord (som exempelvis *supersecret*). I en produktionsmiljö är det här alldeles för enkelt och måste därför ersättas med ett starkare. MySQL erbjuder ett verktyg för detta, som vi kör genom att skriva

```
$ sudo mysql_secure_installation
```

i terminalen. Var försiktig med root-lösenordet. Blir du av med det får du en massa jobb med att ställa om det.

Vidare konfiguration av PHPMyAdmin efter detta finns att läsa på [DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-16-0).

## Referenser

* VirtualBox - *Chapter 2. Installation details* ([https://www.virtualbox.org/manual/ch02.html](https://www.virtualbox.org/manual/ch02.html))
* DigitalOcean - *How To Install Linux, Apache, MySQL, PHP (LAMP) stack on Ubuntu 16.04* ([https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04))
* DigitalOcean - *How To Install and Secure phpMyAdmin on Ubuntu 16.04* ([https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-16-04](https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-16-04))
