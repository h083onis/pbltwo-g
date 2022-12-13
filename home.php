<?php
// session_start();
// if (isset($_SESSION['idname']) == 0) {
//     header("Location:index.php"); //ログイン画面に飛ばす
// }
// $user_id = $_SESSION['user_id'];
$user_id = 1;
date_default_timezone_set('Asia/Tokyo'); //東京時間にする
if (isset($_GET['y'])) {
    $y = $_GET['y'];
} else {
    $y = date('Y');
}

$week = ['日', '月', '火', '水', '木', '金', '土'];
//mktimeは第一引数から、（時間,分,秒,月,日,年)
//date関数の指定できるフォーマット文字を参照,Y(西暦4桁),y(西暦2桁),t(指定した月の日数)...

if (isset($_GET['m'])) {
    $m = $_GET['m'];
} else {
    $m = date('m');
}
if (isset($_GET['sel_d'])) {
    $db = new PDO("sqlite:part-time-job.db");
    $sel_d = $_GET['sel_d'];
    $sel_date = strval($y) . '-' . strval($m) . '-' . strval($sel_d);
    $count = $db->query("select count(*) from job_schedule where user_id = $user_id and job_date = '$sel_date'");
    $result2 = $db->query("select * from part_time_job_inf where user_id = $user_id");
    $result3 = $db->query("select * from job_schedule where user_id = $user_id and job_date = '$sel_date'");
    $db = null;
}
#$yと$mが一致する月のシフト状況をデータベースから取得する

$lastday = date("t", mktime(0, 0, 0, $m, 1, $y));

$prev_y = date('Y', mktime(0, 0, 0, $m, 1, $y - 1));
$next_y = date('Y', mktime(0, 0, 0, $m, 1, $y + 1));
$prev_m = date('m', mktime(0, 0, 0, $m - 1, 1, $y));
$next_m = date('m', mktime(0, 0, 0, $m + 1, 1, $y));
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="common.css">
    <meta name="viewport" content="width=device-width">
    <title>スケジュール編集ページ</title>
    <script>
        function print_popup() {
            document.getElementById('popup').style.display = 'block';
            return false;
        }

        function close_popup() {
            document.getElementById('popup').style.display = 'none';
            // location.href = 'bulletin.php?sel=' + sel;
        }
    </script>
</head>

<body>
    <div class="main">
        <div class="side-menu">
            <!--<nav>
                <ul>
                    <li><a href='home.php' class="navi info-icon">個人情報</a></li>
                    <li><a href='edit_job_inf.php' class="navi calender-icon">カレンダー</a></li>
                    <li><a href='' class="navi money-icon">給料計算</a></li>
                    <li><a href='' class="navi logout-icon">ログアウト</a></li>
                </ul>
            </nav>-->

            <nav>
                <ul>
                    <li><a href='job_inf.php' class="navi info-icon"><img src="./img/information.svg" alt="個人情報" width="70px" height="40spx" /></a></li>
                    <li><a href='home.php' class="navi calender-icon"><img src="./img/calender.svg" alt="カレンダー" width="70px" height="40px" /></a></li>
                    <li><a href='' class="navi money-icon"><img src="./img/money.svg" alt="給料計算" width="70px" height="40px" /></a></li>
                    <li><a href='' class="navi logout-icon"><img src="./img/logout.svg" alt="ログアウト" width="70px" height="40px" /></a></li>
                </ul>
            </nav>
        </div>    
    
        <div class="area" align="center">
            <h3>
                <a href="?y=<?php echo $prev_y; ?>" class="move-mo">&lt;</a><span class="years"><?php echo $y; ?>年</span><a href="?y=<?php echo $next_y; ?>" class="move-mo">&gt;</a><br>
                <a href="?m=<?php echo $prev_m; ?>" class="move-mo">&lt;</a><span class="months"><?php echo $m; ?></span>月 <a href="?m=<?php echo $next_m; ?>" class="move-mo">&gt;</a>
            </h3>
            <table class="calendar">
                <tr>
                    <?php
                    //$week配列の中の$weeksという要素を繰り返し処理する(日曜日から土曜日まで)
                    foreach ($week as $weeks) {
                        if ($weeks == '日') {
                            echo '<td class = "week sunday">' . $weeks . '</td>';
                        } else if ($weeks == '土') {
                            echo '<td class = "week saturday">' . $weeks . '</td>';
                        } else {
                            echo '<td class = "week weekday">' . $weeks . '</td>';
                        }
                    }
                    ?>
                </tr>
                <?php
                // 1日の曜日を取得
                $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
                // その数だけ空白を表示
                for ($i = 1; $i <= $wd1; $i++) {
                    echo '<td class="space"></td>';
                }

                // 1日から月末日までの表示
                $d = 1;
                $n = 0;

                $db = new PDO("sqlite:part-time-job.db");
                for ($d = 1; $d <= $lastday; $d++) {
                    echo '<td class = "day"><a class="open" href="?y=' . $y . '&m=' . $m . '&sel_d=' . $d . '">' . $d . '</a>';
                    echo '<br>';
                    /*echo '<br>';*/
                    $job_date = strval($y) . '-' . strval($m) . '-' . strval($d);
                    $result = $db->query("select * from job_schedule where user_id = $user_id and job_date = '$job_date'");
                    foreach ($result as $value) :
                        echo '<span class = text_style>' . $value['job_name'] . $value['start_time'] . '~' . $value['end_time'] . '</span></br>';
                    endforeach;
                    echo "</td>";
                    if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                        // 週を終了
                        echo "</tr>";
                        // 次の週がある場合は新たな行を準備
                        if (checkdate($m, $d + 1, $y)) {
                            echo "<tr>";
                        }
                    }
                    $n++;
                }
                $db = null;

                // 最後の週の土曜日まで移動
                $wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
                for ($i = 1; $i < 7 - $wdx; $i++) {
                    echo '<td class="space"></td>';
                }
                ?>
            </table>
        </div>

        <div id="popup" class='overlay'>
            <div class='window'>
                <div class='date-popup'><?= $y ?>年<?= $m ?>月<?= $sel_d ?>日</div>
                <!-- すでに追加されている情報を表示する欄 -->
                <?php
                if (isset($_GET['e'])) {
                    if($_GET['e']== 1){
                        echo '全ての項目を入力してください';
                    }
                    else{
                        echo '他のバイトと時間帯がかぶっています';
                    }
                }
                if ($count != 0) {
                    echo '<table class=sel_d_inf>';
                    echo '<tr class="item">';
                    echo '<td>バイト名</td>
                        <td>時間</td>
                        <td colspan=2>削除</td>';
                    echo '</tr>';
                    foreach ($result3 as $value):
                        echo '<tr class="item-list">';
                        echo '<td>' . $value['job_name'] . '</td><td>' . $value['start_time'] . '~' . $value['end_time'] . '</td>';
                        echo '<td><form action=\'delete_schedule.php\' method=\'post\'>';
                        echo '<input type=\'hidden\' name=\'job_date\' value=',$sel_date,'>';
                        echo '<input type=\'hidden\' name=\'job_name\' value=',$value['job_name'],'>';
                        echo '<input type=\'hidden\' name=\'start_time\' value=',$value['start_time'],'>';                        
                        echo '<input type="submit" value="×" class="button-del"></form></td>';
                        echo '</tr>';
                    endforeach;
                    echo '</table>';
                } else {
                    echo '登録情報はありません。';
                }
                ?>
                <label class='close' id="no" onclick="close_popup()">×</label><br>
                <form action='add_schedule.php' method='post'>
                    <span class="select-time">バイト項目
                        <select name='job_name' required class="drop-down-job">
                            <option disabled selected>選択してください</option>
                            <!-- <option>コンビニ</option>
                            <option>ニトリ</option> -->
                            <?php
                            foreach ($result2 as $value):
                                echo '<option>' . $value['job_name'] . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </span>
                    <span class="drop-down-time">時間</span>
                    <input type='time' name='start_time' style='width:80px' step='60'>
                    ~
                    <input type='time' name='end_time' style='width:80px' step='60'>
                    <input type='hidden' name='year' value='<?= $y ?>'>
                    <input type='hidden' name='month' value='<?= $m ?>'>
                    <input type='hidden' name='day' value='<?= $sel_d ?>'><br>
                    <input type='submit' value='追加' class='button-add'>
                </form><br><br>
            </div>
        </div>
    </div>
</body>

<?php
if (isset($_GET['sel_d'])) {
    echo '<script>', 'print_popup();', '</script>';
}
?>

</html>