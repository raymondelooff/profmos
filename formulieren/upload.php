<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');
require_once ('../includes/functions.php');
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
                            $error = "";
                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $error = "<ul>";
                                $target_dir = "../uploads/";
                                $target_file = $target_dir . basename($_FILES["upload"]["name"]);
                                $upload_success = 1;
                                $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                                // Check if file already exists
                                if (file_exists($target_file)) {
                                    $error .= "<li>Het bestand bestaat al op de server.</li>";
                                    $upload_success = 0;
                                }

                                // Check file size
                                if ($_FILES["upload"]["size"] > 500000) {
                                    $error .= "<li>Het bestand is te groot.</li>";
                                    $upload_success = 0;
                                }

                                // Allow certain file formats
                                if ($fileType != "xlsx") {
                                    $error .= "<li>Upload alstublieft een .xlsx (Excel) bestand.</li>";
                                    $upload_success = 0;
                                }

                                // Check if $upload_success is set to 0 by an error
                                if ($upload_success == 1) {
                                    // if everything is ok, try to upload file
                                    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                                        $error .= "<li>Het bestand " . basename($_FILES["upload"]["name"]) . " is geüpload en verwerkt in de database.</li>";

                                        $reader = new SpreadsheetReader($target_file);

                                        // Remove file
                                        unlink($target_file);

                                        $insert = array();
                                        $check = array();
                                        $i = 0;
                                        $verzaaien = false;
                                        $tabel = "";
                                        $oppervlakte = 0;
                                        $kilogramPerM2 = NULL;

                                        foreach ($reader as $row) {
                                            if ($i == 1) {
                                                $insert['Datum'] = strtotime($row[1]);
                                            }
                                            if ($i == 2) {
                                                $activiteit = $row[1];
                                                if ($activiteit == "Zaaien" || $activiteit == "Bijzaaien") {
                                                    $tabel = 'zaaiing';
                                                }
                                                else if ($activiteit == "Leegvissen" || $activiteit == "Vissen voor veiling" || $activiteit == "Verzaaien") {
                                                    $tabel = 'oogst';
                                                }
                                                else if ($activiteit == "Trekje op perceel" || $activiteit == "Sterren Dweilen" || $activiteit == "Sterren Rapen" || $activiteit == "Sterren" || $activiteit == "Onder Zoet Water" || $activiteit == "Onder Warm Water" || $activiteit == "Peulen" || $activiteit == "Groen" || $activiteit == "Droog Leggen" || $activiteit == "Over Spoelerij") {
                                                    $tabel = 'behandeling';
                                                }
                                                else {
                                                    $error .= "<li>Er is een foutieve <b>Activiteit</b> ingevoerd</li>";
                                                }

                                                if ($activiteit == "Verzaaien" && $_POST['verzaaien']) {
                                                    $verzaaien = TRUE;
                                                }
                                                $insert['Activiteit'] = $activiteit;
                                            }

                                            /**
                                             * if ($i == 3) {
                                             * $oppervlakte = $row[1];
                                             * }*/
                                            if ($i == 5) {
                                                if ($row[1] == "Ja") {
                                                    $insert['Monster'] = TRUE;
                                                } else if ($row[1] == "Nee") {
                                                    $insert['Monster'] = FALSE;
                                                }
                                                $check['Monster'] = $insert['Monster'];
                                            }
                                            if ($i == 6 && $insert['Monster'] == TRUE) {
                                                $insert['MonsterLabel'] = $row[1];
                                                $check['MonsterLabel'] = $insert['Monsterlabel'];
                                            }

                                            if ($i == 9 && $tabel != "behandeling") {
                                                $insert['Bustal'] = $row[1];
                                                $check['Bustal'] = $insert['Bustal'];
                                            }
                                            if ($i == 10 && $tabel == 'oogst') {
                                                $insert['Stukstal'] = $row[1];
                                                $check['Stukstal'] = $insert['Stukstal'];
                                            }
                                            if ($i == 11 && $tabel != "behandeling") {
                                                $insert['BrutoMton'] = $row[1];
                                                $check['BrutoMton'] = $insert['BrutoMton'];
                                                $insert['Kilogram'] = $insert['BrutoMton'] * 100;
                                                $check['Kilogram'] = $insert['Kilogram'];
                                                $kilogramPerM2 = $insert['Kilogram'] / ($oppervlakte * 10000);
                                                if ($tabel == 'zaaiing') {
                                                    $insert['KilogramPerM2'] = $kilogramPerM2;
                                                }

                                            }
                                            if ($i == 12) {
                                                $perceelLeeggevist = $row[1];
                                                $check['perceelLeeggevist'] = $perceelLeeggevist;
                                            }
                                            if ($i == 13) {
                                                $insert['Opmerking'] = $row[1];
                                                $check['Opmerking'] = $insert['Opmerking'];
                                            }
                                            $i++;
                                        }

                                        if ($tabel != 'oogst') {
                                            $insert['Bedrijf_BedrijfID'] = $_POST['bedrijf'];
                                            $check['Bedrijf'] = $insert['Bedrijf_BedrijfID'];
                                            $insert['Vak_VakID'] = $_POST['vak'];
                                            $check['Vak'] = $insert['Vak_VakID'];
                                            $insert['Perceel_PerceelID'] = $_POST['perceel'];
                                            $check['Perceel'] = $insert['Perceel_PerceelID'];

                                        }
                                            if ($tabel == 'zaaiing') {
                                                $database->insert('mosselgroep', array('ParentMosselgroepID' => null));
                                                $insert['Mosselgroep_MosselgroepID'] = $database->getInsertId();
                                                $check['Mosselgroep'] = $insert['Mosselgroep_MosselgroepID'];
                                            }
                                            $database->insert($tabel, $insert);
                                            if ($tabel == "oogst") {
                                                $oogstID = $database->getInsertId();
                                            } else if ($tabel == "behandeling") {
                                                $behandelingID = $database->getInsertId();
                                            }
                                            if ($verzaaien) {
                                                $data = array(
                                                    'Bedrijf_BedrijfID' => $_POST['bedrijf'],
                                                    'Vak_VakID' => $_POST['verzaaienVakSelect'],
                                                    'Perceel_PerceelID' => $_POST['verzaaienPerceelSelect'],
                                                    'Activiteit' => $insert['Activiteit'],
                                                    'Datum' => $insert['Datum'],
                                                    'BrutoMton' => $insert['BrutoMton'],
                                                    'Kilogram' => $insert['Kilogram'],
                                                    'KilogramPerM2' => $kilogramPerM2,
                                                    'Bustal' => $insert['Bustal'],
                                                    'Monster' => $insert['Monster'],
                                                    'MonsterLabel' => $insert['MonsterLabel'],
                                                    'Opmerking' => $insert['Opmerking']
                                                );
                                                $database->insert('zaaiing', $data);
                                                $verzaaienID = $database->getInsertId();
                                            }
                                            if ($tabel == 'oogst') {
                                                if (isset($oogstID)) {
                                                    if ($verzaaien) {
                                                        $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['bedrijf'] . "&oogstID=" . $oogstID . "&verzaaiingID=" . $verzaaienID . "&leeggevist=" . $perceelLeeggevist;
                                                    } else {
                                                        $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['bedrijf'] . "&oogstID=" . $oogstID;

                                                    }

                                                    header($location);
                                                    die();

                                                } else {
                                                    $error .= "Er is een fout opgetreden (oogstID niet meegegeven.)";
                                                }
                                            }
                                            if ($tabel == 'behandeling') {
                                                if (isset($behandelingID)) {
                                                    $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['bedrijf'] . "&behandelingID=" . $behandelingID;
                                                    header($location);
                                                    die();
                                                } else {
                                                    $error .= "Er is een fout opgetreden (oogstID niet meegegeven.)";
                                                }

                                            }
                                        }
                                    }
                                    else {
                                        $error .= "Het bestand kan niet geüpload worden.";
                                    }
                            }
                            echo $error;

                        ?>
                        <h1>Uploaden spreadsheet</h1>
                        <form method="post" enctype="multipart/form-data">
                            Selecteer een bestand om te uploaden.
                            <input type="file" class="file" name="upload" id="upload">
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
                            <div class="form-group">
                                <label for="verzaaien">Verzaaien?: </label>
                                <select name="verzaaien" id="verzaaien" class="form-control" onchange="toggleVerzaaien()">
                                    <option value="Ja">Ja</option>
                                    <option value="Nee" selected>Nee</option>
                                </select>

                            </div>
                            <div class="form-group" id="verzaaienBedrijf">
                                <label for="verzaaienBedrijfSelect">Bedrijf: </label>
                                <select id="verzaaienBedrijfSelect" name="verzaaienBedrijfSelect" class="form-control">
                                    <?php
                                    $bedrijven = $database->get('bedrijf');
                                    echo '<option></option>';
                                    foreach($bedrijven as $bedrijf) {
                                        echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' - ' . $bedrijf['Afkorting'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="verzaaienPerceel">
                                <label for="verzaaienPerceelSelect">Perceel: </label>
                                <select id="verzaaienPerceelSelect" name="verzaaienPerceelSelect" class="form-control" onchange="fillVakVerzaaid()">
                                    <?php
                                    $percelen = $database->get('perceel');
                                    echo '<option></option>';
                                    foreach($percelen as $perceel) {
                                        echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="verzaaienVak">
                            </div>
                            <br>
                            <div id="verzaaienOppervlakte" class="form-group">
                                <label for="verzaaienOppervlakte">Oppervlakte: </label>
                                <input type="text" id="verzaaienOppervlakte" class="form-control">
                            </div>
                            <br>
                            <input type="submit" value="Upload spreadsheet" name="submit">
                        </form>
                </div>
            </div>
        </section>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
        <script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
        <script src="/js/invulformulieren.js"></script>
        <!-- For file input box. -->
        <script src="/bower_components/bootstrap-file/js/fileinput.min.js"></script>
        <link href="/bower_components/bootstrap-file/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <script src="/bower_components/bootstrap-file/js/fileinput_locale_nl.js"></script>
    </body>
</html>