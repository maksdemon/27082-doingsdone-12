<?php

session_start();
require_once('helpers.php');
require_once('init_db.php');

//правка на авторизацию
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $required_fields = ['email', 'password'];
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
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $sql);
    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
    if (!count($errors) && $user) {
        if (password_verify($user_guest['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }
    if (!count($errors)) {
        header("Location: /");
    }
} else if (isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

$page_content = include_template('auth.php', [
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
