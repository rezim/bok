ALTER TABLE `printers` ADD `type_color` BOOLEAN NOT NULL DEFAULT FALSE AFTER `iloscstron`;

UPDATE `printers` SET type_color = true where iloscstron_kolor is not NULL AND iloscstron_kolor > 0