<?php

require_once (FS_PATH . "functions/plugins.php");

  /** htmltickets/setup.php
   *
   * Copyright (c) 2010 by Maxime Gamboni
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Render tickets in html.
   *
   * $Id$
   *
   */

function freeseat_plugin_init_htmltickets() {
  global $freeseat_plugin_hooks;
  
  $freeseat_plugin_hooks['ticket_prepare']['htmltickets'] = 'htmltickets_intro';
  $freeseat_plugin_hooks['ticket_render']['htmltickets'] = 'htmltickets_body';
  $freeseat_plugin_hooks['ticket_finalise']['htmltickets'] = 'htmltickets_end';
}

//function htmltickets_intro() {
//  global $lang;
//  echo '<p class="main"><b>'.$lang["intro_finish"].'</b></p>';
//}

/** print a ticket. $booking is an associative array with information
 * about this specific booking (seat number, seat class, etc, as well as 
 * name, address, payment, showid, etc) */
function htmltickets_body($booking) {
  global $ticket_logo;
  echo "<div class='ticket'>";
  echo "<div class='bookid'>";

  if (!do_hook_exists('ticket_left',$booking)) {
    /* If no one provides a replacement for book id display... */
    echo "<p>".$booking["bookid"] /*."<br>";
    echo $booking["bookid"]."<br>";
    echo $booking["bookid"]*/."</p>";
  }
  echo "</div>";
  echo "<p><img class='ticketsponsors' src='".FS_PATH . $ticket_logo."'></p>";

  $oneline = array($booking);
  echo print_booked_seats($oneline,FMT_NOCOUNT|FMT_PRICE|FMT_HTML);

  show_user_info(false,$booking);

  echo "<p class='ticketdate'>";
  show_show_info(get_show($booking["showid"]),false);
  echo "</p>\n";

  echo '</div>';
}

function htmltickets_end() {
  static $htmltickets_printed = false;
  if (!$htmltickets_printed) {
    /* htmltickets_end() may be called more than once in case there
     are several groups of tickets on the page, such as in remail.php
     */
?>
<script language="javascript">
<!--
   window.print();
 // -->
</script>
<?php
    $htmltickets_printed = true;
  }
}

?>
