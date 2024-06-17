<?php

if (isset($_POST["completedid"])) {
    $id = $_POST["completedid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $sql = "UPDATE tasks SET checkbox = 1 WHERE tasks.tasksId = $id;";
    $result=mysqli_query($conn, $sql);
    if($result){
        header("location: ../tasks.php");
        exit();
    }
}
else {
    header("location: ../tasks.php");
    exit();
}
?>