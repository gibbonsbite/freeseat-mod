<?php

define('FS_PATH','../../');

require_once( FS_PATH . 'vars.php');
require_once( FS_PATH . 'functions/format.php');
require_once( 'functions.php');

session_name("freeseat");
session_start();
config_authorise();
show_head(true);

echo '<h1>';
echo $lang["config_title"] . ' &mdash; ' . $lang["config_cron"] . "</title>";
echo '</h1>';

?>
<?php
  /* script_filename is /path/to/freeseat/plugins/config/index.php.
   applying dirname three times removes /index.php, then /config and
   then /plugins, leaving the base freeseat path. */
  $base = dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])));
echo $lang['config_intro_cron'];
?>
<textarea style="width: 100%" readonly>
1 2 * * * sudo -u www-data /usr/bin/php <?php //';
echo '"'.addslashes($base).'/cron.php" "'.addslashes($_SESSION["systempass"]) .'"'; ?>
</textarea>
<?php
echo '<p>';
printf($lang["backto"],'[<a href="index.php">'.$lang["config_index"].'</a>]');
echo '</p>';
show_foot();
?>
