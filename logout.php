<?php
session_start();
if (isset($_SESSION['user_id']) == 0) {
  header("Location:index.php"); //ログイン画面に飛ばす
}
$user_id = $_SESSION['user_id'];
header("refresh:1200;url=index.php");

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ログアウト</title>
    </head>
<?php
$response = $_POST['judge'];
//echo $response;

if($response == "はい"){
    $_SESSION = array();
    session_destroy();
    header("Location:home.php");
    exit();
}elseif($response == "いいえ"){
    header("Location:home.php");
    exit();
}
else{
    echo 'ログアウトしますか？';
    echo '<form action="logout.php" method="post">';
    echo '<input type="submit" name="judge" value="はい">';
    echo '<input type="submit" name="judge" value="いいえ"></form>';
    
}

?>

</html>