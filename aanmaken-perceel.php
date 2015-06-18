<?php
//includes
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
            <h1>Aanmaken perceel</h1>
            
            <?php
                //verwerken invoer
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
					$rules = array(
						'plaats' => array(
                                    'label' => 'Plaats',
                                    'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 45
                                ),
                        'nummer' => array(
									'label' => 'Nummer',
									'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 10							
								),
						'oppervlakte' => array(
									'label' => 'Oppervlakte',
									'type' => 'int',
									'minLength' => 1,
                                    'maxLength' => 10					
								)
					);
					//validatie invoer
					if(isValidArray($rules, $_POST)) {
						$arrayperceel = array();
						$arrayvak = array();
						
						$arrayperceel['Plaats'] = $_POST['plaats'];
						$arrayperceel['Nummer'] = $_POST['nummer'];
						
						$insert = $database->insert('perceel', $arrayperceel);
						
						$arrayvak['Omschrijving'] = "Geheel";
						$arrayvak['Oppervlakte'] = $_POST['oppervlakte'];
						$arrayvak['Perceel_PerceelID'] = $database->getInsertId();

						$insert = $database->insert('vak', $arrayvak);
						
						if($insert) {
							echo '<div class="alert alert-success text-center">Perceel toegevoegd</div>';
						}
						else {
							echo '<div class="alert alert-warning text-center">Het toevoegen van een nieuw perceel is niet gelukt.</div>';
						}
					}
					
            	}
            
            ?>
            <!--invulformulier-->
            <form role="form" method="post">
            	
                <div class="form-group">
                    <label for="plaats">Plaats:</label>
                    <input type="text" class="form-control" id="plaats" name="plaats">
                </div>
                
                <div class="form-group">
                    <label for="bedrijf">Nummer: </label>
                    <input type="text" class="form-control" id="nummer" name="nummer" >
                </div>
                
                <div class="form-group">
                    <label for="oppervlakte">Oppervlakte: </label>
                    <input type="int" class="form-control" id="oppervlakte" name="oppervlakte" >
                </div>
                
                 <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Verstuur" id="submit">
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