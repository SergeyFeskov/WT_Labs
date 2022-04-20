<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab3. Task from SEO. Variant 3</title>
</head>
<body>
<form action="" method="post">
    <p>Array 1: <input type="text" name="arr1"></p>
    <p>Array 2: <input type="text" name="arr2"></p>
    <p><input type="submit"/></p>
</form>
<?php

if (count($_POST) != 2 || !isset($_POST['arr1']) || !isset($_POST['arr2'])) {
    exit(1);
}

$arr1 = preg_split("/\s+/", $_POST['arr1']);
$arr2 = preg_split("/\s+/", $_POST['arr2']);

foreach ($arr1 as $value) {
    if (!is_numeric($value)) {
        echo "$value in array 1 isn't numeric.";
        exit(1);
    }
}

foreach ($arr2 as $value) {
    if (!is_numeric($value)) {
        echo "$value in array 1 isn't numeric.";
        exit(1);
    }
}

$result_arr = $arr1;
foreach ($arr2 as $num) {
    if (!in_array($num, $arr1)) {
        $result_arr[] = $num;
    }
}

echo "Arr 1: " . implode(' ', $arr1) . "<br>";
echo "Arr 2: " . implode(' ', $arr2) . "<br>";
echo "Result arr: " . implode(' ', $result_arr);