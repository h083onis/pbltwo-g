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

// echo 'console.log(',$y,')';
//曜日を配列で渡している
$week = ['日', '月', '火', '水', '木', '金', '土'];
//mktimeは第一引数から、（時間,分,秒,月,日,年)
//date関数の指定できるフォーマット文字を参照,Y(西暦4桁),y(西暦2桁),t(指定した月の日数)...

// 前月・次月リンクが押された場合は、GETパラメーターから月を取得、それ以外は今月を入手
if (isset($_GET['m'])) {
    $m = $_GET['m'];
} else {
    // 今月を表示
    $m = date('m');
}

//月の最後の日を入手する
$lastday = date("t", mktime(0, 0, 0, $m, 1, $y));

$prev_y = date('Y', mktime(0, 0, 0, $m, 1, $y - 1));
$next_y = date('Y', mktime(0, 0, 0, $m, 1, $y + 1));
//前月・次月を入手
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

        /* input[type="number"] {
            width: 35px;
        } */
    </style>
</head>

<body>
    <header>
        
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

                    echo '<td class = "day"><a href=\'home.php\'>' . $d. '</a>';
                    echo '<br>';
                    echo '<br>';

                    // $db = new PDO("sqlite:circle.db");
                    // $result = $db->query("select * from calendar where id = $id and month = $m and day = $d");
                    // $db = null;
                    // foreach ($result as $value) :

                    //     echo '<span class = text_style>', htmlspecialchars($value['content']), '</span>';
                    // endforeach;

                    echo "</td>";

                    //day=$dで絞り込んだ時になかった場合の処理
                    //echo "<td> '.$d.' </td>"   空白の予定だったけど、無くてもうまくいった。
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
    </main>
</body>

</html>