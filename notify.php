<?php
/**
 * @var mysqli $con подключение к базе
 */

require_once 'vendor/autoload.php';
require_once 'inidb.php';
include('index.php');

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;


mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {

}


$dsn = 'smtp://gunseo@yandex.ru:Wjl9VBip2QUjn@smtp.yandex.ru:465?encryption=ssl&auth_mode=login';
// Настройки SMTP
$transport = Transport::fromDsn($dsn);
$mailer = new Mailer($transport);

$today = date('Y-m-d');
$sql = "SELECT task.id,task.name AS task_name,deadline,created_at, project_id,file,email,id_user,STATUS,USER,USERs.name FROM task LEFT JOIN users on task.user =users.id  WHERE  status = 0 AND deadline = $today";

$res = mysqli_query($con, $sql);


if ($res && mysqli_num_rows($res)) {
    $rezult = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $total = [];
    foreach ($rezult as $value) {
        $email = $value['email'];

        if (!array_key_exists($email, $total)) {
            $total[$email] = [
                'username' => $value['name'],
                'email' => $value['email'],
                'task' => [],

            ];
        }
        $total[$email]['task'][] = $value['task_name'];
    }
} else {
    $total = [];
}
if ($total) {
    foreach ($total as $userTask) {
        $mailText = "\n" . 'Рассылка' . ' ' . 'Уважаемый пользователь, ' . $userTask['username'] . "\n" . 'У Вас запланирована задача - ' . "\n";

        foreach ($userTask['task'] as $todayTask) {
            $mailText = $mailText . $todayTask . ' на указанное число' . ' ' . $today . "\n";
        };
        $message = new Email();
        $message->to($userTask['email']);
        $message->from(new Address('gunseo@yandex.ru', 'keksobot'));
        $message->subject('Рассылка' . ' ' . 'Уведомление от сервиса «Дела в порядке»' . ' ' . $userTask['username']);
        $message->text($mailText);
        $mailer->send($message);
    }
}







