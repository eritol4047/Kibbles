<?php 
class Tasks {
    //Declarations
    private $taskID;
    private $userId;
    private $task;
    private $description;
    private $repeatID;

    function __construct($taskID, $userId, $task, $description, $repeatID) {
        $this->taskID = $taskID;
        $this->task = $task;
        $this->description = $description;
        $this->repeatID = $repeatID;
        $this->userId = $userId;
    }
    
    //Getters and Setters
    function getTaskId() {
        return $this->taskID;
    }
    function setTaskId($value) {
        $this->taskID = $value;
    }
    
    function getUserId() {
            return $this->userId;
        }
    function setUserId($value) {
        $this->userId = $value;
    }
    
    function getTask() {
            return $this->task;
        }
    function setTask($value) {
        $this->task = $value;
    }
    
    function getDescription() {
        return $this->description;
    }
    function setDescription($value) {
        $this->description = $value;
    }

    function getRepeatID() {
        return $this->repeatID;
    }
    function setRepeatID($value) {
        $this->repeatID = $value;
    }
}
?>