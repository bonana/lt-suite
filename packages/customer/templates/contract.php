<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    <style>
    html {
        box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
        box-sizing: inherit;
    }

    body {
        color: #000;

        font-family: 'Open Sans', Helvetica, Arial, sans-serif;
        font-size: 1.375em;
    }

    ul, ol {
        margin: 0;
        padding: 0;
        margin-left: 1em;

        list-style-position: inside;
    }

    ul {
        list-style: none;
    }

    ul.alpha-low {
        list-style: lower-alpha;
    }

    ul li:not(:last-of-type),
    ol li:not(:last-of-type) {
        margin-bottom: 1.5em;
    }

    ul ul,
    ol ul {
        list-style: disc;
    }

    table.definition-table {
        width: 100%;
        table-layout: fixed;
    }

    table.definition-table thead {
        text-align: left;
    }

    table.definition-table th:first-child {
        width: 30%;
    }

    table.definition-table th,
    table.definition-table td {
        padding: 4px 8px;
    }

    .title {
        margin: 2em 0;
    }

    .slogan {
        max-width: 560px;
        margin: 0 auto;
    }

    .text-center {
        text-align: center;
    }

    .no-margin-bottom {
        margin-bottom: 0 !important;
    }

    .no-margin {
        margin: 0;
    }

    .no-margin-bottom:not(:last-child) + p.no-margin {
        margin-bottom: 1.5em !important;
    }

    /**
     * Signature
     */
    .signature {
        float: left;
        width: 50%;
        padding: 0 16px;
    }

    .signature .name {
        font-size: 1.25em;
        font-weight: bold;
    }

    /**
     * Clearfix
     */
    .cf:before,
    .cf:after {
        content: " "; /* 1 */
        display: table; /* 2 */
    }

    .cf:after {
        clear: both;
    }

    /**
     * For IE 6/7 only
     * Include this rule to trigger hasLayout and contain floats.
     */
    .cf {
        *zoom: 1;
    }

    li,
    p {
        page-break-inside: avoid !important;
    }
    </style>
</head>
<body>
<section>
    <h1 class="text-center title">Produktbeskrivning</h1>
    <p>Du har blivit erbjuden våran produkt Once in a livetime. Once in a Livetime är ett kampanjerbjudande på hemsida. Vi väljer tillsammans med dig ut valfritt tema på hemsida från Envato Market. Vi installerar, driver, och underhåller sedan hemsidan åt dig i 24 månader månader med startdatum vid signering utav avtal. Vi assisterar dig med att rikta om aktuella domäner och importerar din nuvarande data/information till ny hemsida. Du har också utöver installerad demoversion 5 timmar korrigering utav design och kod. För att samarbetet ska fungera så optimalt som möjligt så krävs det att vi är ense om riktlinjerna. Vid signering utav detta avtal så godkänner du samtliga punkter.</p>
</section>
<section>
    <h1 class="text-center title">Allmänt</h1>
    <ol>
        <li>Dessa villkor (“Avtalet”) reglerar förhållandet mellan <?php echo $customer->name; ?>, <?php echo $customer_contact->name . ' ' . $customer_contact->surname; ?> (“Kund”) och Livetime AB, org. nr 559046-2866, Kumlagatan 3, 723 42 Västerås, (”Livetime”) , avseende Once in a Livetime i förslag och faktura (“Tjänsterna”) i delad servermiljö (“Produkterna”).</li>
        <li>Kund kan vara juridisk eller myndig fysisk person. Kund får inte upplåta eller överlåta Tjänsterna (helt eller delvis) till någon annan utan Livetimes medgivande.</li>
    </ol>
</section>
<section style="margin-bottom: 30px;">
    <h1 class="text-center title">Webbhotell</h1>
    <p class="text-center slogan">Eftersom Livetime använder sig utav Binero som leverantör av webbhotell så måste du även läsa, godkänna och följa deras användavillkor. När du signerar avtalet så godkänner du dessa villkor.</p>
</section>
<section>
    <h1>Livetimes ansvar</h1>
    <ol>
        <li>Livetime utövar ingen kontroll över information som hanteras av Kund inom Webbhotellet. Livetime är således inte ansvarigt för verksamheten på enskilda hemsidor eller innehållet där, eller direkta eller indirekta skador som uppkommer till följd av agerande från Kund. Livetime svarar inte för Kunds eventuella ersättningsskyldighet mot tredje part. Livetime ansvarar inte för dataförlust, eller annan skada som uppstått till följd av virus eller obehörigt intrång eller obehörig påverkan av Bineros servrar.</li>
        <li>Livetime ansvarar endast för skador som Livetime eller av Livetime anlitad underleverantör orsakar genom vårdslöshet. Livetimes skadeståndsskyldighet är begränsad till direkta förluster till ett sammanlagt värde motsvarande högst avgiften för Tjänsterna under gällande avtalsperiod. Ersättning utgår inte för förlust i näringsverksamhet, eller indirekt skada, såsom minskad produktion eller omsättning för Kund eller tredje part.</li>
        <li>Kund som drabbas av skada på grund av fel hos Livetime, måste meddela detta omedelbart. Livetime lämnar ingen ersättning för skador som kunde ha undvikits. Krav på skadestånd ska framföras skriftligen till Livetime och inkomma inom skälig tid efter det att Kund märkt eller börjat märka grunden för kravet.</li>
        <li>Binero har fullgoda system för dubbel lagring av data, så att denna kan återskapas i händelse av haveri, men Livetime garanterar inte tillgången till data på Kunds hemsida och ansvarar inte för förlust av data.</li>
    </ol>
</section>
<section>
    <h1>Kunds ansvar</h1>
    <ol>
        <li>Kunden ansvarar för att Livetime har tillgång till riktig och effektiv kontaktinformation under hela kontraktstiden. Livetime ansvarar inte för problem, skador eller kostnader som uppstår på grund av att kontaktinformationen är felaktig, eller att Kund inte omgående tar del av Livetimes meddelanden.</li>
        <li>Kund ansvarar för säker hantering av Kunds användarnamn och lösenord.</li>
        <li>Kund ansvarar för att information som hanteras av Kund inom Webbhotellet (eller Kunds verksamhet på Webbhotellet) inte (a) gör intrång i tredje parts rättigheter, (b) på annat sätt bryter mot svensk lagstiftning, (c) orsakar allvarlig skada, eller (d) är uppenbart oförsvarlig ur etisk synpunkt.</li>
        <li>Webbhotellet är avsett endast för hemsidesparkering och årligt underhåll. Livetime förbehåller sig rätten att avgöra när gränsen för olaglig eller uppenbart oförsvarlig verksamhet / innehåll överskrids och vad som är rimliga åtgärder för att garantera säkerheten för Webbhotellet. Kund ansvarar för att skyndsamt agera om Livetime uppmanar kund att ta bort information inom Webbhotellet som enligt Livetimes skäliga uppfattning är oacceptabel.</li>
        <li>Livetime har rätt att kontrollera information som hanteras inom Webbhotellet i samband med felsökning eller om det föreligger misstankar om brott mot dessa villkor. Livetime har även rätt att med omedelbar verkan ta bort eller flytta information som hanteras inom Webbhotellet om denna information riskerar att orsaka skada för Livetimes kunder, servrar eller nätverk. Detta gäller även om sådan skada orsakas indirekt genom att innehållet ger upphov till överbelastning eller olagliga angrepp från utomstående.</li>
        <li>Avtalet kan sägas upp av Livetime om Kund bryter mot villkoren i Avtalet. Innan uppsägning verkställs ska Livetime, om det är möjligt, ge Kund skälig tid för att vidta rättelse. Om innehållet eller verksamheten på Kundens hemsida ger upphov till överbelastning eller andra säkerhetsproblem i Webbhotellet, som kan antas hota funktionen på andra Kunders hemsidor, förbehåller sig Livetime rätten att omedelbart – och utan föregående varning – stänga hemsida som orsakar problemen.</li>
        <li>Kund som bryter mot detta avtal har inte rätt till återbetalning av erlagda avgifter och är skadeståndsskyldig mot Livetime i den omfattning som gäller enligt svensk rätt.</li>
    </ol>
</section>
<section>
    <h1>Otillåten Användning</h1>
    <ol>
        <li>Kunden får inte använda Tjänsterna i strid med Avtalet, gällande lagstiftning eller för att främja olämplig eller oetisk verksamhet. Information som lagras inom Webbhotellet eller som annars omfattas av Tjänsterna får inte innehålla:
        <ul>
            <li>Information som gör intrång i tredje mans immateriella rättigheter.</li>
            <li>Datavirus eller annan skadlig kod;</li>
            <li>Barnpornografiskt, pornografiskt, diskriminerande, rasistiskt, förnedrande, hotfullt eller våldsamt material eller annat material som utgör olaga hot, hets mot folkgrupp, förtal eller som uppmuntrar till olagliga handlingar eller aktiviteter;</li>
        </ul>
        </li>
        <li>Livetime äger rätt att omedelbart stänga av kunden från webbhotellet och vidta andra rättsliga åtgärder om Kundens användning av Tjänsterna strider mot punkt “Otillåten Användning” ovan eller om Kunden använder webbhotellet på ett sätt som riskerar att skada Livetime.</li>
    </ol>
</section>
<section style="margin-bottom: 30px; page-break-inside: avoid;">
    <h1 class="text-center title">Tema</h1>
    <p class="text-center slogan">Eftersom Livetime använder sig utav Envato som leverantör utav teman så måste du även godkänna deras licensvillkor. Du godkänner dessa villkor och blir ägare utav licensen när du signerar avtalet.</p>
</section>
<section>
    <h1>The low-down! The nuts and bolts of this license</h1>
    <ol>
        <li>The Regular License grants you, the purchaser, an ongoing, non-exclusive, worldwide license to make use of the digital work (Item) you have selected. Read the rest of this license for the details that apply to your use of the Item, as well as the FAQs (which form part of this license).</li>
        <li>You are licensed to use the Item to create one single End Product for yourself or for one client (a “single application”), and the End Product can be distributed for Free.</li>
        <li>
            An End Product is one of the following things, both requiring an application of skill and effort.
            <ul class="alpha-low">
                <li>
                    For an Item that is a template, the End Product is a customised implementation of the Item.
                    <p class="no-margin">For example: the item is a website theme and the end product is the final website customised with your content.</p>
                </li>
                <li>For other types of Item, an End Product is a work that incorporates the Item as well as other things, so that it is larger in scope and different in nature than the Item.</li>
            </ul>
        </li>

        <p>For example: the item is a button graphic and the end product is a website. See the FAQs for examples and information about End Products and the single application requirement.</p>

        <h1>Go for it! Things you can do with the Item</h1>
        <li>You can create one End Product for a client, and you can transfer that single End Product to your client for any fee. This license is then transferred to your client.</li>
        <li>You can make any number of copies of the single End Product, as long as the End Product is distributed for Free.</li>
        <li>You can modify or manipulate the Item. You can combine the Item with other works and make a derivative work from it. The resulting works are subject to the terms of this license. You can do these things as long as the End Product you then create is one that’s permitted under clause</li>
        <p>For example: You can license a flyer template, include your own photos, modify the layout and get it printed to promote your event.</p>

        <h1>Whoa there! Things you can't do with the item</h1>
        <li>You can’t Sell the End Product, except to one client. (If you or your client want to Sell the End Product, you will need the Extended License.)</li>
        <li class="no-margin-bottom">You can’t re-distribute the Item as stock, in a tool or template, or with source files. You can’t do this with an Item either on its own or bundled with other items, and even if you modify the Item. You can’t re-distribute or make available the Item as-is or with superficial modifications. These things are not allowed even if the re-distribution is for Free.</li>
        <p class="no-margin">If you’re an Envato author you can use other items in your item’s preview without a license, under conditions. See the author licensing FAQs.</p>
        <p>For example: You can’t purchase an HTML template, convert it to a WordPress theme and sell or give it to more than one client. You can’t license an item and then make it available as-is on your website for your users to download.</p>
        <li>You can’t use the Item in any application allowing an end user to customise a digital or physical product to their specific needs, such as an “on demand”, “made to order” or “build it yourself” application. You can use the Item in this way only if you purchase a separate license for each final product incorporating the Item that is created using the application. Examples of “on demand”, “made to order” or “build it yourself” applications: website builders, “create your own” slideshow apps, and e-card generators. You will need one license for each product created by a customer, or contact us at Help Center to discuss.</li>
        <li class="no-margin-bottom">Although you can modify the Item and therefore delete unwanted components before creating your single End Product, you can’t extract and use a single component of an Item on a stand-alone basis.</li>
        <p class="no-margin">For example: You license a website theme containing icons. You can delete unwanted icons from the theme. But you can't extract an icon to use outside of the theme.</p>
        <li>You must not permit an end user of the End Product to extract the Item and use it separately from the End Product.</li>
        <li class="no-margin-bottom">You can’t use an Item in a logo, trademark, or service mark.</li>
        <p class="no-margin">Looking for a logo? See our GraphicRiver logos section, which has its own license.</p>
        <h1>The nitty gritty! Other license terms</h1>
        <li>For some Items, a component of the Item will be sourced by the author from elsewhere and different license terms may apply to the component, such as someone else’s license or an open source or creative commons license. If so, the component will be identified by the author in the Item’s description page or in the Item’s downloaded files. The other license will apply to that component instead of this license. This license will apply to the rest of the Item.</li>
        <p>For example: A theme might contain images licensed under a Creative Commons CCBY license. The CCBY license applies to those specific images. This license applies to the rest of the theme.</p>
        <li>
            For some items, a GNU General Public License (GPL) or another open source license applies. The open source license applies in the following ways:
            <ul class="alpha-low">
                <li class="no-margin-bottom">Some Items, even if entirely created by the author, may be partially subject to the open source license: a ‘split license’ applies. This means that the open source license applies to an extent that’s determined by the open source license terms and the nature of the Item, and this license applies to the rest of the Item.</li>
                <p class="no-margin">Split and other open source licensing is relevant for themes and plug-ins for WordPress and other open source platforms. Where split licensing applies, this is noted in the Item’s download files: for more information, see this Help Center article</p>
                <li class="no-margin-bottom">For some Items, the author may have chosen to apply a GPL license to the entire Item. This means that the relevant GPL license will apply to the entire Item instead of this license.</li>
                <p class="no-margin">Where an Item is entirely under a GPL license, it will be identified as a GPL item and the license noted in the download files: for more information see the FAQs</p>
            </ul>
        </li>
        <li class="no-margin-bottom">You can only use the Item for lawful purposes. Also, if an Item contains an image of a person, even if the Item is model-released you can’t use it in a way that creates a fake identity, implies personal endorsement of a product by the person, or in a way that is defamatory, obscene or demeaning, or in connection with sensitive subjects.</li>
        <p class="no-margin">For more information on sensitive subjects, see our FAQs.</p>
        <li>Items that contain digital versions of real products, trademarks or other intellectual property owned by others have not been property released. These Items are licensed on the basis of editorial use only. It is your responsibility to consider whether your use of these Items requires a clearance and if so, to obtain that clearance from the intellectual property rights owner.</li>
        <li>This license applies in conjunction with the Envato Market Terms for your use of Envato Market. If there is an inconsistency between this license and the Envato Market Terms, this license will apply to the extent necessary to resolve the inconsistency.</li>
        <li>This license can be terminated if you breach it. If that happens, you must stop making copies of or distributing the End Product until you remove the Item from it.</li>
        <li>The author of the Item retains ownership of the Item but grants you the license on these terms. This license is between the author of the Item and you. Envato Pty Ltd is not a party to this license or the one giving you the license.</li>
    </ol>
</section>
<section style="padding: 30px 0; page-break-inside: avoid;">
    <h1>Definitions</h1>
    <table class="definition-table" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th>Term used</th>
                <th>Meaning</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>End Product</td>
                <td>See clause 3 of this license</td>
            </tr>
            <tr>
                <td>Free</td>
                <td>No fee is paid by the end user to access the End Product. The End Product is not sold. No fee is paid to subscribe to a service that includes the End Product (eg a website subscription fee)</td>
            </tr>
            <tr>
                <td>Sell or Sold</td>
                <td>Sell, license, sub-license or distribute for any type of fee or charge</td>
            </tr>
        </tbody>
    </table>
</section>
<section>
    <h1 class="text-center title">Process</h1>
    <p class="text-center slogan">Tänk på att Livetime inte tar ansvar för kvalitén på det inköpta temat. Alla produkter som finns för försäljning hos Envato genomgår deras egna kvalitetskontroll.</p>
    <ol style="margin-top: 30px;">
        <li>När Kund signerat avtalet och godkänt villkoren så utgår automatiskt en faktura på e-post. Fakturan innehåller halva beloppet och måste betalas innan något arbete påbörjas.</li>
        <li>När betalning är mottagen så påbörjas arbetet genom installation utav utvalt tema på vår server hos Binero. Vi tilldelar Kund en länk där hen kan följa och påverka arbetet live.</li>
        <li>Vi erbjuder hjälp med att importerar den data/information Kund vid tidpunkten utav signering har synlig på sin hemsida.</li>
        <li>Kund får nu 5 timmars design och kod så att vi kan anpassa hemsidan efter Kunds önskemål och varumärkesprofil. För tid därutöver debiteras 600 SEK per timme.</li>
        <li>Vi erbjuder våran hjälp med att rikta om aktuella domäner och assistans med e-postadresser om det önskas.</li>
        <li>När Kund känner sig nöjd med resultatet så utgår en slutfaktura via e-post.</li>
        <li>När betalning för slutfaktura är mottagen så blir hemsidan tillgänglig för dig och dina besökare.</li>
    </ol>
</section>
<section class="cf" style="margin-top: 90px;">
    <div class="signature unsigned">
        <img src="<?php echo LTS_CUSTOMER_URL; ?>/templates/img/empty.png">
        <div class="name"><?php echo $customer_contact->name . ' ' . $customer_contact->surname; ?></div>
        <div class="company"><?php echo $customer->name; ?></div>
    </div>
    <div class="signature signed" style="text-align: right;">
        <img src="<?php echo LTS_CUSTOMER_URL; ?>/templates/img/sebastian.png">
        <div class="name">Sebastian Dahlström</div>
        <span class="company">Verkställande Direktör för</span>
        <span class="company-name">Livetime AB</span>
    </div>
</section>
</body>
</html>