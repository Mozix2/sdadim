<?php
session_start();

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подключение к базе данных (замените на свои данные)
    $dbConnection = new mysqli("localhost", "username", "password", "database");

    // Проверка соединения
    if ($dbConnection->connect_error) {
        die("Ошибка подключения: " . $dbConnection->connect_error);
    }

    // Подготовленный запрос для проверки пользователя
    $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Успешная авторизация
        $_SESSION['loggedin'] = true;
        header("Location: booking.php"); // Перенаправление на страницу бронирования
        exit();
    } else {
        $errorMessage = 'Неправильный email или пароль';
    }

    $stmt->close();
    $dbConnection->close();

    if ($conn->query($sql) === TRUE) {
        // Перенаправление на page2.php
        header("Location: page1.php");
        exit(); // Завершает выполнение скрипта после перенаправления
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Авторизация</title>
</head>
<body>
    <main class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f0e6ff;">
        <form method="post" action="login.php" class="p-4 shadow-sm rounded bg-white">
            <h2 class="text-center">Авторизация</h2>
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-light-pink w-100">Войти</button>
        </form>
    </main>
</body>
</html>