<?php include '../defolt/header.php'; ?>

<main>
	<h2>Экспорт в файл CSV</h2>
	<form action="export.php" method="post">
		<label for="filename">Введите название файла (без расширения):</label><br>
		<input type="text" id="filename" name="filename" required><br><br>
		<input type="submit" value="EXPORT">
	</form>
	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Получаем данные из формы
		$filename = $_POST['filename'];

		// Подключение к базе данных
		$pdo = connectToDatabase();
		$filePath = 'files/' . $filename . ".csv";
		// Получение директории из пути к файлу
		$directory = dirname($filePath);

		// Проверка существования и доступности для записи директории
		if (is_dir($directory) && is_writable($directory)) {
			try {
				if (exportMultipleTablesToCsv($pdo, $filePath)) {
					echo 'Данные успешно экспортированы в CSV файл';
				}
			} catch (Exception $e) {
				echo 'Ошибка: ' . $e->getMessage();
			}
		} else {
			echo 'Некорректный путь к файлу или нет прав на запись';
		}
		// Экспорт данных в CSV файл
	


		// Отключение от базы данных
		disconnectFromDatabase($pdo);
	}
	?>
</main>
<?php include '../defolt/footer.php'; ?>