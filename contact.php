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
            <div class="row">
                <div class="col col-md-6">
                    <h1>Contact</h1>
                    <p>Mocht u vragen hebben met betrekking tot het PROFMOS-project kunt u via het onderstaande formulier contact opnemen met de projectleiding.</p>

                    <?php

                        // Check if there is a POST request
                        if($_SERVER['REQUEST_METHOD'] == "POST") {
                            require_once('lib/PHPMailer/PHPMailerAutoLoad.php');

                            $mail = new PHPMailer;

                            // Set up mail object
                            $mail->addAddress('raydelooff@gmail.com');

                            // Validate POST array
                            $rules = array(
                                'name' => array(
                                    'label' => 'Naam',
                                    'type' => 'text',
                                    'minLength' => 1,
                                    'maxLength' => 100
                                ),
                                'email' => array(
                                    'label' => 'E-mailadres',
                                    'type' => 'email'
                                ),
                                'subject' => array(
                                    'label' => 'Onderwerp',
                                    'type' => 'text',
                                    'minLength' => 1,
                                    'maxLength' => 100
                                ),
                                'message' => array(
                                    'label' => 'Bericht',
                                    'type' => 'text',
                                    'minLength' => 1,
                                    'maxLength' => 500
                                )
                            );

                            if(isValidArray($rules, $_POST)) {
                                $mail->From = $_POST['email'];
                                $mail->FromName = $_POST['name'];
                                $mail->Subject = $_POST['subject'];
                                $mail->Body = '<p>Bericht via het contactformulier:</p>' . $_POST['message'];

                                if($mail->send()) {
                                    echo '<div class="alert alert-success">Bedankt voor uw bericht!</div>';
                                }
                                else {
                                    echo '<div class="alert alert-danger">De e-mail kon niet worden verzonden, probeer het opnieuw.</div>';
                                }
                            }

                        }

                    ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="name">Naam:</label>
                            <input type="text" class="form-control" name="name" id="name" <?php getTextFieldValue('name'); ?>>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" class="form-control" name="email" id="email" <?php getTextFieldValue('email'); ?>>
                        </div>

                        <div class="form-group">
                            <label for="subject">Onderwerp:</label>
                            <input type="text" class="form-control" name="subject" id="subject" <?php getTextFieldValue('subject'); ?>>
                        </div>

                        <div class="form-group">
                            <label for="message">Bericht:</label>
                            <textarea class="form-control" name="message" id="message" rows="10"><?php getTextAreaValue('message'); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Verzenden</button>
                    </form>
                </div>
                <div class="col col-md-6">
                    <img src="/images/plattegrond.png" alt="Plattegrond PROFMOS" />
                </div>
            </div>
        </div>
    </section>

    <?php

        include_once('includes/footer.php');

    ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>

</body>
</html>