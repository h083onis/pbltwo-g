<?php
$id = $_POST['id'];
$pass = $_POST['pass'];
session_start();//セッションスタート
$_SESSION['id'] = $id;
$_SESSION['pass'] = $pass;
$data = file("id.txt");

foreach ($data as $line) {
  if (rtrim($line) == $id) {
    echo '入力されたIDは既に利用されています。';
    echo '<p><a href="http://localhost/PBL2/index.php">home</a></p>';
    echo '<p><a href="http://localhost/PBL2/add.php">新規登録画面</a></p>';
    exit();
  }
}
header("Location:http://localhost/PBL2/add1.php");
?>
