<?php
session_start();

$productId = $_GET["productId"];
$size = $_GET["year"];
$typep = $_GET['typep'];
$count = $_GET["count"];

if (isset($productId) && isset($size) && isset($count) && $size != "Default") {
    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        $ids = array_column($_SESSION["cart"], 'id');
        if (($id = array_search($productId, $ids)) !== FALSE) {
            $sizes = array_column($_SESSION["cart"][$id], 'year');
            $typeps = array_column($_SESSION["cart"][$id], 'typep');
            if (($sizeId = array_search($size, $sizes)) !== FALSE && ($typepId = array_search($typep, $typeps)) !== FALSE) {
                $_SESSION["cart"][$id][$sizeId][$typepId]["count"] += intval($count);
            } else {
                array_push($_SESSION["cart"][$id], array("year" => $size, "typep" => $typep, "count" => intval($count)));
            }
        } else {
            array_push($_SESSION["cart"], array("id" => $productId, array("year" => $size, "typep" => $typep, "count" => intval($count))));
        }
    } else {
        $_SESSION["cart"] = array();
        array_push($_SESSION["cart"], array("id" => $productId, array("year" => $size, "typep" => $typep, "count" => intval($count))));
    }

    // Изчислете новата цена за сесията
    $sql = "SELECT price FROM products WHERE productId = $productId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $price = $row["price"];

    // Запазваме данните за продукта в сесията
    $_SESSION['productDetails'] = array(
        'productId' => $productId,
        'price' => $price
    );
    header("Location: ../cart.php?typep=" . urlencode($typep));
} else {
    header("Location: ../cart.php?error=NoProductId");
}
?>
