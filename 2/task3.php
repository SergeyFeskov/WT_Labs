<?php

function output_array(array $arr, int $arr_level)
{
    // arr for colors in order from first dimension to 5th and greater
    $COLORS = ['red', 'blue', 'green', 'purple', 'yellow'];

    // loop through arr's elements
    foreach ($arr as $value) {
        if (is_array($value)) {

            // recursive call if arr's element is array
            output_array($value, $arr_level + 1);
        } else {
            // output of indent of curr element's level
            echo "<pre>", str_repeat(" ", $arr_level * 4);

            // output of element with its level color
            // (for 4th (if start from 0) and greater levels same color
            if ($arr_level < 4) {
                echo "<span style='background-color: $COLORS[$arr_level];'>$value</span>";
            } else {
                echo "<span style='background-color: $COLORS[4];'>$value</span>";
            }
            echo "</pre>";
        }
    }
}

// example
$arr = [1, 1, [2, 2, [3, 3, 3, [4, [[6]], 4, [5, [6, 6, [7, 7]], 5, 5, 5], 4]]], 1, 1];
output_array($arr, 0);