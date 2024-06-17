<?php
session_start();

if (isset($_POST["submit"])) {

    $taskname = $_POST["taskname"];
    $taskdescription = $_POST["taskdescription"];
    $timezone = new DateTimeZone('America/Denver'); 
    $currentdate = new DateTime('now', $timezone);
    $phpdate = $currentdate->format('Y-m-d');
    $usersid = $_SESSION["usersid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputDataEntry($taskname, $taskdescription) !== false) {
        header("location: ../tasks.php?error=emptyinput");
        exit();
    }
    if (invalidTaskName($taskname) !== false) {
        header("location: ../tasks.php?error=invalidtaskname");
        exit();
    }
    taskSubmit($conn, $taskname, $taskdescription, $phpdate, $usersid);

}
else {
    header("location: ../tasks.php");
    exit();
}