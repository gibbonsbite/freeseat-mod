<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "functions/spectacle.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info

$Id: confirm.php 353 2011-06-13 14:34:45Z tendays $
**/

db_connect();

load_alerts();

kill_booking_done();

foreach (array("firstname","lastname","phone","email","address","postalcode","city","us_state","country") as $n => $a) {
  if (isset($_POST[$a]))
      $_SESSION[$a] = make_reasonable(nogpc($_POST[$a]));
}

if (isset($_POST["email"])) $_SESSION["email"] = make_email_reasonable(nogpc($_POST["email"]));

/* See how many seats must be marked reduced/invitation. This map maps
 CAT_xyz entries to the number of requested seats. */
$hook_catmap = array();

if (isset($_POST["ncat".CAT_REDUCED]))
  $hook_catmap[CAT_REDUCED] = ceil(abs($_POST["ncat".CAT_REDUCED]));
else if (isset($_POST["cat"])) {
  switch ($_POST["cat"]) {
  case CAT_REDUCED:
    $hook_catmap[CAT_REDUCED] = 1;
    break;
  case CAT_FREE:
    if (admin_mode()) $hook_catmap[CAT_FREE] = 1;
    break;
  }
}

if (admin_mode() && isset($_POST["ncat".CAT_FREE])) {
  $hook_catmap[CAT_FREE] = ceil(abs($_POST["ncat".CAT_FREE]));
}

do_hook('pay_process'); // this may modiy the $hook_catmap variable

/* Note: Should not be necessary to check the value is valid because
check_session will anyway fail if given an illegal payment method but
let's play safe */
if (isset($_POST["payment"])) {
  switch ($_POST["payment"]) {
  case PAY_CCARD:
    $_SESSION["payment"]=PAY_CCARD;
    break;
  case PAY_CASH:
    $_SESSION["payment"]=PAY_CASH;
    break;
  case PAY_OTHER:
    $_SESSION["payment"]=PAY_OTHER;
	// allow a sale from the office to proceed even if we have no user data
	if ((!isset($_SESSION["lastname"])) || $_SESSION["lastname"]=="")
		$_SESSION["lastname"] = $lang["pay_other"];
    break;
  default: // case PAY_POSTAL:
    $_SESSION["payment"]=PAY_POSTAL;
    break;
  }
} else {
$_SESSION["payment"]=PAY_CASH;
}

check_session(4);

if (!empty($hook_catmap)) {
  foreach ($hook_catmap as $cat => $n) {
    $_SESSION["ncat$cat"] = $n;
  }

  /* This is the only place where we pass true to that function. The
  reason is that it is the only place where the user explicitly gave
  those ncatxyz values, just below the ticket list, so it makes sense
  to
  1. shout at him for giving nonsensical values
  2. correct them in-session

  In contrast, if for instance the user reduced the number of selected
  seats to get below the number of requested reduced seats, we are not
  going to shout at him or change the in-session $ncatX behind his
  back. */
  compute_cats(true);
}

if (!admin_mode()) {
if ($_SESSION["payment"]!=PAY_OTHER)  {	
  if (!$_SESSION["email"]) {
    if (!$_SESSION["phone"])
      kaboom($lang["warn-nocontact"]);
    else
      kaboom($lang["warn-nomail"]);
  }
}
}

show_head();

check_session(1); // check showid
$sh = get_show($_SESSION["showid"]);
$spectacleid = $sh["spectacleid"]; // movie ID
$spec = get_spectacle($spectacleid);

//echo '<p class="main">'.$lang["intro_confirm"].'</p>';
echo '<h2>'.$lang["summary"].'</h2>';

echo '<p class="main"> Elokuva: ';
printf($spec["name"]); // movie name
echo '</p><p class="main">N&auml;yt&ouml;s: ';
show_show_info();
echo '</p>';

echo print_booked_seats(null,FMT_PRICE|FMT_CORRECTLINK);
show_user_info();
if (admin_mode()) {
if (get_total() > 0) show_pay_info();
}
echo '<p class="main">';
printf($lang["change_pay"],'[<a href="pay.php">','</a>]');
echo '</p>';

echo '<form action="finish.php" method="post">';

do_hook('confirm_bottom');
// let's check that the user actually owes us something
if ($_SESSION["payment"] == PAY_CCARD && get_total()>0) {
	echo '<h2>'.$lang["make_payment"].'</h2>';
	echo '<p class="emph">' . $lang['paypal_lastchance'] . '</p>';

	do_hook('ccard_confirm_button');

	echo '</form>';
} else {
  echo '<div class="continue"><input type="submit" value="'.$lang["book_submit"].'"></div>';
}
echo '</form>';
show_foot();

?>
