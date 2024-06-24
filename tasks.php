<?php
include_once 'header.php';
include_once 'sidebar.php';

?>

<main class="test">


    <?php
        // only access if the user is logged in.
        if (isset($_SESSION["username"])) {
            $userid = $_SESSION["usersid"];
            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';
            $result = listTasks($conn, $userid);
            $result2 = completedTasks($conn, $userid);
        }
        // else redirect to this page.
        else {
            header("location: index.php");
            exit();
        }
    ?>

    <section class="signup-form column">
        <h2>Daily Tasks Entry</h2>
            <div class="signup-form-form">
                <form action="includes/tasks.inc.php" method="post">
                    <input type="text" name="taskname" maxlength="30" placeholder="Task Name...">
                    <textarea name="taskdescription" maxlength="256" rows="3" cols="25" placeholder="Task Description..."></textarea>
                    <button type="submit" name="submit">Submit Entry</button>
                </form>
            </div>
        <div class="error">

            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields</p>";
                    }
                    else if ($_GET["error"] == "stmtfailed") {
                        echo "<p>Something went wrong, try again.</p>";
                    }
                    else if ($_GET["error"] == "invalidtaskname") {
                        echo "<p>Task names can only include letters or numbers</p>";
                    }
                    else if ($_GET["error"] == "none") {
                        echo "<p class='noerror'>Data Entry Valid</p>";
                    }
                }
            ?>
            
        </div>
    </section> 


    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="styled-table column">';
        echo '<h2>Tasks To Do</h2>';
        echo '<table class="styled-table-table">';
            echo '<tr>';
                echo '<th>Task Name</th>';
                echo '<th>Task Description</th>';
                echo '<th>Changes</th>';
            echo '</tr>';
            echo '<tr>';
                while($row = mysqli_fetch_assoc($result)) {
                $id = $row['tasksId'];
                $name = $row['taskName'];
                $description = $row['taskDescription'];
    ?>
                <td>
                    <div class="space">
                    <?php echo $name?>
                    </div>
                </td>
                <td>
                    <div class="space">
                    <?php echo $description?>
                    </div>
                </td>
                <td>
                    <?php 
                    echo '<form action="edit.php" method="post">';
                        echo '<input type="hidden" name="editid" value='.$id.'>';
                        echo '<button type="submit" class="btn">Update</button>';
                    echo '</form>';
                    echo '<form action="includes/completed.inc.php" method="post">';
                        echo '<input type="hidden" name="completedid" value='.$id.'>';
                        echo '<button type="submit" class="btn btnlower">Complete</button>';
                    echo '</form>';
                    ?>
                </td>
                </tr>
        <?php  
                }
        echo '</table>';
        echo '</div>';
    }
        ?>
    
    <?php
    if (mysqli_num_rows($result2) > 0) {
        echo '<div class="styled-table column">';
        echo '<h2>Tasks Completed</h2>';
        echo '<table class="styled-table-table">';
            echo '<tr>';
                echo '<th>Task Name</th>';
                echo '<th>Task Description</th>';
                echo '<th>Changes</th>';
            echo '</tr>';
            echo '<tr>';
                while($row = mysqli_fetch_assoc($result2)) {
                $id = $row['tasksId'];
                $name = $row['taskName'];
                $description = $row['taskDescription'];
    ?>
                <td>
                    <div class="space">
                    <?php echo $name?>
                    </div>
                </td>
                <td>
                    <div class="space">
                    <?php echo $description?>
                    </div>
                </td>
                <td>
                    <?php
                    echo '<form action="includes/notcompleted.inc.php" method="post">';
                        echo '<input type="hidden" name="notcompletedid" value='.$id.'>';
                        echo '<button type="submit" class="btn">Incomplete</button>';
                    echo '</form>';
                    echo '<form action="includes/delete.inc.php" method="post">';
                        echo '<input type="hidden" name="deleteid" value='.$id.'>';
                        echo '<button type="submit" class="btn btndanger">Delete</button>';
                    echo '</form>';
                    ?>
                </td>
                </tr>
        <?php  
                }
        echo '</table>';
        echo '</div>';
    }

        ?>

</main>

<?php
include_once 'footer.php';
?>
