USE `appendectomy`;
ALTER TABLE user_basic ADD notify enum('all_received','not_all_received') NOT NULL default 'not_all_received';
