INSERT INTO type_payement (libelle, description)
VALUES ('Annuité constante', 'Méthode de remboursement de prêt où les versements périodiques sont constants. Chaque mensualité comprend une part d''intérêt dégressive et une part de capital croissante.');

-- utilisateur
INSERT INTO role (libelle, description) VALUES
('Administrateur', 'Utilisateur avec tous les droits, y compris la gestion des utilisateurs et des paramètres du système.'),
('Employé', 'Utilisateur ayant accès aux opérations courantes.'),
('Client', 'Utilisateur final qui peut accéder à ses informations et effectuer certaines opérations.');

INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, id_role) VALUES
('Randriamihaja', 'Patrick', 'admin@banque.com', 'admin123', '0321234567', 'Antananarivo', 1),
('Rakoto', 'Jean', 'employe1@banque.com', 'employe123', '0345678901', 'Fianarantsoa', 2),
('Rasoa', 'Miora', 'client1@banque.com', 'client123', '0339988776', 'Toamasina', 3);

-- client
INSERT INTO type_client (libelle, description) VALUES
('Entreprise', 'Client de type société ou organisation commerciale.'),
('Particulier', 'Client individuel, personne physique.'),
('État', 'Client institutionnel représentant une entité publique.');

INSERT INTO client (id_type_client, nom, prenom, email, telephone, adresse) VALUES
(1, 'Société Générale', 'Finance', 'contact@societegenerale.mg', '0202233445', 'Zone Galaxy, Andraharo'),
(2, 'Rakoto', 'Jean', 'rakoto.jean@gmail.com', '0341234567', 'Lot II H 23, Ambohijatovo'),
(3, 'Ministère', 'des Finances', 'contact@mf.gov.mg', '0202200000', 'Ambohidahy, Antananarivo');

-- investissement 
INSERT INTO type_investissement (libelle, taux_interet, description) VALUES
('Plan Épargne', 3.5, 'Placement sécurisé avec un taux d''intérêt modéré.'),
('Actions', 8.0, 'Investissement en bourse à rendement potentiellement élevé mais risqué.'),
('Obligations', 4.2, 'Titre de créance à revenu fixe émis par l''État ou des entreprises.');

INSERT INTO investissement (libelle, montant, id_client, id_type_investissement) VALUES
('Épargne long terme', 5000000, 2, 1),
('Portefeuille boursier', 12000000, 1, 2),
('Obligations d''État', 8000000, 3, 3);

-- pret
INSERT INTO type_pret (libelle, taux_interet, description) VALUES
('Prêt personnel', 6.5, 'Prêt destiné aux particuliers pour des besoins personnels (achat, voyage, etc.).'),
('Prêt immobilier', 4.2, 'Crédit destiné à l''achat ou la construction d''un bien immobilier.'),
('Prêt étudiant', 2.9, 'Prêt à taux réduit pour financer les études supérieures.'),
('Prêt auto', 5.0, 'Prêt pour l''achat d''un véhicule neuf ou d''occasion.'),
('Prêt professionnel', 7.0, 'Crédit accordé aux entreprises pour financer leur activité ou leurs investissements.');
