<?php

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "functions/format.php");
include_once (FS_PATH . 'plugins/config/functions.php');

include_once (FS_PATH . 'plugins/seasontickets/locking.php');

/*
 *  Setup for season tickets in freeseat
 *  
 *  The general idea is that we want to make it possible to use a season ticket 
 *  in freeseat, but we are not concerned here about how the season tickets are 
 *  issued.  We are not selling season tickets in freeseat.  The admin can 
 *  create a season ticket code, and send the code to the buyer somehow, online 
 *  or offline.  This might be a free season ticket for making a large donation 
 *  to the theatre, for example.  A holder of one season ticket can get a free 
 *  ticket, once for each spectacle until the expiration date.  
 *  The seasontickets table also has a count field for the number of tickets 
 *  they are entitled to for each spectacle.
 *  TODO  Convert postaltax to a plugin for consistency. 
 */

define("CAT_SEASON",4);

function freeseat_plugin_init_seasontickets() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['check_session']['seasontickets'] = 'seasontickets_check';

    $freeseat_plugin_hooks['other_payment_info']['seasontickets'] = 'seasontickets_prompt';
    $freeseat_plugin_hooks['pay_process']['seasontickets'] = 'seasontickets_retrieve';
    $freeseat_plugin_hooks['book']['seasontickets'] = 'seasontickets_record';
    $freeseat_plugin_hooks['kill_booking_done']['seasontickets'] = 'seasontickets_cleanup';
    $freeseat_plugin_hooks['front_page_admin']['seasontickets'] = 'seasontickets_fplink';
    $freeseat_plugin_hooks['get_cats']['seasontickets'] = 'seasontickets_cat';
    $freeseat_plugin_hooks['get_cat_names']['seasontickets'] = 'seasontickets_name';
    $freeseat_plugin_hooks['get_seat_price']['seasontickets'] = 'seasontickets_price';
    $freeseat_plugin_hooks['config_db']['seasontickets'] = 'seasontickets_config_db';
    init_language('seasontickets');
}

function seasontickets_cat() {
  return CAT_SEASON;
}

function seasontickets_name() {
  global $lang;
  return $lang['seasontickets'];
}

function seasontickets_price($seat) {
  if ($seat['cat']==CAT_SEASON)
    return 0;
  else
    return NULL;
}

function seasontickets_prompt() {
  // prompt user for season ticket code
  global $lang;
  echo '<p class="main"><div'.(isset($_SESSION['seasontickets_highlight']) ? ' class="highlight"' : '').'>';
  echo $lang['seasontickets_enter']."&nbsp;:&nbsp;<input name='seasonticket'";
  if (isset($_SESSION['seasontickets'])) {
    if (!isset($_SESSION['seasontickets_highlight'])) {
      $d = htmlspecialchars($_SESSION['seasontickets']);
    echo ' value="'.$d.'"';
    } else {
      // if the user made an error, let's not encourage him to repeat it
      seasontickets_cleanup();
    }
  }
  echo " size=20>";
  echo '&nbsp;<input type="submit" value="'.$lang["seasontickets_ok"].'">';
  echo '</div></p>';
  unset($_SESSION['seasontickets_highlight']);
}

function seasontickets_retrieve() {
  global $seasontickets_process_failed, $lang, $hook_catmap;
  // determine if the user has any season tickets available
  $seasontickets_process_failed = false; // gets set to true whenever something goes wrong, and then gets picked up by _check()
  if (isset($_POST['seasonticket']) && !empty($_POST['seasonticket'])) {
    $sh = get_show($_SESSION["showid"]); 
    $spec = $sh['spectacleid'];
    $_SESSION['seasontickets'] = nogpc($_POST['seasonticket']);
    $code = $_SESSION['seasontickets'];
    // search seasontickets table for this code and expiration > current date
    $sql = "select * from seasontickets where code=".quoter($code)." and expiration > curdate()";
    // codes are unique so there is only one active season ticket record
    $account = mysql_fetch_assoc(mysql_query($sql));
    
    // if not found, return to pay.php and display error message
    if (empty($account)) {
      kaboom($lang['seasontickets_fail']);
      $seasontickets_process_failed = true;
    }

    /* Calling seasontickets_lock() here causes the "These season tickets are 
       currently locked from another session" message to fire at the wrong times, 
       such as when the season ticket is rejected because the code is not found 
       in the database.  If we delete this, then seasontickets_lock() will still be 
       called by seasontickets_check() so all is well.
    if ($seasontickets_process_failed && !seasontickets_lock($account['id'])) {
      // lock() already kaboomed for us.
      $seasontickets_process_failed = true;
    }  
    */

    if (!$seasontickets_process_failed) {
      // if found, search seasontickets_bookings for same id and spectacleid
      $used = 0;
      $available = 0;
      $id = $account['id'];
      $available = $account['count'];
      $sql = "select count(*) from seasontickets_bookings stb, booking bt, shows where stb.id = '$id' and shows.spectacle = '$spec' and bt.state != '".ST_DELETED."' and stb.bookingid = bt.id and bt.showid = shows.id";
      $used = m_eval($sql);
      // calculate remaining tickets available
      $available -= $used;
      if ($available > 0) {
        // pull booking data from table to populate $_SESSION
        foreach (array('firstname','lastname','email','address','city','us_state','postalcode','phone') as $name) {
          $_SESSION[$name] = $account[$name];
        }
        $_SESSION['seasontickets_id'] = $id;
        kaboom(sprintf($lang['seasontickets_thanks'],$available));
	      $hook_catmap[CAT_SEASON] = min($available,count($_SESSION['seats']));
      } else {
        kaboom($lang['seasontickets_gone']);
        $seasontickets_process_failed = true;
      }
    }
    // TODO: figure out why check_session() doesn't handle this
    if (isset($seasontickets_process_failed) && $seasontickets_process_failed) {
      $_SESSION['seasontickets_highlight'] = TRUE;
    }
  }
}

function seasontickets_record($bookid) {
  // write to seasontickets_bookings table
  if (isset($_SESSION['seasontickets_id']) && !empty($_SESSION['seasontickets_id'])) {
    $booking = get_booking($bookid);
    if ($booking['cat']!=CAT_SEASON) return;
    $seasonid = $_SESSION['seasontickets_id'];
    $sql = "insert into seasontickets_bookings (bookingid, id) ";
    $sql .= "values($bookid,$seasonid)";
    return mysql_query($sql);
  }
}

function seasontickets_cleanup() {
  // clear session variables after use
  seasontickets_unlock($_SESSION['seasontickets_id']);
  unset($_SESSION['seasontickets_id']);
  unset($_SESSION['seasontickets']);
}

function seasontickets_fplink() {
  global $lang;
  echo '<p class="main">';
  echo '[<a href="plugins/seasontickets/">'.$lang["seasontickets"].'</a>]';
  echo '</p>';
}

function seasontickets_codegen($n) {
  // generate a random string for a season ticket code $n chars long
  $pool = "abcdefghijklmnopqrstuvwxyz0123456789";
  $code = '';
  for ($i=0;$i<$n;$i++) {
    $code .= $pool[mt_rand(0,35)];
  }
  return $code;
}

/*
function seasontickets_coderead($code) {
  // scrub extra chars from code input
  return str_replace(array('-',' '),'',$code);
}

function seasontickets_codesplit($code) {
  if (strpos($code,'-')!==FALSE) return $code;
  return wordwrap($code,5,'-',TRUE);
}
*/

function seasontickets_config_db($user) {
  return config_checksql_for('plugins/seasontickets/setup.sql', $user);
}

function seasontickets_check($level) {
  global $lang, $seasontickets_process_failed;
  if ($level == 4) { // "we must be ready to book"
    /* NOTE: on register_globals system, users can set this variable
     and force check_session to fail on finish.php. This doesn't hold
     in confirm.php where it's relevant. */
    if (isset($seasontickets_process_failed) && $seasontickets_process_failed) {
      // (seasontickets_retrieve has already kaboomed)
      $_SESSION['seasontickets_highlight'] = TRUE;
      return true; // true = failure
    }

    $must_check_lock = false;
    /* if at least one selected seat requested CAT_SEASON... */
    foreach ($_SESSION["seats"] as $seat) {
      if ($seat['cat'] == CAT_SEASON) {
	$must_check_lock = true;
	break;
      }
    }
    if ($must_check_lock) {
      if (!isset($_SESSION['seasontickets_id'])) {
	/* That shouldn't happen but let's be safe */
	return kaboom($lang['seasontickets_nonefound']);
      }
      /* ... then check our lock on the season ticket is still
       valid. Note the negation '!' as lock() returns false on failure
       and we should return true on failure.*/
      return !seasontickets_lock($_SESSION['seasontickets_id']);
    }
  }
  return false; // no need to check the lock => success
}

?>
