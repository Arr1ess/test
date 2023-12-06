<?php
class DishTable {
	private $pdo;
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	public function addDish($name, $photo, $composition = 'No composition', $weight = 100, $menuId = 1) {
		if(empty($name)) {
			throw new Exception('Название блюда не может быть пустым');
		}
		if($weight <= 0) {
			throw new Exception('Вес должен быть положительным числом');
		}
		if(isset($photo) && $photo['error'] === UPLOAD_ERR_OK) {
			$photoName = $photo['name'];
			$photo_tmp = $photo['tmp_name'];
			move_uploaded_file($photo_tmp, '../IMG/'.$photoName);
		} else {
			throw new Exception('Не удалось загрузить фото блюда');
		}
		$sql = "INSERT INTO dish (Name, Photo, Composition, Weight, Menu_id) VALUES (:name, :photo, :composition, :weight, :menuId)";
		$statement = $this->pdo->prepare($sql);
		$success = $statement->execute([
			':name' => $name,
			':photo' => $photoName,
			':composition' => $composition,
			':weight' => $weight,
			':menuId' => $menuId
		]);
		if(!$success) {
			throw new Exception('Ошибка при добавлении блюда в базу данных');
		}
	}
	public function updateDish($id, $data) {
		$fields = implode('=?, ', array_keys($data)).'=?';
		$sql = "UPDATE dish SET $fields WHERE id = ?";
		$values = array_values($data);
		$values[] = $id;
		$statement = $this->pdo->prepare($sql);
		if(!$statement) {
			throw new Exception('Ошибка подготовки запроса');
		}
		$success = $statement->execute($values);
		if(!$success) {
			throw new Exception('Ошибка при обновлении блюда в базе данных');
		}
	}
	public function getDishById($id) {
		$sql = "SELECT * FROM dish WHERE id = ?";
		$statement = $this->pdo->prepare($sql);
		if(!$statement) {
			throw new Exception('Ошибка подготовки запроса');
		}
		$success = $statement->execute([$id]);
		if(!$success) {
			throw new Exception('Ошибка выполнения запроса');
		}
		$dish = $statement->fetch(PDO::FETCH_ASSOC);
		if(!$dish) {
			throw new Exception('Блюдо с указанным id не найдено');
		}
		return $dish;
	}
	public function deleteDish($id) {
		$sql = "DELETE FROM dish WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		if(!$statement) {
			throw new Exception('Ошибка подготовки запроса');
		}
		$success = $statement->execute(['id' => $id]);
		if(!$success) {
			throw new Exception('Ошибка при удалении блюда из базы данных');
		}
		if($statement->rowCount() === 0) {
			throw new Exception('Запись не найдена');
		}
	}
	public function getAllDishes() {
		$sql = "SELECT * FROM dish";
		$statement = $this->pdo->query($sql);
		$dishes = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(!$dishes) {
			throw new Exception('Ошибка при получении данных о блюдах из базы данных');
		}
		return $dishes;
	}
}
?>