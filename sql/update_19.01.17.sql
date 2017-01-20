INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('reportsshowdaneklient', 'reports', 'showdaneklient', NULL, NULL, NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '62', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('profitabilityshow', 'profitability', 'show', NULL, '', NULL, '1'), ('profitabilitygetagreementnotifications', 'profitability', 'getagreementnotifications', NULL, '', NULL, '1'), ('profitabilitygetoveralcosts', 'profitability', 'getoveralcosts', NULL, '', NULL, '1'), ('profitabilitygetinvoices', 'profitability', 'getinvoices', NULL, '', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '63', 'rw', NULL), ('1', '64', 'rw', NULL), ('1', '65', 'rw', NULL), ('1', '66', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('customshowdaneklient', 'custom', 'showdaneklient', NULL, NULL, NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '70', 'rw', NULL);

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('2', '70', 'r', NULL)