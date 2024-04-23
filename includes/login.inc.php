<?php

if (isset($_POST["submit"])) {
    $uid = $_POST["username"];
    $pwd = $_POST["password"];

    require_once 'db.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($uid, $pwd) !== false) {
        header("Location: ../index.php?error=emptyInput&username=$uid");
        exit();
    }

    // Вход в системата
    $userId = loginUser($conn, $uid, $pwd);

    if ($userId !== false) {
        // Запазване на идентификатора на потребителя в сесията
        session_start();
        $_SESSION['userId'] = $userId;
        header("Location: ../account.php?login=success");
        exit();
    } else {
        // Неуспешен вход в системата
        header("Location: ../account.php?error=wrongLogin");
        exit();
    }
} else {
    // Ако submit не е зададен, пренасочваме потребителя към страницата за вход
    header("Location: ../account.php");
    
    exit();
    
}
?>
