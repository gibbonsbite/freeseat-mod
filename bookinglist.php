<script src="jquery/jquery.min.js"></script>
<script src="js/checkall.js"></script>
<?php

/**                               **\
  *  Booking list administration  *
\**                               **/

/** we can be in one of three states:

1 - entry state, we do nothing and display the full list to the user
2 - confirmation state, we do nothing but display a confirmation
message to the user
3 - action state, we run user's request and then act like in state 1.

1 has no session data and no input
2 receives an action request and moves it into session data
3 receives a confirmation message and acts whatever is in session
data, then destroys session data.

Copyright (C) 2010 Maxime Gamboni. See COPYING for copying/warranty
info.

$Id: bookinglist.php 385 2012-03-28 01:00:34Z twowheeler $

**/

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/booking.php");
require_once (FS_PATH . "functions/configuration.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/money.php");
require_once (FS_PATH . "functions/shows.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/seat.php");
require_once (FS_PATH . "functions/send.php");
require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "functions/spectacle.php");

db_connect();

if (!admin_mode()) {
  kaboom($lang["access_denied"]);
  show_head(true);
  show_foot();
  exit;
}

prepare_log("booking administration");

/* READ FILTER PARAMETERS

 either from GET (when filter settings changed) or from POST (previous
 filter settings carried through form submission) */

$params = array();
foreach (array("offset",/*"from","to",*/"st","showid","sort") as $n => $f) {
  if (isset($_GET[$f]))
      $params[$f] = nogpc($_GET[$f]);
  else if (isset($_POST[$f]))
      $params[$f] = nogpc($_POST[$f]);
  // note - the default values are null, not empty strings !
}

$c = get_config();
 /*  $spectacleid = $c["spectacleid"]; */

/* These are actually set while printing page list because here we
don't yet know what the default value should be */
// $filterfrom = null;
// $filterto = null;

if (isset($params["sort"]) && ($params["sort"] == "email" || $params["sort"] == "lastname"))
  $orderby = $params["sort"];
else
  $orderby = "id";

// "selected offset", affects displayed bookings. Don't mistake with
// $coffset which is used in a loop for pagelist.
if (isset($params["offset"]))
  $soffset = (int)$params["offset"];
else
  $soffset = 0;
   
/* valid values for $filterst are 0 (means show everything)
 * -ST_DELETED (means everything except deleted)
 * ST_BOOKED (means booked or shaken but not paid)
 * ST_DELETED (means show only deleted)
 * ST_DISABLED (means not available)
 * ST_PAID (means paid) */
if (isset($params["st"]))
  $filterst = (int)($params["st"]);
else
  $filterst = 0;

if (isset($params["showid"]))
  $filtershow = (int)($params["showid"]);
else
  $filtershow = null;

/** DONE WITH parsing filter parameters */

/* Now see if we have a command to execute */

/** First see if bookings were selected */
$ab = array();
foreach ($_POST as $key => $value) {
  if (is_numeric($key)) {
    $ab[] = get_booking((int)$key);
  }
}

$setstate = 0;
if (isset($_POST["setstate"]) && (($_POST["setstate"] == ST_DELETED) || ($_POST["setstate"] == ST_PAID))) {
  $setstate = (int)$_POST["setstate"];
  //start_notifs();

  foreach($ab as $book) {
    set_book_status($book,$setstate);
  }

  //send_notifs($setstate);
  $setstate = 0;
 } else if (isset($_POST["confirm"])) {
  $setstate = ST_PAID;
 } else if (isset($_POST["delete"])) {
  $setstate = ST_DELETED;
 }

do_hook('bookinglist_process');

show_head(true);

/* echo '<pre>_POST='; // DEBUG
print_r($_POST); // DEBUG
echo "setstate=$setstate\n"; // DEBUG
echo "ab=\n"; // DEBUG
print_r($ab); // DEBUG
echo '</pre>'; */  // DEBUG

if ($setstate && (count($ab)>0)) { // state 2
  $checkboxes=false; // i.e. select everything on screen
  echo '<h2>';
  printf($lang["check_st_update"],($setstate==ST_DELETED)?$lang["DELETE"]:$lang["acknowledge"]);
  echo '</h2>';
} else { // state 1 or 3
  $setstate = 0;
  $checkboxes=true;

  ?>
 <form action="bookinglist.php" method="GET" name="filterform">
 <p class="main"><?php echo $lang["filter"];?>
 <select name="st" onchange="filterform.submit();">
<?php //'
  foreach (array(-ST_DELETED => "st_notdeleted",
		 ST_BOOKED => "st_tobepaid",
		 ST_PAID => "st_paid",
		 ST_DELETED => "st_deleted",
		 ST_DISABLED => "st_disabled",
		 0 => "st_any") as $opt => $lab) {
    echo '<option value="'.$opt.'" ';
    if ($filterst==$opt) echo "selected ";
    echo '>'.$lang[$lab].'</option>';
  }
?>
</select>
 <?php
    $ss = get_shows(); //"spectacle=$spectacleid");
 // and date_sub(concat(date,time),interval ".$c["closing"]." minute) > now();");
 if ($ss) {

   echo '<select name="showid" onchange="filterform.submit();">';
   echo '<option value="">'.$lang["show_any"].'</option>';
   foreach ($ss as $sh) {
     echo '<option value="'.$sh["id"].'"';
     if ($filtershow==$sh["id"])
       echo 'selected >';
     else
       echo '>';
     show_show_info($sh,false);
     echo '</option>';
   }
   echo '</select> ';
 } else echo mysql_error();
 echo '<select name="sort" onchange="filterform.submit();">';

 foreach (array("id","email","lastname") as $h) {
   echo "<option value='$h' ";
   if ($orderby==$h) echo "selected";
   echo '>';
   printf($lang["orderby"],$lang[$h]);
   echo '</option>';
 }
 echo '</select> <input type="submit" value="'.$lang["update"].'"></form></p>';

/** BUILD QUERY ACCORDING TO filter settings **/

$and = ""; // set to "and" once $cond is non empty
$cond = "";

 if ($filtershow) {
   $cond .= " $and showid=$filtershow";
   $and = "and";
 }

 switch ($filterst) {
 case ST_BOOKED:
   $cond .= " $and (state=".ST_BOOKED." or state=".ST_SHAKEN.")";
   $and = "and";
   break;
 case ST_PAID: case ST_DELETED: case ST_DISABLED:
   $cond .= " $and state=$filterst";
   $and = "and";
   break;
 case 0:
   $cond .= " $and (state=".ST_BOOKED." or state=".ST_SHAKEN." or state=".ST_PAID." or state=".ST_DELETED.")";
   $and = "and";
   break;
 default: //  -ST_DELETED
   $cond .= " $and (state=".ST_BOOKED." or state=".ST_SHAKEN." or state=".ST_PAID.")";
   $and = "and";
 }

/** Print page list **/
 $firstloop=true;

 // "current offset", changes while looping through pagelist
 $coffset = 0;

 // echo "<p>$cond</p>"; // DEBUG

 $prevz = null; // value of $z in the previous loop
 $closing = ''; // what to print to close previous page link
 $subpage = 1; // if there's many links with same label we display
	       // them as a/1, a/2, a/3, etc, b/1, b/2, etc, c, d, etc
	       // and $subpage indicates /number.

 if ($cond) $condAnd = "$cond and"; else $condAnd = "";
 $slice = get_slice($orderby,$cond,$coffset);
while ($slice !== false) {
  list($a,$z)=$slice;
  if ($orderby!="id") {
    $a=$a{0};
    $z=$z{0};
  }
  if ($firstloop) {
    echo '<p>'.$lang[$orderby].'&nbsp;: ';
    $firstloop = false;
  }

  if (trim($a)=="") $a='<i>'.$lang["none"].'</i>';
  if (trim($z)=="") $z='<i>'.$lang["none"].'</i>';

  /** Print and calculate /subpagenumbers **/

  if ($a == $prevz || $subpage>1) echo "<span class='subpage'>$subpage</span>";
  echo $closing; // close previous link

  if ($a == $prevz)
    $subpage ++;
  else
    $subpage = 1;

  if ($soffset == $coffset) {
    echo "(";
    $closing = ") ";
  } else {
    echo "[<a href='bookinglist.php?offset=$coffset&amp;st=$filterst&amp;showid=$filtershow&amp;sort=$orderby'>";
    $closing = "</a>] ";
  }
  if ($a != $z) {
    echo ($subpage>1)? "$a<span class='subpage'>$subpage</span>-$z": "$a-$z";
    $subpage=1;
  } else {
    echo "$z";
  }

  $prevz = $z;
  $coffset += $bookings_on_a_page;
  $slice = get_slice($orderby,$cond,$coffset);
}

/* See if last link needed a /pagenumber */
 if ($subpage>1) echo "<span class='subpage'>$subpage</span>";
 echo $closing; // close last link
 if (!$firstloop) echo "</p>"; // There was at least one page

 echo '<input type="hidden" name="resetab" value="kaboom">';
 
 $ab = get_bookings($cond,($orderby=="id"?"bookid":"$orderby,bookid"),$soffset,$bookings_on_a_page);
 if (!$ab) kaboom(mysql_error());
} // end of state 1 or 3

/* At this point $ab contains the possibly (state2) partial booking
list that is to be displayed to the user */

?>

<form action="bookinglist.php" method="post">
<!-- default action : just save notes. Does not need any visible button -->
<input type="hidden" name="save">

<?php
/* this is to persist filter settings accross links. We DON'T use
 session variables so that e.g. using "back" will work as expected,
 so that many views can be opened simultaneously, so that starting
 from main page will always show default view etc etc */

foreach (array("offset","st","showid","sort") as $n => $f) {
  if (isset($params[$f]))
    echo "<input type='hidden' name='$f' value='".htmlspecialchars($params[$f],ENT_QUOTES)."'>";
}

if ($setstate) echo '<input type="hidden" name="setstate" value="'.$setstate.'">';

if ($ab) {

  /* count does not work - we would like to take all pages into account .. */
  //  echo "<p class='main'>Nombre d'entr�es&nbsp;: ".count($ab)."</p>";

  $total = 0; // total price of displayed elements

  $html = array(); // maps states to the html for bookings in said states.

  foreach ($ab as $b) {
    $id = $b['bookid'];
    $st = $b['state'];

    if (!isset($html[$st])) {
      /* Make a header if this is the first booking in that state */
      $html[$st] = '<tr><td colspan=9><p class="main">';
      $html[$st] .= sprintf($lang["booking_st"],'<b>'.f_state($st).'</b>');
      $html[$st] .= '</p>';
    }
      
    $html[$st] .= '<tr><td>';
    $itemprice = get_seat_price($b);
    if ($st!=ST_PAID) $total += $itemprice;
    if ($checkboxes) {
      if (($filterst==ST_DELETED) || ($st!=ST_DELETED))
	$html[$st] .= '<input type="checkbox" class="chkboxes" name="'.$id.'">';
    } else {
      // when no checkboxes we secretly check them all
      $html[$st] .= '<input type="hidden" name="'.$id.'">';
    }
    $html[$st] .= $id.'<td bgcolor="#ffffb0"><a href="seats.php?showid='.$b['showid'].'&amp;bookinglist">'.
      $b['date'].' '.f_time($b['time']).
      // check for -1: don't display row/col information for
      // unnumbered seats.
      '</a><td>'.($b['row']==-1? '': htmlspecialchars($b['col']).', '.$lang["row"].' '.htmlspecialchars($b['row']).' ').
      '<td bgcolor="#ffffb0">'.f_cat($b['cat'])." (".price_to_string($itemprice).")".
      '<td>'.$b['firstname'].' <i>'.$b['lastname'].'</i>'.
      '<td bgcolor="#ffffb0">'.f_mail($b['email']).
      '<td>'.$b['phone']."\n".
      '<td bgcolor="#ffffb0">';
    if (($st==ST_BOOKED) || ($st==ST_SHAKEN)) {
      if ($b['payment']==PAY_CCARD)
	$exp = strtotime($b['timestamp'])+86400*$c["paydelay_ccard"];
      else if ($b['payment']==PAY_POSTAL)
	$exp = sub_open_time(strtotime($b['timestamp']),-86400*$c["paydelay_post"]);
      else {
	$exp = FALSE;
	$html[$st] .= '<i>'.$lang["none"].'</i>';
      }
      if ($exp !== FALSE) {
	$delta = $exp-$now; // ($now=time() is in tools.php)
	//	echo date("D d F H:i",$exp); // DEBUG

	if ($delta<0)
	  $html[$st] .= $lang["expired"];
	else if ($delta < 5400)
	  $html[$st] .= sprintf($lang["in"],((int)($delta/60)).' '.$lang["minute"]);
	else if ($delta < 129600)
	  $html[$st] .= sprintf($lang["in"],((int)($delta/3600)).' '.$lang["hour"]);
	else
	  $html[$st] .= sprintf($lang["in"],((int)($delta/86400)).' '.$lang["day"]);
      }
    } else $html[$st] .= '<i>'.$lang["none"].'</i>';

    $html[$st] .= do_hook_concat('bookinglist_tablerow',$b);
  }

  /** WARN - update colspan=9 where needed if you change columns **/
  $headers = '<tr><th>'.$lang["bookid"].
    '<th>'.$lang["date"].      '<th>'.$lang["col"].
    '<th>'.$lang["cat"].       '<th>'.$lang["name"].
    '<th>'.$lang["email"].     '<th>'.$lang["phone"].
    '<th>'.$lang["expiration"]. do_hook_concat('bookinglist_tableheader');

  echo '<table cellspacing=0 cellpadding=4 border=0 class="bookinglist">'.$headers;

  /* Foreaching on the states rather than on $html itself to preserve
   state ordering */
  foreach (array(ST_BOOKED, ST_SHAKEN, ST_PAID, ST_DELETED, ST_DISABLED) as $st) {
    if (isset($html[$st])) echo $html[$st];
  }

  echo $headers.'</table>';

  if ($checkboxes) {
    if ($filterst != ST_DELETED) {
	  echo'<input type="checkbox" class="chkall" label="check all"  />Valitse kaikki';
      echo '<ul><li><p class="main">'.$lang["set_status_to"];
      echo '<input type="submit" name="confirm" value="'.$lang["acknowledge"].'"> ';
      echo '<input type="submit" name="delete" value="'.$lang["DELETE"].'"> ';
    }
    do_hook('bookinglist_pagebottom');
    echo "</ul>";
      ?>
<?php } else {
  if ($setstate==ST_PAID) {
    $paid=1;
	global $paid;
    echo '<p class="main">'.$lang["total"].'&nbsp;:'.price_to_string($total).'</p>';
	}

  if ($paid!=1) echo '<p class="main"><input type="submit" value="'.$lang["confirmation"].'">';
  do_hook('bookinglist_process'); // When admin presses print, bookings are confirmed
  do_hook('bookinglist_pagebottom');
  echo '<a href="bookinglist.php';
  $sep = "?"; // what comes between params
  foreach (array("offset","st","showid","sort") as $n => $f) {
    if (isset($params[$f])) {
      echo "$sep$f=".htmlspecialchars($params[$f],ENT_QUOTES);
      $sep = "&amp;";
    }
  }
  echo '"> <p class="main">'.$lang["cancel"].'</a></p>';
}
  
} else {
  echo '<p class="warning">'.$lang["warn-nomatch"].'</p>';
}

echo '<p class="main">';
if (admin_mode()) printf($lang["backto"],'[<a href="http://www.studiot123.com/listreserve/">'.$lang["link_showlist"].'</a>]');
if (!admin_mode()) printf($lang["backto"],'[<a href="http://www.studiot123.com">'.$lang["link_index"].'</a>]');
echo '</p></form>';

show_foot();

?>
