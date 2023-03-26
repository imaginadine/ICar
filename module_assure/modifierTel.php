<?php
    session_start();
?>

<?php
    $tel = $_POST['newTel'];
    $_SESSION["tel"] = $tel;

    //on note les nouvelles infos dans le fichier info
    $i=0;
    $ligneSuppr=0;  // numéro de la ligne
    $infoAssures = fopen("../csv/assures.csv", "r");
    while (($data = fgetcsv($infoAssures, 1000, ";"))) {
        if($data[0] == $_SESSION['pseudo']){
            $ligneSuppr = $i;
        }
        $i=$i+1;
    }
    fclose($infoAssures);


    $donnee=file("../csv/assures.csv"); // on met le contenu du fichier dans $donnee

    $infoAssures = fopen("../csv/assures.csv", "w"); // ouvre le fichier en droit d'écriture
        fputs($infoAssures,''); // on le vide

        $i=0;
        foreach($donnee as $d)
        //
        {
            if($i!=$ligneSuppr){
                fputs($infoAssures,$d);
            }else{
                fputs($infoAssures,'');
            }
            $i=$i+1;
        }

    fclose($infoAssures);

    $fp = fopen('../csv/assures.csv', 'a+');
    $monAssure=array(
        array($_SESSION['pseudo'],
        $_SESSION['nom'],
        $_SESSION['prenom'],
        $tel,
        $_SESSION['mail'],
        $_SESSION['adresse'],
        $_SESSION['ville'],
        $_SESSION['codePostal'],
        $_SESSION['pays'],
        $_SESSION['codeAssureur']
        )
    );
    foreach ($monAssure as $fields) {
        fputcsv($fp, $fields,";");
    }
    fclose($fp);
    echo $tel;

    // on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "telephone",
													 "numero" => $_SESSION["identifiant"],
													 "type" => "modification",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);

?>
