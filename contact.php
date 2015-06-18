<?php
    //includes
    require_once('includes/MysqliDb.php');
    require_once('includes/connectdb.php');
    require_once('includes/functions.php');

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<?php

		include_once('includes/head.php');

	?>

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

                            $post = isValidArray($rules, $_POST);

                            if($post !== FALSE) {
                                $mail->From = $post['email'];
                                $mail->FromName = $post['name'];
                                $mail->Subject = $post['subject'];
                                $mail->Body = '<p>Bericht via het contactformulier:</p>' . $post['message'];

                                if($mail->send()) {
                                    echo '<div class="alert alert-success">Bedankt voor uw bericht!</div>';
                                }
                                else {
                                    echo '<div class="alert alert-danger">De e-mail kon niet worden verzonden, probeer het opnieuw.</div>';
                                }
                            }

                        }

                    ?>
                    <!--invulformulier-->
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
		include_once('includes/scripts.php');

	?>

	<!-- Specific JS files here -->


</body>
</html>