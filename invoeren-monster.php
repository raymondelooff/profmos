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
            <h1>Monster data</h1>

            <?php

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $rules = array(
                    'date' => array(
                        'label' => 'Datum',
                        'type' => 'date',
                        'format' => 'd-m-Y'
                    ),
                    'mosselgroep' => array(
                        'label' => 'Mosselgroep',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'bedrijf' => array(
                        'label' => 'Bedrijf',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'boot' => array(
                        'label' => 'Boot',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'perceel' => array(
                        'label' => 'Perceel',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'vak' => array(
                        'label' => 'Vak',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'brutomonster' => array(
                        'label' => 'Brutomonster',
                        'type' => 'float'
                    ),
                    'nettomonster' => array(
                        'label' => 'Nettomonster',
                        'type' => 'float'
                    ),
                    'bustal' => array(
                        'label' => 'Bustal',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'slippers' => array(
                        'label' => 'Slippers',
                        'type' => 'float'
                    ),
                     'zeester' => array(
                        'label' => 'zeester',
                        'type' => 'float'
                    ),
                    'pokken' => array(
                        'label' => 'Pokken',
                        'type' => 'float'
                    ),
                    'busnetto' => array(
                        'label' => 'Busnetto',
                        'type' => 'float'
                    ),
                    'kookmonsteraantal' => array(
                        'label' => 'KookMonsterAantal',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'nettokookmonster' => array(
                        'label' => 'nettomonsteraantal',
                        'type' => 'float'
                    ),
                    'vistotalemonster' => array(
                        'label' => 'vistotalemonster',
                        'type' => 'float'
                    ),
                    'vispercentage' => array(
                        'label' => 'Vispercentage',
                        'type' => 'float'
                    ),
                    'opmerkingen' => array(
                        'label' => 'Opmerkingen',
                        'type' => 'text',
                        'minLength' => 0,
                        'maxLength' => 200
                    ),
                    'kroesnummer' => array(
                        'label' => 'Kroesnummer',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),
                    'kroes' => array(
                        'label' => 'Kroes',
                        'type' => 'float'
                    ),
                    'kroesvleesnat' => array(
                        'label' => 'Kroesvleesnat',
                        'type' => 'float'
                    ),
                    'drooggewicht' => array(
                        'label' => 'Drooggewicht',
                        'type' => 'float'
                    ),
                    'asvrijdrooggewicht' => array(
                        'label' => 'Asvrijdrooggewicht',
                        'type' => 'float'
                    ),
                    'schelpendroog' => array(
                        'label' => 'Schelpendroog',
                        'type' => 'float'
                    ),
                    'gemiddeldelengte' => array(
                        'label' => 'Gemiddeldelengte',
                        'type' => 'float'
                    )
                );

                if(isValidArray($rules, $_POST)) {
                    $tarra = 1 - ($_POST['nettomonster']/$_POST['brutomonster']);
                    $gewichtMossel = ($_POST['busnetto']/$_POST['bustal']);
                    $stuktal = (2500/$gewichtMossel);
                    $afdwpm = ($_POST['asvrijdrooggewicht']/$_POST['kookmonsteraantal']);

                    $array = array(
                        'Bedrijf_BedrijfID' => $_POST['bedrijf'],
                        'Boot_BootID' => $_POST['boot'],
                        'Perceel_PerceelID' => $_POST['perceel'],
                        'Vak_VakID' => $_POST['vak'],
                        'mosselgroep_MosselgroepID' => $_POST['mosselgroep'],
                        'Datum' => $_POST['date'],
                        'BrutoMonster' => $_POST['brutomonster'],
                        'NettoMonster' => $_POST['nettomonster'],
                        'Tarra' => $tarra,
                        'Busstal' => $_POST['bustal'],
                        'GewichtMossel' => $gewichtMossel,
                        'Slippers' => $_POST['slippers'],
                        'Zeester' => $_POST['zeester'],
                        'Pokken' => $_POST['pokken'],
                        'BusNetto' => $_POST['busnetto'],
                        'AantalKookmonsters' => $_POST['kookmonsteraantal'],
                        'NettoKookmonster' => $_POST['nettokookmonster'],
                        'VisTotalemonster' => $_POST['vistotalemonster'],
                        'VisPercentage' => $_POST['vispercentage'],
                        'Stukstal' => $stuktal,
                        'Kroesnr' => $_POST['kroesnummer'],
                        'Kroes' => $_POST['kroes'],
                        'KroesEnVlees' => $_POST['kroesvleesnat'],
                        'DW' => $_POST['drooggewicht'],
                        'AFDW' => $_POST['asvrijdrooggewicht'],
                        'AFDWpM' => $afdwpm,
                        'SchelpenDroog' => $_POST['schelpendroog'],
                        'GemiddeldeLengte' => $_POST['gemiddeldelengte'],
                        'GrGewicht' => 0,
                        'GrLengte' => 0,
                        'GrAFDW' => 0,
                        'Opmerking' => $_POST['opmerkingen'],
                    );

                    $insert = $database->insert('monster', $array);

                    if($insert) {
                        echo '<div class="alert alert-success text-center">Monster data toegevoegd</div>';
                    }
                    else {
                        echo '<div class="alert alert-warning text-center">Het is niet gelukt de monster data toe te voegen, probeer het later opnieuw</div>';
                    }
                }
            }
            ?>

            <form role="form" method="post">
                <div class="form-group">
                    <label for="datum">Datum</label>
                    <input type="text" class="form-control date" name="date" <?php getTextFieldValue('date'); ?>>
                </div>
                <div class="form-group">
                    <label for="mosselgroep">Mosselgroep</label>
                    <input class="form-control" type="text" id="mosselgroep" name="mosselgroep" <?php getTextFieldValue('mosselgroep'); ?>maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="bedrijf">Bedrijf</label>
                    <select id="bedrijf" name="bedrijf" class="form-control" onchange="fillBoot()">
                        <?php
                        $bedrijven = $database->get('bedrijf');
                        echo '<option selected disabled>Select one</option>';
                        foreach($bedrijven as $bedrijf) {
                            echo '<option value=" ' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="boot">
                </div>
                <div class="form-group">
                    <label for="perceel">Perceel: </label>
                    <select id="perceel" name="perceel" class="form-control" onchange="fillVak()">
                        <?php
                        $percelen = $database->get('perceel');
                        echo '<option selected disabled>Select one</option>';
                        foreach($percelen as $perceel) {
                            echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="vak">
                </div>
                <div class="form-group">
                    <label for="brutomonster">Bruto monster (g)</label>
                    <input class="form-control" type="text" id="brutomonster" name="brutomonster" <?php getTextFieldValue('brutomonster'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="nettomonster">Netto monster (g)</label>
                    <input class="form-control" type="text" id="nettomonster" name="nettomonster" <?php getTextFieldValue('nettomonster'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="bustal">Bustal</label>
                    <input class="form-control" type="text" id="bustal" name="bustal" <?php getTextFieldValue('bustal'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="slippers">Slippers (g)</label>
                    <input class="form-control" type="text" id="slippers" name="slippers" <?php getTextFieldValue('slippers'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="zeester">Zeester (g)</label>
                    <input class="form-control" type="text" id="zeester" name="zeester" <?php getTextFieldValue('zeester'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="pokken">Pokken</label>
                    <input class="form-control" type="text" id="pokken" name="pokken" <?php getTextFieldValue('pokken'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="busnetto">Bus netto</label>
                    <input class="form-control" type="text" id="busnetto" name="busnetto" <?php getTextFieldValue('busnetto'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="kookmonsteraantal">Kookmonster aantal</label>
                    <input class="form-control" type="text" id="kookmonsteraantal" name="kookmonsteraantal" <?php getTextFieldValue('kookmonsteraantal'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="nettokookmonster">Netto kookmonster (g)</label>
                    <input class="form-control" type="text" id="nettokookmonster" name="nettokookmonster" <?php getTextFieldValue('nettokookmonster'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="vistotalemonster">Vis totale monster</label>
                    <input class="form-control" type="text" id="vistotalemonster" name="vistotalemonster" <?php getTextFieldValue('vistotalemonster'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="vispercentage">Vis (%)</label>
                    <input class="form-control" type="text" id="vispercentage" name="vispercentage" <?php getTextFieldValue('vispercentage'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="opmerkingen">Opmerkingen</label>
                    <input class="form-control" type="text" id="opmerkingen" name="opmerkingen" <?php getTextFieldValue('opmerkingen'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="kroesnummer">Kroesnummer</label>
                    <input class="form-control" type="text" id="kroesnummer" name="kroesnummer" <?php getTextFieldValue('kroesnummer'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="kroes">Kroes (g)</label>
                    <input class="form-control"  type="text" id="kroes" name="kroes" <?php getTextFieldValue('kroes'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="kroesvleesnat">Kroes+vlees nat</label>
                    <input class="form-control" type="text" id="kroesvleesnat" name="kroesvleesnat" <?php getTextFieldValue('kroesvleesnat'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="drooggewicht">Droog gewicht (g)</label>
                    <input class="form-control" type="text" id="drooggewicht" name="drooggewicht" <?php getTextFieldValue('drooggewicht'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="asvrijdroogewicht">Asvrij droog gewicht (g)</label>
                    <input class="form-control" type="text" id="asvrijdrooggewicht" name="asvrijdrooggewicht" <?php getTextFieldValue('asvrijdrooggewicht'); ?> maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="schelpendroog">Schelpen droog (g)</label>
                    <input class="form-control" type="text" id="schelpendroog" name="schelpendroog" <?php getTextFieldValue('schelpendroog'); ?> maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="gemiddeldelengte">Gemiddelde lengte</label>
                    <input class="form-control" type="text" id="gemiddeldelengte" name="gemiddeldelengte" <?php getTextFieldValue('gemiddeldelengte'); ?> maxlength="80" size="20">
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