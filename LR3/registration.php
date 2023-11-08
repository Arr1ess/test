<?php include '../defolt/header.php'; ?>

<main class="auth">
	<form class="auth__form auth__form--registration" style="background-color: #f2f2f2; padding: 20px; margin: 20px;">
		<input type="text" class="auth__input form-control" id="full-name" placeholder="Full Name"
			style="margin-bottom: 10px;">
		<input type="date" class="auth__input form-control" id="birth-date" placeholder="Date of Birth"
			style="margin-bottom: 10px;">
		<input type="text" class="auth__input form-control" id="address" placeholder="Address" style="margin-bottom: 10px;">
		<select class="auth__input form-control" id="gender" style="margin-bottom: 10px;">
			<option value="male">Male</option>
			<option value="female">Female</option>
		</select>
		<textarea class="auth__input form-control" id="interests" placeholder="Interests"
			style="margin-bottom: 10px;"></textarea>
		<input type="url" class="auth__input form-control" id="vk-profile" placeholder="VK Profile Link"
			style="margin-bottom: 10px;">
		<input type="text" class="auth__input form-control" id="blood-group" placeholder="Blood Group"
			style="margin-bottom: 10px;">
		<select class="auth__input form-control" id="rhesus-factor" style="margin-bottom: 10px;">
			<option value="positive">Rh+</option>
			<option value="negative">Rh-</option>
		</select>
		<a href="login.php" class="btn btn-primary" style="margin-top: 10px;">Already have an account? Sign in</a>
	</form>
</main>


<?php include '../defolt/footer.php'; ?>