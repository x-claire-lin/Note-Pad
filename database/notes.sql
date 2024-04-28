CREATE DATABASE notes;
GRANT USAGE ON *.* TO cst8285Test@localhost IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON notes.* TO cst8285Test@localhost;
FLUSH PRIVILEGES;

USE notes;

CREATE TABLE `user` (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `notes` (
    noteid INT AUTO_INCREMENT PRIMARY KEY,
    note TEXT NOT NULL,
    userid INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES user(userid)
);
