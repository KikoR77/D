<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Форма за регистрация</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="name">Име:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="phone">Телефонен номер:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="input-group">
                <label for="password">Парола:</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Потвърди паролата:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Регистрирай се</button>
        </form>
    </div>
</body>
</html>
<?php
// Проверка дали формата е изпратена
// Проверка дали формата е изпратена
// Проверка дали формата е изпратена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка дали всички полета са попълнени
    if (isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Проверка дали паролата и потвърждението на паролата съвпадат
        if ($password == $confirm_password) {
            // Свържете се с базата данни
            $servername = "localhost";
            $username = "root";
            $password = ""; // Паролата на базата данни
            $dbname = "diplomen";

            // Създаване на връзка
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка за връзка
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Създаване на таблица register_f, ако не съществува
            $sql = "CREATE TABLE IF NOT EXISTS register_f (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                phone VARCHAR(15) NOT NULL,
                password VARCHAR(255) NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

            if ($conn->query($sql) === TRUE) {
                // Вмъкване на данните в таблицата
                $sql = "INSERT INTO register_f (name, phone, password)
                VALUES ('$name', '$phone', '$password')";

                if ($conn->query($sql) === TRUE) {
                    echo "Регистрацията е успешна!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error creating table: " . $conn->error;
            }

            $conn->close();
        } else {
            echo "Паролата и потвърждението й не съвпадат.";
        }
    } else {
        echo "Моля, попълнете всички полета.";
    }
}

?>
