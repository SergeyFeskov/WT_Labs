<?php

// if user doesn't enter any parameters
if (count($_GET) == 0) {
    echo "Enter any number of parameters and script will print their types.";
    exit();
}

// check if the entered parameter is float or integer or string
foreach ($_GET as $value) {
    if (is_numeric($value)) {
        if (strpos($value, '.') === false && strpos($value, 'e') === false) {
            echo "$value is integer number.";
        } else {
            echo "$value is float number.";
        }
    } else {
        echo "$value is string.";
    }
    echo "<br>";
}
