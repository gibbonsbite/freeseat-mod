<?php

  /** remail/setup.php
   *
   * Copyright (c) 2010 by Maxime Gamboni
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Lets the user retrieve previously booked tickets.
   *
   * $Id$
   *
   */

function freeseat_plugin_init_remail() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['front_page_public']['remail'] = 'remail_fplink';
}

function remail_fplink() {
    global $take_down, $lang;
    echo '<p class="main">';
    if ($take_down)
	printf($lang["remail"],'[',']');
    else
	printf($lang["remail"],'[<a href="plugins/remail/index.php">','</a>]');
    echo '</p>';
}

?>