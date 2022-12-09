<?php
// $user_id = $_SESSION['user_id'];
$user_id = 1;
$pass = $_POST['pass'];

$db = new PDO('sqlite:part-time-job.db');
$result = $db->query("select pass from user_inf where user_id = '$user_id'");
$encry_pass = $result->fetchColumn();
echo $encry_pass;
$db = null;

#一致していた場合
if (password_verify($pass, $encry_pass)) {
  header("Location:job_inf.php?check_pass=correct");
  exit();
}

#該当しない場合
header("Location:job_inf.php?e=2"); //エラーを返す
?>