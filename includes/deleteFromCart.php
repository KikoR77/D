<?php

session_start();

$productId = $_POST["productId"];
$index = $_POST["index"];

if(isset($productId)) {
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { 
        if(isset($_SESSION["cart"][$index]) && !empty($_SESSION["cart"][$index])) {
            // Изтриване на продукта от количката
            unset($_SESSION["cart"][$index]);
            // Редирект към страницата за количката
            header("Location: ../cart.php");
            exit(); // Уверете се, че излизате от скрипта след редиректа
        }
    }
} else {
    //header("Location: ../cart.php?error=NoProductId");
    // Ако желаете да редиректнете с грешка, разкоментирайте горната редица
    // и добавете съобщение за грешка към URL-а
    header("Location: ../cart.php?error=NoProductId");
    exit();
}
?>
