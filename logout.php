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
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/logout.css">
        <title>ログアウト</title>
    </head>
    <script>
    function move_side_menu() {
      let side_inf =  document.getElementById("side-menu").getBoundingClientRect().left;
      if (side_inf >= 0) {
          document.getElementById("side-menu").style.transform = 'translateX(-61px)';
      } else {
          document.getElementById("side-menu").style.transform = 'translateX(0px)';
      }
    }
    </script>

<body>
    <div id="side-menu">
        <nav>
            <ul>
                <li><a href='job_inf.php' class="navi info-icon"><img src="./img/information.svg" alt="個人情報" width="60px" height="35px" /></a></li>
                <li><a href='home.php' class="navi calender-icon"><img src="./img/calender.svg" alt="カレンダー" width="60px" height="35px" /></a></li>
                <li><a href='initial_charts.php' class="navi money-icon"><img src="./img/money.svg" alt="給料計算" width="60px" height="35px" /></a></li>
                <li><a href='help.php' class="navi question-icon"><img src="./img/question.svg" alt="ヘルプ" width="60px" height="35px" /></a></li>
                <li><a href='logout.php' class="navi logout-icon"><img src="./img/logout.svg" alt="ログアウト" width="60px" height="35px" /></a></li>
            </ul>
        </nav>
    </div>

  <input class ='move-side' name='button' type='button' value='タスクバー表示切替' onclick="move_side_menu()">

<div class="logout-button">
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
    echo '<input type="submit" name="judge" value="はい" class="button">';
    echo '<input type="submit" name="judge" value="いいえ" class="button"></form>';
    
}

?>
</div>
</body>

</html>