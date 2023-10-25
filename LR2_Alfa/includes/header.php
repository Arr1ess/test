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
    <header>
        <style>
            .header {
                background-color: #333;
                padding: 10px;
            }

            .header__menu {
                display: flex;
                justify-content: space-around;
            }

            .header__link {
                color: #fff;
                text-decoration: none;
                margin-right: 10px;
            }

            h1 {
                text-align: center;
                margin-top: 50px;
            }
        </style>
        <header class="header">
            <nav class="header__menu">
                <a href="/LR2_Alfa/index.php" class="header__link">Главная</a>
                <a href="/LR2_Alfa/FilterList.php" class="header__link">Menu</a>
            </nav>
        </header>