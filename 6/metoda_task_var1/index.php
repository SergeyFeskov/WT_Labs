<?php
const EXPIRE_TIME = 180;

function set_cookie_from_post(string $name) {
    if (isset($_POST[$name])) {
        setcookie($name, $_POST[$name], time() + EXPIRE_TIME);
    }
}

set_cookie_from_post("bg_color");
set_cookie_from_post("h_color");
set_cookie_from_post("h_size");
set_cookie_from_post("text_color");
set_cookie_from_post("text_size");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab6. Metoda task. Variant 1</title>
    <link href="static_styles.css" rel="stylesheet">
    <?php require_once "cookie_funcs.php" ?>
</head>
<body>
<form method="post" action="index.php">
    <p>Background color: <input type="color" name="bg_color" value="<?php get_cookie("bg_color", "#ffffff")?>"></p>
    <p>Header text color: <input type="color" name="h_color" value="<?php get_cookie("h_color", "#000000")?>"></p>
    <p>Header text size: <input type="number" name="h_size" value="<?php get_cookie("h_size", "32")?>"></p>
    <p>Other text color: <input type="color" name="text_color" value="<?php get_cookie("text_color", "#000000")?>"></p>
    <p>Other text size: <input type="number" name="text_size" value="<?php get_cookie("text_size", "16")?>"></p>
    <input type="submit" value="Set">
</form>
<?php
    require_once "set_styles.php";
?>
<div class="content">
    <h1>Header</h1>
    This is plain text!
</div>
</body>
</html>