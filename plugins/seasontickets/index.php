<?php

/*
 *  The admin console for maintaining season tickets. We can be in one of 
 *  two states: edit mode or display mode.
 *  Display mode: existing season tickets are shown in a list, newest first.
 *  Each line will have icons or buttons for Edit or Delete.
 *  At the top is a button for Adding a new record.
 *  When adding a new record, the system will by default put in a one-year
 *  expiration date and calculate a random code.
 *  Edit mode: opens an existing season ticket record for editing, or entry
 *  of a new record.  Buttons for Save or Cancel.
 *  By default the code is a 8-digit random character string.
 *  11 Fields: firstname, lastname, address, city, us_state, postalcode, phone,
 *  code, count, used, email, expiration. See setup.sql for schema.
 *  
 */

define('FS_PATH','../../');
define('CODE_LENGTH','8');

require_once (FS_PATH . "vars.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "plugins/seasontickets/setup.php");

db_connect();

ensure_plugin('seasontickets');

$seasontickets_template = array( 'firstname' => '', 'lastname' => '', 'address' => '', 'city' => '',
  'us_state' => $pref_state_code, 'postalcode' => '', 'phone' => '', 
  'code' => seasontickets_codegen(CODE_LENGTH), 'count' => 1, 'email' => '', 
  'expiration' => sanitise_date(date('Y-m-d', strtotime("+365 days"))));

$seasontickets_dblimit = 20;
$seasontickets_dboffset = 0;
$seasontickets_listmode = TRUE;

if (isset($_SESSION['editdone']) and isset($_POST['save'])) {
  $seasontickets_editid = $_SESSION['editdone'];
  foreach (array("firstname", "lastname", "address", "city", "us_state", "postalcode", "phone", "email", "code", "count", "expiration") as $label) {
    if (isset($_POST[$label])) 
      $seasontickets_editrow[$label] = $_POST[$label]; 
    else 
      $seasontickets_editrow[$label] = '';
  }
  unset($_SESSION['editdone']);
  $result = seasontickets_write($seasontickets_editid,$seasontickets_editrow);
}
 
if (!admin_mode()) fatal_error($lang["access_denied"]);
$seasontickets_dbnumber = seasontickets_count();
if ($seasontickets_dbnumber==0) kaboom($lang['seasontickets_nonefound']);

foreach ($_POST as $n => $a) {
  if (strpos($n,'new')!==FALSE) {
    // user clicked the new button
    $seasontickets_editid = -1;
    $seasontickets_editrow = $seasontickets_template;
    $seasontickets_listmode = FALSE;
  } else if (strpos($n,'edit')!==FALSE) {
    // user clicked an edit button
    $seasontickets_editid = substr($n,4);
    $sql = "select * from seasontickets where id=".quoter($seasontickets_editid);
    $res = mysql_query($sql);
    $seasontickets_editrow = mysql_fetch_assoc($res);
    $seasontickets_listmode = FALSE;
  } else if (strpos($n,'dele')!==FALSE) {
    // user clicked a delete button
    $id = substr($n,4);
    $sql = "delete from seasontickets where id=".quoter($id);
    mysql_query($sql);
    $seasontickets_dbnumber = seasontickets_count();
  } else if (strpos($n,'next')!==FALSE) {
    // user clicked the next button
    $seasontickets_dboffset = substr($n,4);
    $seasontickets_dboffset += $seasontickets_dblimit;
    $seasontickets_dboffset = min($seasontickets_dboffset,$seasontickets_dbnumber-1);
  } else if (strpos($n,'back')!==FALSE) {
    // user clicked the back button
    $seasontickets_dboffset = substr($n,4);
    $seasontickets_dboffset -= $seasontickets_dblimit;
    $seasontickets_dboffset = max($seasontickets_dboffset,0);
  } else if (strpos($n,'list')!==FALSE) {
    $seasontickets_listmode = TRUE;
  }
}

// kaboom("Post: " . print_r($_POST,1));
// kaboom("Session: " . print_r($_SESSION,1));

function seasontickets_write($id,$row) {
  $fieldlist = array('firstname', 'lastname', 'address', 'city', 'us_state', 'postalcode', 'phone', 'email', 'code', 'count', 'expiration'); 
  if ($id==-1) {
    // insert a new record
    $start = TRUE;
    $sql = "insert into seasontickets (";
    foreach($fieldlist as $label) {
      if (!$start) $sql .= ', ';
      $sql .= $label;
      $start = FALSE;
    }
    $start = TRUE;
    $sql .= ') values (';
    foreach($fieldlist as $label) {
      if (!$start) $sql .= ', ';
      $sql .= "'".make_reasonable($row[$label])."'";
      $start = FALSE;
    }
    $sql .= ')';
  } else {
    // update an old record
    $start = TRUE;
    $sql = "update seasontickets set ";
    foreach($fieldlist as $label) {
      if (!$start) $sql .= ', ';
      $sql .= $label . " = '" . make_reasonable($row[$label]) . "'";
      $start = FALSE;
    }
    $sql .= " where id = $id";
  }
  return mysql_query($sql);
}

function seasontickets_count() {
  $sql = "select count(id) from seasontickets where expiration > curdate()";
  return m_eval($sql);
}

function seasontickets_getdata() {
  global $seasontickets_dboffset, $seasontickets_dblimit;
  $odd = FALSE;
  $count = 0;
  $sql = "select * from seasontickets where expiration > curdate() order by expiration desc limit $seasontickets_dboffset,$seasontickets_dblimit";
  $res = mysql_query($sql);
  if ($res) {
    for ($row = mysql_fetch_assoc($res); $row; $row = mysql_fetch_assoc($res)) {
      $count++;
      seasontickets_display($row,$odd);
      $odd = !$odd;
    }
  }
  return $count;
}

function seasontickets_display($row, $highlight) {
  global $lang;
  $id = $row['id'];
  $color = ($highlight ? 'yellow' : 'white');
  echo "<tr border='0' style='background-color: $color; border-color: $color; border-collapse: collapse;'>";
  $d = ucfirst($row['firstname']).' '.ucfirst($row['lastname']);
  echo "<td>$d</td>";
  $d = ucwords($row['address']);
  echo "<td style='width:9em;'>$d</td>";
  $d = ucwords($row['city']);
  echo "<td style='width:9em;'>$d</td>";
  $d = strtoupper($row['us_state']);
    echo "<td>$d</td>";
  $d = $row['postalcode'];
  echo "<td>$d</td>";
  $d = $row['phone'];
  echo "<td>$d</td>";
  $d = $row['email'];
  echo "<td>$d</td>";
  $d = $row['code'];
  echo "<td>$d</td>";
  $d = $row['count'];
  echo "<td style='width: 5em;'>$d</td>";
  $d = sanitise_date($row['expiration']);
  echo "<td style='width:9em;'>$d</td>";
  echo "<td><input type='submit' value='".$lang['seasontickets_del']."' name='dele$id' /><br />";
  echo "<input type='submit' value='".$lang['seasontickets_edit']."' name='edit$id' /></td></tr>";
}

function seasontickets_editmode($id, $row) {
  global $lang;
  echo '<h2>'.$lang['seasontickets_edittitle'].'</h2>';
  echo "<p class='main'><form action='".FS_PATH."plugins/seasontickets/index.php' method='post'>";
  echo "<table id='sttable'>";
  foreach (array("firstname", "lastname", "address", "city", "us_state", "postalcode", "phone", "email") as $label) {
    echo "<tr><td>".$lang[$label]."</td><td><input type='text' value='".$row[$label]."' name='$label' /></td></tr>";
  }
  echo "<tr><td>".$lang['seasontickets_code']."</td><td><input type='text' value='".$row['code']."' name='code' /></td></tr>";
  echo "<tr><td>".$lang['seasontickets_count']."</td><td><input type='text' value='".$row['count']."' name='count' /></td></tr>";  
  echo "<tr><td>".$lang['expiration']."</td><td><input type='text' value='".$row['expiration']."' name='expiration' /></td></tr>";
  echo "</table>";
  echo "<input type='submit' value='Save' name='save' />";
  echo "<a href='".FS_PATH."plugins/seasontickets/index.php'><input type='button' value='Cancel' name='cancel' /></a>";
  echo "</form></p>";
  $_SESSION['editdone'] = $id;
}

function seasontickets_listmode() {
  global $lang, $seasontickets_dboffset, $seasontickets_dbnumber;
  echo '<h2>'.$lang['seasontickets_title'].'</h2>';
  echo "<form action='".FS_PATH."plugins/seasontickets/index.php' method='post'>";
  echo "<p class='main'><input type='submit' value='".$lang['seasontickets_addnew']."' name='new' /></p>";
  echo "<p class='fine-print'><table id='sttable'><tr>";
  foreach (array("name", "address", "city", "us_state", "postalcode", "phone", "email") as $label) {
    echo "<th>$lang[$label]</th>";
  }
  echo "<th>".$lang['seasontickets_code']."</th>";
  echo "<th>".$lang['seasontickets_count']."</th>";
  echo "<th>".$lang['expiration']."</th>";
  $dbcount = seasontickets_getdata();
  echo "</tr></table></p>";
  echo "<p class='main'><table><tr>";
  echo "<td style='width: 8em;'>";
  if ($seasontickets_dboffset>0) {
    echo "<input type='submit' value='".$lang['seasontickets_back']."' name='back$seasontickets_dboffset' />";
  }
  echo "</td><td style='width: 8em;'>";
  if (($seasontickets_dboffset+$dbcount)<$seasontickets_dbnumber) {
    echo "<input type='submit' value='".$lang['seasontickets_next']."' name='next$seasontickets_dboffset' />";
  }
  echo "</td></tr><tr></tr></table></form>";
  if ($seasontickets_dbnumber>$dbcount) $seasontickets_dboffset = $dbcount;
  echo '<p class="main">';
  printf($lang["backto"],'[<a href="'.FS_PATH.'index.php">'.$lang["link_index"].'</a>]');
  echo '</p>';
  // echo "<p class='main'>dbnumber: $seasontickets_dbnumber dbcount: $dbcount dboffset: $seasontickets_dboffset</p>";
}

if ($seasontickets_listmode) {
  show_head(TRUE);
  seasontickets_listmode();
} else {
  show_head();
  seasontickets_editmode($seasontickets_editid, $seasontickets_editrow);
}

show_foot();

?>
