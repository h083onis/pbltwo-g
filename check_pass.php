<?php
session_start();
$user_id = $_SESSION['user_id'];
$pass = $_POST['pass'];

$db = new PDO('sqlite:part-time-job.db');
$result = $db->query("select pass from user_inf where user_id = '$user_id'");
$encry_pass = $result->fetchColumn();
$db = null;

#一致していた場合
if (md5($pass)==$encry_pass) {
  header("Location:job_inf.php?check_pass=correct");
  exit();
}

#該当しない場合
header("Location:job_inf.php?e=2"); //エラーを返す
?>