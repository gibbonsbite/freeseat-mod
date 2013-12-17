<?php

define('FS_PATH','../../');

session_name("freeseat");
session_start(); // we need the session to populate $plugins

require_once(FS_PATH . 'config-default.php');
@include_once(FS_PATH . "config.php");

$messages = array();

/* Note that we're both initialising $plugins in here (such as
 "$plugins = array()" below) and generating code that initialises
 $plugins. ("$plugins = array()" below). Note that we do *not* want to
 use the plugin selection given by config.php, that's why we're
 including vars.php first and overriding $plugins with $_SESSION
 afterwards. */
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
require_once(FS_PATH . "languages/$language.php");

config_authorise(); // we need the above require_once to run this...

header("Content-Type: text/html; charset=".$lang['_encoding']);
header('Content-Disposition: attachment; filename="config.php"');

echo "<?php\n";
?>
/* Automatically generated configuration file. Go to .../plugins/config/ to edit. */

/** 0 - Plugin selection **/
$plugins = array();

<?php

foreach ($plugins as $plugin) {
  echo '$'."plugins[] = \"".$plugin."\";\n";
}

echo '$language = '.quote_string($language).';';

config_form("config-dist.php", 2);

do_hook_function('config_form', 2);


echo '?>';
?>

