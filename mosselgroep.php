<?php

require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');
require_once('includes/functions.php');

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

include_once('includes/header.php');

?>

<section id="content">
    <div class="container">
        <?php
            if(isset($_GET['mosselID'])){
                $database-> where('ParentMosselgroepID',$_GET['mosselID']);
                $childIDs = $database-> get('mosselgroep');
                echo "<h2>Het mosselgroep ID = ".$_GET['mosselID']."</h2>";
                echo "<ul>";
                foreach ($childIDs as $childID) {
                    echo "<li>Child ID is: <a href='mosselgroep.php?mosselID=".$childID['MosselgroepID']."' >".$childID['MosselgroepID']."</a>.</li>";
                }
                echo "</ul>";
                $database-> where('MosselgroepID',$_GET['mosselID']);
                $parentIDs = $database-> get('mosselgroep');
                echo "<h2>Parent ID</h2>";
                echo "<ul>";
                foreach ($parentIDs as $parentID) {
                    echo "<li>Parent ID is: <a href='mosselgroep.php?mosselID=".$parentID['ParentMosselgroepID']."' >".$parentID['ParentMosselgroepID']."</a>.</li>";
                }
                echo "</ul>";

                $database-> where('Mosselgroep_mosselgroepID',$_GET['mosselID']);
                $results = $database-> get('zaaiing');
                echo "<h2>Zaaiing</h2>";
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped table-hover">';
                echo '<tr>';
                    echo '<th>Zaaiing ID</th>';
                    echo '<th>Bedrijf</th>';
                    echo '<th>Perceel</th>';
                    echo '<th>Vak</th>';
                    echo '<th>Datum</th>';
                    echo '<th>Activiteit</th>';
                    echo '<th>Bruto Mton</th>';
                    echo '<th>Kg</th>';
                    echo '<th>Kg/m<sup>2</sup></th>';
                    echo '<th>Bustal</th>';
                    echo '<th>Monster</th>';
                    echo '<th>Monster Opmerking</th>';
                    echo '<th>Opmerking</th>';
                echo '</tr>';
                foreach ($results as $result){
                    $database -> where('BedrijfID',$result['Bedrijf_BedrijfID']);
                    $bedrijf = $database-> getOne('bedrijf');
                    $database -> where('PerceelID',$result['Perceel_PerceelID']);
                    $perceel = $database-> getOne('perceel');
                    $database -> where('VakID',$result['Vak_VakID']);
                    $vak = $database-> getOne('vak');
                    $datum = date('d-m-Y', $result['Datum']);
                    echo '<tr>';
                        echo '<td>'.$result['ZaaiingID'].'</td>';
                        echo '<td>'.$bedrijf['Naam'].'</td>';
                        echo '<td>'.$perceel['Plaats'].$perceel['Nummer'].'</td>';
                        echo '<td>'.$vak['Omschrijving'].'</td>';
                        echo '<td>'.$datum.'</td>';
                        echo '<td>'.$result['Activiteit'].'</td>';
                        echo '<td>'.$result['BrutoMton'].'</td>';
                        echo '<td>'.$result['Kilogram'].'</td>';
                        echo '<td>'.$result['KilogramPerM2'].'</td>';
                        echo '<td>'.$result['Bustal'].'</td>';
                        echo '<td>'.$result['Monster'].'</td>';
                        echo '<td>'.$result['MonsterLabel'].'</td>';
                        echo '<td>'.$result['Opmerking'].'</td>';
                    echo '</tr>';
                }
                echo '</table></div>';

                $database-> where('Mosselgroep_mosselgroepID',$_GET['mosselID']);
                $results = $database-> get('oogst');
                echo "<h2>Oogst</h2>";
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped table-hover">';
                echo '<tr>';
                echo '<th>Oogst ID</th>';
                echo '<th>Zaaiing ID</th>';
                echo '<th>Datum</th>';
                echo '<th>Activiteit</th>';
                echo '<th>BrutoMton</th>';
                echo '<th>Kg</th>';
                echo '<th>Rendement</th>';
                echo '<th>Stukstal</th>';
                echo '<th>Bustal</th>';
                echo '<th>Oppervlakte<sup>2</sup></th>';
                echo '<th>Monster</th>';
                echo '<th>Monster Opmerking</th>';
                echo '<th>Opmerking</th>';
                echo '</tr>';
                foreach ($results as $result){
                    $datum = date('d-m-Y', $result['Datum']);
                    echo '<tr>';
                    echo '<td>'.$result['OogstID'].'</td>';
                    echo '<td>'.$result['Zaaiing_ZaaiingID'].'</td>';
                    echo '<td>'.$datum.'</td>';
                    echo '<td>'.$result['Activiteit'].'</td>';
                    echo '<td>'.$result['BrutoMton'].'</td>';
                    echo '<td>'.$result['Kilogram'].'</td>';
                    echo '<td>'.$result['Rendement'].'</td>';
                    echo '<td>'.$result['Stukstal'].'</td>';
                    echo '<td>'.$result['Bustal'].'</td>';
                    echo '<td>'.$result['Oppervlakte'].'</td>';
                    echo '<td>'.$result['Monster'].'</td>';
                    echo '<td>'.$result['MonsterLabel'].'</td>';
                    echo '<td>'.$result['Opmerking'].'</td>';
                    echo '</tr>';
                }
                echo '</table></div>';

                $database-> where('Mosselgroep_mosselgroepID',$_GET['mosselID']);
                $results = $database-> get('behandeling');
                echo "<h2>Behandeling</h2>";
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped table-hover">';
                echo '<tr>';
                echo '<th>Behandeling ID</th>';
                echo '<th>Zaaing ID</th>';
                echo '<th>Bedrijf</th>';
                echo '<th>Perceel</th>';
                echo '<th>Vak</th>';
                echo '<th>Datum</th>';
                echo '<th>Activiteit</th>';
                echo '<th>Monster</th>';
                echo '<th>Monster Opmerking</th>';
                echo '<th>Opmerking</th>';
                echo '</tr>';
                foreach ($results as $result){
                    $database -> where('BedrijfID',$result['Bedrijf_BedrijfID']);
                    $bedrijf = $database-> getOne('bedrijf');
                    $database -> where('PerceelID',$result['Perceel_PerceelID']);
                    $perceel = $database-> getOne('perceel');
                    $database -> where('VakID',$result['Vak_VakID']);
                    $vak = $database-> getOne('vak');
                    $datum = date('d-m-Y', $result['Datum']);
                    echo '<tr>';
                    echo '<td>'.$result['BehandelingID'].'</td>';
                    echo '<td>'.$result['Zaaiing_ZaaiingID'].'</td>';
                    echo '<td>'.$bedrijf['Naam'].'</td>';
                    echo '<td>'.$perceel['Plaats'].$perceel['Nummer'].'</td>';
                    echo '<td>'.$vak['Omschrijving'].'</td>';
                    echo '<td>'.$datum.'</td>';
                    echo '<td>'.$result['Activiteit'].'</td>';
                    echo '<td>'.$result['Monster'].'</td>';
                    echo '<td>'.$result['MonsterLabel'].'</td>';
                    echo '<td>'.$result['Opmerking'].'</td>';
                    echo '</tr>';
                }
                echo '</table></div>';



            }
            else {
                echo "Er is geen mosselID meegegeven.";
            }
        ?>
    </div>
</section>

<?php

include_once('includes/footer.php');
include_once('includes/scripts.php');

?>

<!-- Specific JS files here -->


</body>
</html>