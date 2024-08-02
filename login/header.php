<?php
    session_start();
/*
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        $message = "Error: [$errno] $errstr - $errfile:$errline";
        error_log($message . PHP_EOL, 3, "../errors/error_log.txt");
    }

    set_error_handler("customErrorHandler"); */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>ToDoInc</title>
</head>
<body>
    <nav class="topnav">
        <div class="wrapper">
            <div class="topnav-left">
                <a href="../index.php">Home</a>
            </div>
            <div class="topnav-right">
                <?php
                    if (isset($_SESSION["username"])) {
                        echo "<a href='../profile.php'>Profile</a>";
                        echo "<a href='../includes/logout.inc.php'>Log out</a>";
                    }
                    else {
                        echo "<a href='../signup.php'>Sign Up</a>";
                        echo "<a href='login.php'>Log in</a>";
                    }
                ?>
            </div>
        </div>
    </nav>
