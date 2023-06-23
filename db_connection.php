<?php

$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "WPRG";

$con = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$con) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

