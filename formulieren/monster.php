<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');

?>
<!DOCTYPE html>
<html lang="nl">
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
        include('../includes/header.php');
        ?>

        <form id="monster" style="padding-top: 200px;">
            Datum: <div class="date">
                <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
            Item: <input type="text">
            <br>
        </form>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/invulformulieren.js"></script>
    </body>
</html>


