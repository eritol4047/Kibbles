<?php
/********* Page only accessable via the admin profile. **********/
//Shows all users.
SESSION_START();
require_once('C:\xampp\htdocs\cis480_dogproject\util\security.php');
require_once('C:\xampp\htdocs\cis480_dogproject\model\database.php');
require_once('C:\xampp\htdocs\cis480_dogproject\controller\user_controller.php');
$db = new Database();
$conn = $db->getDbConn();
if (isset($_POST['logout'])) {
    Security::logout();
}

//The display query pulls up all level 2 users, thus preventing admins from making problems for other
//admins
$count = 1;
$displayQuery = "SELECT * FROM users WHERE UserLevel = 2 ORDER BY UserID";
$result = mysqli_query($conn, $displayQuery);
if (isset($_POST['reset'])) {
    $userID = $_POST['userID'];
    $resQuery = "UPDATE users SET Password = '123456' WHERE UserID = '$userID'";
    mysqli_query($conn, $resQuery);
    header("Location: users.php");
}

?>
<html>
<head>
    <title>Admin Mode</title>
   <style><?php include "../stylesheets/CaPrTa.css" ?></style>
</head>
    <ul class="nav">
    <li class="nav"><a href="Home.php"><img src="../images/HomeIcon2.png" alt="Home" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Tasks.php"><img src="../images/Task.png" alt="Tasks" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Profiles.php"><img src="../images/Profilef.png" alt="Profile Image" height="40px" width="40px"></a></li>
    <li class="nav"><a href="Users.php">Users</a></li>
    </ul>
    <h1>Admin Mode</h1>
<h1>All Users</h1>
    <form method="POST">
        <input type="submit" value="Logout" name="logout">
    </form>
    <h4>Password After Reset: 123456</h4>
    <table>
            <tr style="font-size:large;">
                <th>Number</th>
                <th>UserID</th>
                <th>Username</th>
                <th>Password</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>UserLevel</th>
                <th>Password Reset</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row["UserID"];?></td>
                    <td><?php echo $row["Username"];?></td>
                    <td><?php echo $row["Password"];?></td>
                    <td><?php echo $row["FirstName"];?></td>
                    <td><?php echo $row["LastName"];?></td>
                    <td><?php echo $row["UserLevel"];?></td>
                    <td><form method="post">
                        <input type="hidden" value="<?php echo $row['UserID']; ?>" name="userID">
                        <input type="submit" value="Password Reset" name="reset">
                    </form></td>
                </tr>
            <?php $count += 1; endwhile;?>
        </table>
</html>