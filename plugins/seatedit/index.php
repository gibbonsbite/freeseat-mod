<?php

define('FS_PATH','../../');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/tools.php");

db_connect();

ensure_plugin('seatedit');

if (isset($_GET["id"]) && isset($_GET["zone"])) {

  if (!admin_mode()) {
    echo '[]';
    exit;
  }

    /* This is called by loadMap() in editor.js, which itself is
       called when the user clicks on the "Load" button */
  if ($allseats = mysql_query('select id,row,col,x,y,class,zone,extra from seats where theatre='.(int)($_GET["id"])
			      .' and zone='.quoter(nogpc($_GET["zone"])))) {
    } else {
	// either the theatre has no seats or there was an error obtaining them.
	echo '[]';
	exit;
    }
    echo '[';
    $sep='';
    for ($currseat = mysql_fetch_assoc($allseats);
	 $currseat;$currseat = mysql_fetch_assoc($allseats)) {
	echo $sep.'{x:'.$currseat['x'].','.
	  'y:'.$currseat['y'].','.
	  'cls:'.$currseat['class'].','.
	  'row:"'.addslashes($currseat['row']).'",'.
	  'col:"'.addslashes($currseat['col']).'",'.
	  'extra:"'.addslashes($currseat['extra']).'"}';
	$sep=',';
    }
    echo ']';
    exit;
 } else if (isset($_POST["theatre"])) {
  /* The "save" button got clicked. */

  if (!admin_mode()) {
    echo '{ok:0,msg:"'.$lang["access_denied"].'"}';
    exit;
  }

  /* First see if there's already a theatre of the given name */

  $theatreId = m_eval('select id from theatres where name='.quoter(nogpc($_POST["theatre"])));

  if (($theatreId === null) &&
      mysql_query("insert into theatres (name) values (".quoter(nogpc($_POST["theatre"])).")"))
    $theatreId = mysql_insert_id();

  if ($theatreId !== null) {
    /* A zone of that name already existed. Check if it is referenced
     by existing bookings before nuking it */
    $useCount = m_eval("select count(*) from booking,seats,shows where ". 
		       "booking.seat=seats.id and ".
		       "seats.zone=".quoter(nogpc($_POST["zone"])).
		       " and ".
		       "booking.showid=shows.id and ".
		       "shows.theatre=$theatreId");

    if ($useCount>0) {
      echo "{ok:0,msg:'".addslashes(sprintf($lang['seatedit_error_cant_delete'], $useCount))."'}";
      exit;
    }

    /* First erase any existing map in that theatre and zone. */
    mysql_query("delete from seats where theatre=$theatreId and zone=".
		quoter(nogpc($_POST["zone"]))." and row != -1");

    /* To avoid having enormous queries in case there are lots of
     seats I'm going one query for every thousand seats. The GUI isn't
     practical for more than that, anyway */

    $success = true;
    $queryhead = "insert into seats (theatre,row,col,extra,zone,class,x,y) values ";
    $query = $queryhead;
    $sep = '';
    $cnt = 0; // how many seats in current query
    for ($i=0;$i<count($_POST["x"]);$i++) {
      $query .= $sep.
	  "($theatreId,".quoter(nogpc($_POST["row"][$i])).
	  ",".quoter(nogpc($_POST["col"][$i])).
	  ",".quoter(nogpc($_POST["xtra"][$i])).
	  ",".quoter(nogpc($_POST["zone"])).
	  ",".(int)($_POST["cls"][$i]).
	",".(int)($_POST["x"][$i]).
	",".(int)($_POST["y"][$i]).
	")";
      $sep = ',';
      if ($cnt++ > 1000) {
	$success &= mysql_query($query);
	
	$query = $queryhead;
	$sep = '';
	$cnt = 0; // how many seats in current query
      }
    }
    if ($cnt>0) {
      $success &= mysql_query($query);
    }
    if ($success)
      echo "{ok:1,theatreId:$theatreId}";
    else
      echo '{ok:0,msg:"When inserting seats into database:'.addslashes(mysql_error()).'"}';
  } else { // if $theatreId == null
    echo '{ok:0,msg:"When inserting theatre into database:'.addslashes(mysql_error()).'"}';
  }
  exit;
 }

if (!admin_mode()) {
  kaboom($lang["access_denied"]);
  show_head(true);
  show_foot();
  exit;
}

show_head(true,true);
?>
<link rel="stylesheet" type="text/css" href="<?php echo FS_PATH; 
?>style/editor.css">
<script src="editor.js" type="text/javascript"></script>
<?php
  close_head(true,'onload="addCols(10);addRows(10)"');
?>
<select id="mapList"></select>
<script type="text/javascript">
<!--

<?php
  foreach(fetch_all(mysql_query("select distinct theatre,zone,theatres.name,theatres.id from seats,theatres where theatres.id=theatre")) as $line) {
  echo 'registerMap('.$line["id"].',"'.addslashes($line["name"]).'","'. addslashes($line["zone"]).'");';
 }
?>

-->
</script>
<input type="button" onclick="loadMap()" value="<?php echo $lang['seatedit_load']; ?>">
    &mdash;  <?php echo $lang['seatedit_theatre']; ?>: <input id="theatreName"> <?php echo $lang['seatedit_zone']; ?>: <input id="zoneName"> <input type="button" onclick="saveMap()" value="<?php echo $lang['seatedit_save']; ?>">
<div id="map" class="map withNumbers">
<div class="rowheadhead"><?php echo $lang['row']; ?></div>
</div>

<p class="main">[<a href="#" onclick="addRows(1); return false"><?php
		 echo $lang['seatedit_more_rows'];
?></a>]
[<a href="#" onclick="addCols(1); return false"><?php
		 echo $lang['seatedit_more_cols'];
?></a>]
[<a href="#" onclick="copySelection(); return false"><?php
		 echo $lang['seatedit_copy'];
?></a>]</p>

  <p class="main"><div class="inline-row">
    <div class="cls1" onclick="setCurrentTool(event)"><div id="currentTool" class="currentTool"></div></div>
    <div class="cls2" onclick="setCurrentTool(event)"></div>
    <div class="cls3" onclick="setCurrentTool(event)"></div>
    <div class="cls4" onclick="setCurrentTool(event)"></div>
    <div class="blank" onclick="setCurrentTool(event)"></div>
    <div class="select" onclick="setCurrentTool(event)" title="<?php
		 echo $lang['seatedit_select'];
?>"></div>
    <div class="paste" onclick="setCurrentTool(event)" title="<?php
echo $lang['seatedit_paste']; ?>"></div>
    <div class="numbers" onclick="setCurrentTool(event)" title="<?php
echo $lang['seatedit_edit_sn_title']; ?>"><?php
echo $lang['seatedit_edit_sn']; ?></div>
    <div class="extra" onclick="setCurrentTool(event)" title="<?php
echo $lang['seatedit_extra_title']; ?>"><?php
  echo $lang['seatedit_extra']; ?></div>
  </div>
  [<a href="#" onclick="setEverywhere(action); return false"><?php
   echo $lang['seatedit_fillselection']; ?></a><span id="optionsExtra" class="options"> <?php echo $lang['seatedit_with_value']; ?> <input type="text" id="defaultExtra"></span><span id="optionsNumber" class="options"> <select id="horiz">
<option value="ltr"><?php echo $lang['seatedit_ltr']; ?></option>
<option value="rtl"><?php echo $lang['seatedit_rtl']; ?></option>
</select>
<select id="subset">
<option value='all'><?php echo $lang['seatedit_subset_all']; ?></option>
   <option value='even'><?php echo $lang['seatedit_subset_even']; ?></option>
   <option value='odd'><?php echo $lang['seatedit_subset_odd']; ?></option>
</select>
<select id="vert">
   <option value='indep'><?php echo $lang['seatedit_vert_indep']; ?></option>
   <option value='ttb'><?php echo $lang['seatedit_vert_ttb']; ?></option>
   <option value='btt'><?php echo $lang['seatedit_vert_btt']; ?></option>
    </select></span>]</p>
    <p class="main">
<?php echo $lang['seatedit_renum_rows']; ?> 
<select id="rowStyle">
  <option value='numeric'>1, 2, 3, ...</option>
  <option value='upper'>A, B, C, ...</option>
  <option value='lower'>a, b, c, ...</option>
  <option value='roman'>I, II, III, ...</option>
</select>
  [<a href="#" onclick="renumRows(true);return false"><?php echo $lang['seatedit_vert_ttb']; ?></a>]
    [<a href="#" onclick="renumRows(false);return false"><?php echo $lang['seatedit_vert_btt']; ?></a>].
    </p>

<?php
echo '<p class="main">';
printf($lang["backto"],'[<a href="'. FS_PATH . 'index.php">'.$lang["link_index"].'</a>]');
echo '</p>';
  show_foot();
?>