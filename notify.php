<?php
/**
 * @var mysqli $con подключение к базе
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'init_db.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

mysqli_set_charset($con, "utf8");
if ($con === false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

$dsn = 'smtp://gunseo@yandex.ru:Wjl9VBip2QUjn@smtp.yandex.ru:465?encryption=ssl&auth_mode=login';
// Настройки SMTP
$transport = Transport::fromDsn($dsn);
$mailer = new Mailer($transport);

$today = date('Y-m-d');
$sql = "SELECT *, task.name AS task_name, users.name AS user_name FROM task
            LEFT JOIN users ON task.user_id=users.id WHERE status=0 AND DATE_FORMAT(deadline, '%Y-%m-%d')=\"$today\"";
$res = mysqli_query($con, $sql);
$total = [];
if ($res && mysqli_num_rows($res)) {
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($result as $value) {
        $email = $value['email'];
        if (!array_key_exists($email, $total)) {
            $total[$email] = [
                'user_name' => $value['user_name'],
                'email'     => $value['email'],
                'task'      => [],
            ];
        }
        $total[$email]['task'][] = $value['task_name'];
    }
}

if ($total) {
    foreach ($total as $userTask) {
        $mailText = "\n" . 'Рассылка' . ' ' . 'Уважаемый пользователь, ' . $userTask['user_name'] . "\n" . 'У Вас запланирована задача - ' . "\n";
        foreach ($userTask['task'] as $todayTask) {
            $mailText .= $todayTask . ' на указанное число' . ' ' . $today . "\n";
        }

        $message = new Email();
        $message->to($userTask['email']);
        $message->from(new Address('gunseo@yandex.ru', 'keksobot'));
        $message->subject('Рассылка' . ' ' . 'Уведомление от сервиса «Дела в порядке»' . ' ' . $userTask['user_name']);
        $message->text($mailText);
        $mailer->send($message);
    }
}







