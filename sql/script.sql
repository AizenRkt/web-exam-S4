DROP DATABASE IF EXISTS tp_flight;
CREATE DATABASE tp_flight CHARACTER SET utf8mb4;
USE tp_flight;

CREATE TABLE role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    valeur VARCHAR(255) NOT NULL
);

CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_role INT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role(id)
);

CREATE TABLE statut (
    id INT PRIMARY KEY AUTO_INCREMENT,
    valeur VARCHAR(255) NOT NULL
);

CREATE TABLE investissement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_statut INT,
    capital INT NOT NULL,
    dateDebut DATE NOT NULL,
    duree INT NOT NULL,
    taux INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_statut) REFERENCES statut(id)
);

CREATE TABLE typePret (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    taux DECIMAL(10,2) NOT NULL,
    duree INT NOT NULL
);

CREATE TABLE pret (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_statut INT,
    valeur INT NOT NULL,
    dateDebut DATE NOT NULL,
    duree INT NOT NULL,
    id_typePret INT,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_statut) REFERENCES statut(id),
    FOREIGN KEY (id_typePret) REFERENCES typePret(id)
);

CREATE TABLE remboursement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_investissement INT,
    id_pret INT,
    valeur INT NOT NULL,
    dateRemboursement DATE NOT NULL,
    FOREIGN KEY (id_investissement) REFERENCES investissement(id),
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE TABLE compteEntreprise (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pret INT,
    id_investissement INT,
    id_remboursement INT,
    valeur INT NOT NULL,
    FOREIGN KEY (id_pret) REFERENCES pret(id),
    FOREIGN KEY (id_investissement) REFERENCES investissement(id),
    FOREIGN KEY (id_remboursement) REFERENCES remboursement(id)
);

CREATE TABLE fondsEtablissement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    montant INT NOT NULL,
    dateAjout DATE NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id)
);

-- Table pour gérer les paiements d'annuités
CREATE TABLE annuite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pret INT,
    annee INT NOT NULL,
    empruntRestant DECIMAL(10,2) NOT NULL,
    interet DECIMAL(10,2) NOT NULL,
    amortissement DECIMAL(10,2) NOT NULL,
    annuite DECIMAL(10,2) NOT NULL,
    valeurNette DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);