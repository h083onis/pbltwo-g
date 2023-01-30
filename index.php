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
	<link rel="stylesheet" href="css/index.css">
	<title>smart-バイト管理アプリ</title>
</head>

<body class="picture">
	<div class="form-login">
		<h1>smart</h1>
		<h2>バイト管理アプリ<h2>
		<form action="pass.php" method="post" name="login_form">
			<table>
				</tr>
				<tr class="">
					<td><input type="text" placeholder="　ユーザー名" name="user_id" required></td>
				</tr>
				<tr class="">
					<td><input type="password" placeholder="　パスワード" name="pass" required></td>
				</tr>
			</table>
			<div>
				<input type="submit" value="ログイン" class="login">
			</div>
		</form>
	
		<input type="button" value="新規登録" onclick="location.href='add.php'" class="sign-up">
	</div>
</body>

</html>
