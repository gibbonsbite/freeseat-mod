<?php

define ('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/send.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: index.php 372 2011-08-28 10:35:23Z tendays $ */

db_connect();

ensure_plugin('remail');

$mailsent = false;

if (isset($_POST["email"])) {

  $eml = make_reasonable(trim(nogpc($_POST["email"])));

  if (!is_email_ok($eml)) {
    kaboom($lang["err-bademail"]);
  } else {

    $mailsent=true;

    // mysqlescape is not supposed to change anything but maybe i'll add
    // quotes or something in chars assumed "reasonable" and forget
    // about that part or something - so this is safer and doesn't hurt
    $paid = get_bookings("email='".mysql_real_escape_string($eml)."' and state=".ST_PAID." and date >= curdate()","shows.date,shows.time,booking.id");
    $countpd=count($paid);
    $bookd = get_bookings("email='".mysql_real_escape_string($eml)."' and (state=".ST_BOOKED." or state=".ST_SHAKEN.") and date >= curdate()","shows.date,shows.time,booking.id");
    $countbk=count($bookd);

    /** WARNING : Using timing attacks someone (sufficiently
     * motivated) can know if the given email address has made
     * bookings or not (yet can't do it discreetly because it will
     * generate a bunch of mails to the person in question) */

    if ($countpd+$countbk > 0) {
      // find a name
      if ($countpd)
	$body= sprintf($lang["hello"],$paid[0]["firstname"].' '.$paid[0]["lastname"])."\n\n";
      else
	$body= sprintf($lang["hello"],$bookd[0]["firstname"].' '.$bookd[0]["lastname"])."\n\n";

      $_SESSION["randkey"] = mt_rand();
      $_SESSION["email"] = $eml;

      $body.=sprintf($lang["mail-remail"],$websitename,$_SESSION["randkey"]);

      if ($countpd) {
	$body .= ($countpd>1?$lang["mail-gotmoney-p"]:$lang["mail-gotmoney"])."\n";
	$body .= print_booked_seats($paid,FMT_SHOWID|FMT_SHOWINFO);
	$body .= "\n";
      }

      if ($countbk) {
	$body .= ($countbk>1?$lang["mail-notpaid-p"]:$lang["mail-notpaid"])."\n";

	$body .= print_booked_seats($bookd,FMT_SHOWID|FMT_PRICE|FMT_SHOWINFO);
	$body .= "\n";
      }
    } else { // no records found

      /* Now that there can be more than one spectacle there is no way
	 to know for which one the user was expecting tickets - so
	 we'll use $websitename instead of $spec["name"] in the mail */

      //      $spec = get_spectacle();

      $body = sprintf($lang["mail-spammer"],$websitename,$normal_area,$eml);
    }

    $body.= "\n";
    $body.= "$auto_mail_signature\n";


    $s=($countbk+$countpd)>1?"s":"";  
    send_message($smtp_sender,$eml,$lang["mail-sub-remail"],$body);

    kaboom(sprintf($lang["sentto"],$eml));
  }
} else if (isset($_POST["randkey"])) {
  if (isset($_SESSION["randkey"])) {
    $randkey = $_SESSION["randkey"];
    unset($_SESSION["randkey"]);
    if ($_POST["randkey"] == $randkey) {
      $paid = get_bookings("email='".mysql_real_escape_string($_SESSION["email"])."' and state=".ST_PAID." and date >= curdate()","shows.date,shows.time,booking.id");
      $countpd=count($paid);
      $bookd = get_bookings("email='".mysql_real_escape_string($_SESSION["email"])."' and (state=".ST_BOOKED." or state=".ST_SHAKEN.") and date >= curdate()","shows.date,shows.time,booking.id");
      $countbk=count($bookd);
      show_head();

      if ($countpd) {
        echo "<h2>".($countpd>1?$lang["mail-gotmoney-p"]:$lang["mail-gotmoney"])."</h2>\n";

	do_hook('ticket_prepare');
	foreach ($paid as $h => $w) {
	  do_hook_function('ticket_render', $w);
	}
	do_hook('ticket_finalise');
      }
      if ($countbk) {
        echo "<h2>".($countbk>1?$lang["mail-notpaid-p"]:$lang["mail-notpaid"])."</h2>\n";
	do_hook('ticket_prepare');
	foreach ($bookd as $h => $w) {
	  do_hook_function('ticket_render', $w);
	}
	do_hook('ticket_finalise');
      }

      print_legal_info();

      echo  "<p class='main'>".sprintf
	($lang["backto"],
	 '[<a href="'. FS_PATH .'index.php">'.$lang["link_index"].'</a>]')
	."</p>";

      show_foot();
      exit;  /* TODO - make flow control less ugly around here */
    }
  } // TODO:  else { warn about missing cookies }
  kaboom(sprintf($lang["err_badkey"],$smtp_sender));
}

show_head();

 echo '<form action="index.php" method="POST">';

 if ($mailsent) {
  printf($lang["intro_remail2"],'<input name="randkey">  <input type="submit" value="'.$lang['continue'].'">');
 } else {
  printf($lang["intro_remail"],'<input name="email">  <input type="submit" value="'.$lang['continue'].'">');
 }
 
 echo '</form>';

echo  "<p class='main'>".sprintf
($lang["backto"],
 '[<a href="'. FS_PATH .'index.php">'.$lang["link_index"].'</a>]')
."</p>";
 show_foot();

?>
