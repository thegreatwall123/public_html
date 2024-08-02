<?php
include_once 'header.php';
include_once 'sidebar.php';

if (isset($_POST["editid"]) && isset($_SESSION["username"])) {

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = $_POST["editid"];
    $sql="Select * from tasks where tasksId=$id";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    $name = $row['taskName'];
    $description = $row['taskDescription'];

    /*
change it so they cant manually change the taskid in the 
search bar. They can change it to a taskid that is not 
associated with their userid.
*/
}

?>

    <section class="signup-form column">
        <h2>Daily Tasks Entry</h2>
            <div class="signup-form-form">
                <form action="includes/edit.inc.php" method="post">
                    <input type="text" name="taskname" maxlength="30" value="<?php echo $name;?>" placeholder="Task Name">
                    <textarea name="taskdescription" maxlength="256" rows="3" cols="25" placeholder="Task Description"><?php echo $description;?></textarea>
                    <button type="submit" name="submit" value="<?php echo $id;?>">Submit Entry</button>
                </form>
            </div>
    </section> 


<?php
include_once 'footer.php';
?>