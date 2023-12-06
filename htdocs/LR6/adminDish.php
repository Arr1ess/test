<?php include '../defolt/header.php'; ?>
<?php
$pdo = connectToDatabase();
$dishTable = new DishTable($pdo);
$dishes = $dishTable->getAllDishes();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(isset($_POST['delete'])) {
		$result = '';
		$id = $_POST['id'];
		try {
			$dishTable->deleteDish($id);
			$result = "Блюдо успешно удалено: $id";
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		header('Location: adminDish.php'.($result ? '?success='.urlencode($result) : ''));
		exit;
	}
}
?>

<main>
	<h1>Управление блюдами</h1>
	<?php if(isset($_GET['success'])): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $_GET['success']; ?>
		</div>
	<?php endif; ?>
	<?php if(isset($_GET['error'])): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $_GET['error']; ?>
		</div>
	<?php endif; ?>
	<div class="table-responsive">
		<table class="table table-striped" id="dishTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Название</th>
					<th>Фото</th>
					<th>Состав</th>
					<th>Вес</th>
					<th>ID Меню</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($dishes as $dish): ?>
					<tr>
						<td>
							<?= $dish['Id'] ?>
						</td>
						<td>
							<?= $dish['Name'] ?>
						</td>
						<td>
							<div class="image-container">
								<img class="responsive-image" src="../IMG/<?= $dish['Photo'] ?>" alt="фото">
							</div>
						</td>
						<td>
							<?= $dish['Composition'] ?>
						</td>
						<td>
							<?= $dish['Weight'] ?>
						</td>
						<td>
							<?= $dish['Menu_id'] ?>
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="id" value="<?= $dish['Id'] ?>">
								<button type="submit" name="edit" formaction="editDish.php" formmethod="post">Edit</button>
								<button type="submit" name="delete">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<h2>Добавить новое блюдо</h2>
	<form action="processNewDish.php" method="post" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="name" class="form-label">Название</label>
			<input type="text" class="form-control" id="name" name="name">
		</div>
		<div class="mb-3">
			<label for="photo" class="form-label">Фото</label>
			<input type="file" class="form-control" id="photo" name="photo">
		</div>
		<div class="mb-3">
			<label for="composition" class="form-label">Состав</label>
			<input type="text" class="form-control" id="composition" name="composition">
		</div>
		<div class="mb-3">
			<label for="weight" class="form-label">Вес</label>
			<input type="number" class="form-control" id="weight" name="weight">
		</div>
		<div class="mb-3">
			<label for="menuId" class="form-label">ID Меню</label>
			<input type="number" class="form-control" id="menuId" name="menuId">
		</div>
		<button type="submit" class="btn btn-primary">Добавить</button>
	</form>
</main>

<?php disconnectFromDatabase($pdo) ?>

<?php include '../defolt/footer.php'; ?>

<style>
	.image-container {
		max-width: 100px;
		height: 100px;
	}

	.responsive-image {
		max-width: 100%;
		height: auto;
	}
</style>