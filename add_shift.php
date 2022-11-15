<?php
$y = $_GET['y'];
$m = $_GET['m'];
$d = $_GET['d'];

#データベースから値を取得する
#登録してあるバイトの項目とすでに同日に入ってるものなど
$list = ['選択してください','コンビニ', '居酒屋'];
$list2 = ['']
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
  <div>
    <?= $y ?>年<?= $m ?>月<?= $d ?>日<br>
    時間
    <input type='time' name='shift_time' style='width:80px' step='60'>
    ~
    <input type='time' name='shift_time' style='width:80px' step='60'>
    バイト項目
    <select name='item'>
      <?php
      foreach ($list as $value) {
        echo '<option>' . $value . '</option>';
      }
      ?>
    </select>
    <input type='button' value='登録'>
  </div>
  <div>

  </div>
</body>

</html>