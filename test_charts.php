<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>テスト用</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <script>
        window.onload = function () {
        var date = new Date();
        var month = date.getMonth() + 1;
              
        var today = document.getElementById("today");
        // optionタグのテキストを現在の月に設定する
        today.text = month + "月";
        // optionタグのvalueを現在の月に設定する
        today.value = month;
    }
    </script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div align="center">
<select name="month" id="select_m" onchange = "change_m()">
    <option id="today" hidden></option>
    <option value="01">1月</option>
    <option value="02">2月</option>
    <option value="03">3月</option>
    <option value="04">4月</option>
    <option value="05">5月</option>
    <option value="06">6月</option>
    <option value="07">7月</option>
    <option value="08">8月</option>
    <option value="09">9月</option>
    <option value="10">10月</option>
    <option value="11">11月</option>
    <option value="12">12月</option>
</div>
</select>
 <input type="button" onClick="change_y()" value="年" >
<div class="chart-container" style="position: relative; height:5vh; width:50vw">
  <canvas id="sample1"></canvas>
</div>
<div class="chart-container" style="position: relative; height:30vh; width:60vw">
<canvas id="sample2" ></canvas>
</div>
<script> 
document.getElementById("sample2").style.display ="none";
function change_m(){ //月のグラフに切替
    if (m_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
      m_chart.destroy();
    }
    if (y_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
      y_chart.destroy();
    }
    /* if(document.getElementById('select_m')){
        id = document.getElementById('select_m').value;
    } */
    getValue(); // グラフデータに値を格納
    chart_m(); // グラフを再描画
    const change2 = document.getElementById("sample2");
    const change1 = document.getElementById("sample1");
    if(change1.style.display=="none"){
    change2.style.display ="none";
    change1.style.display ="block";
	} 
} 
function change_y(){
  if (m_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    m_chart.destroy();
  }

  if (y_chart) { //既に描画済みのグラフがある場合にそのグラフを破棄
    y_chart.destroy();
  }

    getValue2(); // グラフデータに値を格納
    chart_y(); // グラフを再描画
    var change1 = document.getElementById("sample1");
    var change2 = document.getElementById("sample2");
    if(change2.style.display=="none"){
		change1.style.display ="none";
    change2.style.display ="block";
	} 
}

var chartVal_per = []; // グラフデータ（目標達成度合い）
var chartVal_salary = []; // グラフデータ（その月の給料見込み）
var chartVal2 = []; // グラフデータ（描画するデータ）
var cnt = 0;

// ページ読み込み時にグラフを描画
getValue(); // グラフデータに値を格納(仮)
getValue2(); // グラフデータに値を格納(仮)
chart_m(); // 月グラフ描画処理を呼び出す
chart_y(); // 年グラフ描画処理を呼び出す

function getValue() {
  chartVal_per = []; 
  chartVal_salary = [];
  if(cnt == 0){
    <?php
    #データベースから給料見込みの情報を取得
    // session_start();
    // $id = $_SESSION['user_id'];
    $user_id = 1; 
    $db = new PDO("sqlite:part-time-job.db");
    $now = date('Y-m');
    $result = $db->query("select * from income_aggregation where user_id = '$user_id' and date = $now");
    $db = null;
    foreach ($result as $value) {
      $nowIncome = $value['predict_income'];
    }
    ?>
    chartVal_per =  <?php echo $nowIncome ?> ; //当月の目標金額達成度をを代入
    chartVal_salary =  <?php echo $nowIncome ?>;
    cnt++;
  } 
  else{
    chartVal_per.push(Math.floor(Math.random() * 100)); //仮
    chartVal_salary.push(Math.floor(Math.random() * 100)); //仮
  }

  if(chartVal_per > 100){
    chartVal_per = 100;
  }
}

// グラフデータを生成
function getValue2() {
  chartVal2 = []; // 配列を初期化
  var length = 12;
  for (i = 0; i < length; i++) {
    chartVal2.push(Math.floor(Math.random() * 50000));
  }
}


function chart_m(){ //月のグラフを表示
    "use strict";
var ctx = document.getElementById('sample1');
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
    ctx.fillText(chartVal_salary + '円', width / 2, top + (height / 2));
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
    var ctx2 = document.getElementById("sample2");
    window.y_chart = new Chart(ctx2, { // インスタンスをグローバル変数で生成
    type: 'line',
    data: { // ラベルとデータセット
      labels: ["1月","2月","3月","4月", "5月", "6月", "7月", "8月","9月","10月","11月","12月"],
      datasets: [{
        label: '給料見込み',
          data: chartVal2, // グラフデータ
          borderColor: 'rgba(0, 114, 188, 1)', // 棒の枠線の色(青)
          borderWidth: 1, // 枠線の太さ
        },
        {
        label: '目標金額',
          data: [30000,30000,30000,30000,30000,30000,30000,30000,30000,30000,30000,30000], // グラフデータ
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