<?php include '../defolt/header.php'; ?>

<main>

	<h2>Выберите файл из папки</h2>
	<form action="import.php" method="post">
		<label for="files">Выберите файл:</label><br>
		<select id="files" name="selectedFile">
			<?php
			$files = array_diff(scandir('files/'), array('..', '.'));
			foreach ($files as $file) {
				echo "<option value='localhost/LR5/files/$file'>$file</option>";
			}
			?>
		</select><br><br>
		<input type="submit" value="Выбрать">
	</form>
	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$selectedFile = $_POST['selectedFile'];

		// if (CorrectCheck($selectedFile)) {
		// 	$fileData = readFromFile($selectedFile);
		// 	echo "<h2>Содержимое файла $selectedFile:</h2>";
		// 	echo "<pre>$fileData</pre>";
		// 	try {
		// 		importCsvDataToTable($pdo, $selectedFile);
		// 		echo "Данные успешно импортированы из CSV файла в базу данных.";
		// 	} catch (Exception $e) {
		// 		echo "Ошибка: " . $e->getMessage();
		// 	}
		// } else {
		// 	echo "файл не прошел проверку";
		// }
		try {
			$tableDate = readTableDataFromCsv($selectedFile);
			echo "<pre>$tableData</pre>";
		} catch (Exception $e) {
			echo "Ошибка: " . $e->getMessage();
		}



	}
	?>

</main>
<?php include '../defolt/footer.php'; ?>