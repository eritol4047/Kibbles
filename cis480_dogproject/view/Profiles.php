<?php
/*This is the Profiles Page.
This is the family management page. This is where the account holder can add, edit, delete or rename profiles. */
session_start();
require_once('C:\xampp\htdocs\cis480_dogproject\util\security.php');
require_once('C:\xampp\htdocs\cis480_dogproject\model\database.php');
$db = new Database();
$conn = $db->getDbConn();
$user = $_SESSION['userInfo'];
$userLevel = $user['UserLevel'];
if (isset($_POST['logout'])) {
    Security::logout();
}
if (isset($_POST['cancel'])) {
    header("Location: Profiles.php");
}
//Checks if a user is a normal user or an admin.
if ($userLevel == 2) {
$userName = $_SESSION['userName'];
$displayQuery = "SELECT * FROM users a JOIN profiles b ON a.userID = b.userID WHERE Username = '$userName'";
$result = mysqli_query($conn, $displayQuery);
} else {
    $displayQuery = "SELECT * FROM users a JOIN profiles b ON a.userID = b.userID ORDER BY Username, ProfileName";
    $result = mysqli_query($conn, $displayQuery);
}
if (isset($_POST['up'])) {
    $proName = $_POST['proNa'];
    $profile = $_SESSION['profileInfo'];
    $profileID = $profile['ProfileID'];

    $updQuery = "UPDATE profiles SET 
        ProfileName = '$proName'
        WHERE ProfileID = '$profileID'";
    mysqli_query($conn, $updQuery);
    header("Location: Profiles.php");
}
if (isset($_POST['delete'])) {
    $profileID = $_POST['profileID'];
        
    $delQuery = "DELETE FROM profiles WHERE ProfileID = '$profileID'";
    mysqli_query($conn, $delQuery);
    header("Location: Profiles.php");
}
//The added if function adds to the profiles table. It first checks if the user is a normal user or
//an admin account. If it is an admin, then it pulls the UserName from post to get the UserID.
if (isset($_POST['added'])) {
    if ($userLevel == 2) {
    $user = $_SESSION['userInfo'];
    $userID = $user['UserID'];
    $profile = $_POST['proAdd'];

    $addQuery = "INSERT INTO profiles (UserID, ProfileName)
                    VALUES ('$userID', '$profile')";
    mysqli_query($conn, $addQuery);
    header("Location: Profiles.php");
    } else {
        $userName = $_POST['usern'];
        $userQuery = "SELECT UserID FROM users WHERE Username = '$userName'";
        $userResult = mysqli_query($conn, $userQuery);
        $userRow = mysqli_fetch_assoc($userResult);
        $userID = $userRow['UserID'];
        $profile = $_POST['proAdd'];

        $addQuery = "INSERT INTO profiles (UserID, ProfileName)
                        VALUES ('$userID', '$profile')";
        mysqli_query($conn, $addQuery);
        header("Location: Profiles.php");
    }
}
$user = $_SESSION['userInfo'];
$userLevel = $user['UserLevel'];
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
<title>Profiles</title>
    <ul class="nav">
    <li class="nav"><a href="Home.php"><img src="../images/HomeIcon2.png" alt="Home" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Tasks.php"><img src="../images/Task.png" alt="Tasks" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Profiles.php"><img src="../images/Profilef.png" alt="Profile Image" height="40px" width="40px"></a></li>
    <div class="admin"><li class="nav"><a href="Users.php">Users</a></li></div>
    </ul>
    <div class="admin"><h2 class="adm">Admin Mode</h2></div>
    <?php if (isset($_POST['update'])) {
        //Update and Add are hidden and only accessible via the buttons on screen.
        $profileID = $_POST['profileID'];
        $query = "SELECT * FROM profiles a JOIN users b ON a.UserID = b.UserID WHERE ProfileID = '$profileID'";
        $result = $conn->query($query);
        $profile = $result->fetch_assoc();
        $_SESSION['profileInfo'] = $profile;
        ?>
        <div class="outer"><div class="inner">
        <form method="POST">
            <h3>ProfileName: <input type="text" value="<?php echo $profile['ProfileName']; ?>" name="proNa"></h3>
        <input type="submit" value="Save Changes" name="up">
            <input type="submit" value="Cancel" name="cancel">
    </form>
    </div></div>
    <?php }  elseif (isset($_POST['add'])) {
            unset($_SESSION['profileID']);
            unset($profileID); ?>
        <div class="outer"><div class="inner">
        <form method="POST">
            <h3 class="admin">UserName: <input type="text" placeholder="Add UserName" name="usern"></h3>
            <h3>Profile: <input type="text" placeholder="Add Profile" name="proAdd" ></h3>
            <input type="submit" value="Add Profile" name="added">
            <input type="submit" value="Cancel" name="cancel">
        </form>
    </div></div>
    <?php } else { ?>
    <form method="POST">
        <input type="submit" value="Add" name="add">
    </form>
    <table>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <tr id="profiles">
                    <td><img src="../images/Profile.png" alt="Profile Image" height="50px" width="50px"></td>
                    <td class="admin"><?php echo $row['Username'] ?></td>
                    <td><?php echo $row["ProfileName"];?></td>
                    <td><form method="post">
                        <input type="hidden" value="<?php echo $row['ProfileID']; ?>" name="profileID">
                        <input type="submit" value="update" name="update">
                    </form></td>
                    <td><form method="post">
                        <input type="hidden" value="<?php echo $row['ProfileID']; ?>" name="profileID">
                        <input type="submit" value="delete" name="delete">
                    </form></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php } ?>
    <form method="POST">
        <input type="submit" value="Logout" name="logout">
    </form>
</html>