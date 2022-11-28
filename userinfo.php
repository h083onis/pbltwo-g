<meta charset="UTF-8">

<?php
session_start();

$pdo = new PDO('mysql:host=/localhost;dbname=login;charset=utf8','login','login');


function h($s) {//入力内容を無害化するセキュリティ対策
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

$id = h($_POST['id']);
$pass = h($_POST['pass']);
$sql = "select * from ユーザーリスト where id=:id";
$stmt = $pdo->prepare($sql);
$params = array(':id' => $id);
$res=$stmt->execute($params);
if($res){
	$user_data = $stmt->fetch();
}

if(password_verify($pass,$user_data["pass"])){
	//ログイン成功
	$_SESSION['id'] = $id;
	$setcookie('id', $id, time() + 60 * 60 * 24 * 1);
}
?>

<?php
if(isset($_SESSION['id']))
	//ログインできてるので、マイアカウントを表示してみる
	echo "<a href=\"/user/".$_SESSION['id']."\">マイアカウント</a>";
	//これで /user/ユーザー名 へのリンクが貼れる
else{
	echo "はよログインしろやボケ";
}
?>
