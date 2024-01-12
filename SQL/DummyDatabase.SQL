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
("A-04-100001", 5, 1, 1, 'Passoni-Chevalier', 'Christelle', '2018-05-21', 'password123', TRUE, FALSE, FALSE, TRUE, FALSE),
("A-04-100002", 8, 1, 0, 'Delhoumi', 'Sylvian', '2019-03-15', 'password234', TRUE, FALSE, TRUE, FALSE, TRUE),
("A-04-100003", 7, 1, 0, 'Jort', 'Fabienne', '2020-07-11', 'password345', TRUE, TRUE, TRUE, TRUE, FALSE),
("A-04-100004", 9, 1, 2, 'Porcq', 'Eric', '2017-10-05', 'password456', TRUE, FALSE, FALSE, FALSE, FALSE),
("A-04-100005", 6, 2, 0, 'Secouard', 'Stéphane', '2016-12-22', 'password567', TRUE, FALSE, TRUE, FALSE, TRUE),
("A-04-100006", 5, 1, 1, '1', 'A', '2018-05-21', '6', TRUE, FALSE, FALSE, TRUE, FALSE),
("A-04-100007", 8, 1, 3, '2', 'B', '2019-03-15', '7', TRUE, FALSE, TRUE, FALSE, TRUE),
("A-04-100008", 7, 1, 4, '3', 'C', '2020-07-11', '8', TRUE, TRUE, TRUE, TRUE, FALSE),
("A-04-100009", 9, 1, 2, '4', 'D', '2017-10-05', '9', TRUE, FALSE, FALSE, FALSE, FALSE),
("A-04-100010", 6, 2, 0, '5', 'E', '2016-12-22', '10', TRUE, FALSE, TRUE, FALSE, TRUE);

# -----------------------------------------------------------------------------
#       TABLE : DIVES
# -----------------------------------------------------------------------------

INSERT INTO DIVES (DIV_ID, DVR_LICENCE_MONITORS, SHP_ID, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, STA_ID, DLV_ID, SIT_ID, DIV_DATE, DIV_HEADCOUNT, DIV_COMMENT) VALUES
(1, "A-04-100001", 1, "A-04-100002", "A-04-100002", 1, 1, 4, '2024-04-10 09:00:00', 8, 'Belle plongée matinale avec une bonne visibilité'),
(2, "A-04-100003", 3, "A-04-100005", "A-04-100002", 1, 1, 11, '2024-04-12 13:30:00', 12, 'Plongée de l’après-midi, rencontre avec une faune riche'),
(3, "A-04-100003", 2, "A-04-100002", "A-04-100003", 2, 1, 7, '2023-04-15 18:00:00', 10, 'Sortie réussie, courants faibles, excellente pour les photographes sous-marins.');


-- Insert 14 planned (prévue) dives
INSERT INTO DIVES (DIV_ID, DVR_LICENCE_MONITORS, SHP_ID, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, STA_ID, DLV_ID, SIT_ID, DIV_DATE, DIV_HEADCOUNT, DIV_COMMENT) VALUES
(4, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 2, '2024-05-15 09:00:00', 12, 'Plongée au site GRANDES FOURCHES'),
(5, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 3, '2024-06-10 09:00:00', 14, 'Plongée au site CHÂTEAU DU TAUREAU'),
(6, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 7, '2024-01-24 09:00:00', 7, 'Plongée prévue à L''ILE VERTE'),
(7, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 8, '2024-01-27 13:30:00', 11, 'Plongée au site ARCHODONOU'),
(8, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 9, '2024-02-01 09:00:00', 6, 'Plongée au site STOLVEZEN'),
(9, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 10, '2024-02-04 13:30:00', 12, 'Plongée au site LES TREPIEDS'),
(10, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 11, '2024-02-08 09:00:00', 9, 'Plongée au site HENRI JAMES'),
(11, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 12, '2024-02-11 18:00:00', 13, 'Plongée à L''ABOUKIR'),
(12, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 13, '2024-02-15 13:30:00', 14, 'Plongée au site CORBEAU-CALIG'),
(13, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 14, '2024-02-19 09:00:00', 12, 'Plongée au site CORBEAU'),
(14, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 2, '2024-02-22 18:00:00', 15, 'Deuxième plongée au site GRANDES FOURCHES'),
(15, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 2, '2024-03-15 09:00:00', 12, 'Superbe plongée au site GRANDES FOURCHES'),
(16, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 3, '2024-03-10 09:00:00', 14, 'Plongée au site CHÂTEAU DU TAUREAU, belle faune'),
(17, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 1, 5, 4, '2024-03-13 13:30:00', 10, 'Plongée à LA NOIRE'),
(18, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 5, '2024-03-17 09:00:00', 8, 'Plongée au site LE PARADIS'),
(19, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 1, 5, 6, '2024-03-20 18:00:00', 15,  'Plongée au site LE POT DE FER'),

-- Insert 8 completed (effectuée) dives
(20, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 4, '2024-12-20 13:30:00', 10, 'Plongée effectuée à LA NOIRE, excellente visibilité'),
(21, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 2, 6, 5, '2024-01-02 18:00:00', 8,  'Plongée effectuée au site LE PARADIS, conditions parfaites'),
(22, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 6, '2024-12-03 09:00:00', 9,  'Plongée effectuée au site LE POT DE FER, belle expérience'),
(23, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 2, 6, 7, '2024-12-06 13:30:00', 11, 'Plongée effectuée à L''ILE VERTE, faune diverse rencontrée'),
(24, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 8, '2024-12-09 09:00:00', 12, 'Plongée effectuée au site ARCHODONOU, courant modéré'),
(25, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 9, '2024-12-12 18:00:00', 7,  'Plongée effectuée au site STOLVEZEN, visibilité parfaite'),
(26, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 10, '2024-12-15 09:00:00', 13, 'Plongée effectuée au site LES TREPIEDS, magnifique soleil'),
(27, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 2, 6, 4, '2024-12-20 13:30:00', 10, 'Plongée effectuée à LA NOIRE, excellente visibilité'),
(28, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 5, '2024-12-24 09:00:00', 6,  'Plongée effectuée au site LE PARADIS, ambiance festive'),
(29, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 2, 6, 11, '2024-12-27 13:30:00', 14, 'Plongée effectuée à HENRI JAMES, épave impressionnante'),
-- More rows for completed dives (up to DIV_ID 22)

-- Insert 8 canceled (annulée) dives
(30, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 3, 7, 6, '2023-12-01 09:00:00', 15, 'Plongée annulée au site LE POT DE FER, mauvaise météo'),
(31, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 3, 7, 7, '2023-12-05 13:30:00', 12, 'Plongée annulée à L''ILE VERTE, visibilité réduite'),
(32, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 3, 7, 8, '2023-12-08 18:00:00', 8, 'Plongée annulée au site ARCHODONOU, conditions dangereuses'),
(33, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 3, 7, 9, '2023-12-12 09:00:00', 10, 'Plongée annulée au site STOLVEZEN, problèmes techniques'),
(34, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 3, 7, 10, '2023-12-15 13:30:00', 11, 'Plongée annulée au site LES TREPIEDS, équipe insuffisante'),
(35, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 3, 7, 11, '2023-12-19 09:00:00', 9, 'Plongée annulée à HENRI JAMES, mauvaise visibilité'),
(36, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 3, 7, 12, '2023-12-22 18:00:00', 12, 'Plongée annulée à L''ABOUKIR, mer trop agitée'),
(37, 'A-04-100001', 1, 'A-04-100002', 'A-04-100003', 3, 7, 13, '2023-12-26 13:30:00', 13, 'Plongée annulée au site CORBEAU-CALIG, alerte météo'),
(38, 'A-04-100001', 1, 'A-04-100005', 'A-04-100003', 3, 7, 14, '2023-12-30 09:00:00', 14, 'Plongée annulée au site CORBEAU, conditions inadéquates');
-- More rows for canceled dives (up to DIV_ID 30)

# -----------------------------------------------------------------------------
#       TABLE : PARTICIPATE
# -----------------------------------------------------------------------------

INSERT INTO PARTICIPATE (DVR_LICENCE, DIV_ID, PAR_CANCELLED) VALUES
("A-04-100003", 1, FALSE),
("A-04-100004", 1, FALSE),
("A-04-100005", 1, FALSE),
("A-04-100001", 2, FALSE),
("A-04-100004", 2, FALSE);
