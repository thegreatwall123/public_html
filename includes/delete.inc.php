<?php

if (isset($_POST["deleteid"])) {
    $id = $_POST["deleteid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $sql = "DELETE FROM tasks WHERE tasks.tasksId = $id;";
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