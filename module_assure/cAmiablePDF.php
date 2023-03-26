<?php
session_start();
//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
    header('Location: ../pageConnexion.php');
    exit();
}

if(!file_exists("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/")){
  mkdir("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/", 0700);
}
if (($handle = fopen("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$_SESSION['numero'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", "r"))) {
    while (($data = fgetcsv($handle, 1000, ";"))) {
        if($data[0]=="1"){
            $codeSinistre=$data[1];
            $numSinistre=$data[2];
        }
        if($data[0]=="2"){
            $nom=$data[1];
            $prenom=$data[2];
            $adresse=$data[3];
            $codePostal=$data[4];
            $ville=$data[5];
            $pays=$data[6];
            $tel=$data[7];
        }
        if($data[0]=="3"){
            $nomAssureur=$data[1];
            $numeroContrat=$data[2];
            $numeroCarteVerte=$data[3];
            $attestationDebut=$data[4];
            $attestationFin=$data[5];
            $adresseAssureur=$data[6];
            $codePostalAssureur=$data[7];
            $villeAssureur=$data[8];
            $paysAssureur=$data[9];
            $telAssureur=$data[10];
            $degatsAssures=$data[11];
        }
        if($data[0]=="4"){
            $type=$data[1];
            $immatriculation=$data[2];
            $paysImmatriculation=$data[3];
            $numRemorque=$data[4];
            $paysRemorque=$data[5];
        }
        if($data[0]=="5"){
            $nomConducteur=$data[1];
            $prenomConducteur=$data[2];
            $dateConducteur=$data[3];
            $adresseConducteur=$data[4];
            $codePostalConducteur=$data[5];
            $villeConducteur=$data[6];
            $paysConducteur=$data[7];
            $telConducteur=$data[8];
            $numPermisConducteur=$data[9];
            $categorieConducteur=$data[10];
            $validitePermisConducteur=$data[11];
        }
        if($data[0]=="6"){
            $degatsApparents=$data[1];
        }
        if($data[0]=="7"){
            $observations=$data[1];
        }
        if($data[0]=="8"){
            $circonstance1=$data[1];
            $circonstance2=$data[2];
            $circonstance3=$data[3];
            $circonstance4=$data[4];
            $circonstance5=$data[5];
            $circonstance6=$data[6];
            $circonstance7=$data[7];
            $circonstance8=$data[8];
            $circonstance9=$data[9];
            $circonstance10=$data[10];
            $circonstance11=$data[11];
            $circonstance12=$data[12];
            $circonstance13=$data[13];
            $circonstance14=$data[14];
            $circonstance15=$data[15];
            $circonstance16=$data[16];
            $circonstance17=$data[17];
        }
        if($data[0]=="numero"){
            $numero=$data[1];
        }
     }
 }
 fclose($handle);

if(!file_exists("../csv/constats_amiables/".$codeSinistre."/")){
   mkdir("../csv/constats_amiables/".$codeSinistre."/", 0700);
 }
if (($handle = fopen("../csv/constats_amiables/".$codeSinistre."/c-amiable-".$numSinistre.$codeSinistre.".csv", "r"))) {
    while (($data = fgetcsv($handle, 1000, ";"))) {
        if ($data[0]=="A"){
            $Aheure=$data[2];
            $Adate=$data[1];
            $Apays=$data[3];
            $Alieu=$data[4];
            $Ablesse=$data[5];
            $Adegat1=$data[6];
            $Adegat2=$data[7];
        }
        if($data[0]=="Nbtemoins"){
            $nbtemoins=$data[1];
        }
    }
}
fclose($handle);

if(!file_exists("../csv/constats_amiables/".$codeSinistre."/")){
   mkdir("../csv/constats_amiables/".$codeSinistre."/", 0700);
 }
if (($handle = fopen("../csv/constats_amiables/".$codeSinistre."/c-amiable-".$numSinistre.$codeSinistre.".csv", "r"))) {
    while (($data = fgetcsv($handle, 1000, ";"))) {
        for($i=0;$i<$nbtemoins;$i++){
            if($data[0]==("Témoin".($i+1))){
                $Tnom[$i]=$data[1];
                $Tadresse[$i]=$data[2];
                $Tville[$i]=$data[3];
                $TcodePostal[$i]=$data[4];
                $Tpays[$i]=$data[5];
                $Ttel[$i]=$data[6];
            }
        }
        if($data[0]=="2"){
            $Bnom=$data[1];
            $Bprenom=$data[2];
            $Badresse=$data[3];
            $BcodePostal=$data[4];
            $Bville=$data[5];
            $Bpays=$data[6];
            $Btel=$data[7];
        }
        if($data[0]=="3"){
            $BnomAssureur=$data[1];
            $BnumeroContrat=$data[2];
            $BnumeroCarteVerte=$data[3];
            $BattestationDebut=$data[4];
            $BattestationFin=$data[5];
            $BadresseAssureur=$data[6];
            $BcodePostalAssureur=$data[7];
            $BvilleAssureur=$data[8];
            $BpaysAssureur=$data[9];
            $BtelAssureur=$data[10];
            $BdegatsAssures=$data[11];
        }
        if($data[0]=="4"){
            $Btype=$data[1];
            $Bimmatriculation=$data[2];
            $BpaysImmatriculation=$data[3];
            $BnumRemorque=$data[4];
            $BpaysRemorque=$data[5];
        }
        if($data[0]=="5"){
            $BnomConducteur=$data[1];
            $BprenomConducteur=$data[2];
            $BdateConducteur=$data[3];
            $BadresseConducteur=$data[4];
            $BcodePostalConducteur=$data[5];
            $BvilleConducteur=$data[6];
            $BpaysConducteur=$data[7];
            $BtelConducteur=$data[8];
            $BnumPermisConducteur=$data[9];
            $BcategorieConducteur=$data[10];
            $BvaliditePermisConducteur=$data[11];
        }
        if($data[0]=="6"){
            $BdegatsApparents=$data[1];
        }
        if($data[0]=="7"){
            $Bobservations=$data[1];
        }
        if($data[0]=="8"){
            $Bcirconstance1=$data[1];
            $Bcirconstance2=$data[2];
            $Bcirconstance3=$data[3];
            $Bcirconstance4=$data[4];
            $Bcirconstance5=$data[5];
            $Bcirconstance6=$data[6];
            $Bcirconstance7=$data[7];
            $Bcirconstance8=$data[8];
            $Bcirconstance9=$data[9];
            $Bcirconstance10=$data[10];
            $Bcirconstance11=$data[11];
            $Bcirconstance12=$data[12];
            $Bcirconstance13=$data[13];
            $Bcirconstance14=$data[14];
            $Bcirconstance15=$data[15];
            $Bcirconstance16=$data[16];
            $Bcirconstance17=$data[17];
        }
        if($data[0]=="numero"){
            $Bnumero=$data[1];
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
        $this->SetY($this->y0+120);
    }
    function SetColPage2($col)
    {
        // Positionnement sur une colonne
        $this->col = $col;
        $x = 10+$col*90;
        $this->SetLeftMargin($x);
        $this->SetX($x);
        $this->SetY($this->y0+50);
    }
    function AcceptPageBreak(){
        // Ordonnée en haut
        $this->SetY($this->y0+120);
    }
    function AcceptPageBreak2(){
        // Ordonnée en haut
        $this->SetY($this->y0+50);
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
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,5,utf8_decode("Code sinistre associé à l'accident : ".$codeSinistre),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,"Date de l'accident : ".$Adate." - Heure de l'accident : ".$Aheure,0,1);
$pdf->Cell(0,5,"Localisation - Pays : ".$Apays." - Lieu : ".$Alieu,0,1);
$pdf->Cell(0,5,utf8_decode("Blessés même légers : ".$Ablesse),0,1);
$pdf->Cell(0,5,utf8_decode("Dégâts matériels à des : - Véhicules autre que ceux impliqués : ".$Adegat1." - Objets autres que des véhicules : ".$Adegat2),0,1);
for($i=0;$i<$nbtemoins;$i++){
    $pdf->Cell(0,5,utf8_decode("Témoin ".($i+1)." -- Nom : ".$Tnom[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Adresse : ".$Tadresse[$i]." ".$Tville[$i]." ".$TcodePostal[$i]." ".$Tpays[$i]),0,1);
    $pdf->Cell(0,5,utf8_decode(" -Adresse e-mail ou téléphone : ".$Ttel[$i]),0,1);
}


//informations spécifiques au conducteur B
$pdf->SetCol(0);
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,utf8_decode("Assuré 1"),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Preneur d'assurance/assuré :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nom : ".$nom),0,1);
$pdf->Cell(0,5,utf8_decode("Prénom : ".$prenom),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$adresse." ".$codePostal." ".$ville." ".$pays),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$tel),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Véhicule :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,7,utf8_decode("A moteur :"),0,1);
$pdf->Cell(0,5,utf8_decode("Marque, type : ".$type),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro d'immatriculation : ".$immatriculation),0,1);
$pdf->Cell(0,5,utf8_decode("Pays d'immatriculation : ".$paysImmatriculation),0,1);
if ($numRemorque!=""){
    $pdf->Cell(0,7,utf8_decode("Remorque :"),0,1);
    $pdf->Cell(0,5,utf8_decode("Numéro d'immatriculation : ".$numRemorque),0,1);
    $pdf->Cell(0,5,utf8_decode("Pays d'immatriculation : ".$paysRemorque),0,1);
}
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Société d'assurance :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,7,utf8_decode("Nom : ".$nomAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro de contrat: ".$numeroContrat),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro de carte verte : ".$numeroCarteVerte),0,1);
$pdf->Cell(0,5,utf8_decode("Attestation d'assurance valable du ".$attestationDebut. " au ".$attestationFin),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$adresseAssureur." ".$codePostalAssureur." ".$villeAssureur." ".$paysAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$telAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Les dégâts matériels du véhicule sont-ils assurés par le contrat ? ".$degatsAssures),0,1);



//-----------------------colonne 2
$pdf->SetCol(1);
$pdf->AcceptPageBreak();
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Conducteur :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nom : ".$nomConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Prénom : ".$prenomConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Date de naissance : ".$dateConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$adresseConducteur." ".$codePostalConducteur." ".$villeConducteur." ".$paysConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$telConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Permis de conduire numéro : ".$numPermisConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Catégorie : ".$categorieConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Permis valable jusqu'au : ".$validitePermisConducteur),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Dégâts apparents au véhicule :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode($degatsApparents),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Mes observations :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode($observations),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Circonstances :"),0,1);
$pdf->SetFont('Times','',9);
if($circonstance1!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance1),0,1);
}
if($circonstance2!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance2),0,1);
}
if($circonstance3!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance3),0,1);
}
if($circonstance4!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance4),0,1);
}
if($circonstance5!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance5),0,1);
}
if($circonstance6!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance6),0,1);
}
if($circonstance7!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance7),0,1);
}
if($circonstance8!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance8),0,1);
}
if($circonstance9!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance9),0,1);
}
if($circonstance10!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance10),0,1);
}
if($circonstance11!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance11),0,1);
}
if($circonstance12!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance12),0,1);
}
if($circonstance13!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance13),0,1);
}
if($circonstance14!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance14),0,1);
}
if($circonstance15!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance15),0,1);
}
if($circonstance16!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance16),0,1);
}
if($circonstance17!=""){
    $pdf->Cell(0,5,utf8_decode($circonstance17),0,1);
}

//Informations spécifiques au conducteur A
$pdf->SetColPage2(0);
$pdf->AddPage();

$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,utf8_decode("Assuré 2"),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Preneur d'assurance/assuré :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nom : ".$Bnom),0,1);
$pdf->Cell(0,5,utf8_decode("Prénom : ".$Bprenom),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$Badresse." ".$BcodePostal." ".$Bville." ".$Bpays),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$Btel),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Véhicule :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,7,utf8_decode("A moteur :"),0,1);
$pdf->Cell(0,5,utf8_decode("Marque, type : ".$Btype),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro d'immatriculation : ".$Bimmatriculation),0,1);
$pdf->Cell(0,5,utf8_decode("Pays d'immatriculation : ".$BpaysImmatriculation),0,1);
if ($BnumRemorque!=""){
    $pdf->Cell(0,7,utf8_decode("Remorque :"),0,1);
    $pdf->Cell(0,5,utf8_decode("Numéro d'immatriculation : ".$BnumRemorque),0,1);
    $pdf->Cell(0,5,utf8_decode("Pays d'immatriculation : ".$BpaysRemorque),0,1);
}
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Société d'assurance :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,7,utf8_decode("Nom : ".$BnomAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro de contrat: ".$BnumeroContrat),0,1);
$pdf->Cell(0,5,utf8_decode("Numéro de carte verte : ".$BnumeroCarteVerte),0,1);
$pdf->Cell(0,5,utf8_decode("Attestation d'assurance valable du ".$BattestationDebut. " au ".$BattestationFin),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$BadresseAssureur." ".$BcodePostalAssureur." ".$BvilleAssureur." ".$BpaysAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$BtelAssureur),0,1);
$pdf->Cell(0,5,utf8_decode("Les dégâts matériels du véhicule sont-ils assurés par le contrat ? ".$BdegatsAssures),0,1);



//-----------------------colonne 2
$pdf->SetColPage2(1);
$pdf->AcceptPageBreak2();
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Conducteur :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode("Nom : ".$BnomConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Prénom : ".$BprenomConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Date de naissance : ".$BdateConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Adresse : ".$BadresseConducteur." ".$BcodePostalConducteur." ".$BvilleConducteur." ".$BpaysConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Téléphone ou e-mail : ".$BtelConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Permis de conduire numéro : ".$BnumPermisConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Catégorie : ".$BcategorieConducteur),0,1);
$pdf->Cell(0,5,utf8_decode("Permis valable jusqu'au : ".$BvaliditePermisConducteur),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Dégâts apparents au véhicule :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode($BdegatsApparents),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Mes observations :"),0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(0,5,utf8_decode($Bobservations),0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(0,10,utf8_decode("Circonstances :"),0,1);
$pdf->SetFont('Times','',9);
if($Bcirconstance1!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance1),0,1);
}
if($Bcirconstance2!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance2),0,1);
}
if($Bcirconstance3!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance3),0,1);
}
if($Bcirconstance4!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance4),0,1);
}
if($Bcirconstance5!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance5),0,1);
}
if($Bcirconstance6!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance6),0,1);
}
if($Bcirconstance7!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance7),0,1);
}
if($Bcirconstance8!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance8),0,1);
}
if($Bcirconstance9!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance9),0,1);
}
if($Bcirconstance10!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance10),0,1);
}
if($Bcirconstance11!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance11),0,1);
}
if($Bcirconstance12!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance12),0,1);
}
if($Bcirconstance13!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance13),0,1);
}
if($Bcirconstance14!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance14),0,1);
}
if($Bcirconstance15!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance15),0,1);
}
if($Bcirconstance16!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance16),0,1);
}
if($Bcirconstance17!=""){
    $pdf->Cell(0,5,utf8_decode($Bcirconstance17),0,1);
}

$pdf->Output("F", "../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$_SESSION['numero'].$_SESSION['nom'].$_SESSION['QRcode'].".pdf");
$pdf->Output("F", "../csv/constats_amiables/".$codeSinistre."/c-amiable-".$Bnumero.$codeSinistre.".pdf");
header('Location: cAmiable3.php');
?>
