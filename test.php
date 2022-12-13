<?php
// $user_id = $_SESSINN['user_id'];
$user_id = 1;
$db = new PDO("sqlite:part-time-job.db");
$job_name = 'コンビニ';
$result1 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$job_name'");
$job_inf = $result1->feachAll();
echo $job_inf['user_id'];


// $result2 = $db->query("select * job_schedule where date > ")
?>
