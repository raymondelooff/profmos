<?php

// Includes
require_once ('includes/MysqliDb.php');
require_once ('includes/connectdb.php');
require_once ('includes/functions.php');

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <?php

    include_once('includes/head.php');

    ?>

    <title>PROFMOS</title>
</head>

<body>

<?php

include_once ('includes/header.php');

?>

<section id="content">
    <div class="container">
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            date_default_timezone_set('Europe/Amsterdam');
            $error = "<ul>";
            $error_count = 0;
            $verzaaien = false;
            $tabel = "";
            $insert = array();
            $oppervlakte = 0;
            $kilogramPerM2 = NULL;
            if (!isvalidDate($_POST['Datum'], 'd-m-Y')) {
                $error .= "<li>Vul a.u.b. een geldige waarde in het veld <b>Datum</b> in.</li>";
                $error_count++;
            } else {
                $insert['Datum'] = strtotime($_POST['Datum']);
            }
            $activiteit = $_POST['Activiteit'];
            if ($activiteit == "Zaaien" || $activiteit == "Bijzaaien") {
                $tabel = 'zaaiing';
            } else if ($activiteit == "Leegvissen" || $activiteit == "Vissen voor veiling" || $activiteit == "Verzaaien") {
                $tabel = 'oogst';
            } else if ($activiteit == "Trekje op perceel" || $activiteit == "Sterren Dweilen" || $activiteit == "Sterren Rapen" || $activiteit == "Sterren" || $activiteit == "Onder Zoet Water" || $activiteit == "Onder Warm Water" || $activiteit == "Peulen" || $activiteit == "Groen" || $activiteit == "Droog Leggen" || $activiteit == "Over Spoelerij") {
                $tabel = 'behandeling';
            } else {
                $error .= "<li>Vul a.u.b. in het veld <b>Activiteit</b> een geldige keuze in.</li>";
                $error_count++;
            }

            if ($activiteit == "Verzaaien" && $_POST['Verzaaien']) {
                $verzaaien = TRUE;
            }
            $insert['Activiteit'] = $activiteit;

            $oppervlakte = $_POST['Oppervlakte'];
            if ($_POST['Monster'] == "Ja") {
                $insert['Monster'] = TRUE;
            } else if ($_POST['Monster'] == "Nee") {
                $insert['Monster'] = FALSE;
            } else {
                $insert['Monster'] = NULL;
                $error .= "<li>Vul a.u.b. in het veld <b>Monster?</b> een geldige keuze in.</li>";
                $error_count++;

            }
            $insert['MonsterLabel'] = $_POST['MonsterLabel'];
            if (!isValidText($insert['MonsterLabel'], 1, 200)) {
                $error .= "<li>Vul a.u.b. in het veld <b>Monster label</b> een geldige tekst in. (Minimale lengte: 1 teken; Maximale lengte: 200 tekens)</li>";
                $error_count++;
            }
            $insert['Bustal'] = $_POST['Bustal'];
            if (!isValidInteger($insert['Bustal'], 1, 10)) {
                $error .= "<li>Vul a.u.b. in het veld <b>Bustal</b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                $error_count++;
            }
            if ($tabel == 'oogst') {
                $insert['Stukstal'] = $_POST['Stukstal'];
                if (!isValidInteger($insert['Stukstal'], 1, 10)) {
                    $error .= "<li>Vul a.u.b. in het veld <b>Stukstal</b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                    $error_count++;
                }
            }
            $insert['BrutoMton'] = $_POST['BrutoMton'];
            if (!isValidInteger($insert['BrutoMton'], 1, 10)) {
                $error .= "<li>Vul a.u.b. in het veld <b>BrutoMton</b> een geldig geheel getal in. (Minimale lengte: 1 teken; Maximale lengte: 10 tekens)</li>";
                $error_count++;
            }
            $insert['Kilogram'] = $insert['BrutoMton'] * 100;
            if ($oppervlakte != "") {
                if (is_numeric($oppervlakte)) {
                    $kilogramPerM2 = $insert['Kilogram'] / ($oppervlakte * 10000);
                } else {
                    $error .= "<li>Vul a.u.b. in het veld <b>Oppervlakte</b> een geldig getal in.";
                    $error_count++;
                }
            } else {
                $error .= "<li>Vul a.u.b. het veld <b>Oppervlakte</b> in.";
                $error_count++;
            }

            if ($tabel == 'zaaiing') {
                $insert['KilogramPerM2'] = $kilogramPerM2;
            }

            $perceelLeeggevist = $_POST['PerceelLeeggevist'];
            if ($perceelLeeggevist != "Ja" && $perceelLeeggevist != "Nee") {
                $error .= "<li>Vul a.u.b. in het veld <b>Perceel leeggevist?</b> een geldige waarde in. ('Ja' of 'Nee')</li>";
                $error_count++;
            }
            $insert['Opmerking'] = $_POST['Opmerking'];
            if (!isValidText($insert['Opmerking'], 1, 200)) {
                $error .= "<li>Vul a.u.b. in het veld <b>Opmerking</b> een geldige tekst in. (Minimale lengte: 1 teken; Maximale lengte: 200 tekens)</li>";
                $error_count++;
            }

            if ($tabel != 'oogst') {

                $insert['Bedrijf_BedrijfID'] = $_POST['Bedrijf'];
                if (!is_numeric($insert['Bedrijf_BedrijfID'])) {
                    $error .= "<li>Vul a.u.b. in het veld <b>Bedrijf</b> een geldige keuze in.</li>";
                    $error_count++;
                }

                $insert['Perceel_PerceelID'] = $_POST['Perceel'];
                if (!is_numeric($insert['Perceel_PerceelID'])) {
                    $error .= "<li>Vul a.u.b. in het veld <b>Perceel</b> een geldige keuze in.</li>";
                    $error_count++;
                }

                if (!isset($_POST['Vak'])) {
                    $error .= "<li>Vul a.u.b. het veld <b>Vak</b> in.</li>";
                    $error_count++;
                } else {
                    $insert['Vak_VakID'] = $_POST['Vak'];
                    if (!is_numeric($insert['Vak_VakID'])) {
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
                        } else {
                            $error .= "<li>Vul a.u.b. het veld <b>Perceel (verzaaien)</b> in.</li>";
                            $error_count++;
                        }
                        if (isset($_POST['verzaaienVakSelect'])) {
                            if (!is_numeric($_POST['verzaaienVakSelect'])) {
                                $error .= "<li>Vul a.u.b. in het veld <b>Vak (verzaaien)</b> een geldige keuze in.</li>";
                                $error_count++;
                            }
                        } else {
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
                                $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['Bedrijf'] . "&oogstID=" . $oogstID . "&verzaaiingID=" . $verzaaienID . "&leeggevist=" . $perceelLeeggevist;
                            } else {
                                $location = "Location: selectZaaiing.php?bedrijfID=" . $_POST['Bedrijf'] . "&oogstID=" . $oogstID;

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
                        } else {
                            $error .= "<li>Er is een fout opgetreden (behandelingID niet meegegeven.)</li>";
                            $error_count++;
                        }
                    }
                }
            }
        }
        echo '<h1>Registratie kweekactiviteiten</h1>';
        if (isset($error_count)) {
            if ($error_count > 0) {
                $error .= "</ul>";
                echo '<div class="alert alert-danger">';
                echo $error;
                echo $error_count;
                echo '</div>';
            }
            else {
                echo '<div class="alert alert-success">';
                echo 'Het uploaden is geslaagd';
                echo '</div>';
            }
        }
        ?>

        <form role="form" method="post">

            <div class="row">
                <div class="col col-md-6">
                    <h3>Gegevens</h3>
                    <div class="form-group">
                        <label for="Datum">Datum:</label>
                        <input type="text" class="form-control date" name="Datum">
                    </div>

                    <div class="form-group">
                        <label for="Activiteit">Activiteit:</label>
                        <select class="form-control" id="Activiteit" name="Activiteit" >
                            <?php echo '<option selected disabled></option>'; ?>
                            <option >Zaaien</option>
                            <option >Bijzaaien</option>
                            <option >Verzaaien</option>
                            <option >Vissen voor veiling</option>
                            <option >Leegvissen</option>
                            <option >Trekje op perceel</option>
                            <option >Sterren dweilen</option>
                            <option >Sterren rapen</option>
                            <option >Sterren</option>
                            <option >Onder zoet water</option>
                            <option >Onder warm water</option>
                            <option >Peulen</option>
                            <option >Groen</option>
                            <option >Droog leggen</option>
                            <option >Over spoelerij</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Bedrijf">Bedrijf: </label>
                        <select id="Bedrijf" name="Bedrijf" class="form-control">
                            <?php
                            $bedrijven = $database -> get('bedrijf');
                            echo '<option selected disabled></option>';
                            foreach ($bedrijven as $bedrijf) {
                                echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' - ' . $bedrijf['Afkorting'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="perceel">Perceel: </label>
                        <select id="perceel" name="perceel" class="form-control" onchange="fillVak()">
                            <?php
                            $percelen = $database -> get('perceel');
                            echo '<option selected disabled></option>';
                            foreach ($percelen as $perceel) {
                                echo '<option value="' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="vak">
                    </div>

                    <div class="form-group">
                        <label for="Oppervlakte">Oppervlakte: </label>
                        <input type="float" class="form-control" id="Oppervlakte" name="Oppervlakte" >
                    </div>

                    <h3>Monster</h3>

                    <div class="form-group">
                        <label for="Monster">Monster:</label>
                        <select class="form-control" id="Monster" name="Monster" onchange="toggleMonster()">
                            <option selected disabled></option>
                            <option value="Ja">Ja</option>
                            <option value="Nee">Nee</option>
                        </select>
                    </div>

                    <div class="form-group" id="labelDiv">
                        <label for="MonsterLabel">Label: </label>
                        <input type="text" class="form-control" id="MonsterLabel" name="MonsterLabel">
                    </div>
                </div>

                <div class="col col-md-6">
                    <h3>Verzaaien</h3>

                    <div class="form-group">
                        <label for="verzaaienPerceelSelect">Perceel: </label>
                        <select id="verzaaienPerceelSelect" name="verzaaienPerceelSelect" class="form-control" onchange="fillVakVerzaaien()">
                            <?php
                            $percelen = $database -> get('perceel');
                            echo '<option selected disabled></option>';
                            foreach ($percelen as $perceel) {
                                echo '<option value="' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="verzaaienVak"></div>

                    <div class="form-group">
                        <label for="VerzaaienOppervlakte">Oppervlakte: </label>
                        <input type="float" class="form-control" id="VerzaaienOppervlakte" name="VerzaaienOppervlakte" >
                    </div>

                    <h3>Indien van toepassing</h3>

                    <div class="form-group">
                        <label for="Bustal">Bustal: </label>
                        <input type="text" class="form-control" id="Bustal" name="Bustal" >
                    </div>
                    <div class="form-group">
                        <label for="Stukstal">Stukstal: </label>
                        <input type="text" class="form-control" id="Stukstal" name="Stukstal" >
                    </div>
                    <div class="form-group">
                        <label for="BrutoMton">Mosselton: </label>
                        <input type="text" class="form-control" id="BrutoMton" name="BrutoMton" >
                    </div>

                    <div class="form-group">
                        <label for="PerceelLeeggevist">Perceel leeggevist?</label>
                        <select class="form-control" id="PerceelLeeggevist" name="PerceelLeeggevist" >
                            <option selected disabled></option>
                            <option >Ja</option>
                            <option >Nee</option>
                        </select>
                    </div>
                    <br>
                </div>

                <div class="form-group">
                    <label for="Opmerking">Opmerking:</label>
                    <textarea class="form-control" rows="5" id="Opmerking" name="Opmerking" ></textarea>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Verstuur">
                </div>
        </form>
    </div>
</section>

<?php

include_once('includes/footer.php');
include_once('includes/scripts.php');

?>

<!-- Specific JS files here -->
<script src="/js/invulformulieren.js"></script>

</body>
</html>