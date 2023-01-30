<?php
session_start();
$user_id = $_POST['user_id'];
$pass = $_POST['pass'];
$_SESSION['user_id'] = $user_id;

$db = new PDO('sqlite:part-time-job.db');
$result = $db->query("select pass from user_inf where user_id = '$user_id'")
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <title>Document</title>
</head>

<body class="picture">
  <div class="form-login">
    <?php
    foreach ($result as $value) {
      if (md5($pass)==$value['pass']) {
        header("Location:home.php");
        exit();
      }
    }
    echo 'IDまたはパスワードが違います。';
    echo '<p><a href="index.php">ログイン画面に戻る</a></p>';
    ?>
  </div>
</body>

</html>
