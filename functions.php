<?php

include('helpers.php');
require_once('inidb.php');

$ts = time();

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$type2 = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

//подключение к базе данных, вывод ошибки

mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {

}

//тестовый поиск id (ПОСЛЕ ИНДЕКС PHP ВЫВОДИТ ЧТО ВВЕЛИ)
$cat_task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);



if (isset($cat_task_id)) {
    $task_usersql = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=$userID and project_id=$cat_task_id ";
    $result_sql_task = mysqli_query($con, $task_usersql);
    $task_count1 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);

    if (!$task_count1) {
        http_response_code(404);
    }
} else {
    $sort_project = "SELECT * FROM task WHERE USER=2 ";
    $sorted_projects_tasks = mysqli_query($con, $sort_project);
    $task_sql_current = mysqli_fetch_all($sorted_projects_tasks, MYSQLI_ASSOC);
    //all
    $task_usersql_all = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=$userID ";
    $result1_all = mysqli_query($con, $task_usersql_all);
    $task_count_all = mysqli_fetch_all($result1_all, MYSQLI_ASSOC);
    $task_count1 = 0;
    $task_count1 = $task_count_all;

}


$projectuser = "SELECT * FROM project where user_id=$userID";
$projectuser1 = "SELECT * FROM project where user_id=$userID";
$taskuser = "SELECT name FROM task WHERE USER=$userID";
$name_nick = "SELECT * FROM  users WHERE id=$userID";

$task_usersql_all = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user_id=$userID ";
$result1_all = mysqli_query($con, $task_usersql_all);
$task_count_all = mysqli_fetch_all($result1_all, MYSQLI_ASSOC);

$result = mysqli_query($con, $projectuser);
$result_name_nick = mysqli_query($con, $name_nick);
$sql_task_user = 'SELECT name FROM task WHERE `user`=$userID';
$result_sql_user = mysqli_query($con, $sql_task_user);
$task_sql2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
$result_name_nick3 = array_column((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)), "name");

$title2 = "Дела в порядке ";

$name_user = $result_name_nick3;
$user_task = [];

//вариант вывод ключей из массива $test,"title")
$page_content3 = include_template('main.php', [

    'type_project' => $task_sql2,
    'task_c_name' => $task_count1,
    'task_count_all1' => $task_count_all,
    'show_complete_tasks' => $show_complete_tasks
]);
$layout_content = include_template(
    'layout.php',
    [
        'content2' => $page_content3,
        'title1' => $title2,
        'name_user1' => $result_name_nick3
    ]
);



//подсчет количества задач
function test_count($task_count_all1, $cat_task): int
{
    $count = 0;
    foreach ($task_count_all1 as $value) {
        if ($value ['title'] == $cat_task) {
            $count++;
        }
    }
    return $count;
}

;


// тестовая функция подсчета оставшегося времени
function date_diff3($date)
{
    $ts = time();
    $task_date_str = strtotime($date);
    $diff = floor(($task_date_str - $ts) / 3600);
    return $diff;
}


$projects = [];


?>
