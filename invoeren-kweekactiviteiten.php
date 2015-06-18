<?php

    // Includes
    require_once ('includes/MysqliDb.php');
    require_once ('includes/connectdb.php');
    require_once ('includes/functions.php');

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

			include_once ('includes/header.php');

		?>

		<section id="content">
			<div class="container">
				<h1>Registratie kweekactiviteiten</h1>

				<?php

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //defineren validatie regels
                    $rules = array(
                        'Bedrijf' => array('label' => 'Bedrijf', 'type' => 'int', 'minLength' => 1, 'maxLength' => 10),
                        'Perceel' => array('label' => 'Perceel', 'type' => 'int', 'minLength' => 1, 'maxLength' => 10),
                        'Vak' => array('label' => 'Vak', 'type' => 'int', 'minLength' => 1, 'maxLength' => 10),
                        'VerzaaienPerceel' => array('label' => 'Perceel (verzaaien)', 'type' => 'int', 'minLength' => 1, 'maxLength' => 100),
                        'VerzaaienVak' => array('label' => 'Vak (verzaaien)', 'type' => 'int', 'minLength' => 1, 'maxLength' => 45),
                        'VerzaaienOppervlakte' => array('label' => 'Oppervlakte (verzaaien)', 'type' => 'float'),
                        'Datum' => array('label' => 'Datum', 'type' => 'date', 'format' => 'd/m/Y'),
                        'Activiteit' => array('label' => 'Activiteit', 'type' => 'text', 'minLength' => 1, 'maxLength' => 200),
                        'Oppervlakte' => array('label' => 'Oppervlakte', 'type' => 'float'),
                        'Monster' => array('label' => 'Monster', 'type' => 'text', 'minLength' => 1, 'maxLength' => 1),
                        'MonsterLabel' => array('label' => 'label', 'type' => 'text', 'minLength' => 1, 'maxLength' => 200),
                        'Bustal' => array('label' => 'Bustal', 'type' => 'int', 'minLength' => 0, 'maxLength' => 10),
                        'Stukstal' => array('label' => 'Stukstal', 'type' => 'int', 'minLength' => 0, 'maxLength' => 10),
                        'Mosselton' => array('label' => 'Mosselton', 'type' => 'int', 'minLength' => 0, 'maxLength' => 10),
                        'PerceelLeeggevist' => array('label' => 'Perceel leeggevist', 'type' => 'text', 'minLength' => 0, 'maxLength' => 5),
                        'Opmerkingen' => array('label' => 'Opmerkingen', 'type' => 'text', 'minLength' => 0, 'maxLength' => 200)
                    );
                    //validatie
					if (isValidArray($rules, $_POST)) {
						$datum = strtotime($_POST['datum']);	
						
						$array = array();

						// Array voor database vullen

						$insert = $database -> insert('TABEL', $array);

						if ($insert) {
							echo '<div class="alert alert-success text-center">Data is succesvol toegevoegd</div>';
						} else {
							echo '<div class="alert alert-warning text-center">Het is niet gelukt om de data toe te voegen, probeer het later opnieuw</div>';
						}
					}

				}
                //invulformulier
				?>

				<form role="form" method="post">

					<div class="form-group">
						<label for="Datum">Datum:</label>
						<input type="text" class="form-control date" name="Datum">
					</div>

					<div class="form-group">
						<label for="Activiteit">Activiteit:</label>
						<select class="form-control" id="activiteit" name="activiteit" >
							<?php echo '<option selected disabled></option>'; ?>
							<option >Zaaien</option>
							<option >Bijzaaien</option>
							<option >Verzaaien</option>
							<option >Vissen voor veiling</option>
							<option >Leegvissen</option>
							<option >Trekje op perceel</option>
							<option >Sterren dweilen</option>
							<option >Sterren rapen</option>
							<option >Sterren</option>
							<option >Onder zoet water</option>
							<option >Onder warm water</option>
							<option >Peulen</option>
							<option >Groen</option>
							<option >Droog leggen</option>
							<option >Over spoelerij</option>
						</select>
					</div>

					<div class="form-group">
						<label for="Bedrijf">Bedrijf: </label>
						<select id="Bedrijf" name="Bedrijf" class="form-control">
							<?php
							$bedrijven = $database -> get('bedrijf');
							echo '<option selected disabled>Select one</option>';
							foreach ($bedrijven as $bedrijf) {
								echo '<option value="' . $bedrijf['BedrijfID'] . '">' . $bedrijf['Naam'] . ' - ' . $bedrijf['Afkorting'] . '</option>';
							}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="Perceel">Perceel: </label>
						<select id="Perceel" name="Perceel" class="form-control" onchange="fillVak()">
							<?php
							$percelen = $database -> get('perceel');
							echo '<option selected disabled>Select one</option>';
							foreach ($percelen as $perceel) {
								echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
							}
							?>
						</select>
					</div>
					
					<div class="form-group" id="Vak"></div>
					
					<div class="form-group">
						<label for="Oppervlakte">Oppervlakte: </label>
						<input type="float" class="form-control" id="Oppervlakte" name="Oppervlakte" >
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="Monster">Monster:</label>
						<select class="form-control" id="Monster" name="Monster" onchange="toggleMonster()">
							<option selected disabled>Select one</option>
							<option value="Ja">Ja</option>
							<option value="Nee">Nee</option>
						</select>
					</div>

					<div class="form-group" id="labelDiv">
						<label for="MonsterLabel">Label: </label>
						<input type="text" class="form-control" id="MonsterLabel" name="MonsterLabel">
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="label">Verzaaien </label>
					</div>
					
					<div class="form-group">
						<label for="VerzaaienPerceel">Perceel: </label>
						<select id="VerzaaienPerceel" name="VerzaaienPerceel" class="form-control" onchange="fillVakVerzaaien()">
							<?php
							$percelen = $database -> get('perceel');
							echo '<option selected disabled>Select one</option>';
							foreach ($percelen as $perceel) {
								echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
							}
							?>
						</select>
					</div>
					
					<div class="form-group" id="VerzaaienVak"></div>

					<div class="form-group">
						<label for="VerzaaienOppervlakte">Oppervlakte: </label>
						<input type="float" class="form-control" id="VerzaaienOppervlakte" name="VerzaaienOppervlakte" >
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="label">Indien van toepassing </label>
					</div>

					<div class="form-group">
						<label for="Busstukstal">Busstukstal: </label>
						<input type="int" class="form-control" id="Busstukstal" name="Busstukstal" >
					</div>

					<div class="form-group">
						<label for="Mosselton">Mosselton: </label>
						<input type="text" class="form-control" id="Mosselton" name="Mosselton" >
					</div>

					<div class="form-group">
						<label for="PerceelLeeggevist">Perceel leeggevist?</label>
						<select class="form-control" id="PerceelLeeggevist" name="PerceelLeeggevist" >
							<?php echo '<option selected disabled>Select one</option>'; ?>
							<option >Ja</option>
							<option >Nee</option>
						</select>
					</div>

					<div class="form-group">
						<label for="Opmerkingen">Opmerkingen:</label>
						<textarea class="form-control" rows="5" id="Opmerkingen" name="Opmerkingen" ></textarea>
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