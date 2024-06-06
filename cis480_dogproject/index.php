<?php
/************ Main page. First thing users see when they open the website. *************/
session_start();
require_once('controller/user.php');
require_once('controller/user_controller.php');
require_once('util/security.php');
$db = new Database();
$conn = $db->getDbConn();
$_SESSION['userName'] = '';
$_SESSION['userID'] = '';
$_SESSION['password']= '';
$userName = '';

$login_msg = isset($_SESSION['logout_msg']) ?
    $_SESSION['logout_msg'] : '';
//The if statement checks the username and password against the database and if it matches, then the
//session recieves the input and stores it for the other pages and sends the user to one of two pages.
if (isset($_POST['userName']) & isset($_POST['pw'])) {
    $_SESSION['userName'] = $_POST['userName'];
    $_SESSION['password'] = $_POST['pw'];
    $userName = $_POST['userName'];
    $query = "SELECT * FROM users WHERE UserName = '$userName'";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    $_SESSION['userInfo'] = $user;
    $userName = $_POST['userName'];
    $user_level = UserController::validUser(
        $_POST['userName'], $_POST['pw']);
    if($user_level === '1') {
        $_SESSION['admin'] = true;
        $_SESSION['user'] = false;
        header("Location: view/Users.php");
    } if ($user_level === '2') {
        $_SESSION['admin'] = false;
        $_SESSION['user'] = true;
        header("Location: view/Home.php");
    } else { 
        $login_msg = 'Failed Authentication - try again.';
    }
}
?>
<html>
<main>
<head>
   <style><?php include "stylesheets/account.css" ?></style>
</head>
    <title>Log In</title>
    <body>
    <h1>Kibbles</h1>
    <h1>The Family App</h1>
    <div class="outer">
    <div class="inner">
    <h2>Login</h2>
    <form method="POST">
        <h3>Login ID: <input type="text"
             name="userName" placeholder="Enter UserName"></h3>
        <h3>Password: <input type="password" name="pw" placeholder="Enter Password"></h3>
        <input type="submit" value="Login" name="login">
        <input type="button" value="Create" name="create" onclick="location='AccountCreate.php'">
    </form>
    <h2><?php echo $login_msg; ?></h2>
    </div>
    </div>
</body>
</main>
</html>