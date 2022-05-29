<?php
function set_style_from_cookie(string $tag, string $style_name, string $cookie_name) {
    if (isset($_POST[$cookie_name])) {
        echo ".content $tag { $style_name : $_POST [$cookie_name] }\n";
        return;
    }
    if (isset($_COOKIE[$cookie_name])) {
        echo ".content $tag { $style_name : $_COOKIE[$cookie_name] }\n";
    }
}

echo "<style>";
set_style_from_cookie("", "background-color", "bg_color");
set_style_from_cookie("h", "color", "h_color");
set_style_from_cookie("h", "font-size", "h_size");
set_style_from_cookie("", "color", "text_color");
set_style_from_cookie("", "font-size", "text_size");
echo "</style>";