ALTER TABLE `agreements` ADD `ulica` VARCHAR(100) NULL AFTER `jakczarne`;
ALTER TABLE `agreements` ADD `miasto` VARCHAR(70) NULL AFTER `ulica`;
ALTER TABLE `agreements` ADD `kodpocztowy` VARCHAR(10) NULL AFTER `miasto`;
ALTER TABLE `agreements` ADD `telefon` VARCHAR(50) NULL AFTER `kodpocztowy`;
ALTER TABLE `agreements` ADD `mail` VARCHAR(50) NULL AFTER `telefon`;
ALTER TABLE `agreements` ADD `nazwa` VARCHAR(100) NULL AFTER `mail`;