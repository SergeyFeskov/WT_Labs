<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lab4. Task 8 (RegExp)</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
$curr_dir = opendir(getcwd());
if ($curr_dir === false) {
    echo "ERROR(with " . getcwd() . " directory): can't be open.";
    exit(1);
}

$cwd_filenames = [];
while (($filename = readdir($curr_dir)) !== false)
{
    if ($filename == '.' || $filename == '..') {
        continue;
    }

    if (is_file($filename)) {
        $cwd_filenames[] = $filename;
    }
}
closedir($curr_dir);

if (count($cwd_filenames) == 0) {
    echo "ERROR: CWD doesn't contain files.";
    exit(1);
}
?>
<form method='POST'>
    <p>
        Select file you want to parse:
        <select name='src_file' size='1'>
            <?php
            foreach ($cwd_filenames as $filename) {
                echo "<option value='$filename'>$filename</option>";
            }
            ?>
        </select>
    </p>
    <input type="submit" value="Send">
</form>
<?php

if (count($_POST) == 0) {
    exit();
}

$src_filename = $_POST['src_file'];
$file_text = file_get_contents($src_filename);

echo "Source text: <br>" . $file_text . "<br>";

const DAY_PATTERN = '(0?[1-9]|[12][0-9]|3[01])';
const MONTH_PATTERN = '(0?[1-9]|1[0-2])';
const YEAR_PATTERN = '(\d{4}|\d{2})';

const DOT_PATTERN = '#' . DAY_PATTERN . '\.' . MONTH_PATTERN . '\.' . YEAR_PATTERN . '#';
const SLASH_PATTERN = '#' . MONTH_PATTERN . '/' . DAY_PATTERN . '/' . YEAR_PATTERN . '#';

$file_text = preg_replace(SLASH_PATTERN, '${2}.${1}.${3}', $file_text);
$file_text = preg_replace_callback(
        DOT_PATTERN,
        function ($matches) {
            return '<span style="color: #DD0000">' . $matches[1] . '.' . $matches[2] . '.' . ($matches[3] + 1) . '</span>';
        },
        $file_text
);

echo "Result text: <br>" . $file_text;