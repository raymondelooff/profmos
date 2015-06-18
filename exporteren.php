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

    <title>PROFMOS - Gegevens exporteren</title>
</head>

<body>

    <?php

        include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <h1>Gegevens exporteren</h1>
            <p>
                Selecteer de kenmerken van de gewenste gegevens en klik vervolgens op 'Toon' om een overzicht van de gegevens te krijgen.
                Deze dataset is vervolgens te exporteren door op de knop 'Exporteer' te drukken.
            </p>

            <form method="post" action="exporteren.php">

                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <label class="radio-inline"><input type="radio" name="type" id="type" value="1">Monster</label>
                            <label class="radio-inline"><input type="radio" name="type" id="type" value="2">Zaai/Oogst data</label>
                            <label class="radio-inline"><input type="radio" name="type" id="type" value="3">Monitoring</label>
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="bedrijf">Bedrijf (meerdere mogelijk):</label>
                            <select class="form-control" id="bedrijf" name="bedrijf[]" multiple>
                                <?php

                                    $bedrijven = $database->get('bedrijf');

                                    foreach($bedrijven AS $bedrijf) {
                                        echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' (' . $bedrijf['Afkorting'] . ')' . '</option>';
                                    }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="vak">Vakken (meerdere mogelijk):</label>
                            <select class="form-control" id="vak" name="vak[]" multiple>
                                <?php

                                $database->join('perceel', 'vak.Perceel_PerceelID = perceel.PerceelID', 'LEFT');
                                $vakken = $database->get('vak');

                                foreach($vakken AS $vak) {
                                    $naam = $vak['Plaats'] . $vak['Nummer'] . ' - ' . $vak['Omschrijving'];
                                    echo '<option value="' . $vak['VakID'] . '">' . $naam . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Toon gegevens</button>
                    </div>
                </div>

            </form>

            <?php

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $rules = array(
                    'type' => array(
                        'label' => 'Type',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 1
                    ),
                    'bedrijf' => 'optional',
                    'vak' => 'optional'
                );

                if(isValidArray($rules, $_POST)) {

                    if(isset($_POST['bedrijf']) && $_POST['type'] != '3') {
                        foreach($_POST['bedrijf'] AS $bedrijf) {
                            $database->orWhere('Bedrijf_BedrijfID', $bedrijf);
                        }
                    }

                    if(isset($_POST['vak'])) {
                        foreach($_POST['vak'] AS $vak) {
                            $database->where('Vak_VakID', $vak);
                        }
                    }

                    // Switch between tables
                    switch($_POST['type']) {
                        case '1':

                            // Join other tables
                            $database->join('bedrijf b', 'm.Bedrijf_BedrijfID = b.BedrijfID', 'LEFT');
                            $database->join('perceel p', 'm.Perceel_PerceelID = p.PerceelID', 'LEFT');
                            $database->join('vak v', 'm.Vak_VakID = v.VakID', 'LEFT');
                            $result = $database->get('monster m', null, '
                                m.*,

                                b.Naam AS b_Naam,
                                b.Afkorting AS b_Afkorting,

                                p.Plaats AS p_Plaats,
                                p.Nummer AS p_Nummer,

                                v.VakID AS v_VakID,
                                v.Omschrijving AS v_Omschrijving,
                                v.Oppervlakte AS v_Oppervlakte
                            ');

                            if($result) {
                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="monsters">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';

                                echo '<div class="table-responsive">';
                                    echo '<table id="monsters" class="table table-bordered table-striped table-hover">';

                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>Exporteren</th>';
                                            echo '<th>Monster ID</th>';
                                            echo '<th>Mosselgroep</th>';
                                            echo '<th>Bedrijf</th>';
                                            echo '<th>Perceel</th>';
                                            echo '<th>Nummer</th>';
                                            echo '<th>Vak</th>';
                                            echo '<th>Datum</th>';
                                            echo '<th>Bruto monster</th>';
                                            echo '<th>Netto monster</th>';
                                            echo '<th>Tarra</th>';
                                            echo '<th>Busstal</th>';
                                            echo '<th>Gewicht mossel</th>';
                                            echo '<th>Slippers</th>';
                                            echo '<th>Zeester</th>';
                                            echo '<th>Pokken</th>';
                                            echo '<th>Bus netto</th>';
                                            echo '<th>Aantal kookmonsters</th>';
                                            echo '<th>Netto kookmonsters</th>';
                                            echo '<th>Vis totale monster</th>';
                                            echo '<th>Vispercentage</th>';
                                            echo '<th>Stukstal</th>';
                                            echo '<th>Kroesnummer</th>';
                                            echo '<th>Kroes</th>';
                                            echo '<th>Kroes en vlees</th>';
                                            echo '<th>DW</th>';
                                            echo '<th>AFDW</th>';
                                            echo '<th>AFDWpM</th>';
                                            echo '<th>Schelpen droog</th>';
                                            echo '<th>Gemiddelde lengte</th>';
                                            echo '<th>GrGewicht</th>';
                                            echo '<th>GrLengte</th>';
                                            echo '<th>GrAFDW</th>';
                                            echo '<th>Opmerking</th>';
                                        echo '</tr>';
                                    echo '</thead>';

                                    foreach ($result as $row) {
                                        echo '<tr class="active">';
                                            echo '<td class="text-center"><input type="checkbox" class="toggle-active-row" checked></td>';
                                            echo '<td>' . $row['MonsterID'] . '</td>';
                                            echo '<td><a href="mosselgroep.php?id=' . $row['mosselgroep_MosselgroepID'] . '">Bekijken</a></td>';
                                            echo '<td>' . $row['b_Naam'] . '</td>';
                                            echo '<td>' . $row['p_Plaats'] . '</td>';
                                            echo '<td>' . $row['p_Nummer'] . '</td>';
                                            echo '<td>' . $row['v_Omschrijving'] . '</td>';
                                            echo '<td>' . date('d-m-Y', $row['Datum']) . '</td>';
                                            echo '<td>' . $row['BrutoMonster'] . '</td>';
                                            echo '<td>' . $row['NettoMonster'] . '</td>';
                                            echo '<td>' . $row['Tarra'] . '</td>';
                                            echo '<td>' . $row['Busstal'] . '</td>';
                                            echo '<td>' . $row['GewichtMossel'] . '</td>';
                                            echo '<td>' . $row['Slippers'] . '</td>';
                                            echo '<td>' . $row['Zeester'] . '</td>';
                                            echo '<td>' . $row['Pokken'] . '</td>';
                                            echo '<td>' . $row['BusNetto'] . '</td>';
                                            echo '<td>' . $row['AantalKookmonsters'] . '</td>';
                                            echo '<td>' . $row['NettoKookmonster'] . '</td>';
                                            echo '<td>' . $row['VisTotaleMonster'] . '</td>';
                                            echo '<td>' . $row['VisPercentage'] . '</td>';
                                            echo '<td>' . $row['Stukstal'] . '</td>';
                                            echo '<td>' . $row['Kroesnr'] . '</td>';
                                            echo '<td>' . $row['Kroes'] . '</td>';
                                            echo '<td>' . $row['KroesEnVlees'] . '</td>';
                                            echo '<td>' . $row['DW'] . '</td>';
                                            echo '<td>' . $row['AFDW'] . '</td>';
                                            echo '<td>' . $row['AFDWpM'] . '</td>';
                                            echo '<td>' . $row['SchelpenDroog'] . '</td>';
                                            echo '<td>' . $row['GemiddeldeLengte'] . '</td>';
                                            echo '<td>' . $row['GrGewicht'] . '</td>';
                                            echo '<td>' . $row['GrLengte'] . '</td>';
                                            echo '<td>' . $row['GrAFDW'] . '</td>';
                                            echo '<td>' . $row['Opmerking'] . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</table>';
                                echo '</div>';

                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="monsters">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';
                            }
                            else {
                                echo '<p class="alert alert-danger">Kon geen gegevens vinden.</p>';
                            }

                            break;

                        case '2':

                            // Join other tables
                            $database->join('bedrijf b', 'z.Bedrijf_BedrijfID = b.BedrijfID', 'LEFT');
                            $database->join('perceel p', 'z.Perceel_PerceelID = p.PerceelID', 'LEFT');
                            $database->join('vak v', 'z.Vak_VakID = v.VakID', 'LEFT');

                            $result = $database->get('zaaiing z', null,
                                'z.ZaaiingID,
                                z.Bedrijf_BedrijfID,
                                z.Perceel_PerceelID,
                                z.Mosselgroep_MosselgroepID,
                                z.Activiteit AS z_Activiteit,
                                z.Datum AS z_Datum,
                                z.BrutoMton AS z_BrutoMton,
                                z.Kilogram AS z_Kilogram,
                                z.KilogramPerM2,
                                z.Bustal AS z_Bustal,
                                z.Monster AS z_Monster,
                                z.MonsterLabel AS z_MonsterLabel,
                                z.Opmerking AS z_Opmerking,

                                b.Naam AS b_Naam,
                                b.Afkorting AS b_Afkorting,

                                p.Plaats AS p_Plaats,
                                p.Nummer AS p_Nummer,

                                v.VakID AS v_VakID,
                                v.Omschrijving AS v_Omschrijving,
                                v.Oppervlakte AS v_Oppervlakte'
                            );

                            // Check if the result is success
                            if($result) {
                                $i = 0;

                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="zaaiing-oogst">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';

                                echo '<div class="table-responsive">';
                                    echo '<table id="zaaiing-oogst" class="table table-bordered table-striped table-hover">';

                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th colspan="6"></th>';
                                            echo '<th colspan="9">Gezaaid</th>';
                                            echo '<th colspan="11">Geoogst</th>';
                                        echo '</tr>';

                                        echo '<tr>';
                                            echo '<th>Exporteren</th>';
                                            echo '<th>Zaaiing ID</th>';
                                            echo '<th>Mosselgroep</th>';
                                            echo '<th>Bedrijf</th>';
                                            echo '<th>Perceel</th>';
                                            echo '<th>Nummer</th>';
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

                                            echo '<th>Datum</th>';
                                            echo '<th>Activiteit</th>';
                                            echo '<th>Bruto Mton</th>';
                                            echo '<th>Kg</th>';
                                            echo '<th>Rendement</th>';
                                            echo '<th>Stukstal</th>';
                                            echo '<th>Bustal</th>';
                                            echo '<th>Oppervlakte</th>';
                                            echo '<th>Monster</th>';
                                            echo '<th>Monster Opmerking</th>';
                                            echo '<th>Opmerking</th>';
                                        echo '</tr>';
                                    echo '</thead>';

                                    foreach($result as $row) {

                                        $database->where('o.Zaaiing_ZaaiingID', $row['ZaaiingID']);
                                        $result2 = $database->get('oogst o', null, '
                                                o.OogstID,
                                                o.Activiteit AS o_Activiteit,
                                                o.Datum AS o_Datum,
                                                o.BrutoMton AS o_BrutoMton,
                                                o.Kilogram AS o_Kilogram,
                                                o.Rendement,
                                                o.Stukstal,
                                                o.Bustal AS o_Bustal,
                                                o.Oppervlakte,
                                                o.Monster AS o_Monster,
                                                o.MonsterLabel AS o_MonsterLabel,
                                                o.Opmerking AS o_Opmerking
                                            ');

                                        echo '<tr class="active">';
                                            echo '<td class="text-center"><input type="checkbox" class="toggle-active-row" checked></td>';
                                            echo '<td>' . $row['ZaaiingID'] . '</td>';
                                            echo '<td><a href="mosselgroep.php?id=' . $row['Mosselgroep_MosselgroepID'] . '">Bekijken</a></td>';
                                            echo '<td>' . $row['b_Naam'] . '</td>';
                                            echo '<td>' . $row['p_Plaats'] . '</td>';
                                            echo '<td>' . $row['p_Nummer'] . '</td>';
                                            echo '<td>' . $row['v_Omschrijving'] . '</td>';

                                            echo '<td>' . date('d-m-Y', $row['z_Datum']) . '</td>';
                                            echo '<td>' . $row['z_Activiteit'] . '</td>';
                                            echo '<td>' . $row['z_BrutoMton'] . '</td>';
                                            echo '<td>' . $row['z_Kilogram'] . '</td>';
                                            echo '<td>' . $row['KilogramPerM2'] . '</td>';
                                            echo '<td>' . $row['z_Bustal'] . '</td>';
                                            echo '<td>' . $row['z_Monster'] . '</td>';
                                            echo '<td>' . $row['z_MonsterLabel'] . '</td>';
                                            echo '<td>' . $row['z_Opmerking'] . '</td>';

                                            if(isset($result2[$i])) {
                                                echo '<td>' . date('d-m-Y', $result2[$i]['o_Datum']) . '</td>';
                                                echo '<td>' . $result2[$i]['o_Activiteit'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_BrutoMton'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_Kilogram'] . '</td>';
                                                echo '<td>' . $result2[$i]['Rendement'] . '</td>';
                                                echo '<td>' . $result2[$i]['Stukstal'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_Bustal'] . '</td>';
                                                echo '<td>' . $result2[$i]['Oppervlakte'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_Monster'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_MonsterLabel'] . '</td>';
                                                echo '<td>' . $result2[$i]['o_Opmerking'] . '</td>';
                                            }
                                            else {
                                                echo '<th colspan="11"></th>';
                                            }
                                        echo '</tr>';

                                        $i++;
                                    }

                                    echo '</table>';
                                echo '</div>';

                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="zaaiing-oogst">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';
                            }
                            else {
                                echo '<p class="alert alert-danger">Kon geen gegevens vinden.</p>';
                            }

                            break;

                        case '3':

                            // Join other tables
                            $database->join('perceel p', 'm.Perceel_PerceelID = p.PerceelID', 'LEFT');
                            $database->join('vak v', 'm.Vak_VakID = v.VakID', 'LEFT');

                            $result = $database->get('meting m', null,
                                'm.*,

                                p.Plaats AS p_Plaats,
                                p.Nummer AS p_Nummer,

                                v.VakID AS v_VakID,
                                v.Omschrijving AS v_Omschrijving,
                                v.Oppervlakte AS v_Oppervlakte'
                            );

                            if($result) {
                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="monitoring">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';

                                echo '<div class="table-responsive">';
                                    echo '<table id="monitoring" class="table table-bordered table-striped table-hover">';

                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Exporteren</th>';
                                                echo '<th>Meting ID</th>';
                                                echo '<th>Perceel</th>';
                                                echo '<th>Nummer</th>';
                                                echo '<th>Vak</th>';
                                                echo '<th>Datum</th>';
                                                echo '<th>Compartiment</th>';
                                                echo '<th>Type</th>';
                                                echo '<th>Lengte</th>';
                                                echo '<th>Natgewicht</th>';
                                                echo '<th>Visgewicht</th>';
                                                echo '<th>AFDW</th>';
                                                echo '<th>Drooggewicht schelp</th>';
                                            echo '</tr>';
                                        echo '</thead>';

                                        foreach ($result as $row) {
                                            echo '<tr class="active">';
                                                echo '<td class="text-center"><input type="checkbox" class="toggle-active-row" checked></td>';
                                                echo '<td>' . $row['MetingID'] . '</td>';
                                                echo '<td>' . $row['p_Plaats'] . '</td>';
                                                echo '<td>' . $row['p_Nummer'] . '</td>';
                                                echo '<td>' . $row['v_Omschrijving'] . '</td>';
                                                echo '<td>' . date('d-m-Y', $row['Datum']) . '</td>';
                                                echo '<td>' . $row['Compartiment'] . '</td>';
                                                echo '<td>' . $row['Type'] . '</td>';
                                                echo '<td>' . $row['Lengte'] . '</td>';
                                                echo '<td>' . $row['Natgewicht'] . '</td>';
                                                echo '<td>' . $row['Visgewicht'] . '</td>';
                                                echo '<td>' . $row['AFDW'] . '</td>';
                                                echo '<td>' . $row['DW_Schelp'] . '</td>';
                                            echo '</tr>';
                                        }

                                    echo '</table>';
                                echo '</div>';

                                echo '<p class="text-right">';
                                    echo '<a href="#" class="btn btn-primary export-table" data-export-table-id="monitoring">Geselecteerde gegevens exporteren</a>';
                                echo '</p>';
                            }
                            else {
                                echo '<p class="alert alert-danger">Kon geen gegevens vinden.</p>';
                            }

                            break;
                    }
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
	<script src="/js/invulformulieren.js"></script>

</body>
</html>