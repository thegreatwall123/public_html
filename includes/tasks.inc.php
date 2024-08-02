<?php
session_start();

if (isset($_POST["submit"])) {

    $taskname = $_POST["taskname"];
    $taskdescription = $_POST["taskdescription"];
    $timezone = new DateTimeZone('America/Denver');
    $currentdate = new DateTime('now', $timezone);
    $phpdate = $currentdate->format('Y-m-d');
    $usersid = $_SESSION["usersid"];

    if (isset($_POST["completeDate"]) && !empty($_POST["completeDate"])) {
        $completeDateObj = new DateTime($_POST["completeDate"], $timezone);
        $completeDate = $completeDateObj->format('Y-m-d');
    } else {
        $completeDate = null; // or handle default value
    }

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputDataEntry($taskname, $taskdescription, $completeDate) !== false) {
        header("location: ../tasks.php?error=emptyinput");
        exit();
    }
    if (invalidTaskName($taskname) !== false) {
        header("location: ../tasks.php?error=invalidtaskname");
        exit();
    }
    taskSubmit($conn, $taskname, $taskdescription, $phpdate, $completeDate, $usersid);

} else {
    header("location: ../tasks.php");
    exit();
}
?>
