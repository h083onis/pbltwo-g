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
echo  $houryly_wage;

// $result2 = $db->query("select * job_schedule where date > ")
?>
