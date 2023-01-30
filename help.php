<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/help.css">
  <script src="https://code.jquery.com/jquery.min.js"></script>
  <script src="help.js"></script>
  <link rel="stylesheet" href="css/common.css">
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
</head>

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

<br>
<table>
  <tr class="">
    <th><p>よくある質問</p></th>
  </tr>
  <tr class="">
    <td>
      <b>タスクバーについて</b><br>
      <div class="A">&#x25B6; それぞれのアイコンの説明</div><br><p></p>
      <div class="B">上から「個人情報ページ」「シフト編集ページ」「給与計算・グラフページ」「ヘルプページ」「ログアウト」となっています</div><p></p>
      <b>カレンダー機能について</b><br>
      <div class="G">&#x25B6; カレンダーにシフトを追加する</div><br><p></p>
      <div class="H">カレンダー上の該当する日付をクリックすることで、シフト追加のポップアップが開きます。</div><p></p>
      <div class="I">&#x25B6; カレンダーのシフトを削除する</div><br><p></p>
      <div class="J">カレンダー上の該当する日付をクリックすることでポップアップが表示され、そこに既に追加しているシフト情報が表示されます。該当するシフト情報の右端にある「×」ボタンをクリックすることでシフト情報を削除することができます。</div><p></p>
</table><br>
    <?php
    echo '<p><a href="home.php">スケジュール編集ページに戻る</a></p>';
    ?>

</body>
