<?php

require_once('includes/MysqliDb.php');
require_once('includes/connectdb.php');
require_once('includes/functions.php');

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

            <?php

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $rules = array(
                    'datum' => array(
                        'label' => 'Datum', //Naam van het veld
                        'type' => 'date', //Type van opslaan
                        'format' => 'm/d/Y' //formaat
                    ),

                    //'mosselgroep' => array(
                    //    'label' => 'Mosselgroep',
                    //    'type' =>
                    //),

                    'bedrijf' => array(
                        'label' => 'Bedrijf',
                        'type' => 'text',
                        'minLength' => 1,
                        'maxLength' => 20
                    ),

                    'boot' => array(
                        'label' => 'Boot',
                        'type' => 'text',
                        'minLength' => 1,
                        'maxLength' => 20
                    ),

                    //'perceel' => array(
                        //'label' => 'Perceel',
                        //'type' => 'text',
                        //minLength => 1,
                        //maxLength => 30
                    //)

                    'nummer' => array(
                        'label' => 'Nummer',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),

                    'vak' => array(
                        'label' => 'Vak',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),

                    'brutomonster' => array(
                        'label' => 'Brutomonster',
                        'type' => 'float'
                    ),

                    'bustal' => array(
                        'label' => 'Bustal',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),

                    'slippers' => array(
                        'label' => 'Slippers',
                        'type' => 'float'
                    ),

                     'zeester' => array(
                        'label' => 'zeester',
                        'type' => 'float'
                    ),

                    'pokken' => array(
                        'label' => 'Pokken',
                        'type' => 'float'
                    ),

                    'kookmonsteraantal' => array(
                        'label' => 'KookMonsterAantal',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),

                    'nettokookmonster' => array(
                        'label' => 'nettomonsteraantal',
                        'type' => 'float'
                    ),

                    'vistotalemonster' => array(
                        'label' => 'vistotalemonster',
                        'type' => 'float'
                    ),

                    'vispercentage' => array(
                        'label' => 'Vispercentage',
                        'type' => 'float'
                    ),

                    'opmerkingen' => array(
                        'label' => 'Opmerkingen',
                        'type' => 'text',
                        'minLength' => 5,
                        'maxLength' => 200
                    ),

                    'kroesnummer' => array(
                        'label' => 'Kroesnummer',
                        'type' => 'int',
                        'minLength' => 1,
                        'maxLength' => 11
                    ),

                    'kroes' => array(
                        'label' => 'Kroes',
                        'type' => 'float'
                    ),

                    'kroesvleesnat' => array(
                        'label' => 'Kroesvleesnat',
                        'type' => 'float'
                    ),

                    'drooggewicht' => array(
                        'label' => 'Drooggewicht',
                        'type' => 'float'
                    ),

                    'asvrijdrooggewicht' => array(
                        'label' => 'Asvrijdrooggewicht',
                        'type' => 'float'
                    ),

                    'schelpendroog' => array(
                        'label' => 'Schelpendroog',
                        'type' => 'float'
                    ),

                    'gemiddeldelengte' => array(
                        'label' => 'Gemiddeldelengte',
                        'type' => 'float'
                    )
                );

                if(isValidArray($rules, $_POST)) {

                    $array = array(
                        'Datum' => $_POST['datum'],
                       // 'mosselgroep_MosselgroepID' => $_POST['mosselgroep'],
                        'Bedrijf_BedrijfID' => $_POST['bedrijf'],
                        'Boot_BootID' => $_POST['boot'],
                        'Perceel_PerceelID' => $_POST['perceel'],
                        'Nummer' => $_POST['nummer'],
                        'Vak_VakID' => $_POST['vak'],
                        '' => $_POST['brutomonster'],
                        '' => $_POST[''],
                        '' => $_POST['']
                    );

                    $insert = $database->insert('meting', $array);

                    if($insert) {
                        echo '<div class="alert alert-success text-center">Monitoring data toegevoegd</div>';
                    }
                    else {
                        echo '<div class="alert alert-warning text-center">Het is niet gelukt de monitoring data toe te voegen, probeer het later opnieuw</div>';
                    }
                }
            }
            ?>

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
                    <label for="brutomonster">Bruto monster (g)</label>
                    <input class="form-control" type="text" id="brutomonster" name="brutomonster" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="bustal">Bustal</label>
                    <input class="form-control" type="text" id="bustal" name="bustal" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="slippers">Slippers (g)</label>
                    <input class="form-control" type="text" id="slippers" name="slippers" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="zeester">Zeester (g)</label>
                    <input class="form-control" type="text" id="zeester" name="zeester" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="pokken">Pokken</label>
                    <input class="form-control" type="text" id="pokken" name="pokken" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="busnetto">Bus netto</label>
                    <input class="form-control" type="text" id="busnetto" name="busnetto" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kookmonsteraantal">Kookmonster aantal</label>
                    <input class="form-control" type="text" id="kookmonsteraantal" name="kookmonsteraantal" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="nettokookmonster">Netto kookmonster (g)</label>
                    <input class="form-control" type="text" id="nettokookmonster" name="netto kookmonster" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="vistotalemonster">Vis totale monster</label>
                    <input class="form-control" type="text" id="vistotalemonster" name="vistotalemonster" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="vispercentage">Vis (%)</label>
                    <input class="form-control" type="text" id="vispercentage" name="vispercentage" maxlength="80" size="20">
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
                    <label for="kroes">Kroes (g)</label>
                    <input class="form-control"  type="text" id="kroes" name="kroes" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="kroesvleesnat">Kroes+vlees nat</label>
                    <input class="form-control" type="text" id="kroesvleesnat" name="kroesvleesnat" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="drooggewicht">Droog gewicht (g)</label>
                    <input class="form-control" type="text" id="drooggewicht" name="drooggewicht" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="asvrijdroogewicht">Asvrij droog gewicht (g)</label>
                    <input class="form-control" type="text" id="asvrijdrooggewicht" name="asvrijdrooggewicht" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="schelpendroog">Schelpen droog (g)</label>
                    <input class="form-control" type="text" id="schelpendroog" name="schelpen droog" maxlength="80" size="20">
                </div>

                <div class="form-group">
                    <label for="gemiddeldelengte">Gemiddelde lengte</label>
                    <input class="form-control" type="text" id="gemiddeldelengte" name="gemiddeldelengte" maxlength="80" size="20">
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