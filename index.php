<meta charset="UTF-8">
<h1>ログイン</h1>
<form action="pass.php" method="post" name="login_form">
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
	<div>
			<input type="submit" value="ログイン">
	</div>
</form>

<p><a href="http://localhost/PBL2/add.php">初めての方は、会員登録</a></p>
