<?php include '../defolt/header.php'; ?>
<main class="auth">
	<?php
	// Подключение к базе данных
	$conn = connectToDatabase();

	// Получение данных из формы
	$full_name = $_POST['full-name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Проверка правильности пароля
	if (!validatePassword($password)) {
		// Формирование массива данных и их сериализация
		$form_data = array(
			'full-name' => $_POST['full-name'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'birth-date' => isset($_POST['birth-date']) ? $_POST['birth-date'] : '',
			'address' => isset($_POST['address']) ? $_POST['address'] : '',
			'gender' => isset($_POST['gender']) ? $_POST['gender'] : 'male',
			'interests' => isset($_POST['interests']) ? $_POST['interests'] : '',
			'vk-profile' => isset($_POST['vk-profile']) ? $_POST['vk-profile'] : '',
			'blood-group' => isset($_POST['blood-group']) ? $_POST['blood-group'] : '',
			'rhesus-factor' => isset($_POST['rhesus-factor']) ? $_POST['rhesus-factor'] : ''
		);

		$form_data_string = http_build_query($form_data);

		// Перенаправление обратно на страницу регистрации с сохранением данных и сообщением об ошибке
		header("Location: registration.php?error=password&" . $form_data_string);
		exit;
	}

	// Хешируем пароль
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	// Установка значений по умолчанию для остальных полей
	$birth_date = isset($_POST['birth-date']) ? $_POST['birth-date'] : null;
	$address = isset($_POST['address']) ? $_POST['address'] : 'Not specified';
	$gender = isset($_POST['gender']) ? $_POST['gender'] : 'male';
	$interests = isset($_POST['interests']) ? $_POST['interests'] : 'Not specified';
	$vk_profile = isset($_POST['vk-profile']) ? $_POST['vk-profile'] : 'Not specified';
	$blood_group = isset($_POST['blood-group']) ? $_POST['blood-group'] : 'NULL';
	$rhesus_factor = isset($_POST['rhesus-factor']) ? $_POST['rhesus-factor'] : 'positive';

	// Подготавливаем и выполняем SQL запрос для добавления пользователя
	$stmt = $conn->prepare("INSERT INTO user_data 
    (full_name, email, password, address, gender, interests, vk_profile_url, blood_group, rhesus_factor) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssssss", $full_name, $email, $hashedPassword, $address, $gender, $interests, $vk_profile, $blood_group, $rhesus_factor);
	$stmt->execute();
	$stmt->close();

	// Перенаправляем пользователя на главную страницу
	header("Location: ../index.php");


	// Отключение от базы данных
	disconnectFromDatabase($conn);
	?>

</main>
<?php include '../defolt/footer.php'; ?>