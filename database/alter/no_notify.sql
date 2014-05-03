USE `appendectomy`;
ALTER TABLE proposal ADD no_notify tinyint(1) NOT NULL default '0';
ALTER TABLE petition ADD no_notify tinyint(1) NOT NULL default '0';
