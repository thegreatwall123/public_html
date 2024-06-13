<?php

if (isset($_POST["submit"])) {

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$id = $_POST["submit"];
$taskname = $_POST["taskname"];
$taskdescription = $_POST["taskdescription"];
$timezone = new DateTimeZone('America/Denver'); 
$currentdate = new DateTime('now', $timezone);
$phpdate = $currentdate->format('Y-m-d');


if (emptyInputDataEntry($taskname, $taskdescription) !== false) {
    header("location: ../tasks.php?error=emptyinput");
    exit();
}
if (invalidTaskName($taskname) !== false) {
    header("location: ../tasks.php?error=invalidtaskname");
    exit();
}
updateTask($conn, $taskname, $taskdescription, $phpdate, $id);

}

else {
    header("location: ../tasks.php");
    exit();
}

?>