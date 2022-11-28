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
    <style>
        .month {
            text-align: center;
        }

        .week {
            text-align: center;
            height: 50px;
        }

        .sunday {
            color: red;
            background-color: #ffb6c1;
        }

        .saturday {
            color: blue;
            background-color: #e0ffff;
        }

        .day {
            /* width: 72px;
            height: 32px; */
            text-align: left;
            vertical-align: top;
        }

        th,
        td {
            padding: 20px;
            border: solid 1px;
        }

        td {
            height: 100px;
            width: 100px;
        }




        .text_style {
            white-space: pre-wrap;
            background-color: aliceblue;
            border: 1px black;
            color: black;
        }


        .area {
            position: relative;
            width: 1000px;
            margin: auto;
        }

        .view {
            position: absolute;
        }

        .edit {
            position: absolute;
            top: 20px;
            left: 600px;
            font-size: 120%;
        }

        h3 {
            color: black;
        }

        .contents_cel {
            text-align: center;
            height: 50px;
            width: 150px;
            padding: 10px;
        }

        .contents_link {
            display: block;
            width: 100%;
            height: 100%;
        }

        .open {
            cursor: pointer;
        }

        #pop-up {
            display: none;
        }

        .overlay {
            display: none;
        }

        .overlay {
            display: none;
            z-index: 9999;
            background-color: #00000070;
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
        }

        .window {
            width: 800px;
            /* max-width: 600px; */
            height: 800px;
            background-color: #ffffff;
            border-radius: 6px;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close {
            cursor: pointer;
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 20px;
        }

        table.sel_d_inf td {
            text-align: center;
            height: 20px;
            width: 100px;
        }
    </style>
</head>

<body>
    <header>
        <h1>バイト管理アプリ</h1>
        <table align='center'>
            <tr>
                <td class='contents_cel'><span><a href='home.php'>ホーム画面</ho-mu></a></span>
                <td class='contents_cel'><span><a href='edit_job_inf.php'>バイト情報編集</a></span>
                <td class='contents_cel'><span><a href=''>給与計算</a></span></td>
                <td class='contents_cel'><span><a href=''>個人情報</a></span></td>
                <td class='contents_cel'><span><a href=''>ヘルプ</a></span></td>
                <td class='contents_cel'><span><a href=''>ログアウト</a></span></td>
            </tr>
        </table>
    </header>
    <main>
        <div class="area" align="center">
            <h3>
                <a href="?y=<?php echo $prev_y; ?>">&lt;</a><span><?php echo $y; ?></span>年<a href="?y=<?php echo $next_y; ?>">&gt;</a><br>
                <a href="?m=<?php echo $prev_m; ?>">&lt;</a><span><?php echo $m; ?></span>月<a href="?m=<?php echo $next_m; ?>">&gt;</a>
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
                            echo '<td class = "week">' . $weeks . '</td>';
                        }
                    }
                    ?>
                </tr>
                <?php
                // 1日の曜日を取得
                $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
                // その数だけ空白を表示
                for ($i = 1; $i <= $wd1; $i++) {
                    echo "<td></td>";
                }

                // 1日から月末日までの表示
                $d = 1;
                $n = 0;

                $db = new PDO("sqlite:part-time-job.db");
                for ($d = 1; $d <= $lastday; $d++) {
                    echo '<td class = "day"><a class="open" href="?y=' . $y . '&m=' . $m . '&sel_d=' . $d . '">' . $d . '</a>';
                    echo '<br>';
                    echo '<br>';
                    $job_date = strval($y) . '-' . strval($m) . '-' . strval($d);
                    $result = $db->query("select * from job_schedule where user_id = $user_id and job_date = '$job_date'");
                    foreach ($result as $value) :
                        echo '<span class = text_style>' . $value['job_name'] . $value['start_time'] . '~' . $value['end_time'] . '</span>';
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
                    echo "<td></td>";
                }
                ?>
            </table>
        </div>

        <div id="popup" class='overlay'>
            <div class='window'>
                <?= $y ?>年<?= $m ?>月<?= $sel_d ?>日<br>
                <label class='close' id="no" onclick="close_popup()">×</label><br>
                <form action='add_schedule.php' method='post'>
                    バイト項目
                    <select name='job_name' required>
                        <option disabled selected>選択してください</option>
                        <?php
                        foreach ($result2 as $value):
                            echo '<option>' . $value['job_name'] . '</option>';
                        endforeach;
                        ?>
                    </select>
                    時間帯
                    <input type='time' name='start_time' style='width:80px' step='60' required>
                    ~
                    <input type='time' name='end_time' style='width:80px' step='60' required>
                    <input type='hidden' name='year' value='<?= $y ?>'>
                    <input type='hidden' name='month' value='<?= $m ?>'>
                    <input type='hidden' name='day' value='<?= $sel_d ?>'>
                    <input type='submit' value='追加'>
                </form>
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
                    echo '<table class=sel_d_inf border=1>';
                    echo '<tr>';
                    echo '<td>バイト名</td>
                        <td>時間</td>
                        <td colspan=2>削除</td>';
                    echo '</tr>';
                    foreach ($result3 as $value):
                        echo '<tr>';
                        echo '<td>' . $value['job_name'] . '</td><td>' . $value['start_time'] . '~' . $value['end_time'] . '</td>';
                        echo '<td><form action=\'delete_schedule.php\' method=\'post\'>';
                        echo '<input type=\'hidden\' name=\'job_date\' value=',$sel_date,'>';
                        echo '<input type=\'hidden\' name=\'job_name\' value=',$value['job_name'],'>';
                        echo '<input type=\'hidden\' name=\'start_time\' value=',$value['start_time'],'>';                        
                        echo '<input type="submit" value="削除"></form></td>';
                        echo '</tr>';
                    endforeach;
                    echo '</table>';
                } else {
                    echo '登録情報はありません。';
                }
                ?>
            </div>
        </div>
    </main>
</body>

<?php
if (isset($_GET['sel_d'])) {
    echo '<script>', 'print_popup();', '</script>';
}
?>

</html>