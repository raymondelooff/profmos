<?php
    //includes
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
                    <h3>Waar staat ProfMos voor?</h3>
                    <p>
                    PROFMOS staat voor Productie factoren Mosselcultuur Oosterschelde
                    </p>
                   	
                   	<h3>Wat is het doel van het PROFMOS-project?</h3>
                   	<p>Welke factoren bepalen het kweekrendement op percelen in de Oosterschelde en hoe kan dit verbeterd worden?</p>
					<ul>
						<li>Kweekrendement = groei x overleving</li>
						<li>Optimalisatie rendement = verbeteren groei + verbeteren overleving = verminderen verlies</li>
					</ul>

                    <h3>Van welke data wordt gebruik gemaakt?</h3>
					<ol>
						<li>Data van de monitoring</li>
						<li>Kweekgegevens (logboeken)</li>
						<li>Aangeleverde mosselmonsters</li>
					</ol>

                    <h3>Data van monitoring</h3>
                    <p>Uitgezet in maart 2014 en maart 2015. Per jaar 9 keer bemonsterd:</p>
					<ul>
						<li>1 keer per maand in het groeiseizoen (apr, mei, jun, jul, aug, sept)</li>
						<li>1 keer per 2 maanden buiten groeiseizoen (nov, jan, mrt)</li>
					</ul>

                </div>
                <div class="col col-md-6">
                    <img src="/images/mosselboot.jpg" alt="Mosselboot PROFMOS" />
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