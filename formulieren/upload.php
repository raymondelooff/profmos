<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');
require_once('../lib/ExcelReader/php-excel-reader/excel_reader2.php');
require_once('../lib/ExcelReader/SpreadsheetReader.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- CSS -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="../css/screen.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <title>PROFMOS</title>
    </head>

    <body>
        <?php

            include_once('../includes/header.php');

        ?>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">

                        <?php

                        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $error = "";
                            $target_dir = "../uploads/";
                            $target_file = $target_dir . basename($_FILES["upload"]["name"]);
                            $upload_success = 1;
                            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                            // Check if file already exists
                            if (file_exists($target_file)) {
                                $error .= "Het bestand bestaat al op de server. ";
                                $upload_success = 0;
                            }

                            // Check file size
                            if ($_FILES["upload"]["size"] > 500000) {
                                $error .= "Het bestand is te groot. ";
                                $upload_success = 0;
                            }

                            // Allow certain file formats
                            if ($fileType != "xlsx") {
                                $error .= "Upload alstublieft een .xlsx (Excel) bestand.";
                                $upload_success = 0;
                            }

                            // Check if $upload_success is set to 0 by an error
                            if ($upload_success == 1) {
                                // if everything is ok, try to upload file
                                if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                                    $error .= "Het bestand " . basename($_FILES["upload"]["name"]) . " is geüpload en verwerkt in de database.";

                                    $reader = new SpreadsheetReader($target_file);

                                    // Remove file
                                    unlink($target_file);

                                    $insert = array();
                                    $i = 0;
                                    $verzaaien = false;
                                    $tabel = "";
                                    $oppervlakte = 0;

                                    foreach ($reader as $row) {
                                        if ($i == 1) {
                                            $insert['Datum'] = time($row[1]);
                                        }
                                        if ($i == 2) {
                                            $activiteit = $row[1];
                                            if ($activiteit == "Zaaien" || $activiteit == "Bijzaaien" || $activiteit == "Verzaaien") {
                                                $tabel = 'zaaiing';
                                            }
                                            if ($activiteit == "Leegvissen" || $activiteit == "Vissen voor veiling") {
                                                $tabel = 'oogst';
                                            }
                                            if ($activiteit == "Trekje op perceel" || $activiteit == "Sterren Dweilen" || $activiteit == "Sterren Rapen" || $activiteit == "Sterren" || $activiteit == "Onder Zoet Water" || $activiteit == "Onder Warm Water" || $activiteit == "Peulen" || $activiteit == "Groen" || $activiteit == "Droog Leggen" || $activiteit == "Over Spoelerij") {
                                                $tabel = 'behandeling';
                                            }

                                            if ($activiteit == "Verzaaien") {
                                                $verzaaien = true;
                                            }
                                            $insert['Activiteit'] = $activiteit;
                                        }

                                        if ($i == 3) {
                                            $oppervlakte = $row[1];
                                        }
                                        if ($i == 5) {
                                            if ($row[1] == "Ja") {
                                                $insert['Monster'] = TRUE;
                                            }
                                            else if ($row[1] == "Nee") {
                                                $insert['Monster'] = FALSE;
                                            }
                                        }
                                        if ($i == 6) {
                                            $insert['MonsterLabel'] = $row[1];
                                        }
                                        if ($i == 9 && $verzaaien) {
                                            $herkomstNaam = $row[1];

                                        }
                                        if ($i == 10 && $verzaaien) {
                                            $herkomstPlaats = $row[1];
                                        }
                                        if ($i == 11 && $verzaaien) {
                                            $herkomstOppervlakte = $row[1];
                                        }
                                        if ($i == 14 && $tabel != "behandeling") {
                                            $insert['Bustal'] = $row[1];
                                        }
                                        if ($i == 15 && $tabel == 'oogst') {
                                            $insert['Stukstal'] = $row[1];
                                        }
                                        if ($i == 16  && $tabel != "behandeling") {
                                            $insert['BrutoMton'] = $row[1];
                                            $insert['Kilogram'] = $insert['BrutoMton'] * 100;
                                            if ($tabel == 'zaaiing') {
                                                $insert['KilogramPerM2'] = ($insert['Kilogram'] / ($oppervlakte * 10000));
                                            }

                                        }
                                        if ($i == 17) {
                                            $perceelLeeggevist = $row[1];
                                        }
                                        if ($i == 18) {
                                            $insert['Opmerking'] = $row[1];
                                        }
                                        $i++;
                                    }

                                    if ($tabel != 'oogst') {
                                        $insert['Bedrijf_BedrijfID'] = $_POST['bedrijf'];
                                        $insert['Vak_VakID'] = $_POST['vak'];
                                        $insert['Perceel_PerceelID'] = $_POST['perceel'];
                                        if ($tabel == 'zaaiing') {
                                            $database->insert('mosselgroep', array('ParentMosselgroepID' => null));
                                            $insert['Mosselgroep_MosselgroepID'] = $database->getInsertId();
                                        }

                                    }
                                    if (!$verzaaien) {
                                        $database->insert($tabel, $insert);
                                    }
                                    else {

                                    }
                                    if ($tabel == 'oogst') {
                                        header("Location: selectZaaiing.php?oogstID=" . $database->getInsertId() . "&bedrijfID=" . $_POST['bedrijf']);
                                        die();
                                    }
                                    if ($tabel == 'behandeling') {
                                        header("Location: selectZaaiing.php?behandelingID=" . $database->getInsertId() . "&bedrijfID=" . $_POST['bedrijf']);
                                        die();
                                    }

                                }
                                else {
                                    $error .= "Het bestand kan niet geüpload worden.";
                                }

                            }
                            else {
                                $error .= "Geen geldig bestand geupload.";
                            }

                            echo $error;
                        }

                        ?>

                        <form method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="upload" id="upload">
                            <br>
                            <div class="form-group">
                                <label for="bedrijf">Bedrijf: </label>
                                <select id="bedrijf" name="bedrijf" class="form-control">
                                    <?php
                                        $bedrijven = $database->get('bedrijf');
                                        echo '<option></option>';
                                        foreach($bedrijven as $bedrijf) {
                                            echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' - ' . $bedrijf['Afkorting'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="perceel">Perceel: </label>
                                <select id="perceel" name="perceel" class="form-control" onchange="fillVak()">
                                    <?php
                                    $percelen = $database->get('perceel');
                                    echo '<option></option>';
                                    foreach($percelen as $perceel) {
                                        echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="vak">
                            </div>
                            <br>
                            <input type="submit" value="Upload spreadsheet" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/invulformulieren.js"></script>
    </body>
</html>