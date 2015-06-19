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
            <h1>Aanmaken vak</h1>
            
            <?php
                //verwerken invoer
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
					$rules = array(
						'omschrijving' => array(
                                    'label' => 'Omschrijving',
                                    'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 45
                                ),
                        'oppervlakte' => array(
									'label' => 'Oppervlakte',
									'type' => 'float'						
								),
						'perceel_perceelID' => array(
									'label' => 'Perceel_PerceelID',
									'type' => 'int',
									'minLength' => 1,
                                    'maxLength' => 10
								)
					);
					//valideren invoer
		            $post = isValidArray($rules, $_POST);

					if($post !== FALSE) {
						$array = array();
						
						$array['Omschrijving'] = $post['omschrijving'];
						$array['Oppervlakte'] = $post['oppervlakte'];
						$array['Perceel_PerceelID'] = $post['perceel_perceelID'];
						
						$insert = $database->insert('vak', $array);
						
						if($insert) {
							echo '<div class="alert alert-success text-center">Vak toegevoegd</div>';
						}
						else {
							echo '<div class="alert alert-warning text-center">Het toevoegen van een nieuw vak is niet gelukt.</div>';
						}
					}
					
            	}
            
            ?>
            <!--invulfromulier-->
            <form role="form" method="post">
            	
                <div class="form-group">
                    <label for="omschrijving">Omschrijving:</label>
                    <input type="text" class="form-control" id="omschrijving" name="omschrijving">
                </div>
                
                <div class="form-group">
                    <label for="oppervlakte">Oppervlakte: </label>
                    <input type="float" class="form-control" id="oppervlakte" name="oppervlakte" >
                </div>
                
                <div class="form-group">
                    <label for="perceel_perceelID">Perceel: </label>
                    <select class="form-control" id="perceel_perceelID" name="perceel_perceelID" >
        				<?php 
							
							$percelen = $database->get('perceel');

				            echo '<option selected disabled></option>';
							foreach($percelen as $perceel) {
								echo '<option value="' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . $perceel['Nummer'] . '</option>';	
							}
							
						?>
						</select>
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