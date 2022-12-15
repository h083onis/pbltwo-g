<?php
// session_start();
// $user_id = $_SESSION['id'];
$user_id = 1;
$job_name = $_POST['job_name'];

$db = new PDO("sqlite:part-time-job.db");
$sql = "delete from part_time_job_inf where user_id = :user_id and job_name = :job_name";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->execute();
}
$sql = "delete from job_schedule where user_id = :user_id and job_name = :job_name";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->execute();
}
$sql = "delete from job_income_aggregation where user_id = :user_id and job_name = :job_name";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->execute();
}
header('Location:job_inf.php');
?>