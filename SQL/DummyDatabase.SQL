DELETE FROM PARTICIPATE;
DELETE FROM DIVES;
DELETE FROM DIVERS;

DELETE FROM TRAINING_LEVELS;
DELETE FROM SITES;
DELETE FROM STATUS;
DELETE FROM PASS;
DELETE FROM SHIPS;
DELETE FROM DIVING_LEVELS;

# -----------------------------------------------------------------------------
#       TABLE : DIVING_LEVELS
# -----------------------------------------------------------------------------


INSERT INTO DIVING_LEVELS (DLV_ID, DLV_LABEL, DLV_DESC, DLV_LEVEL) VALUES
(0, 'sans niveau', 'sans niveau', 0),
(1, 'PB', 'plongeur Bronze', 0),
(2, 'PA', 'plongeur Argent', 0),
(3, 'PO-12m', 'plongeur Or autorisé jusque 12 m', 0),
(4, 'PO-20m', 'plongeur Or autorisé jusque 20 m', 0),
(5, 'PE-20', 'plongeur encadré jusqu’à 20 m', 1),
(6, 'PA-12', 'plongeur autonome jusqu’à 12m', 1),
(7, 'PE-40', 'plongeur encadré jusqu’à 40 m', 1),
(8, 'PA-20', 'plongeur autonome jusqu’à 20 m', 2),
(9, 'PA-40', 'plongeur autonome jusqu’à 40 m', 2),
(10, 'PE-60', 'plongeur encadré jusque 60 m', 2),
(11, 'PA-60', 'plongeur autonome jusqu’à 60 m avec autorisation DP', 3),
(12, 'PA-60 – Guide de palanquée', 'Guide de palanquée', 4);

# -----------------------------------------------------------------------------
#       TABLE : SITES
# -----------------------------------------------------------------------------


INSERT INTO SITES (SIT_ID, SIT_NAME, SIT_LONGITUDE, SIT_LATITUDE, SIT_DEPTH) VALUES
(1, 'ASTAN', 0.0, 0.0, 50),
(2, 'GRANDES FOURCHES', 0.0, 0.0, 40),
(3, 'CHÂTEAU DU TAUREAU', 0.0, 0.0, 30),
(4, 'LA NOIRE', 0.0, 0.0, 30),
(5, 'LE PARADIS', 0.0, 0.0, 30),
(6, 'LE POT DE FER', 0.0, 0.0, 60),
(7, 'LILE VERTE', 0.0, 0.0, 20),
(8, 'ARCHODONOU', 0.0, 0.0, 30),
(9, 'STOLVEZEN', 0.0, 0.0, 40),
(10, 'LES TREPIEDS', 0.0, 0.0, 40),
(11, 'HENRI JAMES', 0.0, 0.0, 60),
(12, 'LABOUKIR', 0.0, 0.0, 30),
(13, 'CORBEAU-CALIG', 0.0, 0.0, 30),
(14, 'CORBEAU', 0.0, 0.0, 30);

# -----------------------------------------------------------------------------
#       TABLE : TRAINING_LEVELS
# -----------------------------------------------------------------------------


INSERT INTO TRAINING_LEVELS (TRL_ID, TRL_LABEL, TRL_DESC) VALUES
(0,'E0', 'n''encadre pas'),
(1, 'E1', 'encadrant jusqu’à 6 m. (nécessite d’être au minimum Niveau 2)'),
(2, 'E2', 'encadrant jusqu’à 40 m (nécessite d’être au minimum Niveau 4)'),
(3, 'E3', 'encadrant moniteur fédéral 1 (nécessite d’être au minimum E2)'),
(4, 'E4', 'encadrant moniteur fédéral 2 (nécessite d’être au minimum E3)');


# -----------------------------------------------------------------------------
#       TABLE : STATUS
# -----------------------------------------------------------------------------

INSERT INTO STATUS (STA_ID, STA_LABEL) VALUES
(1, 'prévue'),
(2, 'effectuée'),
(3, 'annulée');

# -----------------------------------------------------------------------------
#       TABLE : PASS
# -----------------------------------------------------------------------------

INSERT INTO PASS (PAS_ID, PAS_LABEL) VALUES
(1, 'adulte'),
(2, 'enfant');

# -----------------------------------------------------------------------------
#       TABLE : SHIPS
# -----------------------------------------------------------------------------

INSERT INTO SHIPS (SHP_ID, SHP_NAME, SHP_SEATS) VALUES
(1, 'LE DAUPHIN', 25),
(2, 'LESTELLEN', 12),
(3, 'LE BEKLEM', 35);

# -----------------------------------------------------------------------------
#       TABLE : DIVERS
# -----------------------------------------------------------------------------

INSERT INTO DIVERS (DVR_LICENCE, DLV_ID, PAS_ID, TRL_ID, DVR_NAME, DVR_FIRST_NAME, DVR_MC_DATE, DVR_PASSWORD, DVR_ACTIVE, DVR_ISADMIN, DVR_CANDRIVE, DVR_CANMONITOR, DVR_CANDIRECT) VALUES
(1001, 5, 1, 1, 'Chevalier-Passoni', 'Christelle', '2018-05-21', 'password123', TRUE, FALSE, FALSE, TRUE, FALSE),
(1002, 8, 1, 0, 'Delhoumi', 'Sylvian', '2019-03-15', 'password234', TRUE, FALSE, TRUE, FALSE, TRUE),
(1003, 7, 1, 0, 'Jort', 'Fabienne', '2020-07-11', 'password345', TRUE, TRUE, TRUE, TRUE, FALSE),
(1004, 9, 1, 2, 'Porcq', 'Eric', '2017-10-05', 'password456', TRUE, FALSE, FALSE, FALSE, FALSE),
(1005, 6, 2, 0, 'Secouard', 'Stéphane', '2016-12-22', 'password567', TRUE, FALSE, TRUE, FALSE, TRUE);

# -----------------------------------------------------------------------------
#       TABLE : DIVES
# -----------------------------------------------------------------------------

INSERT INTO DIVES (DIV_ID, DVR_LICENCE_MONITORS, SHP_ID, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, STA_ID, DLV_ID, SIT_ID, DIV_DATE, DIV_HEADCOUNT, DIV_COMMENT) VALUES
(1, 1001, 1, 1002, 1002, 1, 1, 4, '2024-04-10 08:00:00', 8, 'Belle plongée matinale avec une bonne visibilité'),
(2, 1003, 3, 1005, 1002, 1, 1, 11, '2024-04-12 14:30:00', 12, 'Plongée de l’après-midi, rencontre avec une faune riche'),
(3, 1003, 2, 1002, 1003, 2, 1, 7, '2023-04-15 09:30:00', 10, 'Sortie réussie, courants faibles, excellente pour les photographes sous-marins.');

# -----------------------------------------------------------------------------
#       TABLE : PARTICIPATE
# -----------------------------------------------------------------------------

INSERT INTO PARTICIPATE (DVR_LICENCE, DIV_ID, PAR_CANCELLED) VALUES
(1003, 1, FALSE),
(1004, 1, FALSE),
(1005, 1, FALSE),
(1001, 2, FALSE),
(1004, 2, FALSE);