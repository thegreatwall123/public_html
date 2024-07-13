<?php
include_once 'header.php';
include_once 'sidebar.php';
?>

<main>
    <?php
    if (isset($_SESSION["username"])) {
        $userid = $_SESSION["usersid"];
        echo "<h1 class='title'>Welcome: " . $_SESSION["username"] . "</h1>";

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        // Fetch existing user info
        $sql = "SELECT * FROM userinfo WHERE usersId = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $userInfo = mysqli_fetch_assoc($result);
        }
        ?>

        <div class="current-info">
            <h2>Your Current Information</h2>
            <p><strong>First Name:</strong> <?php echo isset($userInfo['fname']) ? $userInfo['fname'] : 'N/A'; ?></p>
            <p><strong>Last Name:</strong> <?php echo isset($userInfo['lname']) ? $userInfo['lname'] : 'N/A'; ?></p>
            <p><strong>Bio:</strong> <?php echo isset($userInfo['bio']) ? $userInfo['bio'] : 'N/A'; ?></p>
            <?php if (isset($userInfo['profilepicture']) && !empty($userInfo['profilepicture'])): ?>
                <p><strong>Profile Picture:</strong></p>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($userInfo['profilepicture']); ?>" alt="Profile Picture">
            <?php else: ?>
                <p><strong>Profile Picture:</strong> N/A</p>
            <?php endif; ?>
        </div>

        <button id="updateInfoButton">Update My Info</button>

        <div id="updateInfoForm" style="display:none;">
            <section class="user-info-form column">
                <h2>Update Your Information</h2>
                <div class="user-info-form-form">
                    <form action="includes/userinfo.inc.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="fname" maxlength="50" placeholder="First Name" value="<?php echo isset($userInfo['fname']) ? $userInfo['fname'] : ''; ?>">
                        <input type="text" name="lname" maxlength="50" placeholder="Last Name" value="<?php echo isset($userInfo['lname']) ? $userInfo['lname'] : ''; ?>">
                        <textarea name="bio" maxlength="256" rows="3" cols="25" placeholder="Bio"><?php echo isset($userInfo['bio']) ? $userInfo['bio'] : ''; ?></textarea>
                        <input type="file" name="profilepicture" accept="image/*">
                        <button type="submit" name="submit">Update Info</button>
                    </form>
                </div>
                <div class="error">
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "<p>Fill in all fields</p>";
                        } else if ($_GET["error"] == "stmtfailed") {
                            echo "<p>Something went wrong, try again.</p>";
                        } else if ($_GET["error"] == "none") {
                            echo "<p class='noerror'>Information Updated Successfully</p>";
                        }
                    }
                    ?>
                </div>
            </section>
        </div>

        <script>
            document.getElementById('updateInfoButton').addEventListener('click', function() {
                var form = document.getElementById('updateInfoForm');
                if (form.style.display === 'none') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        </script>

        <?php
    } else {
        echo "<p>You need to log in to update your information.</p>";
    }
    ?>
</main>

<?php
include_once 'footer.php';
?>
