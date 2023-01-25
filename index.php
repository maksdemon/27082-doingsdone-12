<?php
///require_once ('helpers.php');
///
// $userID = $_SESSION['id'];
//$userName = $_SESSION['user'];
//$user = $_SESSION["user"];
// Если пользователь не вошёл в систему (т.е. нет о нем информации в сессии), подключаем тут же (!) страницу для гостя и выходим
session_start();

$user = $_SESSION["user"]["id"];
$userID=(int)$user;
if (!isset($_SESSION["user"]["id"])) {
header("location: /templates/guestf.php");
exit;}
//echo($userID);

//echo "<pre>";
//print_r ($user = $_SESSION["user"]);
//  echo "</pre>";
include ('helpers.php');
$ts = time();
//echo ($ts);
// показывать или нет выполненные задачи

//test

//test



$show_complete_tasks =  isset($_GET['show_completed']) ? (int)$_GET['show_completed'] : 1;
$cat_task_id2 =  isset($_GET['filter']) ? (string )$_GET['show_completed'] : '';
echo ( $cat_task_id2 );
$type2=[ "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

//подключение к базе данных, вывод ошибки
$con = mysqli_connect("localhost", "root", "", "doingsdone_db");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
  //  print("Соединение установлено");
    // выполнение запросов
}

//тестовый поиск id (ПОСЛЕ ИНДЕКС PHP ВЫВОДИТ ЧТО ВВЕЛИ)
$cat_task_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$cat_task_filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
//echo ($cat_task_filter);
if( $cat_task_id){
    $cat_task_id_show= "&id=".$cat_task_id;
   echo ($cat_task_id_show);
 //   echo(33);
}


if(isset($cat_task_id)){
    //пачка для выводу нужного проекта
   // $sort_project="SELECT * FROM task WHERE USER=2 AND project_id=$cat_task_id";
    $task_usersql="SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID and project_id=$cat_task_id ";
    $result_sql_task= mysqli_query($con, $task_usersql);
    $task_count1 = mysqli_fetch_all($result_sql_task , MYSQLI_ASSOC);

  //  echo "<pre>";
   // print_r ($task_count1);
   //echo "</pre>";
    //вывод по запросу
    if (!$task_count1){
        http_response_code(404);
    }

}
else  {

    $sort_project="SELECT * FROM task WHERE user= $userID ";
    $sort_project_vivod=mysqli_query($con, $sort_project);
    $task_sql_current = mysqli_fetch_all($sort_project_vivod, MYSQLI_ASSOC);
    //oll
    $task_usersql_oll="SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID ";
    $result1_oll = mysqli_query($con, $task_usersql_oll);
    $task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);
    $task_count1=0;
    $task_count1=$task_count_oll;

}
if (isset($_GET['q'])) {
        $search = trim(filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS));
            if (!empty($search)) {
               $con->set_charset("utf8mb4");
               // $search_q = "SELECT * FROM task where user=$userID and MATCH(name) AGAINST (?)";
                $search_q = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID AND MATCH(name) AGAINST ( '$search')";
                $search_f = mysqli_query($con, $search_q);
              //  $task_count1=0;
                $task_count1=$search_f;
                $records_count = mysqli_num_rows( $task_count1);
                if($records_count==0){
                        $errorsearch2 = "Ничего не найдено по вашему запросу ";
                       // echo ($errorsearch2);
                    }
            }
    }



$projectuser = "SELECT * FROM project where user_id=$userID";
$projectuser1 = "SELECT * FROM project LEFT JOIN task on task.project_id=project.id where user=$userID";
$taskuser ="SELECT name FROM task WHERE USER=$userID";
$name_nick="SELECT * FROM  users WHERE id=$userID";
// список задач с группами

$task_usersql_oll="SELECT * FROM task LEFT JOIN project on task.project_id=project.id where user=$userID AND task.STATUS = 0 ";
$result1_oll = mysqli_query($con, $task_usersql_oll);


if($result1_oll) { // всегда проверять, есть ли результат
    $task_count_oll = mysqli_fetch_all($result1_oll, MYSQLI_ASSOC);
}
$result = mysqli_query($con, $projectuser);
//$result1 = mysqli_query($con, $task_usersql);

$result_name_nick = mysqli_query($con, $name_nick);
$sql_task_user= "SELECT name FROM task WHERE `user`=$userID";
$result_sql_user= mysqli_query($con, $sql_task_user);


$task_sql2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
/*
echo '<pre>';
print_r($task_sql2);
echo '</pre>';
*/

$result_name_nick3 = array_column ((mysqli_fetch_all($result_name_nick, MYSQLI_ASSOC)),"name");



$title2="Дела в порядке ";

$user_task=[];



//смена статуса выполнения


//получение спика задач без выполненных
$task_active ="SELECT * FROM task where USER =$userID AND STATUS=0" ;
$result_task_active= mysqli_query($con, $task_active);
$task_sql_task_active = mysqli_fetch_all($result_task_active, MYSQLI_ASSOC);

if ($_GET['show_completed'] == 0) {
    $search = trim(filter_input(INPUT_GET, 'show_completed', FILTER_SANITIZE_SPECIAL_CHARS));
    if (isset($_GET['show_completed'])) {
        $con->set_charset("utf8mb4");
        // $search_q = "SELECT * FROM task where user=$userID and MATCH(name) AGAINST (?)";
        if (isset($cat_task_id)){
            $search_q = " SELECT * FROM task where USER =$userID AND STATUS=0 AND project_id =$cat_task_id";
            $search_f = mysqli_query($con, $search_q);
            //  $task_count1=0;
            $task_count1=$search_f;
            $records_count = mysqli_num_rows( $task_count1);
            if($records_count==0){
                $errorsearch2 = "Ничего не найдено по вашему запросу ";
                // echo ($errorsearch2);
            }
        }
        else{
            $search_q = "SELECT name FROM task where USER =$userID AND STATUS=0";
            $search_f = mysqli_query($con, $search_q);
            //  $task_count1=0;
            $task_count1=$search_f;
            $records_count = mysqli_num_rows( $task_count1);
            if($records_count==0){
                $errorsearch2 = "Ничего не найдено по вашему запросу ";
                // echo ($errorsearch2);
            }
        }

    }
    else{

    }
}



//задчи выполнено/невыполнено
$task_id_rev='';

if (isset($_GET['task_id'])){
    $task_id_rev= intval($_GET['task_id']);
}



if ($task_id_rev) {
   // echo('test0');
    $task_status ="SELECT * FROM task  WHERE id = $task_id_rev" ;
    $result_task_status = mysqli_query($con, $task_status);
    $task_sql_task_status = mysqli_fetch_all($result_task_status, MYSQLI_ASSOC);

        if ($task_sql_task_status[0] ["STATUS"] === '0') {

            $sql = "UPDATE task SET STATUS = 1 WHERE id = $task_id_rev";
            $result = mysqli_query($con, $sql);
          //  header("Location: /(if(isset($cat_task_id))id=$cat_task_id");
                header("Location: /");
        }
        else {
            if ($task_sql_task_status[0] ["STATUS"] === '1') {

                $sql = "UPDATE task SET STATUS = 0 WHERE id = $task_id_rev";
                $result = mysqli_query($con, $sql);
             //   header("Location: /".if(isset($cat_task_id))id=$cat_task_id);
                header("Location: /");

            }


            }

}

/*
echo "<pre>";
var_dump($task_sql_task_status );
echo "</pre>";
*/

//фильтр дат
$safeFilter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);

//$tasks = filterTasks($task_count_oll, $safeFilter);
if(isset($safeFilter)){
    if ($cat_task_filter == 'expired'){
        $task_count1=[''];
        $task_usersql="SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task= mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task , MYSQLI_ASSOC);
        $task_new=[];
        foreach ($result_sql_task as $task){
            $task_new2=0;
            if (strtotime($task['deadline']) < strtotime(date('Y-m-d')) + 86400) {
                // array_push( $task_count1, $task);
                $task_new[$i]=$task;
                $i++;
            };

        }
        $task_count1=$task_new;


    }
    if ($cat_task_filter == 'tommorow'){
        $task_count1=[''];
        $task_usersql="SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task= mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task , MYSQLI_ASSOC);
        $task_new=[];
        foreach ($result_sql_task as $task){
            $task_new2=0;
            if (strtotime($task['deadline']) == strtotime(date('Y-m-d')) + 86400) {
                // array_push( $task_count1, $task);
                $task_new[$i]=$task;
                $i++;
            };

        }
        $task_count1=$task_new;

    }
    if ($cat_task_filter == 'today'){
        $task_count1=[''];
        $task_usersql="SELECT * FROM task WHERE `user`=$userID";
        $result_sql_task= mysqli_query($con, $task_usersql);
        $task_count2 = mysqli_fetch_all($result_sql_task , MYSQLI_ASSOC);
        $task_new=[];
        foreach ($result_sql_task as $task){
            $task_new2=0;
            if (strtotime($task['deadline']) == strtotime(date('Y-m-d'))) {
                // array_push( $task_count1, $task);
                $task_new[$i]=$task;
                $i++;
            };

        }
        $task_count1=$task_new;

    }

}



function filterToday($task_count_oll)
{
    $task_count_oll = [];
    foreach ($task_count_oll as $task) :
        if (strtotime($task['deadline']) == strtotime(date('Y-m-d'))) {
            array_push($task_count_oll, $task);
        };
    endforeach;
    return $task_count_oll;
  //  var_dump($task_count_oll);

};




function filterExpired($task_count_oll)
{$ts = time();
    $task_count_oll = [];
    foreach ($task_count_oll as $task) :
        if (strtotime($task['deadline']) < strtotime($ts)) {
            array_push($task_count_oll, $task);
        };
    endforeach;
    return $task_count_oll;
};
//$filterTasks = [];
/*
function filterTasks($task_count_oll, $filter)
{


    if ($filter == 'today') {
        $task_count_oll = filterToday($task_count_oll);
        var_dump ($task_count_oll);
    };

    if ($filter == 'tommorow') {
        $task_count1 = filterTommorow($task_count_oll);
    };

    if ($filter == 'expired') {
        $task_count_oll = filterExpired($task_count_oll);
    };

    if ($filter == 'all' || $filter == '') {
        $task_count_oll =$task_count_oll;
    };
    return $task_count_oll;
};

*/








//вариант вывод ключей из массива $test,"title")
$page_content3= include_template ('main.php', [
   // вывод из простого mysqli_fetch_all 'type1'=> array_column ($test,"title"),
   'type_project'=> $task_sql2,
  //  'link_project'=>$task_sql_project_id,
      'task_c_name'=>$task_count1 ,
      'errorsearch2'=> $errorsearch2,
   // 'task_c_name2'=>$task_count,
      'task_count_oll1' =>$task_count_oll ,
  //  "task_search" =>  $search_result,
    'id_cat'=>$cat_task_id,
    'id_task_time'=>$cat_task_filter,
    'id_task_showid'=>$cat_task_id_show,
    'id_task_showid2'=>$cat_task_id2,

    'show_complete_tasks'=> $show_complete_tasks]);



$layout_content =include_template ('layout.php',
    ['content2'=>$page_content3,
        'title1'=> $title2,
        'name_user1' => $result_name_nick3
    ]);




print ($layout_content);

//подсчет количества задач
function test_count ( $task_count_oll1 , $cat_task):int{
        $count = 0;
    foreach ($task_count_oll1  as $value) {
        if ( $value ['title'] == $cat_task) {
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







?>
