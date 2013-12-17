<?php

require_once (FS_PATH . "vars.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id$

Tools to ease access to mysql
*/

/** pass a mysql resource (that returned by mysql_query) and get an
array of (0,1,...-indexed) mysql records **/
function fetch_all($res) {
  if ($res===false) {
    return $res;
  } else {
    $out = array();
    while ($l = mysql_fetch_assoc($res)) $out[] = $l;
    return $out;
  }
}

/** pass a mysql resource (that returned by mysql_query) and get an
array of mysql records, indexed by values in the field named
$keyfield. If two rows have the same value for that field one of them
will be randomly selected (which is not what you want) **/
function fetch_all_id($res,$keyfield) {
  if ($res===false) {
    return $res;
  } else {
    $out = array();
    while ($l = mysql_fetch_assoc($res)) $out[$l[$keyfield]] = $l;
    return $out;
  }
}

/* For a mysql query supposed to return one row with one value,
return the contents of that row. If something went wrong then null is
returned */
function m_eval($s) {

  if (($r = mysql_query($s)) && ($r = mysql_fetch_row($r)))
    return $r[0];

  return null;
}

/** For a query supposed to return a number of rows with one value
 each, return an array of all those values. If something went wrong
 then null is returned. 

 $s: the mysql query. */
function m_eval_all($s) {
  $res = mysql_query($s);

  if ($res===false) {
    return $res;
  } else {
    $out = array();
    while ($r = mysql_fetch_row($res)) $out[] = $r[0];
    return $out;
  }
}

?>
