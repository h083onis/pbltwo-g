<?php
// $user_id = $_SESSINN['user_id'];
$user_id = 1;

$db = new PDO("sqlite:part-time-job.db");
$job_name = 'コンビニ';
$result1 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$job_name'");
foreach($result1 as $value){
    $houryly_wage = $value['hourly_wage'];
    $cutoff_day = $value['cutoff_day'];
    $mid_wage = $value['cutoff_day'];
    $start_mid_time = $value['start_mid_time'];
    $end_mid_time = $value['end_mid_time'];
}
// echo  $start_mid_time;

$y = 2022;
$m = 12;
$tem_m = $m - 1;
$tem_y = $y;
if($tem_m == 0){
    $tem_m = 12;
    $ten_y = $y-1;
}

$pre_job_date = strval($tem_y) . '-' . strval($tem_m) . '-' . strval($cutoff_day);
$now_job_date = strval($y) . '-' . strval($m) . '-' . strval($cutoff_day);
$date = date_create($pre_job_date);
$formated_date = date_format($date, 'Y-m-d');
echo $formated_date;
// echo $pre_job_date.'<br>';
// echo $now_job_date.'<br>';

$result2 = $db->query("select * from job_schedule where user_id ='$user_id' and job_name ='$job_name' and job_date BETWEEN '$pre_job_date' and '$now_job_date'");
foreach($result2 as $value){
    echo $value['start_time'].'<br>';
}

$db = null;
// $result2 = $db->query("select * job_schedule where date > ")
?>