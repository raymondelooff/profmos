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

    // Check if the string contains legit characters
    return preg_match('/[^.,_-a-zA-Z0-9 ]/', $input);

}

// Function for validating emails
function isValidEmail($input) {

    return filter_var($input, FILTER_VALIDATE_EMAIL);

}

// Function for validating a form
function isValidArray($rules, $array) {

    foreach($array as $name => $value) {

        if(isset($rules[$name])) {
            $rule = $rules[$name];

            if($rule != null) {
                switch($rule['type']) {

                    // Value needs to be checked as 'text'
                    case 'text':

                        if(!isValidText($value, $rule['minLength'], $rule['maxLength'])) {
                            echo '<div class="alert alert-danger">Vul a.u.b. het veld <strong>' . $rule['label'] . '</strong> (geldig) in!</div>';
                            return false;
                        }

                        break;

                    // Value needs to be checked as 'email'
                    case 'email':

                        if(!isValidEmail($value)) {
                            echo '<div class="alert alert-danger">Vul a.u.b. het veld <strong>' . $rule['label'] . '</strong> (geldig) in!</div>';
                            return false;
                        }

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