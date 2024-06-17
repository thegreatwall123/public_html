<?php

/* Functions for the signup page */


// error handler for if the username or email already exists.
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

// function to register the user with a hashed password.
function createUser($conn, $username, $email, $pwd, $questionone, $questiontwo) {
    $sql = "INSERT INTO users (userName, userEmail, 
    userPassword, questionOne, questionTwo) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    // hashing
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $username, $email,
    $hashedPwd, $questionone, $questiontwo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}

// error handler for if any of the fields are empty.
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

// error handler for the username.
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

// error handler for he email.
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

function validateUsernameLength($username) {
    $minLength = 4;
    $maxLength = 20;
    $length = strlen($username);
    return ($length < $minLength || $length > $maxLength);
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