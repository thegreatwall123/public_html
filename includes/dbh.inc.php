<?php

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "todoincdb";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
