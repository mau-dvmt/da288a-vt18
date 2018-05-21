# Inlämningsuppgift 4 - Webbapplikation med ramverk, Continuous Integration och Delivery

Den fjärde inlämningsuppgiften handlar åter igen om att bygga en webbapplikation med **Lumen** eller **Laravel**. Webbapplikationen ska hantera olika *resurser* (vilka resurser väljer ni själva) samt ha inloggningsfunktionalitet. Ni ska även visa prov på god versionshantering under utvecklandet av webbapplikationen genom `GitFlow`. Applikationen ska hanteras av Travis CI för att automatiskt integrera förändringar, köra enhetstester och driftsätta nya versioner av applikationen.

## Uppgiften

Denna uppgift är mycket mer öppen än tidigare uppgifter, vilket innebär att ni sjävla får bestämma innehållet i er webbapplikation. Det är helt okej att återanvända det ny byggt på laborationerna eller inlämningsuppgift 3 och bygga en webbapplikation med resurserna `produkt`, `review` och `store` om man vill det, men det är även välkommet med egna idéer. Följande ska finnas finnas i inlämningsuppgiften.

1. Ni ska arbetar i grupper om två eller tre studenter
2. Ni ska använda `GitFlow` i er utvecklingsprocess på ett **korrekt** sätt, se [Lab 2](../../Labs/2/git.md).
3. Ni ska använda er av enhetstester för att säkerställa att er kod är korrekt, se [Lab 7](../../Labs/7/tester_och_refaktorisering.md).
4. Ni ska driftsätta er applikation på en virtuell maskin i Azure med hjälp av Travis CI, se [Lab 8](../../Labs/8/ddi.md).
5. Ni ska använda er av minst tre resurser (vilket ska resultera i minst tre `models`)
    - Minst två av resurserna ska ha en relation till varandra. T.ex. en `product` har flera `review`.
6. Varje resurs ska ha en egen `controller`.
7. Ni ska ha följande vyer för var och en av era resurser:
    - **Lista alla exemplar av en resurs (t.ex alla produkter)**
    - **Lista detaljerad information om en resurs (t.ex. en produkt)**
    - Skapa en ny resurs (t.ex. en ny produkt)
    - Redigera en resurs (t.ex. en produkt)
    - Radera en resurs (t.ex. radera en produkt)
    - _De fetstilta vyerna kräven **inte inloggning**_
8. Ni ska även ha en startsida som visar en översikt av webbplatsens syfte och resurser.

Om ni väljer att återanvända en tidigare uppgift, måste denna byggas ut med minst två nya funktioner, vilka båda hanteras i separata feature-branches. Samtliga gruppmedlemmar ska bistå med minst en commit till projektet.

Inlämningen sker som vanligt via GitHub och Its Learning. I ert projekts README.md-fil (se (GitHubs information om README.md)[https://help.github.com/articles/getting-started-with-writing-and-formatting-on-github/]) på GitHub specificerar ni vem som har lämnat in uppgiften, samt adressen till er färdiga applikation i drift.

## Krav

Följande krav finns på uppgiften:

- Uppgiften *ska* följa uppgiftsbeskrivningen ovan
- Uppgiften *ska* utföras i grupper om två eller tre studenter
- Ni *ska* använda er av `GitFlow` för versionshantering av webbapplikationen
- Ni *ska* testa er kod med relevanta enhetstester
- Ni *ska* driftsätta er applikation på en virtuell Ubuntu-maskin på Azure
- Ni *ska* använda Travis CI för att automatiskt köra enhetstester och driftsätta på er virtuella maskin
- Ni *ska* använda er av `migrations` för att skapa era tabeller
- Ni *ska* använda er utav `seeds` för att populera era tabeller
- Ni *ska* använda er utav `controllers` för att hantera logiken för er applikation
- Ni *ska* använda er utav `models` för att mappar era resurser mot databaser (ORM)
- Ni *ska* bygga ett grafisk gränssnitt med en av två metoder:
  - Ni *kan* använda er utav `views` för att bygga ert grafiska gränssnitt (med Laravel)
  - Ni *kan* använda er av en single page-lösning, där ni hämtar data från ett REST-API (med Lumen)
- Ni *ska* använda er utav `authentication` för att skydda vissa vyer (skapa/redigera/radera resurs)
- Ni *ska* följa PSR-1 & PSR-2 när det gäller hur ni skriver er kod

## Inlämning & deadline
Inlämningen sker genom att ni publicerar er lösning på Github och skickar in adressen till er lösning på Its learning. Glöm inte att uppgiften ska utföras och redovisas enskilt.

Uppgiften ska vara inlämnad senast onsdagen den *30:e maj*, 23.59. Uppgifter som lämnas in efter deadline kommer att rättas i samband med nästa inlämningsuppgift.

## Tips

Det kan vara lite klurigt att köra igång MySQL på Azure. Titta på den här (guiden)[https://docs.microsoft.com/en-us/azure/app-service/containers/tutorial-php-mysql-app] för att titta på hur ni hanterar det.
