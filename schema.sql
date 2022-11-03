CREATE DATABASE doingsdone_db
  DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE doingsdone_db;

CREATE TABLE `users` (
                       `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       `name` varchar(255) NOT NULL,
                       `email` varchar(255) NOT NULL UNIQUE,
                       `password` varchar(255) NOT NULL,

                       `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `project` (
                         `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `title` varchar(255) NOT NULL,
                         `user_id` INT(255) NOT NULL

);

CREATE TABLE `task` (
                      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      `name` varchar(255) NOT NULL,
                      `deadline` TIMESTAMP NULL,
                      `category` int(255) ,
                      `user` INT(255) NOT NULL,
                      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      `STATUS` BOOLEAN NOT NULL DEFAULT '0',
                      `project_id` INT NOT NULL,
                      `file` varchar(255)
);

CREATE INDEX search_by_name on `users` (name);
CREATE INDEX search_by_project on `project` (title);
CREATE INDEX search_by_task on `task` (NAME);

SELECT * FROM project;
INSERT INTO task (`name`, `deadline`, `project_id`, `user`)
VALUES ("Собеседование в IT компании", "2020-12-01",1,1),
       ("Выполнить тестовое задание", "2021-11-06",2,1),
       ("Сделать задание новое 3", "2022-12-21",3,2),
       ("Встреча с другом", "2022-10-22",2,2),
       ("Купить корм для кота", NULL,4,1),
       ("Заказать пиццу", NULL,5,2),
       ("тестирование", "2022-11-01",6,1),
       ("поход в магазин", "2022-09-30",7,1),
       ("покушать", "2022-11-22",8,2),
       ("поспать", "2012-10-01",8,2),
       ("игры", "2022-01-27",2,1),
       ("встреча", "2022-10-07",3,1);
INSERT INTO task (`name`, `project_id`, `user`, `deadline`)
VALUES ("dfgnfdgn", 8,2,"2020-12-01");

INSERT INTO project (`title`,`user_id`) VALUES
                                          ("УЧЕБА",1),
                                          ("ВХОДЯЩИЕ",1),
                                          ("РАБОТА",1),
                                          ("ДОМАШНИЕ ДЕЛА",1),
                                          ("АВТО",1),
                                          ("МАГАЗИН",2),
                                          ("МЕТРО",2),
                                          ("ХЛАМ",2);

INSERT INTO users (`name`,`email`,`password`,id,`data`) VALUES
  ("denni","den@mirom@mir","aAESWF@Q",2,"2022-05-17"),
  ("konst","konst@mirom@mir","sdfc",1,"2022-03-17");

SELECT * FROM users ;
SELECT id FROM users ;



SELECT * FROM task WHERE USER=2 AND project_id=2;

UPDATE task SET STATUS = 1 WHERE NAME = "игры";


UPDATE task SET name = "home" WHERE id = 3;

SELECT title FROM project where user_id=2;
SELECT * FROM task LEFT JOIN project on task.project_id=project.id ;

SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=2;

SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=2;

SELECT NAME FROM  users WHERE id=1;

SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=2 and project_id=8;
SELECT * FROM task where user=2;
SELECT file FROM task where user=2;


