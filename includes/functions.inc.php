<?php

/* Functions for the signup page */

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

function createUser($conn, $username, $email, $pwd) {
    $sql = "INSERT INTO users (userName, userEmail, 
    userPassword) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, 
    $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputSignup($username, $email, $pwd, $pwdRepeat) {
    $result; 
    if ( empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result; 
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result; 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

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

/* Functions for the login page */

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPassword"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["usersid"] = $uidExists["usersId"];
        $_SESSION["username"] = $uidExists["userName"];
        header("location: ../index.php");
        exit();
    }
}

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

/* Functions for the ToDos Tab */

function taskSubmit($conn, $taskname, $taskdescription, $currentdate, $usersid) {
    $sql = "INSERT INTO tasks (taskName, taskDescription, currentDate,
    usersId) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../tasks.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $taskname, $taskdescription, $currentdate, $usersid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../tasks.php?error=none");
    exit();
}

function emptyInputDataEntry($taskname, $taskdescription) {
    $result; 
    if (empty($taskname) || empty($taskdescription)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function invalidTaskName($taskname) {
    $result; 
    if (!preg_match("/^[a-zA-Z1-9 ]{1,30}$/", $taskname)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function listTasks($conn, $userid) {

    $sql = "SELECT tasksId, taskName, taskDescription FROM tasks
    WHERE usersId = $userid
    AND checkbox IS NULL
    or checkbox = 0 AND usersId = $userid
    ORDER BY currentDate DESC LIMIT 10;";

    $result = mysqli_query($conn, $sql);
    return $result;
}

function completedTasks($conn, $userid) {

    $sql = "SELECT tasksId, taskName, taskDescription FROM tasks
    WHERE usersId = $userid
    AND checkbox IS NOT NULL
    AND checkbox = 1
    ORDER BY currentDate DESC LIMIT 10;";

    $result2 = mysqli_query($conn, $sql);
    return $result2;
}

/* Function for the edit.php page */

function updateTask($conn, $taskname, $taskdescription, $currentdate, $id) {
    $sql = "UPDATE tasks SET taskName = ?, taskDescription = ?,
    currentDate = ?
    WHERE tasks.tasksId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: edit.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssi", $taskname, $taskdescription, $currentdate, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: edit.inc.php?error=none");
    exit();
}
?>