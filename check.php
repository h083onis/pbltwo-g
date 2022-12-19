<?php
$user_id = $_POST['user_id'];
$pass = $_POST['pass'];
session_start(); //セッションスタート
$_SESSION['user_id'] = $user_id;
$_SESSION['pass'] =  $pass;
$db = new PDO('sqlite:part-time-job.db');
$result = $db->query("select count(*) from user_inf where user_id = '$user_id'");
$count = $result->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>

<body>
  <?php
  if($count == 1) {
    echo '<p>入力されたIDは既に利用されています。</p>';
    echo '<p><a href="index.php">home</a></p>';
    echo '<p><a href="add.php">新規登録画面</a></p>';
    exit();
  }

  if (mb_strlen($_POST['pass']) < 8) {
    echo '<p>8文字以上のパスワードを入力してください。</p>';
    echo '<p><a href="index.php">home</a></p>';
    echo '<p><a href="add.php">新規登録画面</a></p>';
    exit();
  }

  header("Location:add1.php");
  ?>
</body>

</html>
