<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');
require_once('../lib/ExcelReader/php-excel-reader/excel_reader2.php');
require_once('../lib/ExcelReader/SpreadsheetReader.php');

if(isset($_POST["submit"])) {
    $error_msg = "";
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if file already exists
    if (file_exists($target_file)) {
        $error_msg .= "Het bestand bestaat al op de server. ";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["upload"]["size"] > 500000) {
        $error_msg .= "Het bestand is te groot. ";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($fileType != "xlsx") {
        $error_msg .= "Upload alstublieft een .xlsx (Excel) bestand.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            $error_msg .= "Het bestand " . basename($_FILES["upload"]["name"]) . " is geüpload en verwerkt in de database.";

            $reader = new SpreadsheetReader($target_file);
            $gets = array();
            $i = 0;
            foreach ($reader as $row) {
                if ($i == 1) {
                    $gets['datum'] = $row[1];
                }
                if ($i == 2) {
                    $gets['activiteit'] = $row[1];
                }
                if ($i == 3) {
                    $gezaaidAls = $row[1];
                    if ($gezaaidAls == "Anders:") {
                        $gezaaidAls = $row[2];
                    }
                    $gets['gezaaidAls'] = $gezaaidAls;
                }
                if ($i == 4) {
                    $gets['oppervlakte'] = $row[1];
                }
                if ($i == 6) {
                    $gets['monster'] = $row[1];
                }
                if ($i == 7) {
                    $gets['label'] = $row[1];
                }
                if ($i == 10) {
                    $gets['herkomstNaam'] = $row[1];
                }
                if ($i == 11) {
                    $gets['herkomstPlaats'] = $row[1];
                }
                if ($i == 12) {
                    $gets['herkomstOppervlakte'] = $row[1];
                }
                if ($i == 15) {
                    $gets['busstukstal'] = $row[1];
                }
                if ($i == 16) {
                    $gets['mosselton'] = $row[1];
                }
                if ($i == 17) {
                    $gets['perceelLeeggevist'] = $row[1];
                }
                if ($i == 18) {
                    $gets['opmerkingen'] = $row[1];
                }
                $i++;
            }

            unlink($target_file);

        }

        else {

            $error_msg .= "Het bestand kan niet geüpload worden.";
        }

    }
}
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
            include_once('../includes/header.php');
            echo $error_msg;
        ?>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="upload" id="upload">
                            <input type="submit" value="Upload spreadsheet" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>