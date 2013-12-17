<?php

  /** Language selection. This must be the very first thing we do
   because we pick a character encoding based on the language. */

define('FS_PATH','../../');
require_once('functions.php');

session_name("freeseat");
session_start();

?>
<html>
<head>
<title>FreeSeat Installation Helper &mdash; Language Selection</title>
</head>
<body>
<?php
config_authorise();
require_once( FS_PATH . 'vars.php');

if (isset($_SESSION["language"])) {
  $language = $_SESSION["language"];
 }
?>

<h1>FreeSeat Installation Helper &mdash; Language Selection</h1>

<p>Please select the language in which you want to use FreeSeat.</p>

<form action="plugins.php" method="post">
<?php
  foreach (language_list() as $l) {
  echo '<p><input id="'.$l.'" type="radio" name="language" value="'.$l.'"'
  .($l == $language? " checked" : "").'> <label for="'.$l.'" >'.$l.'</label></p>';
}
?>

<input type="submit">
</form>

</body>
</html>