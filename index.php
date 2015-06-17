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

    <title>PROFMOS</title>
</head>

<body>

    <?php

        include_once('includes/header.php');

    ?>

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col col-md-6">
                    <h1>PROFMOS</h1>
                    <h2>Onderzoeksgroep Aquacultuur in Delta Gebieden</h2>
                    <p>
                        Aquacultuur in Delta Gebieden van de Delta Academy richt zijn focus op duurzame zoute aquacultuur in en buiten de regio Zeeland.
                        Aquacultuur is de gecontroleerde productie van zilte gewassen, algen, zeewier, zagers, schelpdieren en vis.
                        De teelt van deze organismen kan plaatsvinden in verschillende (intensieve en extensieve) manieren.
                        De onderzoeksgroep Aquaculture heeft een uitgebreid netwerk opgebouwd van kleine en middelgrote ondernemingen (MKB's), adviesbureaus en kennisinstellingen betrokken bij aquacultuur in en buiten Nederland.
                    </p>
                </div>
                <div class="col col-md-6">
                    <img src="/images/plattegrond.png" alt="Plattegrond PROFMOS" />
                </div>
            </div>
        </div>
    </section>

	<?php

		include_once('includes/footer.php');
		include_once('includes/scripts.php');

	?>

	<!-- Specific JS files here -->


</body>
</html>