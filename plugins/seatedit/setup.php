<?php

  /** remail/setup.php
   *
   * Copyright (c) 2010 by Maxime Gamboni
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Seatmap editor
   *
   * $Id$
   *
   */


function freeseat_plugin_init_seatedit() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['front_page_admin']['seatedit'] = 'seatedit_fplink';
    $freeseat_plugin_hooks['config_db']['seatedit'] = 'seatedit_config_db';
    init_language('seatedit');
}

function seatedit_fplink() {
    global $lang;
    echo '<p class="main">';
    echo '[<a href="plugins/seatedit/">'.$lang['seatedit_fplink'].'</a>]';
    echo '</p>';
}

function seatedit_config_db($user) {
  return config_checksql_for('plugins/seatedit/setup.sql', $user);
}

?>