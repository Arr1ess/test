<?php include '../defolt/header.php'; ?>

<main>
	<h2>Управление файлами</h2>
	<form action="export.php" method="get">
		<input type="submit" value="Экспорт в файл CSV">
	</form>
	<form action="import.php" method="get">
		<input type="submit" value="Импорт из файла CSV">
	</form>

</main>
<?php include '../defolt/footer.php'; ?>