<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['name'];
    $phoneNumber = $_POST['phone'];
    $userLogin = $_POST['username'];
    $userPassword = $_POST['password'];

    // Подключение к базе данных (замените на свои данные)
    $dbConnection = new mysqli("localhost", "username", "password", "database");

    // Проверка соединения
    if ($dbConnection->connect_error) {
        die("Ошибка подключения: " . $dbConnection->connect_error);
    }

    // Подготовленный запрос для вставки данных
    $stmt = $dbConnection->prepare("INSERT INTO users (name, phone, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $phoneNumber, $userLogin, $userPassword);

    if ($stmt->execute()) {
        header("Location: success.php"); // Перенаправление на страницу успешной регистрации
        exit();
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $dbConnection->close();

    if ($conn->query($sql) === TRUE) {
        // Перенаправление на page2.php
        header("Location: page2.php");
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
    <title>Регистрация</title>
</head>
<body>
    <main class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f0e6ff;">
        <form method="post" action="registration.php" class="p-4 shadow-sm rounded bg-white">
            <div class="mb-3">
                <label for="name" class="form-label">ФИО:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон:</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Логин:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-light-pink w-100">Зарегистрироваться</button>
        </form>
    </main>
</body>
</html>