DROP DATABASE IF EXISTS ESERCIZI_SQL;

/* Creazione Database */
CREATE DATABASE ESERCIZI_SQL;
USE ESERCIZI_SQL;

/* Creazione Tabelle */
CREATE TABLE UTENTE(
  Username VARCHAR(50) PRIMARY KEY,
  Password VARCHAR(200) NOT NULL,
  Nome VARCHAR(50) NOT NULL,
  Cognome VARCHAR(50) NOT NULL,
  TipoAccesso enum("Libero", "Limitato") DEFAULT "Limitato"
) ENGINE = INNODB;

CREATE TABLE INFO_DATABASE(
  NomeDatabase VARCHAR(50) PRIMARY KEY,
  Descrizione VARCHAR(100),
  Immagine BLOB
) ENGINE = INNODB;

CREATE TABLE DOMANDA(
  Numero INTEGER,
  NomeDatabase VARCHAR(50),
  Domanda VARCHAR(100) NOT NULL,
  Risposta VARCHAR(100),
  PRIMARY KEY (Numero,NomeDatabase),
  FOREIGN KEY (NomeDatabase) REFERENCES INFO_DATABASE(NomeDatabase) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE RISPOSTE_ALUNNI(
  Id INTEGER AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(50) NOT NULL,
  Risposta VARCHAR(200) NOT NULL,
  Domanda VARCHAR(100) NOT NULL,
  NomeDB VARCHAR(50) NOT NULL,
  FOREIGN KEY (Username) REFERENCES UTENTE(Username) ON DELETE CASCADE,
  FOREIGN KEY (NomeDB) REFERENCES INFO_DATABASE(NomeDatabase) ON DELETE CASCADE
) ENGINE = INNODB;

/* Inserimento dei 2 utenti */
INSERT INTO UTENTE (Username, Password, TipoAccesso) VALUES ("Docente", "3b7dbebda8147df74875502f78acf82d44194a4035a8db5c7e75ff4852ac7ce4eb787e7cf13ddf69d708a078c45df4a407d10112a594005fd3590f79c4164d3b", "Libero");
INSERT INTO UTENTE (Username, Password, TipoAccesso) VALUES ("Studente", "8318fd2a10c66e4b79104d884bd83eba5dff1461978f3ed2c094d56141d4ccd0f67b3cf9e3e9d7d5f8c51d79d5623aeb46072fc022821310af0cea1ef0b8b8b9", "Limitato");



/* Creazione di database e inserimenti per eseguire Test */
INSERT INTO INFO_DATABASE (NomeDatabase, Descrizione, Immagine) VALUES ("Animali", "Database dedicato agli animali", "immagine2.jpg");
INSERT INTO DOMANDA (Numero, NomeDatabase, Domanda, Risposta) VALUES (1,"Animali", "Seleziona tutti gli animali carnivori", "select * from carnivori");
INSERT INTO DOMANDA (Numero, NomeDatabase, Domanda, Risposta) VALUES (2,"Animali", "Seleziona tutti gli animali carnivori e mammiferi", "select * from carnivori where Classificazione = 'mammifero'");
INSERT INTO DOMANDA (Numero, NomeDatabase, Domanda) VALUES (3,"Animali", "Seleziona tutti gli animali carnivori che pesano piu' di 80kg");

DROP USER IF EXISTS studente@localhost;
CREATE USER studente@localhost;
GRANT SELECT ON ESERCIZI_SQL.* TO studente@localhost;


DROP DATABASE IF EXISTS Animali;
CREATE DATABASE Animali;
USE Animali;

CREATE TABLE CARNIVORI(
  Nome  VARCHAR(50) PRIMARY KEY,
  Peso  DECIMAL,
  Habitat VARCHAR(100),
  Classificazione VARCHAR(50)
) ENGINE = INNODB;

CREATE TABLE ERBIVORI(
  Nome  VARCHAR(50) PRIMARY KEY,
  Habitat VARCHAR(100),
  Classificazione VARCHAR(50)
) ENGINE = INNODB;

INSERT INTO CARNIVORI (Nome, Peso, Habitat, Classificazione) VALUES ("Tigre", 100, "Foresta", "Mammifero");
INSERT INTO CARNIVORI (Nome, Peso, Habitat, Classificazione) VALUES ("Leone", 160, "Savana", "Mammifero");
INSERT INTO CARNIVORI (Nome, Peso, Habitat, Classificazione) VALUES ("Coccodirllo", 250, "Fiume", "Rettile");
INSERT INTO ERBIVORI (Nome, Habitat, Classificazione) VALUES ("Rinoceronte", "Savana", "Mammifero");
INSERT INTO ERBIVORI (Nome, Habitat, Classificazione) VALUES ("Cervo", "Bosco", "Mammifero");

DROP USER IF EXISTS studente@localhost;
CREATE USER studente@localhost;
GRANT SELECT ON *.* TO studente@localhost;

DROP USER IF EXISTS studenteInsert@localhost;
CREATE USER studenteInsert@localhost;
GRANT SELECT, INSERT, UPDATE ON *.* TO studenteInsert@localhost;
