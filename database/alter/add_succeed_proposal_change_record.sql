USE `appendectomy`;
ALTER TABLE proposal_change_record ADD succeed tinyint(1) NOT NULL default '0';
