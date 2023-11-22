<?php
require_once '../defolt/header.php';

// Получение ошибки, если она есть
$error = $_GET['error'] ?? '';

// Получение данных из предыдущей отправки формы, если они были отправлены
$full_name = $_POST['full-name'] ?? '';
$email = $_POST['email'] ?? '';
$birth_date = $_POST['birth-date'] ?? '';
$address = $_POST['address'] ?? '';
$gender = $_POST['gender'] ?? 'male'; // Пол по умолчанию
$interests = $_POST['interests'] ?? '';
$vk_profile = $_POST['vk-profile'] ?? '';
$blood_group = $_POST['blood-group'] ?? '';
$rhesus_factor = $_POST['rhesus-factor'] ?? '';

?>

<main class="auth">
	<form method="post" action="process_registration.php" class="auth__form auth__form--registration"
		style="background-color: #f2f2f2; padding: 20px; margin: 20px;">
		<input type="text" class="auth__input form-control" id="full-name" name="full-name" placeholder="Full Name"
			value="<?php echo $full_name; ?>" style="margin-bottom: 10px;">
		<input type="email" class="auth__input form-control" id="email" name="email" placeholder="Email"
			value="<?php echo $email; ?>" style="margin-bottom: 10px;">
		<input type="password" class="auth__input form-control" id="password" name="password" placeholder="Password"
			style="margin-bottom: 10px;">
		<input type="date" class="auth__input form-control" id="birth-date" name="birth-date" placeholder="Date of Birth"
			value="<?php echo $birth_date; ?>" style="margin-bottom: 10px;">
		<input type="text" class="auth__input form-control" id="address" name="address" placeholder="Address"
			value="<?php echo $address; ?>" style="margin-bottom: 10px;">
		<select class="auth__input form-control" id="gender" name="gender" style="margin-bottom: 10px;">
			<option value="male" <?php if ($gender === 'male')
				echo 'selected'; ?>>Male</option>
			<option value="female" <?php if ($gender === 'female')
				echo 'selected'; ?>>Female</option>
		</select>
		<textarea class="auth__input form-control" id="interests" name="interests" placeholder="Interests"
			style="margin-bottom: 10px;"><?php echo $interests; ?></textarea>
		<input type="url" class="auth__input form-control" id="vk-profile" name="vk-profile" placeholder="VK Profile Link"
			value="<?php echo $vk_profile; ?>" style="margin-bottom: 10px;">
		<input type="text" class="auth__input form-control" id="blood-group" name="blood-group" placeholder="Blood Group"
			value="<?php echo $blood_group; ?>" style="margin-bottom: 10px;">
		<select class="auth__input form-control" id="rhesus-factor" name="rhesus-factor" style="margin-bottom: 10px;">
			<option value="positive" <?php if ($rhesus_factor === 'positive')
				echo 'selected'; ?>>Rh+</option>
			<option value="negative" <?php if ($rhesus_factor === 'negative')
				echo 'selected'; ?>>Rh-</option>
		</select>
		<button type="submit" class="btn btn-primary" style="margin-top: 10px;">Register</button>
	</form>
	<?php
	if ($error === 'password') {
		echo ("<p style='color:red;'>Пароль введен неверно</p>");
	}
	?>
</main>

<?php include '../defolt/footer.php'; ?>