<?php

require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');

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

    <title>PROFMOS monitoring</title>
</head>

<body>

    <?php

    include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <h2>Monitoring</h2>
            
            <?php
            
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
            		
					$rules = array(
						'datum' => array(
                            'label' => 'Datum',
                            'type' => 'date',
                            'format' => 'm/d/Y'
                        ),
                        'compartiment' => array(
                            'label' => 'Compartiment',
                            'type' => 'numeric',
                        ),
                        'locatie' => array(
                            'label' => 'Locatie',
                            'type' => 'text',
                        ),
                        'type' => array(
                            'label' => 'Type',
                            'type' => 'text',
                        ),
                        'lengte' => array(
                            'label' => 'Lengte',
                            'type' => 'numeric',
                        ),
                        'natgewicht' => array(
                            'label' => 'Natgewicht',
                            'type' => 'numeric',
                        ),
                        'visgewicht' => array(
                            'label' => 'Visgewicht',
                            'type' => 'numeric',
                        ),
                        'AFDW' => array(
                            'label' => 'AFDW',
                            'type' => 'numeric',
                        ),
                        'DryWeightSchelp' => array(
                            'label' => 'DryWeightSchelp',
                            'type' => 'numeric',
                        )
					);
					
					if(isValidArray($rules, $_POST)) {
						$array = array(
                            'Datum' => $_POST['datum'],
                            'Compartiment' => $_POST['compartiment'],
                            'Type' => $_POST['type'],
                            'Lengte' => $_POST['type'],
                            'Natgewicht' => $_POST['natgewicht'],
                            'Visgewicht' => $_POST['visgewicht'],
                            'AFDW' => $_POST['AFDW'],
                            'DW_Schelp' => $_POST['DryWeightSchelp']
                        );
						
						$insert = $database->insert('TABEL', $array);
						
						if($insert) {
							echo 'victory';
						}
						else {
							echo 'gefaald';
						}
					}
					
            	}
            
            ?>

            <form name="input" method="post">
                <div class="form-group">
                    <label for="datum">Datum</label>
                    <input class="form-control date" type="text" id="datum" name="datum" maxlength="50" size="20">
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
                    <label for="locatie">Locatie</label>
                    <input class="form-control" type="text" id="locatie" name="locatie" maxlength="80" size="20">
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
                    <input class="form-control" type="text" id="lengte" name="lengte" maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="natgewicht">Natgewicht</label>
                    <input class="form-control" type="text" id="natgewicht" name="natgewicht" maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="visgewicht">Visgewicht</label>
                    <input class="form-control" type="text" id="visgewicht" name="visgewicht" maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="AFDW">AFDW</label>
                    <input class="form-control" type="text" id="AFDW" name="AFDW" maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <label for="DryWeightSchelp">Dry Weight schelp</label>
                    <input class="form-control" type="text" id="DryWeightSchelp" name="DryWeightSchelp" maxlength="80" size="20">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Verstuur">
                </div>
            </form>
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