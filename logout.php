<?php
session_start();

// Zniszczenie sesji i przekierowanie do strony logowania
session_destroy();
header("Location: login.php");
exit();
?>

