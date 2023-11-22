<?php include '../defolt/header.php'; ?>

<main class="auth">
	<?php
	$error = "Defoult";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['guest'])) {
			createSession('guest_' . uniqid(), 'Гость');
			header('Location: ../index.php');
			exit;
		} else {
			$email = $_POST['email'];
			$password = $_POST['password'];
			$conn = connectToDatabase();
			$query = "SELECT * FROM user_data WHERE email = '$email'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$user = $result->fetch_assoc();
				if (password_verify($password, $user['password'])) {
					createSession($user['id'], $user['full_name']);
					header("Location: index.php");
					exit;
				} else {
					$error = "Неверный пароль";
				}
			} else {
				$error = "Логин не найден в системе";
			}
		}
	}

	if (isset($error)) {
		header("Location: login.php?error=" . urlencode($error));
		exit;
	}
	?>
</main>

<?php include '../defolt/footer.php'; ?>