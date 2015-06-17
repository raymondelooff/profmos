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
            <h1>Aanmaken boot</h1>
            
            <?php
            
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
					
					if(isValidArray($rules, $_POST)) {
						$array = array();
						
						$array['Bedrijf_BedrijfID'] = $_POST['bedrijf_bedrijfID'];
						$array['Naam'] = $_POST['naam'];
						
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