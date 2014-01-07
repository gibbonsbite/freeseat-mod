<?php
$lang['config_all_dependencies_found'] = "All dependencies were found";
$lang['config_bad'] = "Not Available";
$lang['config_can_be_found'] = '%1$s can be downloaded from %2$s';
$lang['config_click_config'] = 'Click %1$shere%2$s to set up your initial configuration.';
$lang['config_click_cron'] = 'Click %1$shere%2$s for instructions on setting up your cron tables or scheduled tasks.';
$lang['config_click_db'] = 'Click %1$shere%2$s to set up your database.';
$lang['config_click_gentables'] = 'Generate MySQL Script';
$lang['config_click_seats'] = 'Click %1$shere%2$s to create or modify seatmaps.';
$lang['config_click_spectacles'] = 'Click %1$shere%2$s to create or modify spectacles.';
$lang['config_config'] = "System Configuration";
$lang['config_congratulations'] = "Congratulations";
$lang['config_cron'] = "Cron Setup";
$lang['config_cron_latest'] = "Cronjob last ran on";
$lang['config_cron_never'] = "Cronjob has never been run so far.";
$lang['config_db'] = "Database";
$lang['config_db_adminpass'] = 'Choose a password for the admin user';
$lang['config_db_systempass'] = 'Choose a password for the system user';
$lang['config_db_warning'] = <<<EOD
Warning, after pressing the following button, your passwords may
    be displayed in clear in your browser window.
EOD;
$lang['config_dbtables'] = "Database tables";
$lang['config_dbusers_but_not_logged'] = 'Database users available but you are not logged in.';
$lang['config_fplink'] = "FreeSeat asennus ja j&auml;rjestelm&auml;n asetukset";
$lang['config_good'] = "Available";
$lang["config_group_configuration"] = 'Configuration';
$lang["config_group_configuration_msg"] = 'Plugins useful for setting up FreeSeat. Make sure all are selected when installing the application, you may unselect some later.';
$lang['config_group_operator'] = 'Operator';
$lang['config_group_operator_msg'] = 'Makes life easier for the operator.';
$lang['config_group_payment'] = 'Payment';
$lang['config_group_payment_msg'] = 'Offers more payment methods.';
$lang['config_group_tickets'] = 'Tickets';
$lang['config_group_tickets_msg'] = 'Customises ticket appearance.';
$lang['config_group_user'] = 'User';
$lang['config_group_user_msg'] = 'Tools useful for the ticket buyer.';
$lang['config_group_pricing'] = 'Pricing';
$lang['config_group_pricing_msg'] = 'Supports altering the price in various ways, extra taxes or special offers.';
$lang['config_index'] = "Main configuration page";
$lang['config_intro'] = "Welcome to FreeSeat! This page will help you install and configure FreeSeat.";
$lang['config_intro_congratulations'] = <<<EOD
Your FreeSeat installation is now complete. You might now want to
disable configuration-related plugins through the initial
configuration link above. They can be re-enabled at any time by coming
to this page.
EOD;
$lang['config_intro_cron'] = <<<EOD
<p>If you have not yet done so, make sure <tt>cron.php</tt> is run once a day after midnight. On most linux systems, you'd need to add the following line to your crontab, possibly with some adjustments:</p>
EOD;
$lang['config_intro_genconfig'] = <<<EOD
<p>For security reasons FreeSeat is not allowed to write its own configuration file.</p>
<p>Please save the following file and save it as <code>config.php</code> into the root directory of your FreeSeat installation: %1\$sconfig.php%2\$s.</p>
EOD;
$lang['config_intro_gentables'] = <<<EOD
<p>For security reasons FreeSeat is not allowed to modify or create
its own database schema.</p>
<p>Please run the following MySQL script (try right-click in the box
and "select all") in a MySQL prompt as root, or as a user allowed to
create and modify users, databases and tables.</p>
EOD;
$lang['config_intro_plugins'] = <<<EOD
<p>Please select which features ("plugins") 
you want to enable for your FreeSeat install.</p>

<p>You can come back here later and change your selection if you wish.</p>
EOD;
$lang['config_logged'] = 'and you are logged in';
$lang['config_logged_but_no_db'] = 'You are now logged in but database tables need setting up.';
$lang['config_need_syspass'] = "We'll also need your <em>system</em> password to check your configuration:";
$lang['config_plugins'] = "Feature Selection";
$lang['config_seats'] = "Seatmap definition";
$lang['config_seats_one'] = "1 seatmap is available.";
$lang['config_seats_n'] = '%1$d seatmaps are available.';
$lang['config_seats_none'] = "You have not yet created a seatmap.";
$lang['config_title'] = "FreeSeat Installation Helper";
$lang['config_missing_dependencies'] = 'Some dependencies could not be found';
$lang['config_missing_file'] = 'Could not find file %1$s (at the FreeSeat root directory)';
$lang['config_spectacles']  = "Spectacle Setup";
$lang['config_spectacles_one'] = "1 spectacle is available.";
$lang['config_spectacles_n'] = '%1$d spectacles are available.';
$lang['config_spectacles_none'] = "You have not yet created any spectacle.";
$lang['config_button_config'] = "Proceed to configuration";
?>
