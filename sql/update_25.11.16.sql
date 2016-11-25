CREATE TABLE IF NOT EXISTS `config` (
  `stawka_kilometrowa` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `stawka_godzinowa` decimal(10,2) NOT NULL DEFAULT '0.00'
)

INSERT INTO `config` (`stawka_kilometrowa`, `stawka_godzinowa`) VALUES ('0.8358', '25.00');