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
  <?php
  session_start();
  $id = $_SESSION['id'];
  $pass = $_SESSION['c_t'];
  $write_test = fopen("test.txt", "a");
  if (flock($write_test, LOCK_EX)) {
    fwrite($write_test, $id . "," . $pass . "\n");
  }
  fclose($write_test);
  $write_id = fopen("id.txt", "a");
  if (flock($write_id, LOCK_EX)) {
    fwrite($write_id, $id . "\n");
  }
  fclose($write_id);
  ?>
  <p><a href="index.php">home</a></p>

</body>

</html>