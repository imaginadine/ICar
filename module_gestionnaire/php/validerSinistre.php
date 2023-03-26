<?php
    $branche=$_POST['branche'];
    $num=$_POST['num'];
    $resp=$_POST['resp'];
    //modification de la bonne ligne de fichier : remplacer non par oui
    if (($handle1 = fopen("../../csv/sinistres.csv", "r")) !== FALSE) {
        if (($handle2 = fopen("../../csv/sinistres2.csv", "w")) !== FALSE) {
            while (($data = fgetcsv($handle1, 1000, ";")) !== FALSE) {
               // vérification que nous sommes dans la bonne ligne du fichier
               if (($data[0]==$branche) && ($data[1]==$num)){
                    $data[3]="oui";
                    $data[4]=$resp;
               }
               // écriture dans le deuxième fichier
               fputcsv($handle2, $data, ";");
            }
            fclose($handle2);
        }
        fclose($handle1);
    }
    $handle1="../../csv/sinistres.csv";
    $handle2="../../csv/sinistres2.csv";
    //copie du deuxième fichier dans l'original
    copy($handle2,$handle1);
    //suppression du deuxième fichier
    unlink($handle2);
?>
