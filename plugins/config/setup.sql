use $db;

-- we add a "lastcron" column in the config table to know the last
-- time the cronjob ran.

alter table config add column lastcron datetime default null;

GRANT UPDATE ON $db.config TO $systemuser;
