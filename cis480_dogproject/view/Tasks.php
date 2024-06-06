<?php
/*This is the Tasks Page.
This will be where users can access their list of tasks to add, edit or delete tasks as they see fit. They will also be able to check off tasks as they get done.*/
SESSION_START();
require_once('C:\xampp\htdocs\cis480_dogproject\util\security.php');
require_once('C:\xampp\htdocs\cis480_dogproject\model\database.php');
require_once('C:\xampp\htdocs\cis480_dogproject\controller\tasks.php');
require_once('C:\xampp\htdocs\cis480_dogproject\controller\tasks_controller.php');
require_once('C:\xampp\htdocs\cis480_dogproject\controller\user_controller.php');
$db = new Database();
$conn = $db->getDbConn();
$userName = '';
$user = $_SESSION['userInfo'];
$userLevel = $user['UserLevel'];
$userID = $user['UserID'];
$_SESSION['userID'] = $userID;

if (isset($_POST['logout'])) {
    Security::logout();
}
//We added the cancel button and an if statement to give the user more control to say nevermind and
//avoid changing or adding what they don't want.
if (isset($_POST['cancel'])) {
    header("Location: Tasks.php");
}
//The search function is handled by the if else statement. Inside both, the queries have a join
//statement matching the username to the user. Using this, we can limit the view of the user to only
//see tasks created and maintained by their account. By default, it just runs the join query, but
//with the submit search feature, the query has an extra piece that filters further by whatever the
//user searches with.
if (isset($_POST['submit'])) {
    $db = new Database();
    $conn = $db->getDbConn();
    $userName = $user['Username'];
    $find = $_POST['find'];
    
    $searchQuery = "SELECT * FROM users a JOIN tasks b ON a.UserID = b.UserID WHERE a.Username = '$userName' AND (b.TaskName LIKE '%$find%' or b.Description LIKE '%$find%')";
    $result = mysqli_query($conn, $searchQuery);
} else {
    $userName = $user['Username'];
    $searchQuery = "SELECT * FROM users a JOIN tasks b ON a.UserID = b.UserID WHERE Username = '$userName' ";
    $result = mysqli_query($conn, $searchQuery);
    $user = UserController::getUserbyID($_SESSION['userName']);
}
//the update and add features only show up when the button is clicked. To do that, we took part of
//the html and stored them inside of if statements. After which, the if statements that data gets
//passed to can complete the functions so that the user sees an immediate effect.
if (isset($_POST['up'])) {
    $task = $_POST['taskName'];
    $description = $_POST['desc'];
    $taskID = $_SESSION['taskID'];

    $updQuery = "UPDATE tasks SET 
        TaskName = '$task',
        Description = '$description'
        WHERE TaskID = '$taskID'";
    mysqli_query($conn, $updQuery);
    header("Location: Tasks.php");
}
if (isset($_POST['added'])) {
    if ($userLevel == 2) {
    $userID = $_SESSION['userID'];
    $task = $_POST['taskAdd'];
    $description = $_POST['descAdd'];

    $addQuery = "INSERT INTO tasks (UserID, TaskName, Description, RepeatID)
                    VALUES ('$userID', '$task', '$description', NULL)";
    mysqli_query($conn, $addQuery);
    header("Location: Tasks.php");
    } else {
        $userName = $_POST['usern'];
        $userQuery = "SELECT UserID FROM users WHERE Username = '$userName'";
        $userResult = mysqli_query($conn, $userQuery);
        $userRow = mysqli_fetch_assoc($userResult);
        $userID = $userRow['UserID'];
        $task = $_POST['taskAdd'];
        $description = $_POST['descAdd'];
    
        $addQuery = "INSERT INTO tasks (UserID, TaskName, Description, RepeatID)
                        VALUES ('$userID', '$task', '$description', NULL)";
        mysqli_query($conn, $addQuery);
        header("Location: Tasks.php");
    }
}
if (isset($_POST['delete'])) {
    $task = TaskController::getTaskbyID($_POST['taskID']);
    $taskID = $task->getTaskId();
        
    $delQuery = "DELETE FROM tasks WHERE TaskID = '$taskID'";
    mysqli_query($conn, $delQuery);
    header("Location: Tasks.php");
}

//This if statement allows us to hide stuff that is only for admin mode.
if ($userLevel == 2) {
    ?><style> .admin {display: none;} </style> <?php
} else {
    ?><style> </style> <?php
}
?>

<html>
<head>
   <style><?php include "../stylesheets/CaPrTa.css" ?></style>
</head>
<title>Tasks</title>
    <ul class="nav">
    <li class="nav"><a href="Home.php"><img src="../images/HomeIcon2.png" alt="Home" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Tasks.php"><img src="../images/Task.png" alt="Tasks" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Profiles.php"><img src="../images/Profilef.png" alt="Profile Image" height="40px" width="40px"></a></li>
    <div class="admin"><li class="nav"><a href="Users.php">Users</a></li></div>
    </ul>
    <form method="POST">
        <input type="text" value="" name="find" placeholder="search tasks here..">
        <input type="submit" value="Search" name="submit">
    </form>
    <div class="admin"><h2 class="adm">Admin Mode</h2></div>
    <?php if (isset($_POST['update'])) {
        $tasks = TaskController::getTaskbyID($_POST['taskID']);
        $taskID = $tasks->getTaskId();
        $_SESSION['taskID'] = $taskID;
        ?>
        <div class="outer"><div class="inner">
        <form method="POST">
        <h3>Task: <input type="text" value="<?php echo $tasks->getTask(); ?>" name="taskName"></h3>
        <h3>Description: <input type="text" value="<?php echo $tasks->getDescription(); ?>" name="desc"></h3>
        <input type="submit" value="Save Changes" name="up">
            <input type="submit" value="Cancel" name="cancel">
    </form>
    </div></div>
    <?php } ?>
    <?php if (isset($_POST['add'])) {
            unset($_SESSION['taskID']);
            unset($taskID); ?>
        <div class="outer"><div class="inner">
        <form method="POST">
            <h3 class="admin">UserName: <input type="text" placeholder="Add UserName" name="usern"></h3>
            <h3>Task: <input type="text" name="taskAdd" ></h3>
            <h3>Description: <input type="text" name="descAdd" ></h3>
            <input type="submit" value="Add to List" name="added">
            <input type="submit" value="Cancel" name="cancel">
        </form>
    </div></div>
    <?php } ?>
    <form method="POST">
        <input type="submit" value="Add" name="add">
    </form>
    <table>
            <tr style="font-size:large;">
                <th class="admin">UserName</th>
                <th>Task</th>
                <th>Description</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td class="admin"><?php echo $row['Username'] ?></td>
                    <td><?php echo $row["TaskName"];?></td>
                    <td><?php echo $row["Description"];?></td>
                    <td><form method="post">
                        <input type="hidden" value="<?php echo $row['TaskID']; ?>" name="taskID">
                        <input type="submit" value="update" name="update">
                    </form></td>
                    <td><form method="post">
                        <input type="hidden" value="<?php echo $row['TaskID']; ?>" name="taskID">
                        <input type="submit" value="delete" name="delete">
                    </form></td>
                </tr>
            <?php endwhile;?>
        </table>
    <form method="POST">
        <input type="submit" value="Logout" name="logout">
    </form>
</html>