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
            <h1>Aanmaken boot</h1>
            
            <?php
                //verwerken invoer
            	if($_SERVER['REQUEST_METHOD'] == 'POST') {
					$rules = array(
						'bedrijf_bedrijfID' => array(
									'label' => 'Bedrijf_BedrijfID',
									'type' => 'int',
									'minLength' => 1,
                                    'maxLength' => 10
								),
						'naam' => array(
                                    'label' => 'Naam',
                                    'type' => 'text',
									'minLength' => 1,
                                    'maxLength' => 45
                                )
					);
					//validatie invoer
		            $post = isValidArray($rules, $_POST);

					if($post !== FALSE) {
						$array = array();
						
						$array['Bedrijf_BedrijfID'] = $post['bedrijf_bedrijfID'];
						$array['Naam'] = $post['naam'];
						
						$insert = $database->insert('boot', $array);
						
						if($insert) {
							echo '<div class="alert alert-success text-center">Boot toegevoegd</div>';
						}
						else {
							echo '<div class="alert alert-warning text-center">Het toevoegen van een nieuwe boot is niet gelukt.</div>';
						}
					}
					
            	}
            
            ?>
            <!--invoerformulier-->
            <form role="form" method="post">
                
                <div class="form-group">
                    <label for="bedrijf_bedrijfID">Bedrijf: </label>
                    <select class="form-control" id="bedrijf_bedrijfID" name="bedrijf_bedrijfID" >
        				<?php 
							
							$bedrijven = $database->get('bedrijf');
							
							echo '<option selected disabled>Select one</option>';
							foreach($bedrijven as $bedrijf) {
								echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . '</option>';	
							}
							
						?>
						</select>
                </div>
                
                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" class="form-control" id="naam" name="naam">
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