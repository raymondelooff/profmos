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

// Function for validating numeric inputs
function isValidNumber($input) {

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

    foreach($array as $name => $value) {

        if(isset($rules[$name])) {
            $rule = $rules[$name];

            if($rule != null) {
                if($rule != 'optional') {
                    switch ($rule['type']) {

                        // Value needs to be checked as 'text'
                        case 'text':

                            if (!isValidText($value, $rule['minLength'], $rule['maxLength'])) {
                                echo '<div class="alert alert-danger">Vul a.u.b. het veld <strong>' . $rule['label'] . '</strong> (geldig) in!</div>';
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

                        // Value needs to be checked as 'numeric'
                        case 'numeric':

                            if (!isValidNumber($value)) {
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

                    }
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