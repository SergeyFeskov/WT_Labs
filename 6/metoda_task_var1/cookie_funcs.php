<?php
function get_cookie(string $cookie_name, string $default_value) {
    if (isset($_POST[$cookie_name])) {
        echo $_POST[$cookie_name];
        return;
    }
    if (isset($_COOKIE[$cookie_name])) {
        echo $_COOKIE[$cookie_name];
    } else {
        echo $default_value;
    }
}