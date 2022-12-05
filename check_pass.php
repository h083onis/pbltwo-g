<?php
// $user_id = $_SESSION['user_id'];
$user_id = 1;
$pass = $_POST['pass'];

$db = new PDO('sqlite:part-time-job.db');
$encryptedPw = password_hash($pass, PASSWORD_DEFAULT);
$result = $db->query("select count(*) from user_inf where user_id = '$user_id' and pass = '$encryptedPw'");
$num_rows = $result->fetchColumn();
echo $num_rows;
#該当しない場合
if ($num_rows == 0) {
  $db = null;
  header("Location:job_inf.php?e=2"); //エラーを返す
}

header("Location:job_inf.php?check_pass=correct")

?>