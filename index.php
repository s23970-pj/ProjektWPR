<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


if (isset($_POST["submit"])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    if (!empty($startTime) && !empty($endTime) && $startTime >= $endTime) {
        echo "Godzina zakończenia powinna być późniejsza niż godzina rozpoczęcia.";
    } else {
        $query = "INSERT INTO reservations (first_name, last_name, reservation_date, start_time, end_time)
                  VALUES ('$firstName', '$lastName', '$date', '$startTime', '$endTime')";
        mysqli_query($con, $query);

        header("Location: index.php");
        exit();
    }
}


if (isset($_POST["delete"])) {
    $reservationId = $_POST['reservationId'];

    $query = "DELETE FROM reservations WHERE id='$reservationId'";
    mysqli_query($con, $query);

    header("Location: index.php");
    exit();
}

// Pobranie rezerwacji z bazy danych
$query2 = "SELECT * FROM reservations";
$result = mysqli_query($con, $query2);

// Zapisanie rezerwacji do tablicy
$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}
?>

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
    <input type="text" name="firstName" id="firstName" required><br><br>

    <label for="lastName">Nazwisko:</label>
    <input type="text" id="lastName" name="lastName" value="" required><br><br>

    <label for="date">Data rezerwacji:</label>
    <input type="date" id="date" name="date" value="" required><br><br>

    <label for="startTime">Godzina rozpoczęcia:</label>
    <input type="time" id="startTime" name="startTime" value="" required><br><br>

    <label for="endTime">Godzina zakończenia:</label>
    <input type="time" id="endTime" name="endTime" value="" required><br><br>

    <input type="submit" name="submit" value="Dodaj rezerwację">
</form>

<h2>Lista rezerwacji</h2>
<table>
    <tr>
        <th>ID Rezerwacji</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Data rezerwacji</th>
        <th>Godzina rozpoczęcia</th>
        <th>Godzina zakończenia</th>
        <th>Akcje</th>
    </tr>
    <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?php echo $reservation['id']; ?></td>
            <td><?php echo $reservation['first_name']; ?></td>
            <td><?php echo $reservation['last_name']; ?></td>
            <td><?php echo $reservation['reservation_date']; ?></td>
            <td><?php echo $reservation['start_time']; ?></td>
            <td><?php echo $reservation['end_time']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="reservationId" value="<?php echo $reservation['id']; ?>">
                    <input type="submit" name="delete" value="Usuń">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<form method="post" action="logout.php">
    <input type="submit" name="logout" value="Wyloguj">
</form>
</body>
</html>
