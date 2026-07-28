-- Add new agreement type visible in "Typ umowy" dropdown.
INSERT INTO agreement_type (description)
SELECT 'wymiana'
WHERE NOT EXISTS (
    SELECT 1 FROM agreement_type WHERE description = 'wymiana'
);

-- Add ACL actions for the new agreement status "wymiana".
-- Note: role mappings (roles_shares) are intentionally not inserted here.
INSERT INTO shares (id, controller, action, parent_rowid, nazwa, activity)
SELECT 'agreementscanListReplacement', 'agreements', 'canListReplacement', NULL, 'Lista umów: wymiana', 1
WHERE NOT EXISTS (
    SELECT 1 FROM shares WHERE id = 'agreementscanListReplacement'
);

INSERT INTO shares (id, controller, action, parent_rowid, nazwa, activity)
SELECT 'agreementscanAddReplacement', 'agreements', 'canAddReplacement', NULL, 'Dodanie umowy: wymiana', 1
WHERE NOT EXISTS (
    SELECT 1 FROM shares WHERE id = 'agreementscanAddReplacement'
);

INSERT INTO shares (id, controller, action, parent_rowid, nazwa, activity)
SELECT 'agreementscanEditReplacement', 'agreements', 'canEditReplacement', NULL, 'Edycja umowy: wymiana', 1
WHERE NOT EXISTS (
    SELECT 1 FROM shares WHERE id = 'agreementscanEditReplacement'
);

INSERT INTO shares (id, controller, action, parent_rowid, nazwa, activity)
SELECT 'agreementscanSaveReplacement', 'agreements', 'canSaveReplacement', NULL, 'Zapis umowy: wymiana', 1
WHERE NOT EXISTS (
    SELECT 1 FROM shares WHERE id = 'agreementscanSaveReplacement'
);

INSERT INTO shares (id, controller, action, parent_rowid, nazwa, activity)
SELECT 'agreementsrequestreplacement', 'agreements', 'requestreplacement', NULL, 'Umowy: żądanie wymiany urządzenia', 1
WHERE NOT EXISTS (
    SELECT 1 FROM shares WHERE id = 'agreementsrequestreplacement'
);
