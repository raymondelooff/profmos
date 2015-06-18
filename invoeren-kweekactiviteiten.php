<?php

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
                        'Opmerking' => array('label' => 'Opmerking', 'type' => 'text', 'minLength' => 0, 'maxLength' => 200)
                    );

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
				?>

				<form role="form" method="post">

					<div class="form-group">
						<label for="datum">Datum:</label>
						<input type="text" class="form-control date" name="datum">
					</div>

					<div class="form-group">
						<label for="activiteit">Activiteit:</label>
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
						<label for="bedrijf">Bedrijf: </label>
						<select id="bedrijf" name="bedrijf" class="form-control">
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
						<label for="perceel">Perceel: </label>
						<select id="perceel" name="perceel" class="form-control" onchange="fillVak()">
							<?php
							$percelen = $database -> get('perceel');
							echo '<option selected disabled>Select one</option>';
							foreach ($percelen as $perceel) {
								echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
							}
							?>
						</select>
					</div>
					
					<div class="form-group" id="vak"></div>
					
					<div class="form-group">
						<label for="oppervlakte">Oppervlakte: </label>
						<input type="float" class="form-control" id="oppervlakte" name="oppervlakte" >
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="monster">Monster:</label>
						<select class="form-control" id="monster" name="monster" >
							<option >Ja</option>
							<option >Nee</option>
						</select>
					</div>

					<div class="form-group">
						<label for="label">Label: </label>
						<input type="text" class="form-control" id="label" name="label" >
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="label">Verzaaien </label>
					</div>

					<div class="form-group">
						<label for="bedrijf_verzaaien">Bedrijf: </label>
						<select id="bedrijf_verzaaien" name="bedrijf_verzaaien" class="form-control">
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
						<label for="perceel_verzaaien">Perceel: </label>
						<select id="perceel_verzaaien" name="perceel_verzaaien" class="form-control" onchange="fillVakVerzaaien()">
							<?php
							$percelen = $database -> get('perceel');
							echo '<option selected disabled>Select one</option>';
							foreach ($percelen as $perceel) {
								echo '<option value=" ' . $perceel['PerceelID'] . '">' . $perceel['Plaats'] . ' - ' . $perceel['Nummer'] . '</option>';
							}
							?>
						</select>
					</div>
					
					<div class="form-group" id="vak_verzaaien"></div>

					<div class="form-group">
						<label for="oppervlakte_verzaaien">Oppervlakte: </label>
						<input type="float" class="form-control" id="oppervlakte_verzaaien" name="oppervlakte_verzaaien" >
					</div>

					<br>
					<br>

					<div class="form-group">
						<label for="label">Indien van toepassing </label>
					</div>

					<div class="form-group">
						<label for="busstukstal">Busstukstal: </label>
						<input type="int" class="form-control" id="busstukstal" name="busstukstal" >
					</div>

					<div class="form-group">
						<label for="mosselton">Mosselton: </label>
						<input type="text" class="form-control" id="mosselton" name="mosselton" >
					</div>

					<div class="form-group">
						<label for="perceel_leeggevist">Perceel leeggevist?</label>
						<select class="form-control" id="perceel_leeggevist" name="perceel_leeggevist" >
							<?php echo '<option selected disabled>Select one</option>'; ?>
							<option >Ja</option>
							<option >Nee</option>
						</select>
					</div>

					<div class="form-group">
						<label for="opmerkingen">Opmerkingen:</label>
						<textarea class="form-control" rows="5" id="opmerkingen" name="opmerkingen" ></textarea>
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