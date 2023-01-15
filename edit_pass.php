<?php
// session_start();
// $user_id =$_SESSION['user_id'];
$user_id = 1;
$new_target = $_POST['target_amount'];
$first_pass = $_POST['first_pass'];
$second_pass= $_POST['second_pass'];

if($first_pass != $second_pass){
  $db = null;
  header("Location:job_inf.php?e=3&check_pass=correct&e=4");
  exit();
  //エラーを返す
}
$db = new PDO("sqlite:part-time-job.db");

// $encryptedPw = password_hash($pass, PASSWORD_DEFAULT);
$encryptedPw = md5($first_pass);
$sql = "update user_inf set pass= :pass where user_id = :user_id";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':pass', $encryptedPw, PDO::PARAM_STR);
  $stmt->execute();
}
$db = null;

header('Location:job_inf.php?check_pass=complete');
?>