<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>新規登録</h1>
  <form action="check.php" method="post" name="info">
    <table>
      <tr class="">
        <p class="form_caution">全項目が必須入力です。</p>
      </tr>
      <tr class="">
        <th><label for="id">ID</label></th>
        <td><input type="text" name="id" required></td>
      </tr>
      <tr class="">
        <th><label for="pass">パスワード</label></th>
        <td><input type="password" name="pass" required></td>
      </tr>
    </table>
    <form action="check.php" method="post">
      <div>
        <input type="submit" value="登録">
      </div>
    </form>
  </form>
  <p><a href="index.php">home</a></p>
</body>

</html>