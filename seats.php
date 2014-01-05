<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/seatmap.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: seats.php 298 2010-11-14 08:33:13Z tendays $*/

/** TODO - move mysql stuff into functions/seat.php, abstracting away
  from db details **/

function make_legend($numberedseats) {
// Construct a legend table showing only classes which exist in the seats table
// for the selected theatre, spectacle and zone, and display the normal 
// and reduced (if any) price in each box
  global $sh,$lang,$currency, $zone, $show_price;

	$criterion = ($numberedseats ? "row !=-1" : "row=-1" );

	// $cat_price = array(); // this is (was) just used to detect ...
                                 // ... whether price depends on class.

	$class_price = array(); // same, but for cat

	$q = "select distinct price.class, price.cat, price from price, seats where spectacle='".$sh["spectacleid"];
	$q .= "' and theatre='".$sh["theatre"]."' and price.class=seats.class and zone='".mysql_real_escape_string($zone)."' and $criterion order by class";

	$prices= array();

	//	$show_price= false; // set to true if prices depend on class
	$show_cat  = false;  // set to true if prices depend on cat

	if ($list = fetch_all(mysql_query($q))) {
	  foreach ( $list as $item ) {
	    $prices[$item['class']][$item['cat']] = $item['price'];

/* 	    if (!isset($cat_price[$item['cat']])) $cat_price[$item['cat']]=$item['price']; */
/* 	    else if ($cat_price[$item['cat']]!=$item['price']) $show_price=true; */

	    if (!isset($class_price[$item['class']])) $class_price[$item['class']]=$item['price'];
	    else if ($class_price[$item['class']]!='0') $show_cat=true;
	  }

	  echo "<h4>" . $lang[$numberedseats?"reserved-header":"nnseat-header"] . "</h4>";
	  
	  echo '<p class="main">' . $lang["legend"];

	  echo $lang[($show_price ? "diffprice" : "sameprice")];  
	  echo '</p><p class="main"><table border="1" cellpadding="5"><tr>';
	  if ($show_price && $show_cat) {
	    echo "<td align='center'>" . $lang["cat_normal"];
	    echo "<br>".$lang["cat_reduced"];	// don't display reduced prices if there aren't any
	  }

	  $class='default';

	  foreach ($prices as $class => $val) {

	    echo "<td class='cls$class' align='center'><p>";
	    if ($show_price) {
		echo $currency .' '. price_to_string($val[CAT_NORMAL]);
		echo '&euro;';
	      if ($show_cat) echo '<br>'.$currency .' '. price_to_string($val[((isset($val[CAT_REDUCED])) ? CAT_REDUCED : CAT_NORMAL)]);
	    } else {
	      echo $lang["class"].' '.$class;
	    }
	    echo "</p></td>";
	  }
	  /* don't display the free/occupied part for unnumbered seats */
	  if ($numberedseats) {
	    /* if there is only one class, use the color for that
	       class, otherwise show as orange */
	    if (count($prices)>1) $class = 'default';
	    echo "<td>".$lang["seat_occupied"]."</td><td class='stpaid' align='center'></td>";
	    echo "<td>".$lang["seat_free"]."</td><td class='cls$class' align='center'></td>";
	  }
	  echo "</tr></table></p>";
	} // else : don't output anything if there are no seats...
}

  /** print a form to let user pick unnumbered seats in the given
      zone. proto maps class numbers to seat ids with matching class
      and zone. **/
function unseatcallback($cls, $cnt, $proto) {
  global $sh, $lang, $show_price, $zone;

    /* How many are still available */
    $nnav = $cnt - m_eval("select count(*) from booking,seats where showid=".$sh["id"]." and row=-1 and state!=".ST_DELETED." and booking.seat=seats.id and zone='".mysql_real_escape_string($zone)."' and class=$cls");

    // fetch comment field from class_comment table and display it in the text
    // if blank show class number
    $comment= m_eval("select comment from class_comment where class=$cls and spectacle=".$sh["spectacleid"]);
    if ($comment==null) $comment = $lang["class"] . " $cls";
    if ($nnav == 1)
      printf('<p class="main">'.$lang["nnseat-avail"], $comment);
    else // $nnav != 1
      printf('<p class="main">'.$lang["nnseats-avail"],$nnav, $comment);
    if (isset($_SESSION["nncnt-".$proto])) $nncnt = (int)$_SESSION["nncnt-".$proto];
    else $nncnt=0;

    if ($nnav > 0) {
      // The following test will almost never be triggered because
      // load_seats bounds the nncnt (with a warning to the user).  It
      // may be triggered if a seat is booked/locked by someone else
      // between the call to load_seats above and the initialisation of $nnav
      if ($nncnt>$nnav) $nncnt = $nnav;
      echo "<input class='cls$cls' name='nncnt-".$proto."' value='$nncnt'>";
    }
    echo '</p>';
}

/** make_legend for numbered seats */
function keycallback() {
  make_legend(true);
}
/** renders one seat. */
function seatcallback($currseat) {
  global $sh;
  // in-session selected seats have already been checked and are
  // locked - so no need to check their state
  if (is_seat_checked($currseat['id'])) {
    $chkd = true;
    $st = ST_FREE;
  } else {
    $chkd = false;
    $st = get_seat_state($currseat['id'],$sh['id']);
  }

  if ($st==ST_DISABLED)
    $colour = "stdisabled";
  else
  if ($st!=ST_FREE)
	$colour = "stpaid";
  else
    $colour = "cls".$currseat['class'];

  echo "<td colspan='2' align='center' class='$colour'><p>";
  if (($st==ST_FREE) || ($st==ST_DELETED)) {
    echo '<input type="checkbox" name="'.$currseat['id'].'"';
    if ($chkd) echo ' checked="checked"';
    echo '><br>';
  }
  echo $currseat['col'];
}

/* make_legend for unnumbered seats. */
function unkeycallback() {
  make_legend(false);
}

/** functions end here **/

db_connect();

/* seat selection housekeeping */
  kill_booking_done();

  if (isset($_GET["showid"]) &&
      (!isset($_SESSION["showid"]) || 
       ($_SESSION["showid"] != (int)($_GET["showid"])))) {
    if (isset($_SESSION["seats"]))
      $prevSelected = $_SESSION["seats"];
    else
      $prevSelected = array();

    // We must unlock the seats before changing the show id otherwise the
    // thing will get confused.
    unlock_seats();
    $_SESSION["showid"] = (int)($_GET["showid"]);

    check_session(1); // check showid

    // note that if check_session fails then any previous seat selection
    // is lost.

    $sh = get_show($_SESSION["showid"]);
    /* The following call makes sure all seats are in the theatre
       corresponding to the current show, but not whether they're
       available. check_seats() below does that work. */
    load_seats($prevSelected);
    if (!check_seats())
      kaboom($lang["err_occupied"]);
    /* load_seats lost any existing category selection so we need to
       put it back. (Maybe that should be done by load_seats
       itself?) */
    compute_cats();

  } else { // showid unchanged

    check_session(1); // check showid
    $sh = get_show($_SESSION["showid"]);
	$spectacleid = $sh["spectacleid"]; // movie name
	$spec = get_spectacle($spectacleid);
    if (!check_seats())
      kaboom($lang["err_occupied"]);
  }

  /* Decide whether to show the prices or not (i.e. whether they
     depend on category or not) */

$show_price = price_depends_on_cat($sh["spectacleid"]);

show_head(true);

echo '<h2>'.$lang["err_checkseats"].'</h2>'; // not an error - lang item is a bit misnamed
echo '<p class="main">';
printf(htmlspecialchars($spec["name"]));
echo '</p><p class="main">';
show_show_info($sh);
echo '</p><p class="main">'.$lang["intro_seats"].'</p>';

do_hook("seatmap_top");

echo '<form action="pay.php" method="post">';
echo '<input type="hidden" name="load_seats">';

if ($sh["imagesrc"]!="") {
  echo '<img src="'.$sh["imagesrc"].'">';
}

/* Now display the seatmaps */

$zonelist = get_zones($sh['theatre']);

if ($zonelist) {
  foreach ($zonelist as $zone) {
    render_seatmap($sh['theatre'], $zone,
		   'keycallback', 'seatcallback',
		   'unkeycallback', 'unseatcallback');
  }
} else {
  // either the theatre has no seats or there was an error obtaining them.
  kaboom($lang['err_noseats']);
  $currseat = false;
}

echo '<input type="submit" value="'.$lang["continue"].'">';

echo '</form>';

show_foot(); ?>
