<?php

// get clicked parameter's value or null if clicked isn't set
$clicked = $_GET['clicked'] ?? null;

// set style for clicked link
echo "<style> .$clicked { background-color: black; color: red; } </style>";

// output links
echo "<a class='about' href='dop_task1.php?clicked=about'>About company</a>";
echo "<a class='services' href='dop_task1.php?clicked=services'>Services</a>";
echo "<a class='prices' href='dop_task1.php?clicked=prices'>Prices</a>";
echo "<a class='contacts' href='dop_task1.php?clicked=contacts'>Contacts</a>";