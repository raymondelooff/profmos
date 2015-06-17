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
						<li>1 keer per 2 maanden buiten groeiseizoen (dec, jan, mrt)</li>
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