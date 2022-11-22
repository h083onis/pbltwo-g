<?php
session_start();
$id = $_SESSION['id'];
$job_name = $_POST['job_name'];
$money = $_POST['money'];
$cutoff_day = $_POST['cutoff_day'];
$payment_day = $_POST['payment_day'];
$mid_money = $_POST['mid_money'];
$start_mid_time = $_POST['start_mid_time'];
$end_mid_time = $_POST['end_mid_time'];

$db = new PDO("sqlite:circle.db");

#同じバイト名がある場合のエラーを考える
$job_count = $db->query("select count(*) from circle_home where id = $id and job_name = $job_name");
if ($job_count == 1) {
  $db = null;
  header("Location:job_inf.php?e=1"); //エラーを返す
}

if (isset($mid_money)) {
  #深夜手当ありの場合
  // $sql = "insert into bulletin(user_id, job_name, money, cutoff_day, payment_day, mid_money, start_mid_time, end_mid_time) values(:user_id, :job_name,:money ,:cutoff_day,:payment_day,:mid_money,:start_mid_time,:end_mid_time)"; //idはint型として代入
  // if ($stmt = $db->prepare($sql)) {
  //   $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  //   $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  //   $stmt->bindValue(':money', $money, PDO::PARAM_INT);
  //   $stmt->bindValue(':cutoff_day', $cutoff_day, PDO::PARAM_INT);
  //   $stmt->bindValue(':payment_day', $payment_day, PDO::PARAM_INT);
  //   $stmt->bindValue(':mid_money', $mid_money, PDO::PARAM_INT);
  //   $stmt->bindValue(':start_mid_time', $start_mid_time, PDO::PARAM_STR);
  //   $stmt->bindValue(':end_mid_time', $end_mid_time, PDO::PARAM_STR);
  //   $stmt->execute();
  // }
} 
else {
  #深夜手当なしの場合
  // $sql = "insert into bulletin(user_id, job_name, money, cutoff_day, payment_day) values(:user_id, :job_name, :cutoff_day, :, :payment_day)"; //idはint型として代入
  // if ($stmt = $db->prepare($sql)) {
  //   $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  //   $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  //   $stmt->bindValue(':money', $money, PDO::PARAM_INT);
  //   $stmt->bindValue(':cutoff_day', $cutoff_day, PDO::PARAM_INT);
  //   $stmt->bindValue(':payment_day', $payment_day, PDO::PARAM_INT);
  //   $stmt->execute();
  // }
}



$db = null;

header("Location:job_inf.php");
