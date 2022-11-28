<?php
$key = '長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵';
$id = $_POST['id'];
$pass = openssl_encrypt($_POST['pass'], 'AES-128-ECB', $key);
$id_pass = $id . "," . $pass;
$data = file("test.txt");
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
    if (rtrim($line) == $id_pass) {
      header("Location:home1.php");
      exit();
    }
  }
  echo 'IDまたはパスワードが違います。';
  echo '<p><a href="index.php">home</a></p>';
  ?>
</body>

</html>
