<?php
session_start();
$user_id = $_SESSION['id'];
$job_id = $_POST['job_id'];

$db = new PDO("sqlite:circle.db");
$sql = "delete from part_time_job_inf where user_id = :user_id and job_id = :job_id";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->bindValue(':job_id', $job_id, PDO::PARAM_INT);
  $stmt->execute();
}
header('Location:job_inf.php');
?>