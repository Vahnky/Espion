# Espion

Ceci est un projet pour mon école, ou on devait :
- afficher des missions sur la page principale,
- si on clique sur une d'entre elles, on accède sur une autre page aux détails de cette mission.

De plus, on devait créer une page de connection, pour accéder au back office dans lequel on pourrait ajouter : des agents, des cibles, des contacts, des planques ainsi que des missions.
Dans ces dernières on devait pouvoir ajouter, modifier, supprimer les valeurs des colonnes.

Les contraintes pour les missions étaient : 

Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
Sur une mission, la planque est obligatoirement dans le même pays que la mission.
Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise

ATTENTION : Toutes les infos sont Case Sensitive, je n'ai pas ajouté de code supplémentaire pour convertir les chaines en majuscule ou minuscule.

LA db name est AGENCE

Exemple de SQL pour créer les tables et les remplir :


CREATE TABLE Agents (
    AgentID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    DateNaissance DATE,
    CodeIdentification VARCHAR(50),
    Nationalite VARCHAR(50),
    Specialite VARCHAR(255)
);

CREATE TABLE Admins (
    AdminID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    Pass VARCHAR(255) NOT NULL,
    AdresseMail VARCHAR(255),
    DateCreation DATE
);


CREATE TABLE Cibles (
    CibleID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    DateNaissance DATE,
    NomDeCode VARCHAR(50),
    Nationalite VARCHAR(50)
);


CREATE TABLE Contacts (
    ContactID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    DateNaissance DATE,
    NomDeCode VARCHAR(50),
    Nationalite VARCHAR(50)
);


CREATE TABLE Planques (
    PlanqueID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Code VARCHAR(50) UNIQUE,
    Adresse VARCHAR(255),
    Pays VARCHAR(50),
    Type VARCHAR(50)
);

CREATE TABLE Missions (
    MissionID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255) NOT NULL,
    Description VARCHAR(255),
    NomDeCode VARCHAR(50),
    Pays VARCHAR(50),
    NomAgent VARCHAR(255),
    NomContact VARCHAR(255),
    NomCible VARCHAR(255),
    Type VARCHAR(255),
    Statut VARCHAR(50),
    CodePlanque INT,
    SpecialiteRequise VARCHAR(255),
    DateDebut DATE,
    DateFin DATE
);


INSERT INTO Admins (Nom, Prenom, AdresseMail, Pass, DateCreation)
VALUES ('Dupont', 'Jane', 'jane@A.com', SHA2('123', 512), '2024-03-14');


INSERT INTO Agents (Nom, Prenom, DateNaissance, CodeIdentification, Nationalite, Specialite)
VALUES 	('Libi', 'Fab', '1985-10-10', '007', 'Française', 'Espionnage'),
	('Kaspa', 'Gary', '1980-01-01', '001', 'Russe', 'Espionnage');
	



INSERT INTO Cibles (Nom, Prenom, DateNaissance, NomDeCode, Nationalite)
VALUES
    ('VL', 'Maxime', '1991-02-02', 'A', 'Française'),
    ('Aroni', 'Lev', '2000-01-01', 'B', 'Arménienne');


INSERT INTO Contacts (Nom, Prenom, DateNaissance, NomDeCode, Nationalite)
VALUES
    ('Hika', 'Naka', '1982-10-10', 'C', 'Américaine'),
    ('Wes', 'So', '1975-09-09', 'D', 'Allemande'),
	('Baki', 'Etienne', '1970-08-09', 'E', 'Francais');

INSERT INTO Planques (Code, Adresse, Pays, Type)
VALUES
    ('100', '12 Rue du Port', 'France', 'Phare'),
    ('200', '14 Avenue Albert', 'Allemagne', 'Cabane')



INSERT INTO Missions (Titre, Description, NomDeCode, Pays, NomAgent, NomContact, NomCible, Type, Statut, CodePlanque, SpecialiteRequise, DateDebut, DateFin)
VALUES
    ('Mission secrète', 'Infiltration', 'Q', 'France', 'Kasparov', 'Bacrot', 'Aronian', 'Espionnage', 'En cours', 123, 'Espionnage', '2024-03-20', '2024-04-10');

