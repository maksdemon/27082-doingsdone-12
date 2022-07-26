<?php
//$ts = time();
//echo ($ts);
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$type2=[ "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$task=[
    [
        'name' => 'Собеседование в IT компании',
        'date_complete' => '01.12.2019',
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
$title2="Дела в порядке 0";
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
}


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
