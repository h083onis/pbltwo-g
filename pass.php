<?php
$user_id = $_POST['user_id'];
$pass = $_POST['pass'];

$db = new PDO('sqlite:part-time-job.db');
$result = $db->query("select pass from user_inf where user_id = '$user_id'")
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
  foreach ($result as $value) {
    if (md5($pass)==$value['passwd']) {
      header("Location:home.php");
      exit();
    }
  }
  echo 'IDまたはパスワードが違います。';
  echo '<p><a href="index.php">home</a></p>';
  ?>
</body>

</html>
