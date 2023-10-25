<?php include 'includes/header.php'; ?>

<main class="main">
    <form class="form" method="GET" action="FilterList.php">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="composition">Состав:</label>
            <input type="text" class="form-control" name="composition" id="composition">
        </div>
        <div class="form-group">
            <label for="weight">Вес:</label>
            <input type="text" class="form-control" name="weight" id="weight">
        </div>
        <button type="submit" class="btn btn-primary">Применить фильтр</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>