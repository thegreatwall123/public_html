<?php
include_once 'header.php';
include_once 'sidebar.php';
?>

    <main>

        <?php


            if (isset($_SESSION["username"])) {
                $userid = $_SESSION["usersid"];
                echo "<h1 class='title'>" . $_SESSION["username"] . "'s Home Page</h1>";

            }
        ?>
    </main>

<?php
include_once 'footer.php';
?>