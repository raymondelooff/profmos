<?php

    // Includes
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
                //defineren regels validatie
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
                // Validatie
                $post = isValidArray($rules, $_POST);

                if($post !== FALSE) {
                    // Ontbrekende gegevens berekenen
                    $datum = strtotime($post['date']);
                    $tarra = 1 - ($post['nettomonster']/$post['brutomonster']);
                    $gewichtMossel = ($post['busnetto']/$post['bustal']);
                    $stuktal = (2500/$gewichtMossel);
                    $afdwpm = ($post['asvrijdrooggewicht']/$post['kookmonsteraantal']);

                    $database->where('mosselgroep_MosselgroepID', $post['mosselgroep']);
                    $database->orderby('Datum','DESC');
                    $mosselgroep = $database->getOne('monster');

	                print_r($mosselgroep);

                    if(empty($mosselgroep)) {
                        $grgewicht = null;
                        $grlengte = null;
                        $grafdw = null;
                    }
                    else {
                        $time = ($datum - $mosselgroep['Datum']) / 86400;

	                    // Als het verschil in dagen 0 is, zet verschil op 1
	                    $time = ($time == 0 ? $time = 1 : null);

                        $grgewicht = ($gewichtMossel - $mosselgroep['GewichtMossel']) / $time;
                        $grlengte = ($post['gemiddeldelengte'] - $mosselgroep['GemiddeldeLengte'] ) / $time;
                        $grafdw = ($afdwpm - $mosselgroep['AFDWpM']) / $time;
                    }

                    // Opstellen array voor database
                    $array = array(
                        'Bedrijf_BedrijfID' => $post['bedrijf'],
                        'Boot_BootID' => $post['boot'],
                        'Perceel_PerceelID' => $post['perceel'],
                        'Vak_VakID' => $post['vak'],
                        'mosselgroep_MosselgroepID' => $post['mosselgroep'],
                        'Datum' => $datum,
                        'BrutoMonster' => $post['brutomonster'],
                        'NettoMonster' => $post['nettomonster'],
                        'Tarra' => $tarra,
                        'Busstal' => $post['bustal'],
                        'GewichtMossel' => $gewichtMossel,
                        'Slippers' => $post['slippers'],
                        'Zeester' => $post['zeester'],
                        'Pokken' => $post['pokken'],
                        'BusNetto' => $post['busnetto'],
                        'AantalKookmonsters' => $post['kookmonsteraantal'],
                        'NettoKookmonster' => $post['nettokookmonster'],
                        'VisTotalemonster' => $post['vistotalemonster'],
                        'VisPercentage' => $post['vispercentage'],
                        'Stukstal' => $stuktal,
                        'Kroesnr' => $post['kroesnummer'],
                        'Kroes' => $post['kroes'],
                        'KroesEnVlees' => $post['kroesvleesnat'],
                        'DW' => $post['drooggewicht'],
                        'AFDW' => $post['asvrijdrooggewicht'],
                        'AFDWpM' => $afdwpm,
                        'SchelpenDroog' => $post['schelpendroog'],
                        'GemiddeldeLengte' => $post['gemiddeldelengte'],
                        'GrGewicht' => $grgewicht,
                        'GrLengte' => $grlengte,
                        'GrAFDW' => $grafdw,
                        'Opmerking' => $post['opmerkingen'],
                    );

                    // Insert in database en controle.
                    $insert = $database->insert('monster', $array);

                    if($insert) {
                        echo '<div class="alert alert-success text-center">Monster data toegevoegd</div>';
                    }
                    else {
	                    $database->getLastError();
                        echo '<div class="alert alert-warning text-center">Het is niet gelukt de monster data toe te voegen, probeer het later opnieuw</div>';
                    }
                }
            }

            // Invulformulier
            ?>

            <form role="form" method="post">
				<div class="row">
					<div class="col col-md-6">
						<div class="form-group">
							<label for="date">Datum</label>
							<input type="text" class="form-control date" id="date" name="date" <?php getTextFieldValue('date'); ?>>
						</div>

						<div class="form-group">
							<label for="mosselgroep">Mosselgroep</label>
                            <select id="mosselgroep" name="mosselgroep" class="form-control" >
                                <?php
                                $mosselgroepen = $database->get('mosselgroep');
                                echo '<option selected disabled></option>';
                                foreach($mosselgroepen as $mosselgroep) {
                                    echo '<option value=" ' . $mosselgroep['MosselgroepID'] . '">' . $mosselgroep['MosselgroepID'] . '</option>';
                                }
                                ?>
                            </select>
						</div>

						<div class="form-group">
							<label for="bedrijf">Bedrijf</label>
							<select id="bedrijf" name="bedrijf" class="form-control" onchange="fillBoot()">
								<?php
								$bedrijven = $database->get('bedrijf');
								echo '<option selected disabled></option>';
								foreach($bedrijven as $bedrijf) {
									echo '<option value=" ' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . '</option>';
								}
								?>
							</select>
						</div>

						<div class="form-group" id="boot"></div>

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
					</div>

					<div class="col col-md-6">
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
							<label for="kroesvleesnat">Kroes + vlees nat</label>
							<input class="form-control" type="text" id="kroesvleesnat" name="kroesvleesnat" <?php getTextFieldValue('kroesvleesnat'); ?> maxlength="80" size="20">
						</div>

						<div class="form-group">
							<label for="drooggewicht">Droog gewicht (g)</label>
							<input class="form-control" type="text" id="drooggewicht" name="drooggewicht" <?php getTextFieldValue('drooggewicht'); ?> maxlength="80" size="20">
						</div>

						<div class="form-group">
							<label for="asvrijdrooggewicht">Asvrij droog gewicht (g)</label>
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
					</div>
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