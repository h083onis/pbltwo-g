<?php
require_once 'month_calc.php';
$fp = fopen('job_schedule.csv', 'r');
$num_sche = 0;
$arr_sche = [];
while ($line = fgetcsv($fp)) {
  if ($line[0] == 'a') {
    $arr_sche[$num_sche] = $line;
    $num_sche = $num_sche + 1;
  }
}
fclose($fp);
// print_r($arr_sche);
// echo "<br><br>";

$fp = fopen('job_income_aggregation2.csv', 'r');
$num_job_inc = 0;
$arr_job_inc =[];
while ($line = fgetcsv($fp)) {
  if ($line[0] == 'a') {
    $arr_job_inc[$num_job_inc] = $line;
    $num_job_inc = $num_job_inc + 1;
  }
}
fclose($fp);
// print_r($arr_job_inc);
// echo "<br>";


## 計算 ##

$fp = fopen('job_income_aggregation2.csv', 'w');
$salary = 0 ;
for ($j = 0; $j < $num_job_inc; $j++) {
  if (isset($arr_job_inc[$j][5])) {
    $line = array(array($arry_job_inc[$j][0],$arr_job_inc[$j][1],$arr_job_inc[$j][2],$arr_job_inc[$j][3],$arr_job_inc[$j][4],$arr_job_inc[$j][5],$arr_job_inc[$j][6]. "\n"));
    fwrite($fp, $line . "\n");
  } else {
    for ($i = 0; $i < $num_sche; $i++) {
      if (($arr_job_inc[$j][0] = 'a' && $arr_sche[$i][0] = 'a') && $arr_job_inc[$j][1] == $arr_sche[$i][1] && new DateTimeImmutable($arr_sche[$i][2]) <= new DateTimeImmutable($arr_job_inc[$j][2])) {
        $from_time = strtotime($arr_sche[$i][3]);
        $to_time = strtotime($arr_sche[$i][4]);
        $diff = $to_time - $from_time;
        $min_time = $diff / 60;        //勤務時間（分）
        $Hour_wage = $arr_job_inc[$j][3];
        $min_wage = $Hour_wage / 60;  //分給
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
      }
    }
    echo $salary;
  }
  $arr_job_inc[$j][5] = $salary;
  fwrite($fp, $arr_job_inc[$j] . "\n");
}
fclose($fp);

