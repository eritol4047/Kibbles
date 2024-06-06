<?php
require_once('C:\xampp\htdocs\cis480_dogproject\model\task_db.php');    
require_once('tasks.php');
require_once('C:\xampp\htdocs\cis480_dogproject\model\database.php');
//Does the same thing that usercontroller does, but for tasks.
class TaskController {

    private static function rowToTask($row) {
        $task = new Tasks($row['TaskID'],
            $row['UserID'],
            $row['TaskName'],
            $row['Description'],
            $row['RepeatID']);
        return $task;
    }

    public static function getAllTasks() {
        $queryRes = TasksDB::getTasks();
        $task = array();
        foreach ($queryRes as $row) {
            $task[] = self::rowToTask($row);
        }

        return $task;
    }

    public static function getTaskbyID($taskID) {
        $queryRes = TasksDB::getTask($taskID);

        if ($queryRes) {
            return self::rowToTask($queryRes);
        } else {
            return false;
        }
    }

    public static function updateTask($task, $description, $taskID) {
        $db = new Database();
        $conn = $db->getDbConn();

        $updQuery = "UPDATE tasks SET 
            TaskName = '$task',
            Description = '$description'
            WHERE TaskID = '$taskID'";
        mysqli_query($conn, $updQuery);
    }
}
?>