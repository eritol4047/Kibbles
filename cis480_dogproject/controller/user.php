<?php
class User {
    //Declarations
    private $userId;
    private $firstName;
    private $lastName;
    private $password;
    private $userName;
    private $userLevel;

    function __construct($firstName, $lastName, $userName, $password, $userLevel, $userId = null) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->password = $password;
        $this->userLevel = $userLevel;
        $this->userId = $userId;
    }

    //Getters and Setters
    function getUserId() {
        return $this->userId;
    }
    function setPersonNo($value) {
        $this->userId = $value;
    }
    
    function getFirstName() {
            return $this->firstName;
        }
    function setFirstName($value) {
        $this->firstName = $value;
    }
    
    function getLastName() {
            return $this->lastName;
        }
    function setLastName($value) {
        $this->lastName = $value;
    }
    
    function getuserName() {
        return $this->userName;
    }
    function setuserName($value) {
        $this->userName = $value;
    }

    function getPassword() {
        return $this->password;
    }
    function setPassword($value) {
        $this->password = $value;
    }

    function getUserLevel() {
        return $this->userLevel;
    }
    function setUserLevel($value) {
        $this->userLevel = $value;
    }
}
?>