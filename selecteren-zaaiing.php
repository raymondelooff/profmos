<?php

    // Includes
    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');
$error_msg = "";
if (isset($_GET['zaaiingID'])) {
    if (isset($_GET['oogstID'])) {
        $database->where('OogstID', $_GET['oogstID']);
        $success = $database->update(
            'oogst',
            array(
                'Zaaiing_ZaaiingID' => $_GET['zaaiingID']
            )
        );
        if (!$success) {
            $error_msg .= "De zaaiing kon niet toegevoegd worden.";
        }
        $mosselgroepID = NULL;

        $mosselgroepResult = $database->rawQuery("
                                    SELECT Z.Mosselgroep_MosselgroepID AS Mosselgroep_MosselgroepID
                                    FROM zaaiing Z, oogst O
                                    WHERE OogstID = " . $_GET['oogstID'] . "
                                    AND ZaaiingID = O.Zaaiing_ZaaiingID
                                    ");
        foreach($mosselgroepResult as $mosselgroepRow) {
            if ($mosselgroepID == NULL) {
                $mosselgroepID = $mosselgroepRow['Mosselgroep_MosselgroepID'];
            }
        }

        if ($_GET['leeggevist'] == "Nee") {
            $database->insert('mosselgroep', array('ParentMosselgroepID' => $mosselgroepID));
            $mosselgroepID = $database->getInsertId();
        }

        $database->where('OogstID', $_GET['oogstID']);
        $success = $database->update(
            'oogst',
            array(
                'Mosselgroep_MosselgroepID' => $mosselgroepID
            )
        );
        if (!$success) {
            $error_msg .= "De zaaiing kon niet toegevoegd worden.";
        }
        if (isset($_GET['verzaaiingID'])) {
            $database->where('ZaaiingID', $_GET['verzaaiingID']);
            $database->update('zaaiing', array('Mosselgroep_MosselgroepID' => $mosselgroepID));
        }
    }
    if (isset($_GET['behandelingID'])) {
        $database->where('BehandelingID', $_GET['behandelingID']);
        $success = $database->update(
            'behandeling',
            array(
                'Zaaiing_ZaaiingID' => $_GET['zaaiingID'],
            )
        );
        if (!$success) {
            $error_msg .= "De zaaiing kon niet toegevoegd worden.";
        }
        $mosselgroepResult = $database->rawQuery("
                                        SELECT Z.Mosselgroep_MosselgroepID AS Mosselgroep_MosselgroepID
                                        FROM zaaiing Z, behandeling B
                                        WHERE BehandelingID = " . $_GET['behandelingID'] . "
                                        AND ZaaiingID = Zaaiing_ZaaiingID
                                        ");
        $mosselgroepID = NULL;
        foreach($mosselgroepResult as $mosselgroepRow) {
            $mosselgroepID = $mosselgroepRow['Mosselgroep_MosselgroepID'];
        }
        $database->where('BehandelingID', $_GET['behandelingID']);
        $success = $database->update(
            'behandeling',
            array(
                'Mosselgroep_MosselgroepID' => $mosselgroepID
            )
        );
        if (!$success) {
            $error_msg .= "De zaaiing kon niet toegevoegd worden.";
        }
    }
    header("Location: ./invoeren-upload.php");
    die();
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php

            include_once('includes/head.php');

        ?>

        <title>PROFMOS - Selecteren zaaiing</title>
    </head>

    <body>
        <?php

            include_once('includes/header.php');

        ?>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">
                        <?php

                            $bedrijf_id = 1; // Moet gekoppeld worden aan sessie
                            echo '<h2>Zaaiingen</h2>';
                            $database->where('Bedrijf_BedrijfID', $bedrijf_id);
                            if (!isset($_GET['bedrijfID'])) {
                                $error_msg .= "Het bedrijfID is niet meegegeven. ";
                            }
                            else if (!isset($_GET['oogstID']) && !isset($_GET['behandelingID'])) {
                                $error_msg .= "Het oogstID en behandelingID zijn niet meegegeven. ";
                            }
                            else if (isset($_GET['oogstID']) && isset($_GET['behandelingID'])) {
                                $error_msg .= "Het oogstID en behandelingID zijn allebei meegegeven. ";
                            }
                            else {
                                $bedrijfID = $_GET['bedrijfID'];
                                $result = $database->rawQuery("
                                SELECT Z.ZaaiingID, V.Omschrijving, P.Plaats, P.Nummer, M.MosselgroepID, Z.Activiteit,
                                    Z.Datum, Z.BrutoMton, Z.Kilogram, Z.KilogramPerM2, Z.Bustal, Z.Monster,
                                    Z.MonsterLabel, Z.Opmerking
                                FROM zaaiing Z, vak V, perceel P, bedrijf B, mosselgroep M
                                WHERE Z.Bedrijf_BedrijfID = B.BedrijfID
                                AND Z.Vak_VakID = V.VakID
                                AND Z.Perceel_PerceelID = P.PerceelID
                                AND V.Perceel_PerceelID = P.PerceelID
                                AND Z.Mosselgroep_MosselgroepID = M.MosselgroepID
                                AND Z.Bedrijf_BedrijfID = " . $bedrijfID
                                );

                                if($result) {
                                    echo '<table class="table">';
                                    echo '<thead>';
                                    echo '<th>ID</th>';
                                    echo '<th>Vak</th>';
                                    echo '<th>Perceelnaam</th>';
                                    echo '<th>Perceelnummer</th>';
                                    echo '<th>Mosselgroep</th>';
                                    echo '<th>Activiteit</th>';
                                    echo '<th>Datum</th>';
                                    echo '<th>BrutoMton</th>';
                                    echo '<th>Kilogram</th>';
                                    echo '<th>Kilogram per m2</th>';
                                    echo '<th>Bustal</th>';
                                    echo '<th>Monster?</th>';
                                    echo '<th>Monster label</th>';
                                    echo '<th>Opmerking</th>';
                                    echo '<th>Selecteren</th>';
                                    echo '</thead>';

                                    foreach($result as $row) {
                                        echo '<tr>';
                                        echo '<td>' . $row['ZaaiingID'] . '</td>';
                                        echo '<td>' . $row['Omschrijving'] . '</td>';
                                        echo '<td>' . $row['Plaats'] . '</td>';
                                        echo '<td>' . $row['Nummer'] . '</td>';
                                        echo '<td>' . $row['MosselgroepID'] . '</td>';
                                        echo '<td>' . $row['Activiteit'] . '</td>';
                                        echo '<td>' . $row['Datum'] . '</td>';
                                        echo '<td>' . $row['BrutoMton'] . '</td>';
                                        echo '<td>' . $row['Kilogram'] . '</td>';
                                        echo '<td>' . round($row['KilogramPerM2'], 3) . '</td>';
                                        echo '<td>' . $row['Bustal'] . '</td>';
                                        echo '<td>' . $row['Monster'] . '</td>';
                                        if ($row['Monster'] == NULL || $row['Monster'] == 0) {
                                            $monsterLabel = "";
                                        }
                                        else {
                                            $monsterLabel = $row['MonsterLabel'];
                                        }
                                        echo '<td>' . $monsterLabel. '</td>';
                                        echo '<td>' . $row['Opmerking'] . '</td>';

                                        if (isset($_GET['oogstID'])) {
                                            echo '<td><a href="selecteren-zaaiing.php?zaaiingID=' . $row['ZaaiingID'] . '&oogstID=' . $_GET['oogstID'];
                                            if (isset($_GET['verzaaiingID'])) {
                                                echo '&verzaaiingID=' . $_GET['verzaaiingID'];
                                            }
                                            if (isset($_GET['leeggevist'])) {
                                                echo '&leeggevist=' . $_GET['leeggevist'];
                                            }
                                            echo '">Selecteer zaaiing &raquo;</a></td>';
                                        }
                                        if (isset($_GET['behandelingID'])) {
                                            if (isset($_GET['leeggevist'])) {
                                                echo '<td><a href="selecteren-zaaiing.php?zaaiingID=' . $row['ZaaiingID'] . '&behandelingID=' . $_GET['behandelingID'] . '&leeggevist' . $_GET['leeggevist'] . '>Selecteer zaaiing &raquo;</a></td>';

                                            }
                                            else {
                                                echo '<td><a href="selecteren-zaaiing.php?zaaiingID=' . $row['ZaaiingID'] . '&behandelingID=' . $_GET['behandelingID'] . '">Selecteer zaaiing &raquo;</a></td>';

                                            }
                                        }
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                }
                                else {
                                    echo '<p>Nog geen zaaiingen gevonden van uw bedrijf.</p>';
                                }
                            }
                        echo $error_msg;

                        ?>
                    </div>
                </div>
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