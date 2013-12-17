<?php

define('FS_PATH','../../');

require_once( FS_PATH . 'vars.php');
require_once( FS_PATH . 'functions/format.php');
require_once( 'functions.php');

session_name("freeseat");
session_start();

$grants = ''; // grant statements

if (!config_checkconfig()) fatal_error('Please set up your initial configuration first');

if (config_checkdbusers() || admin_mode()) {
  if (!config_checkadmin()) fatal_error($lang["access_denied"]);
 } else {
  /* If users haven't been set up yet, take their passwords from POST */
   if (!empty($systempass)) {
     /* password given through the config file. */
     $setsystempass = $systempass;
   } else if (isset($_POST['setsystempass'])) {
     /* password given through the form. */
     $setsystempass = $_POST['setsystempass'];
   } // else: error?!
  $setadminpass = $_POST['setadminpass'];

  $grants .= "GRANT USAGE ON *.* TO $dbuser@localhost IDENTIFIED BY '$dbpass';\n";
  $grants .= "GRANT USAGE ON *.* TO $systemuser@localhost IDENTIFIED BY '$setsystempass';\n";
  $grants .= "GRANT USAGE ON *.* TO $adminuser@localhost IDENTIFIED BY '$setadminpass';\n";
 }

show_head(true);
echo $lang['config_intro_gentables'];
?>
<textarea style="width: 100%; height:80%" readonly>
<?php
  echo $grants;

/* This will set up the $config_missingdb_cache global: */
config_checkalltables();

foreach ($config_missingdb_cache as $sqlfile => $dummy) {
  config_include_sql($sqlfile);
}
?>
</textarea>
<?php
printf($lang["backto"],'[<a href="index.php">'.$lang["config_index"].'</a>]');
 show_foot(); ?>

