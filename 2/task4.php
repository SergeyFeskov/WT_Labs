<?php

// if user doesn't enter any parameters
if (count($_GET) == 0) {
    echo 'Enter any number of parameters.';
    exit();
}

// loop through each parameter
foreach ($_GET as $value) {

    // check if parameter is number
    if (is_numeric($value)) {

        // loop through number's digits,
        // which gets sum of them
        $sum = 0;
        $number_len = strlen($value);
        for ($i = 0; $i < $number_len; $i++) {

            // check for symbols in numbers like 'e' or '.'
            if ('0' < $value[$i] && $value[$i] < '9') {
                $sum += (int)$value[$i];
            }
        }
        echo "The sum of digits in $value equals to $sum. <br>";
    } else {
        echo "$value isn't numeric. <br>";
    }
}