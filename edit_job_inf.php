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
  <!-- バイトの登録情報の表示する位置 -->
  <?php

  ?>
  バイト項目<input type='text'><br>
  <select>
    <option>時給</option>
    <option>日給</option>
    <option>週給</option>
    <option>月給</option>
  </select>
  金額入力<input type='number' name='money'><br>
  締め日<input type='date'><br>
  給料日<input type='date'><br>
  <input type='button'value='登録'>

</body>

</html>