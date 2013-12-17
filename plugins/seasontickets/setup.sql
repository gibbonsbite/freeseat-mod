use $db;

CREATE TABLE IF NOT EXISTS `seasontickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) DEFAULT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(127) NOT NULL,
  `us_state` varchar(2) NOT NULL,
  `postalcode` varchar(15) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `expiration` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)  
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- Season tickets in the process of being booked are locked in this
-- table until they are added to the bookings and
-- seasontickets_bookings table, preventing parallel booking of a
-- single season ticket.
create table if not exists seasontickets_lock (
  id int(10) unsigned NOT NULL,
  sid varchar(50) NOT NULL default '0',
  until int(10) not null,
  primary key (id)
);

CREATE TABLE IF NOT EXISTS `seasontickets_bookings` (
  `bookingid` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bookingid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

GRANT SELECT,INSERT,UPDATE,DELETE ON $db.seasontickets TO $adminuser;
GRANT SELECT,INSERT ON $db.seasontickets_bookings TO $adminuser;
GRANT SELECT,INSERT,UPDATE,DELETE ON $db.seasontickets_lock TO $adminuser;

GRANT SELECT ON $db.seasontickets TO $dbuser;
GRANT SELECT,INSERT ON $db.seasontickets_bookings TO $dbuser;
GRANT SELECT,INSERT,UPDATE,DELETE ON $db.seasontickets_lock TO $dbuser;

GRANT SELECT,DELETE ON $db.seasontickets_lock TO $systemuser;
