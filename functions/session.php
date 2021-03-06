<?php

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/configuration.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/seat.php");
require_once (FS_PATH . "functions/shows.php");
require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "functions/booking.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id$

Session and booking session related functions
*/

/* connects to the database using either adminuser or dbuser. In case
the in-session password is wrong, it is cleared.
*/
function db_connect($die_on_failure = true) {
  global $dbserv, $dbuser, $dbpass, $dbdb, $adminuser,$lang,$messages;
  
  session_name("freeseat");
  session_start();
  
  $messages = array();

  if (admin_mode())
    $r = mysql_connect($dbserv, $adminuser, $_SESSION["adminpass"]);
  else
    $r = mysql_connect($dbserv, $dbuser, $dbpass);

  if ($r && mysql_select_db($dbdb))
    return; // success

  /* if we reach this point, something went wrong */

  if (mysql_errno()==1045)
    $msg = $lang["err_pw"];
  else
    $msg = mysql_error();

  unset($_SESSION["adminpass"]);
  unset($_POST["adminpass"]); // yea, ugly, I know ... That's to
			      // prevent the show_foot function to
			      // think we successfully logged in.
  if ($die_on_failure)
    fatal_error($lang["err_connect"].$msg);
  else
    return false;
}

/** Call this after creating the session, for passing on messages that
were created after show_head(). WARNING on register_globals
systems you MUST reset $messages yourself at the beginning (db_connect
does it) **/
function load_alerts() {
  global $messages;
  if (isset($_SESSION["messages"]))
    $messages = array_merge($_SESSION["messages"], $messages);
  $_SESSION["messages"] = array();
}

/* Whether administration were requested. Note that you probably don't
   want to call this function before db_connect(), because admin
   credentials won't be checked.

   when $unsecure_login is false, we need two things be in admin_mode:
   both a secure connexion (which implies a valid client ssl certificate)
   and either $_SESSION["adminpass"] or $_POST["adminpass"] to be correctly
   set. In the latter case the password is shifted into the session */
function admin_mode() {
    global $lang,$unsecure_login;
    if (isset($_POST["adminpass"]) && strlen($_POST["adminpass"])>0)
	$_SESSION["adminpass"] = nogpc($_POST["adminpass"]);
    if (isset($_SESSION["adminpass"])) {
	if ($unsecure_login) {
	    return true;
	} else {
	    if ((isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on') ||
		(isset( $_SERVER['SERVER_PORT']) && 
		 $_SERVER['SERVER_PORT']=='443')
		) {
		// twowheeler: some servers don't report HTTPS properly
		return true;
	    } else {
		kaboom("You don't seem to be using a secure connection");
		kaboom($lang["err_config"]. '$sec_area');
	    }
	}
    }
    return false;
}

/** check that the session is sufficiently defined. When you pass a
    value $n all conditions from 1 to $n must be satisfied
    
    $n = 0: booking must be enabled.
    $n = 1: a valid date must be specified
    $n = 2: seats must be specified
    $n = 3: seats must still be available
    $n = 4: we must be ready to book (a name must be provided, and
              more in case of ccard payment)

    set $quiet to true to hide non critical warnings
*/
function check_session($n,$quiet=false) {
  global $lang,$take_down;
  /* 
     We are checking each time that the show exists - that's maybe a little
     overkill (checking @ the end would suffice but anyway we are more
     consistent this way)
  */
  $system_config = get_config();

  // still-not-booked. Note, if this is false then we should
  // "normally" always succeed. The checks done here are useful in
  // case there is a bug in the code.
  $snb = (!isset($_SESSION["booking_done"])) || !$_SESSION["booking_done"];
  if ($take_down && !admin_mode()) {
    kaboom($take_down);
    $url = "index";
  } else if (!isset($_SESSION["showid"])) {
    kaboom($lang["err_session"]);
    $url = "index";
  } else if (do_hook_exists("check_session", 0)) {
    $url = "index";
  } else if ($n >= 1 && !($sh = get_show($_SESSION["showid"]))) {
    $url = "repr";
  } else {
    $remaining = show_closing_in($sh);
    if ($n >= 1 && $remaining<=0 && (!admin_mode()) && $snb) {
      kaboom($lang["err_closed"]);
      $url = "repr";
    } else if ($n>=1 && do_hook_exists("check_session", 1)) {
      $url = "repr";
    } else {
      if ((!admin_mode()) && $snb &&
	  ($remaining<=15) && !$quiet) {
	/* This is a warning but not a failure */
	if ($remaining==1)
	  kaboom($lang["warn_close_in_1"]);
	else
	  kaboom(sprintf($lang["warn_close_in_n"],$remaining));
      }
      if ($n>=2 && ((!isset($_SESSION["seats"])) || count($_SESSION["seats"])==0)) {
	kaboom($lang["err_checkseats"]);
	$url="seats";
      } else if ($n>=2 && do_hook_exists("check_session", 2)) {
	$url = "seats";
      } else if ($n>=3 && $snb && !check_seats()) {
	unlock_seats(false); // this one is probably not needed?
	kaboom($lang["err_occupied"]);
	$url="seats";
      } else if ($n>=3 && do_hook_exists("check_session", 3)) {
	$url = "seats";
      } else if ($n>=4) {
	if (admin_mode() && isset($_SESSION["lastname"]) && $_SESSION["lastname"]) {
	return;
	} else if ((!isset($_SESSION["firstname"])) || (!isset($_SESSION["lastname"])) || (!isset($_SESSION["email"])) || $_SESSION["firstname"]=='' || $_SESSION["lastname"]=='' || $_SESSION["email"]=='') {
		kaboom($lang["err_noname"]);
		$url="pay";
		} else if (isset($_SESSION["email"]) && $_SESSION["email"] && !is_email_ok($_SESSION["email"])) {
	  kaboom($lang["err_bademail"]);
	  $url="pay";
	} else if ($snb && !payment_open($sh,$_SESSION["payment"])) {
	  /* WARN: if someone handcrafts a PAY_CASH payment method
	   *before* it is available he'll still get this error message,
	   that it is "no longer" available but this bug doesn't occur
	   with normal client use */
	  kaboom(sprintf($lang["err_paymentclosed"],f_payment($_SESSION["payment"])));
	  $url="pay";
	} else if (do_hook_exists("check_session", 4)) {
	  $url = "pay";
	} else return; // success
      } else return; // success
    }
  }

  /* at this point we have failed */

  show_head();
  echo "<p class='main'>";
  printf($lang["backto"],"[<a href='$url.php'>".$lang["link_$url"]."</a>]");
  echo "</p>\n";
  show_foot();
  exit;
}

function kill_booking_done() {
  if (isset($_SESSION["booking_done"]) && $_SESSION["booking_done"]) {
    unlock_seats();
    $_SESSION["booking_done"] = false;
    // foreach'ing and unset'ting on the same array tends to create instabilities.
    // cf. http://bugs.php.net/bug.php?id=36646
    $sessioncopy = $_SESSION; // ... so looping on a copy instead
    foreach ($sessioncopy as $key => $v) if (substr($key,0,6)=='nncnt-')
      unset($_SESSION[$key]);

    unset($_SESSION["showid"]);
    unset($_SESSION["mail_sent"]);
    foreach (array(CAT_REDUCED, CAT_NORMAL, CAT_FREE) as $cat) 
      if (isset($_SESSION["ncat$cat"])) unset($_SESSION["ncat$cat"]);
    do_hook('kill_booking_done');
  }
}

?>
