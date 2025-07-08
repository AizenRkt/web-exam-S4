<?php
require_once(__DIR__ . '/../vendor/fpdf186/fpdf.php');
if (!class_exists('FPDF')) {
    die('Erreur : la classe FPDF n\'a pas été trouvée. Vérifiez le chemin d\'inclusion.');
}

class PretPDF extends FPDF {
    private $pret;
    private $client;
    private $typePret;
    
    public function __construct($pret, $client, $typePret) {
        parent::__construct();
        $this->pret = $pret;
        $this->client = $client;
        $this->typePret = $typePret;
    }
    
    function Header() {
        // Logo
        // $this->Image('logo.png',10,6,30);
        
        // Titre principal
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, 'CONTRAT DE PRET', 0, 1, 'C');
        $this->Ln(5);
        
        // Ligne de séparation
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, 30, 200, 30);
        $this->Ln(10);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function generatePretDocument() {
        $this->AliasNbPages();
        $this->AddPage();
        
        // Informations du contrat
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'INFORMATIONS DU CONTRAT', 0, 1, 'L');
        $this->Ln(5);
        
        // Numéro de contrat
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 8, 'Numero de contrat:', 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, 'PRET-' . str_pad($this->pret['id'], 6, '0', STR_PAD_LEFT), 0, 1);
        
        // Date du contrat
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 8, 'Date du contrat:', 0, 0);
        $this->Cell(0, 8, date('d/m/Y', strtotime($this->pret['date'])), 0, 1);
        
        $this->Ln(10);
        
        // Informations du client
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'INFORMATIONS DU CLIENT', 0, 1, 'L');
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 8, 'Nom complet:', 0, 0);
        $this->Cell(0, 8, $this->client['nom'] . ' ' . $this->client['prenom'], 0, 1);
        
        $this->Cell(50, 8, 'Email:', 0, 0);
        $this->Cell(0, 8, $this->client['email'], 0, 1);
        
        $this->Cell(50, 8, 'Telephone:', 0, 0);
        $this->Cell(0, 8, $this->client['telephone'], 0, 1);
        
        $this->Cell(50, 8, 'Adresse:', 0, 0);
        $this->MultiCell(0, 8, $this->client['adresse'], 0, 'L');
        
        $this->Ln(10);
        
        // Détails du prêt
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'DETAILS DU PRET', 0, 1, 'L');
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 8, 'Libelle:', 0, 0);
        $this->Cell(0, 8, $this->pret['libelle'], 0, 1);
        
        $this->Cell(50, 8, 'Type de pret:', 0, 0);
        $this->Cell(0, 8, $this->typePret['libelle'], 0, 1);
        
        $this->Cell(50, 8, 'Montant:', 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, number_format($this->pret['montant'], 2, ',', ' ') . ' Ar', 0, 1);
        
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 8, 'Taux d\'interet:', 0, 0);
        $this->Cell(0, 8, $this->typePret['taux_interet'] . '%', 0, 1);
        
        $this->Cell(50, 8, 'Nombre de mensualites:', 0, 0);
        $this->Cell(0, 8, $this->pret['nombre_mensualite'] . ' mois', 0, 1);
        
        // Calcul de la mensualité
        $tauxMensuel = $this->typePret['taux_interet'] / 100 / 12;
        $mensualite = $this->pret['montant'] * ($tauxMensuel * pow(1 + $tauxMensuel, $this->pret['nombre_mensualite'])) / (pow(1 + $tauxMensuel, $this->pret['nombre_mensualite']) - 1);
        
        $this->Cell(50, 8, 'Mensualite:', 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, number_format($mensualite, 2, ',', ' ') . ' Ar', 0, 1);
        
        $this->Ln(10);
        
        // Conditions générales
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'CONDITIONS GENERALES', 0, 1, 'L');
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 10);
        $conditions = [
            "1. Le preteur s'engage a verser le montant du pret dans les 5 jours ouvrables suivant la signature de ce contrat.",
            "2. L'emprunteur s'engage a rembourser le pret selon l'echeancier etabli.",
        ];
        
        foreach ($conditions as $condition) {
            $this->MultiCell(0, 6, $condition, 0, 'L');
            $this->Ln(2);
        }
        
        $this->Ln(15);
        
        // Signature
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(95, 10, 'Signature du preteur:', 0, 0, 'C');
        $this->Cell(95, 10, 'Signature de l\'emprunteur:', 0, 1, 'C');
        
        $this->Ln(20);
        
        $this->Line(20, $this->GetY(), 90, $this->GetY());
        $this->Line(120, $this->GetY(), 190, $this->GetY());
        
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 8, 'Date: ' . date('d/m/Y'), 0, 0, 'C');
        $this->Cell(95, 8, 'Date: ' . date('d/m/Y'), 0, 1, 'C');
    }
} 