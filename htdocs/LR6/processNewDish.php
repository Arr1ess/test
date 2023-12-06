<?php
include '../DB_management/index.php';

// Создаем объект класса DishTable
$dishTable = new DishTable(connectToDatabase());

// Обработка данных из формы и добавление нового блюда
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
		$name = $_POST['name'];
		if (empty($name)) {
			throw new Exception('Название блюда не может быть пустым');
		}
		$photo = $_FILES['photo'];
		

		$composition = $_POST['composition'];
		$weight = $_POST['weight'];
		$menuId = $_POST['menuId'];

		// Добавление блюда
		$dishTable->addDish($name, $photo, $composition, $weight, $menuId);

		// Перенаправляем пользователя обратно на страницу управления блюдами
		header('Location: adminDish.php?success=' . urlencode("Данные успешно добавлены"));
		exit;
	} catch (Exception $e) {
		// В случае возникновения ошибки, перенаправляем пользователя обратно на страницу управления блюдами с сообщением об ошибке
		header('Location: adminDish.php?error=' . urlencode($e->getMessage()));
		exit;
	}
}

?>