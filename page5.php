<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Панель администратора</title>
</head>
<body>
    <main class="container">
        <h2>Все заявки</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Выбранный мастер</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['phone']); ?></td>
                        <td><?php echo htmlspecialchars($request['date']); ?></td>
                        <td><?php echo htmlspecialchars($request['time']); ?></td>
                        <td><?php echo htmlspecialchars($request['master']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                        <td>
                            <form method="post" action="page5.php">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="Новое" <?php if ($request['status'] === 'Новое') echo 'selected'; ?>>Новое</option>
                                    <option value="Подтверждено" <?php if ($request['status'] === 'Подтверждено') echo 'selected'; ?>>Подтверждено</option>
                                    <option value="Отклонено" <?php if ($request['status'] === 'Отклонено') echo 'selected'; ?>>Отклонено</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="page1.php" class="btn btn-logout">Выход</a>
    </main>
</body>
</html>
<?php
// Подключение к базе данных (замените на свои данные)
$dbConnection = new mysqli("localhost", "username", "password", "database");

// Проверка соединения
if ($dbConnection->connect_error) {
    die("Ошибка подключения: " . $dbConnection->connect_error);
}

// Получение всех заявок
$sql = "SELECT * FROM requests";
$result = $dbConnection->query($sql);
$requests = $result->fetch_all(MYSQLI_ASSOC);

// Изменение статуса заявки
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['status'])) {
    $requestId = $_POST['request_id'];
    $status = $_POST['status'];
    $updateSql = "UPDATE requests SET status = ? WHERE id = ?";
    $updateStmt = $dbConnection->prepare($updateSql);
    $updateStmt->bind_param("si", $status, $requestId);
    $updateStmt->execute();
    header("Location: page5.php"); // Перезагрузка страницы для отображения обновленного списка заявок
    exit();
}

// Закрытие соединения
$dbConnection->close();
?>