<?php

    // Includes
    require_once('../includes/MysqliDb.php');
    require_once('../includes/connectdb.php');

?>

<label for="VerzaaienVak">Vak: </label>
<select id="VerzaaienVak" name="VerzaaienVak" class="form-control">
    <?php
        if(isset($_GET['perceelID'])) {
            $database->where('Perceel_PerceelID', $_GET['perceelID']);
            $vakken = $database->get('vak');
			
			echo '<option selected disabled>Select one</option>';
			
            foreach ($vakken as $vak) {
                echo '<option value="' . $vak['VakID'] . '">' . $vak['Omschrijving'] . '</option>';
                echo '<option value ='.$vak['VakID'].'>' . $vak['Omschrijving'] . '</option>';
            }
        }
    ?>

</select>