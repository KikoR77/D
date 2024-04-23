<?php

if(isset($_POST['submit'])) {
    $uid = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pwd = $_POST['password'];
    $pwdRepeat = $_POST['confirmPassword'];

    require_once 'db.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($email, $uid, $phone, $pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=emptyInput" . PassInformation($uid, $email, $phone));
        exit();
    }

    if(invalidUid($uid) !== false) {
        header("Location: ../account.php?error=invalidUid&email=$email&phone=$phone");
        exit();
    }

    if(invalidEmail($email) !== false) {
        header("Location: ../account.php?error=invalidEmail&username=$uid&phone=$phone");
        exit();
    }
    
    if(invalidPhone($phone) !== false) {
        header("Location: ../account.php?error=invalidPhone&email=$email&username=$uid");
        exit();
    }

    if(phoneExist($conn, $phone) === true) {
        header("Location: ../account.php?error=phoneTaken&email=$email&username=$uid");
        exit();
    }

    if(pwdChar($pwd) !== false) {
        header("Location: ../account.php?error=passwordLenght" . PassInformation($email, $uid, $phone));
        exit();
    }

    if(pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=passwordDontMatch" . PassInformation($email, $uid, $phone));
        exit();
    }    

    if(uidExists($conn, $uid, $email) !== false) {
        $userInfo = uidExists($conn, $uid, $email);

        if ($userInfo['usersName'] === $uid) {
            header("Location: ../account.php?error=usernameTaken&username=$uid&email=$email");
            exit();
        } else if($userInfo['usersEmail'] === $email) {
            header("Location: ../account.php?error=emailTaken&username=$uid");
            exit();
        }
    }
    
    createUser($conn, $uid, $email, $phone, $pwd);


} else {
    header("Location: ../account.php");
    exit();
}