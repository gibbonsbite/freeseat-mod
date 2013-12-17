<?php

define('FS_PATH','../../');

  /* This page receives a plugin selection from plugins.php */

session_name("freeseat");
session_start();

/* NOT loading vars.php because $_SESSION may override $language (and vars.php
 includes language file specified in config.php). */

require_once(FS_PATH . 'config-default.php');
@include_once(FS_PATH . "config.php");

/* plugin (and language) selection done in the session override
 whatever is in config.php, precisely so that it may affect the
 construction of config.php. */
if (isset($_SESSION["plugins"]))
  $plugins = $_SESSION["plugins"];

if (isset($_SESSION["language"])) {
  $language = $_SESSION["language"];
 }
  /* plugins selected in plugins.php and passed through POST overrides
   SESSION (which overrides config.php which overrides
   config-default). */

if (isset($_POST['plugin_selection'])) {
  $plugins = array();
  foreach( $_POST as $key => $value) {
    if (substr($key,0,7)=='plugin_') {
      $plugins[] = substr($key,7);
    }
  }
  $_SESSION['plugins'] = $plugins;
 }

  /* Only import plugin handling code *after* setting up $plugins, so
   that plugins may add their configuration options to this page */

require_once(FS_PATH . 'functions/plugins.php');
require_once(FS_PATH . 'plugins/config/functions.php');

/* Set encoding so that special characters entered in the form get
 encoded the right way. */

require_once (FS_PATH . "languages/$language.php");
header("Content-Type: text/html; charset=".$lang['_encoding']);

?>
<html>
<head>
<title><?php
echo $lang["config_title"] . ' &mdash; ' . $lang["config_config"] . "</title>";
?></title>
<style>
.configitem {
  font-weight: bold;
  }

 .warning {
    color : red;
    font-variant : small-caps;
    text-align : center;
 }
</style>
</head>
<body>
<?php
config_authorise();

 if (isset($_SESSION["messages"])) {
   $messages = $_SESSION["messages"];
   flush_messages_html();
 }
 
echo '<h1>'.$lang['config_title'] . ' &mdash; ' . $lang['config_config'] . "</h1>";
?>


<form action="configlink.php" method="post">
<?php

config_form('config-dist.php', 0);

do_hook_function('config_form', 0);

?>
<input type="submit">
</form>
</body>
</html>