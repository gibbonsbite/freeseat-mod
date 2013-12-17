<?php

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/mysql.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id$

functions related to getting/setting configuration
*/


/** Return the contents of the config table (First row ; there "should" not be more).
    You can then modify the returned assoc array and store it back using set_config. */
function get_config($key=null) {
  if (isset($key)) return m_eval("select $key from config");
  if ($zou = mysql_query("select * from config"))
    return mysql_fetch_assoc($zou);
  else {
    kaboom(mysql_error());
    return false;
  }
}

function set_config($c) {
  $sep = '';
  $q = '';
  foreach ($c as $k => $v) {
    $q .= "$sep $k='$v'";
    $sep = ',';
  }
  return mysql_query("update config set $q");
}

?>