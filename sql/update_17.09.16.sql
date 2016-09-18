ALTER TABLE `agreements` ADD `osobakontaktowa` VARCHAR(100) NULL AFTER `nazwa`;
ALTER TABLE `clients` ADD `pokaznumerseryjny` BOOLEAN NOT NULL DEFAULT FALSE AFTER `terminplatnosci`;
ALTER TABLE `clients` ADD `pokazstanlicznika` BOOLEAN NOT NULL DEFAULT FALSE AFTER `pokaznumerseryjny`;