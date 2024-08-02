<?php
    session_start();

    /*error_reporting(E_ALL);
    ini_set('display_errors', 1);

    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        $message = "Error: [$errno] $errstr - $errfile:$errline";
        error_log($message . PHP_EOL, 3, "errors/error_log.txt");
    }

    set_error_handler("customErrorHandler");*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>ToDoInc</title>
</head>
<body>
<nav class="topnav">
    <div class="wrapper">
        <div class="topnav-left">
            <a href="index.php">Home</a>
        </div>
        <div class="topnav-right">
            <?php
            if (isset($_SESSION["username"])) {
                // Fetch user info to get the profile picture
                require_once 'includes/dbh.inc.php';

                $userid = $_SESSION["usersid"];
                $sql = "SELECT profilepicture FROM userinfo WHERE usersId = ?";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $userid);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $userInfo = mysqli_fetch_assoc($result);

                    if (!empty($userInfo['profilepicture'])) {
                        echo "<img src='data:image/jpeg;base64," . base64_encode($userInfo['profilepicture']) . "' alt='Profile Picture' class='profile-pic'>";
                    } else {
                        // Default profile picture if none exists
                        echo "<img src='path/to/default/profile.png' alt='Profile Picture' class='profile-pic'>";
                    }
                }

                echo "<a href='profile.php'>Profile</a>";
                echo "<a href='includes/logout.inc.php'>Log out</a>";
            } else {
                echo "<a href='signup.php'>Sign Up</a>";
                echo "<a href='login/login.php'>Log in</a>";
            }
            ?>
        </div>
    </div>
</nav>
