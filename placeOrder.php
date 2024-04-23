<?php
session_start();
include_once "includes/db.php";

// Проверка за изпращане на POST заявка
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка за наличие на данни в POST заявката
    if (isset($_POST['phone']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['totalAmount']) && isset($_POST['products'])) {
        // Получаване на информацията за поръчката
        $phone = $_POST['phone'] ?? 0; // Ако 'phone' е null, задайте 0
        $name = $_POST['name'] ?? 0; // Ако 'name' е null, задайте 0
        $email = $_POST['email'] ?? 0; // Ако 'email' е null, задайте 0
        $address = $_POST['address'] ?? 0; // Ако 'address' е null, задайте 0
        $city = $_POST['city'] ?? 0; // Ако 'city' е null, задайте 0
        $totalAmount = $_POST['totalAmount'] ?? 0; // Ако 'totalAmount' е null, задайте 0
        $products = json_decode($_POST['products'], true);

        // Валидация на данните (можете да добавите повече проверки според изискванията)
        if (empty($phone) || empty($name) || empty($email) || empty($address) || empty($city) || empty($totalAmount) || empty($products)) {
            echo "Моля, попълнете всички полета.";
            exit();
        }
        
        // Вмъкване на данните за поръчката в таблицата "poruchki"
        $sql_insert_order = "INSERT INTO poruchki (phone, name, email, total_amount) VALUES (?, ?, ?, ?)";
        $stmt_order = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_order, $sql_insert_order)) {
            echo "Грешка при подготовката на заявката за поръчка.";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt_order, "sssd", $phone, $name, $email, $totalAmount);
            mysqli_stmt_execute($stmt_order);
            $order_id = mysqli_insert_id($conn); // Получаване на последно вмъкнатото ID на поръчката
            
            // Вмъкване на данните за продуктите в таблицата "poruchki_info"
            $sql_insert_order_product = "INSERT INTO poruchki_info (order_id, product_name, type, quantity, address, city, year) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_order_product = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt_order_product, $sql_insert_order_product)) {
                echo "Грешка при подготовката на заявката за продукт в поръчката.";
                exit();
            } else {
                // Вмъкване на данните за продуктите в базата данни
                foreach ($products as $product) {
                    $product_name = $product['name'] ?? 0; // Ако 'name' на продукта е null, задайте 0
                    $type = $product['typep'] ?? 0; // Ако 'type' на продукта е null, задайте 0
                    $quantity = $product['quantity'] ?? 0; // Ако 'quantity' на продукта е null, задайте 0
                    $year = $product['year'] ?? 0; // Ако 'year' на продукта е null, задайте 0
                    
                    // Вмъкване на данните за продукта в базата данни
                    mysqli_stmt_bind_param($stmt_order_product, "ississi", $order_id, $product_name, $type, $quantity, $address, $city, $year);
                    $result = mysqli_stmt_execute($stmt_order_product);
                    if (!$result) {
                        echo "Грешка при изпълнението на заявката за вмъкване на продукт в поръчката: " . mysqli_error($conn);
                        exit();
                    }
                }
            }

            // Изчистване на количката в сесията
            unset($_SESSION["cart"]);

            echo "Поръчката е приета успешно!";
            exit();
        }
    } else {
        echo "Моля, попълнете всички полета.";
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
