<?php
session_start();
$user_id = $_SESSION['id'];
$job_id = $_POST['job_id'];
$job_name = $_POST['job_name'];
$money = $_POST['money'];
$cutoff_day = $_POST['cutoff_day'];
$payment_day = $_POST['payment_day'];
$mid_money = $_POST['mid_money'];
$start_mid_time = $_POST['start_mid_time'];
$end_mid_time = $_POST['end_mid_time'];

$db = new PDO("sqlite:circle.db");
if ($mid_money != '') {
  $sql = "update part_time_job_inf set job_name = :job_name, money = :money, cutoff_day = :cutoff_day, payment_day=:payment_day,mid_money=:mid_money,start_mid_time=:start_mid_time,end_mid_time = :end_mid_time where user_id = :user_id and job_id = :job_id";
  if ($stmt = $db->prepare($sql)) {
    $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
    $stmt->bindValue(':money', $money, PDO::PARAM_INT);
    $stmt->bindValue(':cutoff_day', $cutoff_day, PDO::PARAM_INT);
    $stmt->bindValue(':payment_day', $payment_day, PDO::PARAM_INT);
    $stmt->bindValue(':mid_money', $payment_day, PDO::PARAM_INT);
    $stmt->bindValue(':start_mid_time', $payment_day, PDO::PARAM_STR);
    $stmt->bindValue(':end_mid_time', $payment_day, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
else{
  $sql = "update part_time_job_inf set job_name = :job_name, money = :money, cutoff_day = :cutoff_day, payment_day = :payment_day where user_id = :user_id and job_id = :job_id";
  if ($stmt = $db->prepare($sql)) {
    $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
    $stmt->bindValue(':money', $money, PDO::PARAM_INT);
    $stmt->bindValue(':cutoff_day', $cutoff_day, PDO::PARAM_INT);
    $stmt->bindValue(':payment_day', $payment_day, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
$db = null;

header('Location:job_inf.php');
