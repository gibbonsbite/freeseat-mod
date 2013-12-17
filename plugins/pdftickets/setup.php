<?php

require_once (FS_PATH . "vars.php");
require_once (FS_PATH . "functions/plugins.php");
require_once (FS_PATH . "functions/format.php");
require_once (FS_PATH . "functions/money.php");
require_once (FS_PATH . "functions/tools.php");

  /** pdftickets/setup.php
   *
   * Copyright (c) 2010 by twowheeler
   * Licensed under the GNU GPL 2. For full terms see the file COPYING.
   *
   * Render tickets in pdf.
   *
   * $Id$
   *
   */

function freeseat_plugin_init_pdftickets() {
    global $freeseat_plugin_hooks;
    
    $freeseat_plugin_hook['config_checkdependencies']['pdftickets'] = 
      'pdftickets_checkdependencies';

    $freeseat_plugin_hooks['ticket_prepare']['pdftickets'] = 'pdftickets_prepare';
    $freeseat_plugin_hooks['ticket_render']['pdftickets'] = 'pdftickets_render';
    $freeseat_plugin_hooks['ticket_finalise']['pdftickets'] = 'pdftickets_finalise';
    
    init_language('pdftickets');
}

/*
Oh, wait, actually we don't need that as the dependencies are included in the plugin.

function pdftickets_checkdependencies() {
  return !config_checkdependency("plugins/pdftickets/dompdf/dompdf_config.inc.php", "dompdf", "http://code.google.com/p/dompdf/downloads/list");
  }*/

function pdftickets_prepare() {
  global $pdftickets_id;

  // Dompdf will throw errors on PHP 4.x. 
  if (version_compare(PHP_VERSION, '5.0.0', '>')) 
    require_once FS_PATH . "plugins/pdftickets/dompdf/dompdf_config.inc.php";
  else 
    fatal_error("PHP version 5 is required for the pdfticket plugin");

  /** This plugin stores series of tickets into SESSION["pdftickets"], and index.php generates the corresponding pdf file. */

  if (!isset($_SESSION["pdftickets"])) {
    $_SESSION["pdftickets"]["next"] = 0; // identifier of the next batch for this session.
  }

  $pdftickets_id = $_SESSION["pdftickets"]["next"];
  $_SESSION["pdftickets"][$pdftickets_id] = array(); // identifiers of the tickets to generate.
  $_SESSION["pdftickets"]["next"] = $pdftickets_id + 1;
}

function pdftickets_render($booking) {
  global $pdftickets_id;

  $_SESSION["pdftickets"][$pdftickets_id][] = $booking;
}

function pdftickets_finalise() {
  global $lang;
  global $pdftickets_id;

  echo "<div class='dontprint'>";
  echo "<h2>".$lang['pdftickets_thankyou']."</h2><p class='main'></p>";  
  echo "<p class='main'><table><tr><td>";
  echo "<div id='download-image'>";
  echo "<img src='".FS_PATH."plugins/pdftickets/down.png"."'></div></td><td>";
  printf($lang["pdftickets_download_link"],'[<a href="'.FS_PATH.'plugins/pdftickets/?key='.$pdftickets_id.'">','</a>]');
  echo "</td></tr></table></p></div>";
}

?>
