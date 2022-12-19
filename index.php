<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['pass']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css">
	<title>Document</title>
</head>

<body>
	<h1>バイト管理アプリ</h1>
	<form action="pass.php" method="post" name="login_form">
		<table>
			</tr>
			<tr class="">
				<td><input type="text" placeholder="ユーザー名" name="user_id" required></td>
			</tr>
			<tr class="">
				<td><input type="password" placeholder="パスワード" name="pass" required></td>
			</tr>
		</table>
		<div>
			<input type="submit" value="ログイン">
		</div>
	</form>

	<p><a href="add.php">新規登録はこちら</a></p>
</body>

</html>
