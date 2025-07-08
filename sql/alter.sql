-- Désactive la vérification des clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS payement;
DROP TABLE IF EXISTS validation_pret;
DROP TABLE IF EXISTS pret;
DROP TABLE IF EXISTS type_pret;
DROP TABLE IF EXISTS investissement;
DROP TABLE IF EXISTS type_investissement;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS type_client;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS type_payement;
DROP TABLE IF EXISTS compte;

-- Réactive la vérification des clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE role ADD COLUMN autorisation INTEGER NOT NULL;
