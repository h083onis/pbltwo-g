<?php
session_start();
header("refresh:1200;url=index.php");
$user_id = $_SESSION['user_id'];
$pass = $_SESSION['pass'];
$encryptedPw = md5($pass);
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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.css">
  <title>Document</title>
</head>

<body class="picture">
  <div class="form-login">
    <h3>登録完了しました。</h3>
    <p><a href="index.php">ログイン画面に戻る</a></p>
  </div>
</body>

</html>
