<?php
if (isset($_POST['submit'])) {
    session_start();
    $userid = $_SESSION["usersid"];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $bio = $_POST['bio'];
    $profilepicture = $_FILES['profilepicture'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Handle profile picture upload
    $filePath = null;
    if (!empty($profilepicture['name'])) {
        $fileTmpName = $profilepicture['tmp_name'];
        $fileSize = $profilepicture['size'];
        $fileError = $profilepicture['error'];
        $fileType = $profilepicture['type'];

        $fileExt = explode('.', $profilepicture['name']);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) { // Limit to 5MB
                    $fileNameNew = "profile" . $userid . "." . $fileActualExt;
                    $fileDestination = '../uploads/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $filePath = 'uploads/' . $fileNameNew;
                } else {
                    header("location: ../index.php?error=filetoobig");
                    exit();
                }
            } else {
                header("location: ../index.php?error=uploaderror");
                exit();
            }
        } else {
            header("location: ../index.php?error=invalidfiletype");
            exit();
        }
    }

    // Check if userinfo already exists for the user
    $sqlCheck = "SELECT * FROM userinfo WHERE usersId = ?";
    $stmtCheck = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtCheck, $sqlCheck)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmtCheck, "i", $userid);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Prepare to update existing entry
        $sqlUpdate = "UPDATE userinfo SET ";
        $params = [];
        $types = "";

        if (!empty($fname)) {
            $sqlUpdate .= "fname = ?, ";
            $params[] = $fname;
            $types .= "s";
        }
        if (!empty($lname)) {
            $sqlUpdate .= "lname = ?, ";
            $params[] = $lname;
            $types .= "s";
        }
        if (!empty($bio)) {
            $sqlUpdate .= "bio = ?, ";
            $params[] = $bio;
            $types .= "s";
        }
        if (!empty($filePath)) {
            $sqlUpdate .= "profilepicture = ?, ";
            $params[] = $filePath;
            $types .= "s";
        }

        // Remove trailing comma and space
        $sqlUpdate = rtrim($sqlUpdate, ', ');
        $sqlUpdate .= " WHERE usersId = ?";
        $params[] = $userid;
        $types .= "i";

        $stmtUpdate = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtUpdate, $sqlUpdate)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmtUpdate, $types, ...$params);
        mysqli_stmt_execute($stmtUpdate);
        mysqli_stmt_close($stmtUpdate);
    } else {
        // Insert new entry
        $sqlInsert = "INSERT INTO userinfo (usersId, fname, lname, bio, profilepicture) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtInsert, $sqlInsert)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmtInsert, "issss", $userid, $fname, $lname, $bio, $filePath);
        mysqli_stmt_execute($stmtInsert);
        mysqli_stmt_close($stmtInsert);
    }

    header("location: ../index.php?error=none");
    exit();
} else {
    header("location: ../index.php");
    exit();
}
?>
