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
    var month = ('00' + (date.getMonth()+1)).slice(-2);
    var YearMonth = year + '-' + month;
        
    var now_Ym = document.getElementById("select_Ym");
    // optionタグのvalueを現在の年に設定する
    now_Ym.value = YearMonth;
  }  
  </script>
</head>
<body>
<div align="center">
<input type="button" onClick="mode_m()" value="月" >
<input type="button" onClick="mode_y()" value="年" >
<form method="post" action="y_charts.php">
<select name="year" id="select_y" onchange = "this.form.submit()">
</select>
</form>
<form method="post" action="m_charts.php">
<input type="month" id = "select_Ym" name="YYYY-mm" onchange = "this.form.submit()">
</form>
<div style="position: relative">
  <canvas id="MyChart"></canvas>
</div>
</div>
</div>
<script> 
document.getElementById("select_y").style.display ="none";

(function date() { //年グラフのプルダウン作成
  var optionLoop, this_year, today;
  today = new Date();
  this_year = today.getFullYear();

  /*
    ループ処理（スタート数字、終了数字、表示id名、デフォルト数字）
   */
  optionLoop = function date(start, end, id, this_day) {
    var i, opt;

    opt = null;
    for (i = start; i <= end ; i++) {
      if (i === this_day) {
        opt += "<option value='" + i + "' selected>" + i + "年" + "</option>";
      } else {
        opt += "<option value='" + i + "'>" + i + "年" + "</option>";
      }
    }
    return document.getElementById(id).innerHTML = opt;
  };


  /*
    関数設定（スタート数字[必須]、終了数字[必須]、表示id名[省略可能]、デフォルト数字[省略可能]）
   */
  optionLoop(this_year - 5, this_year + 1, 'select_y', this_year);
})();

var mode_cnt = 0;
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
var chartVal_target = 0; //グラフデータ(円グラフ用の目標金額)

// ページ読み込み時にグラフを描画
getValue(); // グラフデータに値を格納(仮)
getValue2(); // グラフデータに値を格納(仮)
chart_m(); // 月グラフ描画処理を呼び出す
//chart_y(); // 年グラフ描画処理を呼び出す

//月グラフデータの生成
function getValue() {
  chartVal_target = 0; //目標金額
  chartVal_per = []; 
  chartVal_income = [];
    <?php
    #データベースから給料見込みの情報を取得
    // session_start();
    // $id = $_SESSION['user_id'];
    $user_id = 1; 
    $nowIncome_sum = 0;
    $nowIncome_per = 0;
    $db = new PDO("sqlite:part-time-job.db");
    $now = date('Y-m');
    $result = $db->query("select sum(predict_income) from job_income_aggregation where user_id = '$user_id' and date = '$now'");
    $db = null;
    foreach ($result as $value) {
      if ($value['sum(predict_income)'] != 0) {
        $nowIncome_sum = $value['sum(predict_income)'];
      }
      else{
        $nowIncome_sum = 0;
      }
    }
    $nowIncome_per = $nowIncome_sum / $target_amount * 100;
    ?>
    chartVal_target = <?php echo $target_amount ?>; //目標金額を代入
    chartVal_per =  <?php echo $nowIncome_per ?> ; //当月の目標金額達成度を代入
    chartVal_income =  <?php echo $nowIncome_sum ?>; //当月の給料見込みを代入
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
var ctx = document.getElementById('MyChart');
  ctx.width=window.innerWidth*0.1;
  ctx.height=window.innerHeight*0.8;
const backgroundColor = 'rgba(0, 114, 188, 1)'; //グラフの色(青)
const counter = {
  id: 'counter',
  beforeDraw(chart, args, options) {
    const { ctx, chartArea: { top, right , bottom, left, width, height } } = chart;
    ctx.save();
    ctx.fillStyle = 'black';
    ctx.fillRect(width / 2, top + (height / 2), 0, 0);
    ctx.font = '47px sans-serif';
    ctx.textAlign = 'center';

    // 位置調整
    ctx.fillText(chartVal_income + '円' + '/' + chartVal_target + '円', width / 2, top + (height / 2));
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
                radius: 250,  
                cutout: '82%',  //チャートの幅(%)
                borderWidth: 1,   //枠線
                borderColor: 'rgba(0, 0, 0, 1)' // 棒の枠線の色(黒)
              }]
    },
    options: {
    maintainAspectRatio: false 
    },
    plugins: [counter]
});
}; 

function chart_y(){ //年のグラフ表示
    var ctx2 = document.getElementById("MyChart");
    ctx2.width=window.innerWidth*0.05;
    ctx2.height=window.innerHeight*0.1;
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