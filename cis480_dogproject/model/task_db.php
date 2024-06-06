<?php 
require_once('database.php');

class TasksDB {
    //This function gets all tasks.
    public static function getTasks() {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "SELECT * FROM Tasks";
            
            return $dbConn->query($query);
        } else {
            return false;
        }
    }

    //getTask pulls all information on one task using taskID.
    public static function getTask($taskID) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        $query = "SELECT * FROM Tasks WHERE TaskID = '$taskID'";

        $result = $dbConn->query($query);
        return $result->fetch_assoc();
    }
}
?>