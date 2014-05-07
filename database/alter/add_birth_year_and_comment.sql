USE `appendectomy`;
ALTER TABLE proposal ADD `birth_year` varchar(5) default NULL;
ALTER TABLE petition ADD `birth_year` varchar(5) default NULL;
ALTER TABLE proposal ADD `userComment` varchar(255) default NULL;
ALTER TABLE petition ADD `userComment` varchar(255) default NULL;
