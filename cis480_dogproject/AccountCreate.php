<?php
/******************** This page is where users can create their accounts ******************/
require_once('controller/user.php');
require_once("controller/user_controller.php");
    
    $passwordError = '';
    if (isset($_POST['create'])) {
        $db = new Database();
        $conn = $db->getDbConn();

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $userName = $_POST['userName'];
        $password = $_POST['pw'];
        $userLevel = 2;
        //The if statement contains two types of matching syntax. strlen is short for string length
        //and the preg_match compares the specified dataset to the variable.
        if (strlen($password) < 6) {
            $passwordError = 'Password must be at least 6 characters long';
        }  elseif (!preg_match("#[0-9]+#", $password)) {
            $passwordError = 'Password must include at least one number';
        } elseif (!preg_match("#[a-zA-Z]+#", $password)) {
            $passwordError = 'Password must include at least one letter';
        } elseif (!preg_match("#[^\da-zA-Z]+#", $password)) {
            $passwordError = 'Password must include at least one Special Character';
        } else {
            UserController::addUser($firstName, $lastName, $userName, $password, $userLevel);
            header("Location: index.php");
        }
    }
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Create Account</title>
   <style><?php include "stylesheets/account.css" ?></style>
   <link rel="stylesheet" href="stylesheets/style.css" type="text/css">
</head>
    <div class="outer">
    <div class="inner">
    <?php echo "<span style='color: red; text-align: center;'>{$passwordError}</span>"; ?>
    <h2>Create an Account</h2>
    <form method="POST">
        <h3>First Name: <input type="text" name="firstName" placeholder="First Name"></h3>
        <h3>Last Name: <input type="text" name="lastName" placeholder="Last Name"></h3>
        <h3>UserName: <input type="text" name="userName" placeholder="UserName"></h3>
        <h3>Password: <input id="password" type="password" name="pw" placeholder="Enter Password" onkeyup="checkPasswordStrength();"></h3>
        <div id="password-strength-status"></div>
        <input type="submit" value="Submit and Return" name="create">
    </form>
    </div>
    </div>
    <h4>Password Requirements</h4>
    <ul class="req">
        <li>Passwords must be at least 6 characters long</li>
        <li>Password must contain at least 1 number</li>
        <li>Password must contain at least 1 letter</li>
        <li>Password must contain at least 1 Special Character</li>
    </ul>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
</html>