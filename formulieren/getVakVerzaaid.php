<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');

?>

<label for="verzaaienVak">Vak: </label>
<select id="verzaaienVak" name="verzaaienVak" class="form-control">
    <?php
        if(isset($_GET['perceelID'])) {
            $database->where('Perceel_PerceelID', $_GET['perceelID']);
            $vakken = $database->get('vak');

            foreach ($vakken as $vak) {
                echo '<option value="' . $vak['VakID'] . '">' . $vak['Omschrijving'] . '</option>';
            }
        }
    ?>

</select>