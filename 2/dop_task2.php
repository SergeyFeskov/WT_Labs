<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab2. Additional task 2</title>
</head>
<body>
<form action="" method="post">
    <p>
        Enter string:
        <label>
            <input type="text" name="name" style="width: 400px"/>
        </label>
    </p>
    <input type="submit" value="Enter"/>
</form>
<?php

// if Enter wasn't clicked
if (!isset($_POST['name'])) {
    exit();
}

mb_internal_encoding('UTF-8');

// init vars
$array = htmlspecialchars($_POST['name']);
$array_words = explode(" ", $array);

// number of letters 'o' and 'O' in the string
$count = 0;
for ($k = 0; $k < mb_strlen($array); $k++) {
    if ($array[$k] == 'o' || $array[$k] == 'O') {
        $count++;
    }
}
echo "Number of 'o' and 'O' repetitions: ", $count, ".<br />";

echo "Result string:<br />";

// loop through words
for ($i = 0; $i < count($array_words); $i++) {

    // turn into upper case letters of third words
    if (($i + 1) % 3 == 0) {
        $array_words[$i] = mb_strtoupper($array_words[$i]);
    }

    // change color of third letters
    $word = $array_words[$i];
    for ($j = 0; $j < mb_strlen($word); $j++) {
        if (($j + 1) % 3 == 0) {
            echo "<span style='color:purple; font-weight: bold;'>$word[$j]</span>";
        } else {
            echo $word[$j];
        }
    }
    echo ' ';
}

?>
</body>
</html>