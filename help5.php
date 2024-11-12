<?php
session_start();

// Обработка формы входа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка логина и пароля
    if ($username === 'beauty' && $password === 'pass') {
        $_SESSION['loggedin'] = true; // Устанавливаем сессию
        header('Location: page5.php'); // Перенаправляем на панель администратора
        exit;
    } else {
        $error = "Неверный логин или пароль"; // Сообщение об ошибке
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Подключаем CSS файл -->
</head>
<body>
    <div class="container">
        <h2>Вход в систему</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div> <!-- Отображение ошибки -->
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
