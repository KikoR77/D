<?php
    session_start();
    include_once 'db.php';
    
    if(!isset($_POST["submit"])) {
        header("Location: ../addproduct.php?error=post");
    } else {        
        $ID = $_SESSION['usersId'];           
        $productName = $_POST['productName'];
        $price = $_POST['price'];        
        $year = $_POST['year'];
        $desc = $_POST['description'];        
        $hp = $_POST['horsepower'];
        $type = $_POST['typep'];
        include "errorHandlerAdd.php";
        include 'upload.php';
        
        if(empty($imgId)) {
            $imgIds = "none";
        } else {
            $imgIds = implode(" ", $imgId);
        }        
    
        $sql = "INSERT IGNORE INTO products (name, 	price, year, description, images,horsepower,typep) VALUES(?, ?, ?, ?, ?,?,?)";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {         
            mysqli_stmt_bind_param($stmt, "siissis", $productName, $price, $year, $desc, $imgIds,$hp,$type);           
            mysqli_stmt_execute($stmt);           
        }

        header("Location: ../addproduct.php?error=success");
        
    }
?>