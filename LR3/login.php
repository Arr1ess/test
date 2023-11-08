

<?php include '../defolt/header.php'; ?>



<main class="auth">
	<form class="auth__form auth__form--login" style="background-color: #e6e6e6; padding: 20px; margin: 20px;">
		<input type="text" class="auth__input form-control" id="email" placeholder="Email or Username"
			style="margin-bottom: 10px;">
		<input type="password" class="auth__input form-control" id="password" placeholder="Password"
			style="margin-bottom: 10px;">
		<button class="auth__guest-button" style="margin-bottom: 10px;">Continue as Guest</button>
		<a href="registration.php" class="btn btn-secondary" style="margin-top: 10px;">Create an account</a>
	</form>
</main>




<?php include '../defolt/footer.php'; ?>