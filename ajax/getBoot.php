<?php

    // Includes
    require_once('../includes/MysqliDb.php');
    require_once('../includes/connectdb.php');
    require_once('../includes/functions.php');

?>

<label for="boot">Boot: </label>

<?php

    if(isset($_GET['bedrijfID'])) {
        $rules = array(
            'bedrijfID' => array(
                'label' => 'Bedrijf ID',
                'type' => 'int',
                'minLength' => 1,
                'maxLength' => 11
            )
        );

        $get = isValidArray($rules, $_GET);

        if($get !== FALSE) {
            $database->where('Bedrijf_BedrijfID', $get['bedrijfID']);
            $boten = $database->get('boot');

            echo '<select id="boot" name="boot" class="form-control">';
                echo '<option selected disabled></option>';

                if ($database->count > 0) {
                    foreach ($boten as $boot) {
                        echo '<option value="' . $boot['BootID'] . '">' . $boot['Naam'] . '</option>';
                    }
                }
                else {
                    echo '<option selected disabled>- Geen boot gevonden -</option>';
                }
            echo '</select>';
        }
    }

?>