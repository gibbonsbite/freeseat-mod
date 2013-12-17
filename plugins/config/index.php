<?php

  /** Main page for the configuration helper. Note that unlike the
   rest of freeseat this page must work fine even if freeseat is not
   configured, there are no databases or config.php file, which is why
   we duplicate some standard functionality like db_connect,
   show_head, etc. */

define('FS_PATH','../../');

session_name("freeseat");
session_start();
$messages = array(); // for kaboom()

/* NOT loading vars.php because $_SESSION may override $language (and vars.php
 includes language file specified in config.php). */

require_once(FS_PATH . 'config-default.php');
@include_once(FS_PATH . "config.php");

/* Language selection done in the session override whatever is in
 config.php, precisely so that it may affect the construction of
 config.php. */

if (isset($_SESSION["language"])) {
  $language = $_SESSION["language"];
 }

$config_detailCounter = 0;

function config_end_detail_block() {
  global $config_detailsPrinted;
  if ($config_detailsPrinted) {
    echo '</div>';
    $config_detailsPrinted = false;
  }
}

function config_print_messages($msg) {
  global $config_detailCounter, $config_detailsPrinted;
  if ($msg) {
    if (!$config_detailsPrinted) {
      $config_detailsPrinted = true;
      $config_detailCounter++;
      echo '<input type="checkbox" id="chkH'.$config_detailCounter
	.'" onchange="if (this.checked) showDetails(\'H'.$config_detailCounter
	.'\'); else hideDetails(\'H'.$config_detailCounter
	.'\');"> <label for="chkH'.$config_detailCounter
	.'"> Show details</label></p>';
      echo '<div class="details" id="detailsH'.$config_detailCounter.'">';
    }
    echo '<ul>';
    foreach ($msg as $m) {
      echo "<li>" . htmlspecialchars($m);
    }
    echo '</ul>';
    //    echo '</div>'; // end_detail_block will print that
  }
}

require_once(FS_PATH . 'vars.php'); // for language strings...
require_once(FS_PATH . 'plugins/config/functions.php');

/** First establish installation status **/
$config_available = config_checkconfig();
$messages_config = $messages; $messages = array();

$dbusers_available = $config_available && config_checkdbusers();
$messages_dbusers = $messages; $messages = array();

/* The following function also connects as admin. */
$admin_available = $dbusers_available && config_checkadmin();
if (mysql_error())
  kaboom(mysql_error());
$messages_admin = $messages; $messages = array();

$tables_available = $admin_available && config_checkalltables();
$messages_tables = $messages; $messages = array();

$dependencies_available = config_checkdependencies();
$messages_dependencies = $messages; $messages = array();

$cron_available = $tables_available && config_checkcron();
$messages_cron = $messages; $messages = array();

/* Note that we don't require cron for setting up seats. */
$seats_available = $tables_available && config_checkseats();
$messages_seats = $messages; $messages = array();

$shows_available = $seats_available && config_checkshows();
$messages_shows = $messages; $messages = array();

?>
<html>
<head>
<title><?php echo $lang['config_title']; ?></title>
<style>
.good {
  font-weight: bold;
  color: green
     }

.medium {
  font-weight: bold;
 color: DarkOrange;
     }

.bad {
  font-weight: bold;
  color: red
     }

.details {
 display: none;
 }
</style>
<script type="text/javascript">
function hideDetails(n)
{
document.getElementById("details".concat(n)).style.display="none";
}
function showDetails(n)
{
document.getElementById("details".concat(n)).style.display="block";
}
</script>
</head>
<body>
<h1><?php echo $lang['config_title']; ?></h1>

<p><?php echo $lang['config_intro']; ?></p>

<ol><li>

<?php
if ($config_available) {
  $class = "good";
 } else {
  $class = "bad";
 }

echo '<p class="'.$class.'">' . $lang['config_config'] . ' ' . $lang['config_'.$class] . '</p>';

config_print_messages($messages_config);
config_end_detail_block();

if ($admin_available || !$dbusers_available) {
  /* Once an admin db account has been set up, no longer let users access
   the configuration information if they aren't logged in. */
  echo '<p>';
  printf($lang['config_click_config'], '<a href="language.php">','</a>');
  echo '</p>';
 } ?>

<li><?php if ($tables_available) {
  echo '<p class="good">'. $lang['config_dbtables']. ' '. $lang['config_good'] . ' '. $lang['config_logged'].'.</p>';
 } else if ($admin_available) { 
  echo '<p class="bad">'.$lang['config_logged_but_no_db'].'</p>';
 
  config_print_messages($messages_dbusers);
  config_print_messages($messages_admin);
  config_print_messages($messages_tables);
  config_end_detail_block();

  echo '<p>';
  printf($lang['config_click_db'], '<a href="db.php">','</a>');
  echo '</p>';
 } else if ($dbusers_available) { 
  echo '  <p class="medium">'.$lang['config_dbusers_but_not_logged'].'</p>';

  config_print_messages($messages_dbusers);
  config_print_messages($messages_admin);
  config_print_messages($messages_tables);
  config_end_detail_block();
?>
  <form id="config_loginform" action="<?php echo freeseat_url('plugins/config/index.php', true); ?>" method="POST">
     <p>Enter your admin password:
  <input name="adminpass" type="password"></p>
     <?php

     if ((!isset($systempass)) || empty($systempass)) {
       /* In case the system password is not in the configuration
	file... We don't reuse SESSION["systempass"] to let the user
	retype it in case of typo etc. */
       ?>
     <p><?php
       echo $lang['config_need_syspass'];
       ?>
  <input name="login_systempass" type="password"></p>
  <p id='config_unsecbutton'>Press this to use an UNSECURE connection (in case the "sec_area"
configuration item is incorrect): <input type="button" value="Use unsecure connection" onClick="document.getElementById('config_loginform').action='.'; document.getElementById('config_unsecbutton').style.display='none';"></p> <?php // emacs candy:';
     }
?>
      <input class="fine-print" type="submit" value="&gt;">
  </form>
</p>
<?php } else if ($config_available) { 
  echo '<p class="bad">'.$lang['config_db'].' '.$lang['config_bad'].'.</p>';
  config_print_messages($messages_dbusers);
  config_print_messages($messages_admin);
  config_print_messages($messages_tables);
  config_end_detail_block();

  echo '<p>';
  printf($lang['config_click_db'], '<a href="db.php">','</a>');
  echo '</p>';
 } else { /* config.php is not setup yet so user can't do
	   anything about the database yet */
  echo '<p>'.$lang['config_db'].'</p>';
 }

if ($dependencies_available) {
  echo '<li><p class="good">' . htmlspecialchars($lang['config_all_dependencies_found']).'</p>';
 } else {
  echo '<li><p class="bad">' . htmlspecialchars($lang['config_missing_dependencies']).'</p>';
  config_print_messages($messages_dependencies);
  config_end_detail_block();
  /* For now the only dependency is phpmailer. If more come up we'll
   have to store that into a map produced by checkependencies(). */
  foreach ($config_missingdeps as $resource => $url) {
    printf('<p>'.$lang['config_can_be_found'].'</p>', $resource,
'<a href="'.$url.'">'.$url.'</a>');
  }
 }

if ($tables_available) {

  if ($cron_available) {
    foreach ($messages_cron as $m) {
      echo "<li><p class='good'>" . htmlspecialchars($m)."</p>";
    }
  } else {
    foreach ($messages_cron as $m) {
      echo "<li><p class='medium'>". htmlspecialchars($m)."</p>";
    }
    echo '<p>';
    printf($lang['config_click_cron'],'<a href="cron.php">', '</a>');
    echo '</p>';

  }
 } else {
  /* the database is not setup yet so cron *should not* be run before. */

  echo '<li><p>'.$lang['config_cron'].'</p>';
    } ?>

<li>
<?php
if ($tables_available) {
  if ($seats_available) {
    foreach ($messages_seats as $m) {
      echo "<p class='good'>". htmlspecialchars($m)."</p>";
    }
  } else {
    foreach ($messages_seats as $m) {
      echo "<p class='bad'>". htmlspecialchars($m)."</p>";
    }
  }

  echo '<p>';
  printf($lang['config_click_seats'],'<a href="../seatedit/">', '</a>');
  echo '</p>';

 } else {
  echo '<p>'.$lang['config_seats'].'</p>';
 } ?>
<li>
<?php
if ($seats_available) {
  if ($shows_available) {
    foreach ($messages_shows as $m) {
      echo "<p class='good'>". htmlspecialchars($m)."</p>";
    }
  } else {
    foreach ($messages_shows as $m) {
      echo "<p class='bad'>". htmlspecialchars($m)."</p>";
    }
  }
  echo '<p>';
  printf($lang['config_click_spectacles'],'<a href="../showedit/">', '</a>');
  echo '</p>';

 } else {
  echo '<p>'.$lang['config_spectacles'].'</p>';

 }

    if ($cron_available && $shows_available) {

      echo '<li><p class="good">'.$lang['config_congratulations'].'</p>';
      echo '<p>'.$lang['config_intro_congratulations'].'</p>';
	}
?>
</ol>

<p class="main">
<?php
printf($lang["backto"],'[<a href="'. FS_PATH. 'index.php">'. $lang["link_index"].'</a>]');
?>
</p>

</body>
</html>
