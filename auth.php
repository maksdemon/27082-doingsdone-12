<?php

session_start();
require_once('helpers.php');
$ts = time();
require_once('inidb.php');
define('CACHE_DIR', basename(__DIR__ . DIRECTORY_SEPARATOR . 'cache'));
define('UPLOAD_PATH', basename(__DIR__ . DIRECTORY_SEPARATOR . 'uploads'));

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


//подключение к базе данных, вывод ошибки

mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {


}


function check_email_dublicate($con, $user_mail)
{
    $email = mysqli_real_escape_string($con, $user_mail);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        return true;
    }
}


$users = $userID;
//правка на авторизацию
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ['email', 'password'];
    $errors = [];
    $user_guest = $_POST;
    $required = ["email", "password"];
//проверка на пустые поля
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
//проверка почты
    $email = mysqli_real_escape_string($con, $user_guest["email"]);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
    if (!count($errors) and $user) {
        if (password_verify($user_guest['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }
    if (count($errors)) {
        $page_content = include_template('enter.php', ['form' => $user_guest, 'errors' => $errors]);
    } else {
        $page_content = include_template(
            header("Location: /")
        );
    }
} else {
    $page_content = include_template('auth.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: /");
        exit();
    }
}



$title2 = "Дела в порядке ";

$user_task = [];


//вариант вывод ключей из массива $test,"title")
$page_content3 = include_template('authf.php', [

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
        'name_user1' => $result_name_nick3
    ]
);



print ($layout_content);
