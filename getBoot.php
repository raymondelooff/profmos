<?php
//includes
require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');

?>

<label for="boot">Boot: </label>
<select id="boot" name="boot" class="form-control">
    <?php
    if(isset($_GET['bedrijfID'])) {
        $database->where('Bedrijf_BedrijfID', $_GET['bedrijfID']);
        $boten = $database->get('boot');

        foreach ($boten as $boot) {
            echo '<option value="' . $boot['BootID'].'">' . $boot['Naam'] . '</option>';
        }
    }
    ?>

</select>