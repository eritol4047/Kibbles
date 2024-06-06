<?php
/*************** This is the page where users can change their own account password. ***************/
session_start();
require_once('C:\xampp\htdocs\cis480_dogproject\controller\user_controller.php');
require_once('C:\xampp\htdocs\cis480_dogproject\util\security.php');
$passwordError = '';

if (isset($_POST['change'])) {
    $db = new Database();
    $conn = $db->getDbConn();
    $userName = $_SESSION['userName'];
    $oldPassword = $_SESSION['password'];
    $oldPw = $_POST['oldpw'];
    $password = $_POST['pw'];
    
    /************ Password Validation ************/
    $passwordError = '';
    if ($oldPassword === $oldPw) {
        if (strlen($password) < 6) {
            $passwordError = 'Password must be at least 6 characters long';
        } elseif (!preg_match("#[0-9]+#", $password)) {
            $passwordError = 'Password must include at least one number';
        } elseif (!preg_match("#[a-zA-Z]+#", $password)) {
            $passwordError = 'Password must include at least one letter';
        } elseif (!preg_match("#[^\da-zA-Z]+#", $password)) {
            $passwordError = 'Password must include at least one Special Character';
        } else {

        $updQuery = "UPDATE users SET 
            Password = '$password'
            WHERE UserName = '$userName'";
            mysqli_query($conn, $updQuery);
        Security::logout();
        }
    } else {
        $passwordError = 'Incorrect Password - Please type in your old Password';
    }
}
$user = $_SESSION['userInfo'];
$userLevel = $user['UserLevel'];
if ($userLevel == 2) {
    ?><style> div.admin {visibility: hidden;} </style> <?php
} else {
    ?><style> div.admin {visibility: visible;} </style> <?php
}
?>

<html>
    <head>
        <style><?php include "../stylesheets/CaPrTa.css" ?></style>
        <link rel="stylesheet" href="../stylesheets/style.css" type="text/css">
    </head>
    <title>Change Password</title>
    <ul class="nav">
    <li class="nav"><a href="Home.php"><img src="../images/HomeIcon2.png" alt="Home" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Tasks.php"><img src="../images/Task.png" alt="Tasks" width="40px" height="40px"></a></li>
    <li class="nav"><a href="Profiles.php"><img src="../images/Profilef.png" alt="Profile Image" height="40px" width="40px"></a></li>
    <li class="nav"><a href="Users.php"><div class="Admin">Users</div></a></li>
    </ul>
    <div class="admin"><h2 class="adm">Admin Mode</h2></div>
        <div class="outer"><div class="inner">
    <?php echo "<span style='color: red;'>{$passwordError}</span>"; ?>
<form method="POST">
        <h3>Old Password: <input type="password" placeholder="Old Password" name="oldpw"></h3>
        <h3> New Password: <input id="password" placeholder="Enter New Password" type="password" name="pw" onkeyup="checkPasswordStrength();"></h3>
        <input type="submit" value="Change Password" name="change">
        <div id="password-strength-status"></div>
    </form>
    <h4>Password Requirements</h4>
    <ul class="req">
        <li>Password must be at least 6 characters long</li>
        <li>Password must contain at least 1 Number</li>
        <li>Password must contain at least 1 Letter</li>
        <li>Password must contain at least 1 Special Character</li>
    </ul>
    </div></div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/main.js"></script>
</html>