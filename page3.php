<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Заявки на ногточки</title>
</head>
<body>
    <main class="container">
        <h2>Мои заявки</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Услуга</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['service']); ?></td>
                        <td><?php echo htmlspecialchars($request['date']); ?></td>
                        <td><?php echo htmlspecialchars($request['time']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Создать новую заявку</h3>
        <form method="post" action="requests.php" class="p-4 shadow-sm rounded bg-white">
            <div class="mb-3">
                <label for="service" class="form-label">Услуга:</label>
                <input type="text" id="service" name="service" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Дата:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for
<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: page1.php"); // Перенаправление на страницу авторизации
    exit();
}

// Подключение к базе данных
$dbConnection = new mysqli("localhost", "username", "password", "database");

// Проверка соединения
if ($dbConnection->connect_error) {
    die("Ошибка подключения: " . $dbConnection->connect_error);
}

// Получение заявок пользователя
$userId = $_SESSION['user_id']; // Предполагается, что ID пользователя хранится в сессии
$sql = "SELECT * FROM requests WHERE user_id = ?";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$requests = $result->fetch_all(MYSQLI_ASSOC);

// Создание новой заявки
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    $insertSql = "INSERT INTO requests (user_id, service, date, time, status) VALUES (?, ?, ?, ?, 'Новая')";
    $insertStmt = $dbConnection->prepare($insertSql);
    $insertStmt->bind_param("isss", $userId, $service, $date, $time);
    
    if ($insertStmt->execute()) {
        header("Location: requests.php"); // Перезагрузка страницы для отображения обновленного списка заявок
        exit();
    } else {
        echo "Ошибка: " . $insertStmt->error;
    }
    $insertStmt->close();
}

$stmt->close();
$dbConnection->close();
?>