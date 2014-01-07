<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/shows.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info. 
$Id: repr.php 381 2012-03-27 01:26:42Z twowheeler $
*/

$allshown=false;

db_connect();

if ($take_down && !admin_mode()) fatal_error($take_down);

    /* Set the $spec and $spectacleid variables either according to
       GET, POST or SESSION: */

/* NOTE THAT if user comes here by post without having a session, and
   then reloads it with GET (i.e. presses enter in his browser address
   bar), then the site will complain about missing cookies. Oh well,
   user can go back to home page and click on the spectacle - that's
   not the end of the world */

$spec = null;

if (isset($_REQUEST["spectacleid"])) {
   $spectacleid = (int)($_REQUEST["spectacleid"]);
   $spec = get_spectacle($spectacleid);
} else if (isset($_SESSION["showid"])) {
  if ($sh = get_show($_SESSION["showid"])) {
    $spectacleid = $sh["spectacleid"];
    $spec = get_spectacle($spectacleid);
  }
} else fatal_error($lang["err_session"]); // unspecified spectacle

if (!$spec) fatal_error(); // e.g. trying to get a nonexistant spectacle

    /* Process POST requests */

// we detect a request for changing disabled status with the
//  "reset_disabled" POST variable.
// Just checking HTTP_REQUEST_METHOD would have been risky in case
//  the user drops on that page in POST mode - that would remove the
//  disabled flag everywhere.
if (admin_mode() && isset($_POST["reset-disabled"])) {
  $ok = true;
  $ss = get_shows("spectacle=$spectacleid");
  if ($ss) foreach ($ss as $sh)
    $ok &= mysql_query("update shows set disabled=".(isset($_POST["disable-".$sh["id"]])?1:0)." where id=".$sh["id"]);

  if ($ok)
    kaboom($lang["show_stored"]);
  else
    myboom($lang["err_connect"]); // couldn't update some show -
                                  // probably access right problem
}
/* note that we get_shows twice in case there was a POST. The goal is
   to have it immediately visible to the user in case there was a
   problem altering the "disabled" settings. */

//$c = get_config();
$ss = get_shows("spectacle=$spectacleid");
// and date_sub(concat(date,time),interval ".$c["closing"]." minute) > now();");

if ($ss===false)
     fatal_error($lang["err_connect"].mysql_error());
else if (!count($ss))
     fatal_error($lang["err_spectacleid"]); // spectacle exists but it
					    // has no shows
do_hook('repr_process');

show_head();

echo '<h2>';
printf($lang["showlist"],htmlspecialchars($spec["name"]));
echo '</h2>';

if (admin_mode())
     echo '<form action="repr.php" method="post"><input type="hidden" name="reset-disabled" value="on"><input type="hidden" name="spectacleid" value="'.$spectacleid.'">';

echo '<ul>';
foreach ($ss as $sh) {
  
  $remaining = show_closing_in($sh);
  
  /* total seats */
  $tot = m_eval("select count(*) from seats where theatre=".$sh["theatre"]);
  /* how many have been booked so far */
  $bk = m_eval("select count(*) from booking where showid=".$sh["id"]." and state!=".ST_DELETED);
  /* how many are disabled (included in above counts) */
  $ds = m_eval("select count(*) from booking where showid=".$sh["id"]." and state=".ST_DISABLED);

  // in progress   $bkds = m_eval($q="select *,1 as cnt,$cat as cat,seats.id as id from seats left join booking on booking.seat=seats.id and booking.showid=$showid and booking.state!=".ST_DELETED.
  //	   " where booking.id is null"));

  if (($tot===null) ||
      ($bk===null)  ||
      ($ds===null)) {
    $tot="??";
    $bk="??";
  } else {
    /* note that we assume there aren't two non-deleted bookings for
       the same seat, same show, same spectacle, otherwise things get
       funky */
    $tot -= $ds;
    $bk -= $ds;
    // disable the book button if there are no free seats left
    if ($bk >= $tot)  // (Heh - what would it mean if it were strictly bigger?) :-)
      $remaining = 0;
  }
  
if(isset($_GET['nohide'])) {
   $allshown=true;
}
  
  if ($remaining<=0 && admin_mode() && $allshown)
    echo "<li><p class='disabled'>";
  elseif ($remaining>0)
    echo "<li><p>";
  
  if ($remaining>0 && admin_mode())
    echo "($bk/$tot) [<a href='bookinglist.php?showid=".$sh["id"]."'>".$lang["link_bookinglist"]."</a>] ";
	
  if ($remaining<=0 && admin_mode() && $allshown)
    echo "($bk/$tot) [<a href='bookinglist.php?showid=".$sh["id"]."'>".$lang["link_bookinglist"]."</a>] ";

  if ($remaining>0 || admin_mode() && $allshown)
    echo "[<a href='seats.php?showid=".$sh["id"]."'>".$lang["book"]."</a>]";
  else
  if (admin_mode()) {
  echo "[".$lang["closed"]."]";

  if (admin_mode()) echo ' [<input type="checkbox" name="disable-'.$sh["id"].($sh["disabled"]?'" checked>':'">').$lang["disabled"].']';
  }

  if ($remaining>0) {
	echo ' : ';
	show_show_info($sh,false);
  } elseif (admin_mode() && $allshown) {
	echo ' : ';
	show_show_info($sh,false);
	}

  if ($remaining<=0 && admin_mode() && $allshown)
    echo " (".$lang["book_adminonly"].")";
    
  echo "</p>\n";
}

?>

</ul>

<?php

do_hook('repr_display');
if (admin_mode()) echo '<input type="submit" value="Save changes"></form>';

echo '<p class="main">';
printf($lang["backto"],'[<a href="index.php">'.$lang["link_index"].'</a>]');
echo '</p>';

show_foot(); ?>
