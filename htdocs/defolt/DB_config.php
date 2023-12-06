<?php
function executeQuery($pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertData($pdo, $tableName, $data)
{
    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));
    $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function updateData($pdo, $tableName, $data, $condition)
{
    $setValues = [];
    foreach ($data as $key => $value) {
        $setValues[] = "$key=:$key";
    }
    $setValues = implode(", ", $setValues);
    $sql = "UPDATE $tableName SET $setValues WHERE $condition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function deleteData($pdo, $tableName, $condition)
{
    $sql = "DELETE FROM $tableName WHERE $condition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function exportMultipleTablesToCsv($pdo, $filePath)
{
    try {
        // Проверка существования таблиц
        $stmtCheckDish = $pdo->query("SELECT 1 FROM dish LIMIT 1");
        $stmtCheckMenu = $pdo->query("SELECT 1 FROM menu LIMIT 1");

        if ($stmtCheckDish->columnCount() == 0 || $stmtCheckMenu->columnCount() == 0) {
            throw new Exception("Таблицы dish и/или menu не существуют в базе данных");
        }

        // Экспорт данных
        $file = fopen($filePath, 'w');
        if (!$file) {
            throw new Exception("Не удалось открыть файл $filePath для записи");
        }

        // Запись данных из таблицы "dish"
        fwrite($file, "Table: dish\n");
        $sqlDish = "SELECT * FROM dish";
        $stmtDish = $pdo->query($sqlDish);
        $headerWritten = false;
        while ($rowDish = $stmtDish->fetch(PDO::FETCH_ASSOC)) {
            if (!$headerWritten) {
                fputcsv($file, array_keys($rowDish));
                $headerWritten = true;
            }
            fputcsv($file, $rowDish);
        }

        // Разделение между таблицами
        fwrite($file, "\n");

        // Запись данных из таблицы "menu"
        fwrite($file, "Table: menu\n");
        $sqlMenu = "SELECT * FROM menu";
        $stmtMenu = $pdo->query($sqlMenu);
        $headerWritten = false;
        while ($rowMenu = $stmtMenu->fetch(PDO::FETCH_ASSOC)) {
            if (!$headerWritten) {
                fputcsv($file, array_keys($rowMenu));
                $headerWritten = true;
            }
            fputcsv($file, $rowMenu);
        }

        fclose($file);
        return true;
    } catch (Exception $e) {
        throw new Exception("Ошибка при экспорте данных: " . $e->getMessage());
    }
}

function getFileContentFromUrl($fileUrl)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fileUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $fileContent = curl_exec($ch);
    if ($fileContent === false) {
        throw new Exception("Ошибка при чтении файла по адресу $fileUrl: " . curl_error($ch));
    }
    curl_close($ch);
    return $fileContent;
}

function readTableDataFromCsv($filePath)
{
    try {
        if (!file_exists($filePath)) {
            throw new Exception("Файл $filePath не существует");
        }

        $file = fopen($filePath, 'r');
        if (!$file) {
            throw new Exception("Не удалось открыть файл $filePath для чтения");
        }

        $tableData = [];
        $currentTable = '';
        $row = 0;

        while ($rowData = fgetcsv($file)) {
            // Пропускаем строку с заголовками таблицы
            if ($row === 0) {
                $row++;
                continue;
            }

            if (empty($rowData)) {
                // Пустая строка - разделитель между таблицами
                $currentTable = '';
            } else {
                if (empty($currentTable)) {
                    // Запись имени таблицы для текущей порции данных
                    $currentTable = str_replace('Table: ', '', $rowData[0]);
                } else {
                    // Добавление данных в массив с учетом имени таблицы
                    $tableData[$currentTable][] = $rowData;
                }
            }
            $row++;
        }

        fclose($file);

        return $tableData;
    } catch (Exception $e) {
        throw new Exception("Ошибка при чтении данных из файла: " . $e->getMessage());
    }
}

function processCsvData($pdo, $tableName, $data)
{
    try {
        if ($tableName === 'dish') {
            $stmt = $pdo->prepare("REPLACE INTO dish (Id, Name, Photo, Composition, Weight, Menu_id) VALUES (?, ?, ?, ?, ?, ?)");
        } elseif ($tableName === 'menu') {
            $stmt = $pdo->prepare("REPLACE INTO menu (id, Name) VALUES (?, ?)");
        }
        $stmt->execute($data);
    } catch (Exception $e) {
        throw new Exception("Ошибка при обработке данных для таблицы $tableName: " . $e->getMessage());
    }
}

function importCsvDataToTable($pdo, $fileUrl)
{
    try {
        $fileContent = getFileContentFromUrl($fileUrl);
        if ($fileContent === false) {
            throw new Exception("Не удалось получить содержимое файла");
        }
        $stream = fopen('php://memory', 'r+');
        if ($stream === false) {
            throw new Exception("Не удалось открыть поток данных");
        }
        fwrite($stream, $fileContent);
        rewind($stream);

        $pdo->beginTransaction(); // Начинаем транзакцию
        while (($data = fgetcsv($stream)) !== false) {
            if (strpos($data[0], "Table: dish") !== false) {
                processCsvData($pdo, 'dish', array_slice($data, 1)); // Первый элемент содержит "Table: dish", поэтому пропускаем его
            } elseif (strpos($data[0], "Table: menu") !== false) {
                processCsvData($pdo, 'menu', array_slice($data, 1)); // Первый элемент содержит "Table: menu", поэтому пропускаем его
            }
        }
        $pdo->commit(); // Фиксируем изменения в базе данных
    } catch (Exception $e) {
        throw new Exception("Ошибка при импорте данных из CSV файла по адресу $fileUrl: " . $e->getMessage());
    } finally {
        if ($stream) {
            fclose($stream);
        }
    }
}


function addNewRecord($pdo, $tableName, $data)
{
    // Проверяем, что $data не пустой
    if (empty($data)) {
        throw new Exception('Добавление пустых данных невозможно');
    }

    // Формируем запрос для добавления записи
    $fields = implode(', ', array_keys($data));
    $values = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO $tableName ($fields) VALUES ($values)";

    // Подготавливаем запрос
    $stmt = $pdo->prepare($sql);

    // Проверяем, что запрос был корректно подготовлен
    if (!$stmt) {
        throw new Exception('Ошибка подготовки запроса');
    }

    // Выполняем запрос с данными, передавая значения параметров в execute
    $success = $stmt->execute(array_values($data));

    // Проверяем, что выполнение запроса прошло успешно
    if (!$success) {
        throw new Exception('Ошибка выполнения запроса');
    }
}


?>