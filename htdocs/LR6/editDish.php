<?php include '../defolt/header.php'; ?>
<?php
$pdo = connectToDatabase();
$dishTable = new DishTable($pdo);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(isset($_POST['submit'])) {
		$id = $_POST['id'];
		$data = array(
			'Name' => $_POST['name'],
			'Composition' => $_POST['composition'],
			'Weight' => $_POST['weight'],
			'Menu_id' => $_POST['menuId']
		);
		try {
			if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
				$photoName = $_FILES['photo']['name'];
				$photoTmp = $_FILES['photo']['tmp_name'];
				// Перемещаем загруженный файл в нужную директорию
				if(!move_uploaded_file($photoTmp, '../IMG/'.$photoName)) {
					throw new Exception('Не удалось загрузить фото блюда');
				}
				$data['Photo'] = $photoName; // Обновляем имя файла в массиве $data
			}
			$dishTable->updateDish($id, $data);
			$result = "Блюдо успешно обновлено: $id";
			header('Location: adminDish.php?success='.urlencode($result));
			exit;
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
	$id = $_POST['id'];
	$dish = $dishTable->getDishById($id);
}

?>
<main>
	<h1>Редактирование блюда</h1>
	<!-- Всплывающее сообщение об успешном действии, если таковое имеется -->
	<?php if(isset($result)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $result; ?>
		</div>
	<?php endif; ?>
	<!-- Всплывающее сообщение об ошибке, если таковая имеется -->
	<?php if(isset($error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $error; ?>
		</div>
	<?php endif; ?>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $dish['Id'] ?>">
		<div class="mb-3">
			<label for="name" class="form-label">Название</label>
			<input type="text" class="form-control" id="name" name="name" value="<?= $dish['Name'] ?>">
		</div>
		<div class="mb-3">
			<label for="photo" class="form-label">Фото</label>
			<input type="file" class="form-control" id="photo" name="photo" value="<?= $dish['Photo'] ?>">
		</div>
		<div class="mb-3">
			<label for="composition" class="form-label">Состав</label>
			<input type="text" class="form-control" id="composition" name="composition" value="<?= $dish['Composition'] ?>">
		</div>
		<div class="mb-3">
			<label for="weight" class="form-label">Вес</label>
			<input type="number" class="form-control" id="weight" name="weight" value="<?= $dish['Weight'] ?>">
		</div>
		<div class="mb-3">
			<label for="menuId" class="form-label">ID Меню</label>
			<input type="number" class="form-control" id="menuId" name="menuId" value="<?= $dish['Menu_id'] ?>">
		</div>
		<button type="submit" class="btn btn-primary" name="submit">Сохранить изменения</button>
	</form>
</main>

<?php disconnectFromDatabase($pdo) ?>

<?php include '../defolt/footer.php'; ?>