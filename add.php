<meta charset="UTF-8">
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
  <form action="check.php" method="post" >
    <div>
      <input type="submit" value="登録">
    </div>
  </form>
</form>
<p><a href="http://localhost/PBL2/index.php">home</a></p>
