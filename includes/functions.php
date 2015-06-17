<?php

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
    return !preg_match('/[^[:alnum:][:space:].,?!]/ui', $input);

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

    // Check if all the required fields are sent
    foreach($rules as $key => $rule) {

        if($rule != 'optional') {
            if (!isset($array[$key]) || empty($array[$key])) {
                echo '<div class="alert alert-danger">Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> in!</div>';
                return false;
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
                            echo '<div class="alert alert-danger">Vul a.u.b. het veld <strong>' . $rule['label'] . '</strong> (geldig) in! Minimaal ' . $rule['minLength'] . ', maximaal ' . $rule['maxLength'] . ' tekens.</div>';
                            return false;
                        }

                        break;

                    // Value needs to be checked as 'email'
                    case 'email':

                        if (!isValidEmail($value)) {
                            echo '<div class="alert alert-danger">Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) e-mailadres in!</div>';
                            return false;
                        }

                        break;

                    // Value needs to be checked as 'int'
                    case 'int':

                        if (!isValidInteger($value, $rule['minLength'], $rule['maxLength'])) {
                            echo '<div class="alert alert-danger">Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) nummer in! Minimaal ' . $rule['minLength'] . ', maximaal ' . $rule['maxLength'] . ' tekens.</div>';
                            return false;
                        }

                        break;

                    // Value needs to be checked as 'int'
                    case 'float':

                        if (!isValidFloat($value)) {
                            echo '<div class="alert alert-danger">Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldig) nummer in!</div>';
                            return false;
                        }

                        break;

                    // Value needs to be checked as 'date'
                    case 'date':

                        if (!isValidDate($value, $rule['format'])) {
                            echo '<div class="alert alert-danger">Vul a.u.b. in het veld <strong>' . $rule['label'] . '</strong> een (geldige) datum in!</div>';
                            return false;
                        }

                        break;

                    default:

                        echo '<div class="alert alert-danger">Ongeldig validatie type <strong>' . $rule['type'] . '</strong>!</div>';
                        return false;

                        break;

                }
            }
        }
        else {
            echo '<div class="alert alert-danger">Veld <strong>' . $name . '</strong> wordt niet gevalideerd! Voeg regels toe aan de validatie rules array.</div>';
            return false;
        }
    }

    return true;

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