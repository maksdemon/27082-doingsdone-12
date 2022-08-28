CREATE DATABASE doingsdone_db
  DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE doingsdone_db;

CREATE TABLE `users` (
                       `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       `name` varchar(255) NOT NULL,
                       `email` varchar(255) NOT NULL UNIQUE,
                       `password` varchar(255) NOT NULL,
                       `id_user` INT(255) NOT NULL,
                       `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `project` (
                         `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `title` varchar(255) NOT NULL UNIQUE,
                         `id_user` INT(255) NOT NULL
);

CREATE TABLE `task` (
                      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      `name` varchar(255) NOT NULL,
                      `deadline` TIMESTAMP NULL,
                      `category` varchar(255) NOT NULL,
                      `user` INT(255) NOT NULL,
                      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      `STATUS` BOOLEAN NOT NULL DEFAULT '0',
                      'project_id' INT NOT NULL,
                      'file' CHAR(255)


);





