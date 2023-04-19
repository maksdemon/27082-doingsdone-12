<?php

require_once('init_db.php');
include('helpers.php');
include('functions.php');

session_start();

$user_id = check_auth($config['title']);

$error_message = '';
$project_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
if (!$project_name) {
    $error_message = 'Название не введено';
}
if (!$error_message) {
    $sql = 'INSERT INTO project (`title`, `user_id`) VALUES (?, ?)';
    // создаем подготовленное выражение
    $stmt = db_get_prepare_stmt($con, $sql, [
        $project_name,
        $user_id => $user_id,
    ]);

    // исполняем подготовленное выражение
    mysqli_stmt_execute($stmt);
    header('Location: /');
}

$page_content = include_template('../pages/form-project.php', [
    'user_projects'  => get_user_projects($con, $user_id),
    'all_user_tasks' => get_all_user_projects($con, $user_id),
    'error_message'  => $error_message,
]);

$layout_content = include_template(
    'layout.php',
    [
        'content'   => $page_content,
        'title'     => $config['title'],
        'name_user' => get_user_name($con, $user_id)
    ]
);

print ($layout_content);
