<?php
// Script de test pour la génération de PDF
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers/PretPDF.php';

// Données de test
$pret = [
    'id' => 1,
    'libelle' => 'Prêt immobilier',
    'montant' => 50000000,
    'nombre_mensualite' => 240,
    'date' => date('Y-m-d H:i:s')
];

$client = [
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'email' => 'jean.dupont@email.com',
    'telephone' => '0341234567',
    'adresse' => '123 Rue de la Paix, Antananarivo'
];

$typePret = [
    'libelle' => 'Prêt immobilier',
    'taux_interet' => 8.5,
    'description' => 'Prêt pour l\'achat d\'un bien immobilier'
];

// Créer le PDF
$pdf = new PretPDF($pret, $client, $typePret);
$pdf->generatePretDocument();

// Générer le nom du fichier
$filename = 'Test_Contrat_Pret_' . date('Y-m-d_H-i-s') . '.pdf';

// Envoyer le PDF au navigateur
$pdf->Output('D', $filename);
?> 