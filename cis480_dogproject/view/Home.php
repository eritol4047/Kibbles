<?php
/*This is the home page that users see once they are logged in. This will be where users can navigate to different pages.*/
session_start();
require_once('C:\xampp\htdocs\cis480_dogproject\util\security.php');
if (isset($_POST['logout'])) {
    Security::logout();
}
//The UserLevel from the Session Array is put into the userLevel variable and if it matches a normal
//user, then the special link to the users gets hidden.
$user = $_SESSION['userInfo'];
$userLevel = $user['UserLevel'];
if ($userLevel == 2) {
    ?><style> .admin {display: none;} </style> <?php
} else {
    ?><style> </style> <?php
}
?>

<html>
<main>
<head>
   <style><?php include "../stylesheets/home.css" ?></style>
</head>
<title>Home Page</title>
    <ul>
    <li><a href="Password.php"> Change Password </a></li>
    <div class="admin"><li><a href="Users.php">Users</a></li></div>
    </ul>
<h1>Home</h1>
    <div class="admin"><h2 class="adm">Admin Mode</h2></div>
    <div class="row">
        <div class="gallery"><div class="inner"><a href="Tasks.php"><img src="../images/Task.png" alt="Tasks" width="100" height="100"></a>
            <div class="desc">Tasks</div></div></div>
    
        <div class="gallery"><div class="inner"><a href="Profiles.php"><img src="../images/Profilef.png" alt="Tasks" width="100" height="100"></a>
            <div class="desc">Profiles</div></div></div>
    </div>
    <form method="POST">
        <input type="submit" value="Logout" name="logout">
    </form>
</main>
</html>