<?php
// Start output buffering
ob_start();

include_once 'header.php';

// only access if the user is logged in.
if (isset($_SESSION["id"])) {
    require_once '../includes/dbh.inc.php';
    require_once '../includes/login/functions.inc.php';
    $id = $_SESSION["id"];

    unset($_SESSION["id"]);
    ?>

    <section class="signup-form">
        <h2>Reset Password</h2>
        <div class="signup-form-form">
            <form action="../includes/login/resetPassword.inc.php" method="post">
                <label style="margin-right: 170px; font-weight: normal;" for="passwordone">Enter your New Password</label>
                <input type="password" name="password">
                <label style="margin-right: 145px; font-weight: normal;" for="passwordtwo">Re-Enter your New Password</label>
                <input type="password" name="passwordrepeat">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button type="submit" name="submit">Reset Password</button>
            </form>
        </div>
        <div class="error">
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields</p>";
                }
                if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>passwords don't match</p>";
                }
                else if ($_GET["error"] == "none") {
                    echo "<p class='noerror'>Access Granted</p>";
                }
            }
            ?>
        </div>
    </section>

    <?php
    include_once '../footer.php';
} else {
    // Redirect to forgotPassword.php with error parameter
    header("Location: login.php");
    exit();
}
// End output buffering and flush output
ob_end_flush();
?>

