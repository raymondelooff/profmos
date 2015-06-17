<?php

require_once('../includes/MysqliDb.php');
require_once('../includes/connectdb.php');
require_once('../lib/ExcelReader/php-excel-reader/excel_reader2.php');
require_once('../lib/ExcelReader/SpreadsheetReader.php');

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

        ?>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">

                        <?php

                        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $error = "";
                            $target_dir = "../uploads/";
                            $target_file = $target_dir . basename($_FILES["upload"]["name"]);
                            $upload_success = 1;
                            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

                            // Check if file already exists
                            if (file_exists($target_file)) {
                                $error .= "Het bestand bestaat al op de server. ";
                                $upload_success = 0;
                            }

                            // Check file size
                            if ($_FILES["upload"]["size"] > 500000) {
                                $error .= "Het bestand is te groot. ";
                                $upload_success = 0;
                            }

                            // Allow certain file formats
                            if ($fileType != "xlsx") {
                                $error .= "Upload alstublieft een .xlsx (Excel) bestand.";
                                $upload_success = 0;
                            }

                            // Check if $upload_success is set to 0 by an error
                            if ($upload_success == 1) {
                                // if everything is ok, try to upload file
                                if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                                    $error .= "Het bestand " . basename($_FILES["upload"]["name"]) . " is geüpload en verwerkt in de database.";

                                    $reader = new SpreadsheetReader($target_file);

                                    // Remove file
                                    unlink($target_file);

                                    $insert['Zaaiing_ZaaiingID'] = 13;
                                    $zaaiingRow = $database->rawQuery('SELECT * FROM zaaiing WHERE ZaaiingID = ' . $insert['Zaaiing_ZaaiingID']);
                                    $insert = array();
                                    $i = 0;
                                    $verzaaien = false;
                                    $tabel = "";
                                    $oppervlakte = 0;

                                    foreach ($reader as $row) {
                                        if ($i == 1) {
                                            $insert['Datum'] = $row[1];
                                        }
                                        if ($i == 2) {
                                            $activiteit = $row[1];
                                            if ($activiteit == "Zaaien" || $activiteit == "Bijzaaien" || $activiteit == "Verzaaien") {
                                                $tabel = 'zaaiing';
                                            }
                                            else if ($activiteit == "Vissen voor veiling" || $activiteit == "Uitvissen") {
                                                $tabel = 'oogst';
                                            }
                                            else if ($activiteit == "Sterren rollen" || $activiteit == "Trekje op perceel") {
                                                $tabel = 'behandeling';
                                            }

                                            if ($activiteit == "Verzaaien") {
                                                $verzaaien = true;
                                            }
                                        }
                                        /**if ($i == 3) {
                                        $gezaaidAls = $row[1];
                                        if ($gezaaidAls == "Anders:") {
                                        $gezaaidAls = $row[2];
                                        }
                                        $insert['gezaaidAls'] = $gezaaidAls;
                                        }*/
                                        if ($i == 4) {
                                            $oppervlakte = $row[1];
                                        }
                                        if ($i == 6) {
                                            $insert['Monster'] = $row[1];
                                        }
                                        if ($i == 7) {
                                            $insert['MonsterLabel'] = $row[1];
                                        }
                                        if ($i == 10 && $verzaaien) {
                                            $herkomstNaam = $row[1];

                                        }
                                        if ($i == 11 && $verzaaien) {
                                            $herkomstPlaats = $row[1];
                                        }
                                        if ($i == 12 && $verzaaien) {
                                            $herkomstOppervlakte = $row[1];
                                        }
                                        if ($i == 15) {
                                            $insert['Bustal'] = $row[1];
                                        }
                                        if ($i == 16) {
                                            $insert['BrutoMton'] = $row[1];
                                            $insert['Kilogram'] = $insert['BrutoMton'] * 100;
                                            if ($tabel == 'oogst') {
                                                $insert['Rendement'] = $insert['Kilogram'] / $zaaiingRow['Kilogram'];
                                                echo $insert['Rendement'];
                                            }
                                            if ($tabel == 'zaaiing') {
                                                $insert['KilogramPerM2'] = ($insert['Kilogram'] / ($oppervlakte * 10000));
                                            }

                                        }
                                        if ($i == 17) {
                                            $perceelLeeggevist = $row[1];
                                        }
                                        if ($i == 18) {
                                            $insert['Opmerking'] = $row[1];
                                        }
                                        $i++;
                                    }

                                    $insert['Bedrijf_BedrijfID'] = $_POST['bedrijf'];
                                    $insert['Vak_VakID'] = $_POST['vak'];
                                    $insert['Perceel_PerceelID'] = $_POST['perceel'];
                                    $database->insert('mosselgroep', array('ParentMosselgroepID' => null));
                                    $insert['Mosselgroep_MosselgroepID'] = $database->getInsertId();
                                    if (!$verzaaien) {
                                        $database->insert($tabel, $insert);
                                    }

                                }
                                else {
                                    $error .= "Het bestand kan niet geüpload worden.";
                                }

                            }
                            else {
                                $error .= "Geen geldig bestand geupload.";
                            }

                            echo $error;
                        }

                        ?>

                        <form method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="upload" id="upload">
                            <br>
                            <select name="bedrijf">
                                <option>1</option>
                            </select>
                            <select name="perceel">
                                <option>1</option>
                            </select>
                            <select name="vak">
                                <option>1</option>
                            </select>
                            <input type="submit" value="Upload spreadsheet" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>