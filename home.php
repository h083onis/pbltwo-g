<?php
// session_start();
// if (isset($_SESSION['idname']) == 0) {
//     header("Location:index.php"); //ログイン画面に飛ばす
// }
// $id = $_SESSION['id'];

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
    $sel_d = $_GET['sel_d'];
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
            width: 600px;
            max-width: 600px;
            height: 500px;
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
                <a href="?m=<?php echo $prev_m; ?>">&lt;</a><span><?php echo $m; ?></span>月 <a href="?m=<?php echo $next_m; ?>">&gt;</a>
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

                for ($d = 1; $d <= $lastday; $d++) {
                    echo '<td class = "day"><a class="open" href="?y=' . $y . '&m=' . $m . '&sel_d=' . $d . '">' . $d . '</a>';
                    echo '<br>';
                    echo '<br>';

                    // $db = new PDO("sqlite:manage-part-time.db");
                    // $result = $db->query("select * from calendar where id = $id and year = $y month = $m and day = $d");
                    // $db = null;
                    // foreach ($result as $value) :

                    //     echo '<span class = text_style>.$value['startTime'].'~'.$value['endTime].'</span>';
                    // endforeach;
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
                    <select name='items' required>
                        <option disabled selected>選択してください</option>
                        <option>コンビニ</option>
                        <option>ニトリ</option>
                        <!-- <?php
                        foreach ($list as $value) {
                            echo '<option>' . $value . '</option>';
                        }
                        ?> -->

                    </select>
                    時間
                    <input type='time' name='start_time' style='width:80px' step='60'>
                    ~
                    <input type='time' name='end_time' style='width:80px' step='60'>
                    <input type='hidden' name='year' value='<?= $y?>'>
                    <input type='hidden' name='month' value='<?= $m?>'>
                    <input type='hidden' name='day' value='<?= $sel_d?>'>
                    <input type='submit' value='追加'>
                </form>
                <!-- すでに追加されている情報を表示する欄 -->
            </div>
        </div>
    </main>
</body>

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
<?php
if (isset($_GET['sel_d'])) {
    echo '<script>', 'print_popup();', '</script>';
}
?>

</html>