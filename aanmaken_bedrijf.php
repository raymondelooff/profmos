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

    <title>PROFMOS</title>
</head>

<body>

    <?php

    include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <h2>Toevoegen bedrijf</h2>
            
            <?php
            
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
					$rules = array(
						'naam' => array(
                                    'label' => 'Naam',
                                    'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 45
                                ),
                        'afkorting' => array(
									'label' => 'Afkorting',
									'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 10							
								)
					);
					
					if(isValidArray($rules, $_POST)) {
						$array = array();
						
						$array['Naam'] = $_POST['naam'];
						$array['Afkorting'] = $_POST['afkorting'];
						
						$insert = $database->insert('bedrijf', $array);
						
						if($insert) {
							echo '<div class="alert alert-success text-center">Bedrijf toegevoegd</div>';
						}
						else {
							echo '<div class="alert alert-warning text-center">Het toevoegen van een nieuw bedrijf is niet gelukt.</div>';
						}
					}
					
            	}
            
            ?>

            <form role="form" method="post">
            	
                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" class="form-control" id="naam" name="naam">
                </div>
                
                <div class="form-group">
                    <label for="afkorting">Afkorting: </label>
                    <input type="text" class="form-control" id="afkorting" name="afkorting" >
                </div>
                
                 <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Verstuur" id="submit">
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