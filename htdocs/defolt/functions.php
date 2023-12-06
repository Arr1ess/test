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
function readFromFile(string $fileUrl): string
{
    // Инициализация cURL сессии
    $ch = curl_init();

    // Устанавливаем параметры запроса
    curl_setopt($ch, CURLOPT_URL, $fileUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Выполняем запрос и сохраняем полученное содержимое
    $fileContent = curl_exec($ch);

    // Закрываем cURL сессию
    curl_close($ch);

    if ($fileContent === false) {
        // Обработка ошибки, если не удалось получить данные
        return "Ошибка при чтении файла";
    } else {
        // Возвращаем содержимое файла
        return $fileContent;
    }
}
function saveToCsv(array $data, string $filename): bool
{
    $filePath = 'files/' . $filename;
    $file = fopen($filePath, 'w');

    if ($file === false) {
        // Обработка ошибки, если не удалось открыть файл
        return false;
    }

    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    return true;
}

function CorrectCheck(string $filename): bool {
    $allowedFormats = array('csv'); // Разрешенные форматы

    // Проверка формата файла
    $fileInfo = pathinfo($filename);
    if (!in_array(strtolower($fileInfo['extension']), $allowedFormats)) {
        return false; // Формат файла не соответствует разрешенным
    }

    // Проверка наличия файла
    // $filePath = 'files/' . $filename;
    // if (!file_exists($filePath)) {
    //     return false; // Файл не существует
    // }

    // Дополнительные проверки безопасности
    // Например, проверка контента на соответствие ожидаемой структуре

    return true; // Все проверки пройдены успешно
}


function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
  }
  
  function make_upload($file){	
	// формируем уникальное имя картинки: случайное число и name
	$name = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], '../IMG/' . $name);
  }

?>