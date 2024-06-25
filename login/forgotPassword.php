<?php
    include_once 'header.php';
?>


<section class="signup-form">
    <h2>Forgot Password</h2>
        <div class="signup-form-form">
            <form action="../includes/login/forgotPassword.inc.php" method="post">
                <label style="margin-right: 145px; font-weight: normal;" for="username">Enter your username or email</label>
                <input type="text" name="username">
                <label style="margin-right: 165px; font-weight: normal;" for="questionone">What is your date of birth?</label>
                <input type="date" name="questionone">
                <label style="margin-right: 88px; font-weight: normal;" for="questiontwo">What is your mother's maiden name?</label>
                <input type="text" name="questiontwo">
                <button type="submit" name="submit">Confirm</button>
            </form>
        </div>
    <div class="error">
        <?php
            if (isset($_GET["error"])) {
                # If any fields are empty returns an error message.
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields</p>";
                }
                # If the answers to the security questions don't match then displays an error message.
                if ($_GET["error"] == "incorrectinformation") {
                    echo "<p>Incorrect login information</p>";
                }
            }
        ?>
    </div>
</section>


<?php
    include_once '../footer.php';
?>