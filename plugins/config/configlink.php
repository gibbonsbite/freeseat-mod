<?php

define('FS_PATH','../../');

session_name("freeseat");
session_start(); // we need the session to populate $plugins

require_once(FS_PATH . 'config-default.php');
@include_once(FS_PATH . "config.php");

$messages = array();

/* Note that we're both initialising $plugins in here (such as
 "$plugins = array()" above) and generating code that initialises
 $plugins (in genconfig). Also note that we do *not* want to use the
 plugin selection given by config.php, that's why we're including
 config.php first and overriding $plugins with $_SESSION afterwards. */
$plugins = array();
foreach ($_SESSION["plugins"] as $plugin) {
  $plugins[] = $plugin;
}

if (isset($_SESSION["language"])) {
  $language = $_SESSION["language"];
 }
/* Only import plugin handling code *after* setting up $plugins, so
 that plugins may add their configuration options to this page */

require_once(FS_PATH . 'plugins/config/functions.php');
require_once(FS_PATH . 'functions/plugins.php');
require_once (FS_PATH . "languages/$language.php");
header("Content-Type: text/html; charset=".$lang['_encoding']);

config_authorise(); // we need the above require_once to run this...

/* Now check if the user-provided data makes sense, otherwise send
 back to config.php. */

if (do_hook_exists('config_configproblems')) {
  $_SESSION['messages'] = $messages;
  header("Location: config.php");
  exit();
}

/* Store POST values into config_post so that genconfig can retrieve them. */
$_SESSION["config_post"] = $_POST;

?>
<html>
<head><title>FreeSeat Installation Helper &mdash; Initial Configuration</title></head>
<body>
<h1>config.php</h1>
<?php printf($lang['config_intro_genconfig'], '<a href="genconfig.php">', '</a>'); ?>

<?php
printf($lang["backto"],'[<a href="index.php">'.$lang["config_index"].'</a>]');
?>
</body>
</html>

