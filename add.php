<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['pass']);
header("refresh:1200;url=index.php");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.css">

  <title>新規登録</title>
</head>

<body class="picture">
  <div class="form-login">
  <h3>新規登録</h3>
  <form action="check.php" method="post" name="info">
    <table>
      <tr class="">
        <p class="form_caution">全項目が必須入力です。</p>
      </tr>
      <tr class="">
        <td><p><input type="text" placeholder="  ユーザー名" name="user_id" required></p></td>
      </tr>
      <tr class="">
        <td><input type="password" placeholder="  パスワード" name="pass" required></p></td>
      </tr>
    </table>
    <form action="check.php" method="post">
      <div>
        <input type="submit" value="登録" class="login">
      </div>
    </form>
  </form>
  <input type="button" value="ログイン画面に戻る" onclick="location.href='index.php'" class="sign-up">
</body>

</html>
