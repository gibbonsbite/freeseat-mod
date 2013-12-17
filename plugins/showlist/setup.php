<?php

require_once (FS_PATH . "vars.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/tools.php");
require_once (FS_PATH . "functions/mysql.php");

function freeseat_plugin_init_showlist() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['front_page_showlist']['showlist'] = 'showlist_display';
}

/* Outputs info about a spectacle on the front page. Requires a spectacle 
array as parameter. */
function showlist_display($spectacle=false) {
  global $lang;
  if (!$spectacle) return;
  echo '<p>'.$lang['datesandtimes'].'</p><ul>';
  $shows = fetch_all(mysql_query("select shows.* from shows where date >= curdate() and spectacle='".$spectacle['id']."' order by date"));
  foreach ($shows as $show) {
    $id = $spectacle['id'];
    $d = f_date($show['date']);
    $t = f_time($show['time']);
    $target = freeseat_url("repr.php?spectacleid=$id");
    echo "<li><p><a style='color: #202020;' href='$target'>$d, $t</a></p></li>";
  }
  echo '</ul>';
}
