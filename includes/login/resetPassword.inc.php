<?php

if (isset($_POST["submit"])) {

    $userid = $_POST["id"];
    $pwd = $_POST["password"];
    $pwdRepeat = $_POST["passwordrepeat"];

    require_once '../dbh.inc.php';
    require_once 'functions.inc.php';

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../../login/resetPassword.php?error=passwordsdontmatch");
        exit();
    }

    resetPassword($conn, $userid, $pwd);

}
else {
    header("location: ../../login/resetPassword.php");
    exit();
}