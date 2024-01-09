DROP DATABASE IF EXISTS CARANTEC_DB;

CREATE DATABASE IF NOT EXISTS CARANTEC_DB;
USE CARANTEC_DB;

DROP TABLE IF EXISTS DIVES;
DROP TABLE IF EXISTS DIVERS;

DROP TABLE IF EXISTS PARTICIPATE;
DROP TABLE IF EXISTS TRAINING_LEVELS;
DROP TABLE IF EXISTS SITES;
DROP TABLE IF EXISTS STATUS;
DROP TABLE IF EXISTS PASS;
DROP TABLE IF EXISTS SHIPS;
DROP TABLE IF EXISTS DIVING_LEVELS;


# -----------------------------------------------------------------------------
#       TABLE : DIVES
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS DIVES
 (
   DIV_ID INTEGER NOT NULL  ,
   DVR_LICENCE_MONITORS INTEGER NOT NULL  ,
   SHP_ID INTEGER NOT NULL  ,
   DVR_LICENCE_DIRECTS INTEGER NOT NULL  ,
   DVR_LICENCE_DRIVES INTEGER NOT NULL  ,
   STA_ID INTEGER NOT NULL  ,
   DLV_ID INTEGER NOT NULL  ,
   SIT_ID INTEGER NOT NULL  ,
   DIV_DATE DATETIME NOT NULL  ,
   DIV_HEADCOUNT INTEGER NOT NULL  ,
   DIV_COMMENT VARCHAR(1048) NULL  
   , PRIMARY KEY (DIV_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE DIVES
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_DIVES_DIVERS
     ON DIVES (DVR_LICENCE_MONITORS ASC);

CREATE  INDEX I_FK_DIVES_SHIPS
     ON DIVES (SHP_ID ASC);

CREATE  INDEX I_FK_DIVES_DIVERS3
     ON DIVES (DVR_LICENCE_DIRECTS ASC);

CREATE  INDEX I_FK_DIVES_DIVERS1
     ON DIVES (DVR_LICENCE_DRIVES ASC);

CREATE  INDEX I_FK_DIVES_STATUS
     ON DIVES (STA_ID ASC);

CREATE  INDEX I_FK_DIVES_DIVING_LEVELS
     ON DIVES (DLV_ID ASC);

CREATE  INDEX I_FK_DIVES_SITES
     ON DIVES (SIT_ID ASC);

# -----------------------------------------------------------------------------
#       TABLE : DIVING_LEVELS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS DIVING_LEVELS
 (
   DLV_ID INTEGER NOT NULL  ,
   DLV_LABEL VARCHAR(128) NOT NULL  ,
   DLV_DESC VARCHAR(128) NOT NULL  ,
   DLV_LEVEL INTEGER NOT NULL  
   , PRIMARY KEY (DLV_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : DIVERS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS DIVERS
 (
   DVR_LICENCE INTEGER NOT NULL  ,
   DLV_ID INTEGER NOT NULL  ,
   PAS_ID INTEGER NOT NULL  ,
   TRL_ID INTEGER NOT NULL  ,
   DVR_NAME VARCHAR(128) NOT NULL  ,
   DVR_FIRST_NAME VARCHAR(128) NOT NULL  ,
   DVR_MC_DATE DATE NOT NULL  ,
   DVR_PASSWORD VARCHAR(128) NOT NULL  ,
   DVR_ACTIVE BOOL NOT NULL  ,
   DVR_ISADMIN BOOL NULL  
      DEFAULT 0,
   DVR_CANDRIVE BOOL NULL  ,
   DVR_CANMONITOR BOOL NULL  ,
   DVR_CANDIRECT BOOL NULL  
   , PRIMARY KEY (DVR_LICENCE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE DIVERS
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_DIVERS_DIVING_LEVELS
     ON DIVERS (DLV_ID ASC);

CREATE  INDEX I_FK_DIVERS_PASS
     ON DIVERS (PAS_ID ASC);

CREATE  INDEX I_FK_DIVERS_TRAINING_LEVELS
     ON DIVERS (TRL_ID ASC);

# -----------------------------------------------------------------------------
#       TABLE : SHIPS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SHIPS
 (
   SHP_ID INTEGER NOT NULL  ,
   SHP_NAME VARCHAR(128) NOT NULL  ,
   SHP_SEATS INTEGER NOT NULL  
   , PRIMARY KEY (SHP_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : PASS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS PASS
 (
   PAS_ID INTEGER NOT NULL  ,
   PAS_LABEL VARCHAR(128) NOT NULL  
   , PRIMARY KEY (PAS_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : STATUS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS STATUS
 (
   STA_ID INTEGER NOT NULL  ,
   STA_LABEL VARCHAR(128) NOT NULL  
   , PRIMARY KEY (STA_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : SITES
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SITES
 (
   SIT_ID INTEGER NOT NULL  ,
   SIT_NAME VARCHAR(128) NOT NULL  ,
   SIT_LONGITUDE REAL(12,9) NOT NULL  ,
   SIT_LATITUDE REAL(12,9) NOT NULL  ,
   SIT_DEPTH INTEGER NOT NULL  
   , PRIMARY KEY (SIT_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : TRAINING_LEVELS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TRAINING_LEVELS
 (
   TRL_ID INTEGER NOT NULL  ,
   TRL_LABEL VARCHAR(128) NOT NULL  ,
   TRL_DESC VARCHAR(256) NOT NULL  
   , PRIMARY KEY (TRL_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : PARTICIPATE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS PARTICIPATE
 (
   DVR_LICENCE INTEGER NOT NULL  ,
   DIV_ID INTEGER NOT NULL  ,
   PAR_CANCELLED BOOL NOT NULL  
   , PRIMARY KEY (DVR_LICENCE,DIV_ID) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE PARTICIPATE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_PARTICIPATE_DIVERS
     ON PARTICIPATE (DVR_LICENCE ASC);

CREATE  INDEX I_FK_PARTICIPATE_DIVES
     ON PARTICIPATE (DIV_ID ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_DIVERS (DVR_LICENCE_MONITORS)
      REFERENCES DIVERS (DVR_LICENCE) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_SHIPS (SHP_ID)
      REFERENCES SHIPS (SHP_ID) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_DIVERS3 (DVR_LICENCE_DIRECTS)
      REFERENCES DIVERS (DVR_LICENCE) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_DIVERS1 (DVR_LICENCE_DRIVES)
      REFERENCES DIVERS (DVR_LICENCE) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_STATUS (STA_ID)
      REFERENCES STATUS (STA_ID) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_DIVING_LEVELS (DLV_ID)
      REFERENCES DIVING_LEVELS (DLV_ID) ;


ALTER TABLE DIVES 
  ADD FOREIGN KEY FK_DIVES_SITES (SIT_ID)
      REFERENCES SITES (SIT_ID) ;


ALTER TABLE DIVERS 
  ADD FOREIGN KEY FK_DIVERS_DIVING_LEVELS (DLV_ID)
      REFERENCES DIVING_LEVELS (DLV_ID) ;


ALTER TABLE DIVERS 
  ADD FOREIGN KEY FK_DIVERS_PASS (PAS_ID)
      REFERENCES PASS (PAS_ID) ;


ALTER TABLE DIVERS 
  ADD FOREIGN KEY FK_DIVERS_TRAINING_LEVELS (TRL_ID)
      REFERENCES TRAINING_LEVELS (TRL_ID) ;


ALTER TABLE PARTICIPATE 
  ADD FOREIGN KEY FK_PARTICIPATE_DIVERS (DVR_LICENCE)
      REFERENCES DIVERS (DVR_LICENCE) ;


ALTER TABLE PARTICIPATE 
  ADD FOREIGN KEY FK_PARTICIPATE_DIVES (DIV_ID)
      REFERENCES DIVES (DIV_ID) ;

