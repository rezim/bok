INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('li_profitabilityshow', 'profitability', 'show', NULL, 'Wyświetlanie informacji i przychodach i kosztach', '61', '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '61', 'rw', NULL);