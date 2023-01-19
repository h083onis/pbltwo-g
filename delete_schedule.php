<?php
session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 1;
$job_name = $_POST['job_name'];
$job_date = $_POST['job_date'];
$start_time = $_POST['start_time'];

$list = preg_split("/-/", $job_date);
$sel_y = intval($list[0]);
$sel_m = intval($list[1]);
$sel_d = intval($list[2]);

$db = new PDO("sqlite:part-time-job.db");
$sql = "delete from job_schedule where user_id = :user_id and job_name = :job_name and job_date =:job_date and start_time = :start_time";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->bindValue(':job_date', $job_date, PDO::PARAM_STR);
  $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->execute();
}
$db = null;

header("Location:yosoku2.php?y=$sel_y&m=$sel_m&job_name=$job_name&sel_d=$sel_d");
?>
