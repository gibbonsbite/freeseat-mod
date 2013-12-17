<?php

$lang["_encoding"] = "ISO-8859-1";


$lang["access_denied"] = 'ACCESS DENIED - Your session must have expired';
$lang["acknowledge"] = 'acknowledged'; // used with check_st_update
$lang["address"] = 'Address';
$lang["admin"] = 'Administrative Functions';
$lang["admin_buy"] = 'Book and %1$sbuy%2$s tickets (and invitations)';
$lang["alert"] = 'ALERT';
$lang["are-you-ready"] = 'Please review your entries to make sure they are correct, then click Continue.';

$lang["backto"] = 'Back to %1$s';
$lang["book"] = 'Book';
$lang["bookagain"] = 'Make %1$sAnother booking%2$s';
$lang["bookid"] = 'Code';
$lang["book_adminonly"] = 'Booking closed to the public';
$lang["book_submit"] = 'Make booking';
$lang["booking_st"] = 'Reservations in state %1$s';
$lang["bookinglist"] = 'Browse/Modify %1$sbookings%2$s (e.g. for acknowledging a payment)';
$lang["bookingmap"] = 'Booking Map';
$lang["buy"] = 'Book and %1$sbuy%2$s tickets';

$lang["cancel"] = "Cancel";
$lang["cancellations"] = "Cancellations";
$lang["cat"] = 'Rate';
$lang["cat_free"] = 'Complimentary';
$lang["cat_normal"] = 'Normal ';
$lang["cat_reduced"] = 'Discount ';
$lang["ccard_failed"] = '%1$s WHILE PROCESSING A CREDIT CARD NOTIFICATION\n\n\n';
$lang["ccard_partner"] = 'Credit card payment made secure by&nbsp;%1$s';
$lang["change_date"] = 'Change date';
$lang["change_pay"] = 'Change %1$sPersonal and payment information%2$s';
$lang["change_seats"] = 'Change %1$sSeat selection%2$s';
$lang["check_st_update"] = 'Check that the following list of bookings to be %1$s is correct then click on confirm at the bottom of this page';
$lang["choose_show"] = 'Please choose a show';
$lang["city"] = 'City';
$lang["comment"] = 'Comment';
$lang["confirmation"] = 'Confirmation';
$lang["continue"] = 'Continue';
$lang["country"] = 'Country';
$lang["class"] = 'Category';
$lang["closed"] = 'Closed';
$lang["col"] = 'Seat';
$lang["create_show"] = 'Create a new show';

$lang["date"] = 'Date';
$lang['datesandtimes'] = 'Show Dates';
$lang["date_title"] = 'Date<br>(yyyy-mm-dd)';
$lang["day"] = 'd'; // abbreviated
$lang["days"] = 'days';
$lang["DELETE"] = 'DELETED'; // used in check_st_update
$lang["description"] = 'Description';
$lang["diffprice"] = 'Prices are color-coded by each category as shown below';
$lang["disabled"] = "disabled"; // for shows or payment methods
$lang["dump_csv"] = 'Database dump in csv format: %1$sbookings.csv%2$s';

$lang['editshows'] = 'Add or edit %1$sshow%2$s information';
$lang["email"] = 'Email';
$lang["err_bademail"] = 'The e-mail address you gave does not seem to be valid';
$lang["err_badip"] = 'You are not authorised to access this file';
$lang["err_badkey"] = 'The access key was not correct. You may try again. (Please send an email to %1$s if you don\'t manage)';
$lang["err_bookings"] = 'Error accessing bookings';
$lang["err_ccard_cfg"] = 'Credit card payment must be setup in config.php before it can be enabled'; // § NEW in 1.2.1
$lang["err_ccard_insuff"] = 'Can\'t pay seat %1$d costing %4$s %2$d with only %4$s %3$d available!';
$lang["err_ccard_mysql"] = '(Mysql) error while logging a credit card transaction';
$lang["err_ccard_nomatch"] = 'push (%1$s) and pull (%2$s) do not match (using pull amount)';
$lang["err_ccard_pay"] = 'Can\'t record credit card payment for seat %1$d ! (check logs - maybe it has already been paid)';
$lang["err_ccard_repay"] = 'Received a (credit card) payment acknowledgement for seat %1$d that has already been paid !';
$lang["err_ccard_toomuch"] = 'We got too much money! %3$s %1$d out of %3$s %2$d unused.';
$lang["err_ccard_user"] = 'There was a problem with payment - you may try again, or also send an email to %1$s';
$lang["err_checkseats"] = 'Select Your Seats';
$lang["err_closed"] = 'Sorry, on-line booking for this show has just closed';
$lang["err_config"] = 'Check server configuration on: '; // § NEW
$lang["err_connect"] = 'Connection error : ';
$lang["err_cronusage"] = "One argument expected (database booking system password)\n";
$lang["err_email"] = 'Selected bookings don\'t all have the same email address (I keep the first one)';
$lang["err_filetype"] = 'Wrong file type, was expecting: ';
$lang["err_ic_firstname"] =    'Selected bookings don\'t all have the same first name (keeping the first one)';
$lang["err_ic_lastname"] =    'Selected bookings don\'t all have the same last name (keeping the first one)';
$lang["err_ic_payment"] = 'Selected bookings don\'t all have the same payment method (keeping the first one)';
$lang["err_ic_phone"] =   'Selected bookings don\'t all have the same phone number (keeping the first one)';
$lang["err_ic_showid"] =  'Selected bookings are not all for the same show...';
$lang["err_noaddress"] = 'For credit card payment you must at least provide an email address and a complete postal address.';
$lang["err_noavailspec"] = 'There are no spectacles available for booking'; // § NEW IN 1.2.2b
$lang["err_nodates"] = 'No show dates are set for this show.';
$lang["err_noname"] = 'Please at least provide a name';
$lang["err_noprices"] = 'No prices are set for this show.';
$lang["err_noseats"] = 'No seats to display'; // § NEW
$lang["err_nospec"] = 'You must provide a name for this show.';
$lang["err_notheatre"] = 'Please select a theatre seatmap.';
$lang["err_occupied"] = 'Sorry, one of the seats you selected has just been booked';
$lang["err_paymentclosed"] = 'Payment %1$s has just been closed for this show';
$lang["err_payreminddelay"] = 'Payment delay must be longer than remind delay';
$lang["err_postaltax"] = 'Price is too high for postal payment';
$lang["err_price"] = 'Can\'t get seat price';
$lang["err_pw"] = 'Unknown user or bad password. Please try again';
$lang["err_scriptauth"] = 'Request to script %1$s rejected';
$lang["err_scriptconnect"] = 'Connecting to the %1$s script failed';
$lang["err_seat"] = 'Error accessing seat';
$lang["err_seatcount"] = 'You cannot book so many seats at a time';
$lang["err_seatlocks"] = 'Error locking seat';
$lang["err_session"] = 'You do not (or no longer) have a current booking session. (Are "cookies" activated in your browser?)';
$lang["err_setbookstatus"] = 'Error while changing seat status';
$lang["err_shellonly"] = 'ACCESS DENIED - Accessing this page requires shell access';
$lang["err_show_entry"] = 'This show cannot be saved until you supply the missing items.';
$lang["err_showid"] = 'Bad show number';
$lang["err_smtp"] = 'Warning: sending message failed: %1$s - Server replied: %2$s';
$lang["err_spectacle"] = 'Error accessing spectacle data';
$lang["err_spectacleid"] = 'Bad spectacle number'; // § NEW
$lang["err_upload"] = 'Problem uploading file';
$lang["expiration"] = 'Expiration';
$lang["expired"] = 'already expired';

$lang["failure"] = 'PANIC';
$lang["file"] = 'File: '; 
$lang["filter"] = 'Show:'; // filter form header in bookinglist
$lang["firstname"] = 'First name';
$lang["from"] = 'From'; // in a temporal sense : from a to b

$lang["hello"] = 'Hello %1$s,';
$lang["hideold"] = '%1$sHide%2$s old spectacles.'; // §NEW IN 1.2.2b that's "%1$s hide %2$s" without the spaces
$lang["hour"] = 'hr'; // abbreviated
/* (note : this is only used for at least two seats) */
$lang["howmanyare"] = 'Among these %1$d seats, how many are';

$lang["id"] = 'Code';
$lang['imagesrc'] = 'Image location';
$lang["immediately"] = 'immediately';
$lang["import"] = 'Upload this file';
$lang["in"] = 'in %1$s'; // as in "in <ten days>"
$lang["index_head"] = 'On-line Box Office';
$lang["intro_ccard"] = <<<EOD
 <h2>Thank you for your booking</h2>

<p class="main">The seats are now booked in your name.</p>
EOD;

$lang["intro_confirm"] = 'Please check and make any required changes before validating your booking';
$lang["intro_finish"] = 'This page is your entry ticket. Please print it and bring it to the show.';
$lang["intro_params"] = <<<EOD
<h2>Availability of payment methods</h2>

<p class="main">
<ul><li><p>
Provide here the periods during which the various payment methods are
available, relative to show date.
</p>
<li>
<p>The numbers to be provided are numbers of <em>minutes</em> before
the beginning of the show.</p>
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

?>
