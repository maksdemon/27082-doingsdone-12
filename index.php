<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$type=[ "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
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
$title = "Дела в порядке";

function test_count ($task,$cat_task):int{
        $count = 0;
    foreach ($task as $key=>$value) {
        if ($value ['category'] == $cat_task) {
            $count++;
        }
    }
    return $count;
}
$content = include_template('main.php',[] );
$content = include_template('layout.php',[] );


//$count = 0;
//$num_count = count($task);
//$cat_task =$type[0];
/*foreach($task as $key => $value){   echo  $value['category'];}*/

/*
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
