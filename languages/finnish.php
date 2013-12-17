<?php

/** Finnish language file.
*/

require_once (FS_PATH . "languages/default.php");

$lang["_encoding"] = "ISO-8859-1";


$lang["access_denied"] = 'Pääsy kielletty - Istuntosi on vanhentunut';
$lang["acknowledge"] = 'Tunnustettu'; // used with check_st_update
$lang["address"] = 'Osoite';
$lang["admin"] = 'Hallinta toiminnot';
$lang["admin_buy"] = 'Varaa ja %1$sosta%2$s lippuja';
$lang["alert"] = 'VAROITUS';
$lang["are-you-ready"] = 'Varmista varauksesi tiedot ja paina Jatka.';

$lang["backto"] = 'Takaisin %1$s';
$lang["book"] = 'Varaa';
$lang["bookagain"] = 'Tee %1$sToinen varaus%2$s';
$lang["bookid"] = 'Koodi';
$lang["book_adminonly"] = 'Varaus suljettu';
$lang["book_submit"] = 'Tee varaus';
$lang["booking_st"] = 'Varaukset tilassa %1$s';
$lang["bookinglist"] = 'Selaa/Muokkaa %1$sbookings%2$s (esim. maksun hyväksymiseen)';
$lang["bookingmap"] = 'Varauskartta';
$lang["buy"] = 'Varaa ja %1$sosta%2$s lippuja';

$lang["cancel"] = "Peruuta";
$lang["cancellations"] = "Peruutukset";
$lang["cat"] = 'Hinta';
$lang["cat_free"] = 'Ilmainen';
$lang["cat_normal"] = 'Normaali ';
$lang["cat_reduced"] = 'Alennus ';
$lang["ccard_failed"] = '%1$s WHILE PROCESSING A CREDIT CARD NOTIFICATION\n\n\n';
$lang["ccard_partner"] = 'Credit card payment made secure by&nbsp;%1$s';
$lang["change_date"] = 'Muuta päivämäärää';
$lang["change_pay"] = 'Muuta %1$sHenkilö ja maksutietoja%2$s';
$lang["change_seats"] = 'Muuta %1$sPaikan valintaa%2$s';
$lang["check_st_update"] = 'Varmista että allaoleva lista varauksista jotka %1$s on oikein ja paina Varmista tämän sivun alalaidasta';
$lang["choose_show"] = 'Valitse esitys';
$lang["city"] = 'Kaupunki';
$lang["comment"] = 'Kommentti';
$lang["confirmation"] = 'Varmistus';
$lang["continue"] = 'Jatka';
$lang["country"] = 'Maa';
$lang["class"] = 'Tyyppi';
$lang["closed"] = 'Suljettu';
$lang["col"] = 'Paikka';
$lang["create_show"] = 'Luo uusi esitys';

$lang["date"] = 'Pvm';
$lang['datesandtimes'] = 'Näytä päivät';
$lang["date_title"] = 'Pvm<br>(dd.mm.yyyy)';
$lang["day"] = 'pv.'; // abbreviated
$lang["days"] = 'päivät';
$lang["DELETE"] = 'Poistettu'; // used in check_st_update
$lang["description"] = 'Kuvaus';
$lang["diffprice"] = 'Hinnat ovat värikoodattu alla olevan listan mukaisesti';
$lang["disabled"] = "Ei käytössä"; // for shows or payment methods
$lang["dump_csv"] = 'Tietokanta CSV-muodossa: %1$sbookings.csv%2$s';

$lang['editshows'] = 'Lisää tai muokkaa %1$sshow%2$s tietoja';
$lang["email"] = 'Email';
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
$lang["err_closed"] = 'Pahoittelumme, nettivaraus tähän näytökseen on juuri sulkeutunut';
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
$lang["err_noname"] = 'Täytä vähintään etu ja sukunimi';
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
$lang["file"] = 'Tiedosto: '; 
$lang["filter"] = 'Näytös:'; // filter form header in bookinglist
$lang["firstname"] = 'Etunimi';
$lang["from"] = ''; // in a temporal sense : from a to b

$lang["hello"] = 'Hei %1$s,';
$lang["hideold"] = '%1$sPiilota%2$s vanhat elokuvat.'; // §NEW IN 1.2.2b that's "%1$s hide %2$s" without the spaces
$lang["hour"] = 't'; // abbreviated
/* (note : this is only used for at least two seats) */
$lang["howmanyare"] = 'Montako näistä %1$d paikasta ovat';

$lang["id"] = 'Tunnus';
$lang['imagesrc'] = 'Kuvan sijainti';
$lang["immediately"] = 'heti';
$lang["import"] = 'Lähetä tämä tiedosto';
$lang["in"] = '%1$s:ssa'; // as in "in <ten days>"
$lang["index_head"] = 'Netti lipunvaraus';
$lang["intro_ccard"] = <<<EOD
 <h2>Kiitos varauksestanne</h2>

<p class="main">Paikat ovat nyt varattu nimellänne</p>
EOD;

$lang["intro_confirm"] = 'Tarkista ja tee tarpeelliset muutokset ennen varauksen varmistamista';
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
<p>Opening/Closing payment at the counter means here the time during
which customers may request to pay at the counter (and not the opening
hours of the counter itself)</p>

<li>
<p>
Delays about postal transfer are seen in working days only. If a delay
falls in a working day then the specified interval is implicitly
increased of 24h times the number of holidays.
</p>
</ul>
</p>

%1\$s

<h2>Reminders and cancellation</h2>

<p class="main">Depending the payment method request by the client,
how many <em>days</em> after the booking do I have to send a reminder,
and cancel the booking?</p>

%2\$s

<h2>Other parameters</h2>

EOD;
//'

$lang["intro_remail"] = <<<EOD

<h2>Reservation retrieval</h2>

<p class='main'>Please type in the following field the email address
you used when making your booking, then submit.<br>
You will then receive an email containing all details about your
bookings</p>

<p class='main'>Email address: %1\$s</p>

<p class='main'>(If you had not given an email address, or if you no
longer have access to it, please contact us directly.)</p>

EOD;

$lang["intro_remail2"] = <<<EOD

<h2>Reservation retrieval</h2>

<p class='main'>In case the e-mail you received contains an access key
to your tickets, you may now copy it in the following field, to be
able to print them:</p>

<p class='main'>(Note, it is not the reservation code)</p>

<p class='main'>Access key to your tickets: %1\$s</p>

EOD;

$lang["intro_seats"] = 'Click on "Continue" at the bottom of this page once you made your choices';
$lang["is_default"] = 'This is the active show.';
$lang["is_not_default"] = 'This is not the active show.';

$lang["lastname"] = 'Last name';
$lang["legend"] = 'Legend: ';
$lang["link_bookinglist"] = 'Booking list';
$lang["link_edit"] = 'Edit Shows';
$lang["link_index"] = 'Welcome page';
$lang["link_pay"] = 'Personal information';
$lang["link_repr"] = 'Show list';
$lang["link_seats"] = 'Seat selection';
$lang["login"] = 'System Administration (For authorised persons only):';
$lang["logout"] = 'Log Out';

$lang["mail-anon"] = <<<EOD
Hello,

This is information concerning someone who did not provide an e-mail
address.

So that (if needed) you may contact them, here are the information I
have been given during the booking:

EOD;

/* NOTE - Assumes spectacle must be preceded by a (masculine)
 definite article. In the future we will need to integrate the article
 in the spectacle name and alter/extended it when needed (e.g. French
 de+le = du, German von+dem = vom, etc) */
$lang["mail-booked"] = <<<EOD
Thank you for your reservation for the %1\$s

Here are again the details of your reservation, that you will have to
show at the entrance of the show.

EOD;

$lang["mail-cancel-however"] = <<<EOD
We however inform you that your booking for the following seat has
been cancelled:
EOD;
$lang["mail-cancel-however-p"] = <<<EOD
We however inform you that your booking for the following seats has
been cancelled:
EOD;
$lang["mail-cancel"] = <<<EOD
This is to inform you that your booking for the following seat has
been cancelled:
EOD;
$lang["mail-cancel-p"] = <<<EOD
This is to inform you that your booking for the following seats has
been cancelled:
EOD;

$lang["mail-gotmoney"] = 'We have received your payment for the following seat:';
$lang["mail-gotmoney-p"] = 'We have received your payment for the following seats:';

$lang["mail-heywakeup"] = <<<EOD

We still have not received the payment for your booking of the
following seat:

%1\$s
In case your payment crossed this message, you may ignore it.

If however you would like to cancel your booking we would be thankful
for you to tell it us replying to this email. Without news from your
side in the following days we will cancel your booking.

EOD;

$lang["mail-heywakeup-p"] = <<<EOD


According to our records, we still have not received the payment for 
your reservation of the following seats:

%1\$s
If you have already made your payment, you may ignore this message.

If on the other hand you would like to cancel your reservation, please 
let us know by replying to this email. Unless we hear from you soon, 
your reservation will be cancelled.
EOD;

$lang["mail-notconfirmed"] = <<<EOD
Your reservation has not yet been confirmed ; Tickets grant access to
the seats only after the payment has been received.
EOD;

// for one seat
$lang["mail-notdeleted"] = 'The following seat booking is maintained:';
// for more than one seat
$lang["mail-notdeleted-p"] = 'The following seat booking is maintained:';
$lang["mail-notpaid"] = 'The following seat is booked but we have not yet received the payment:';
$lang["mail-notpaid-p"] = 'The following seats are booked but we have not yet received the payment:';
$lang["mail-remail"] = <<<EOD
In return to your request on the %1\$s website, here is a summary of
all bookings you have made so far, at this email address.


Access key to your tickets : %2\$s

EOD;

$lang["mail-reminder-p"] = <<<EOD
We additionally remind you that the following seats must still be paid:

%1\$s
If you would like to cancel them, we would be thankful for you to tell
us replying to this email.

EOD;

$lang["mail-reminder"] = <<<EOD
We additionally remind you that the following seat must still be paid:

%1\$s
If you would like to cancel it, we would be thankful for you to tell
us replying to this email.

EOD;

$lang["mail-secondmail"] = <<<EOD
You will receive a second
mail once we receive your payment.

EOD;

$lang["mail-spammer"] = <<<EOD
Hello,

Someone (maybe you) requested to have a summary bookings made at this
address (%3\$s) on %1\$s
(%2\$s) to be sent to you.

We however do not have any reservation made from this address. It
could mean one of three things.

* You did make a booking, but using another e-mail address.
* You had a seat booked but it was cancelled. You should have received
another e-mail at the time it has been done.
* Some joker is trying to fill your e-mail box, thinking he can remain
anonymous.

If you have any question please let us know, replying to this e-mail.

EOD;
// following always plural
$lang["mail-summary-p"] = 'Seats that are presently confirmed (excluding past shows) are the following:';

$lang["mail-thankee"] = <<<EOD
We are thankful for your booking and hope you will enjoy the show.

EOD;

$lang["mail-oops"] = <<<EOD
If you believe this is a mistake, please reply to this mail as quickly
as possible, so that we may reactivate your booking.
EOD;
    //'

$lang["mail-sent"] = 'An e-mail has just been sent to you, and contains the same information as this page';
$lang["mail-sub-booked"] = 'Your booking';
$lang["mail-sub-cancel"] = 'Booking cancellation';
$lang["mail-sub-gotmoney"] = 'Payment acknowledgement';
$lang["mail-sub-heywakeup"] = 'Reminder';
$lang["mail-sub-remail"] = 'Booking summary';
$lang["make_default"] = 'Make this the active show.  Only one show can be active at a time.';
$lang['make_payment'] = 'Make Your Payment';
$lang["max_seats"] = 'Maximum number of seats that can be booked in one session';
$lang["minute"] = 'm'; // abbreviated
$lang["minutes"] = 'minutes';
$lang["months"] = array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");

$lang["name"] = 'Name';
$lang["new_spectacle"] = 'Creating a New Show Definition';
$lang["ninvite"] = 'Invitations';
// following written on tickets for non-numbered seats.
$lang["nnseat"] = 'General admission seat';
$lang["nnseat-avail"] = 'There is one %1$s seat available. <br>Type 1 (one) here if you want to book it: ';
$lang["nnseat-header"] = 'General Admission Tickets';
$lang["nnseats-avail"] = 'There are %1$s %2$s seats available. <br>Enter here how many you want to book: ';
$lang["nocancellations"] = 'No automatic cancellation';
$lang["noimage"] = 'No image file';
$lang["none"] = 'none'; // § NEW in 1.2.2
$lang["noreminders"] = 'No reminders sent';
$lang["notes"] = 'Notes';
$lang["notes-changed"] = 'Notes changed for 1 reservation';
$lang["notes-changed-p"] = 'Notes changed for %1$d reservations';
$lang["nreduced"] = 'At reduced price';

$lang["orderby"] = 'Order by %1$s';

$lang["panic"] = <<<EOD
<h2>WE HAVE BEEN UNABLE TO PROCESS YOUR BOOKING</h2>
<p class='main'>The system administrator has been notified and it will 
be fixed as quickly as possible.</p>

<p class='main'>Please come back in a few hours and try again</p>

<p class='main'>We apologise for this problem, and appreciate your patience.</p>
EOD;

$lang["params"] = 'Modify %1$ssystem parameters%2$s';
$lang["pay_cash"] = 'at the counter';
$lang["pay_ccard"] = 'by credit card';
$lang["pay_other"] = 'other';
$lang["pay_postal"] = 'by postal transfer';
$lang["payinfo_cash"] = <<<EOD
Tickets are to be paid 30 minutes before the show begins, at the
latest, otherwise they may be put back for sale.

EOD;
$lang["payinfo_ccard"] = <<<EOD
We have not yet received the payment notification. In case we don't
receive it by %1\$d days the tickets may be put back for sale.

EOD;
//'
$lang["payinfo_postal"] = <<<EOD
The total is to be paid on the %1\$s
before %2\$d working days, otherwise they may be put back for sale.

EOD;
//'

$lang["paybutton"] = 'Please use the following button to proceed with payment:&nbsp;%1$sContinue%2$s';
$lang["payment"] = 'Payment:';
$lang['payment_received'] = 'Your payment has been received.  Thank you!';
$lang['paypal_id'] = 'PayPal Transaction ID: ';
$lang['paypal_lastchance'] = "We are ready to accept your payment.  After clicking on the button below, you will be transferred to the PayPal web site along with information about your ticket purchase.  After completing the payment, you will be transferred back to this site and your payment will be recorded.  Your credit or debit card information will be limited to the PayPal secure payment system.";
$lang["paypal_purchase"] = 'PayPal Ticket Purchase';
$lang["phone"] = 'Phone';
$lang['please_wait'] = 'Processing Transaction . . .  Please Wait';
$lang["postal tax"] = 'Postal tax';
$lang["postalcode"] = 'Zip Code';
$lang["poweredby"] = 'Powered by %1$s';
$lang["price"] = 'Price';
$lang["price_discount"] = 'Discount Price ';
$lang['prices']  = 'Ticket Prices';
$lang["print_entries"] = '%1$sPrint%2$s selected entries';

$lang["rebook"] = 'Make a new booking using the selected entries as a template: %1$sStart booking%2$s';
$lang["rebook-info"] = 'To reactivate deleted bookings, first select the "Deleted" filter on the top-left of this page';
$lang["reduction_or_charges"] = 'Reductions/charges';
$lang["remail"] = 'Have you lost your ticket? The following link lets you get it back: %1$sBooking retrieval%2$s';
$lang["reminders"] = 'Reminders';
$lang["reqd_info"] = <<<EOD
You must in all cases at least provide a name.
Moreover, if you pay by credit card an email address and
a complete address are required.
EOD;
$lang["reserved-header"] = 'Reserved Seat Tickets';
$lang["row"] = 'Row';

$lang["sameprice"] = 'Prices are the same for all categories';
$lang["save"] = 'Save';
$lang["seat_free"] = 'Free<br>Seat:';
$lang["seat_occupied"] = 'Occupied<br>Seat:';
$lang["seats"] = 'Seats';
$lang["seats_booked"] = 'Booked Seats';
$lang["seeasalist"] = 'See as a %1$sList%2$s';
$lang["seeasamap"] = 'The following link lets you see bookings for this show as a&nbsp;: %1$sBooking map%2$s';
$lang["select"] = 'Select';
$lang["select_payment"] = 'Please select a payment method:';
$lang["selected_1"] = '1 seat selected';
$lang["selected_n"] = '%1$d seats selected';
$lang["sentto"] = 'Message sent to %1$s';
$lang["set_status_to"] = 'Selected entries are to be: ';
$lang["show_any"] = 'All shows';
$lang["show_info"] = '%1$s at %2$s, %3$s'; // date, time, location
$lang["show_name"] = 'Show Name';
$lang["show_not_stored"] = 'Your changes could not be saved.  Please check with your system administrator.';
$lang["show_stored"] = 'Your changes have been saved.';
$lang["showallspec"] = 'Show %1$sall spectacles%2$s.'; // §NEW IN 1.2.2b (that's "%1$s show all %2$s" without the spaces)
$lang["showlist"] = 'Shows of %1$s';
$lang["spectacle_name"] = 'Select a Show';
$lang["state"] = 'State'; // in the sense of status, not in the sense
			  // of a country's part
$lang["st_any"] = 'Any state';
$lang["st_booked"] = 'Booked';
$lang["st_deleted"] = 'Deleted';
$lang["st_disabled"] = 'Disabled';
$lang["st_free"] = 'Free';
$lang["st_locked"] = 'In process';
$lang["st_notdeleted"] = 'Not deleted';
$lang["st_paid"] = 'Paid';
$lang["st_shaken"] = 'Reminder sent';
$lang["st_tobepaid"] = 'To be paid';
$lang["stage"] = 'Stage';
$lang["summary"] = 'Summary';

$lang["thankyou"] = 'Thank You';
$lang["theatre_name"] = 'Theatre Seatmap Name';
$lang["time"] = 'Time';
$lang["time_title"] = 'Time<br>(hh:mm)';
$lang["timestamp"] = 'Booked on';
$lang["title_mconfirm"] = 'Confirm Show Details';
$lang["title_maint"] = 'Add or Edit a Show';
$lang["to"] = 'To'; // in a temporal sense : from a to b
$lang["total"] = 'Total';

$lang["update"] = 'Update';
$lang['us_state'] = 'State (US Only)';

$lang["warn_badlogin"] = 'Illegal client connection attempt';
$lang["warn_bookings"] = 'Please Note: You are about to change date, time or price for a show that has already sold tickets. You should contact those who have already purchased tickets to inform them of the change.  If you change the ticket prices, tickets may have been sold for amounts different than the new prices, which will cause confusion.  Please proceed with caution.';
$lang["warn_close_in_1"] = 'Warning, on-line booking for this show is going to close in one minute';
$lang["warn_close_in_n"] = 'Warning, on-line booking for this show is going to close in %1$d minutes';
$lang["warn-nocontact"] = 'Warning, you have not provided any contact information ; We will therefore be unable to contact you in case there is a problem related to your booking';
$lang["warn-nomail"] = 'Warning, you have not provided an email address ; You will therefore not be notified of your booking status';
$lang["warn-nomatch"] = 'No match'; // no matching bookings
$lang["warn-nonsensicalcat"] = 'Warning, you have requested more reduced price seats than you have selected seats';
$lang["warn-nonsensicalcat-admin"] = 'Warning, the number of requested invitations plus the number of requested reduced price tickets is bigger than the number of selected seats';
$lang['warn_paypal_confirm'] = 'We could not confirm your PayPal payment.  Please contact the office to confirm your payment.';
$lang['warn_process_payment'] = 'There was a problem with final processing of your payment.  Please contact the office to confirm your payment';
$lang["warn_show_confirm"] = 'Please confirm that the information above is accurate.  To make further changes, click on the Edit link.  When you are ready, click Save.';
$lang["warn_spectacle"] = 'Please note that you cannot change the theatre seatmap after a show has been created.';
$lang["we_accept"] = "We Accept"; // credit card logos come after that
$lang["weekdays"] = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$lang["workingdays"] = 'working days';

$lang["youare"] = 'You Are:';

$lang["zoneextra"] = ''; // intentionally left blank

/** add "at the" before the given noun. This is used with theatre
names (We have a problem in case we need to know if $w is masculine or
feminine or whatever - so far everything has been masculine so won't
extend the function until need appears :-) **/
function lang_at_the($w) {
  return "in de $w";
}

?>
