<?php

// Function for cleaning text inputs
function cleanText($input) {

    return preg_replace('/[^[:alnum:][:space:].,?!:;]/ui', '', $input);

}

// Function for cleaning integer inputs
function cleanInteger($input) {

    return preg_replace('/[^[:digit:]]/ui', '', $input);

}

// Function for cleaning float inputs
function cleanFloat($input) {

    $input = str_replace(',', '.', $input);

    return preg_replace('/[^[:digit:].]/ui', '', $input);

}

// Function for validating text input
function isValidText($input, $minLength, $maxLength) {

    // Check if the length of the input is not shorter than the minimum length
    if(strlen($input) < $minLength) {
        return false;
    }

    // Check if the length of the input is not longer than the maximum length
    if(strlen($input) > $maxLength) {
        return false;
    }

    $input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    // Check if the string contains legit characters
    return !preg_match('/[^[:alnum:][:space:].,?!:;]/ui', $input);

}

// Function for validating emails
function isValidEmail($input) {

    return filter_var($input, FILTER_VALIDATE_EMAIL);

}

// Function for validating integer inputs
function isValidInteger($input, $minLength, $maxLength) {

    // Check if the length of the input is not shorter than the minimum length
    if(strlen($input) < $minLength) {
        return false;
    }

    // Check if the length of the input is not longer than the maximum length
    if(strlen($input) > $maxLength) {
        return false;
    }

    if(!is_numeric($input)) {
        return false;
    }

    return true;

}

// Function for validating float inputs
function isValidFloat($input) {

    $input = str_replace(',', '.', $input);

    if(!is_numeric($input)) {
        return false;
    }

    return true;

}

// Function for validating the date
function isValidDate($input, $format) {

    $date = DateTime::createFromFormat($format, $input);
    return $date && $date->format($format) == $input;

}

// Function for validating a form
function isValidArray($rules, $array) {

	$errors = array();
    $newArray = array();

    // Check if all the required fields are sent
    foreach($rules as $key => $rule) {

        if($rule != 'optional') {
            if (!isset($array[$key])) {
                $errors[] = 'Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> in!';
            }
        }

    }

    // Check the values of the sent fields
    foreach($array as $name => $value) {

        // Check if the rules for the field are set
        if(isset($rules[$name])) {
            $rule = $rules[$name];

            // Check if the rule is optional
            if($rule != 'optional') {
                switch ($rule['type']) {

                    // Value needs to be checked as 'text'
                    case 'text':

                        if (!isValidText($value, $rule['minLength'], $rule['maxLength'])) {
							$errors[] = 'Vul a.u.b. het veld <strong>' . $rule['label'] . '</strong> (geldig) in! Minimaal ' . $rule['minLength'] . ', maximaal ' . $rule['maxLength'] . ' tekens.';
                        }
                        else {
                            $newArray[$name] = cleanText($value);
                        }

                        break;

                    // Value needs to be checked as 'email'
                    case 'email':

                        if (!isValidEmail($value)) {
							$errors[] = 'Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) e-mailadres in!';
                        }
                        else {
                            $newArray[$name] = $value;
                        }

                        break;

                    // Value needs to be checked as 'int'
                    case 'int':

                        if (!isValidInteger($value, $rule['minLength'], $rule['maxLength'])) {
							$errors[] = 'Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) nummer in! Minimaal ' . $rule['minLength'] . ', maximaal ' . $rule['maxLength'] . ' tekens.';
                        }
                        else {
                            $newArray[$name] = cleanInteger($value);
                        }

                        break;

                    // Value needs to be checked as 'float'
                    case 'float':

                        if (!isValidFloat($value)) {
							$errors[] = 'Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) getal in!';
                        }
                        else {
                            $newArray[$name] = cleanFloat($value);
                        }

                        break;

                    // Value needs to be checked as 'date'
                    case 'date':

                        if (!isValidDate($value, $rule['format'])) {
							$errors[] = 'Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldige) datum in!';
                        }
                        else {
                            $newArray[$name] = $value;
                        }

                        break;

                    default:

						$errors[] = 'Ongeldig validatie type <strong>' . $rule['type'] . '</strong>!';

                        break;

                }
            }
        }
        else {
			$errors[] = 'Veld <strong>' . $name . '</strong> wordt niet gevalideerd! Voeg regels toe aan de validatie rules array.';
        }
    }

	if(!empty($errors)) {

        echo '<div class="alert alert-danger">';

            if(count($errors) == 1) {
                echo 'Er trad <strong>1</strong> fout op:';
            }
            else {
                echo 'Er traden <strong>' . count($errors) . '</strong> fouten op:';
            }

            echo '<ul>';
                foreach($errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
            echo '</ul>';

        echo '</div>';

		return false;

	}

    return $newArray;

}

// Function for filling in the value of a text field
function getTextFieldValue($field) {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST[$field])) {
			echo 'value="' . $_POST[$field] . '"';
		}
	}

}

// Function for filling in the value of a text area
function getTextAreaValue($field) {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST[$field])) {
			echo $_POST[$field];
		}
	}

}