<?php

require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');

?>

<label for="vak">Vak: </label>
<select id="vak" name="vak" class="form-control">
    <?php
        if(isset($_GET['perceelID'])) {
            $database->where('Perceel_PerceelID', $_GET['perceelID']);
            $vakken = $database->get('vak');

            foreach ($vakken as $vak) {
<<<<<<< HEAD
                echo '<option value="' . $vak['VakID'] . '">' . $vak['Omschrijving'] . '</option>';
=======
                echo '<option value ='.$vak['VakID'].'>' . $vak['Omschrijving'] . '</option>';
>>>>>>> d937f4dea1cfed16d98e88a35377eff518c48256
            }
        }
    ?>

</select>