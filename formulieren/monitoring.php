<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  	
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
 	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 	 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <!-- Bootstrap -->
    <link href="../css/screen.css" rel="stylesheet">

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
    include ('../includes/header.php');
?>

<section id="content">
    <div class="container">
        <form name="input"
              id="input monitoring"
              action=""
              method="post">
            <div class="form-group">
                Invullen monitoring gegevens
            </div>
            <div class="form-group">
                <input class="form-control" type="hidden" name="send" value="true"/>
            </div>
            <div class="form-group">
                <label for="datum">Datum</label>
                <input class="form-control" type="date" id="datum" name="datum" value ="" maxlength="50" size="20">
            </div>
            <div class="form-group">
                <label for="comp">Comp</label>
                <select class="form-control" name="comp" id="comp">
                    <option value="">Select one</option>
                         <?php
                            for($i = 1; $i <13; $i++){
                               echo "<option value='".$i."''>".$i."</option>";
                          }
                      ?>
                </select>
            </div>
            <div class="form-group">
                <label for="locatie">Locatie</label>
                <input class="form-control" type="text" id="locatie" name="locatie" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" name="type" id="type">
                    <option value="">Select one</option>
                    <option value="HW">HW</option>
                    <option value="cons">cons</option>
                    <option value="zaad">zaad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="lengte">Lengte</label>
                <input class="form-control" type="text" id="lengte" name="lengte" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <label for="natgewicht">Natgewicht</label>
                <input class="form-control" type="text" id="natgewicht" name="natgewicht" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <label for="visgewicht">Visgewicht</label>
                <input class="form-control" type="text" id="visgewicht" name="visgewicht" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <label for="AFDW">AFDW</label>
                <input class="form-control" type="text" id="AFDW" name="AFDW" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <label for="DWschelp">DWschelp</label>
                <input class="form-control" type="text" id="DWschelp" name="DWschelp" value ="" maxlength="80" size="20">
            </div>
            <div class="form-group">
                <input class="form-control" type="submit" value="Verstuur">
            </div>
        </form>
    </div>
</section>

<footer>
    <div class="container">
        <span>&copy; 2015 Delta Academy</span>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>

</body>
</html>