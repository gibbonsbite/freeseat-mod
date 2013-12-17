<?php

include_once (FS_PATH . 'plugins/config/functions.php');

  /** remail/setup.php
   *
   * Copyright (c) 2010 by Maxime Gamboni
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Show editor
   *
   * $Id$
   *
   */


function freeseat_plugin_init_showedit() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['front_page_admin']['showedit'] = 'showedit_fplink';
    $freeseat_plugin_hooks['config_db']['showedit'] = 'showedit_config_db';
}

function showedit_fplink() {
    global $lang;
    echo '<p class="main">';
    printf($lang["editshows"],'[<a href="plugins/showedit/">','</a>]');
    echo '</p>';
}

function showedit_config_db($user) {
  return config_checksql_for('plugins/showedit/setup.sql', $user);
}

?>