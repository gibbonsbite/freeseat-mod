<?php

/*
Requires a new table postpay_keys for storing keys for re-entry to the payment process.

CREATE TABLE IF NOT EXISTS `postpay_keys` (
  `randkey` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(254) NOT NULL DEFAULT '',
  `expiration` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`randkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

*/
define ('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/send.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

function postpay_rebook($groupid,$seat) {
	// this function changes the groupid of bookings to a new group 
	$showid = $seat["showid"];
	$seatid = $seat["seat"];	
	$bookid = $seat["bookid"];
	$st = get_seat_state($seatid,$showid,true);
	if ($st!=ST_BOOKED && $st!=ST_SHAKEN) {
	  sys_log("Help! Trying to pay for the wrong seats!");
	  return false;
	}
	sys_log("rebooking $bookid with $groupid");
	$oldbook = fetch_all(mysql_query("select groupid from booking where id=$bookid"));
	if (!count($oldbook)) {      // shouldn't happen, booking already exists	
	  sys_log("Help! Can't rebook this seat!");
	  return false;
	}		
	if ($groupid==0) 
	  mysql_query("update booking set groupid=NULL where id=$bookid");
	else	
 	  mysql_query("update booking set groupid=$groupid where id=$bookid");
	return true;
}

function postpay_relock($seat) {
	// this function updates the lock time on seats for remail
	$showid = $seat["showid"];
	$seatid = $seat["seat"];
	$oldlock = fetch_all(mysql_query("select * from seat_locks where seatid=$seatid showid=$showid"));
    if (count($oldlock)) 
		mysql_query("update seat_locks set until=".$_SESSION["until"].
			" where seatid=$seatid and showid=$showid)");
	else 
		mysql_query("insert into seat_locks (seatid,showid,until) values ($seatid, $showid,".
			$_SESSION["until"].")");
	return true;
}

function postpay_write( $safeemail, $randkey ) {
	// write the email, key and expiration time to the postpay_keys table
	global $lang;
	$dt = time() + 60*60*24;
	$sql = "INSERT into postpay_keys (email,randkey,expiration) values ('$safeemail','$randkey', FROM_UNIXTIME($dt))";
	if ( ! mysql_query( $sql ) ) 
	  sys_log( sprintf( $lang["mail-error"], $randkey, $safeemail ). mysql_error() );	
}

function postpay_read( $key ) {
	// check on the validity of the access key
	// the key must match, and the expiration time must be in the future
	$sql = "SELECT email,randkey,UNIX_TIMESTAMP(expiration) as u_expire from postpay_keys where randkey=$key";
	$data = mysql_fetch_assoc(mysql_query( $sql ));
	if (!$data)  {
		sys_log("SQL error on $sql: ". mysql_error() );
		$auth = array( "ok" => FALSE);
	} else {
		$auth = $data;
		$auth["ok"]= ($auth["u_expire"] > time());
	}
	return $auth;
}

/* Pass a condition such as "booking.id=2". (Empty string to get all
   bookings) Returns an array of mysql records.
   $orderby is passed to mysql's ORDER BY
   and $offset $limit are passed to mysql's LIMIT. 
   ** Adds x, y, and theatreid to regular get_bookings() */
function postpay_get_bookings($cond,$orderby = "booking.id",$offset = 0,$limit = 999999999) {
  if ($cond) $cond = "( $cond ) and";
  if ($orderby) $orderby = "ORDER BY $orderby";
  return fetch_all(mysql_query("SELECT booking.id as bookid,booking.*,seat,seats.row,seats.col,seats.extra,seats.zone,seats.class,showid,shows.date,shows.time,shows.spectacle as spectacleid,theatres.name as theatrename,seats.x,seats.y,seats.theatre as theatreid FROM booking,shows,seats,theatres WHERE $cond booking.seat = seats.id and booking.showid=shows.id and shows.theatre=theatres.id $orderby LIMIT ".((int)$limit)." OFFSET ".((int)$offset)));
}

function postpay_process() {
  global $lang, $normal_area, $lockingtime;

  $mailsent = false;

  if (isset($_POST["email"])) {

    $eml = make_reasonable(trim(nogpc($_POST["email"])));
 
    if (!is_email_ok($eml)) {
      kaboom($lang["err-bademail"]);
    } else {
      $mailsent=true;
      $bookd = postpay_get_bookings("email='".mysql_real_escape_string($eml)."' and (state=".ST_BOOKED." or state=".ST_SHAKEN.") and date >= curdate()","shows.date,shows.time,booking.id");
      $countbk=count($bookd);
      if ($countbk > 0) {
        // find a name
        $body= sprintf($lang["hello"],$bookd[0]["firstname"].' '.$bookd[0]["lastname"])."\n\n";

        $randkey = mt_rand();
        $_SESSION["email"] = $eml;
        $URL =  freeseat_url("plugins/postpay/index.php?access=$randkey");
        $body.=sprintf($lang["postpay_mail"],$websitename,$URL);
        postpay_write( mysql_real_escape_string($eml), $randkey );
        if ($countbk) {
	        $body .= ($countbk>1?$lang["mail-notpaid-p"]:$lang["mail-notpaid"])."\n";
          $body .= print_booked_seats($bookd,FMT_SHOWID|FMT_PRICE|FMT_SHOWINFO);
          $body .= "\n";
        }
      } else { // no records found
        // $spec = get_spectacle();
        $body = sprintf($lang["mail-spammer"],$websitename,$normal_area,$eml);
      }
      $body.= "\n";
      $body.= "$auto_mail_signature\n";
      send_message($smtp_sender,$eml,$lang["mail-sub-remail"],$body);
      kaboom(sprintf($lang["sentto"],$eml));
    }
  } else if (isset($_GET["access"])) {	// we are re-entering with an access key from an email link
    $randkey = $_GET["access"];
    // check for a record in access table with this $randkey
    $auth_data = postpay_read( $randkey );
    if ( $auth_data["ok"] ) {
      $eml = $auth_data["email"];
      $bookd = postpay_get_bookings("email='".mysql_real_escape_string($eml)."' and (state=".ST_BOOKED." or state=".ST_SHAKEN.") and date >= curdate()","shows.date,shows.time,booking.id");
    	if (count($bookd)) {
	      // At this point we have a list of booked but unpaid seats in $bookd
        // create a seats array in the session, and set everything up as though user
	      // arrived via the normal process at pay.php
  	    $showid = $bookd[0]["showid"];
	      $seats = array();
  	    $groupid = 0;
	    $ninvite = 0; // (tendays) TODO migrate this to use a cat-associative array as in pay.php
	      $nreduced = 0;
  	    $_SESSION["until"] = time()+$lockingtime;
	      foreach (array("firstname","lastname","phone","email", "payment", "address", "city", "us_state", "postalcode") as $n => $a) 
	        if (isset($bookd[0][$a]))	$_SESSION[$a] = make_reasonable($bookd[0][$a]);
     	  foreach ($bookd as $item => $data ) {
          $seat = $data["seat"];
          $seats[$seat] = array( "id" => $seat, "theatre" => $data["theatreid"], "cnt" => 1 );
          foreach (array("bookid", "row", "col", "extra", "zone", "class", "cat", "date", "time", "theatrename", "spectacleid","x","y") as $n => $a) {
	          if (isset($data[$a]))  $seats[$seat][$a] = $data[$a];
          }
          if ($data['cat']==CAT_REDUCED) $nreduced++;
          if ($data['cat']==CAT_FREE) $ninvite++; 
      		// if they have more than one unpaid booking, which groupid controls?
          // get payment for all of them, create one paypal transaction, with one new groupid
          // this could have bookings in multiple shows in one group
          if (postpay_rebook($groupid,$data) && ($groupid==0))
            $groupid = $data["bookid"];
          postpay_relock($data);
        } 
        $_SESSION["seats"] = $seats;
        $_SESSION["showid"] = $showid;
        $_SESSION["groupid"] = $groupid;
        $_SESSION["ninvite"] = $ninvite;
        $_SESSION["nreduced"] = $nreduced;
        // we are setting this var so that finish.php will not try to call book() again on these seats
        $_SESSION["booking_done"] = ST_BOOKED;
        $_SESSION["postpay"] = true;
        header("Location: ".FS_PATH."finish.php");	// then go back to get the payment
        exit;
      } else {
        // we should not get here since we don't send a link in the email if there are no tickets
	      kaboom(sprintf($lang["postpay_notickets"],$lang["st_tobepaid"]));
      }
    } else kaboom(sprintf($lang["err_badkey"],$smtp_sender));
  }
  return $mailsent;
}

// end of functions

init_language('postpay');

db_connect();

ensure_plugin('postpay');

$postpay_mailsent = postpay_process();
show_head();

echo '<form action="index.php" method="POST">';

if ($postpay_mailsent) {
  printf($lang["postpay_emailsent"],'<input name="randkey"> - <input type="submit">');
} else {
  printf($lang["postpay_intro"],'<input name="email"> - <input type="submit">');
}
 
echo '</form>';

echo  "<p class='main'>".sprintf
($lang["backto"],
 '[<a href="'. FS_PATH .'index.php">'.$lang["link_index"].'</a>]')
."</p>";
 show_foot();

?>
