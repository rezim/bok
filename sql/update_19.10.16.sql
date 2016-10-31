ALTER TABLE `printers` ADD `ulica` VARCHAR(100) NULL AFTER `iloscstron_total`;
ALTER TABLE `printers` ADD `miasto` VARCHAR(70) NULL AFTER `ulica`;
ALTER TABLE `printers` ADD `kodpocztowy` VARCHAR(10) NULL AFTER `miasto`;
ALTER TABLE `printers` ADD `telefon` VARCHAR(50) NULL AFTER `kodpocztowy`;
ALTER TABLE `printers` ADD `mail` VARCHAR(50) NULL AFTER `telefon`;
ALTER TABLE `printers` ADD `nazwa` VARCHAR(100) NULL AFTER `mail`;
ALTER TABLE `printers` ADD `osobakontaktowa` VARCHAR(100) NULL AFTER `nazwa`;

ALTER TABLE `agreements`
  DROP `ulica`,
  DROP `miasto`,
  DROP `kodpocztowy`,
  DROP `telefon`,
  DROP `mail`,
  DROP `nazwa`,
  DROP `osobakontaktowa`;

UPDATE `roles_shares` SET `permission` = 'r' WHERE `roles_shares`.`rowid_role` = 2 AND `roles_shares`.`rowid_share` = 14