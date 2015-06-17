<?php

    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');
    require_once('includes/functions.php');

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
	<link href="css/screen.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

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

            <form method="post">

                <div class="row">
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <label class="radio-inline"><input type="radio" name="type" id="type" value="1">Monitoring</label>
                            <label class="radio-inline"><input type="radio" name="type" id="type" value="2">Zaai/Oogst data</label>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="bedrijf">Bedrijf (meerdere mogelijk):</label>
                            <select class="form-control" id="bedrijf" name="bedrijf[]" multiple>
                                <?php

                                    $bedrijven = $database->get('bedrijf');

                                    foreach($bedrijven as $bedrijf) {
                                        echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' (' . $bedrijf['Afkorting'] . ')' . '</option>';
                                    }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="vak">Vakken (meerdere mogelijk):</label>
                            <select class="form-control" id="vak" name="vak[]" multiple>
                                <?php

                                $database->join('perceel', 'vak.Perceel_PerceelID = perceel.PerceelID', 'LEFT');
                                $vakken = $database->get('vak');

                                foreach($vakken as $vak) {
                                    $naam = $vak['Plaats'] . $vak['Nummer'] . ' - ' . $vak['Omschrijving'];
                                    echo '<option value="' . $vak['VakID'] . '">' . $naam . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col col-md-3">
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

                    if(isset($_POST['bedrijf'])) {
                        foreach($_POST['bedrijf'] as $bedrijf) {
                            print_r($bedrijf);
                            $database->orWhere('Bedrijf_BedrijfID', $bedrijf);
                        }
                    }

                    if(isset($_POST['vak'])) {
                        foreach($_POST['vak'] as $vak) {
                            $database->orWhere('Vak_VakID', $vak);
                        }
                    }

                    // Switch between tables
                    switch($_POST['type']) {
                        case '1':
                            $result = $database->get('monster');

                            print_r($result);

                            break;

                        case '2':

                            // Join other tables
                            /*$result = $database->rawQuery('

                                SELECT
                                    z.ZaaiingID,
                                    z.Bedrijf_BedrijfID,
                                    z.Perceel_PerceelID,
                                    z.Mosselgroep_MosselgroepID,
                                    z.Activiteit as z_Activiteit,
                                    z.Datum as z_Datum,
                                    z.BrutoMton as z_BrutoMton,
                                    z.Kilogram as z_Kilogram,
                                    z.KilogramPerM2,
                                    z.Bustal as z_Bustal,
                                    z.Monster as z_Monster,
                                    z.MonsterLabel as z_MonsterLabel,
                                    z.Opmerking as z_Opmerking,

                                    o.OogstID,
                                    o.Activiteit as o_Activiteit,
                                    o.Datum as o_Datum,
                                    o.BrutoMton as o_BrutoMton,
                                    o.Kilogram as o_Kilogram,
                                    o.Rendement,
                                    o.Stukstal,
                                    o.Bustal as o_Bustal,
                                    o.Oppervlakte,
                                    o.Monster as o_Monster,
                                    o.MonsterLabel as o_MonsterLabel,
                                    o.Opmerking as o_Opmerking,

                                    b.Naam as b_Naam,
                                    b.Afkorting as b_Afkorting,

                                    p.Plaats as p_Plaats,
                                    p.Nummer as p_Nummer,

                                    v.VakID as v_VakID,
                                    v.Omschrijving as v_Omschrijving,
                                    v.Oppervlakte as v_Oppervlakte

                                FROM
                                    zaaiing as z,
                                    oogst as o,
                                    bedrijf as b,
                                    perceel as p,
                                    vak as v

                                WHERE
                                    z.ZaaiingID = o.Zaaiing_ZaaiingID AND
                                    z.Bedrijf_BedrijfID = b.BedrijfID AND
                                    z.Perceel_PerceelID = p.PerceelID AND
                                    z.Vak_VakID = v.VakID
                            ');*/


                            //$database->where('o.Zaaiing_ZaaiingID', 'z.ZaaiingID');
                            //$database->join('zaaiing z', 'o.Zaaiing_ZaaiingID = z.ZaaiingID', 'LEFT');
                            //$database->join('oogst o', 'o.Zaaiing_ZaaiingID = z.ZaaiingID', 'LEFT');
                            $database->join('bedrijf b', 'z.Bedrijf_BedrijfID = b.BedrijfID', 'LEFT');
                            $database->join('perceel p', 'z.Perceel_PerceelID = p.PerceelID', 'LEFT');
                            $database->join('vak v', 'z.Vak_VakID = v.VakID', 'LEFT');

                            $result = $database->get('zaaiing z', null,
                                'z.ZaaiingID,
                                z.Bedrijf_BedrijfID,
                                z.Perceel_PerceelID,
                                z.Mosselgroep_MosselgroepID,
                                z.Activiteit as z_Activiteit,
                                z.Datum as z_Datum,
                                z.BrutoMton as z_BrutoMton,
                                z.Kilogram as z_Kilogram,
                                z.KilogramPerM2,
                                z.Bustal as z_Bustal,
                                z.Monster as z_Monster,
                                z.MonsterLabel as z_MonsterLabel,
                                z.Opmerking as z_Opmerking,

                                b.Naam as b_Naam,
                                b.Afkorting as b_Afkorting,

                                p.Plaats as p_Plaats,
                                p.Nummer as p_Nummer,

                                v.VakID as v_VakID,
                                v.Omschrijving as v_Omschrijving,
                                v.Oppervlakte as v_Oppervlakte'
                            );

                            // Check if the result is success
                            if($result) {
                                $i = 0;

                                echo '<div class="table-responsive">';
                                    echo '<table class="table table-bordered table-striped table-hover">';

                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th colspan="5"></th>';
                                            echo '<th colspan="9">Gezaaid</th>';
                                            echo '<th colspan="11">Geoogst</th>';
                                        echo '</tr>';

                                        echo '<tr>';
                                            echo '<th>Zaaiing ID</th>';
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
                                                o.Activiteit as o_Activiteit,
                                                o.Datum as o_Datum,
                                                o.BrutoMton as o_BrutoMton,
                                                o.Kilogram as o_Kilogram,
                                                o.Rendement,
                                                o.Stukstal,
                                                o.Bustal as o_Bustal,
                                                o.Oppervlakte,
                                                o.Monster as o_Monster,
                                                o.MonsterLabel as o_MonsterLabel,
                                                o.Opmerking as o_Opmerking
                                            ');

                                        echo '<tr>';
                                            echo '<th>' . $row['ZaaiingID'] . '</th>';
                                            echo '<th>' . $row['b_Naam'] . '</th>';
                                            echo '<th>' . $row['p_Plaats'] . '</th>';
                                            echo '<th>' . $row['p_Nummer'] . '</th>';
                                            echo '<th>' . $row['v_Omschrijving'] . '</th>';

                                            echo '<th>' . $row['z_Datum'] . '</th>';
                                            echo '<th>' . $row['z_Activiteit'] . '</th>';
                                            echo '<th>' . $row['z_BrutoMton'] . '</th>';
                                            echo '<th>' . $row['z_Kilogram'] . '</th>';
                                            echo '<th>' . $row['KilogramPerM2'] . '</th>';
                                            echo '<th>' . $row['z_Bustal'] . '</th>';
                                            echo '<th>' . $row['z_Monster'] . '</th>';
                                            echo '<th>' . $row['z_MonsterLabel'] . '</th>';
                                            echo '<th>' . $row['z_Opmerking'] . '</th>';

                                            if(isset($result2[$i])) {
                                                echo '<th>' . $result2[$i]['o_Datum'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_Activiteit'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_BrutoMton'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_Kilogram'] . '</th>';
                                                echo '<th>' . $result2[$i]['Rendement'] . '</th>';
                                                echo '<th>' . $result2[$i]['Stukstal'] . '</th>';
                                                echo '<th>' . $result2[$i]['Oppervlakte'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_Bustal'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_Monster'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_MonsterLabel'] . '</th>';
                                                echo '<th>' . $result2[$i]['o_Opmerking'] . '</th>';
                                            }
                                            else {
                                                echo '<th colspan="11"></th>';
                                            }
                                        echo '</tr>';

                                        $i++;
                                    }

                                    echo '</table>';
                                echo '</div>';
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

    ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/invulformulieren.js"></script>

</body>
</html>