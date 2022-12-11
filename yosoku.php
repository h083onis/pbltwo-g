<?php
$fp = fopen('job_schedule.csv', 'r');
$num_sche = 0;

while ($line = fgetcsv($fp)) {
  if ($line[0] == 'a') {
    $arr_sche[$num_sche] = $line;
    $num_sche = $num_sche + 1;
  }
}
fclose($fp);


$fp = fopen('job_income_aggregation2.csv', 'r');
$num_sche = 0;

while ($line = fgetcsv($fp)) {
  if ($line[0] == 'a') {
    $arr_job_inc[$num_job_inc] = $line;
    $num_job_inc = $num_job_inc + 1;
  }
}
fclose($fp);


## 月ごと計算 ##
for ($i = 0; $i < $num_sche; $i++) {
  for ($j = 0; $j < $num_job_inc; $j++) {
    if ($arr_sche[$i][0] = 'a' && $arr_job_inc[$j][0] = 'a' && new DateTimeImmutable($arr_sche[$i][2]) < new DateTimeImmutable($arr_job_inc[$j][3]) && new DateTimeImmutable($arr_sche[$i][2]) > new DateTimeImmutable($arr_job_inc[$j][3])){
      $from_time = strtotime($arr_sche[$i][3]);
      $to_time = strtotime($arr_sche[$i][4]);
      $diff = $to_time - $from_time;
      $min_time = $diff / 60;        //勤務時間（分）
      $Hour_wage = $arr_sche[$i][5];
      $min_wage = $Hour_wage / 60;  //分給
      $day_salary = $min_wage * $min_time;
      $salary += $day_salary;
    }
  }
}
echo $salary;
