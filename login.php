<?php
session_start();

// Sprawdzenie, czy użytkownik jest już zalogowany
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

// Sprawdzenie, czy formularz logowania został wysłany
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sprawdzenie poprawności danych logowania
    if ($username === 'admin' && $password === 'admin123') {
        // Ustawienie flagi zalogowanego użytkownika
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        echo "Nieprawidłowe dane logowania.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
</head>
<body>
<h1>Logowanie</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Użytkownik:</label>
    <input type="text" name="username" id="username" required><br><br>

    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password" required><br><br>

    <input type="submit" name="submit" value="Zaloguj">
</form>
</body>
</html>

