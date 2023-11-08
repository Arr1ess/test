<?php include '../defolt/header.php'; ?>



<main class="auth">
	<form class="auth__form auth__form--login" style="background-color: #e6e6e6; padding: 20px; margin: 20px;"
		method="post" action="login.php">
		<input type="text" class="auth__input form-control" name="email" id="email" placeholder="Email or Username"
			style="margin-bottom: 10px;">
		<input type="password" class="auth__input form-control" name="password" id="password" placeholder="Password"
			style="margin-bottom: 10px;">
		<button class="auth__guest-button" type="submit" name="guest" style="margin-bottom: 10px;">Continue as
			Guest</button>
		<button class="auth__submit-button" type="submit" style="margin-bottom: 10px;">Войти</button>
		<a href="registration.php" class="btn btn-secondary" style="margin-top: 10px;">Create an account</a>
	</form>
</main>

<?php
// Подключение к базе данных
function connectDatabase()
{
	$db_host = 'localhost';
	$db_user = 'your_username';
	$db_pass = 'your_password';
	$db_name = 'your_db_name';
	return new mysqli($db_host, $db_user, $db_pass, $db_name);
}

// Создание сессии
function createSession($user_id, $username)
{
	session_start();
	$_SESSION['user_id'] = $user_id;
	$_SESSION['username'] = $username;
}

// Обработка входных данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['guest'])) {
		// Для гостя создаем сессию
		createSession('guest_' . uniqid(), 'Гость');

		// Редирект на главную страницу
		header("Location: ../index.php");
		exit;
	} else {
		$email = $_POST['email'];
		$password = $_POST['password'];

		// Поиск пользователя в базе данных
		$conn = connectDatabase();
		$query = "SELECT * FROM users WHERE email = '$email'";
		$result = $conn->query($query);

		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			// Проверка пароля
			if (password_verify($password, $user['password'])) {
				// Создаем сессию для пользователя
				createSession($user['id'], $user['username']);

				// Редирект на главную страницу
				header("Location: index.php");
				exit;
			} else {
				$error = "Неверный пароль";
			}
		} else {
			$error = "Логина нет в системе";
		}
	}
}

// Вывод ошибок
if (isset($error)) {
	echo $error;
}
?>

<?php include '../defolt/footer.php'; ?>