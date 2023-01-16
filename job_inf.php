<?php
#データベースからバイトの情報を取得
// session_start();
// $id = $_SESSION['user_id'];
header("refresh:1200;url=index.php");
$user_id = 1;
$db = new PDO("sqlite:part-time-job.db");
$result = $db->query("select * from part_time_job_inf where user_id = '$user_id'");
$count = $db->query("select count(*) from part_time_job_inf where user_id = '$user_id'");
$row = $count->fetchColumn();
$target_amount = $db->query("select target_amount from user_inf where user_id = '$user_id'");
$target = $target_amount->fetchColumn();

if (isset($_GET['sel_job'])) {
  $sel_job = $_GET['sel_job'];
  $result2 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$sel_job'");
}
if (isset($_GET['delete_job'])) {
  $delete_job = $_GET['delete_job'];
  $result3 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$delete_job'");
}

$db = null;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common.css">
  <link rel="stylesheet" href="user-icon.css">
  <link rel="stylesheet" href="job_inf.css">
  <title>Document</title>
  <script>
    function print_popup1() {
      document.getElementById('popup1').style.display = 'block';
      return false;
    }

    function close_popup1() {
      document.getElementById('popup1').style.display = 'none';
      // location.href = 'bulletin.php?sel=' + sel;
    }

    function print_popup2() {
      document.getElementById('popup2').style.display = 'block';
      return false;
    }

    function close_popup2() {
      document.getElementById('popup2').style.display = 'none';
      // location.href = 'bulletin.php?sel=' + sel;
    }
    function print_popup3() {
      document.getElementById('popup3').style.display = 'block';
      return false;
    }

    function close_popup3() {
      document.getElementById('popup3').style.display = 'none';
      // location.href = 'bulletin.php?sel=' + sel;
    }
  </script>
</head>

<body>

  <div class="side-menu">
    <nav>
      <ul>
        <li><a href='job_inf.php' class="navi info-icon"><img src="./img/information.svg" alt="個人情報" width="70px" height="40spx" /></a></li>
        <li><a href='home.php' class="navi calender-icon"><img src="./img/calender.svg" alt="カレンダー" width="70px" height="40px" /></a></li>
        <li><a href='initial_charts.php' class="navi money-icon"><img src="./img/money.svg" alt="給料計算" width="70px" height="40px" /></a></li>
        <li><a href='' class="navi question-icon"><img src="./img/question.svg" alt="ヘルプ" width="70px" height="40px" /></a></li>
        <li><a href='' class="navi logout-icon"><img src="./img/logout.svg" alt="ログアウト" width="70px" height="40px" /></a></li>
      </ul>
    </nav>
  </div>

  <div class="inf">
    <div class="user-inf">
      <span class="user"></span>
      <span class="user-id"><?= $user_id?></span>
    </div>
    <div class="user-pass">
      <?php
        if(isset($_GET['e']) && $_GET['e']==2){
          echo'パスワードが間違っています';
        }
        if(isset($_GET['check_pass']) && $_GET['check_pass'] == 'complete'){
          echo 'パスワードの変更が完了しました';
        }
      ?>
      <div class="pass-change">
        <form id = 'check_pass' action='check_pass.php' method='post'>
          <input type='password'name='pass' minlength='8' required>
        </form>
        <input type='submit' value='変更' form='check_pass' class="button">
      </div>
      <span>※パスワード変更の際は現在のパスワードを入力してください</span>
    </div>
  
    <div class="job-inf">
    <?php
    if($target != ''){
      echo '<span class="target-display">今月の目標金額　'. $target. '円</span>';
    }
    else{
      echo '目標金額が設定されていません';
    }
    ?>
    <div class="target">
      <form id='edit_target' action = 'edit_target.php' method = 'post'>
        <input type ='number' name ='target_amount' min = 1 required>
      </form>
      <input type='submit' value='金額変更' form ='edit_target' class="button">
    </div>
    <!-- 既に登録されているバイトの登録情報を表示する -->
    <?php
    if ($row != 0) {
      echo '<table border=1 class="job-detail">';
      echo '<tr class="job-item">';
      echo '<td>バイト名</td><td>時給</td><td>締め日</td><td>給料日</td><td>深夜手当時給</td><td>深夜手当時間</td><td colspan=2>編集・削除</td>';
      echo '</tr>';
      foreach ($result as $value) {
        echo '<tr>';
        echo '<td>' . $value['job_name'] . '</td><td>' . $value['hourly_wage'] . '</td><td>' . $value['cutoff_day'] . '</td><td>' . $value['payment_day'] . '</td>';
        if ($value['mid_wage'] != 0) {
          echo '<td>' . $value['mid_wage'] . '</td><td>' . $value['start_mid_time'] . '~' . $value['end_mid_time'] . '</td>';
        } else {
          echo '<td>なし</td><td>なし</td>';
        }
        echo '<td><input type="button" value="編集" onClick="location.href=\'job_inf.php?sel_job=' . $value['job_name'] . '\'" class="button-edit"></td>';
        echo '<td><input type="button" value="×" onClick="location.href=\'job_inf.php?delete_job=' . $value['job_name'] . '\'" class="button-del"></td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
      echo '登録情報はありません。';
    }
    // 追加や編集によるエラー内容の表示
    if (isset($_GET['e']) && $_GET['e']==1) {
      echo '同じバイト名は登録できません';
    }
    if (isset($_GET['e']) && $_GET['e']==3) {
      echo '項目への入力が不十分です';
    }
    ?>
    <form action='add_inf.php' method='post' class="add-form">
      バイト名：<input type='text' name='job_name' required class="form"><br>
      時給入力：<input type='number' name='hourly_wage' min='0' required class="form"><br>
      締め日：<input type='number' name='cutoff_day' min='1' max='31' required class="form"><br>
      給料日：<input type='number' name='payment_day' min='1' max='31' required class="form"><br>
      深夜手当時給入力：<input type='number' name='mid_wage' min='0' class="form"><br>
      <div class="form">深夜手当時間：
        <input type='time' name='start_mid_time' style='width:80px' step='60'>
        ~
        <input type='time' name='end_mid_time' style='width:80px' step='60'>
        <input type='submit' value='登録' class="button">
      </div>
    </form>
    <!-- 編集画面 -->
    <div id="popup1" class='overlay'>
      <div class='window'>
        <label class='close' id="no" onclick="close_popup1()">×</label><br>
        <form action='edit_inf.php' method='post'>
          <?php
          foreach ($result2 as $value) {
            echo 'バイト名：<input type=\'text\' name=\'job_name\'value=', $value['job_name'], '><br>';
            echo '時給：<input type=\'number\' name=\'hourly_wage\' min=\'0\' value=', $value['hourly_wage'], ' required><br>';
            echo '締め日：<input type=\'number\' name=\'cutoff_day\' min=\'1\' max=\'31\' value=', $value['cutoff_day'], ' required><br>';
            echo '給料日：<input type=\'number\' name=\'payment_day\' min=\'1\' max=\'31\' value=', $value['payment_day'], ' required><br>';
            echo '深夜手当時給：<input type=\'number\' name=\'mid_wage\' min=\'0\' value=', $value['mid_wage'], '><br>';
            echo '深夜手当時間：';
            echo '<input type=\'time\' name=\'start_mid_time\' style=\'width:80px\' step=\'60\' value=', $value['start_mid_time'], '>~';
            echo '<input type=\'time\' name=\'end_mid_time\' style=\'width:80px\' step=\'60\' value=', $value['end_mid_time'], '>';
            echo '<input type=\'hidden\' name=\'pre_name\' value=', $value['job_name'], '>';
          }
          ?>
          <br><input type='submit' value='変更' class="button button-change">
        </form>
      </div>
    </div>
    <!-- 削除前の確認画面 -->
    <div id="popup2" class='overlay'>
      <div class='window'>
        <?php
        foreach($result3 as $value):
          $del_job = $value['job_name'];
        endforeach;
        ?>
        <span>バイト名：<?= $del_job ?>に関係する全ての情報が削除されますがよろしいでしょうか？</span>
        <form id='delete' action='delete_inf.php' method='post'>
          <input type='hidden' name='job_name' value=<?= $del_job ?>>
        </form>
        <input type='button' value='いいえ' onclick="close_popup2()"><br>
        <input type='submit' value='はい' form='delete'>
      </div>
    </div>
    <!-- パスワード編集用の画面 -->
    <div id="popup3" class='overlay'>
      <div class='window'>
        <span>変更したいパスワードを2回入力してください</span>
        <?php
          if(isset($_GET['e']) && $_GET['e']==4){
            echo '同じパスワードを入力してください';
          }
        ?>
        <form id='edit_pass' action='edit_pass.php' method='post'>
          <input type='password' name='first_pass' minlength='8' required></br>
          <input type='password' name='second_pass' minlength='8' required> 
        </form>
        <input type='button' value='やめる' onclick="close_popup3()"><br>
        <input type='submit' value='変更' form='edit_pass'>
      </div>
    </div>
    </div>
  </div>
</body>

<?php
if (isset($_GET['sel_job'])) {
  echo '<script>', 'print_popup1();', '</script>';
}
if (isset($_GET['delete_job'])) {
  echo '<script>', 'print_popup2();', '</script>';
}
if (isset($_GET['check_pass']) && $_GET['check_pass'] == 'correct') {
  echo '<script>', 'print_popup3();', '</script>';
}
?>

</html>