<?php

    // Includes
    require_once('../includes/MysqliDb.php');
    require_once('../includes/connectdb.php');
    require_once('../includes/functions.php');

?>

<label for="verzaaienVak">Vak: </label>

<?php

    if(isset($_GET['perceelID'])) {
        $rules = array(
            'perceelID' => array(
                'label' => 'Perceel ID',
                'type' => 'int',
                'minLength' => 1,
                'maxLength' => 11
            )
        );

        $get = isValidArray($rules, $_GET);

        if($get !== FALSE) {
            $database->where('Perceel_PerceelID', $get['perceelID']);
            $vakken = $database->get('vak');

            echo '<select id="verzaaienVak" name="VerzaaienVak" class="form-control">';
                echo '<option selected disabled></option>';

                if ($database->count) {
                    foreach ($vakken as $vak) {
                        echo '<option value="' . $vak['VakID'] . '">' . $vak['Omschrijving'] . '</option>';
                    }
                }
                else {
                    echo '<option selected disabled> - Geen vakken gevonden -</option>';
                }
            echo '</select>';
        }
    }

?>