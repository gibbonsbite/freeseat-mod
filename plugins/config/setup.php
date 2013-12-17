<?php

  /** config/setup.php
   *
   * Copyright (c) 2010 by Maxime Gamboni
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Installer and system configuration helper.
   *
   * $Id$
   *
   */


function freeseat_plugin_init_config() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['front_page_admin']['config'] = 'config_fplink';
    $freeseat_plugin_hooks['cron']['config'] = 'config_cron_ts';
    $freeseat_plugin_hooks['config_db']['config'] = 'config_config_db';
    /* This hook should check configuration available in POST and
     return true if it has consistency problems, detailing said
     problems with kaboom()s. */
    $freeseat_plugin_hooks['config_configproblems']['config'] = 'config_configproblems';

    init_language('config');
}

function config_fplink() {
  global $lang;
    echo '<p class="main">';
    echo '[<a href="plugins/config/">'.$lang['config_fplink'].'</a>]';
    echo '</p>';
}

function config_cron_ts() {
  mysql_query('update config set lastcron=now()');
}

function config_config_db($user) {
  return config_checksql_for('plugins/config/setup.sql', $user);
}

function config_configproblems($void) {
  /* TODO this should probably be done in javascript so that
   user-entered data is not lost! */
  $fail = false;
  if ((substr($_POST["sec_area"],0,8) != 'https://')
      && !(isset($_POST["unsecure_login"]) && $_POST["unsecure_login"])) {
    kaboom("Make sure sec_area starts with https:// (or select the unsecure_login box)");
    $fail = true;
  }

  return $fail;
}

?>