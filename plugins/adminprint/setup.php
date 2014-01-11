<?php

require_once (FS_PATH . "vars.php");
require_once (FS_PATH . "functions/plugins.php");

function freeseat_plugin_init_adminprint() {
    global $freeseat_plugin_hooks;

    $freeseat_plugin_hooks['bookinglist_process']['adminprint'] = 'adminprint_process';
    $freeseat_plugin_hooks['bookinglist_pagebottom']['adminprint'] = 'adminprint_button';
}

function adminprint_process() {
  global $ab,$lang;

  if (count($ab) && isset($_POST["print"])) {
    show_head(true);
	$setstate = ST_PAID; //Set state to PAID when printing
    do_hook('adminprint_process');  // process parameters from bookinglist

    /* Ticketing-printing plugins may request to override ticket
    rendering from other plugins by implementing the _override hooks
    below, and returning true in ticket_prepare_override. Most ticket
    printing routines should only implement the non-override hooks. Of
    course if more than one plugin requests overriding ticket
    rendering, all such plugins will be run side by side. */
    $hide_tickets = do_hook_exists('ticket_prepare_override');
	  foreach ($ab as $x) {
	    do_hook_function('ticket_render_override', $x);
	  }
	  do_hook('ticket_finalise_override');

    if (!$hide_tickets) {
    do_hook('ticket_prepare');
    foreach ($ab as $x)
      do_hook_function('ticket_render', $x);
    do_hook('ticket_finalise');
    }

    print_legal_info();
    $showid = $x['showid'];
    echo "<p class='main'>";
    printf($lang['backto'],"[<a href='bookinglist.php?showid=$showid'>".$lang["link_bookinglist"]."</a>] ");
    echo "</p>";
    show_foot();
    exit;
  }
}

function adminprint_button() {
  global $lang;
  
  // echo '<li><p class="main">';
  printf($lang["print_entries"],'<input type="submit" name="print" value="','">');
  do_hook('adminprint_line');
  // echo '</p></li>';
}
