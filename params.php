<?php

define ('FS_PATH','');

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "functions/plugins.php");

require_once (FS_PATH . "functions/configuration.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/session.php");
require_once (FS_PATH . "functions/tools.php");

/** Copyright (C) 2010 Maxime Gamboni. See COPYING for
copying/warranty info.

$Id: params.php 399 2013-01-06 17:48:42Z tendays $
*/

db_connect();

if (!admin_mode()) {
  fatal_error($lang["access_denied"]);
}

$config = get_config();
foreach (array('paydelay_ccard','closing_ccard','shakedelay_ccard','paydelay_post','closing_post','shakedelay_post','max_seats','opening_cash','closing_cash') as $n => $k) {
  if (isset($_POST[$k]))
     $config[$k] = abs($_POST[$k]);
}
// checkboxes
if ($_SERVER["REQUEST_METHOD"]=="POST")
  foreach (array('disabled_ccard','disabled_post','disabled_cash') as $n => $k)
    $config[$k] = isset($_POST[$k])?1:0;

do_hook('params_post'); // may modify $config

$warn=0;
if ($config['shakedelay_ccard'] >= $config['paydelay_ccard']) {
  $warn=1;
  $config['paydelay_ccard'] = $config['shakedelay_ccard'] + 1;
}
if ($config['shakedelay_post'] >= $config['paydelay_post']) {
  $warn=1;
  $config['paydelay_post'] = $config['shakedelay_post'] + 1;
}

if ($warn)
     kaboom($lang["err_payreminddelay"]);

  /*if ($config['opening_cash']<$config['closing_cash']) {
  kaboom("l'ouverture du paiement &agrave; la caisse doit &ecirc;tre au plus tard au moment de la fermeture du paiement &agrave; la caisse.");
  kaboom("(Donnez des valeurs &eacute;gales pour ls d&eacute;sactiver)");
  $config['opening_cash']=$config['closing_cash'];
}*/

set_config($config);

show_head();

echo '<form action="params.php" method="post">'; 

$t1 = "<table class='form' cellspacing='15'><tr><th>".$lang["payment"]."<th>".$lang["from"].'<th>'.$lang["to"].'<th>'.$lang["disabled"];
if (do_hook_exists('ccard_exists')) {
  $t1.= '</tr><tr><td><p>'.$lang["pay_ccard"]. '</p><td><p>('.$lang["immediately"].
    ')</p><td><p><input name="closing_ccard" size="5" value="'.$config['closing_ccard'] .'">&nbsp;'.$lang["minutes"].
    '</p><td align="center"><input type="checkbox" name="disabled_ccard"'.($config["disabled_ccard"]?' checked>':'>');
 } else {
  $t1.='</tr><tr><td colspan=4 align="center"><p class=\'warning\'>('.$lang['err_ccard_cfg'].')</p>';
 }

$t1.= '</tr><tr><td><p>'.$lang["pay_postal"].'</p><td><p>('.$lang["immediately"].
   ')</p><td><p><input name="closing_post"  size="5" value="'. $config['closing_post'] .'">&nbsp;'.$lang["minutes"].
   '</p><td align="center"><input type="checkbox" name="disabled_post"'.($config["disabled_post"]?' checked>':'>');
$t1.= '</tr><tr><td><p>'.$lang["pay_cash"].  '</p><td><p><input name="opening_cash" size="5" value="'. $config['opening_cash'].
   '">&nbsp;'.$lang["minutes"].' ('.$lang["workingdays"].
   ')</p><td><p><input name="closing_cash"  size="5" value="'. $config['closing_cash'] .'">&nbsp;'.$lang["minutes"].
   '</p><td align="center"><input type="checkbox" name="disabled_cash"'.($config["disabled_cash"]?' checked>':'>');
$t1.= '</table>';


$t2 = '<table class="form" cellspacing="15"><tr><th>'.$lang["payment"].'<th>'.$lang["reminders"].'<th>'.$lang["cancellations"];
if (isset($ccard_provider)) {
  $t2.= '</tr><tr><td><p>'.$lang["pay_ccard"].'</p><td><p><input name="shakedelay_ccard" size="3" value="'.$config['shakedelay_ccard'].
   '">&nbsp;'.$lang["days"].
   '</p><td><p><input name="paydelay_ccard" size="3" value="'.$config['paydelay_ccard'].'">&nbsp;'.$lang["days"];
 } else {
  $t2.='</tr><tr><td colspan=3 align="center"><p class=\'warning\'>('.$lang['err_ccard_cfg'].')</p>';
 }
$t2.= '</p><tr><td><p>'.$lang["pay_postal"].'</p><td><p><input name="shakedelay_post"  size="3" value="'.$config['shakedelay_post'].
   '">&nbsp;'.$lang["workingdays"].
   '</p><td><p><input name="paydelay_post" size="3" value="'. $config['paydelay_post']. '">&nbsp;'.$lang["workingdays"];
$t2.= '</p><tr><td><p>'.$lang["pay_cash"].'</p><td><p>('.$lang["noreminders"].')</p><td><p>('.$lang["nocancellations"];
$t2.= ')</p></table>';

printf($lang["intro_params"],$t1,$t2);

?>

<table class="form" cellspacing="15">
<tr><td><p><?php echo $lang["max_seats"]; ?>
<td><p><input name="max_seats" size="3" value="<?php echo $config['max_seats'].'">&nbsp;'.$lang["seats"]; ?>
</p>

<?php do_hook_function('params_edit'); ?>
</table>

<p align="center"><input type="submit" value="<?php echo $lang["save"]; ?>"></p>

</form>

</table>

<?php
//';

echo '<p class="main">';
printf($lang["backto"],'[<a href="index.php">'.$lang["link_index"].'</a>]');
echo '</p>';

show_foot();

?>
