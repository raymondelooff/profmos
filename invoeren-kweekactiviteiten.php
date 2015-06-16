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
            <h2>Registratie kweekactiviteiten</h2>

            <form role="form">
            	
                <div class="form-group">
                    <label for="datum">Datum:</label>
                    <input type="text" class="form-control date" name="datum">
                </div>
                
                <div class="form-group">
                    <label for="activiteit">Activiteit:</label>
                    <select class="form-control" id="activiteit" name="activiteit" >
                        <option >Zaaien</option>
                        <option >Verzaaien</option>
                        <option >Sterren dweilen</option>
                        <option >Sterren rollen</option>
                        <option >Uitvissen</option>
                        <option >Bijzaaien</option>
                        <option >Trekje op perceel</option>
                        <option >Anders</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="perceel_naam">Perceel naam: </label>
                    <input type="text" class="form-control" id="perceel_naam" name="perceel_naam" >
                </div>
                
                <div class="form-group">
                    <label for="perceel_plaats">Perceel plaats: </label>
                    <input type="text" class="form-control" id="perceel_plaats" name="perceel_plaats" >
                </div>
                
                <div class="form-group">
                    <label for="gezaaid_als">Gezaaid als:</label>
                    <select class="form-control" id="gezaaid_als" name="gezaaid_als" >
                        <option >MZI WAD</option>
                        <option >NJZAAD</option>
                        <option >VJZAAD</option>
                        <option >HalfwasOS</option>
                        <option >HalfwasWAD</option>
                        <option >Consumptie</option>
                        <option >Anders</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="oppervlakte">Oppervlakte: </label>
                    <input type="text" class="form-control" id="oppervlakte" name="oppervlakte" >
                </div>
                
                <br>
                <br>
                
                <div class="form-group">
                    <label for="monster">Monster:</label>
                    <select class="form-control" id="monster" name="monster" >
                        <option >Ja</option>
                        <option >Nee</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="label">Label: </label>
                    <input type="text" class="form-control" id="label" name="label" >
                </div>
                
                <br>
                <br>
                
                <div class="form-group">
                    <label for="label">Verzaaien </label>
                </div>
                
                <div class="form-group">
                    <label for="perceel_naam_verzaaien">Perceel naam: </label>
                    <input type="text" class="form-control" id="perceel_naam_verzaaien" name="perceel_naam_verzaaien" >
                </div>
                
                <div class="form-group">
                    <label for="perceel_plaats_verzaaien">Perceel plaats: </label>
                    <input type="text" class="form-control" id="perceel_plaats_verzaaien" name="perceel_plaats_verzaaien" >
                </div>
                
                <div class="form-group">
                    <label for="oppervlakte_verzaaien">Oppervlakte: </label>
                    <input type="text" class="form-control" id="oppervlakte_verzaaien" name="oppervlakte_verzaaien" >
                </div>
                
                <br>
                <br>
                
                <div class="form-group">
                    <label for="label">Indien van toepassing </label>
                </div>
                
                <div class="form-group">
                    <label for="busstukstal">Busstukstal: </label>
                    <input type="text" class="form-control" id="busstukstal" name="busstukstal" >
                </div>
                
                <div class="form-group">
                    <label for="mosselton">Mosselton: </label>
                    <input type="text" class="form-control" id="mosselton" name="mosselton" >
                </div>
                
                <div class="form-group">
                    <label for="perceel_leeggevist">Perceel leeggevist?</label>
                    <select class="form-control" id="perceel_leeggevist" name="perceel_leeggevist" >
                        <option >Ja</option>
                        <option >Nee</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="opmerkingen">Opmerkingen:</label>
                    <textarea class="form-control" rows="5" id="opmerkingen" name="opmerkingen" ></textarea>
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