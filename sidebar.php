<div class="container">
        <!--container class will contain the links-->
        <?php
            if (isset($_SESSION["username"])) {
                $personid = $_SESSION["usersid"];
                echo '<a href="tasks.php">ToDos</a>';
            }
            else {
                echo '<a href="login/login.php">ToDos</a>';
            }
        ?>
    </div>
