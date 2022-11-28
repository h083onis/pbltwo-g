<?php
$key = '長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵';
$id = $_POST['id'];
$pass = openssl_encrypt($_POST['pass'], 'AES-128-ECB', $key);
$id_pass = $id.",".$pass;
$data = file("test.txt");


foreach ($data as $line) {
  if (rtrim($line) == $id_pass) {
    header("Location:http://localhost/PBL2/home1.php");
    exit();
  }
}
echo 'IDまたはパスワードが違います。';
echo '<p><a href="http://localhost/PBL2/index.php">home</a></p>';
?>
