<?php include '../defolt/header.php'; ?>

<main>
<?php
if (isSessionActive()) {
    header('Location: LogOut.php');
} else {
    header('Location: login.php');
}
?>
</main>

<?php include '../defolt/footer.php'; ?>