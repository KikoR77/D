<?php
session_start();

// Ако в сесията няма дефинирана количка, създайте празна количка
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

include_once "db.php";

// Проверяваме дали са предоставени необходимите данни за обновяване на количеството
if(isset($_POST['productId']) && isset($_POST['quantity']) && isset($_POST['index'])) {
    // Получаваме данните от POST заявката
    $productId = $_POST['productId'];
    $newQuantity = $_POST['quantity'];
    $index = $_POST['index'];

    // Обновяваме сесията с новите данни
    $_SESSION['cart'][$index][$productId]['count'] = $newQuantity;

    // Пресмятаме новата междинна сума
    $intermediateTotal = 0;
    foreach ($_SESSION["cart"] as $cartItem) {
        foreach ($cartItem as $item) {
            $intermediateTotal += $item['count'] * $item['price'];
        }
    }

    // Изчисляваме ДДС и обща сума
    $vat = $intermediateTotal * 0.2;
    $total = $intermediateTotal + $vat;

    // Връщаме отговор към клиента с новата междинна сума и общата сума
    $response['success'] = true;
    $response['newIntermediateTotal'] = $intermediateTotal;
    $response['vat'] = $vat;
    $response['total'] = $total;
    echo json_encode($response);
} else {
    // Ако не са предоставени необходимите данни, върнете грешка
    $response['success'] = false;
    echo json_encode($response);
}
?>
