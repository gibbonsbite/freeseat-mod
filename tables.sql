-- Note: since version 1.4.0 you are no longer supposed to modify and
-- run this file directly. Use the config plugin instead, so that
-- grant statements and plugin-specific tables are generated correctly.

-- Copyright (C) 2010 Maxime Gamboni. See COPYING for copying/warranty
-- info.

CREATE DATABASE $db;
USE $db;

-- note: expiration is not yet used but will soon be (for overriding
-- default cancellation delays).

-- name has been deprecated in favour of firstname and lastname.

-- groupid is an identifier given to a set of bookings made
-- simultaneously. To ensure uniqueness I am simply taking the booking
-- id of the first booking in the set as groupid for the set. I needed
-- this because each booking is independent from the others in the
-- booking table but when user does a credit card payment we need to
-- know what he is paying
CREATE TABLE booking (
  id int(10) NOT NULL auto_increment,
  seat int(10) NOT NULL default '0',
  state int(2) NOT NULL default '0', -- ST_something in booking.php
  cat int(2) NOT NULL default '0', -- price category (CAT_something in booking.php)
--   name varchar(128) NOT NULL default '',
  firstname varchar(128) NOT NULL default '',
  lastname varchar(128) NOT NULL default '',
  email varchar(128) default NULL,
  phone varchar(128) default NULL,
  timestamp datetime default NULL,
  payment int(2) NOT NULL default '0', -- PAY_something in booking.php
  groupid int(10) default NULL,
  showid int(10) NOT NULL default '0',
  address varchar(255) default NULL,
  postalcode varchar(15) default NULL,
  city varchar(127) default NULL,
  us_state varchar(2) default NULL,
  country varchar(2) default NULL,
  expiration datetime not null default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
);

-- the following line tells the config script not to verify existence
-- of this table, because the admin user isn't granted access to it
-- so it would look like the table is missing.

-- @meta skip
CREATE TABLE ccard_transactions (
  numxkp varchar(25) NOT NULL default '0', -- transaction ID
  groupid int(9) NOT NULL default '0',
  amount int(6) default NULL, -- amount in hundredths of $currency (pennies, cents, etc)
  PRIMARY KEY  (numxkp)
);

-- this table should contain only one line
CREATE TABLE config (
  max_seats int(9) not null default 0,
  paydelay_ccard int(9) not null default 0,
  closing_ccard int(9) not null default 0,
  shakedelay_ccard int(9) not null default 0,
  disabled_ccard int(1) not null default 0,
  paydelay_post int(9) not null default 0,
  closing_post int(9) not null default 0,
  shakedelay_post int(9) not null default 0,
  disabled_post int(1) not null default 0,
  opening_cash int(9) not null default 0,
  closing_cash int(9) not null default 0,
  disabled_cash int(1) not null default 0
-- , spectacleid int(5) not null default 1    
);

CREATE TABLE price (
  spectacle int(7) default NULL,
  cat int(2) default NULL,
  class int(3) default NULL,
  price int(10) default NULL, -- amount in hundredths of $currency (pennies, cents, etc)
  primary key (spectacle,cat,class)
);

-- sid is the PHP session id used to lock the seat
CREATE TABLE seat_locks (
  seatid int(10) NOT NULL default '0',
  showid int(10) NOT NULL default '0',
  sid varchar(50) NOT NULL default '0',
  until int(10) not null,
  PRIMARY KEY  (seatid,showid)
);

-- set "row" to -1 for unnumbered seats. In that case, col, x and y are ignored.
CREATE TABLE seats (
  id int(10) NOT NULL auto_increment,
  theatre int(7) NOT NULL default '0',
  row varchar(5) NOT NULL default '',
  col varchar(5) NOT NULL default '',
  extra varchar(64) default NULL,
  zone varchar(32) default NULL,
  class int(3) NOT NULL default '0', -- seat class (first class seat, second class seat, etc)
  x int(3) NOT NULL default '0',
  y int(3) NOT NULL default '0',
  PRIMARY KEY  (id)
);

-- no booking is permitted to non-admins when disabled is set to
-- 1. Note there may be other reasons for a show to be disabled, like
-- no payment method available or no seats available.
CREATE TABLE shows (
  id int(10) NOT NULL auto_increment,
  spectacle int(7) not null,
  theatre int(7) not null,
  date date not null,
  time time not null,
  disabled int(1) not null,
  PRIMARY KEY  (id)
);

-- imagesrc is the path to a photo, logo or similar image (don't make
-- it too big: try 150x100 pixels)

-- description is a long text field with program notes or
-- advertisement text

-- note that imagesrc is relative to $upload_url
CREATE TABLE spectacles (
  id int(7) NOT NULL auto_increment,
  name varchar(64) not null default 'unnamed',
  imagesrc varchar(64) default NULL,
  description text default NULL,
  PRIMARY KEY  (id)
);


-- staggered_seating: whether we want the seating chart to alternate odd and even rows
-- imagesrc: here it is the complete url
CREATE TABLE theatres (
  id int(7) NOT NULL auto_increment,
  name varchar(64) not null default 'unnamed',
  imagesrc varchar(64) default NULL,
  staggered_seating int(1) not null default 0,
  PRIMARY KEY  (id)
);

CREATE TABLE class_comment (
	spectacle int (7) not null,
	class int(2) not null,
	comment varchar(64),
	primary key(spectacle,class)
);

GRANT LOCK TABLES ON $db.* TO $dbuser;
GRANT SELECT, INSERT ON $db.booking TO $dbuser;
GRANT SELECT ON $db.config TO $dbuser;
GRANT SELECT ON $db.seats TO $dbuser;
GRANT SELECT,INSERT,UPDATE,DELETE ON $db.seat_locks TO $dbuser;
GRANT SELECT ON $db.price TO $dbuser;
GRANT SELECT ON $db.class_comment TO $dbuser;
GRANT SELECT ON $db.theatres TO $dbuser;
GRANT SELECT ON $db.spectacles TO $dbuser;
GRANT SELECT ON $db.shows TO $dbuser;

GRANT SELECT,DELETE ON $db.seat_locks TO $systemuser;
GRANT SELECT ON $db.config TO $systemuser;
GRANT SELECT, UPDATE ON $db.booking TO $systemuser;
GRANT SELECT ON $db.shows TO $systemuser;
GRANT SELECT ON $db.seats TO $systemuser;
GRANT SELECT ON $db.theatres TO $systemuser;
GRANT SELECT, INSERT ON $db.ccard_transactions TO $systemuser;
GRANT SELECT ON $db.price TO $systemuser;
GRANT SELECT ON $db.class_comment TO $systemuser;
GRANT SELECT ON $db.spectacles TO $systemuser;

GRANT LOCK TABLES ON $db.* TO $adminuser;
GRANT SELECT ON $db.seats TO $adminuser;
GRANT SELECT, INSERT, UPDATE ON $db.booking TO $adminuser;
GRANT SELECT,INSERT,UPDATE,DELETE ON $db.seat_locks TO $adminuser;
GRANT SELECT ON $db.shows TO $adminuser;
GRANT SELECT,UPDATE ON $db.config TO $adminuser;
GRANT SELECT ON $db.price TO $adminuser;
GRANT SELECT ON $db.class_comment TO $adminuser;
GRANT SELECT ON $db.spectacles TO $adminuser;
GRANT SELECT ON $db.theatres TO $adminuser;

INSERT INTO config
 (max_seats,paydelay_ccard,closing_ccard,shakedelay_ccard,disabled_ccard,paydelay_post,closing_post,shakedelay_post,disabled_post,opening_cash,closing_cash,disabled_cash) VALUES
 (  20     ,  3           ,  60         ,  2             ,  0           ,  5          ,  8000      ,  3            ,  0          ,  0         ,  88880     ,  0);
