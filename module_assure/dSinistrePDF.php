<?php
session_start();
//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
    header('Location: ../pageConnexion.php');
    exit();
}

if (($handle = fopen("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/sinistre-".$_SESSION['numeroS'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", "r"))) {
    while (($data = fgetcsv($handle, 1000, ";"))) {
        if($data[0]=="1"){
            $nomConducteur=$data[1];
            $telConducteur=$data[2];
            $mailConducteur=$data[3];
            $professionAssure=$data[4];
        }
        if($data[0]=="nbBlesses"){
            $nbBlesses=$data[1];
        }
        for($i=0;$i<$nbBlesses;$i++){
            if($data[0]=="Blessé".($i+1)){
                $Tnom[$i]= $data[1];
                $Tprenom[$i]=$data[2];
                $Tadresse[$i]=$data[3];
                $Tville[$i]=$data[4];
                $TcodePostal[$i]=$data[5];
                $Tpays[$i]=$data[6];
                $Ttel[$i]=$data[7];
                $Tprofession[$i]=$data[8];
                $Tsituation[$i]=$data[9];
                $Thospitalisation[$i]=$data[10];
                $Tport[$i]=$data[11];
                $Tblessure[$i]=$data[12];
            }
        }
        if($data[0]=="2"){ 
            $professionConducteur=$data[1];
            $situation=$data[2];
            $habituel=$data[3];
            $reside=$data[4];
            $salarie=$data[5];
            $titre=$data[6];
            $motifDeplacement=$data[7];
        }
        if($data[0]=="3"){ 
            $circonstances=$data[1];
        }
        if($data[0]=="4"){ 
            $procesVerbal=$data[1];
            $rapportPolice=$data[2];
            $mainCourante=$data[3];
            $commissariat=$data[4];
        }
        if($data[0]=="5"){ 
            $lieuGarage=$data[1];
            $reparateur=$data[2];
            $telReparateur=$data[3];
            $faxReparateur=$data[4];
            $mailReparateur=$data[5];
            $quandReparateur=$data[6];
            $telReparateur2=$data[7];
        }
        if($data[0]=="6"){ 
            $numVehiculeVole=$data[1];
            $nomLocation=$data[2];
            $adresseLocation=$data[3];
            $poidsLourd=$data[4];
            $poidsRemorque=$data[5];
            $societeRemorque=$data[6];
            $contratRemorque=$data[7];
        }
        if($data[0]=="7"){ 
            $natureDegatAutre=$data[1];
            $importanceAutre=$data[2];
            $nomAutre=$data[3];
            $adresseAutre=$data[4];
        }
    }
 }
 fclose($handle);

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('../img/icon.png',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(50,10,utf8_decode('Déclaration sinistre'),1,0,'C');
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
        $this->SetY($this->y0+150);
    }
    function AcceptPageBreak(){
        // Ordonnée en haut
        $this->SetY($this->y0+120);
    }
    function general(){
        $this->SetY($this->y0+50);
    }
}



// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
$pdf->general();

//informations générales 
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Informations générales"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nom de l'assuré : ".$nomConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Profession : ".$professionAssure),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone : ".$telConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("E-mail : ".$mailConducteur),0,1);

$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Conducteur du véhicule"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Profession : ".$professionConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Situation : ".$situation),0,1);
$pdf->Cell(0,5,utf8_decode("Est-il le conducteur habituel du véhicule ? ".$habituel),0,1);
$pdf->Cell(0,5,utf8_decode("Réside-t-il habituellement chez l'assuré ? ".$reside),0,1);
$pdf->Cell(0,5,utf8_decode("Est-il salarié de l'assuré ? ".$salarie),0,1);
if($salarie=="non"){
    $pdf->Cell(0,5,utf8_decode("Il conduisait au titre de : ".$titre),0,1);
}
$pdf->Cell(0,5,utf8_decode("Motif du déplacement : ".$motifDeplacement),0,1);

$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Circonstances de l'accident"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode($circonstances),0,1);

$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("A-t-il été établi..."),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("...un procès-verbal de gendarmerie ? ".$procesVerbal),0,1);
$pdf->Cell(0,5,utf8_decode("...un rapport de police ? ".$rapportPolice),0,1);
$pdf->Cell(0,5,utf8_decode("...une main-courante ? ".$mainCourante),0,1);
if($mainCourante=="oui"){
    $pdf->Cell(0,5,utf8_decode("Main-courante à la brigade ou au commissariat de : ".$commissariat),0,1);
}

$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Véhicule assuré"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Lieu habituel de garage : ".$lieuGarage),0,1);
$pdf->Cell(0,5,utf8_decode("Expertise des dégâts : Réparateur chez qui le véhicule sera visible : ".$reparateur),0,1);
$pdf->Cell(0,5,utf8_decode("Tél : ".$telReparateur),0,1);
$pdf->Cell(0,5,utf8_decode("Fax : ".$faxReparateur),0,1);
$pdf->Cell(0,5,utf8_decode("E-mail : ".$mailReparateur),0,1);
$pdf->Cell(0,5,utf8_decode("Quand ? ".$quandReparateur),0,1);
$pdf->Cell(0,5,utf8_decode("Motif du déplacement : ".$motifDeplacement),0,1);
$pdf->Cell(0,5,utf8_decode("Eventuellement téléphoner à : ".$telReparateur2),0,1);
$pdf->Cell(0,5,utf8_decode("Si le véhicule : "),0,1);
$pdf->Cell(0,5,utf8_decode("A été volé, numéro dans la série du type : ".$numVehiculeVole),0,1);
$pdf->Cell(0,5,utf8_decode("Est gagé ou fait l'objet d'un contrat de location, nom et adresse de l'organisme concerné : ".$nomLocation),0,1);
$pdf->Cell(0,5,utf8_decode("Est un poids lourd, poids total en charge : ".$poidsLourd),0,1);
$pdf->Cell(0,5,utf8_decode("Etait attelé à un autre véhicule au moment de l'accident, poids total en charge : ".$poidsRemorque),0,1);
$pdf->Cell(0,5,utf8_decode("    nom de la société qui l'assure : ".$societeRemorque),0,1);
$pdf->Cell(0,5,utf8_decode("    numéro de contrat dans la société : ".$contratRemorque),0,1);

//autre page

$pdf->AddPage();

$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Dégâts matériels autres qu'aux deux véhicules impliqués"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nature des dégâts : ".$natureDegatAutre),0,1);
$pdf->Cell(0,5,utf8_decode("Importance : ".$importanceAutre),0,1);
$pdf->Cell(0,5,utf8_decode("Nom du propriétaire : ".$nomAutre),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$adresseAutre),0,1);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode("Blessés"),0,1);
$pdf->SetFont('Times','',9);
for($i=0;$i<$nbBlesses;$i++){
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(0,5,utf8_decode("Blessé ".($i+1)." -- Nom : ".$Tnom[$i]." ".$Tprenom[$i]),0,1);
    $pdf->SetFont('Times','',9);
    $pdf->Cell(0,5,utf8_decode(" -Adresse : ".$Tadresse[$i]." ".$Tville[$i]." ".$TcodePostal[$i]." ".$Tpays[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Adresse e-mail ou téléphone : ".$Ttel[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Profession : ".$Tprofession[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Situation au moment de l'accident : ".$Tsituation[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Portait-il casque ou ceinture ? ".$Tport[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Premiers soins ou hospitalisation à : ".$Thospitalisation[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Nature et gravité des blessures : ".$Tblessure[$i]),0,1);
}

$pdf->Output("F", "../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/sinistre-".$_SESSION['numeroS'].$_SESSION['nom'].$_SESSION['QRcode'].".pdf");
header('Location: dSinistre2.php');
?>