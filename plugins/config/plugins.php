<?php

define('FS_PATH','../../');

/* This page receives a language selection from language.php. */

/* Warning, this code is a bit tricky as it dynamically overrides
 configuration variables like $language and $plugins, that are assumed
 to be always and immediately available. In particular we must refrain
 from calling any freeseat function or including any freeseat file at
 all before the environment is setup. */

session_name("freeseat");
session_start();

if (isset($_POST["language"])) {
  $_SESSION["language"] = $_POST["language"];
 }

/* We first load the configuration variables but don't include
 anything else because include files tend to include vars.php, which
 we want to delay until $language and $plugins have been setup. */
require_once (FS_PATH . "config-default.php"); // FROM vars.php
@include_once (FS_PATH . "config.php"); // FROM vars.php

/* plugin (and language) selection done in the session override
 whatever is in config.php, precisely so that it may affect the
 construction of config.php. */
if (isset($_SESSION["plugins"]))
  $plugins = $_SESSION["plugins"];

if (isset($_SESSION["language"]))
  $language = $_SESSION["language"];

/** We may now include files and use freeseat variables and
 functions. vars.php will fill the $lang variable taking into account
 the $language assignment above. Note that functions.php already
 (indirectly) includes vars.php but we re-require it here for clarity
 and code stability. */
require_once('functions.php');
require_once( FS_PATH . 'vars.php');
header("Content-Type: text/html; charset=".$lang['_encoding']);

?>
<html>
<head>
<title><?php
echo $lang["config_title"] . ' &mdash; ' . $lang["config_plugins"] . "</title>";
?><style>
.configitem {
  font-weight: bold;
  }
</style>
</head>
<body>
<?php

config_authorise();

/** use plugin names as *keys* so that we can use isset to check for a
 plugin being selected */
$pset = array();
foreach ($plugins as $plugin) {
  $pset[$plugin] = true;
}

/** Returns a map category -> of available plugins. */
function plugin_map() {
  $plugins = array();
  if ($dh = opendir(FS_PATH . 'plugins')) {
    while (($pname = readdir($dh)) !== false) {
      if (($pname{0} != '.')
	  && (file_exists(FS_PATH . "plugins/$pname/info.php"))) {
	include_once(FS_PATH . "plugins/$pname/info.php");
	$info = $pname."_info";
	if (function_exists($info)) {
	  $plugin = $info();
	  $plugin['name'] = $pname;
	  if (isset($plugin['category']))
	    $cat = $plugin['category'];
	  else
	    $cat = 'misc';

	  if (!isset($plugins[$cat]))
	    $plugins[$cat] = array();

	  $plugins[$cat][] = $plugin;
	} else {
	  echo "<p>missing $info</p>";
	}
      }
    }
    closedir($dh);
  }
  return $plugins;
} ?>

<h1>
<?php
echo $lang['config_title'] . ' &mdash; ' . $lang['config_plugins'] . "</h1>";
echo $lang['config_intro_plugins'];
?>


<form action="config.php" method="POST">
<input type="hidden" name="plugin_selection" value="t">
<?php
  foreach (plugin_map() as $cat => $plugin_in_cat) {
      if (isset($lang["config_group_$cat"])) {
	echo "<h2>".$lang["config_group_$cat"]."</h2>";
	echo "<p><i>".$lang["config_group_${cat}_msg"]."</i></p>";
      } else {
	echo "<h2>$cat</h2>";
      }

      foreach ($plugin_in_cat as $plugin) {
	echo ('<p><input name="plugin_'.$plugin['name'].'" type="checkbox"'
	      .(isset($pset[$plugin['name']])? ' checked':'')
	      .'>');
	echo ' <b>'. $plugin['english_name']. '</b> '.$plugin['summary'];
	echo '</p>';
      }
  }
?>

<input type="submit" value="<?php echo $lang['config_button_config']; ?>">
</form>
</body>
</html>