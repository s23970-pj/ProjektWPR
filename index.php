<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Formularz rezerwacji</title>
</head>
<body>
<h1>Formularz rezerwacji</h1>
<form method="post">
    <label for="firstName">Imię:</label>
    <input type="text" name="firstName" id="firstName" required><BR><br>

    <label for="lastName">Nazwisko:</label>
    <input type="text" id="lastName" name="lastName" value="" required><br><br>

    <label for="date">Data rezerwacji:</label>
    <input type="date" id="date" name="date" value="" required><br><br>

    <label for="startTime">Godzina rozpoczęcia:</label>
    <input type="time" id="startTime" name="startTime" value="" required><br><br>

    <label for="endTime">Godzina zakończenia:</label>
    <input type="time" id="endTime" name="endTime" value="" required><br><br>

    <input type="submit" name="submit" value="submit">
</form>

<?php
session_start();
require_once 'db_connection.php'; // Plik zawierający połączenie z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
//obsluga formularza
if (isset($_POST["submit"])) {
    $firstName = $_POST['firstName'];
    $lastName=$_POST['lastName'];
    $date=$_POST['date'];
    $startTime=$_POST['startTime'];
    $endTime=$_POST['endTime'];

    print_r($startTime);
  if (!empty($startTime) && !empty($endTime) && $startTime >= $endTime) {
    echo "Godzina zakończenia powinna być późniejsza niż godzina rozpoczęcia.";
  } else
  {
      // Zapisanie rezerwacji do bazy danych
      $query = "INSERT INTO reservations (first_name, last_name, reservation_date, start_time, end_time)
                  VALUES ('$firstName', '$lastName', '$date', '$startTime', '$endTime')";
      mysqli_query($conn, $query);

      // Przekierowanie na stronę index.php po zapisaniu rezerwacji
      header("Location: index.php");
      exit();
  }
    // Pobranie rezerwacji z bazy danych
    $query = "SELECT * FROM reservations";
    $result = mysqli_query($conn, $query);

// Zapisanie rezerwacji do tablicy
    $reservations = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = $row;
    }
    print_r($reservations);
}

?>

<h2>Lista rezerwacji</h2>
<table>
    <tr>
        <th>ID Rezerwacji</th>
        <th>Data rezerwacji</th>
        <th>Godzina rozpoczęcia</th>
        <th>Godzina zakończenia</th>
    </tr>
</table>

<form method="post" action="logout.php">
    <input type="submit" name="logout" value="Wyloguj">
</form>
</body>
</html>

<!-- wyswietlanie rezerwacji w schludnej formie, dodaj na db, id rezerwacji, -->