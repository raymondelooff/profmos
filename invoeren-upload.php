<?php

    // Includes
    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');
    require_once('includes/functions.php');
    require_once('lib/ExcelReader/php-excel-reader/excel_reader2.php');
    require_once('lib/ExcelReader/SpreadsheetReader.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php

            include_once('includes/head.php');

        ?>

        <title>PROFMOS - Excel bestand uploaden</title>
    </head>

    <body>

        <?php

            include_once('includes/header.php');

        ?>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">
                        <h1>Uploaden spreadsheet</h1>

                        <?php


                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $error = "<ul>";
                                $error_count = 0;
                                $target_dir = "uploads/";
                                $target_file = $target_dir . basename($_FILES["upload"]["name"]);
                                $upload_success = 1;
                                $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                                // Check if file already exists
                                if (file_exists($target_file)) {
                                    $error .= "<li>Het bestand bestaat al op de server.</li>";
                                    $error_count++;
                                    $upload_success = 0;
                                }

                                // Check file size
                                if ($_FILES["upload"]["size"] > 500000) {
                                    $error .= "<li>Het bestand is te groot.</li>";
                                    $error_count++;
                                    $upload_success = 0;
                                }

                                // Allow certain file formats
                                if ($fileType != "xlsx") {
                                    $error .= "<li>Upload alstublieft een .xlsx (Excel) bestand.</li>";
                                    $error_count++;
                                    $upload_success = 0;
                                }

                                // Check if $upload_success is set to 0 by an error
                                if ($upload_success == 1) {
                                    // if everything is ok, try to upload file
                                    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {

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
                                            $insert['Datum'] = strtotime($row[1]);
                                            //if ($i == 1) {
                                            //    if(!isvalidDate($row[1], 'd-m-Y')) {
                                            //       $error .= "<li>Vul a.u.b. een geldige waarde in het veld <b>Datum</b> in.</li>";
                                            //       $error_count++;
                                            //    }

                                            //}
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
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Activiteit</b> een geldige keuze in.</li>";
                                                    $error_count++;
                                                }

                                                if ($activiteit == "Verzaaien" && $_POST['verzaaien']) {
                                                    $verzaaien = TRUE;
                                                }
                                                $insert['Activiteit'] = $activiteit;
                                            }

                                            if ($i == 3) {
                                                $oppervlakte = $row[1];
                                            }
                                            if ($i == 5) {
                                                if ($row[1] == "Ja") {
                                                    $insert['Monster'] = TRUE;
                                                } else if ($row[1] == "Nee") {
                                                    $insert['Monster'] = FALSE;
                                                }
                                                else {
                                                    $insert['Monster'] = NULL;
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Monster?</b> een geldige keuze in.</li>";
                                                    $error_count++;

                                                }
                                            }
                                            if ($i == 6 && $insert['Monster'] == TRUE) {
                                                $insert['MonsterLabel'] = $row[1];
                                                if (!isValidText($insert['MonsterLabel'], 1, 200)) {
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Monster label</b> een geldige tekst in. (Minimale lengte: 1 teken; Maximale lengte: 200 tekens)</li>";
                                                    $error_count++;
                                                }
                                            }
                                            if ($i == 9 && $tabel != "behandeling") {
                                                $insert['Bustal'] = $row[1];
                                                if (!isValidInteger($insert['Bustal'], 1, 10)) {
                                                    "<li>Vul a.u.b. in het veld <b>Bustal/b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                                                    $error_count++;
                                                }
                                            }
                                            if ($i == 10 && $tabel == 'oogst') {
                                                $insert['Stukstal'] = $row[1];
                                                if (!isValidInteger($insert['Stukstal'], 1, 10)) {
                                                    "<li>Vul a.u.b. in het veld <b>Stukstal</b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                                                    $error_count++;
                                                }
                                            }
                                            if ($i == 11 && $tabel != "behandeling") {
                                                $insert['BrutoMton'] = $row[1];
                                                if (!isValidInteger($insert['BrutoMton'], 1, 10)) {
                                                    "<li>Vul a.u.b. in het veld <b>BrutoMton</b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                                                    $error_count++;
                                                }
                                                $insert['Kilogram'] = $insert['BrutoMton'] * 100;
                                                if ($oppervlakte != "") {
                                                    if (is_numeric($oppervlakte)) {
                                                        $kilogramPerM2 = $insert['Kilogram'] / ($oppervlakte * 10000);
                                                    }
                                                    else {
                                                        $error .= "<li>Vul a.u.b. in het veld <b>Oppervlakte</b> een geldig getal in.";
                                                        $error_count++;
                                                    }
                                                }
                                                else {
                                                    $error .= "<li>Vul a.u.b. het veld <b>Oppervlakte</b> in.";
                                                    $error_count++;
                                                }

                                                if ($tabel == 'zaaiing') {
                                                    $insert['KilogramPerM2'] = $kilogramPerM2;
                                                }

                                            }
                                            if ($i == 12) {
                                                $perceelLeeggevist = $row[1];
                                                if ($perceelLeeggevist != "Ja" && $perceelLeeggevist != "Nee") {
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Perceel leeggevist?</b> een geldige waarde in. ('Ja' of 'Nee')</li>";
                                                    $error_count++;
                                                }
                                            }
                                            if ($i == 13) {
                                                $insert['Opmerking'] = $row[1];
                                                if (!isValidText($insert['Opmerking'], 1, 200)) {
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Opmerking</b> een geldige tekst in. (Minimale lengte: 1 teken; Maximale lengte: 200 tekens)</li>";
                                                    $error_count++;
                                                }
                                            }
                                            $i++;
                                        }

                                        if ($tabel != 'oogst') {

                                            $insert['Bedrijf_BedrijfID'] = $_POST['bedrijf'];
                                            if (!is_numeric($insert['Bedrijf_BedrijfID'])){
                                                $error .= "<li>Vul a.u.b. in het veld <b>Bedrijf</b> een geldige keuze in.</li>";
                                                $error_count++;
                                            }

                                            $insert['Perceel_PerceelID'] = $_POST['perceel'];
                                            if (!is_numeric($insert['Perceel_PerceelID'])){
                                                $error .= "<li>Vul a.u.b. in het veld <b>Perceel</b> een geldige keuze in.</li>";
                                                $error_count++;
                                            }

                                            if (!isset($_POST['vak'])) {
                                                $error .= "<li>Vul a.u.b. het veld <b>Vak</b> in.</li>";
                                                $error_count++;
                                            }
                                            else {
                                                $insert['Vak_VakID'] = $_POST['vak'];
                                                if (!is_numeric($insert['Vak_VakID'])){
                                                    $error .= "<li>Vul a.u.b. in het veld <b>Vak</b> een geldige keuze in.</li>";
                                                    $error_count++;
                                                }
                                            }
                                        }
                                        if ($error_count == 0) {
                                            if ($tabel == 'zaaiing') {
                                                $success = $database->insert('mosselgroep', array('ParentMosselgroepID' => null));
                                                $insert['Mosselgroep_MosselgroepID'] = $database->getInsertId();
                                                if (!$success) {
                                                    $error .= "<li>Er is iets misgegaan in het aanmaken van een nieuwe <b>Mosselgroep</b>. Als dit blijft gebeuren, neem dan contact op met de ontwikkelaars.</li>";
                                                    $error_count++;
                                                }
                                            }
                                            if ($error_count == 0) {
                                                if ($verzaaien) {
                                                    if (isset($_POST['verzaaienPerceelSelect'])) {
                                                        if (!is_numeric($_POST['verzaaienPerceelSelect'])) {
                                                            $error .= "<li>Vul a.u.b. in het veld <b>Perceel (verzaaien)</b> een geldige keuze in.</li>";
                                                            $error_count++;
                                                        }
                                                    }
                                                    else {
                                                        $error .= "<li>Vul a.u.b. het veld <b>Perceel (verzaaien)</b> in.</li>";
                                                        $error_count++;
                                                    }
                                                    if (isset($_POST['verzaaienVakSelect'])) {
                                                        if (!is_numeric($_POST['verzaaienVakSelect'])) {
                                                            $error .= "<li>Vul a.u.b. in het veld <b>Vak (verzaaien)</b> een geldige keuze in.</li>";
                                                            $error_count++;
                                                        }
                                                    }
                                                    else {
                                                        $error .= "<li>Vul a.u.b. het veld <b>Vak (verzaaien)</b> in.</li>";
                                                        $error_count++;
                                                    }
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
                                                $success = $database->insert($tabel, $insert);
                                                if (!$success) {
                                                    $error .= "<li>Er is iets misgegaan in het aanmaken van een nieuwe <b>" . $tabel . "</b>. Als dit blijft gebeuren, neem dan contact op met de ontwikkelaars.</li>";
                                                }
                                                if ($tabel == "oogst") {
                                                    $oogstID = $database->getInsertId();
                                                } else if ($tabel == "behandeling") {
                                                    $behandelingID = $database->getInsertId();
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
                                                        $error .= "<li>Er is een fout opgetreden (oogstID niet meegegeven.)</li>";
                                                        $error_count++;
                                                    }
                                                }
                                                if ($tabel == 'behandeling') {
                                                    if (isset($behandelingID)) {
                                                        $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['bedrijf'] . "&behandelingID=" . $behandelingID;
                                                        header($location);
                                                        die();
                                                    }
                                                    else {
                                                        $error .= "<li>Er is een fout opgetreden (behandelingID niet meegegeven.)</li>";
                                                        $error_count++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                else {
                                    $error .= "<li>Het bestand kan niet geüpload worden.</li>";
                                    $error_count++;
                                }
                            }
                            if (isset($error_count)) {
                                if ($error_count > 0) {
                                    $error .= "</ul>";

                                    echo '<div class="alert alert-danger">';
                                        echo $error;
                                    echo '</div>';
                                }
                                else {
                                    echo '<div class="alert alert-success">';
                                    echo 'Het uploaden is geslaagd';
                                    echo '</div>';
                                }
                            }
                        ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Selecteer een bestand om te uploaden</label>
                                <input type="file" class="file" name="upload" id="upload">
                            </div>

                            <div class="form-group">
                                <label for="bedrijf">Bedrijf: </label>
                                <select id="bedrijf" name="bedrijf" class="form-control">
                                    <?php
                                        $bedrijven = $database->get('bedrijf');
                                        echo '<option selected disabled></option>';
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
                                    echo '<option selected disabled></option>';
                                    foreach($percelen as $perceel) {
                                        echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group" id="vak"></div>

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
                                    echo '<option selected disabled></option>';
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
                                    echo '<option selected disabled></option>';
                                    foreach($percelen as $perceel) {
                                        echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group" id="verzaaienVak"></div>

                            <div id="verzaaienOppervlakte" class="form-group">
                                <label for="verzaaienOppervlakte">Oppervlakte: </label>
                                <input type="text" id="verzaaienOppervlakte" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Upload spreadsheet</button>
                        </form>
                </div>
            </div>
        </section>

        <?php

            include_once('includes/footer.php');
            include_once('includes/scripts.php');

        ?>

        <!-- Specific JS files here -->
        <script src="/js/invulformulieren.js"></script>
        <script src="/bower_components/bootstrap-file/js/fileinput.min.js"></script>
        <script src="/bower_components/bootstrap-file/js/fileinput_locale_nl.js"></script>

    </body>
</html>