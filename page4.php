<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма заявки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Форма заявки</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="master">Выберите мастера:</label>
                <select name="master" id="master" required>
                    <option value="master1">Мастер 1</option>
                    <option value="master2">Мастер 2</option>
                    <option value="master3">Мастер 3</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Выберите дату:</label>
                <input type="date" name="date" id="date" required>
            </div>
            <div class="form-group">
                <label for="time">Выберите время:</label>
                <select name="time" id="time" required>
                    <?php
                    for ($hour = 8; $hour <= 18; $hour++) {
                        echo "<option value='$hour:00'>$hour:00</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Отправить заявку</button>
        </form>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $master = $_POST['master'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    echo "Вы выбрали мастера: $master, дату: $date, время: $time";
}
?>