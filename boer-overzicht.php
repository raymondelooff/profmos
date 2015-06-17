<?php

    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- CSS -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<link href="css/screen.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

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
                                echo '<td><a href="invoeren-upload.php?view=zaaiing&id=' . $row['ZaaiingID'] . '">Oogst invoeren &raquo;</a></td>';
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