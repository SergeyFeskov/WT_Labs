<?php

//if user enters invalid parameters count and parameters keys
if (count($_GET) != 1 || array_key_first($_GET) != 'rows') {
    echo "Enter one parameter (with 'rows' key), defining number of rows in table.";
    exit();
}

// check for the valid parameter
if (is_numeric($_GET['rows']) &&
    strpos($_GET['rows'], '.') === false &&
    strpos($_GET['rows'], 'e') === false) {

    // html-table initialization
    echo '<table border="1">';

    // loop through rows
    $rows_num = (int)$_GET['rows'];
    for ($tr = 1; $tr <= $rows_num; $tr++) {
        echo '<tr>';
        echo '<td>';
        echo $tr;  //output of the row's number
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    // output if entered invalid parameter
    echo "Parameter 'rows' should be integer number.";
}