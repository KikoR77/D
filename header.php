<?php
session_start();
include_once "includes/db.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Kiko's Auto parts | Онлайн магазин</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">    
</head>
<body>
    <div class="header"> 
        <div class="container"> 
            <div class="navbar"> 
                <div class="logo">
                    <a href="index.php"><img class="logo" src="images\Logo-kikopng.png" width="85px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <li><a href="index.php"><b>Начало</b></a></li>
                        <li><a href="products.php"><b>Продукти</b></a></li>
                        <li><a href="aboutUs.php"><b>За нас</b></a></li>
                        <li><a href="contact.php"><b>Контакти</b></a></li>
                        <?php
                            if(isset($_SESSION['useruid'])) {
                                if(isset($_SESSION["accountType"]) && $_SESSION["accountType"] == 1) {
                                    ?>
                                    <li><a href="addproduct.php"><b>Добави продукт</b></a></li>
                                    <?php
                                }
                                ?>
                                    <li><a href="includes/logout.inc.php"><b>Излизане</b></a></li>
                                    <?php                                                              
                            } else {
                                ?>
                                <li><a href="account.php"><b>Профил</b></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </nav>
                <a href="cart.php"><i class="fa fa-shopping-cart" style = " font-size: 28px; color: black;"></i></a>
                <img src="menu-removebg-preview.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>