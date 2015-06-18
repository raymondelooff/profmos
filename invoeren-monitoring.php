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

    <title>PROFMOS monitoring</title>
</head>

<body>

    <?php

    	include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <h1>Monitoring</h1>
            
            <?php
            
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
            		
					$rules = array(
						'datum' => array(
                            'label' => 'Datum',
                            'type' => 'date',
                            'format' => 'd-m-Y'
                        ),
                        'compartiment' => array(
                            'label' => 'Compartiment',
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
                        'type' => array(
                            'label' => 'Type',
                            'type' => 'text',
                            'minLength' => 1,
                            'maxLength' => 45
                        ),
                        'lengte' => array(
                            'label' => 'Lengte',
                            'type' => 'float',
                        ),
                        'natgewicht' => array(
                            'label' => 'Natgewicht',
                            'type' => 'float',
                        ),
                        'visgewicht' => array(
                            'label' => 'Visgewicht',
                            'type' => 'float',
                        ),
                        'AFDW' => array(
                            'label' => 'AFDW',
                            'type' => 'float',
                        ),
                        'DryWeightSchelp' => array(
                            'label' => 'DryWeightSchelp',
                            'type' => 'float',
                        )
					);

                    $post = isValidArray($rules, $_POST);

                    if($post !== FALSE) {
                        $datum = strtotime($post['datum']);

						$array = array(
                            'Datum' => $datum,
                            'Vak_VakID' => $post['vak'],
                            'Perceel_PerceelID' => $post['perceel'],
                            'Compartiment' => $post['compartiment'],
                            'Type' => $post['type'],
                            'Lengte' => $post['lengte'],
                            'Natgewicht' => $post['natgewicht'],
                            'Visgewicht' => $post['visgewicht'],
                            'AFDW' => $post['AFDW'],
                            'DW_Schelp' => $post['DryWeightSchelp']
                        );
						
						$insert = $database->insert('meting', $array);

                        if($insert) {
                            echo '<div class="alert alert-success text-center">Monitoring data toegevoegd</div>';
                        }
                        else {
                            echo '<div class="alert alert-warning text-center">Het is niet gelukt de monitoring data toe te voegen, probeer het later opnieuw</div>';
                        }
					}
					
            	}
            
            ?>

            <form name="input" method="post">
                <div class="form-group">
                    <label for="datum">Datum</label>
                    <input class="form-control date" type="text" id="datum" name="datum" <?php getTextFieldValue('datum'); ?> maxlength="50" size="20">
                </div>
                <div class="form-group">
                    <label for="compartiment">Compartiment</label>
                    <select class="form-control" name="compartiment" id="compartiment">
                        <option value="">Select one</option>
                        <?php
                        for($i = 1; $i <13; $i++){
                            echo "<option value='".$i."''>".$i."</option>";
                        }
                        ?>
                    </select>
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
                    <label for="type">Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="">Select one</option>
                        <option value="Halfwas">Halfwas</option>
                        <option value="consumptieFormaat">consumptie formaat</option>
                        <option value="zaad">zaad</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lengte">Lengte</label>
                    <input class="form-control" type="text" id="lengte" name="lengte" <?php getTextFieldValue('lengte'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="natgewicht">Natgewicht</label>
                    <input class="form-control" type="text" id="natgewicht" name="natgewicht" <?php getTextFieldValue('natgewicht'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="visgewicht">Visgewicht</label>
                    <input class="form-control" type="text" id="visgewicht" name="visgewicht" <?php getTextFieldValue('visgewicht'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="AFDW">AFDW</label>
                    <input class="form-control" type="text" id="AFDW" name="AFDW" <?php getTextFieldValue('AFDW'); ?> maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="DryWeightSchelp">Dry Weight schelp</label>
                    <input class="form-control" type="text" id="DryWeightSchelp" name="DryWeightSchelp" <?php getTextFieldValue('DryWeightSchelp'); ?> maxlength="80" size="20">
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