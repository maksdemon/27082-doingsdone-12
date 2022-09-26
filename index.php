<?php
$ts = time();
//echo ($ts);
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$type2=[ "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$task=[
    [
        'name' => 'Собеседование в IT компании',
        'date_complete' => '18.08.2022',
        'category' => 'Работа',
        'status'=>'false'
    ],
    [
        'name' => 'Выполнить тестовое задание',
        'date_complete' => '25.12.2019',
        'category' => 'Работа',
        'status'=>'false'
    ],

    [
        'name' => 'Сделать задание первого раздела',
        'date_complete' => '21.12.2019',
        'category' => 'Учеба',
        'status'=>'true'
    ],
    [
        'name' => 'Встреча с другом',
        'date_complete' => '22.12.2019',
        'category' => 'Входящие',
        'status'=>'false'
    ],
    [
        'name' => 'Купить корм для кота	',
        'date_complete' => 'null',
        'category' => 'Домашние дела',
        'status'=>'false'
    ],
    [
        'name' => 'Заказать пиццу',
        'date_complete' => 'null',
        'category' => 'Домашние дела',
        'status'=>'false'
    ]

];
require_once ('helpers.php');
$title2="Дела в порядке ";
//$content2 = "";
$name_user="КОнстантин";

$page_content3= include_template ('main.php', ['type1'=>$type2,
    'task3'=>$task, 'show_complete_tasks'=> $show_complete_tasks]);
$layout_content =include_template ('layout.php',['content2'=>$page_content3, 'title1'=> $title2, 'name_user1' => $name_user]);

print ($layout_content);


function test_count ($task,$cat_task):int{
        $count = 0;
    foreach ($task as $key=>$value) {
        if ($value ['category'] == $cat_task) {
            $count++;
        }
    }
    return $count;
};

// тестовая йункция подсчета
function date_diff3 ($date){
    $ts = time();
    $task_date_str =strtotime($date);
    $diff =  floor(($task_date_str-$ts)/3600);
    return $diff;
}




$con = mysqli_connect("localhost", "root", "", "doingsdone_db");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    print("Соединение установлено");
    // выполнение запросов
}
$projectuser = "SELECT title FROM project where id_user=2";
$taskuser ="SELECT name FROM task WHERE USER=2";
$result = mysqli_query($con, $sql);

$test = mysqli_fetch_all($result, MYSQLI_ASSOC);
//echo $test;
echo "<pre>";
print_r($test);
echo "</pre>";

foreach ($test as $row) {
    print(" Категория: " . $row['title']);
}




/* пример обработки ошибки
if (!$result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL: " . $error);
}
*/

/* ошибка
$date_now = date_create('now');
$date_task = date_create($task['date_complete']);
$date_diff1 = date_diff($date_task,$date_now);
$date_diff2 = date_format('%a ');
*/
/*
function date_diff3 ($date){
    $datetime1 = date_create('now');
    $date2 = date_create($date);
    $interval = date_diff($datetime1, $date2);
    $interval->format('%a');
    $interval2=(int)$interval;
    return $interval2;
}
*/



/*
 //$count = 0;
//$num_count = count($task);
//$cat_task =$type[0];

/*foreach($task as $key => $value){   echo  $value['category'];}
function test_count($task,$cat_task){
    $count2=0;
    $count = 0;
    $num_count = count($task);
    while ($count<$num_count){
        if ($cat_task==$task [$count]['category']){
            $count2++;
        }
        $count++;
        //echo $count;
    }
    return $count2;
}*/
//echo test_count($task,$cat_task)," test";



?>
