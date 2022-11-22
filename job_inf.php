<?php
#データベースからバイトの情報を取得
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table align='center' border=1>
    <tr>
      <td class='contents_cel'><span><a href='home.php'>ホーム画面</ho-mu></a></span>
      <td class='contents_cel'><span><a href='edit_job_inf.php'>バイト情報編集</a></span>
      <td class='contents_cel'><span><a href=''>給与計算</a></span></td>
      <td class='contents_cel'><span><a href=''>個人情報</a></span></td>
      <td class='contents_cel'><span><a href=''>ヘルプ</a></span></td>
      <td class='contents_cel'><span><a href=''>ログアウト</a></span></td>
    </tr>
  </table>
  <!-- 既に登録されているバイトの登録情報を表示する -->
  <?php

  ?>
  <form action='add_inf.php' method='post'>
    バイト項目<input type='text' name='job_name' required><br>
    時給入力<input type='number' name='money' min='0' required><br>
    締め日<input type='number' name='cutoff_day' min='1' max='31' required><br>
    給料日<input type='number' name='payment_day' min='1' max='31' required><br>
    <!-- 深夜手当在りだと欄が増えるようにする -->
    深夜手当時給入力<input type='number' name='mid_money' min='0'><br>
    深夜手当時間
    <input type='time' name='start_mid_time' style='width:80px' step='60'>
    ~
    <input type='time' name='end_mid_time' style='width:80px' step='60'>
    <input type='submit' value='登録'>
  </form>

</body>

</html>