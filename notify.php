<?php
/**
 * @var mysqli $con подключение к базе
 */

require_once 'vendor/autoload.php';
include ('index.php');

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\BodyRenderer;

$con = mysqli_connect("localhost", "root", "", "doingsdone_db");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
      print("Соединение установлено");
    // выполнение запросов
}

/*
sql=
SELECT * FROM task LEFT JOIN users on task.user =users.id;

*/


//$dsn = 'smtp://gikser@mail.ru:QJsUEMAn0bMtDX3fA9dM@smtp.mail.ru:465';
$dsn = 'smtp://gunseo@yandex.ru:Wjl9VBip2QUjn@smtp.yandex.ru:465?encryption=ssl&auth_mode=login';
// Настройки SMTP
$transport = Transport::fromDsn($dsn);
$mailer = new Mailer($transport);
//$sql= 'SELECT * FROM task LEFT JOIN users on task.user =users.id  WHERE DATE(deadline) = DATE(NOW()) and status = 0 ';
//$sql= 'SELECT * FROM task LEFT JOIN users on task.user =users.id  WHERE  status = 0 ';
$sql= 'SELECT task.id,task.name AS task_name,deadline,created_at, project_id,file,email,id_user,STATUS,USER,USERs.name FROM task LEFT JOIN users on task.user =users.id  WHERE  status = 0';

$res = mysqli_query($con, $sql);


if ($res && mysqli_num_rows($res)) {
$rezult =  mysqli_fetch_all($res, MYSQLI_ASSOC);
        $itog =[];
        foreach ($rezult as $value){
            $email = $value['email'];

            if(!array_key_exists($email,  $itog)) {
                $itog[$email] = [
                    'username' => $value['name'],
                    'email' => $value['email'],
                    'task' => [],

                ];
            }
            $itog[$email]['task'][] =$value['task_name'];
       //     echo $value['task_name'];
        }
      //  return $itog;

}
$today = date('Y-m-d');


    foreach ($itog as $userTask)
    {
        $mailText = "\n" . 'Уважаемый пользователь, ' . $userTask['username'] . "\n" . 'У Вас запланирована задача - ' . "\n";

        foreach ($userTask['task'] as $todayTask)
        {
            $mailText = $mailText.$todayTask . ' на указанное число'.' '. $today . "\n";

        };

        $message = new Email();
        $message->to('gikser@mail.ru');
        $message->from('gunseo@yandex.ru');
        $message->subject('Уведомление от сервиса «Дела в порядке»'.' '.$userTask['username']);
        $message->text($mailText);


        $mailer->send($message);

    }







/*
if (isset($value)) {
    $today = date('Y-m-d');
//  $test="demovariable";
//  $taskmail = mysqli_fetch_all($res, MYSQLI_ASSOC);
// print_r($taskmail );
    $recipients = "gikser@mail.ru";
    $message = new Email();
    $message->subject("testname");
    $message->from('gunseo@yandex.ru');
    $message->to($recipients);
//  $message->text("This is the plain text body of the message.\nThanks,   \nAdmin");
//   $message = "\n" . 'Уважаемый, ' . $userTask['username'] . "\n" . 'У Вас запланирована задача - ' . "\n";

    foreach ($itog[$email] as $task) {
        $message .= 'У вас запланирована задача: ';
        $message .= $task['title'];
        $message .= ' на ' . date('d.m.Y', strtotime($task['deadline']));
        $message .= '\n';
    }


    foreach ($itog as $todayTask) {
        $mailText = $mailText . $todayTask . ' на ' . $today . "\n";
    };

    $result = $mailer->send($message);
    if (!$result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку");
    }

}

*/


/*
foreach ($allUsersTasks as $userTask)
{
    $mailText = "\n" . 'Уважаемый, ' . $userTask['username'] . "\n" . 'У Вас запланирована задача - ' . "\n";
    foreach ($userTask['taskname'] as $todayTask)
    {
        $mailText = $mailText.$todayTask . ' на ' . $today . "\n";
    };

    $message = new Email();
    $message->to($userTask['email']);
    $message->from('keks@phpdemo.ru');
    $message->subject('Уведомление от сервиса «Дела в порядке»');
    $message->text($mailText);

    $mailer = getMailer();
    $mailer->send($message);
}
*/
