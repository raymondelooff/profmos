<?php

    // Includes
    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');

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