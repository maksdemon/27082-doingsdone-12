<?php

session_start();
$user = $_SESSION["user"]["id"];
$userID = (int)$user;

require_once('inidb.php');
require_once('helpers.php');
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
    //пачка для вывода нужного проекта

    $task_usersql = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID and project_id=$cat_task_id ";
    $result_sql_task = mysqli_query($con, $task_usersql);
    $task_count1 = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);

    //вывод по запросу
    if (!$task_count1) {
        http_response_code(404);
    }
} else {
    $sort_project = "SELECT * FROM task WHERE USER=$userID ";
    $sort_project_vivod = mysqli_query($con, $sort_project);
    $task_sql_current = mysqli_fetch_all($sort_project_vivod, MYSQLI_ASSOC);
    $task_usersql_oll = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID ";
    $result1_oll = mysqli_query($con, $task_usersql_oll);
    $task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);
    $task_count1 = 0;
    $task_count1 = $task_count_oll;
}


$projectuser = "SELECT * FROM project where user_id=$userID";

$taskuser = "SELECT * FROM task WHERE USER=$userID";
$name_nick = "SELECT * FROM  users WHERE id=$userID";

$result2_oll_user = mysqli_query($con, $taskuser);
$task_count_oll2 = mysqli_fetch_all($result2_oll_user, MYSQLI_ASSOC);

// список задач с группами

$task_usersql_oll = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID AND task.STATUS = 0 ";
$result1_oll = mysqli_query($con, $task_usersql_oll);
$task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);

$result_name_nick = mysqli_query($con, $name_nick);
$sql_task_user = 'SELECT * FROM task WHERE `user`=$userID';
$result_sql_user = mysqli_query($con, $sql_task_user);
$result = mysqli_query($con, $projectuser);

$task_done_sql = "UPDATE task SET STATUS = 1 WHERE id = $taskId";



// список задач простым массивом из ассоциативного


$task_sql2 = mysqli_fetch_all($result, MYSQLI_ASSOC);

//ник пользователя

$result_name_nick3 = array_column((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)), "name");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    $tsql_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
    if (!$tsql_name) {
        $errors['$tsql_name'] = 'Название не введено';
    }

    $result_name_nick3 = array_column((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)), "name");

//проверка ,что есть название

    $project_err = filter_input(INPUT_POST, 'project', FILTER_VALIDATE_INT, ['options' => ['default' => 0]]);
//проверка даты
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);


    if ($date) {
        if (is_date_valid($date)) {
            if (strtotime($date) < strtotime('now')) {
                $errors['date'] = 'Выбрана прошедшая или уже наступившая дата';
            }
        } else {
            $errors['date'] = 'Дата не корректна';
        }
    } else {
        $errors['date'] = 'Дата не заполнена';
    };


    if (is_uploaded_file($_FILES['file']['tmp_name'])) { // была загрузка файла
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) { // Если загружен файл и нет ошибок, то сохраняем его в папку
            $original_name = $_FILES['file']['name'];

            $target = __DIR__ . '/uploads/' . $original_name;

            // сохраняем файл в папке
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $errors['file'] = 'Не удалось сохранить файл.';
            }
        } else {
            $errors['file'] = 'Ошибка ' . $_FILES['file']['error'] . ' при загрузке файла. <a href="https://www.php.net/manual/ru/features.file-upload.errors.php" target="_blank">Код ошибки</a>';
        }
    };

}

if ($errors == false && $date) {
    $user_id = $result_name_nick3[0];
    $add_task_sql = 'INSERT INTO task (`name`, `project_id`, `user`,`deadline`,`file`) VALUES (?, ?,?,?,?)';
    // делаем подготовленное выражение
    $stmt = db_get_prepare_stmt($con, $add_task_sql, [
        $tsql_name,
        (int)$_POST['project2'],
        $user_id => $userID,
        $date,
        $original_name

    ]);

    // исполняем подготовленное выражение
    mysqli_stmt_execute($stmt);
    header('Location: /');
} else {
}


$title2 = "Дела в порядке ";

$user_task = [];


//вариант вывод ключей из массива $test,"title")
$page_content3 = include_template('../pages/form-task.php', [

    'type_project' => $task_sql2,

    'task_c_name' => $task_count1,

    'task_count_oll1' => $task_count_oll,
    'errors' => $errors,
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
