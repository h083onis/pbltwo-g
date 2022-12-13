<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>テスト用</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <script>
        window.onload = function () {
        //今の月を表示
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
    <option value="1">1月</option>
    <option value="2">2月</option>
    <option value="3">3月</option>
    <option value="4">4月</option>
    <option value="5">5月</option>
    <option value="6">6月</option>
    <option value="7">7月</option>
    <option value="8">8月</option>
    <option value="9">9月</option>
    <option value="10">10月</option>
    <option value="11">11月</option>
    <option value="12">12月</option>
</div>
</select>
<input type="button" onClick="change_y()" value="年" >
<canvas id="sample1"></canvas>
<canvas id="sample2" width="300" height="100"></canvas>

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
    getValue(); // グラフデータにランダムな値を格納
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

    getValue2(); // グラフデータにランダムな値を格納
    chart_y(); // グラフを再描画
    var change1 = document.getElementById("sample1");
    var change2 = document.getElementById("sample2");
    if(change2.style.display=="none"){
		change1.style.display ="none";
    change2.style.display ="block";
	} 
}

var chartVal = []; // グラフデータ（描画するデータ）
var chartVal2 = []; // グラフデータ（描画するデータ）
var cnt = 0;

// ページ読み込み時にグラフを描画
getValue(); // グラフデータに値を格納(仮)
getValue2(); // グラフデータに値を格納(仮)
chart_m(); // 月グラフ描画処理を呼び出す
chart_y(); // 年グラフ描画処理を呼び出す


var data = [30,40,50,20,60,70,80,90,30,10,20,50];
function getValue() {
    chartVal = [];
    var date = new Date();
    var month = date.getMonth();
    var data = 20;
    if(cnt == 0){
       chartVal = data; //当月の目標金額達成度をを代入
       cnt++;
    } 
    else{
        chartVal.push(Math.floor(Math.random() * 100));
    }

    if(chartVal > 100){
        chartVal = 100;
    }
}

// グラフデータをランダムに生成
function getValue2() {
  chartVal2 = []; // 配列を初期化
  var length = 12;
  for (i = 0; i < length; i++) {
    chartVal2.push(Math.floor(Math.random() * 50000));
  }
}


function chart_m(){ 
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
    ctx.fillText(chartVal + '円', width / 2, top + (height / 2));
  }
};
window.m_chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
                data: [chartVal,100 - chartVal],
                backgroundColor: [
                    backgroundColor,
                    'rgba(0, 0, 0, 0)',
                ],
                radius: 300,  
                cutout: '80%',  //チャートの幅(%)
                borderWidth: 0   //枠線
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