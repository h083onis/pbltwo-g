<?php
$id = $_POST['id'];
$pass = $_POST['pass'];
session_start(); //セッションスタート
$_SESSION['id'] = $id;
$_SESSION['pass'] = $pass;
$data = file("id.txt");
$key = '長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵';
$c_t = openssl_encrypt($_SESSION['pass'], 'AES-128-ECB', $key);
$p_t = openssl_decrypt($c_t, 'AES-128-ECB', $key);
$_SESSION['c_t'] = $c_t;
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
  <?php
  foreach ($data as $line) {

    if (rtrim($line) == $id) {
      echo '入力されたIDは既に利用されています。';
      echo '<p><a href="index.php">home</a></p>';
      echo '<p><a href="add.php">新規登録画面</a></p>';
      exit();
    }
    if (mb_strlen($_POST['pass']) < 8) {
      echo '8文字以上のパスワードを入力してください。';
      echo '<p><a href="index.php">home</a></p>';
      echo '<p><a href="add.php">新規登録画面</a></p>';
      exit();
    }
  }
  header("Location:add1.php");
  ?>
</body>

</html>