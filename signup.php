<?php
    include_once 'header.php';
?>


<section class="signup-form">
    <h2>Sign Up</h2>
        <div class="signup-form-form">
            <form action="includes/signup.inc.php" method="post">
                <input type="text" name="username" placeholder="Username...">
                <input type="text" name="email" placeholder="Email...">
                <input type="password" name="password" placeholder="Password...">
                <input type="password" name="passwordrepeat" placeholder="Repeat password...">
                <label style="margin-right: 100px; font-weight: normal;" for="questionone">Security Question #1: Date of Birth?</label>
                <input type="date" name="questionone" placeholder="Answer...">
                <label style="margin-right: 23px; font-weight: normal;" for="questiontwo">Security Question #2: Mother's Maiden Name?</label>
                <input type="text" name="questiontwo" placeholder="Answer...">
                <button type="submit" name="submit">Sign Up</button>
            </form>
        </div>
    <div class="error">
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields</p>";
                }

                // Seperate validation for email and username 
                else if ($_GET["error"] == "invalidusername") {
                    echo "<p>Choose a proper username</p>";
                }
                else if ($_GET["error"] == "invalidemail") {
                    echo "<p>Choose a proper email</p>";
                }
                else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>passwords don't match</p>";
                }
                else if ($_GET["error"] == "stmtfailed") {
                    echo "<p>Something went wrong, try again.</p>";
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo "<p>Username already taken</p>";
                }
                else if ($_GET["error"] == "none") {
                    echo "<p class='noerror'>You have signed up</p>";
                }
            }
        ?>
    </div>
</section>


<?php
    include_once 'footer.php';
?>