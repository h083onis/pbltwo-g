<?php
session_start();
$user_id = $_SESSION['user_id'];
$job_name = $_POST['job_name'];
$hourly_wage = $_POST['hourly_wage'];
$cutoff_day = $_POST['cutoff_day'];
$payment_day = $_POST['payment_day'];
$mid_wage = $_POST['mid_wage'];
$start_mid_time = $_POST['start_mid_time'];
$end_mid_time = $_POST['end_mid_time'];

$db = new PDO("sqlite:part-time-job.db");

if ($mid_wage != '' || $start_mid_time != '' || $end_mid_time != '') {
  if ($start_mid_time == '' || $end_mid_time == '') {
    $db = null;
    header("Location:job_inf.php?e=5&sel_job=$job_name"); //エラーを返す
    exit();
  }
  if ($mid_wage == '' || $end_mid_time == '') {
    $db = null;
    header("Location:job_inf.php?e=5&sel_job=$job_name"); //エラーを返す
    exit();
  }
  if ($mid_wage == '' || $start_mid_time == '') {
    $db = null;
    header("Location:job_inf.php?e=5&sel_job=$job_name"); //エラーを返す
    exit();
  }
}


$sql = "update part_time_job_inf set user_id = :user_id, job_name = :job_name, hourly_wage = :hourly_wage, cutoff_day = :cutoff_day, payment_day=:payment_day, mid_wage=:mid_wage, start_mid_time=:start_mid_time, end_mid_time = :end_mid_time where user_id = :user_id and job_name = :job_name";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->bindValue(':hourly_wage', $hourly_wage, PDO::PARAM_INT);
  $stmt->bindValue(':cutoff_day', $cutoff_day, PDO::PARAM_INT);
  $stmt->bindValue(':payment_day', $payment_day, PDO::PARAM_INT);
  $stmt->bindValue(':mid_wage', $mid_wage, PDO::PARAM_INT);
  $stmt->bindValue(':start_mid_time', $start_mid_time, PDO::PARAM_STR);
  $stmt->bindValue(':end_mid_time', $end_mid_time, PDO::PARAM_STR);
  $stmt->execute();
}

$db = null;

header('Location:job_inf.php');
