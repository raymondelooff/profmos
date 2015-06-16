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
            Invullen monitoring gegevens <br>
            <input type="hidden" name="send" value="true"/><br>
            <label for="datum">Datum</label><br>
            <input  type="text" id="datum" name="datum" value ="" maxlength="50" size="20"><br>
            <label for="comp">Comp</label><br>
            <select name="comp" id="comp"><br>
                <option value="">Select one</option>
                    <?php
                        for($i = 1; $i <13; $i++){
                            echo "<option value='".$i."''>".$i."</option>";
                        }
                    ?>
            </select><br>
            <label for="locatie">Locatie</label><br>
            <input  type="text" id="locatie" name="locatie" value ="" maxlength="80" size="20"><br>
            <label for="type">Type</label><br>
            <select name="type" id="type">
                <option value="">Select one</option>
                <option value="HW">HW</option>
                <option value="cons">cons</option>
                <option value="zaad">zaad</option>
            </select><br>
            <label for="lengte">Lengte</label><br>
            <input  type="text" id="lengte" name="lengte" value ="" maxlength="80" size="20"><br>
            <label for="natgewicht">Natgewicht</label><br>
            <input  type="text" id="natgewicht" name="natgewicht" value ="" maxlength="80" size="20"><br>
            <label for="visgewicht">Visgewicht</label><br>
            <input  type="text" id="visgewicht" name="visgewicht" value ="" maxlength="80" size="20"><br>
            <label for="AFDW">AFDW</label><br>
            <input  type="text" id="AFDW" name="AFDW" value ="" maxlength="80" size="20"><br>
            <label for="DWschelp">DWschelp</label><br>
            <input  type="text" id="DWschelp" name="DWschelp" value ="" maxlength="80" size="20"><br>
            <input type="submit" value="Verstuur"><br>
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