<?php

require_once('init_db.php');
require_once('helpers.php');
include('functions.php');

session_start();

$user_id = check_auth($config['title']);

$task_name = '';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
    if (!$task_name) {
        $errors['task_name'] = 'Название не введено';
    }
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
    if ($date) {
        if (is_date_valid($date)) {
            if (strtotime($date) < time()) {
                $errors['date'] = 'Выбрана прошедшая или уже наступившая дата';
            }
        } else {
            $errors['date'] = 'Дата не корректна';
        }
    } else {
        $errors['date'] = 'Дата не заполнена';
    }

    $original_name = '';
    if (is_uploaded_file($_FILES['file']['tmp_name'])) { // была загрузка файла
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) { // если загружен файл и нет ошибок, то сохраняем его в папку
            $original_name = $_FILES['file']['name'];

            $target = __DIR__ . '/uploads/' . $original_name;

            // сохраняем файл в папке
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $errors['file'] = 'Не удалось сохранить файл.';
            }
        } else {
            $errors['file'] = 'Ошибка ' . $_FILES['file']['error'] . ' при загрузке файла. <a href="https://www.php.net/manual/ru/features.file-upload.errors.php" target="_blank">Код ошибки</a>';
        }
    }

    if (!$errors) {
        $sql = 'INSERT INTO task (`name`, `project_id`, `user_id`, `deadline`, `file`) VALUES (?, ?, ?, ?, ?)';
        // делаем подготовленное выражение
        $stmt = db_get_prepare_stmt($con, $sql, [
            $task_name,
            (int)$_POST['project'],
            $user_id,
            $date,
            $original_name
        ]);

        // исполняем подготовленное выражение
        mysqli_stmt_execute($stmt);
        header("Location: /?project_id=" . $_POST['project']);
    }
}

$page_content = include_template('../pages/form-task.php', [
    'user_projects'  => get_user_projects($con, $user_id),
    'all_user_tasks' => get_all_user_projects($con, $user_id),
    'task_name'      => $task_name,
    'errors'         => $errors,
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
