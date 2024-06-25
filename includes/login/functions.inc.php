<?php

/* Functions for the login page */

// Checks if the uid Exists in the database. 
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE userName = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// function to login.
function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../../login/login.php?error=wronglogin");
        exit();
    }

    // verifies the hashed password.
    $pwdHashed = $uidExists["userPassword"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../../login/login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();

        // starts the session to keep the user logged in.
        $_SESSION["usersid"] = $uidExists["usersId"];
        $_SESSION["username"] = $uidExists["userName"];
        header("location: ../../index.php");
        exit();
    }
}

// Checks if the user's reset password information is correct  
function authenticateUser($conn, $username, $questionone, $questiontwo) {

    $sql = "SELECT usersId FROM users WHERE (userName = ? OR userEmail = ?)
    AND questionOne = ?
    AND questionTwo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../login/forgotPassword.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $username, $username, $questionone, $questiontwo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // User found, set session variables
        session_start();
        $_SESSION['id'] = $row['usersId'];

        // Redirect to resetPassword.php
        header("location: ../../login/resetPassword.php?error=none");
        exit();
    } 
    else {
        // User not found or credentials don't match
        header("location: ../../login/forgotPassword.php?error=incorrectinformation");
        exit();
    }

    mysqli_stmt_close($stmt);
}

// Checks if the user's reset password information is correct  
function resetPassword($conn, $userid, $pwd) {
    $updateSql = "UPDATE users SET userPassword = ? WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $updateSql)) {
        header("location: ../../login/resetPassword.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit(header("location: ../../login/resetPassword.php?error=none"));

}

// error handler for empty input fields.
function emptyInputLogin($username, $pwd) {
    $result; 
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// error handler for empty input fields. ForgotPassword.inc.php
function emptyInputSecurity($username, $questionone, $questiontwo) {
    $result; 
    if (empty($username) || empty($questionone) || empty($questiontwo)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// error handler for the passwords to match.
function pwdMatch($pwd, $pwdRepeat) {
    $result; 
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

?>