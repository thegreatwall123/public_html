<?php

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $questionone = $_POST["questionone"];
    $questiontwo = $_POST["questiontwo"];

    $formattedQuestionOne = date('Y-m-d', strtotime($questionone));

    require_once '../dbh.inc.php';
    require_once 'functions.inc.php';

    authenticateUser($conn, $username, $formattedQuestionOne, $questiontwo);
}
else {
    header("location: ../../login/login.php");
    exit();
}