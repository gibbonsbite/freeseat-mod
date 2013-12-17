<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/seat.php");
require_once (FS_PATH . "functions/session.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: logoff.php 350 2011-06-05 08:32:03Z tendays $
*/

db_connect();
unlock_seats();
session_destroy();

header("Location: ".freeseat_url("index.php", false));

?>