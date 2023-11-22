<?php include '../defolt/header.php'; ?>

<main class="auth">
    <form class="auth__form auth__form--login" method="post" action="process_login.php">
        <?php if (isset($_GET['error'])){
					echo "<div class='error'>" .  urldecode($_GET['error']) .  "</div>";
				}
        ?>
        <input type="text" class="auth__input form-control" name="email" id="email" placeholder="Email or Username" />
        <input type="password" class="auth__input form-control" name="password" id="password" placeholder="Password" />
        <button class="auth__guest-button" type="submit" name="guest">
            Continue as Guest
        </button>
        <button class="auth__submit-button" type="submit">Login</button>
        <a href="registration.php" class="auth__link">Create an account</a>
    </form>
</main>

<?php include '../defolt/footer.php'; ?>
