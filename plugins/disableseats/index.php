<?php

define ('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/seatmap.php");
require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 twowheeler. See COPYING for
copying/warranty info.

$Id: seats.php 277 2010-10-30 10:49:31Z tendays $*/

/*
A seatmap display with checkboxes to select seats to be disabled.  
*/
function disableseats_summarize( $zone ) {
	// Returns an array with number of seats, total and disabled, 
	// by class, for the zone $zone. We will call this only once per zone.
	// $cls == 0 is the total for all classes
  global $sh;
	$counts = array('total' => array(0,0,0,0,0),
                 'disabled' => array(0,0,0,0,0));
	$theatre = $sh['theatre'];
	for ($cls = 1; $cls <= 4; $cls++ ) {
	    $counts['total'][$cls] = m_eval("select count(*) from seats where theatre=$theatre and class=$cls and zone='$zone'");
	    $counts['total'][0] += $counts['total'][$cls];
	    $counts['disabled'][$cls] = m_eval("select count(*) from booking,seats where showid=".$sh["id"]." and row!=-1 and class=$cls and state=".ST_DISABLED." and booking.seat=seats.id and zone='$zone'");
	    $counts['disabled'][0] += $counts['disabled'][$cls]; 
	}
	return $counts;
}

function disableseats_seat($currseat) {
  global $sh;
    /* 4. Actually output the seat */
    // colours are based on class, and disabled seats are checked
    $st = get_seat_state($currseat['id'],$sh['id']);
    $colour = "cls".$currseat['class'];  
    echo "<td colspan='2' align='center' class='$colour'><p>";
    if (($st==ST_FREE) || ($st==ST_DELETED) || ($st==ST_DISABLED)) {
      echo '<input type="checkbox" name="'.$currseat['id'].'"';
      if ($st==ST_DISABLED) echo ' checked="checked"';
      echo '><br>';
    }
    echo $currseat['col'] . "</p></td>";
}

/** functions end here **/

db_connect();

ensure_plugin("disableseats");

if (!admin_mode()) {
  kaboom($lang["access_denied"]);
  show_head(true);
  show_foot();
  exit;
}

function disableseats_key() {
  global $zone;
    $counts = disableseats_summarize($zone);  // calculates all totals at once for this zone
    // output a summary table
    echo '<p class="main"><table border="1">';
    echo '<th colspan="2" style="text-align: center; font-weight:bold;">Summary</th>';
    for ($cls = 0; $cls<5; $cls++) {
      if ($cls) {
        if ($counts['total'][$cls]) {
          echo "<tr><td>Total class $cls seats = ". $counts['total'][$cls] . "    <td>";
          echo "Disabled class $cls seats = ". $counts['disabled'][$cls] . "</tr>";
        }
      } else {
        echo "<tr><td>Total seats = " . $counts['total'][$cls] . "    <td>";
        echo "Disabled seats = " . $counts['disabled'][$cls] . "</tr>";
      }
    } 
    echo "</table></p>";
}

function disableseats_unkey() {}
function disableseats_unseat($a, $b, $c) {}

kill_booking_done();
unlock_seats(false);
if (isset($_GET["showid"])) {
  $_SESSION["showid"] = (int)($_GET["showid"]);
  $sh = get_show((int)($_GET["showid"]));
} else {
   kaboom($lang["err_showid"]);
   $sh = false;
 }

if ($sh === false) fatal_error();
check_session(1);

if (isset($_POST["load_seats"])) {
  // We are re-entering with a seat selection here.
  //  This code follows an abbreviated booking process 
  //  with no consideration of prices, payments, etc
  //  to create "bookings" for seats we want to disable.

  if (!load_seats($_POST,FALSE)) {
    kaboom("Failed to find seats, please try again");
  } else {
    
    // first mark as deleted all current disabled seat records for this show
    $bs = get_bookings("booking.showid=".$_SESSION["showid"]." and booking.state=".ST_DISABLED);
    foreach ($bs as $n => $b) 
      set_book_status($b,ST_DELETED);    
    
    // if any seats were selected, create session variables
    if (isset($_SESSION["seats"])) {
      $_SESSION["payment"]=PAY_OTHER;
      $_SESSION["firstname"] = "Disabled";
      $_SESSION["lastname"] = "Seat";
      foreach (array("phone","email","address","postalcode","city","us_state","country") as $a) {
        $_SESSION[$a] = "";
      }
      // make the bookings by calling book()
      foreach ($_SESSION["seats"] as $n => $s) {
	// (tendays) force selected seats to be in state disabled at
	// booking time.
	$s['state'] = ST_DISABLED;
        if (($bookid = book($_SESSION,$s))!==false) {
          $_SESSION["seats"][$n]["bookid"] = $bookid;
          if (!(isset($_SESSION["groupid"]) && $_SESSION["groupid"]!=0))
            $_SESSION["groupid"] = $bookid;
        }
      }
      // now we set_book_status() to disabled
      $_SESSION["booking_done"] = ST_DISABLED;
    }  // if no seats are selected, just report success
    kaboom($lang['show_stored']);
  }
}

show_head(true);

echo '<h2>'.$lang["disableseats"].'</h2><p class="main">';
show_show_info($sh,false);
echo '<form action="index.php?showid='.$_SESSION["showid"].'" method="post">';
echo '<input type="hidden" name="load_seats">';

if ($sh["imagesrc"]!="") {
  echo '<img src="'.$sh["imagesrc"].'">';
}

/* Now display the seatmaps */

$zonelist = get_zones($sh['theatre']);
if ($zonelist) {
  foreach ($zonelist as $zone) {
    
    render_seatmap($sh['theatre'], $zone,
		   'disableseats_key', 'disableseats_seat',
		   'disableseats_unkey', 'disableseats_unseat');
  }
} else {
  // either the theatre has no seats or there was an error obtaining them.
  kaboom($lang['err_noseats']);
  $currseat = false;
}

echo '<input type="submit" value="'.$lang["save"].'">';

echo '</form>';

echo '<p class="main">';
printf($lang["backto"],'[<a href="'.FS_PATH.'seats.php?showid='.$_SESSION['showid'].'">'.$lang["link_seats"].'</a>]');
echo '</p>';

show_foot(); 
?>
