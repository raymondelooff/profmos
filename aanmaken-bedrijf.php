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
            <h1>Toevoegen bedrijf</h1>
            
            <?php
            //verwerken invoer
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
					//validatie invoer
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
            <!--invoer formulier-->
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
        //footer en includes
		include_once('includes/footer.php');
		include_once('includes/scripts.php');

	?>

	<!-- Specific JS files here -->
	<script src="/js/invulformulieren.js"></script>

</body>
</html>