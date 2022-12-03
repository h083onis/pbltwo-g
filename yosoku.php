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
//print_r($arr_sche);
// echo '<br>'.$num_sche;
for ($i = 0; $i < $num_sche; $i++) {
  $from_time = strtotime($arr_sche[$i][3]);
  $to_time = strtotime($arr_sche[$i][4]);
  $diff = $to_time - $from_time;
  $min_time = $diff/60;        //勤務時間（分）
  $Hour_wage = $arr_sche[$i][5];
  $min_wage = $Hour_wage / 60;  //分給
  $day_salary = $min_wage * $min_time;
  $salary += $day_salary; 
}
echo $salary;

// $diff = $time1->diff($time2);

// if ($diff->h == 0 && $diff->i == 0 && $diff->s == 0) {
//   echo '一致しています';
// }
