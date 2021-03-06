<?php

define ('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: seats.php 277 2010-10-30 10:49:31Z tendays $*/

/** TODO - move mysql stuff into functions/seat.php, abstracting away
  from db details **/
/*
Incorporates javascript tooltips for displaying reservation details 
on the booking map.  Source: http://www.walterzorn.com
*/
function print_end_zone() {
  global $table, $lang, $maxlen;
  if ($table) echo "</table>";
}

/** functions end here **/

db_connect();

ensure_plugin("bookingmap");

if (!admin_mode()) {
  kaboom($lang["access_denied"]);
  show_head(true);
  show_foot();
  exit;
}

if (isset($_GET["showid"]))
  $sh = get_show((int)($_GET["showid"]));
 else {
   kaboom($lang["err_showid"]);
   $sh = false;
 }

if ($sh === false) fatal_error();

/* prepare seatmap */
/* The (false) zone is one that doesn't exist, as opposed to the
 (null) zone which is the zone of seats for which the "zone" attribute
 is not set. So as soon as we encounter a seat, whether its "zone" is
 set or not, we will start a new zone. */
$zone = false;
$table = false; // whether we've output a <table> for that zone yet.
/* If the theatre is "staggered" then $even goes
   true-false-true-false-���, otherwise it is false-false-false-���. */
$staggered_seating = is_staggered($sh["theatre"]);
//$y=0;

/* seats to be displayed. The "sort by id" part is to guarantee that
   seats are always returned in the same order, which in turn is
   required to guarantee that the $proto map is always constructed the
   same way, which in turn is required to make sure a SESSION nn-
   entry is taken into account when redispaying seats.php */
if ($allseats = mysql_query("select id,row,col,x,y,class,zone,extra from seats where theatre=".
		       $sh["theatre"]." order by zone,y,x,id")) {
    $currseat = mysql_fetch_assoc($allseats);
} else {
  // either the theatre has no seats or there was an error obtaining them.
  kaboom($lang['err_noseats']);
  $currseat = false;
}

show_head(true);
// the following is used to show tooltips on the map. The
// documentation says it should be right at the beginning of the
// <body> but the freeseat api doesn't let us do that. It seems to
// work anyway.
?> <script type="text/javascript" src="<?php echo FS_PATH; ?>plugins/bookingmap/wz_tooltip.js"></script> <?php

echo '<h2>'.$lang["bookingmap"].'</h2><p class="main">';
show_show_info($sh,false);
// echo '</p><div class="popupbox"></div><p class="main"><ul><li><p>';
echo '<p class="main"><ul><li><p>';
printf($lang["seeasalist"],'[<a href="'. FS_PATH .'bookinglist.php?showid='.$sh['id'].'&sort=lastname">','</a>]');
echo '</p><li><p>';
printf($lang["bookagain"],'[<a href="'. FS_PATH .'seats.php?showid='.$sh['id'].'">','</a>]');
echo '</p></ul></p><table><tr><td><p class="main">';
echo $lang["legend"];
echo '</p>';
  
for ($i=0;$i<7;$i++) {
  echo "<td class='".state2css($i)."'><p>".f_state($i)."</p>";
 }
  
echo "</table>";


if ($sh["imagesrc"]!="") {
  echo '<img src="'.$sh["imagesrc"].'">';
}

/* Now display the seatmaps */

while ($currseat) {
  if ($zone !== $currseat['zone']) {
    if ($zone !== false) print_end_zone();
    $zone = $currseat['zone'];
    if ($zone) echo "<h3>".htmlspecialchars($zone)."</h3>";
    $table = false;
  }

  if ($currseat['row'] != -1) {
    /* numbered seat, show on seatmap */
    /* 1. check we have a <table> */
    if (!$table) {
      /* this is the first (numbered) seat of the zone */
      echo "<p class='main'><table class='seatmap' border='1'><tr><td colspan='100%' align='center'><h4>".$lang["stage"]."</h4></tr></td>";
      $x=0;
      $y=-1;
      $even=false; //$staggered_seating;
      $maxlen=0;
      $table = true;
    }

    /* 2. check we're on the right row */
    if ($currseat['y']>$y) {
      if ($maxlen < $x*2+$even+1) $maxlen = $x*2+$even+1;
      /* this seat starts a new row */
      while ($currseat['y']>$y) {
	$y++;
	echo '<tr class="seatmap">';
	$even ^= $staggered_seating;
      }

      echo '<td>'.$lang['row'].' '.$currseat['row'];
      if ($even) echo '<td>';
      $x=0;
    }
    /* 3. move horizontally to the right position */
    if ($currseat['x']>$x) {
      echo '<td colspan="'.(2*($currseat['x']-$x)).'"></td>';
    }
    /* 4. Actually output the seat */
    // in-session selected seats have already been checked and are
    // locked - so no need to check their state

    $st = get_seat_state($currseat['id'],$sh['id']);
    
    $colour = state2css($st);
    echo "<td colspan='2' align='center' class='$colour'><p>"; //<a class='popup' href='#'>";

    // begin tooltip code
    $text = '\'<b>'.$lang["row"].'</b>: '.$currseat['row'];
	$text .= ' <b>'.$lang["col"].'</b>: '.$currseat['col'].' ( '.$currseat["zone"].' '.$currseat["extra"].' )';
	$text .= ' <b>'.$lang["class"].'</b>: '.$currseat["class"];
	if ($st==ST_LOCKED)	
		$text .= '<br><b>'.$lang["state"].'</b>: '.f_state($st);
	else if (($st!=ST_FREE) && ($st!=ST_DELETED)) {
		$bk = get_bookings("seat=".$currseat["id"]." and state!=".ST_DELETED." and showid=".$sh['id']);
		if ($bk[0]) {
			$text .= '<br><b>'.$lang["bookid"].'</b>: '.$bk[0]["bookid"];
			$text .= ' <b>'.$lang["cat"].'</b>: '.f_cat($bk[0]["cat"]);
			$text .= ' <b>'.$lang["state"].'</b>: '.f_state($st);
			$text .= ' <b>'.$lang["payment"].'</b>: '.f_payment($bk[0]["payment"]);
			$text .= '<br><b>'.$lang["email"].'</b>: '.$bk[0]["email"];
			$text .= ' <b>'.$lang["phone"].'</b>: '.$bk[0]["phone"];
			$text .= '<br><b>'.$lang["name"].'</b>: '.$bk[0]["firstname"].' '.$bk[0]["lastname"];
			$text .= ' <b>'.$lang["timestamp"].'</b>: '.$bk[0]["timestamp"];	
		}
	}
	$text .= '<br>\'';
	echo '<a name="tip" onmouseover="Tip('.$text.')" href="#">';
	echo $currseat['col'];
	// end tooltip code

    echo "</a></p></td>";
    $x=$currseat['x']+1;
  }
  $currseat = mysql_fetch_assoc($allseats);
 }

if ($zone !== false) print_end_zone();

show_foot(); ?>
