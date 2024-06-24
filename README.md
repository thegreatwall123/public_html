##### Steps to run the website on your PC from the direction of a Windows user. #####

## 1st Step
Install Xampp 

## 2nd Step
Run Xampp as an administrator or else it won't work!

## 3rd Step
Start the Apache and MySQL services.

## 4th Step
Go to localhost/phpmyadmin/

## 5th Step
Go to the SQL tab

## 6th Step
Copy and Paste this into SQL and click Go. It will create the database.

CREATE DATABASE todoincdb;
USE todoincdb;
CREATE TABLE `users` (
  `usersId` INT(11) AUTO_INCREMENT NOT NULL,
  `userName` VARCHAR(30) NOT NULL,
  `userEmail` VARCHAR(256) NOT NULL,
  `userPassword` VARCHAR(256) NOT NULL,
  `questionOne` DATE NOT NULL,
  `questionTwo` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`usersId`)
);
CREATE TABLE `tasks` (
  `tasksId` INT(11) AUTO_INCREMENT NOT NULL,
  `taskName` VARCHAR(30) NOT NULL,
  `taskDescription` VARCHAR(256) NOT NULL,
  `checkbox` BOOLEAN NULL,
  `currentDate` DATE NOT NULL,
  `usersId` INT(11) NOT NULL,
  PRIMARY KEY (`tasksId`),
  FOREIGN KEY (`usersId`) REFERENCES `users`(`usersId`)
);

## 7th Step
Download the public_html file from https://github.com/thegreatwall123/public_html.git

## 8th Step 
Move the public_html file to the htdocs folder that was automatically created by the Xampp installation. 
Found at C://xampp/htdocs. (public_html should not have any files between it and htdocs)

## 9th Step
Go to localhost/public_html/ 




