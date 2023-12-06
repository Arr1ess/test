<?php
function connectToDatabase()
{
	$host = 'localhost';
	$db = 'restaurant';
	$user = 'root';
	$password = 'root';

	try {
		$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
}

function disconnectFromDatabase($pdo)
{
	$pdo = null;
}
?>

<?php include '../DB_management/DishTable.php'; ?>