<?php

require_once(FS_PATH . 'functions/tools.php');

  /** This function renders a seatmap and can be parametrised to
   display various information or controls on top. 

   $theatre: the id of the theatre to render.

   $zone: the name of the zone in that theatre to render, or null to
   render the 'null' zone

   $keycallback (): A function (presumably displaying a
   colour key or something) called before starting the seatmap if the
   zone contains at least one numbered seat.

   $seatcallback ($seatrecord): a function that renders one seat. It
   must produce a <td> object with rowspan=2.

   $unkeycallback (): a function called before displaying unnumbered
   seats if there's at least one of those.

   $unseatcallback ($cls, $cnt, $proto): a function that renders one
   class of unnumbered seats. $cls is the seat class identifier, $cnt
   is the number of seats in that class and $proto is the identifier
   of one such seat (preserved from one call to render_seatmap to the
   other)

  Returns: whether everything went well. */

function render_seatmap($theatre, $zone,
			  $keycallback,   $seatcallback,
			$unkeycallback, $unseatcallback) {
  global $lang;
/* seats to be displayed. The "sort by id" part is to guarantee that
   seats are always returned in the same order, which in turn is
   required to guarantee that the $proto map is always constructed the
   same way, which in turn is required to make sure a SESSION nn-
   entry is taken into account when redispaying seats.php */
  $table = false; // whether we've output a <table> yet.

  $proto = array(); // maps classes to PROTOtype unnumbered seat ids

  $x=0; /* Coordinates on the screen */
  $y=-1;

  /* from disableseats/index.php */
  //	$maxx = m_eval("select max(x) from seats where theatre=$theatre and zone=".quoter($zone));
  //	$maxlen = 2*$maxx+$even+3;    // calculate maxlen from result

  $maxlen=0; /* widest row so far, in table cells (seats have colspan=2). */
 
  /* If the theatre is "staggered" then $even goes
   true-false-true-false-···, otherwise it is false-false-false-···. */
  $even=false;
  $staggered_seating = is_staggered($theatre);
 
  if ($zone===null) {
    $zonetest = 'zone is null';
  } else {
    $zonetest = 'zone='.quoter($zone);
    echo "<h3>".htmlspecialchars($zone)."</h3>";
  }

  $allseats = mysql_query
    ("select id,row,col,x,y,class,extra from seats where theatre=$theatre and $zonetest order by y,x,id");

  /* No seats or problem obtaining them... */
  if (!$allseats) return false;

  $currseat = mysql_fetch_assoc($allseats);  
  while ($currseat) {
    if ($currseat['row']==-1) {
	/* unnumbered seat, put into proto */
	$proto[$currseat["class"]] = $currseat["id"]; 
      } else {
	/* numbered seat, show on seatmap */
	/* 1. check we have a <table> */
	if (!$table) {
	  /* this is the first (numbered) seat of the zone */
	  $keycallback();
	echo "<p class='main'><table style='margin: 0 auto;'>";
	  //echo "<p class='main'><table style='margin: 0 auto;'><tr><td colspan='100%' class='stage'><p class='big'><img src='/images/valkokangas.png' alt='".$lang["stage"]."'></p></td></tr>";
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

	  echo '<td class="whiteongrey">'.$lang['row'].' '.$currseat['row'];
	  if ($even) echo '<td>';
	  $x=0;
	}
	/* 3. move horizontally to the right position */
	if ($currseat['x']>$x) {
	  echo '<td class="whiteonblack" colspan="'.(2*($currseat['x']-$x)).'"></td>';
	}
	/* 4. Actually output the seat */
	$seatcallback($currseat);

	echo "</p></td>";
	$x=$currseat['x']+1;
      }
      $currseat = mysql_fetch_assoc($allseats);
    }

  if ($table) echo "</table>";

  /* Now show unnumbered seats. */
  $noheaderyet=true;

  /* How many seats of each class in that zone in that theatre */
  $classes = fetch_all(mysql_query("select class,count(*) as nnav from seats where theatre=$theatre and row=-1 and zone=".quoter($zone)." group by class"));
  if ($classes === false) {
    return false;
  }
  foreach ($classes as $l) {
    if ($noheaderyet) {
      $unkeycallback();
      $noheaderyet=false;
    }
    $cls = $l["class"];
    $unseatcallback($cls, $l['nnav'], $proto[$cls]);
  }
  return true;
}

?>
