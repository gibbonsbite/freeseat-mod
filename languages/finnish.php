<?php

/** Finnish language file.
*/

require_once (FS_PATH . "languages/default.php");

$lang["_encoding"] = "ISO-8859-1";


$lang["access_denied"] = 'P��sy kielletty - Istuntosi on vanhentunut';
$lang["acknowledge"] = 'Hyv�ksy'; // used with check_st_update
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
$lang["change_date"] = 'Muuta n�yt�st�';
$lang["change_pay"] = 'Muuta %1$syhteystietoja%2$s';
$lang["change_seats"] = 'Muuta %1$spaikkaa%2$s';
$lang["check_st_update"] = 'Tarkista ett� alla oleva lista varauksista on oikein ja paina Varmista';
$lang["choose_show"] = 'Valitse esitys';
$lang["city"] = 'Kaupunki';
$lang["comment"] = 'Merkinn�t';
$lang["confirmation"] = 'Varmista';
$lang["continue"] = 'Jatka';
$lang["country"] = 'Maa';
$lang["class"] = 'Tyyppi';
$lang["closed"] = 'Suljettu';
$lang["col"] = 'Paikka';
$lang["create_show"] = 'Uusi elokuva';

$lang["date"] = 'Pvm';
$lang['datesandtimes'] = 'N�yt�kset';
$lang["date_title"] = 'Pvm<br>(dd.mm.yyyy)';
$lang["day"] = 'pv.'; // abbreviated
$lang["days"] = 'p�iv�t';
$lang["DELETE"] = 'Poista'; // used in check_st_update
$lang["description"] = 'Kuvaus';
$lang["diffprice"] = '<strong><img src="images/handicap.jpg"> paikat ovat py�r�tuolipaikkoja eik� niiss� ole istumapaikkaa</strong>';
$lang["disabled"] = "Suljettu"; // for shows or payment methods
$lang["dump_csv"] = 'Tietokanta CSV-muodossa: %1$sbookings.csv%2$s';

$lang['editshows'] = '%1$sMuokkaa%2$s tietoja tai n�yt�ksi�';
$lang["email"] = 'S�hk�postiosoite';
$lang["err_bademail"] = 'S�hk�postiosoite ei ole hyv�ksytyss� muodossa';
$lang["err_badip"] = 'Sinulla ei ole p��syoikeuksia t�h�n tiedostoon';
$lang["err_badkey"] = 'P��syavain on v��r�. Yrit� uudelleen. (L�het� s�hk�postia %1$s jos et hallinnoi)';
$lang["err_bookings"] = 'Virhe varausten luvussa';
$lang["err_ccard_cfg"] = 'Luottokorttimaksut pit�� asettaa config.phpssa ennen kuin ne voidaan ottaa k�ytt��n'; // � NEW in 1.2.1
$lang["err_ccard_insuff"] = 'Ei voida maksaa paikkaa %1$d joka maksaa %4$s %2$d kun vain %4$s %3$d vapaana!';
$lang["err_ccard_mysql"] = '(Mysql) virhe luottokorttisiirtoa kirjatessa';
$lang["err_ccard_nomatch"] = 'push (%1$s) and pull (%2$s) do not match (using pull amount)';
$lang["err_ccard_pay"] = 'Ei voida tallentaa luottokorttimaksua paikalle %1$d ! (tarkista lokit - paikka on mahdollisesti jo maksettu)';
$lang["err_ccard_repay"] = 'Hyv�ksytty luottokorttimaksu saapunut paikalle %1$d joka on jo maksettu !';
$lang["err_ccard_toomuch"] = 'Maksu liian suuri! %3$s %1$d k�ytt�m�tt� %3$s %2$d :st�.';
$lang["err_ccard_user"] = 'Maksussa oli ongelma - voit yritt�� uudelleen, tai l�hett�� s�hk�postia %1$s';
$lang["err_checkseats"] = 'Valitse paikat';
$lang["err_closed"] = 'Pahoittelumme, nettivaraus t�h�n n�yt�kseen on sulkeutunut.';
$lang["err_config"] = 'Check server configuration on: '; // � NEW
$lang["err_connect"] = 'Yhteysvirhe : ';
$lang["err_cronusage"] = "One argument expected (database booking system password)\n";
$lang["err_email"] = 'Kaikilla valituilla varauksilla ei ole sama s�hk�postiosoite (pidet��n ensimm�inen)';
$lang["err_filetype"] = 'Wrong file type, was expecting: ';
$lang["err_ic_firstname"] =    'Kaikilla valituilla varauksilla ei ole sama etunimi (pidet��n ensimm�inen)';
$lang["err_ic_lastname"] =    'Kaikilla valituilla varauksilla ei ole sama sukunimi (pidet��n ensimm�inen)';
$lang["err_ic_payment"] = 'Kaikilla valituilla varauksilla ei ole sama maksutapa (pidet��n ensimm�inen)';
$lang["err_ic_phone"] =   'Kaikilla valituilla varauksilla ei ole sama puh. nro (pidet��n ensimm�inen)';
$lang["err_ic_showid"] =  'Kaikki valitut varaukset eiv�t ole samaan n�yt�kseen...';
$lang["err_noaddress"] = 'Luottokorttimaksua k�ytt�ess� t�ytyy t�ytt�� v�hint��n s�hk�postiosoite, l�hiosoite, postinumero sek� postitoimipaikka.';
$lang["err_noavailspec"] = 'Ei elokuvia'; // � NEW IN 1.2.2b
$lang["err_nodates"] = 'Elokuvaan ei l�ytynyt n�yt�ksi�.';
$lang["err_noname"] = 'T�yt� etunimi, sukunimi ja s�hk�postiosoite.';
$lang["err_noprices"] = 'T�h�n n�yt�kseen ei ole m��ritelty hintaa.';
$lang["err_noseats"] = 'Ei paikkoja'; // � NEW
$lang["err_nospec"] = 'T�yt� elokuvan nimi.';
$lang["err_notheatre"] = 'Valitse sali.';
$lang["err_occupied"] = 'Pahoittelumme, joku valitsemistanne paikoista on juuri varattu.';
$lang["err_paymentclosed"] = 'Maksu %1$s on juuri suljettu t�h�n esitykseen';
$lang["err_payreminddelay"] = 'Payment delay must be longer than remind delay';
$lang["err_postaltax"] = 'Hinta on liian korkea postimaksulle';
$lang["err_price"] = 'Paikan hintaa ei l�ytynyt';
$lang["err_pw"] = 'V��r� k�ytt�j� tai salasana. Yrit� uudelleen.';
$lang["err_scriptauth"] = 'Request to script %1$s rejected';
$lang["err_scriptconnect"] = 'Connecting to the %1$s script failed';
$lang["err_seat"] = 'Virhe paikan haussa';
$lang["err_seatcount"] = 'Et voi varata n�in montaa paikkaa kerralla';
$lang["err_seatlocks"] = 'Virhe lukitessa paikkaa';
$lang["err_session"] = 'Sinulla ei ole varausistuntoa (Ovatko ev�steet p��ll� selaimessasi?)';
$lang["err_setbookstatus"] = 'Virhe muuttaessa paikan tilaa';
$lang["err_shellonly"] = 'P��SY KIELLETTY - P��sy t�lle sivulle vaatii shell tunnuksia';
$lang["err_show_entry"] = 'T�t� n�yt�st� ei voida tallentaa ennen kuin t�ydenn�t puuttuvat tiedot.';
$lang["err_showid"] = 'V��r� n�yt�ksen tunnus';
$lang["err_smtp"] = 'Varoitus: viestin l�hetys ep�onnistui: %1$s - Palvelin vastasi: %2$s';
$lang["err_spectacle"] = 'Virhe etsiess� elokuvan tietoja';
$lang["err_spectacleid"] = 'V��r� elokuvan tunnus'; // � NEW
$lang["err_upload"] = 'Virhe l�hett�ess� tiedostoa';
$lang["expiration"] = 'Vanhentuminen';
$lang["expired"] = 'vanhentunut';

$lang["failure"] = 'PANIC';
$lang["file"] = 'Julisteen nimi'; 
$lang["filter"] = 'Tila:'; // filter form header in bookinglist
$lang["firstname"] = 'Etunimi';
$lang["from"] = ''; // in a temporal sense : from a to b

$lang["hello"] = 'Hei %1$s,';
$lang["hideold"] = '%1$sPiilota%2$s vanhat'; // �NEW IN 1.2.2b that's "%1$s hide %2$s" without the spaces
$lang["hour"] = 't'; // abbreviated
/* (note : this is only used for at least two seats) */
$lang["howmanyare"] = 'Montako n�ist� %1$d paikasta ovat';

$lang["id"] = 'Tunnus';
$lang['imagesrc'] = 'Juliste';
$lang["immediately"] = 'heti';
$lang["import"] = 'L�het� t�m� tiedosto';
$lang["in"] = '%1$s:ssa'; // as in "in <ten days>"
$lang["index_head"] = '<img src="/reservation/images/studio123ticketing.jpg" alt="J�rvenp��n Studiot Lipunvaraus">';
$lang["intro_ccard"] = <<<EOD
 <h2>Kiitos varauksestanne</h2>

<p class="main">Paikat ovat nyt varattu nimell�nne</p>
EOD;

$lang["intro_confirm"] = 'Tarkista tiedot ja paina Tee varaus.';
$lang["intro_finish"] = 'T�m� on lippusi. Tulosta se ja tuo mukanasi kassalle.';
$lang["intro_params"] = <<<EOD
<h2>Maksutapojen saatavuus</h2>

<p class="main">
<ul><li><p>
Lis�� t�nne ajat kuinka pitk��n suhteessa n�yt�saikaan eri maksutavat ovat saatavilla.
</p>
<li>
<p>Lis�tt�v�t numerot ovat muodossa <em>minuuttia</em> ennen n�yt�ksen alkua.</p>
<li>
<p>Kassalla maksun aukeamis/sulkemis aika tarkoittaa aikaa jolloin
asiakkaat voivat valita maksun kassalla (ei kassan aukioloaikaa)</p>

<li>
<p>
Postikuljetuksen viiv�stymiset n�ytet��n arkip�iviss�. 
Viikonloput ja juhlapyh�t lis�t��n kuljetus aikaan.
</p>
</ul>
</p>

%1\$s

<h2>Muistutukset ja peruutus</h2>

<p class="main">Riippuen asiakkaan valitsemasta maksutavasta,
kuinka monta <em>p�iv��</em> varauksen j�lkeen t�ytyy l�hett�� muistutus,
tai peruuttaa varaus?</p>

%2\$s

<h2>Muut valinnat</h2>

EOD;
//'

$lang["intro_remail"] = <<<EOD

<h2>Varauksen nouto</h2>

<p class='main'>Kirjoita seuraavaan kentt��n s�hk�postiosoite
jota k�ytit varatessasi ja paina l�het�.<br>
Saat varaukset s�hk�postiisi. Muista tarkistaa roskaposti kansio!</p>

<p class='main'>S�hk�posti: %1\$s</p>

<p class='main'>(jos et antanut varatessasi s�hk�postiosoitetta
tai sinulla ei ole en��n p��sy� siihen, ota yhteys meihin aukioloaikoina puhelimitse tai kassalla)</p>

EOD;

$lang["intro_remail2"] = <<<EOD

<h2>Varauksen nouto</h2>

<p class='main'>Jos s�hk�posti jonka sait sis�lt�� p��sykoodin,
voit nyt kopioida sen seuraavaan kentt��n, jotta voit tulostaa liput:</p>

<p class='main'>(Huom. t�m� ei ole varaustunnus)</p>

<p class='main'>P��sykoodi lippuihin: %1\$s</p>

EOD;

$lang["intro_seats"] = 'Paina "Jatka" sivun alalaidasta kun olet tehnyt valinnat';
$lang["is_default"] = 'T�m� on valittu n�yt�s.';
$lang["is_not_default"] = 'T�m� ei ole valittu n�yt�s.';

$lang["lastname"] = 'Sukunimi';
$lang["legend"] = 'Paikat: ';
$lang["link_bookinglist"] = 'Varauslistaan';
$lang["link_edit"] = 'Muokkaa n�yt�ksi�';
$lang["link_index"] = 'Etusivulle';
$lang["link_showlist"] = 'Ohjelmistoon';
$lang["link_pay"] = 'Varaustiedot';
$lang["link_repr"] = 'N�yt�s lista';
$lang["link_seats"] = 'Paikan valinta';
$lang["login"] = 'Kirjaudu sis��n (vain henkil�kunnalle):';
$lang["logout"] = 'Kirjaudu ulos';

$lang["mail-anon"] = <<<EOD
Hei,

N�m� ovat tietoja henkil�st� joka ei antanut s�hk�postiosoitetta.

Jotta tarvittaessa voitte ottaa heihin yhteyden, t�ss� on tiedot jotka
asiakas antoi varatessaan paikkoja:

EOD;

/* NOTE - Assumes spectacle must be preceded by a (masculine)
 definite article. In the future we will need to integrate the article
 in the spectacle name and alter/extended it when needed (e.g. French
 de+le = du, German von+dem = vom, etc) */
$lang["mail-booked"] = <<<EOD
Hyv� asiakas,<br />
kiitos varauksesta.<br /><br />

Alla varauksenne tiedot:

EOD;

$lang["mail-cancel-however"] = <<<EOD
T�m� on automaattinen viesti. Varauksenne seuraavaan paikkaan on peruttu:
EOD;
$lang["mail-cancel-however-p"] = <<<EOD
T�m� on automaattinen viesti. Varauksenne seuraaviin paikkoihin on peruttu:
EOD;
$lang["mail-cancel"] = <<<EOD
T�m� on automaattinen viesti. Varauksenne seuraavaan paikkaan on peruttu.:
EOD;
$lang["mail-cancel-p"] = <<<EOD
T�m� on automaattinen viesti. Varauksenne seuraaviin paikkoihin on peruttu:
EOD;

$lang["mail-gotmoney"] = 'Olemme saaneet maksunne seuraavasta paikasta:';
$lang["mail-gotmoney-p"] = 'Olemme saaneet maksunne seuraavista paikoista:';

$lang["mail-heywakeup"] = <<<EOD

Emme ole viel� saaneet maksua seuraavasta varaamastanne paikasta:

%1\$s
Jos maksunne saapui juuri, voit poistaa t�m�n viestin.

Jos haluatte sittenkin peruuttaa varauksenne,
kertokaa siit� meille vastaamalla t�h�n s�hk�postiin.
Jos ette vastaa, joudumme peruuttamaan varauksenne.

EOD;

$lang["mail-heywakeup-p"] = <<<EOD


J�rjestelm�mme mukaan, ette ole viel� lunastaneet seuraavia lippuja:

%1\$s
Jos olette jo maksaneet, voitte poistaa t�m�n viestin.

Jos haluatte sittenkin peruuttaa varauksenne,
kertokaa siit� meille t�m� s�hk�posti osoitteeseen peruutukset@studiot123.com
EOD;

$lang["mail-notconfirmed"] = <<<EOD
EOD;

// for one seat
$lang["mail-notdeleted"] = 'Seuraava varaus pidet��n:';
// for more than one seat
$lang["mail-notdeleted-p"] = 'Seuraavat varaukset pidet��n:';
$lang["mail-notpaid"] = 'Seuraava paikka on varattu, mutta emme ole viel� saaneet maksua:';
$lang["mail-notpaid-p"] = 'Seuraavat paikat ovat varattuja, mutta emme ole viel� saaneet maksua:';
$lang["mail-remail"] = <<<EOD
Pyysitte l�hett�� tiedot varauksestanne %1\$s sivustolla, t�ss� on kaikki varauksenne jotka
olette tehneet t�st� s�hk�postiosoitteesta.


P��syavain lippuihin : %2\$s

EOD;

$lang["mail-reminder-p"] = <<<EOD
Muistutus: Seuraavat varaamanne paikat ovat viel� maksamatta:

%1\$s
Jos haluatte peruuttaa t�m�n varauksen, vastatkaa t�h�n s�hk�postiin.

EOD;

$lang["mail-reminder"] = <<<EOD
Muistutus: Seuraava varaamanne paikka on viel� maksamatta:

%1\$s
Jos haluatte peruuttaa t�m�n varauksen, l�hett�k�� t�m� s�hk�posti osoitteeseen peruutukset@studiot123.com

EOD;

$lang["mail-secondmail"] = <<<EOD
Saatte toisen s�hk�postin kun olemme saaneet maksun varauksestanne.

EOD;

$lang["mail-spammer"] = <<<EOD
Hei,

Joku pyysi varaustietoja t�h�n 
osoitteeseen (%3\$s) %1\$s
(%2\$s)

Meill� ei ole yht��n varausta t�st� osoitteesta.
T�m� voi tarkoittaa yht� kolmesta asiasta:

* Teit varauksen, mutta k�ytit toista s�hk�postiosoitetta
* Sinulla oli varaus, mutta se on peruttu. Sinulle pit�isi olla saapunut
 s�hk�posti t�st� kun se tapahtui.
* Joku muu on t�ytt�nyt pyynn�n

Jos sinulla on kysytt�v��, vastaathan t�h�n s�hk�postiin.

EOD;
// following always plural
$lang["mail-summary-p"] = 'Paikat jotka ovat varmistettuja (paitsi vanhoihin n�yt�ksiin) ovat seuraavat:';

$lang["admin-thankee"] = 'Varaus tallennettu.';

$lang["mail-thankee"] = <<<EOD
Liput voitte lunastaa kassaltamme osoitteessa Helsingintie 12, J�rvenp��.<br /><br />
<strong>Esteen sattuessa pyyd�mme yst�v�llisesti peruuttamaan varauksenne soittamalla numeroon (09) 8366770 kassan aukioloaikana
tai l�hett�m�ll� t�m�n s�hk�postin osoitteeseen <a href="mailto:peruutukset@studiot123.com?Subject=Varauksen peruutus" target="_top">peruutukset@studiot123.com</a></strong><br /><br />
EOD;

$lang["mail-oops"] = <<<EOD
Jos uskot t�m�n olevan virhe, vastatkaa t�h�n s�hk�postiin tai soittakaa kassallemme mahdollisimman pian
, jotta voimme palauttaa varauksenne.
EOD;
    //'

$lang["mail-sent"] = 'Sinulle on l�hetetty s�hk�posti varaustiedoillanne. Tarkista roskapostikansio!';
$lang["mail-sub-booked"] = 'Varauksenne Studio 123 J�rvenp��';
$lang["mail-sub-cancel"] = 'Varauksen peruutus Studio 123 J�rvenp��';
$lang["mail-sub-gotmoney"] = 'Maksun hyv�ksynt�';
$lang["mail-sub-heywakeup"] = 'Muistutus Studio 123 J�rvenp��';
$lang["mail-sub-remail"] = 'Varauksen tiedot Studio 123 J�rvenp��';
$lang["make_default"] = 'Tee t�st� valittu n�yt�s.  Vain yksi n�yt�s voi olla valittu kerrallaan.';
$lang['make_payment'] = 'Suorita maksu';
$lang["max_seats"] = 'Maksimi m��r� paikkoja jotka voidaan varata yhdell� kerralla';
$lang["minute"] = 'm'; // abbreviated
$lang["minutes"] = 'minuuttia';
$lang["months"] = array(1=>"Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kes�kuu","Hein�kuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu");

$lang["name"] = 'Nimi';
$lang["new_spectacle"] = 'Luodaan uusi elokuva';
$lang["ninvite"] = 'Kutsut';
// following written on tickets for non-numbered seats.
$lang["nnseat"] = 'Normaali hintainen paikka';
$lang["nnseat-avail"] = 'Yksi %1$s paikka vapaana. <br>Kirjoita 1 (yksi) t�h�n jos haluat varata sen: ';
$lang["nnseat-header"] = 'Normaali hintaiset liput';
$lang["nnseats-avail"] = '%1$s %2$s paikkaa vapaana. <br>Kirjoita t�h�n monta haluat varata: ';
$lang["nocancellations"] = 'Ei automaattista peruutusta';
$lang["noimage"] = 'Ei kuvaa';
$lang["none"] = 'tyhj�'; // � NEW in 1.2.2
$lang["noreminders"] = 'Ei muistutuksia l�hetetty';
$lang["notes"] = 'Merkinn�t';
$lang["notes-changed"] = 'Merkint�j� muutettu yhdelle varaukselle';
$lang["notes-changed-p"] = 'Merkint�j� muutettu %1$d een varaukseen';
$lang["nreduced"] = 'Alennettuun hintaan';

$lang["orderby"] = 'J�rjestys: %1$s';

$lang["panic"] = <<<EOD
<h2>EMME SAANEET VARAUSTANNE</h2>
<p class='main'>J�rjestelm�n yll�pit�j�lle on ilmoitettu ja ongelma korjataan
mahdollisimman pian.</p>

<p class='main'>Palatkaa sivulle muutaman tunnin p��st� ja koittakaa uudelleen.</p>

<p class='main'>Pahoittelemme h�iri�t�, kiitos k�rsiv�llisyydest�nne.</p>
EOD;

$lang["params"] = 'Muokkaa %1$sj�rjestelm�n asetuksia%2$s';
$lang["pay_cash"] = 'Ei';
$lang["pay_ccard"] = 'luottokortilla';
$lang["pay_other"] = 'Kyll�';
$lang["pay_postal"] = 'postimaksulla';
$lang["payinfo_cash"] = <<<EOD
<br /><strong>Liput elokuviin tulisi lunastaa viimeist��n 30 minuuttia ennen n�yt�ksen alkua.</strong><br />
<u>Oopperoihin ja baletteihin liput tulisi lunastaa 2 p�iv�� ennen n�yt�st� v�liaikatarjoilun vuoksi.</u><br />

EOD;
$lang["payinfo_ccard"] = <<<EOD
Emme ole saaneet maksusta vahvistusta. Jos emme saa
vahvistusta %1\$d p�iv�n sis�ll�, joudumme peruuttamaan ne.

EOD;
//'
$lang["payinfo_postal"] = <<<EOD
Liput t�ytyy maksaa %1\$s
%2\$d ennen, muuten joudumme peruuttamaan ne.

EOD;
//'

$lang["paybutton"] = 'Painakaa seuraavaa nappia suorittaaksenne maksun :&nbsp;%1$sContinue%2$s';
$lang["payment"] = 'Maksu:';
$lang['payment_received'] = 'Maksunne on vastaanotettu. Kiitos!';
$lang['paypal_id'] = 'PayPal Transaction ID: ';
$lang['paypal_lastchance'] = "Olemme valmiit vastaanottamaan maksunne. Kun painatte allaolevasta napista, lipputietosi v�litet��n PayPalin sivuille. Kun maksu on suoritettu, selaimesi siirtyy takaisin t�lle sivustolle ja maksusi tallennetaan. Luottokortti tiedot siirtyv�t vain PayPalille.";
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
$lang["rebook-info"] = 'Uudelleen aktivoidaksesi poistetut varaukset, valitse ensin "Poistetut" suodatin t�m�n sivun vasemmasta yl�laidasta';
$lang["reduction_or_charges"] = 'Lis�maksut';
$lang["remail"] = 'Katosiko lippusi? L�yd�t ne seuraavasta linkist�: %1$sLippujen nouto%2$s';
$lang["reminders"] = 'Muistutukset';
$lang["reqd_info"] = <<<EOD
T�yt� alla olevat tiedot.
Saat varaustiedot s�hk�postitse.
EOD;
$lang["reserved-header"] = 'Salikartta';
$lang["row"] = 'Rivi';

$lang["sameprice"] = 'Hinnat ovat samat kaikissa luokissa';
$lang["save"] = 'Tallenna';
$lang["seat_free"] = 'Vapaa<br>paikka:';
$lang["seat_occupied"] = 'Varattu<br>Paikka:';
$lang["seats"] = 'Paikat';
$lang["seats_booked"] = 'Varatut paikat';
$lang["seeasalist"] = 'N�yt� %1$slistana%2$s';
$lang["seeasamap"] = 'N�yt� varaukset t�h�n n�yt�kseen %1$svarauskarttana%2$s';
$lang["select"] = 'Valitse';
$lang["select_payment"] = 'Maksetaanko heti:';
$lang["selected_1"] = '1 paikka valittu';
$lang["selected_n"] = '%1$d paikkaa valittu';
$lang["sentto"] = 'Viesti l�hetetty %1$s';
$lang["set_status_to"] = 'Paikat: ';
$lang["show_any"] = 'Kaikki n�yt�kset';
$lang["show_info"] = '%1$s klo %2$s, %3$s'; // date, time, location
$lang["show_name"] = 'Elokuvan nimi';
$lang["show_not_stored"] = 'Muutoksia ei voitu tallentaa. Ottakaa yhteys j�rjestelm�n yll�pit�j��n.';
$lang["show_stored"] = 'Muutokset tallennettu.';
$lang["showallspec"] = 'N�yt� %1$skaikki%2$s'; // �NEW IN 1.2.2b (that's "%1$s show all %2$s" without the spaces)
$lang["showlist"] = '%1$s n�yt�kset';
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
$lang["st_shaken"] = 'Muistutus l�hetetty';
$lang["st_tobepaid"] = 'Varatut';
$lang["stage"] = 'Valkokangas';
$lang["summary"] = 'Tiedot';

$lang["thankyou"] = 'Kiitos';
$lang["theatre_name"] = 'Salin nimi';
$lang["time"] = 'Klo';
$lang["time_title"] = 'Klo<br>(hh:mm)';
$lang["timestamp"] = 'Varattu';
$lang["title_mconfirm"] = 'Vahvista elokuvan tiedot';
$lang["title_maint"] = 'Lis�� tai muokkaa n�yt�ksi�';
$lang["to"] = '-'; // in a temporal sense : from a to b
$lang["total"] = 'Kokonaishinta';

$lang["update"] = 'P�ivit�';
$lang['us_state'] = 'Osavaltio (Vain Pohjois-Amerikka)';

$lang["warn_badlogin"] = 'Laiton yhteys yritys';
$lang["warn_bookings"] = 'Huom: Aiot muuttaa n�yt�ksen p�iv�m��r��, aikaa tai hintaa johon on jo myyty lippuja. Sinun tulisi ilmoittaa varausten tehneille muutoksista. Jos muutatte lipun hintoja, lippuja on jo saatettu myyd� eri hinnoilla.';
$lang["warn_close_in_1"] = 'Varoitus: netti lipunvaraus t�h�n n�yt�kseen sulkeutuu yhden minuutin kuluttua.';
$lang["warn_close_in_n"] = 'Varoitus: netti lipunvaraus t�h�n n�yt�kseen sulkeutuu %1$d minuutissa';
$lang["warn-nocontact"] = 'Varoitus: Ette ole t�ytt�neet yhteystietoja ; Emme voi ottaa teihin yhteytt� jos varauksessanne ilmenee ongelmia.';
$lang["warn-nomail"] = 'Varoitus: Ette ole antaneet s�hk�postiosoitetta ; Jos ette t�yt� s�hk�postiosoitetta, ette saa tietoja varauksestanne s�hk�postitse.';
$lang["warn-nomatch"] = 'Ei varauksia'; // no matching bookings
$lang["warn-nonsensicalcat"] = 'Varoitus: olette pyyt�neet varaamanne paikkam��r�n ylitt�v�n m��r�n alennettuja lippuja';
$lang["warn-nonsensicalcat-admin"] = 'Varoitus: Valittu paikkojen m��r� on pienempi kuin kutsujen ja alennettujen lippujen m��r� yhteens�.';
$lang['warn_paypal_confirm'] = 'Emme voineet vahvistaa PayPal maksuanne. Ottakaa yhteys kassalle varmistaaksesi maksunne.';
$lang['warn_process_payment'] = 'Maksunne k�sittelyss� tapahtui virhe. Ottakaa yhteys kassalle varmistaaksesi maksunne.';
$lang["warn_show_confirm"] = 'Varmistakaa ett� yll�olevat tiedot ovat oikein. Jos haluat tehd� muutoksia, paina Muokkaa painiketta. Kun olet valmis, paina Tallenna.';
$lang["warn_spectacle"] = 'Muista, ett� salikarttoja ei voi muuttaa n�yt�sten luonnin j�lkeen.';
$lang["we_accept"] = "Hyv�ksymme"; // credit card logos come after that
$lang["weekdays"] = array("SU","MA","TI","KE","TO","PE","LA");
$lang["workingdays"] = 'arkip�iv��';

$lang["youare"] = 'Henkil�tiedot:';
$lang["entrance"] = 'Sis��n';

$lang["zoneextra"] = ''; // intentionally left blank

/** add "at the" before the given noun. This is used with theatre
names (We have a problem in case we need to know if $w is masculine or
feminine or whatever - so far everything has been masculine so won't
extend the function until need appears :-) **/
function lang_at_the($w) {
  return "$w";
}

?>
