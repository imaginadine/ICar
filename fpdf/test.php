<?php
require('fpdf.php');

class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('img_icon.png',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(50,10,'Constat Amiable',1,0,'C');
        // Saut de ligne
        $this->Ln(40);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function SetCol($col)
    {
        // Positionnement sur une colonne
        $this->col = $col;
        $x = 10+$col*90;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }
    function AcceptPageBreak(){
        // Ordonnée en haut
        $this->SetY($this->y0+50);
    }
}



// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetCol(0);
for($i=1;$i<=10;$i++){
    $pdf->Cell(0,10,'Colonne 1 Impression de la ligne numero '.$i,0,1);
}
$pdf->SetCol(1);
$pdf->AcceptPageBreak();
for($i=1;$i<=10;$i++){
    $pdf->Cell(0,10,'Colonne 2 Impression de la ligne numero '.$i,0,1);
}
$pdf->Output();
?>
