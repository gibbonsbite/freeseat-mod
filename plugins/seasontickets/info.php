<?php
function seasontickets_info() {
    return array
	('english_name' => 'Season Tickets',
	 'version' => '1.0',
	 'required_fs_version' => '1.4.0',
   'category' => 'payment',
	 'summary' => 'Enables simple season ticket handling in Freeseat.',
	 'details' => 'This script will add basic season ticket processing to Freeseat. A new administrative page is added allowing 
for adding, editing and deleting season ticket records at plugins/seasontickets/index.php.  On pay.php, it adds an input box 
for entering a season ticket code.  If the code is validated in the database, it allows the user to purchase a number of free 
tickets.  If the user wants additional tickets, the normal payment process takes over to require the payment.  This is 
implemented by deducting the value of the season tickets from the price charged to the user.  The purchase is recorded in the 
seasontickets_bookings table to limit the season tickets to the number allowed for each spectacle.');
}
?>
