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
//подключение к базе данных, вывод ошибки
$con = mysqli_connect("localhost", "root", "", "doingsdone_db");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    print("Соединение установлено");
    // выполнение запросов
}


$projectuser = "SELECT title FROM project where id_user=1";
$taskuser ="SELECT name FROM task WHERE USER=1";
$name_nick="SELECT * FROM  users WHERE id_user=1";
// список задач с группами
$task_usersql="SELECT * FROM project LEFT JOIN task on task.project_id=project.id where id_user=1";
$result = mysqli_query($con, $projectuser);
$result_sql_task= mysqli_query($con, $task_usersql);
$result_name_nick = mysqli_query($con, $name_nick);

//echo $result;
// список задач простым массивом из ассотиативного
$task_sql = array_column ((mysqli_fetch_all($result, MYSQLI_ASSOC)),"title");

//print_r ($task_sql);

$task_count = mysqli_fetch_all($result_sql_task, MYSQLI_ASSOC);
//print_r( $task_count);
//ник пользователя

//$result_name_nick1 =mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC);

$result_name_nick3 = array_column ((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)),"name");
//print_r ($result_name_nick1);

//print_r ($result_name_nick1);
/*echo "<pre>";
print_r ($result_name_nick3);
echo "</pre>";
*/
//echo $result_name_nick2;
/*
$result_name_nick2  = array_column ((mysqli_fetch_all($result_name_nick1, MYSQLI_ASSOC)),"name");
echo "<pre>";
print_r( $result_name_nick2);
echo "</pre>";
*/
//echo $test;
/*
echo "<pre>";
print_r($task_count);
echo "</pre>";
*/
/*
foreach ($test as $row) {
    print(" Категория: " . $row['title']);
}
*/


require_once ('helpers.php');
$title2="Дела в порядке ";
//$content2 = "";
//$name_user= "КОнстантин";
$name_user= [$result_name_nick3];
$user_task=[];
//вариант вывод ключей из массива $test,"title")
$page_content3= include_template ('main.php', [
   // вывод из простого mysqli_fetch_all 'type1'=> array_column ($test,"title"),
    'type1'=> $task_sql,
    'task3'=>$task_count,
    'show_complete_tasks'=> $show_complete_tasks]);
$layout_content =include_template ('layout.php',
    ['content2'=>$page_content3,
        'title1'=> $title2,
        'name_user1' => $result_name_nick3
    ]);

print ($layout_content);

//подсчет количества задач
function test_count ( $task_count , $cat_task):int{
        $count = 0;
    foreach ($task_count  as $value) {
        if ($value ['title'] == $cat_task) {
            $count++;
        }
    }
    return $count;
};
//echo $test_count ."111";


// тестовая йункция подсчета оставвшегося времени
function date_diff3 ($date){
    $ts = time();
    $task_date_str =strtotime($date);
    $diff =  floor(($task_date_str-$ts)/3600);
    return $diff;
}





//список задач

$projects=[];


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
