<?php
$id = $_POST['id'];
$pass = $_POST['pass'];
$key = $id.",".$pass;
$data = file("test.txt");


foreach ($data as $line) {
  if (rtrim($line) == $key) {
    header("Location:http://localhost/PBL2/home1.php");
    exit();
  }
}
echo 'IDまたはパスワードが違います。';
echo '<p><a href="http://localhost/PBL2/index.php">home</a></p>';
?>
