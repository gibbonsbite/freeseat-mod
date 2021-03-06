<link rel="stylesheet" href="datepicker.css" type="text/css" />
<script src="/reservation/jquery/jquery-1.9.1.js"></script>
<script src="/reservation/jquery/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
<?php
define ('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/money.php");
require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/shows.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
 copying/warranty info. */

/** if an image file was uploaded, this will handle the file */
function get_upload( &$perf ) {
	global $upload_path, $lang;

	$permitted = array("jpeg","jpg","gif","png","bmp");
	if ($_POST['uploadedfile'] == "") {
		foreach( $_FILES as $file_name => $file_array ) {
		$parts = pathinfo($file_array['name']);
		$target = $parts["basename"];
		$perf['imagesrc'] = $target;
		if ($file_array['name'] == "") {
	      kaboom( $lang['err_filetype'] . "image" );
	      $perf['imagesrc'] = "";
	    }
		}
	} else {
	$target = $_POST['uploadedfile'] . ".jpg";
	$perf['imagesrc'] = $target;
	}
}

/* displays a combo box allowing to choose a theatre for the given
   performance. Pass currently selected value as second parameter */
function choose_seatmap( $perf, $theatre=null )
{
	global $lang;
	
	enhanced_list_box(array( 'table' => 'theatres', 'id_field' => 'id', 
		'value_field' => 'name', 'highlight_id' => $theatre), '', '', "theatre_$perf" );
	return "";
}

function choose_local_file($spec)
/* opens a file dialog to upload a file to the server
- Maximum allowable file size is curently 100K */
{
	global $lang;
	
	echo '<br /><h3>' . $lang['file'] . '</h3>';
	echo '<input type="hidden" name="MAX_FILE_SIZE" value="100000">';
	echo '<input name="uploadedfile" type="text"><br>';
}

function choose_spectacle( $new, $spec )
// displays a list box of available spectacles in the database to choose from
{
	global $lang;
	
	enhanced_list_box(array( 'table' => 'spectacles', 'id_field' => 'id', 
		'value_field' => 'name', 'highlight_id' => $spec), 'onchange="choose_spec.submit();"',
		($new ? $lang['create_show'] : '' ), 'id' );
	return ''; 
}

function enhanced_list_box($options, $params, $text_new, $resultname) {
// From http://www.cgi-interactive-uk.com/populate_combo_box_function_php.html
// creates a list box from data in a mysql field
	$sql  = "select " . $options['id_field'];
	$sql .= ", " . $options['value_field'];
	$sql .= " from " . $options['table'];
	/* append any where criteria to the sql */
	if(isset($options['where_statement'])) {
    $sql .= " where " . $options['where_statement'] ;
	}  
	/* set the sort order of the list */
	$sql .= " order by " . $options['value_field'];
	$result = mysql_query($sql);
	if (!$result) {
		kaboom(mysql_error()); 
		return;
	}
	echo '<select name="', $resultname, '" ', $params, ' size="1">';
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		if($row[0] == $options['highlight_id']) {
			echo '<option value="', $row[0], '" SELECTED>', $row[1], '</option>';
		} else {
			echo '<option value="', $row[0], '">', $row[1], '</option>';
		}
	}
	if ($text_new)  {
		echo '<option value="0" ' . (($options['highlight_id']==0)?'SELECTED':'') . '>' . 
			$text_new . '</option>';
	}
	echo '</select>';
}

/* function get_perf( $spec )  */
/* // get spectacle and theatre description into an array  */
/* { */
/* 	$perf = get_spectacle($spec);   */
/* 	$perf["active"] = (get_config("spectacleid")==$spec); */
/* 	return $perf; */
/* } */

function get_tname( $theatre ) {
	if (!$theatre) return null;
	return m_eval("select name from theatres where id=$theatre");
}

/** How many seats have been booked or are in the process of being
    booked for the given show. Might not be very accurate if some guy
    fell asleep while booking etc. Also, very recently booked seats
    are counted twice because their lock is still valid */
function count_bookings( $showid ) {
  global $now;
  $tot = m_eval( "select count(booking.id) from booking where" . 
		 " showid=$showid" .
		 " and (state=" . ST_LOCKED . " or state=" . ST_BOOKED . 
		 " or state=" . ST_SHAKEN . " or state=" . ST_PAID . ")" )+
    m_eval( "select count(*) from seat_locks where" . 
	    " showid=$showid" .
	    " and until>".$now);
    return $tot;
}

function copytodates($key,$field,$value) {
  global $dates,$lang,$permit_warn_booking;
  if (($permit_warn_booking) &&
      $dates[$key]["booked"] &&
      ($dates[$key][$field] != $value)) {
    kaboom($lang["warn_bookings"]);
    $permit_warn_booking = false;
  }
  $dates[$key][$field] = $value;
}

/** print a form input setting $name to $value. If global $ready is
true then print it in a non-editable form.

$name: the form input name

$value: the default value

$headername: if set, show that as a title over the field

**/
function print_var( $name, $value, $headername=null) {
	global $lang, $ready;

	if ($headername) echo '<h3>' . $headername . '</h3>';
	if ($name=="description" && !$ready) { // i am so sorry
	  echo '<textarea name="'.$name.'" border=1 rows=6 cols=35>' . $value; 
	  echo '</textarea>';
	} elseif(strpos($name,'d')!==false){
		$escvalue = $value;
		echo '<script>$(function() { $( "#'.$name.'" ).datepicker({ dateFormat: "yy-mm-dd" }); });</script>';
		echo '<input '.($ready?'type="hidden" ':'').' name="'.$name.'" id="'.$name.'" value="'.$escvalue.'">';
		} else {
		$escvalue = $value;
		echo '<input '.($ready?'type="hidden" ':'').' name="'.$name.'" value="'.$escvalue.'">';
	}
	if ($ready) {
	    /* Note that we *don't* escape $value. The point is to let
	       the admin enter HTML formatting in there if needed */
	  echo '<p class="main">' . $value . '</p>';
	}
}

/* show storing functions */


function set_dates($spec,$dates)
// set dates/times from $dates into shows table
// this should go into mysqlstuff.php
{
	foreach ($dates as $id => $val) {   
		$d = quoter($val['date']);
		$t = quoter($val['time']);
		$th = $val['theatre'];
		if (!isset($val['id'])) { // INSERT
		  if ($d=="'0000-00-00'") continue;
		  $q = "INSERT into shows (spectacle, theatre, date, time) values ($spec, $th, $d, $t)";
		} else {
		  $i = (int)$val['id'];
		  if ($d=="'0000-00-00'") continue; // should maybe do a DELETE instead?
		  $q ="UPDATE shows set time=$t, date=$d, theatre=$th where id=$i";
		}
		if (! mysql_query( $q )) {
			myboom("Problem when creating or updating show information.");
			return false;
		} 
	}
	return true;
}

function set_perf($perf) 
// set spectacle description info into tables, returning the id of the
// spectacle - unchanged if it was an existing one, bigger than zero
// if this is a new spectacle.
// this should go into mysqlstuff.php
{
  $spec = (isset($perf["id"])?(int)$perf["id"]:0);
	if ($spec>0) {
		$q = "UPDATE spectacles set name=".quoter($perf["name"])
		    .", description=".quoter($perf["description"])
		    .", imagesrc=".quoter($perf["imagesrc"])." where id=$spec";
		$result = mysql_query( $q );
	} else {
		$q = "INSERT into spectacles (name, imagesrc,description) values ("
		    .quoter($perf['name']).", "
		    .quoter($perf['imagesrc']).", "
		    .quoter($perf['description']).")";
		$result = mysql_query( $q );
		if ($result) {
		  $spec = mysql_insert_id();
		}
	}
	if (!$result) {
		kaboom(mysql_error());
		return false;
	}	
/* 	if ($perf["active"] ) { */
/* 		$c = get_config(); */
/* 		$c["spectacleid"] = $spec; */
/* 		set_config($c); */
/* 	} */
	return $spec;
}

db_connect();

ensure_plugin('showedit');

if (!admin_mode()) {
  kaboom($lang["access_denied"]);
  show_head(true);
  show_foot();
  exit;
}


load_alerts();

/** 1 - load db-stored data **/
$totalbooked = 0;
if (isset($_REQUEST["id"])) {
  $spec = (int)$_REQUEST["id"];
} else {
  $spec=m_eval("select id from spectacles order by id desc limit 1");
  if ($spec===null) { // empty spectacle table
    $spec = 0;
  }
}

if ($spec > 0) {  // if we have selected a saved spectacle, fetch data
  $dates = get_shows("spectacle=$spec");
  foreach ($dates as $i => $dt)
    $totalbooked += ($dates[$i]["booked"] = count_bookings($dt["id"]));
  $prices = get_spec_prices( $spec );
  $perf = get_spectacle( $spec );
} else { 	// if we want a new spectacle, clear variables and use id 0 as marker
  $dates = array();
  $prices = array();
  $perf = array();
  $perf['id'] = 0;
}

/** 2 - load any POST-provided data **/

$allisfine = true; // set to false in case something went wrong
		   // reading post data
$permit_warn_booking = isset($_POST["submit"]); // whether changes in
                                              // spectacle data may
                                            // display that
                                          // warn_booking message
foreach (array(/*'id',*/ 'name', 'description', 'imagesrc', /*'theatre', 'theatrename', 'active'*/ ) as $item) {
  if (isset($_POST[$item]))
    $perf[$item] = nogpc($_POST[$item]);
}
	//$prices = $_SESSION['prices'];
for ( $i=1; $i<=4; $i++ ) { // class loop
  for ( $j=CAT_NORMAL; $j>=CAT_REDUCED; $j-- ) { // cat loop
    $item = "p_$i"."_$j"; //implode( "_", array( 'p', $i, $j ));
    if (isset($_POST[$item])) {
      if ($totalbooked && $permit_warn_booking &&
	  isset($prices[$i]) && isset($prices[$i][$j]) &&
	  $prices[$i][$j] != string_to_price($_POST[$item])) {
	$permit_warn_booking = false;
	kaboom($lang["warn_bookings"]);
      }
      $prices[$i][$j] = string_to_price($_POST[$item]);
    }
  }
  if (isset($_POST["comment$i"]))
      $prices[$i]['comment'] = nogpc($_POST["comment$i"]);
}

/* performances with a simple number as here alter existing data ...*/
for ( $i=0; isset($_POST["d$i"]); $i++ ) {
  // not isset()ting becase they would only return false if user
  // alters the html before submitting a form

    copytodates($i,'date',sanitise_date($_POST[ "d$i" ]));
    copytodates($i,'time',sanitise_time($_POST[ "t$i" ]));
    if (!$dates[$i]["booked"]) // really don't allow changing theatre..
	// ..when seats have been sold..
	$dates[$i]['theatre'] = (int)($_POST[ "theatre_$i" ]);

    $th = get_theatre($dates[$i]['theatre']);
    if (!$th) $allisfine = kaboom($lang["err_spectacle"]);
    else $dates[$i]['theatrename'] = $th["name"];
}
/* ... while performances with an xnumber are used to create new
   performances. */
for ( $i=0; isset($_POST["dx$i"]); $i++ ) {
  // D�j� vu? RUN! They must have changed something in the Matrix
  // NOTE: no need to use the copytodates wrapper here because these
  // could not have sold tickets anyway
    $dates["x$i"]['date'] = sanitise_date($_POST[ "dx$i" ]);
    $dates["x$i"]['time'] = sanitise_time($_POST[ "tx$i" ]);
    $dates["x$i"]['theatre'] = (int)($_POST[ "theatre_x$i" ]);
    $th = get_theatre($dates["x$i"]['theatre']);
    if (!$th) $allisfine = kaboom($lang["err_spectacle"]);
    else $dates["x$i"]['theatrename'] = $th["name"];
}
$nextxtra = $i; // this is the first $i such that dx$i was NOT
		// defined.

/*}*/

get_upload($perf);

// imagesrc has now been set as follows:
// 1: if user uploads something then that is the value.
// 2: otherwise, if POST gives a values then that is taken
// 3: otherwise, any existing data in the database is used

// make sure all of the variables are initialized
for ( $i=1; $i<=4; $i++ ) { // class loop
  for ( $j=CAT_NORMAL; $j>=CAT_REDUCED; $j-- )  // cat loop
    if (!isset($prices[$i][$j])) $prices[$i][$j] = 0.0;

  if (!isset($prices[$i]['comment'])) $prices[$i]['comment'] = "";
}
foreach (array( 'name', 'description', 'imagesrc' /*, 'active'*/ ) as $item)
	if (!isset($perf[$item])) $perf[$item] = "";

/** 3 - validate data **/

$ready = (isset($_POST["submit"])||isset($_POST["save"]))// $ready:
	&& ($allisfine);			       // When true,
						      // show readonly
if (isset($_POST["edit"])) $ready=false; // data and a button to save
if ($ready) {			        // changes. When false show
  if ($perf["name"]=='') {	       // an editable form and a
    $ready = false;		      // button to confirm. It is
    kaboom($lang["err_nospec"]);     // set to true if user
  }				    // submitted a form and there
  $atleastone = false;		   // was no mistakes
  foreach ($dates as $dt) if ($dt['date'] && ($dt['date']!="0000-00-00")) $atleastone = true;
  if (!$atleastone) {
    $ready = false;
    kaboom($lang["err_nodates"]);
  }
  $atleastone = false;
  for ( $i=1; $i<=4; $i++ ) // class loop
    if (isset($prices[$i][CAT_NORMAL] ) && ($prices[$i][CAT_NORMAL]>0))
      $atleastone = true;
  if (!$atleastone) {
    $ready = false;
    kaboom($lang["err_noprices"]);
  }
  if (!$ready) // something went wrong
    kaboom($lang["err_show_entry"]);
}

// Note that the error message is set only if user requested saving
// BUT storing failed. And in that case the if is not taken so we
// proceed to user interface without redirection.
if ($ready && isset($_POST["save"])) {
/* 4 - data is valid and user requested saving */
    $spec = set_perf( $perf );
    if ($spec) {
	if (!(set_spec_prices( $spec, $prices ) &&
	      set_dates( $spec, $dates ))) {
	    kaboom($lang["show_not_stored"]);

	    // the set_*()ing failed so we set ready to false to make
	    // the interface editable again
	    $ready = false;
	} else {
	    // success
	    kaboom($lang["show_stored"]);
	    $_SESSION["messages"] = $messages;
	    header("Location: index.php?id=".$spec);
	    exit;
	}
    } else {
	// failed creating a spectacle
	$ready = false;
    }
}

/** 5 - show user interface **/

show_head();

// uncomment following lines to display debugging information
/* echo '<pre>POST:';print_r($_POST);echo '</pre>'; */
/* echo '<pre>dates:';print_r($dates);echo '</pre>'; */
/* echo '<pre>perf:';print_r($perf);echo '</pre>'; */
/* echo "<pre>spec=$spec</pre>"; */
echo '<h2>' . $lang[$ready?'title_mconfirm':'title_maint'] . '</h2>';
echo '<form action="index.php" name="choose_spec" method="get">';
// spectacle selection form depends on the onchange action in choose_spectacle()
echo '<h3>' . $lang["spectacle_name"] . '</h3>';
choose_spectacle( true, $spec );
echo ' <input type="submit" value="'.$lang["select"].'">'; // let's not forget people who disable javascript
echo '</form>';
echo '<div class="form">'; // the big div
echo '<form action="index.php" method="post" enctype="multipart/form-data">'; // data submission form

echo '<input style="display : none;" type="submit" name="submit">';// default action when user presses enter in a field

echo '<div class="image-selection"><h3>' . $lang['imagesrc'] . '</h3>' ;    // image upload form
 // imagesrc: default, to be used if user does not upload an image.
echo '<input type="hidden" name="imagesrc" value="'.htmlspecialchars($perf["imagesrc"]).'">';
if ($perf['imagesrc']) {
    echo '<img src="' . htmlspecialchars(apply_fspath($upload_url . $perf['imagesrc'])) . '" height="150"><br>';
} else
	echo $lang['noimage'];
echo '</div>';
echo '<input type="hidden" name="id" value="'.$spec.'">';
print_var("name",$perf['name'],$lang["name"]);
if (!$ready) choose_local_file('image');
print_var("description",$perf['description'],$lang["description"]);

echo '<div class="form">';
echo '<h3>' . $lang['datesandtimes'] . '</h3>';
if (!$ready) echo '<p class="fine-print">' . $lang["warn_spectacle"] . '</p>';

echo '<table BORDER="1" CELLPADDING="4">';
echo '<tr><th>'.$lang["date_title"].'<th>'.$lang["time_title"].'<th>'.$lang["theatre_name"].'<th>'.$lang["seats_booked"].'</tr>';
$dispperf = 0;
foreach ( $dates as $i => $dt ) {
	echo '<tr><td>';
	print_var("d$i",$dt['date']);
	echo '</td><td>';
	print_var("t$i",$dt['time']);
	echo '</td><td>';
	if (!$ready && ((substr($i,0,1)=='x') || (!$dt["theatrename"])))
	  choose_seatmap( $i, $dt["theatre"] );
	else {
	  echo "<input type='hidden' name='theatre_$i' value='".htmlspecialchars($dt['theatre'])."'>";
	  echo htmlspecialchars($dt['theatrename']);
	}
	echo '</td><td>';
	echo isset($dt["id"])? count_bookings($dt["id"]): 'n/a';
	
	$dispperf++;
}

if (isset($_POST["perfcount"]))
    $perfcount = max($dispperf,(int)($_POST["perfcount"]));
else
    $perfcount = $dispperf;

if (isset($_POST["addperf"]))
     $perfcount=$perfcount+10;

if (!$ready) {
  for ($i = $nextxtra; $dispperf<$perfcount; $i++) {
    /* more lines to allow adding performances */
    echo '<tr><td>';
    print_var("dx$i",'');
    echo '<td>';
    print_var("tx$i",'');
    echo '<td>';
    choose_seatmap( "x$i" ); // x as in "extra" - i guess you got
			     // the..
    echo '<td>n/a';
    $dispperf++;		  // ..idea by now
  }
}
  
echo '</table>';
echo '<input type="hidden" name="perfcount" value="'.$perfcount.'">';
if (!$ready) {
  echo '<input type="submit" name="addperf" value="+">';
}
echo '</div><div class="form">';
echo '<h3>' . $lang['prices'] . '</h3>';
echo '<table BORDER="1" CELLPADDING="4" >';
echo '<tr><th>'. $lang["class"] . '<th>'.$lang["price"].'<th>'.$lang["price_discount"].'<th>'.$lang["comment"].'</tr>';
for ( $i=1; $i<=4; $i++ ) { // class loop
	if ($i==1) echo '<tr><td>Norm</td>';
	if ($i==2) echo '<tr><td>3D</td>';
	if ($i==3) echo '<tr><td>Ale</td>';
	if ($i==4) echo '<tr><td>3D Ale</td>';
	//echo '<tr><td>'. $i . '</td>';
	for ( $j=CAT_NORMAL; $j>=CAT_REDUCED; $j-- ) { // cat loop
		echo '<td>';
		print_var("p_$i"."_$j",price_to_string($prices[$i][$j]));
	}
	echo '<td>';
	print_var("comment$i", $prices[$i]['comment']);
	echo '</tr>';
}

echo '</table></div><p>';
/*if ($ready) {
  if ($perf["active"]) echo "<input type='hidden' name='active' value='on'>";
  echo $lang[$perf["active"] ? "is_default" : "is_not_default"];
} else {
  echo '<INPUT type="checkbox" name="active" '.
    ($perf["active"] ? 'checked' : '').'>  '. $lang["make_default"];
}
echo '</p>';*/

echo '<br style="clear:both;"></div>'; // a br to make the big div
				       // large enough

if ($ready) {
  echo '<p class="emph">' . $lang["warn_show_confirm"] . '</p>';
  echo '<p class="main"><input type="submit" name="save" value="' . $lang["save"] . '"></p>';
  echo '<p class="main">';
  printf($lang["backto"],'<input type="submit" name="edit" value="'.$lang["link_edit"].'">');
  echo '</p>';
} else {
  echo '<p class="emph">' . $lang["are-you-ready"] . '</p>';
  echo '<p class="main"><input type="submit" name="submit" value="'.$lang["continue"].'">';
}

echo '</p></form>';
echo '<p class="main">';
printf($lang["backto"],'[<a href="'. FS_PATH .'index.php">'.$lang["link_index"].'</a>]');
echo '</p>';

show_foot(); 
?>
