-- Active: 1751871771198@@127.0.0.1@3306@db_s2_etu003263

CREATE TABLE role (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(100) NOT NULL,  -- 'administrateur'
    description TEXT
);

CREATE TABLE utilisateur (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    adresse VARCHAR(255),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_role INTEGER NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role(id)
);

CREATE TABLE type_client (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,-- entreprise, particulier,etat
    description TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    id_type_client INTEGER NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_type_client) REFERENCES type_client (id)
);

CREATE TABLE type_investissement(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    taux_interet DOUBLE PRECISION,
    description TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE investissement(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    montant DOUBLE PRECISION,
    id_client INTEGER NOT NULL,
    id_type_investissement INTEGER NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES client (id),
    FOREIGN KEY (id_type_investissement) REFERENCES type_investissement (id)
);

CREATE TABLE type_pret(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    taux_interet DOUBLE PRECISION,
    taux_assurance DOUBLE PRECISION,
    description TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE type_payement(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    description TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE pret(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    montant DOUBLE PRECISION,
    id_type_pret INTEGER NOT NULL,
    id_client INTEGER NOT NULL,
    nombre_mensualite INTEGER NOT NULL,
    delai_remboursement INTEGER NOT NULL,
    id_type_payement INTEGER NOT NULL,
    date TIMESTAMP ,
    FOREIGN KEY (id_client) REFERENCES client (id),
    FOREIGN KEY (id_type_pret) REFERENCES type_pret (id),
    FOREIGN KEY (id_type_payement) REFERENCES type_payement (id)
);
CREATE TABLE validation_pret(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    id_pret INTEGER NOT NULL,
    id_utilisateur INTEGER NOT NULL,
    status BOOLEAN NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pret) REFERENCES pret (id),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)
);



CREATE TABLE payement(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    id_pret INTEGER NOT NULL,
    id_type_payement INTEGER NOT NULL,
    montant DOUBLE PRECISION,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pret) REFERENCES pret (id),
    FOREIGN KEY (id_type_payement) REFERENCES type_payement (id)
);

CREATE TABLE compte(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    solde DOUBLE PRECISION,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

alter table payement add column interet DOUBLE PRECISION NOT NULL;
describe type_pret;

ALTER TABLE role ADD COLUMN autorisation INTEGER NOT NULL;
alter table type_pret add column taux_assurance DOUBLE PRECISION NOT NULL;
alter table pret add COLUMN id_type_payement INTEGER NOT NULL;


select*from pret;
SELECT*from payement;
DESCRIBE pret;