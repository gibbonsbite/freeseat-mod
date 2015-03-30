<?php

/** Finnish language file.
*/

require_once (FS_PATH . "languages/default.php");

$lang["_encoding"] = "ISO-8859-1";


$lang["access_denied"] = 'Pääsy kielletty - Istuntosi on vanhentunut';
$lang["acknowledge"] = 'Hyväksy'; // used with check_st_update
$lang["address"] = 'Osoite';
$lang["admin"] = 'Hallinta toiminnot';
$lang["admin_buy"] = '%1$sVaraa%2$s lippuja';
$lang["alert"] = 'VAROITUS';
$lang["are-you-ready"] = 'Varmista tiedot ja paina Jatka.';

$lang["backto"] = '%1$s';
$lang["book"] = 'Varaa';
$lang["bookagain"] = 'Tee %1$sToinen varaus samaan elokuvaan%2$s';
$lang["bookid"] = 'Koodi';
$lang["book_adminonly"] = 'Varaus suljettu';
$lang["book_submit"] = 'Tee varaus';
$lang["booking_st"] = 'Varaukset tilassa %1$s';
$lang["bookinglist"] = 'Selaa/Muokkaa %1$svarauksia%2$s';
$lang["bookingmap"] = 'Varauskartta';
$lang["buy"] = '%1$sVaraa%2$s lippuja';

$lang["cancel"] = "Peruuta";
$lang["cancellations"] = "Peruutukset";
$lang["cat"] = 'Hinta';
$lang["cat_free"] = 'Ilmaisia';
$lang["cat_normal"] = 'Hinta ';
$lang["cat_reduced"] = 'Alennus ';
$lang["ccard_failed"] = '%1$s WHILE PROCESSING A CREDIT CARD NOTIFICATION\n\n\n';
$lang["ccard_partner"] = 'Credit card payment made secure by&nbsp;%1$s';
$lang["change_date"] = 'Muuta näytöstä';
$lang["change_pay"] = 'Muuta %1$syhteystietoja%2$s';
$lang["change_seats"] = 'Muuta %1$spaikkaa%2$s';
$lang["check_st_update"] = 'Tarkista että alla oleva lista varauksista on oikein ja paina Varmista';
$lang["choose_show"] = 'Valitse esitys';
$lang["city"] = 'Kaupunki';
$lang["comment"] = 'Merkinnät';
$lang["confirmation"] = 'Varmista';
$lang["continue"] = 'Jatka';
$lang["country"] = 'Maa';
$lang["class"] = 'Tyyppi';
$lang["closed"] = 'Suljettu';
$lang["col"] = 'Paikka';
$lang["create_show"] = 'Uusi elokuva';

$lang["date"] = 'Pvm';
$lang['datesandtimes'] = 'Näytökset';
$lang["date_title"] = 'Pvm<br>(dd.mm.yyyy)';
$lang["day"] = 'pv.'; // abbreviated
$lang["days"] = 'päivät';
$lang["DELETE"] = 'Poista'; // used in check_st_update
$lang["description"] = 'Kuvaus';
$lang["diffprice"] = '<strong><img src="images/handicap.jpg"> paikat ovat pyörätuolipaikkoja eikä niissä ole istumapaikkaa</strong>';
$lang["disabled"] = "Suljettu"; // for shows or payment methods
$lang["dump_csv"] = 'Tietokanta CSV-muodossa: %1$sbookings.csv%2$s';

$lang['editshows'] = '%1$sMuokkaa%2$s tietoja tai näytöksiä';
$lang["email"] = 'Sähköpostiosoite';
$lang["err_bademail"] = 'Sähköpostiosoite ei ole hyväksytyssä muodossa';
$lang["err_badip"] = 'Sinulla ei ole pääsyoikeuksia tähän tiedostoon';
$lang["err_badkey"] = 'Pääsyavain on väärä. Yritä uudelleen. (Lähetä sähköpostia %1$s jos et hallinnoi)';
$lang["err_bookings"] = 'Virhe varausten luvussa';
$lang["err_ccard_cfg"] = 'Luottokorttimaksut pitää asettaa config.phpssa ennen kuin ne voidaan ottaa käyttöön'; // § NEW in 1.2.1
$lang["err_ccard_insuff"] = 'Ei voida maksaa paikkaa %1$d joka maksaa %4$s %2$d kun vain %4$s %3$d vapaana!';
$lang["err_ccard_mysql"] = '(Mysql) virhe luottokorttisiirtoa kirjatessa';
$lang["err_ccard_nomatch"] = 'push (%1$s) and pull (%2$s) do not match (using pull amount)';
$lang["err_ccard_pay"] = 'Ei voida tallentaa luottokorttimaksua paikalle %1$d ! (tarkista lokit - paikka on mahdollisesti jo maksettu)';
$lang["err_ccard_repay"] = 'Hyväksytty luottokorttimaksu saapunut paikalle %1$d joka on jo maksettu !';
$lang["err_ccard_toomuch"] = 'Maksu liian suuri! %3$s %1$d käyttämättä %3$s %2$d :stä.';
$lang["err_ccard_user"] = 'Maksussa oli ongelma - voit yrittää uudelleen, tai lähettää sähköpostia %1$s';
$lang["err_checkseats"] = 'Valitse paikat';
$lang["err_closed"] = 'Pahoittelumme, nettivaraus tähän näytökseen on sulkeutunut.';
$lang["err_config"] = 'Check server configuration on: '; // § NEW
$lang["err_connect"] = 'Yhteysvirhe : ';
$lang["err_cronusage"] = "One argument expected (database booking system password)\n";
$lang["err_email"] = 'Kaikilla valituilla varauksilla ei ole sama sähköpostiosoite (pidetään ensimmäinen)';
$lang["err_filetype"] = 'Wrong file type, was expecting: ';
$lang["err_ic_firstname"] =    'Kaikilla valituilla varauksilla ei ole sama etunimi (pidetään ensimmäinen)';
$lang["err_ic_lastname"] =    'Kaikilla valituilla varauksilla ei ole sama sukunimi (pidetään ensimmäinen)';
$lang["err_ic_payment"] = 'Kaikilla valituilla varauksilla ei ole sama maksutapa (pidetään ensimmäinen)';
$lang["err_ic_phone"] =   'Kaikilla valituilla varauksilla ei ole sama puh. nro (pidetään ensimmäinen)';
$lang["err_ic_showid"] =  'Kaikki valitut varaukset eivät ole samaan näytökseen...';
$lang["err_noaddress"] = 'Luottokorttimaksua käyttäessä täytyy täyttää vähintään sähköpostiosoite, lähiosoite, postinumero sekä postitoimipaikka.';
$lang["err_noavailspec"] = 'Ei elokuvia'; // § NEW IN 1.2.2b
$lang["err_nodates"] = 'Elokuvaan ei löytynyt näytöksiä.';
$lang["err_noname"] = 'Täytä etunimi, sukunimi ja sähköpostiosoite.';
$lang["err_noprices"] = 'Tähän näytökseen ei ole määritelty hintaa.';
$lang["err_noseats"] = 'Ei paikkoja'; // § NEW
$lang["err_nospec"] = 'Täytä elokuvan nimi.';
$lang["err_notheatre"] = 'Valitse sali.';
$lang["err_occupied"] = 'Pahoittelumme, joku valitsemistanne paikoista on juuri varattu.';
$lang["err_paymentclosed"] = 'Maksu %1$s on juuri suljettu tähän esitykseen';
$lang["err_payreminddelay"] = 'Payment delay must be longer than remind delay';
$lang["err_postaltax"] = 'Hinta on liian korkea postimaksulle';
$lang["err_price"] = 'Paikan hintaa ei löytynyt';
$lang["err_pw"] = 'Väärä käyttäjä tai salasana. Yritä uudelleen.';
$lang["err_scriptauth"] = 'Request to script %1$s rejected';
$lang["err_scriptconnect"] = 'Connecting to the %1$s script failed';
$lang["err_seat"] = 'Virhe paikan haussa';
$lang["err_seatcount"] = 'Et voi varata näin montaa paikkaa kerralla';
$lang["err_seatlocks"] = 'Virhe lukitessa paikkaa';
$lang["err_session"] = 'Sinulla ei ole varausistuntoa (Ovatko evästeet päällä selaimessasi?)';
$lang["err_setbookstatus"] = 'Virhe muuttaessa paikan tilaa';
$lang["err_shellonly"] = 'PÄÄSY KIELLETTY - Pääsy tälle sivulle vaatii shell tunnuksia';
$lang["err_show_entry"] = 'Tätä näytöstä ei voida tallentaa ennen kuin täydennät puuttuvat tiedot.';
$lang["err_showid"] = 'Väärä näytöksen tunnus';
$lang["err_smtp"] = 'Varoitus: viestin lähetys epäonnistui: %1$s - Palvelin vastasi: %2$s';
$lang["err_spectacle"] = 'Virhe etsiessä elokuvan tietoja';
$lang["err_spectacleid"] = 'Väärä elokuvan tunnus'; // § NEW
$lang["err_upload"] = 'Virhe lähettäessä tiedostoa';
$lang["expiration"] = 'Vanhentuminen';
$lang["expired"] = 'vanhentunut';

$lang["failure"] = 'PANIC';
$lang["file"] = 'Julisteen nimi'; 
$lang["filter"] = 'Tila:'; // filter form header in bookinglist
$lang["firstname"] = 'Etunimi';
$lang["from"] = ''; // in a temporal sense : from a to b

$lang["hello"] = 'Hei %1$s,';
$lang["hideold"] = '%1$sPiilota%2$s vanhat'; // §NEW IN 1.2.2b that's "%1$s hide %2$s" without the spaces
$lang["hour"] = 't'; // abbreviated
/* (note : this is only used for at least two seats) */
$lang["howmanyare"] = 'Montako näistä %1$d paikasta ovat';

$lang["id"] = 'Tunnus';
$lang['imagesrc'] = 'Juliste';
$lang["immediately"] = 'heti';
$lang["import"] = 'Lähetä tämä tiedosto';
$lang["in"] = '%1$s:ssa'; // as in "in <ten days>"
$lang["index_head"] = '<img src="/reservation/images/studio123ticketing.jpg" alt="Järvenpään Studiot Lipunvaraus">';
$lang["intro_ccard"] = <<<EOD
 <h2>Kiitos varauksestanne</h2>

<p class="main">Paikat ovat nyt varattu nimellänne</p>
EOD;

$lang["intro_confirm"] = 'Tarkista tiedot ja paina Tee varaus.';
$lang["intro_finish"] = 'Tämä on lippusi. Tulosta se ja tuo mukanasi kassalle.';
$lang["intro_params"] = <<<EOD
<h2>Maksutapojen saatavuus</h2>

<p class="main">
<ul><li><p>
Lisää tänne ajat kuinka pitkään suhteessa näytösaikaan eri maksutavat ovat saatavilla.
</p>
<li>
<p>Lisättävät numerot ovat muodossa <em>minuuttia</em> ennen näytöksen alkua.</p>
<li>
<p>Kassalla maksun aukeamis/sulkemis aika tarkoittaa aikaa jolloin
asiakkaat voivat valita maksun kassalla (ei kassan aukioloaikaa)</p>

<li>
<p>
Postikuljetuksen viivästymiset näytetään arkipäivissä. 
Viikonloput ja juhlapyhät lisätään kuljetus aikaan.
</p>
</ul>
</p>

%1\$s

<h2>Muistutukset ja peruutus</h2>

<p class="main">Riippuen asiakkaan valitsemasta maksutavasta,
kuinka monta <em>päivää</em> varauksen jälkeen täytyy lähettää muistutus,
tai peruuttaa varaus?</p>

%2\$s

<h2>Muut valinnat</h2>

EOD;
//'

$lang["intro_remail"] = <<<EOD

<h2>Varauksen nouto</h2>

<p class='main'>Kirjoita seuraavaan kenttään sähköpostiosoite
jota käytit varatessasi ja paina lähetä.<br>
Saat varaukset sähköpostiisi. Muista tarkistaa roskaposti kansio!</p>

<p class='main'>Sähköposti: %1\$s</p>

<p class='main'>(jos et antanut varatessasi sähköpostiosoitetta
tai sinulla ei ole enään pääsyä siihen, ota yhteys meihin aukioloaikoina puhelimitse tai kassalla)</p>

EOD;

$lang["intro_remail2"] = <<<EOD

<h2>Varauksen nouto</h2>

<p class='main'>Jos sähköposti jonka sait sisältää pääsykoodin,
voit nyt kopioida sen seuraavaan kenttään, jotta voit tulostaa liput:</p>

<p class='main'>(Huom. tämä ei ole varaustunnus)</p>

<p class='main'>Pääsykoodi lippuihin: %1\$s</p>

EOD;

$lang["intro_seats"] = 'Paina "Jatka" sivun alalaidasta kun olet tehnyt valinnat';
$lang["is_default"] = 'Tämä on valittu näytös.';
$lang["is_not_default"] = 'Tämä ei ole valittu näytös.';

$lang["lastname"] = 'Sukunimi';
$lang["legend"] = 'Paikat: ';
$lang["link_bookinglist"] = 'Varauslistaan';
$lang["link_edit"] = 'Muokkaa näytöksiä';
$lang["link_index"] = 'Etusivulle';
$lang["link_showlist"] = 'Ohjelmistoon';
$lang["link_pay"] = 'Varaustiedot';
$lang["link_repr"] = 'Näytös lista';
$lang["link_seats"] = 'Paikan valinta';
$lang["login"] = 'Kirjaudu sisään (vain henkilökunnalle):';
$lang["logout"] = 'Kirjaudu ulos';

$lang["mail-anon"] = <<<EOD
Hei,

Nämä ovat tietoja henkilöstä joka ei antanut sähköpostiosoitetta.

Jotta tarvittaessa voitte ottaa heihin yhteyden, tässä on tiedot jotka
asiakas antoi varatessaan paikkoja:

EOD;

/* NOTE - Assumes spectacle must be preceded by a (masculine)
 definite article. In the future we will need to integrate the article
 in the spectacle name and alter/extended it when needed (e.g. French
 de+le = du, German von+dem = vom, etc) */
$lang["mail-booked"] = <<<EOD
Hyvä asiakas,<br />
kiitos varauksesta.<br /><br />

Alla varauksenne tiedot:

EOD;

$lang["mail-cancel-however"] = <<<EOD
Tämä on automaattinen viesti. Varauksenne seuraavaan paikkaan on peruttu:
EOD;
$lang["mail-cancel-however-p"] = <<<EOD
Tämä on automaattinen viesti. Varauksenne seuraaviin paikkoihin on peruttu:
EOD;
$lang["mail-cancel"] = <<<EOD
Tämä on automaattinen viesti. Varauksenne seuraavaan paikkaan on peruttu.:
EOD;
$lang["mail-cancel-p"] = <<<EOD
Tämä on automaattinen viesti. Varauksenne seuraaviin paikkoihin on peruttu:
EOD;

$lang["mail-gotmoney"] = 'Olemme saaneet maksunne seuraavasta paikasta:';
$lang["mail-gotmoney-p"] = 'Olemme saaneet maksunne seuraavista paikoista:';

$lang["mail-heywakeup"] = <<<EOD

Emme ole vielä saaneet maksua seuraavasta varaamastanne paikasta:

%1\$s
Jos maksunne saapui juuri, voit poistaa tämän viestin.

Jos haluatte sittenkin peruuttaa varauksenne,
kertokaa siitä meille vastaamalla tähän sähköpostiin.
Jos ette vastaa, joudumme peruuttamaan varauksenne.

EOD;

$lang["mail-heywakeup-p"] = <<<EOD


Järjestelmämme mukaan, ette ole vielä lunastaneet seuraavia lippuja:

%1\$s
Jos olette jo maksaneet, voitte poistaa tämän viestin.

Jos haluatte sittenkin peruuttaa varauksenne,
kertokaa siitä meille tämä sähköposti osoitteeseen peruutukset@studiot123.com
EOD;

$lang["mail-notconfirmed"] = <<<EOD
EOD;

// for one seat
$lang["mail-notdeleted"] = 'Seuraava varaus pidetään:';
// for more than one seat
$lang["mail-notdeleted-p"] = 'Seuraavat varaukset pidetään:';
$lang["mail-notpaid"] = 'Seuraava paikka on varattu, mutta emme ole vielä saaneet maksua:';
$lang["mail-notpaid-p"] = 'Seuraavat paikat ovat varattuja, mutta emme ole vielä saaneet maksua:';
$lang["mail-remail"] = <<<EOD
Pyysitte lähettää tiedot varauksestanne %1\$s sivustolla, tässä on kaikki varauksenne jotka
olette tehneet tästä sähköpostiosoitteesta.


Pääsyavain lippuihin : %2\$s

EOD;

$lang["mail-reminder-p"] = <<<EOD
Muistutus: Seuraavat varaamanne paikat ovat vielä maksamatta:

%1\$s
Jos haluatte peruuttaa tämän varauksen, vastatkaa tähän sähköpostiin.

EOD;

$lang["mail-reminder"] = <<<EOD
Muistutus: Seuraava varaamanne paikka on vielä maksamatta:

%1\$s
Jos haluatte peruuttaa tämän varauksen, lähettäkää tämä sähköposti osoitteeseen peruutukset@studiot123.com

EOD;

$lang["mail-secondmail"] = <<<EOD
Saatte toisen sähköpostin kun olemme saaneet maksun varauksestanne.

EOD;

$lang["mail-spammer"] = <<<EOD
Hei,

Joku pyysi varaustietoja tähän 
osoitteeseen (%3\$s) %1\$s
(%2\$s)

Meillä ei ole yhtään varausta tästä osoitteesta.
Tämä voi tarkoittaa yhtä kolmesta asiasta:

* Teit varauksen, mutta käytit toista sähköpostiosoitetta
* Sinulla oli varaus, mutta se on peruttu. Sinulle pitäisi olla saapunut
 sähköposti tästä kun se tapahtui.
* Joku muu on täyttänyt pyynnön

Jos sinulla on kysyttävää, vastaathan tähän sähköpostiin.

EOD;
// following always plural
$lang["mail-summary-p"] = 'Paikat jotka ovat varmistettuja (paitsi vanhoihin näytöksiin) ovat seuraavat:';

$lang["admin-thankee"] = 'Varaus tallennettu.';

$lang["mail-thankee"] = <<<EOD
Liput voitte lunastaa kassaltamme osoitteessa Helsingintie 12, Järvenpää.<br /><br />
<strong>Esteen sattuessa pyydämme ystävällisesti peruuttamaan varauksenne soittamalla numeroon (09) 8366770 kassan aukioloaikana
tai lähettämällä tämän sähköpostin osoitteeseen <a href="mailto:peruutukset@studiot123.com?Subject=Varauksen peruutus" target="_top">peruutukset@studiot123.com</a></strong><br /><br />
EOD;

$lang["mail-oops"] = <<<EOD
Jos uskot tämän olevan virhe, vastatkaa tähän sähköpostiin tai soittakaa kassallemme mahdollisimman pian
, jotta voimme palauttaa varauksenne.
EOD;
    //'

$lang["mail-sent"] = 'Sinulle on lähetetty sähköposti varaustiedoillanne. Tarkista roskapostikansio!';
$lang["mail-sub-booked"] = 'Varauksenne Studio 123 Järvenpää';
$lang["mail-sub-cancel"] = 'Varauksen peruutus Studio 123 Järvenpää';
$lang["mail-sub-gotmoney"] = 'Maksun hyväksyntä';
$lang["mail-sub-heywakeup"] = 'Muistutus Studio 123 Järvenpää';
$lang["mail-sub-remail"] = 'Varauksen tiedot Studio 123 Järvenpää';
$lang["make_default"] = 'Tee tästä valittu näytös.  Vain yksi näytös voi olla valittu kerrallaan.';
$lang['make_payment'] = 'Suorita maksu';
$lang["max_seats"] = 'Maksimi määrä paikkoja jotka voidaan varata yhdellä kerralla';
$lang["minute"] = 'm'; // abbreviated
$lang["minutes"] = 'minuuttia';
$lang["months"] = array(1=>"Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kesäkuu","Heinäkuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu");

$lang["name"] = 'Nimi';
$lang["new_spectacle"] = 'Luodaan uusi elokuva';
$lang["ninvite"] = 'Kutsut';
// following written on tickets for non-numbered seats.
$lang["nnseat"] = 'Normaali hintainen paikka';
$lang["nnseat-avail"] = 'Yksi %1$s paikka vapaana. <br>Kirjoita 1 (yksi) tähän jos haluat varata sen: ';
$lang["nnseat-header"] = 'Normaali hintaiset liput';
$lang["nnseats-avail"] = '%1$s %2$s paikkaa vapaana. <br>Kirjoita tähän monta haluat varata: ';
$lang["nocancellations"] = 'Ei automaattista peruutusta';
$lang["noimage"] = 'Ei kuvaa';
$lang["none"] = 'tyhjä'; // § NEW in 1.2.2
$lang["noreminders"] = 'Ei muistutuksia lähetetty';
$lang["notes"] = 'Merkinnät';
$lang["notes-changed"] = 'Merkintöjä muutettu yhdelle varaukselle';
$lang["notes-changed-p"] = 'Merkintöjä muutettu %1$d een varaukseen';
$lang["nreduced"] = 'Alennettuun hintaan';

$lang["orderby"] = 'Järjestys: %1$s';

$lang["panic"] = <<<EOD
<h2>EMME SAANEET VARAUSTANNE</h2>
<p class='main'>Järjestelmän ylläpitäjälle on ilmoitettu ja ongelma korjataan
mahdollisimman pian.</p>

<p class='main'>Palatkaa sivulle muutaman tunnin päästä ja koittakaa uudelleen.</p>

<p class='main'>Pahoittelemme häiriötä, kiitos kärsivällisyydestänne.</p>
EOD;

$lang["params"] = 'Muokkaa %1$sjärjestelmän asetuksia%2$s';
$lang["pay_cash"] = 'Ei';
$lang["pay_ccard"] = 'luottokortilla';
$lang["pay_other"] = 'Kyllä';
$lang["pay_postal"] = 'postimaksulla';
$lang["payinfo_cash"] = <<<EOD
<br /><strong>Liput elokuviin tulisi lunastaa viimeistään 30 minuuttia ennen näytöksen alkua.</strong><br />
<u>Oopperoihin ja baletteihin liput tulisi lunastaa 2 päivää ennen näytöstä väliaikatarjoilun vuoksi.</u><br />

EOD;
$lang["payinfo_ccard"] = <<<EOD
Emme ole saaneet maksusta vahvistusta. Jos emme saa
vahvistusta %1\$d päivän sisällä, joudumme peruuttamaan ne.

EOD;
//'
$lang["payinfo_postal"] = <<<EOD
Liput täytyy maksaa %1\$s
%2\$d ennen, muuten joudumme peruuttamaan ne.

EOD;
//'

$lang["paybutton"] = 'Painakaa seuraavaa nappia suorittaaksenne maksun :&nbsp;%1$sContinue%2$s';
$lang["payment"] = 'Maksu:';
$lang['payment_received'] = 'Maksunne on vastaanotettu. Kiitos!';
$lang['paypal_id'] = 'PayPal Transaction ID: ';
$lang['paypal_lastchance'] = "Olemme valmiit vastaanottamaan maksunne. Kun painatte allaolevasta napista, lipputietosi välitetään PayPalin sivuille. Kun maksu on suoritettu, selaimesi siirtyy takaisin tälle sivustolle ja maksusi tallennetaan. Luottokortti tiedot siirtyvät vain PayPalille.";
$lang["paypal_purchase"] = 'Paypal lippu ostos';
$lang["phone"] = 'Puh.';
$lang['please_wait'] = 'Suoritetaan maksua . . .  Odota hetki';
$lang["postal tax"] = 'Postimaksu';
$lang["postalcode"] = 'Postinumero';
$lang["poweredby"] = '%1$s';
$lang["price"] = 'Hinta';
$lang["price_discount"] = 'Alennettu hinta ';
$lang['prices']  = 'Lippujen hinnat';
$lang["print_entries"] = '%1$sTulosta%2$s valitut';

$lang["rebook"] = 'Tee uusi varaus valittujen pohjalta %1$sAloita varaus%2$s';
$lang["rebook-info"] = 'Uudelleen aktivoidaksesi poistetut varaukset, valitse ensin "Poistetut" suodatin tämän sivun vasemmasta ylälaidasta';
$lang["reduction_or_charges"] = 'Lisämaksut';
$lang["remail"] = 'Katosiko lippusi? Löydät ne seuraavasta linkistä: %1$sLippujen nouto%2$s';
$lang["reminders"] = 'Muistutukset';
$lang["reqd_info"] = <<<EOD
Täytä alla olevat tiedot.
Saat varaustiedot sähköpostitse.
EOD;
$lang["reserved-header"] = 'Salikartta';
$lang["row"] = 'Rivi';

$lang["sameprice"] = 'Hinnat ovat samat kaikissa luokissa';
$lang["save"] = 'Tallenna';
$lang["seat_free"] = 'Vapaa<br>paikka:';
$lang["seat_occupied"] = 'Varattu<br>Paikka:';
$lang["seats"] = 'Paikat';
$lang["seats_booked"] = 'Varatut paikat';
$lang["seeasalist"] = 'Näytä %1$slistana%2$s';
$lang["seeasamap"] = 'Näytä varaukset tähän näytökseen %1$svarauskarttana%2$s';
$lang["select"] = 'Valitse';
$lang["select_payment"] = 'Maksetaanko heti:';
$lang["selected_1"] = '1 paikka valittu';
$lang["selected_n"] = '%1$d paikkaa valittu';
$lang["sentto"] = 'Viesti lähetetty %1$s';
$lang["set_status_to"] = 'Paikat: ';
$lang["show_any"] = 'Kaikki näytökset';
$lang["show_info"] = '%1$s klo %2$s, %3$s'; // date, time, location
$lang["show_name"] = 'Elokuvan nimi';
$lang["show_not_stored"] = 'Muutoksia ei voitu tallentaa. Ottakaa yhteys järjestelmän ylläpitäjään.';
$lang["show_stored"] = 'Muutokset tallennettu.';
$lang["showallspec"] = 'Näytä %1$skaikki%2$s'; // §NEW IN 1.2.2b (that's "%1$s show all %2$s" without the spaces)
$lang["showlist"] = '%1$s näytökset';
$lang["spectacle_name"] = 'Valitse elokuva';
$lang["state"] = 'Tila'; // in the sense of status, not in the sense
			  // of a country's part
$lang["st_any"] = 'Kaikki';
$lang["st_booked"] = 'Varatut';
$lang["st_deleted"] = 'Poistetut';
$lang["st_disabled"] = 'Suljetut';
$lang["st_free"] = 'Vapaa';
$lang["st_locked"] = 'Lukittu';
$lang["st_notdeleted"] = 'Ei poistetut';
$lang["st_paid"] = 'Maksetut';
$lang["st_shaken"] = 'Muistutus lähetetty';
$lang["st_tobepaid"] = 'Varatut';
$lang["stage"] = 'Valkokangas';
$lang["summary"] = 'Tiedot';

$lang["thankyou"] = 'Kiitos';
$lang["theatre_name"] = 'Salin nimi';
$lang["time"] = 'Klo';
$lang["time_title"] = 'Klo<br>(hh:mm)';
$lang["timestamp"] = 'Varattu';
$lang["title_mconfirm"] = 'Vahvista elokuvan tiedot';
$lang["title_maint"] = 'Lisää tai muokkaa näytöksiä';
$lang["to"] = '-'; // in a temporal sense : from a to b
$lang["total"] = 'Kokonaishinta';

$lang["update"] = 'Päivitä';
$lang['us_state'] = 'Osavaltio (Vain Pohjois-Amerikka)';

$lang["warn_badlogin"] = 'Laiton yhteys yritys';
$lang["warn_bookings"] = 'Huom: Aiot muuttaa näytöksen päivämäärää, aikaa tai hintaa johon on jo myyty lippuja. Sinun tulisi ilmoittaa varausten tehneille muutoksista. Jos muutatte lipun hintoja, lippuja on jo saatettu myydä eri hinnoilla.';
$lang["warn_close_in_1"] = 'Varoitus: netti lipunvaraus tähän näytökseen sulkeutuu yhden minuutin kuluttua.';
$lang["warn_close_in_n"] = 'Varoitus: netti lipunvaraus tähän näytökseen sulkeutuu %1$d minuutissa';
$lang["warn-nocontact"] = 'Varoitus: Ette ole täyttäneet yhteystietoja ; Emme voi ottaa teihin yhteyttä jos varauksessanne ilmenee ongelmia.';
$lang["warn-nomail"] = 'Varoitus: Ette ole antaneet sähköpostiosoitetta ; Jos ette täytä sähköpostiosoitetta, ette saa tietoja varauksestanne sähköpostitse.';
$lang["warn-nomatch"] = 'Ei varauksia'; // no matching bookings
$lang["warn-nonsensicalcat"] = 'Varoitus: olette pyytäneet varaamanne paikkamäärän ylittävän määrän alennettuja lippuja';
$lang["warn-nonsensicalcat-admin"] = 'Varoitus: Valittu paikkojen määrä on pienempi kuin kutsujen ja alennettujen lippujen määrä yhteensä.';
$lang['warn_paypal_confirm'] = 'Emme voineet vahvistaa PayPal maksuanne. Ottakaa yhteys kassalle varmistaaksesi maksunne.';
$lang['warn_process_payment'] = 'Maksunne käsittelyssä tapahtui virhe. Ottakaa yhteys kassalle varmistaaksesi maksunne.';
$lang["warn_show_confirm"] = 'Varmistakaa että ylläolevat tiedot ovat oikein. Jos haluat tehdä muutoksia, paina Muokkaa painiketta. Kun olet valmis, paina Tallenna.';
$lang["warn_spectacle"] = 'Muista, että salikarttoja ei voi muuttaa näytösten luonnin jälkeen.';
$lang["we_accept"] = "Hyväksymme"; // credit card logos come after that
$lang["weekdays"] = array("SU","MA","TI","KE","TO","PE","LA");
$lang["workingdays"] = 'arkipäivää';

$lang["youare"] = 'Henkilötiedot:';
$lang["entrance"] = 'Sisään';

$lang["zoneextra"] = ''; // intentionally left blank

/** add "at the" before the given noun. This is used with theatre
names (We have a problem in case we need to know if $w is masculine or
feminine or whatever - so far everything has been masculine so won't
extend the function until need appears :-) **/
function lang_at_the($w) {
  return "$w";
}

?>
