<?php
$user = 'root';
$password = 'root';
$db = 'restaurant';
$host = 'localhost';
$port = 3306;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);

if (!$success) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>