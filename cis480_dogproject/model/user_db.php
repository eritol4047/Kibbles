<?php
require_once('database.php');

class UsersDB {
    //This function gets the user by the username.
    public static function getUserByUserName($userName) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "SELECT * FROM Users
                    WHERE Users.Username = '$userName'";

            $result = $dbConn->query($query);
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    //getUserID pulls all information on one UserName using UserName. This allows us to tie what users can do
    //based off who is logged in.
    public static function getUserID($userName) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        $query = "SELECT * FROM users WHERE UserName = '$userName'";

        $result = $dbConn->query($query);
        return $result->fetch_assoc();
    }
}
?>