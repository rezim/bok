INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('reportsshowdaneklient', 'reports', 'showdaneklient', NULL, NULL, NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '62', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('profitabilityshow', 'profitability', 'show', NULL, '', NULL, '1'), ('profitabilitygetagreementnotifications', 'profitability', 'getagreementnotifications', NULL, '', NULL, '1'), ('profitabilitygetoveralcosts', 'profitability', 'getoveralcosts', NULL, '', NULL, '1'), ('profitabilitygetinvoices', 'profitability', 'getinvoices', NULL, '', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '63', 'rw', NULL), ('1', '64', 'rw', NULL), ('1', '65', 'rw', NULL), ('1', '66', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('customshowdaneklient', 'custom', 'showdaneklient', NULL, NULL, NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '67', 'rw', NULL);

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('2', '67', 'r', NULL)

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('printerslogi', 'printers', 'logi', NULL, 'Pokaż logi drukarek', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '74', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('sendfilesgetfiles', 'sendfiles', 'getfiles', NULL, 'Pobierz pliki zgłoszenia', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '75', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('notimailsshow', 'notimails', 'show', NULL, 'Pobierz pliki zgłoszenia', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '76', 'rw', NULL);