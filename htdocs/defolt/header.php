<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>Твой сайт</title>
</head>

<body>
    <style>
        html,
        body {
            height: 100%;
        }

        main {
            flex-grow: 1;
        }

        .container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }
    </style>
    <div class="container">
        <header class="header bg-dark">
            <nav class="header__menu navbar navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="/index.php">Главная</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/LR1/">LR1</a></li>
                        <li class="nav-item"><a class="nav-link" href="/LR2/">LR2</a></li>
                        <li class="nav-item"><a class="nav-link" href="/LR3/">LR3</a></li>
                    </ul>
                </div>

                <?php
                // Начать сессию
                session_start();

                // Проверить, авторизован ли пользователь
                if (isset($_SESSION['username'])) {
                    // Показать имя пользователя и ссылку "Выход"
                    echo "<a href = ''> Добро пожаловать, " . $_SESSION['username'] . "! </a>";

                } else {
                    // Если пользователь не авторизован, показать ссылку на страницу авторизации
                    echo '<a href="../LR3/login.php">Войти</a>';
                }
                ?>
            </nav>
        </header>