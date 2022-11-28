<?php
session_start();
$user_id = $_SESSION['user_id'];
$pass = $_SESSION['pass'];
$encryptedPw = password_hash($pass, PASSWORD_DEFAULT);
$db = new PDO('sqlite:part-time-job.db');
$sql = "insert into user_inf(user_id, pass) values(:user_id, :pass)"; //idはint型として代入
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':pass', $encryptedPw, PDO::PARAM_STR);
  $stmt->execute();
}
$db = null;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>登録完了しました。</h1>
  <p><a href="index.php">home</a></p>
</body>

</html>