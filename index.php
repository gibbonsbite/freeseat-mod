<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/spectacle.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: index.php 341 2011-04-25 19:03:48Z tendays $
*/

/** This code is used on first run to provide access to the configuration tool. */
if (!file_exists(FS_PATH . "config.php")) {
  header('Location: ./plugins/config/index.php');
}

db_connect();

/** With no parameters, we show spectacles that have a representation
    today or later. With a spectacleid parameter, show that spectacle
    only **/

$allshown = false;

if (isset($_GET["spectacleid"]) && ($s = get_spectacle((int)($_GET["spectacleid"])))) {
  $ss = array($s);
} else if (isset($_GET["nohide"])) {
  $ss = fetch_all(mysql_query("select spectacles.* from shows,spectacles where spectacles.id=shows.spectacle group by spectacles.id order by date desc"));
  $allshown = true;
} else {
  $ss = fetch_all(mysql_query("select spectacles.* from shows,spectacles where date >= curdate() and spectacles.id=shows.spectacle group by spectacles.id order by date desc"));
}

if ($ss === false)
  fatal_error($lang["err_connect"].mysql_error());
else if (!count($ss))
  kaboom($lang["err_noavailspec"]);

/* displays an image and text description of spectacles on opening page */

echo '<div class="warning">'.$lang["index_head"].'</div>';

show_head();

if ($take_down) echo "<p class='emph-a-lot'>$take_down</p>";

if (admin_mode()) {
/* in admin mode, permit some customisation of which spectacles are
   displayed.

(In non-admin mode those are still available but the link is not
shown) */

if ($allshown)
    printf('<p class="main">'.$lang["hideold"].'</p>','[<a href="index.php">','</a>]');
  else
    printf('<p class="main">'.$lang["showallspec"].'</p>','[<a href="index.php?nohide">','</a>]');
}

echo '<table width="80%">';
foreach ($ss as $s) {
  if (admin_mode() || ! $take_down) {
    $linkl = '<a href="repr.php?spectacleid='.$s["id"].'">';
    $linkr = '</a>';
	$linke = '<a href="plugins/showedit/index.php?id='.$s["id"].'">';
  } else {
    $linkl = '';
    $linkr = '';
	$linke = '';
  }

  echo '<tr>';
  if ($s['imagesrc']) {
    echo '<td class="showlist">'.$linkl.'<img src="'.$upload_path.$s['imagesrc']. '" height="150">'.$linkr.'</td>';
  }

  /** WARN - we assume whoever filled the description field to be
      trustworthy enough not to write malicious or malformed html */
	if ($s["name"]) {
		echo '<td class="showlist"><p><i>' . $s['name'] . '</i></p>';
	}
  if ($s["description"]) {
    echo '<p><i>' . $s['description'] . '</i></p>';
  }
  do_hook_function('front_page_showlist',$s);

  printf('<p>'.$lang[admin_mode()?"admin_buy":"buy"].'</p>','['.$linkl,$linkr.']');
  printf('<p>'.$lang[admin_mode()?"editshows":"Edit"].'</p>','['.$linke,$linkr.']');

  echo '</td></tr>';
}
echo '</table>';

do_hook('front_page_public');

if ($helpmessage) {
  echo "<p class='main'>$helpmessage</p>";
}

if (admin_mode()) {

  echo "<h2>".$lang["admin"]."</h2>";
  
  echo '<p class="main">';
  printf($lang["bookinglist"],'[<a href="bookinglist.php?st=2&sort=lastname">','</a>]');
  echo '</p>';

  echo '<p class="main">';
  printf($lang["params"],'[<a href="params.php">','</a>]');
  echo '</p>';

  do_hook('front_page_admin');

} 

show_foot(); 

?>
