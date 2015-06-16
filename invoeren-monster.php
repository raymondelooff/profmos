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
            <h2>Monster data</h2>

            <form role="form">
                <div class="form-group">
                    <label for="datum">Datum</label>
                    <input type="text" class="form-control date" name="date">
                </div>

                <div class="form-group">
                    <label for="mosselgroep">Mosselgroep</label>
                    <input class="form-control" type="text" id="mosselgroep" name="mosselgroep" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="bedrijf">Bedrijf</label>
                    <input class="form-control" type="text" id="bedrijf" name="bedrijf" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="boot">Boot</label>
                    <input  class="form-control" type="text" id="boot" name="boot" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="perceel">Perceel</label>
                    <input  class="form-control" type="text" id="perceel" name="perceel" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="nummer">Nummer</label>
                    <input class="form-control" type="text" id="nummer" name="nummer" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="vak">Vak</label>
                    <input class="form-control" type="text" id="vak" name="vak" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="bruto monster (g)">Bruto monster (g)</label>
                    <input class="form-control" type="text" id="bruto monster (g)" name="bruto monster (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="bustal">Bustal</label>
                    <input class="form-control" type="text" id="bustal" name="bustal" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="slippers (g)">Slippers (g)</label>
                    <input class="form-control" type="text" id="slippers (g)" name="slippers (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="zeester (g)">Zeester (g)</label>
                    <input class="form-control" type="text" id="zeester (g)" name="zeester (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="pokken">Pokken</label>
                    <input class="form-control" type="text" id="pokken" name="pokken" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="bus netto">Bus netto</label>
                    <input class="form-control" type="text" id="bus netto" name="bus netto" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kookmonster aantal">Kookmonster aantal</label>
                    <input class="form-control" type="text" id="kookmonster aantal" name="kookmonster aantal" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="netto kookmonster (g)">Netto kookmonster (g)</label>
                    <input class="form-control" type="text" id="netto kookmonster (g)" name="netto kookmonster (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="vis totale monster">Vis totale monster</label>
                    <input class="form-control" type="text" id="vis totale monster" name="vis totale monster" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="vis (%)">Vis (%)</label>
                    <input class="form-control" type="text" id="vis (%)" name="vis (%)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="opmerkingen">Opmerkingen</label>
                    <input class="form-control" type="text" id="opmerkingen" name="opmerkingen" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kroesnummer">Kroesnummer</label>
                    <input class="form-control" type="text" id="kroesnummer" name="kroesnummer" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kroes (g)">Kroes (g)</label>
                    <input class="form-control"  type="text" id="kroes (g)" name="kroes (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kroes+vlees nat">Kroes+vlees nat</label>
                    <input class="form-control" type="text" id="kroes+vlees nat" name="kroes+vlees nat" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="droog gewicht (g)">Droog gewicht (g)</label>
                    <input class="form-control" type="text" id="droog gewicht (g)" name="droog gewicht (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="asvrij droog gewicht (g)">Asvrij droog gewicht (g)</label>
                    <input class="form-control" type="text" id="asvrij droog gewicht (g)" name="asvrij droog gewicht (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="schelpen droog (g)">Schelpen droog (g)</label>
                    <input class="form-control" type="text" id="schelpen droog (g)" name="schelpen droog (g)" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="gemiddelde lengte">Gemiddelde lengte</label>
                    <input class="form-control" type="text" id="gemiddelde lengte" name="gemiddelde lengte" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Verstuur">
                </div>
            </form>
        </div>
    </section>

    <?php

    include_once('includes/footer.php');

    ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/invulformulieren.js"></script>

</body>
</html>