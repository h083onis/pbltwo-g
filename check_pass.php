<?php
$user_id = $_SESSION['user_id'];
$pass = $_POST['pass'];

$db = new PDO('sqlite:part-time-job.db');
$encryptedPw = password_hash($pass, PASSWORD_DEFAULT);
$select = $db->query("select count(*) from user_inf where user_id = '$user_id' and job_name = '$encryptedPw'");
$num_rows = $job_count->fetchColumn();
echo $num_rows;
#該当しない場合
if ($num_rows == 0) {
  $db = null;
  header("Location:job_inf.php?e=2"); //エラーを返す
}

header("Location:job_inf.php?edit_pass=correct")

?>