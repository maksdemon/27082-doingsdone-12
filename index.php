<?php

session_start();
require_once('inidb.php');
$user = $_SESSION["user"]["id"];
$userID = (int)$user;
if (!isset($_SESSION["user"]["id"])) {
    header("location: /templates/guestf.php");
    exit;
}
include('helpers.php');
$ts = time();
$show_complete_tasks = isset($_GET['show_completed']) ? (int)$_GET['show_completed'] : 1;
$cat_task_id2 = isset($_GET['filter']) ? (string )$_GET['show_completed'] : '';

$type2 = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

//подключение к базе данных, вывод ошибки

mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    //  print("Соединение установлено");
}

//тестовый поиск id (ПОСЛЕ ИНДЕКС PHP ВЫВОДИТ ЧТО ВВЕЛИ)
$cat_task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$cat_task_filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);

if ($cat_task_id) {
    $cat_task_id_show = "&id=" . $cat_task_id;
}

//категория задач
if (isset($cat_task_id)) {
    //пачка для выводу нужного проекта
    $task_usersql = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID and project_id=$cat_task_id ";
    $result_sql_task = mysqli_query($con, $task_usersql);
    $task_count1 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);


    //вывод по запросу
    if (!$task_count1) {
        http_response_code(404);
    }
} else {
    $sort_project = "SELECT * FROM task WHERE user= $userID ";
    $sort_project_vivod = mysqli_query($con, $sort_project);
    $task_sql_current = mysqli_fetch_all($sort_project_vivod, MYSQLI_ASSOC);
    //oll
    $task_usersql_oll = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID ";
    $result1_oll = mysqli_query($con, $task_usersql_oll);
    $task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);
    $task_count1 = 0;
    $task_count1 = $task_count_oll;
}
if (isset($_GET['q'])) {
    $search = trim(filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS));
    if (!empty($search)) {
        $con->set_charset("utf8mb4");

        $search_q = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID AND MATCH(name) AGAINST ( '$search')";
        $search_f = mysqli_query($con, $search_q);

        $task_count1 = $search_f;
        $records_count = mysqli_num_rows($task_count1);
        if ($records_count == 0) {
            $errorsearch2 = "Ничего не найдено по вашему запросу ";

        }
    }
}


$projectuser = "SELECT * FROM project where user_id=$userID";
$projectuser1 = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID";
$taskuser = "SELECT name FROM task WHERE USER=$userID";
$name_nick = "SELECT * FROM  users WHERE id=$userID";
// список задач с группами

$task_usersql_oll = "SELECT * FROM task LEFT JOIN project on task.project_id=project.id where user=$userID AND task.STATUS = 0 ";
$result1_oll = mysqli_query($con, $task_usersql_oll);


if ($result1_oll) { // всегда проверять, есть ли результат
    $task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);
}
$result = mysqli_query($con, $projectuser);


$result_name_nick = mysqli_query($con, $name_nick);
$sql_task_user = "SELECT name FROM task WHERE `user`=$userID";
$result_sql_user = mysqli_query($con, $sql_task_user);


$task_sql2 = mysqli_fetch_all($result, MYSQLI_ASSOC);


$result_name_nick3 = array_column((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)), "name");


$title2 = "Дела в порядке ";

$user_task = [];





//получение списка задач без выполненных
$task_active = "SELECT * FROM task where USER =$userID AND STATUS=0";
$result_task_active = mysqli_query($con, $task_active);
$task_sql_task_active = mysqli_fetch_all($result_task_active, MYSQLI_ASSOC);

if ($_GET['show_completed'] == 0) {
    $search = trim(filter_input(INPUT_GET, 'show_completed', FILTER_SANITIZE_SPECIAL_CHARS));
    if (isset($_GET['show_completed'])) {
        $con->set_charset("utf8mb4");

        if (isset($cat_task_id)) {
            $search_q = " SELECT * FROM task where USER =$userID AND STATUS=0 AND project_id =$cat_task_id" ;
            $search_f = mysqli_query($con, $search_q);
            $task_count1 = $search_f;
            $records_count = mysqli_num_rows($task_count1);
            if ($records_count == 0) {
                $errorsearch2 = "Ничего не найдено по вашему запросу ";

            }
        } else {
            $search_q = "SELECT * FROM task where USER =$userID AND STATUS=0";
            $search_f = mysqli_query($con, $search_q);
            $task_count1 = $search_f;
            $records_count = mysqli_num_rows($task_count1);
            if ($records_count == 0) {
                $errorsearch2 = "Ничего не найдено по вашему запросу ";
            }
        }
    } else {
    }
}


//задачи выполнено/не выполнено
$task_id_rev = '';

if (isset($_GET['task_id'])) {
    $task_id_rev = intval($_GET['task_id']);
}


if ($task_id_rev) {

    $task_status = "SELECT * FROM task  WHERE id = $task_id_rev";
    $result_task_status = mysqli_query($con, $task_status);
    $task_sql_task_status = mysqli_fetch_all($result_task_status, MYSQLI_ASSOC);

    if ($task_sql_task_status[0] ["STATUS"] === '0') {
        $sql = "UPDATE task SET STATUS = 1 WHERE id = $task_id_rev";
        $result = mysqli_query($con, $sql);

        header("Location: /");
    } else {
        if ($task_sql_task_status[0] ["STATUS"] === '1') {
            $sql = "UPDATE task SET STATUS = 0 WHERE id = $task_id_rev";
            $result = mysqli_query($con, $sql);

            header("Location: /");
        }
    }
}


//фильтр дат
$safeFilter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($safeFilter)) {
    if ($cat_task_filter == 'expired') {
        $task_count1 = [''];
        $task_usersql = "SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task = mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);
        $task_new = [];
        foreach ($result_sql_task as $task) {
            $task_new2 = 0;
            if (strtotime($task['deadline']) < strtotime(date('Y-m-d')) + 86400) {
                $task_new[$i] = $task;
                $i++;
            };
        }
        $task_count1 = $task_new;
    }
    if ($cat_task_filter == 'tommorow') {
        $task_count1 = [''];
        $task_usersql = "SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task = mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);
        $task_new = [];
        foreach ($result_sql_task as $task) {
            $task_new2 = 0;
            if (strtotime($task['deadline']) == strtotime(date('Y-m-d')) + 86400) {
                $task_new[$i] = $task;
                $i++;
            };
        }
        $task_count1 = $task_new;
    }
    if ($cat_task_filter == 'today') {
        $task_count1 = [''];
        $task_usersql = "SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task = mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);
        $task_new = [];
        foreach ($result_sql_task as $task) {
            $task_new2 = 0;
            if (strtotime($task['deadline']) == strtotime(date('Y-m-d'))) {
                $task_new[$i] = $task;
                $i++;
            };
        }
        $task_count1 = $task_new;
    }
}


function filterToday($task_count_oll)
{
    $task_count_oll = [];
    foreach ($task_count_oll as $task) :
        if (strtotime($task['deadline']) == strtotime(date('Y-m-d'))) {
            array_push($task_count_oll, $task);
        };
    endforeach;
    return $task_count_oll;
    //  var_dump($task_count_oll);

}

;


function filterExpired($task_count_oll)
{
    $ts = time();
    $task_count_oll = [];
    foreach ($task_count_oll as $task) :
        if (strtotime($task['deadline']) < strtotime($ts)) {
            array_push($task_count_oll, $task);
        };
    endforeach;
    return $task_count_oll;
}

;


//вариант вывода ключей из массива $test,"title")
$page_content3 = include_template('main.php', [
    'type_project' => $task_sql2,
    'task_c_name' => $task_count1,
    'errorsearch2' => $errorsearch2,
    'task_count_oll1' => $task_count_oll,
    'id_cat' => $cat_task_id,
    'id_task_time' => $cat_task_filter,
    'id_task_showid' => $cat_task_id_show,
    'id_task_showid2' => $cat_task_id2,
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


print ($layout_content);

//подсчет количества задач
function test_count($task_count_oll1, $cat_task): int
{
    $count = 0;
    foreach ($task_count_oll1 as $value) {
        if ($value ['title'] == $cat_task) {
            $count++;
        }
    }
    return $count;
}




// тестовая функция подсчета оставшегося времени
function date_diff3($date)
{
    $ts = time();
    $task_date_str = strtotime($date);
    $diff = floor(($task_date_str - $ts) / 3600);
    return $diff;
}


//список задач

$projects = [];


?>
