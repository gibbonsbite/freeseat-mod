<?php

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id$

Price calculation functions
*/

/* Basic principle for handling money in FreeSeat: all amounts are
   whole numbers, in units of 1/$moneyfactor $currency, e.g. cents or
   pennies.

   When displaying an amount to the user, when sending it to credit
   card processor, etc, call price_to_string (which divides by
   $moneyfactor).

   When receiving an amount from the user or credit card processor
   etc, call string_to_price (which multiplies by $moneyfactor).

   The above principle holds for the database as well, all money
   amounts in the database are in units of 1/$moneyfactor $currency,
   so you do NOT convert at the time of writing to or reading the
   database. */

/** Convert a price to a string suitable for displaying to the user or
    exporting to external web services. Note that $currency is not
    appended to the returned string */
function price_to_string($price) {
    global $moneyfactor;

//    return number_format((round($price))/$moneyfactor,2,'.','');
	setlocale(LC_MONETARY,"en_US");
	return money_format("%!.2n EUR", (round($price))/$moneyfactor);
}

/** Convert a string representing an amount of $currency (eg "43.99")
    to a price amount suitable for computation and storage into the
    database. */
function string_to_price($price) {
    global $moneyfactor;
 
    return round(((real)$price)*$moneyfactor);
}

/** returns the cost of the given booking **/
// TODO check the FALSE return value now and then - we don't want to
// give away free seats whenever something goes wrong :-)
function get_seat_price($seat) {
  global $lang;
  /* First let plugins provide a price. */
  $result = do_hook_function('get_seat_price', $seat);
  if ($result !== null) {
    return $result;
  }
  if ($seat["cat"] == CAT_FREE) return 0;

  $z = mysql_query("select price from price where spectacle=".$seat["spectacleid"]." and cat=".$seat["cat"]." and class=".$seat["class"]);
  if ($z) $z = mysql_fetch_assoc($z);
  if ($z) return $z["price"];
  else {
    myboom($lang["err_price"]);
    return FALSE;
  }

}

/** get show prices in an array. $result being the returned array,
   $result[$class][$cat] gives the price for category $cat and seat
   class $class  */
function get_spec_prices( $spec ) 
{
	if ($result = mysql_query("SELECT cat, class, price from price " . 
		"where spectacle=$spec order by class, cat desc")) {
		$p = fetch_all($result);
		$prices = array();
		foreach ( $p as $item ) 
			$prices[$item['class']][$item['cat']] = $item['price'];
	} else {
		kaboom(mysql_error());
		return false;
	}
	if ($result = mysql_query("SELECT class, comment from class_comment where spectacle=$spec")) {
		$p = fetch_all($result);
		foreach ($p as $item ) 
			$prices[$item['class']]['comment'] = $item['comment'];
	}
	return $prices;
}

/** Record the given prices and class comments into the price table,
   removing pre-existing prices if necessary. $spec is a spectacleid
   and $prices is an array of the format returned by
   get_spec_prices. */
function set_spec_prices( $spec, $prices ) {
    for ( $i=1; $i<=4; $i++ ) { // class loop
	for ( $j=CAT_NORMAL; $j>=CAT_REDUCED; $j-- ) { // cat loop
	    $p = $prices[$i][$j];
	    $q = "DELETE from price where cat=$j and class=$i and spectacle=$spec";
	    if (! mysql_query( $q ) ) {
		// Fail if there was an error removing the previous
		// price. Note that mysql_query does *not* return a failure
		// code if there was no pre-existing price, so we're good.
		myboom("Error deleting previous price for cat=$j, class=$i.");
	    } else {
		if (!mysql_query("INSERT into price (spectacle, cat, class, price) values ($spec, $j, $i, $p)"))
		    myboom("Error setting price for cat=$j, class=$i.");
	    }
	}
	if (isset($prices[$i]['comment'])) {
	    if (! mysql_query("DELETE from class_comment where class=$i and spectacle=$spec")) {
		myboom("Error deleting previous price comment for cat=$j, class=$i.");
	    } else {
		if ($prices[$i]['comment']!='') {
		    if (! mysql_query
			("INSERT into class_comment (spectacle, class, comment) values ($spec, $i, '"
			 .mysql_real_escape_string($prices[$i]['comment'])."')")) {
			myboom("Error setting price comment for cat=$j, class=$i.");
		    }
		}
	    }
	}
    }
    return true;
}

/** Compute the tax for Swiss "CCP" money transfer. Accurate as of
   October 2010. */
function postaltax($amount) {
  global $moneyfactor;
    if ($total ==  0) return 0;
    else if ($total <= 50*$moneyfactor) return 1.50*$moneyfactor;
    else if ($total <= 100*$moneyfactor) return 1.80*$moneyfactor;
    else if ($total <= 1000*$moneyfactor) return 2.35*$moneyfactor;
    else if ($total <= 10000*$moneyfactor) return 3.55*$moneyfactor;
    else {
	kaboom($lang["err_postaltax"]);
	return 3.55*$moneyfactor;
	/* the kaboom should never happen if either config[max_seats]
	   is properly set (params.php), or the combined value of
	   seats in your theatres is less than ten thousand seats. */
    }
}

function get_total() {
  global $postaltax,$lang;
  $data = $_SESSION["seats"];
  $payment = $_SESSION["payment"];

  $total = 0;

  foreach ($data as $n => $s) {
    $total += get_seat_price($s);
  }
  if ($postaltax) {
    if ($payment==PAY_POSTAL) {
	$total += postaltax($total);
    }
  }
  $total += do_hook_sum('extra_charges',$data);
  return $total;
}

?>
