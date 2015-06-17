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
						'datum' => array('label' => 'Datum', 'type' => 'date', 'format' => 'm/d/Y'), 
						'activiteit' => array('label' => 'Activiteit', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100),
						'bedrijf' => array('label' => 'Bedrijf', 'type' => 'text', 'minLength' => 1, 'maxLength' => 45), 
						'perceel' => array('label' => 'Perceel', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'vak' => array('label' => 'Vak', 'type' => 'text', 'minLength' => 1, 'maxLength' => 45), 
						'oppervlakte' => array('label' => 'Oppervlakte', 'type' => 'float'), 
						'monster' => array('label' => 'Monster', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'label' => array('label' => 'label', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'bedrijf_verzaaien' => array('label' => 'Perceel naam verzaaien', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'perceel_verzaaien' => array('label' => 'Perceel plaats verzaaien', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'vak_verzaaien' => array('label' => 'Vak', 'type' => 'text', 'minLength' => 1, 'maxLength' => 45), 
						'oppervlakte_verzaaien' => array('label' => 'Oppervlakte verzaaien', 'type' => 'float'), 
						'busstukstal' => array('label' => 'Busstukstal', 'type' => 'int'), 
						'mosselton' => array('label' => 'Mosselton', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'perceel_leeggevist' => array('label' => 'Perceel leeggevist', 'type' => 'text', 'minLength' => 1, 'maxLength' => 100), 
						'opmerkingen' => array('label' => 'opmerkingen', 'type' => 'text', 'minLength' => 1, 'maxLength' => 500));

					if (isValidArray($rules, $_POST)) {
						$array = array();

						// Array voor database vullen

						$insert = $database -> insert('TABEL', $array);

						if ($insert) {
							// bootstrap succes melding
						} else {
							// bootstrap foutmelding
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
						<select id="perceel_verzaaien" name="perceel_verzaaien" class="form-control" onchange="fillVakVerzaaid()">
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