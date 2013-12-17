<?php

define('FS_PATH','../../');

require_once( FS_PATH . 'vars.php');
require_once( FS_PATH . 'functions/format.php');
require_once( 'functions.php');

$messages = array();

session_name("freeseat");
session_start();
config_authorise();
show_head(true);

echo '<h1>';
echo $lang["config_title"] . ' &mdash; ' . $lang["config_db"] . "</title>";
echo '</h1>';
?>
<form action="gentables.php" method="POST">
<?php
   if (!admin_mode()) {
/* if we're in admin mode then surely the admin password has been setup already!
(This script doesn't permit changing passwords) */
     echo '<p>'.$lang['config_db_adminpass'].' <code>'.$adminuser.'</code>:';
?>
    <input type="password" name="setadminpass">
  </p>
  <?php }

      if 
	(( !isset($systempass) or empty($systempass)) &&
	 ( !isset($_SESSION["systempass"]) or empty($_SESSION["systempass"]))) {

     echo '<p>'.$lang['config_db_systempass'].' <code>'.$systemuser.'</code>:';
?>
    <input type="password" name="setsystempass">
  </p>
  <?php }
echo '<p>'.$lang['config_db_warning'].'</p>';
?>
  <input type="submit" value="<?php echo $lang['config_click_gentables'];?>">
</form>
<?php
show_foot();
?>
