<?php

require_once('helpers.php');
$ts = time();
//echo ($ts);
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//подключение к базе данных, вывод ошибки
$con = mysqli_connect("localhost", "root", "", "doingsdone_db");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
      print("Соединение установлено");
    // выполнение запросов
}

//тестовый поиск id (ПОСЛЕ ИНДЕКС PHP ВЫВОДИТ ЧТО ВВЕЛИ)
$cat_task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//echo "T".$cat_task_id."ЕУЧЕ";
function check_email_dublicate($con, $user_mail)
{
    $email = mysqli_real_escape_string($con, $user_mail);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        return true;
    }
}
$sql_id_max='SELECT id FROM USERS ORDER BY id DESC LIMIT 1';
function insert_user_to_db($con, $data=[])
{


    $sql = 'INSERT INTO users (name, email, password,id_user) VALUES (?, ?, ?,id_user= $sql_id_max+1)';
    $sql2= 'UPDATE users SET id_user=id WHERE id_user=0';
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

       // header('Location: /');
        var_dump($_POST);
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
        //     $tsql_project=>'project2',
        //   (int)$project_sq=>'project2',
        (int)$_POST['project2'],
        $user_id => 2,
        $date,
        $original_name
    ]);

    mysqli_stmt_execute($stmt);

    header("Location: /");


} else {

}
//регистрация пользователя отправка в базу данных и редирект на главную
//скрипт поиска ошибки





$title2 = "Дела в порядке ";
//$content2 = "";
//$name_user= "КОнстантин";
//$name_user= $result_name_nick3;
$user_task = [];


//вариант вывод ключей из массива $test,"title")
$page_content3 = include_template('../register.php', [
    // вывод из простого mysqli_fetch_all 'type1'=> array_column ($test,"title"),
    'type_project' => $task_sql2,
    //  'link_project'=>$task_sql_project_id,
    'task_c_name' => $task_count1,
    //'task_c_name'=>$task_count_oll,
    //'task_c_name2'=>$task_count,
    'task_count_oll1' => $task_count_oll,
    'errors' => $errors,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout-autorisation.php',
    [
        'content2' => $page_content3,
      //  'title1' => $title2,
        'name_user1' => $result_name_nick3
    ]);


//print ($page_content3 );
print ($layout_content);



