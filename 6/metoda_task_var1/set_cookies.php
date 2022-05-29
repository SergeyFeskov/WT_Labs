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
