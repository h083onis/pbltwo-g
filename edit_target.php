<?php
session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 1;
$new_target = $_POST['target_amount'];

$db = new PDO("sqlite:part-time-job.db");

$sql = "update user_inf set target_amount= :target_amount where user_id = :user_id";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':target_amount', $new_target, PDO::PARAM_INT);
  $stmt->execute();
}
$db = null;

header('Location:job_inf.php');
?>