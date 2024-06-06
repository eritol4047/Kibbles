<?php
    require_once('C:\xampp\htdocs\cis480_dogproject\model\user_db.php');    
    require_once('user.php');
    require_once('C:\xampp\htdocs\cis480_dogproject\model\database.php');

class UserController {
    //Allows us to put together the users table for admin view.
    private static function rowToUser($row) {
        $user = new User($row['FirstName'],
            $row['LastName'],
            $row['Username'],
            $row['Password'],
            $row['UserLevel'],
            $row['UserID']);
        return $user;
    }
    
    //runs a search for userID by using UserName.
    public static function getUserbyID($userName) {
        $queryRes = UsersDB::getUserID($userName);

        if ($queryRes) {
            return self::rowToUser($queryRes);
        } else {
            return false;
        }
    }


    //Validates user by finding the user by username input, then matching the password.
    public static function validUser($userName, $password) {
        $queryRes = UsersDB::getUserByUserName($userName);
    
        if ($queryRes) {
            $user = self::rowToUser($queryRes);
            if ($user->getPassword() === $password) {
                return $user->getUserLevel();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //This function allows us to update the password on the front end.
    public static function updateUser($userName, $password) {
        $db = new Database();
        $conn = $db->getDbConn();

        $updQuery = "UPDATE users SET 
            Password = '$password'
            WHERE UserName = '$userName'";
            mysqli_query($conn, $updQuery);
    }

    public static function deleteUser() {
        $db = new Database();
        $conn = $db->getDbConn();
        
        $userID = -1;
        
        $delQuery = "DELETE FROM userinfo WHERE UserID = $userID";
        mysqli_query($conn, $delQuery);
    }

    //We can use this function for the register account screen.
    public static function addUser($firstName, $lastName, $userName, $password, $userLevel) {
        $db = new Database();
        $conn = $db->getDbConn();

        $addQuery = "INSERT INTO 
        users (FirstName, LastName, UserName, Password, UserLevel) 
        VALUES ('$firstName', '$lastName','$userName','$password', '$userLevel')";
        mysqli_query($conn, $addQuery);
    }
}
?>
