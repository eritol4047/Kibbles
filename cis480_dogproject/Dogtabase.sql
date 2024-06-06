create database dogtabase;

CREATE TABLE `dogtabase`.`userlevels` (`UserLevel` INT NOT NULL , `Description` INT NOT NULL , PRIMARY KEY (`UserLevel`)) ENGINE = InnoDB;

CREATE TABLE `dogtabase`.`users` (`UserID` INT(5) NOT NULL AUTO_INCREMENT , `Username` VARCHAR(10) NULL , `Password` VARCHAR(20) NULL , `FirstName` INT(255) NULL , `LastName` INT(255) NULL , `UserLevel` INT(11) NULL , PRIMARY KEY (`UserID`)) ENGINE = InnoDB;

CREATE TABLE `dogtabase`.`tasks` (`TaskID` INT NOT NULL AUTO_INCREMENT, `UserID` INT, 'TaskName' VARCHAR(20), 'Description' VARCHAR(50), 'RepeatID' INT(5),  PRIMARY KEY (`TaskID`)) ENGINE = InnoDB;

CREATE TABLE `dogtabase`.`profiles` (`ProfileID` INT NOT NULL AUTO_INCREMENT, `UserID` INT, 'ProfileName' VARCHAR(20), PRIMARY KEY (`ProfileID`)) ENGINE = InnoDB;

CREATE TABLE `dogtabase`.`repeatable` (`RepeatID` INT NOT NULL AUTO_INCREMENT, 'Name' VARCHAR(25), `Description` VARCHAR(25), INT NOT NULL , PRIMARY KEY (`UserLevel`)) ENGINE = InnoDB;
GO

INSERT INTO userlevels (UserLevel, Description) values (1,'admin');
INSERT INTO userlevels (UserLevel, Description) values (2,'user');
GO

INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'teACH', 'P@ssword1', 'Randy', 'Bellet', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'Twl', '123456', 'Towely', 'Towl', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'teACH', '123456', 'Randy', 'Bellet', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'Retro', '123456', 'Randy', 'Marsh', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'RB', '123456', 'A', 'B', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'Monkey', '123456', 'Manny', 'Manilo', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'JLo', '123456', 'Jennifer', 'Lopez', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'JK', '123456', 'Jeff', 'Keigh', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'jafro', '123456', 'Jack', 'Froth', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'Fool', '123456', 'Harry', 'Fontaine', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'DoubleD', '123456', 'Richard', 'Bronson', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'AB', '123456', 'A', 'B', 2);
INSERT INTO users (Username, Password, FirstName, LastName, UserLevel) values ( 'Admin', 'Access2024!', 'Admin', 'Access', 1);
GO

DROP USER IF EXISTS sdc342gp_user;
CREATE USER Dogroot@'%' IDENTIFIED VIA mysql_native_password USING 'P@ssword1';
GRANT ALL PRIVILEGES ON dogtabase.* TO sdc342gp_user@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GO