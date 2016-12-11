CREATE TABLE `bok`.`notifications_type` ( `nazwa` VARCHAR(40) CHARACTER SET latin2 COLLATE latin2_general_ci NULL , `rowid` BIGINT(20) NOT NULL AUTO_INCREMENT , PRIMARY KEY (`rowid`)) ENGINE = InnoDB;

INSERT INTO `notifications_type` (`nazwa`, `rowid`) VALUES ('Awaria urządzenia ', NULL), ('Materiały eksploatacyjne', NULL), ('Konserwacja', NULL), ('Pomoc zdalna', NULL), ('Wina klienta', NULL), ('Prace zaplanowane', NULL);

ALTER TABLE `notifications` ADD `rowid_type` BIGINT(20) NULL AFTER `data_planowana`;