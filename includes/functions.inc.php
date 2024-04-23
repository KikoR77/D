<?php
    include_once 'db.php';
function emptyInputSignup($email, $uid, $phone, $pwd, $pwdRepeat) {
    $result;
    if(empty($email) || empty($uid) || empty($phone) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($uid) {
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidPhone($phone)
{
    $result;
    if(strlen($phone) != 9 || !preg_match("/^\\d+$/", $phone)) {
        $result = true;
    } else {
        $result = false;
    }        
    return $result;
}

function phoneExist($conn, $phone)
{
    $sql = "SELECT * FROM users WHERE phone = ?;";    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("Location: ../account.php?error=stmtFailed");
        exit();
    }
       
    mysqli_stmt_bind_param($stmt, "i", $phone);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if(empty(mysqli_fetch_assoc($resultData))) {
        $result = false;
        return $result;
    } else {
        $result = true;        
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function invalidEmail($email) {
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdChar($pwd) {
    $result;
    if(strlen($pwd) < 8) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $uid, $email) {
    $sql = "SELECT * FROM users WHERE usersName = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../account.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function PassInformation($email, $uid, $phone) {
    return "&email=$email&username=$uid&phone=$phone";
}

function createUser($conn, $uid, $email, $phone, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, phone, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../account.php?error=stmtFailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssis", $uid, $email, $phone, $hashedPwd);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    //Auto Log In
    $uidExists = uidExists($conn, $uid, $uid);

    if($uidExists === false) {
        header("Location: ../account.php?error=autoLogIn");
        exit();
    }

    session_start();
    $_SESSION['userid'] = $uidExists["usersId"];
    $_SESSION['useruid'] = $uidExists["usersName"];
    //header("Location: ../index.php");
    exit();
}

function emptyInputLogin($uid, $pwd) {
    $result;
    if(empty($uid) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $uid, $pwd) {
    $uidExists = uidExists($conn, $uid, $uid);

    if($uidExists === false) {
        header("Location: ../account.php?error=wrongloginUid");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false) {
        header("Location: ../account.php?error=wrongloginPwd&username=$uid");
        exit();
    } else if($checkPwd === true) {
        session_start();
        $_SESSION['userid'] = $uidExists["usersId"];
        $_SESSION['useruid'] = $uidExists["usersName"];
        $_SESSION['accountType'] = $uidExists["accountType"];
                
        header("Location: ../index.php");
        exit();
    }
}