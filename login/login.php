<?php
    include_once 'header.php';
?>


<section class="signup-form">
    <h2>Log In</h2>
        <div class="signup-form-form">
            <form action="../includes/login/login.inc.php" method="post">
                <input type="text" name="username" placeholder="Username/Email...">
                <input type="password" name="password" placeholder="Password...">
                <button type="submit" name="submit">Log In</button>
            </form>
        </div>
        <div>
            <a href="forgotPassword.php">Forgot My Password</a>
        </div>
    <div class="error">
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields</p>";
                }
                else if ($_GET["error"] == "wronglogin") {
                    echo "<p>Incorrect login information</p>";
                }
            }
        ?>
    </div>
</section>


<?php
    include_once '../footer.php';
?>