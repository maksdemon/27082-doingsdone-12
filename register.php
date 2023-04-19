<?php

require_once('init_db.php');
require_once('helpers.php');
include('functions.php');

$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ['email', 'password', 'name'];

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
        } elseif (check_email_duplicate($con, $user_mail)) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }
    if (empty($errors)) {
        insert_user_to_db($con, [$user_name, $user_mail, $user_password]);
        header('Location: /');
    } else {
        $page_content = include_template(
            'register.php',
            [
                'errors' => $errors
            ]
        );
    }
}

$page_content = include_template('register.php', [
    'errors' => $errors,
]);

$layout_content = include_template(
    'layout.php',
    [
        'content' => $page_content,
        'title'   => $config['title'],
    ]
);

print ($layout_content);



