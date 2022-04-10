<?php

// if user doesn't enter any parameters
if (count($_GET) == 0) {
    echo 'Enter any number of parameters.';
    exit();
}

// ensure that curr encoding for multibyte chars is UTF-8
mb_internal_encoding("UTF-8");

// get params values
$params = array_values($_GET);
$params_num = count($params);

// loop through params,
// which finds max length among params
$max_len = mb_strlen($params[0]);
for ($i = 1; $i < $params_num; $i++) {
    if (mb_strlen($params[$i]) > $max_len) {
        $max_len = mb_strlen($params[$i]);
    }
}

echo "Parameters max length: $max_len. <br>";
echo "Parameters with max length: <br>";

// outputs params with max length
for ($i = 0; $i < $params_num; $i++) {
    if (mb_strlen($params[$i]) == $max_len) {
        echo "$params[$i] <br>";
    }
}
