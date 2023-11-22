<?php include '../defolt/header.php'; ?>

<main>
    <div class="logout-button">
        <form method="post"> <!-- Исправляем action на method="post" -->
            <input type="submit" name="logout" value="Выйти"> <!-- Добавляем name="logout" -->
        </form>
    </div>
</main>

<?php

if (isset($_POST['logout'])) {
    endSession();
    header('Location: index.php');
    exit;
}
?>

<?php include '../defolt/footer.php'; ?>