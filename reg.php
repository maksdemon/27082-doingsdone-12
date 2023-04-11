<?php

session_start();
$user = $_SESSION["user"]["id"];
$userID = (int)$user;
require_once('helpers.php');
$ts = time();
require_once('inidb.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//подключение к базе данных, вывод ошибки

mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
//      print("Соединение установлено");

}

//тестовый поиск id (ПОСЛЕ ИНДЕКС PHP ВЫВОДИТ ЧТО ВВЕЛИ)
$cat_task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

function check_email_dublicate($con, $user_mail)
{
    $email = mysqli_real_escape_string($con, $user_mail);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        return true;
    }
}

function insert_user_to_db($con, $data = [])
{
    $sql = 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)';

    $stmt = db_get_prepare_stmt($con, $sql, $data);
    return mysqli_stmt_execute($stmt);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ['email', 'password', 'name'];
    $errors = [];
    $user_name = $_POST['name'];
    $user_mail = $_POST['email'];
    $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//проверка на пустые поля
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }


    if (!empty($user_mail)) {
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail введён некорректно';
        } elseif (check_email_dublicate($con, $user_mail)) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }
    if (empty($errors)) {
        insert_user_to_db($con, [$user_name, $user_mail, $user_password]);

        header('Location: /');
        // var_dump($_POST);
    } else {
        $page_content = include_template(
            'reg.php',
            [
                'errors' => $errors
            ]
        );
    }
} else {
    $page_content = include_template(
        'reg.php'
    );
}


//скрипт добавления


if ($errors == false && $date) {
    $user_id = $result_name_nick3[0];
    $add_task_sql = 'INSERT INTO task (`name`, `project_id`, `user`,`deadline`,`file`) VALUES (?, ?,?,?,?)';
    // делаем подготовленное выражение
    $stmt = db_get_prepare_stmt($con, $add_task_sql, [
        $email,
        (int)$_POST['project2'],
        $user_id => $userID,
        $date,
        $original_name
    ]);

    mysqli_stmt_execute($stmt);

    header("Location: /");
} else {
}
//регистрация пользователя отправка в базу данных и редирект на главную



$title2 = "Дела в порядке ";

$user_task = [];


//вариант вывод ключей из массива $test,"title")
$page_content3 = include_template('../register.php', [

    'type_project' => $task_sql2,
    'task_c_name' => $task_count1,
    'task_count_all1' => $task_count_all,
    'errors' => $errors,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template(
    'layout-autorisation.php',
    [
        'content2' => $page_content3,
        //  'title1' => $title2,
        'name_user1' => $result_name_nick3
    ]
);


print ($layout_content);



