<?php
    
    include_once 'db.php';
    
    if(empty($productName) || empty($year) || empty($desc) || empty($price)|| empty($hp)) {
        header("Location: ../addproduct.php?error=empty&name=$productName&description=$desc&price=$price&year=$year&hp=$hp");
        exit();
    }    
?>