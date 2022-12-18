<?php
    #データベースからユーザーの目標金額を取得
    // session_start();
    // $id = $_SESSION['user_id'];
    $user_id = 1; 
    $target_amount = 0;
    $db = new PDO("sqlite:part-time-job.db");
    $amount_result = $db->query("select target_amount from user_inf where user_id = '$user_id'");
    $db = null;
    foreach ($amount_result as $amount_value) {
      $target_amount = $amount_value['target_amount'];
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>給与計算グラフ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <script>
    window.onload = function () {
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth() + 1;

      var now_year = document.getElementById("select_y");
      //optionタグのテキストを現在の年に設定する
      now_year.text = year + "年";
      // optionタグのvalueを現在の年に設定する
      now_year.value = year;
    } 
    </script>
</head>
<body>
  <div align="center">
<form method="post" action="y_charts.php">
<select name="year" id="select_y" onchange = "this.form.submit()">
    <option id="now_year2" hidden></option>
    <option value="2020">2020年</option>
    <option value="2021">2021年</option>
    <option value="2022">2022年</option>
</select>
</form>
<form method="post" action="">
<input type="month" id="select_Ym" name="YYYY-mm" value="<?php echo $_POST['YYYY-mm'];?>" onchange = "this.form.submit()">
</form>
<input type="button" onClick="mode_m()" value="月" >
<input type="button" onClick="mode_y()" value="年" >

<div class="chart-container" style="position: relative; height:5vh; width:80vw">
  <canvas id="m"></canvas>
</div>
<div class="chart-container" style="position: relative; height:30vh; width:60vw">
<canvas id="y" ></canvas>
</div>
    </div>
<script> 
document.getElementById("select_y").style.display ="none";

function mode_m(){ //月のグラフに切替
  if (m_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    m_chart.destroy();
  }
  if(mode_cnt != 0){
    if (y_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
      y_chart.destroy();
    }
  }
  chart_m(); // グラフを再描画
  const change1 = document.getElementById("select_Ym");
  change1.style.display ="block";
  const change2 = document.getElementById("select_y");
  change2.style.display ="none";
} 

var mode_cnt = 0;
function mode_y(){
  if (mode_cnt != 0){
    if (y_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
      y_chart.destroy();
    }
  }
  if (m_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    m_chart.destroy();
  }
  chart_y(); //グラフを再描画   
  mode_cnt++;
  var change1 = document.getElementById("select_Ym");
  change1.style.display ="none";
  var change2 = document.getElementById("select_y");
  change2.style.display ="block";
}

function change_m(){ //月のグラフに切替
  if (m_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    m_chart.destroy();
  }

  getValue(); // グラフデータに値を格納
  chart_m(); // グラフを再描画
} 

function change_y(){
  if (y_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    y_chart.destroy();
  }
  getValue2(); // グラフデータに値を格納
  chart_y(); // グラフを再描画
}

var chartVal_per = []; // グラフデータ（目標達成度合い）
var chartVal_income = []; // グラフデータ（その月の給料見込み）
var chartVal_amount = []; // グラフデータ（ユーザーの目標金額）
var chartVal_income2 = []; // グラフデータ（その年の給料見込み)

// ページ読み込み時にグラフを描画
getValue(); // グラフデータに値を格納(仮)
getValue2(); // グラフデータに値を格納(仮)
chart_m(); // 月グラフ描画処理を呼び出す

//月グラフデータの生成
function getValue() {
    <?php
    #データベースから給料見込みの情報を取得
    // session_start();
    // $id = $_SESSION['user_id'];
    $user_id = 1; 
    $income_sum = 0;
    $income_per = 0;
    $y_data = $_POST["YYYY-mm"];
    $db = new PDO("sqlite:part-time-job.db");
    $result = $db->query("select sum(predict_income) from job_income_aggregation where user_id = '$user_id' and date = '$y_data'");
    $db = null;
    foreach ($result as $value) {
      if ($value['sum(predict_income)'] != 0) {
        $income_sum = $value['sum(predict_income)'];
      }
      else{
        $income_sum = 0;
      }
    }
    $income_per = $income_sum / $target_amount * 100;
    ?>
    chartVal_per =  <?php echo $income_per ?> ; //当月の目標金額達成度をを代入
    chartVal_income =  <?php echo $income_sum ?>;

  if(chartVal_per > 100){
    chartVal_per = 100;
  } 
}


// 年グラフデータを生成
function getValue2() {
  chartVal_income2 = []; // 配列を初期化
  chartVal_amount = []; // 配列を初期化

  <?php
    #データベースから給料見込みの情報を取得
    // session_start();
    // $id = $_SESSION['user_id'];
    $user_id = 1; 
    $nowIncome_sum = [];
    $db = new PDO("sqlite:part-time-job.db");
    $now = date('Y');
    $result = $db->query("select sum(predict_income) from job_income_aggregation where user_id = '$user_id' and date like '$now%' group by date ");
    $db = null;
    foreach ($result as $value) {
      $nowIncome_sum[] = $value['sum(predict_income)'];
    }
    $json_array = json_encode($nowIncome_sum); //配列をjson形式に変換
  ?>
  var length = 12;
  var array = <?php echo $json_array; ?>; //変換した配列をjavascriptに受け渡し
  for (i = 0; i < length; i++) {
    if(array[i] == null){
      chartVal_income2[i] = 0;
    }
    else{
    chartVal_income2[i] = array[i];
    }
    chartVal_amount[i] = <?php echo $target_amount ?>;
  }
}




function chart_m(){ //月のグラフを表示
    "use strict";
var ctx = document.getElementById('m');
const backgroundColor = 'rgba(0, 114, 188, 1)'; //グラフの色(青)
const counter = {
  id: 'counter',
  beforeDraw(chart, args, options) {
    const { ctx, chartArea: { top, right , bottom, left, width, height } } = chart;
    ctx.save();
    ctx.fillStyle = 'black';
    ctx.fillRect(width / 2, top + (height / 2), 0, 0);
    ctx.font = '60px sans-serif';
    ctx.textAlign = 'center';

    // 位置調整
    ctx.fillText(chartVal_income + '円', width / 2, top + (height / 2));
  }
};
window.m_chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
                data: [chartVal_per,100 - chartVal_per],
                backgroundColor: [
                    backgroundColor,
                    'rgba(0, 0, 0, 0)',
                ],
                radius: 300,  
                cutout: '82%',  //チャートの幅(%)
                borderWidth: 1,   //枠線
                borderColor: 'rgba(0, 0, 0, 1)' // 棒の枠線の色(黒)
            }]
    },
    plugins: [counter]
});
}; 

function chart_y(){ //年のグラフ表示
    var ctx2 = document.getElementById("y");
    window.y_chart = new Chart(ctx2, { // インスタンスをグローバル変数で生成
    type: 'line',
    data: { // ラベルとデータセット
      labels: ["1月","2月","3月","4月", "5月", "6月", "7月", "8月","9月","10月","11月","12月"],
      datasets: [{
        label: '給料見込み',
          data: chartVal_income2, // グラフデータ
          borderColor: 'rgba(0, 114, 188, 1)', // 棒の枠線の色(青)
          borderWidth: 1, // 枠線の太さ
        },
        {
        label: '目標金額',
          data: chartVal_amount, // グラフデータ
          borderColor: 'rgba(200, 0, 0, 1)', // 棒の枠線の色(赤)
          borderWidth: 1, // 枠線の太さ
        }],
    },
    options: {
    }
  });
}    
</script>
</body>
</html>