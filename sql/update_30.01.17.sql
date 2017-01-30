INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('li_sharesshow', 'shares', 'show', NULL, 'Wyświetl uprawnienia', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '71', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('sharesgetusershares', 'shares', 'getusershares', NULL, 'Pobierz uprawnienia ', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '72', 'rw', NULL);

INSERT INTO `shares` (`id`, `controller`, `action`, `parent_rowid`, `nazwa`, `rowid`, `activity`) VALUES ('sharesupdatepermission', 'shares', 'updatepermission', NULL, 'Zapisz prawa dostępu', NULL, '1');

INSERT INTO `roles_shares` (`rowid_role`, `rowid_share`, `permission`, `rowid`) VALUES ('1', '73', 'rw', NULL);