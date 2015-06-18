<?php

require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');
require_once('includes/functions.php');

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

        include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <?php

                $rules = array(
                    'id' => array(
                        'label' => 'Mosselgroep ID',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'ckcachecontrol' => 'optional'
                );

                $get = isValidArray($rules, $_GET);

                if($get !== FALSE) {
                    echo '<h1>Mosselgroep overzicht</h1>';
                    echo '<p>Deze pagina toont de gegevens van de mosselgroep met nummer ' . $get['id'] . '.';

                    // Subgroepen
                    echo '<h2>Subgroepen</h2>';
                    $database->where('ParentMosselgroepID', $get['id']);
                    $subgroepen = $database->get('mosselgroep');

                    if($database->count > 0) {
                        echo '<ul>';
                            foreach ($subgroepen as $subgroep) {
                                echo '<li>Mosselgroep ' . $subgroep['MosselgroepID'] . ': <a href="mosselgroep.php?id=' . $subgroep['MosselgroepID'] . '">Bekijken &raquo;</a></li>';
                            }
                        echo '</ul>';
                    }
                    else {
                        echo '<p class="alert alert-info">Er zijn geen subgroepen van deze mosselgroep.</p>';
                    }

                    // Parent groep
                    echo '<h2>Supergroep</h2>';
                    $database->where('MosselgroepID', $get['id']);
                    $supergroep = $database->getOne('mosselgroep');

                    if(!empty($supergroep['ParentMosselgroepID'])) {
                        echo '<ul>';
                            echo '<li>Mosselgroep ' . $supergroep['ParentMosselgroepID'] . ': <a href="mosselgroep.php?id=' . $supergroep['ParentMosselgroepID'] . '">Bekijken &raquo;</a></li>';
                        echo '</ul>';
                    }
                    else {
                        echo '<p class="alert alert-info">Er is geen supergroep van deze mosselgroep.</p>';
                    }

                    // Zaaiingen
                    echo '<h2>Zaaiingen</h2>';
                    $database->join('bedrijf b', 'z.Bedrijf_BedrijfID = b.BedrijfID', 'LEFT');
                    $database->join('perceel p', 'z.Perceel_PerceelID = p.PerceelID', 'LEFT');
                    $database->join('vak v', 'z.Vak_VakID = v.VakID', 'LEFT');
                    $database->where('Mosselgroep_mosselgroepID', $get['id']);
                    $results = $database->get('zaaiing z', null,
                        'z.*,

                        b.Naam AS b_Naam,
                        b.Afkorting AS b_Afkorting,

                        p.Plaats AS p_Plaats,
                        p.Nummer AS p_Nummer,

                        v.VakID AS v_VakID,
                        v.Omschrijving AS v_Omschrijving,
                        v.Oppervlakte AS v_Oppervlakte'
                    );

                    if($database->count > 0) {
                        echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-striped table-hover">';
                                echo '<tr>';
                                    echo '<th>Zaaiing ID</th>';
                                    echo '<th>Bedrijf</th>';
                                    echo '<th>Perceel</th>';
                                    echo '<th>Vak</th>';
                                    echo '<th>Datum</th>';
                                    echo '<th>Activiteit</th>';
                                    echo '<th>Bruto Mton</th>';
                                    echo '<th>Kg</th>';
                                    echo '<th>Kg/m<sup>2</sup></th>';
                                    echo '<th>Bustal</th>';
                                    echo '<th>Monster</th>';
                                    echo '<th>Monster Opmerking</th>';
                                    echo '<th>Opmerking</th>';
                                echo '</tr>';

                                foreach ($results as $result) {
                                    echo '<tr>';
                                        echo '<td>' . $result['ZaaiingID'] . '</td>';
                                        echo '<td>' . $result['b_Naam'] . '</td>';
                                        echo '<td>' . $result['p_Plaats'] . $result['p_Nummer'] . '</td>';
                                        echo '<td>' . $result['v_Omschrijving'] . '</td>';
                                        echo '<td>' . date('d-m-Y', $result['Datum']) .   '</td>';
                                        echo '<td>' . $result['Activiteit'] . '</td>';
                                        echo '<td>' . $result['BrutoMton'] . '</td>';
                                        echo '<td>' . $result['Kilogram'] . '</td>';
                                        echo '<td>' . $result['KilogramPerM2'] . '</td>';
                                        echo '<td>' . $result['Bustal'] . '</td>';
                                        echo '<td>' . $result['Monster'] . '</td>';
                                        echo '<td>' . $result['MonsterLabel'] . '</td>';
                                        echo '<td>' . $result['Opmerking'] . '</td>';
                                    echo '</tr>';
                                }
                            echo '</table>';
                        echo '</div>';
                    }
                    else {
                        echo '<p class="alert alert-info">Er zijn geen zaaiingen gevonden van deze mosselgroep.</p>';
                    }

                    // Oogst
                    echo '<h2>Oogst</h2>';
                    $database->where('Mosselgroep_mosselgroepID', $get['id']);
                    $results = $database->get('oogst');

                    if($database->count > 0) {
                        echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-striped table-hover">';
                                echo '<tr>';
                                    echo '<th>Oogst ID</th>';
                                    echo '<th>Zaaiing ID</th>';
                                    echo '<th>Datum</th>';
                                    echo '<th>Activiteit</th>';
                                    echo '<th>BrutoMton</th>';
                                    echo '<th>Kg</th>';
                                    echo '<th>Rendement</th>';
                                    echo '<th>Stukstal</th>';
                                    echo '<th>Bustal</th>';
                                    echo '<th>Oppervlakte<sup>2</sup></th>';
                                    echo '<th>Monster</th>';
                                    echo '<th>Monster Opmerking</th>';
                                    echo '<th>Opmerking</th>';
                                echo '</tr>';

                                foreach ($results as $result) {
                                    echo '<tr>';
                                    echo '<td>' . $result['OogstID'] . '</td>';
                                    echo '<td>' . $result['Zaaiing_ZaaiingID'] . '</td>';
                                    echo '<td>' . date('d-m-Y', $result['Datum']) . '</td>';
                                    echo '<td>' . $result['Activiteit'] . '</td>';
                                    echo '<td>' . $result['BrutoMton'] . '</td>';
                                    echo '<td>' . $result['Kilogram'] . '</td>';
                                    echo '<td>' . $result['Rendement'] . '</td>';
                                    echo '<td>' . $result['Stukstal'] . '</td>';
                                    echo '<td>' . $result['Bustal'] . '</td>';
                                    echo '<td>' . $result['Oppervlakte'] . '</td>';
                                    echo '<td>' . $result['Monster'] . '</td>';
                                    echo '<td>' . $result['MonsterLabel'] . '</td>';
                                    echo '<td>' . $result['Opmerking'] . '</td>';
                                    echo '</tr>';
                                }
                            echo '</table>';
                        echo '</div>';
                    }
                    else {
                        echo '<p class="alert alert-info">Er zijn geen oogsten gevonden van deze mosselgroep.</p>';
                    }

                    // Behandelingen
                    echo '<h2>Behandelingen</h2>';
                    $database->join('perceel p', 'b.Perceel_PerceelID = p.PerceelID', 'LEFT');
                    $database->join('vak v', 'b.Vak_VakID = v.VakID', 'LEFT');
                    $database->where('Mosselgroep_mosselgroepID', $get['id']);
                    $results = $database->get('behandeling b', null,
                        'b.*,

                        p.Plaats AS p_Plaats,
                        p.Nummer AS p_Nummer,

                        v.VakID AS v_VakID,
                        v.Omschrijving AS v_Omschrijving,
                        v.Oppervlakte AS v_Oppervlakte'
                    );

                    if($database->count > 0) {
                        echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-striped table-hover">';
                                echo '<tr>';
                                    echo '<th>Behandeling ID</th>';
                                    echo '<th>Zaaing ID</th>';
                                    echo '<th>Perceel</th>';
                                    echo '<th>Vak</th>';
                                    echo '<th>Datum</th>';
                                    echo '<th>Activiteit</th>';
                                    echo '<th>Monster</th>';
                                    echo '<th>Monster Opmerking</th>';
                                    echo '<th>Opmerking</th>';
                                echo '</tr>';

                                foreach ($results as $result) {
                                    echo '<tr>';
                                        echo '<td>' . $result['BehandelingID'] . '</td>';
                                        echo '<td>' . $result['Zaaiing_ZaaiingID'] . '</td>';
                                        echo '<td>' . $result['p_Plaats'] . $result['p_Nummer'] . '</td>';
                                        echo '<td>' . $result['v_Omschrijving'] . '</td>';
                                        echo '<td>' . date('d-m-Y', $result['Datum']) . '</td>';
                                        echo '<td>' . $result['Activiteit'] . '</td>';
                                        echo '<td>' . $result['Monster'] . '</td>';
                                        echo '<td>' . $result['MonsterLabel'] . '</td>';
                                        echo '<td>' . $result['Opmerking'] . '</td>';
                                    echo '</tr>';
                                }
                            echo '</table>';
                        echo '</div>';
                    }
                    else {
                        echo '<p class="alert alert-info">Er zijn geen behandelingen gevonden van deze mosselgroep.</p>';
                    }

                }

            ?>
        </div>
    </section>

    <?php

        include_once('includes/footer.php');
        include_once('includes/scripts.php');

    ?>

    <!-- Specific JS files here -->


</body>
</html>