<?php

    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<?php

		include_once('includes/head.php');

	?>

    <title>PROFMOS - Boer overzicht</title>
</head>

<body>

    <?php

        include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <h1>Overzicht</h1>
            <p>Hier ziet u een overzicht van de gegevens van uw bedrijf.</p>

            <h2>Zaaiingen</h2>
            <?php

                $bedrijf_id = 1; // Moet gekoppeld worden aan sessie

                $database->where('Bedrijf_BedrijfID', $bedrijf_id);
                $result = $database->get('zaaiing');

                if($result) {
                    echo '<table class="table">';
                        echo '<thead>';
                            echo '<th>ID</th>';
                            echo '<th>Vak</th>';
                            echo '<th>Perceel</th>';
                            echo '<th>Mosselgroep</th>';
                            echo '<th>Datum</th>';
                            echo '<th>Gegevens</th>';
                            echo '<th>Oogst</th>';
                        echo '</thead>';

                        foreach($result as $row) {
                            echo '<tr>';
                                echo '<td>' . $row['ZaaiingID'] . '</td>';
                                echo '<td>' . $row['Vak_VakID'] . '</td>';
                                echo '<td>' . $row['Perceel_PerceelID'] . '</td>';
                                echo '<td>' . $row['Mosselgroep_MosselgroepID'] . '</td>';
                                echo '<td>' . date('d-m-Y', $row['Datum']) . '</td>';
                                echo '<td><a href="boer-bekijk-gegevens.php?view=zaaiing&id=' . $row['ZaaiingID'] . '">Bekijk zaaiing &raquo;</a></td>';
                                echo '<td><a href="invoeren-upload.php">Oogst invoeren &raquo;</a></td>';
                            echo '</tr>';
                        }
                    echo '</table>';
                }
                else {
                    echo '<p>Nog geen zaaiingen gevonden van uw bedrijf.</p>';
                }


            ?>
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