<?php include 'includes/header.php'; ?>

<main class="main">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
    </style>
    <a href="Filter.php">Фильтр</a>
    <?php
    $user = 'root';
    $password = 'root';
    $db = 'restaurant';
    $host = 'localhost';
    $port = 3306;

    $link = mysqli_init();
    $success = mysqli_real_connect(
        $link,
        $host,
        $user,
        $password,
        $db,
        $port
    );

    if (!$success) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    // Получение данных из таблицы "Dish"
    $sql = "SELECT * FROM Dish";

    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Блюда:</h2>";
        echo "<div class='container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["Id"];
            $name = $row["Name"];
            $photo = $row["Photo"];
            $composition = $row["Composition"];
            $weight = $row["Weight"];
            $menuId = $row["Menu_id"];

            // Retrieve the menu name from the Menu table using $menuId
            $menuSql = "SELECT Name FROM menu WHERE id = $menuId";
            $menuResult = mysqli_query($link, $menuSql);

            if ($menuRow = mysqli_fetch_assoc($menuResult)) {
                $menuName = $menuRow["Name"];

                // Pass the menu name to the Card.php file
                include 'includes/Card.php';
            }
        }
        echo '</div>';
    } else {
        echo "Нет данных в таблице Dish";
    }

    // Закрытие соединения
    mysqli_close($link);
    ?>

</main>

<?php include 'includes/footer.php'; ?>