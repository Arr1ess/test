<?php
function endSession()
{
    session_start();
    $_SESSION = array();
    session_destroy();
}

function isSessionActive()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return false;
    }

    session_start();
    return !empty($_SESSION);
}

function createSession($user_id, $username)
{
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
}

function connectToDatabase()
{
    $user = 'root';
    $password = 'root';
    $db = 'restaurant';
    $host = 'localhost';
    $port = 3306;
    $conn = new mysqli($host, $user, $password, $db, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function disconnectFromDatabase($conn)
{
    $conn->close();
}

function validatePassword($password)
{
    // Длина пароля должна быть больше 6 символов
    if (strlen($password) < 6) {
        return false;
    }

    // Проверка наличия больших латинских букв
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Проверка наличия маленьких латинских букв
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Проверка наличия спецсимволов, пробела, дефиса, подчеркивания и цифр
    if (!preg_match('/[!@#\$%\^&\*\(\)\-_\+=\[\]\{\}\\\|;:\'",<>\.\?\/\d]/', $password)) {
        return false;
    }

    // Проверка отсутствия русских букв
    if (preg_match('/[а-яА-Я]/u', $password)) {
        return false;
    }

    return true;
}
?>