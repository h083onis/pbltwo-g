<meta charset="UTF-8">
<h1>登録完了しました。</h1>
<?php
session_start();
$id = $_SESSION['id'];
$pass = $_SESSION['pass'];
$write_test = fopen("test.txt" , "a");
if(flock($write_test , LOCK_EX)){
  fwrite($write_test , $id . "," . $pass . "\n");
}
fclose($write_test);
$write_id = fopen("id.txt" , "a");
if(flock($write_id , LOCK_EX)){
  fwrite($write_id , $id . "\n");
}
fclose($write_id);
?>
<p><a href="http://localhost/PBL2/index.php">home</a></p>
