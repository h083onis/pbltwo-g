<?php
// $user_id = $_SESSINN['user_id'];
$user_id = 1;

$db = new PDO("sqlite:part-time-job.db");
$job_name = 'コンビニ';
$result1 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$job_name'");
foreach ($result1 as $value) {
    $hourly_wage = $value['hourly_wage'];
    $cutoff_day = $value['cutoff_day'];
    $mid_wage = $value['mid_wage'];
    $start_mid_time = $value['start_mid_time'];
    $end_mid_time = $value['end_mid_time'];
}
// echo  $start_mid_time;

$y = 2022;
$m = 12;
$tem_m = $m - 1;
$tem_y = $y;
if ($tem_m == 0) {
    $tem_m = 12;
    $ten_y = $y - 1;
}

$pre_job_date = strval($tem_y) . '-' . strval($tem_m) . '-' . strval($cutoff_day);
$now_job_date = strval($y) . '-' . strval($m) . '-' . strval($cutoff_day);
$date = date_create($pre_job_date);
$formated_date = date_format($date, 'Y-m-d');
//echo $formated_date;
// echo $pre_job_date.'<br>';
// echo $now_job_date.'<br>';

$result2 = $db->query("select * from job_schedule where user_id ='$user_id' and job_name ='$job_name' and job_date BETWEEN '$pre_job_date' and '$now_job_date'");
$salary = 0;
foreach ($result2 as $value) {
    $tmp_st_time = new DateTime($value['job_date'] . ' ' . $value['start_time']);

    if (strtotime($value['start_time']) > strtotime($value['end_time'])) {
        $tmp_en_time = date("Y-m-d H:i", strtotime($value['job_date'] . ' ' . $value['end_time'] . '+days'));
    } else {
        $tmp_en_time = new DateTime($value['job_date'] . ' ' . $value['end_time']);
    }

    $tmp_midst_time = new DateTime($value['job_date'] . ' ' . '22:00');

    if (strtotime($value['start_time']) < strtotime('5:00')) {
        $tmp_miden_time = new Datetime(($value['job_date'] . ' ' . '5:00'));
    } else {
        $tmp_miden_time = date("Y-m-d H:i", strtotime($value['job_date'] . ' ' . '5:00+days'));
    }


    // 深夜なし
    if ($tmp_st_time < $tmp_midst_time && $tmp_en_time < $tmp_midst_time) {
        $difference = date_diff($tmp_st_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;    //勤務時間(分
        $min_wage = $hourly_wage / 60;  //分給
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //終わりが深夜
    else if ($tmp_st_time <= $tmp_midst_time && ($tmp_en_time > $tmp_midst_time && $tmp_en_time < $tmp_miden_time)) {
        //始まり～22:00
        $difference = date_diff($tmp_st_time, $tmp_midst_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $hourly_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //22：00～終わり
        $difference = date_diff($tmp_midst_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //深夜のみ
    else if ($tmp_st_time > $tmp_midst_time && $tmp_en_time < $tmp_miden_time) {
        $difference = date_diff($tmp_st_time, $tmp_midst_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //始まり深夜
    else if ($tmp_st_time < $tmp_miden_time) {
        //始まり～5:00
        $difference = date_diff($tmp_st_time, $tmp_miden_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //5:00～終わり
        $difference = date_diff($tmp_midst_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $hourly_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //深夜またぎ
    else if ($tmp_st_time < $tmp_midst_time && $tmp_en_time > $tmp_miden_time) {
        //始まり～22:00
        $difference = date_diff($tmp_st_time, $tmp_midst_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $hourly_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //22：00～5:00
        $difference = date_diff($tmp_midst_time, $tmp_miden_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //5:00～終わり
        $difference = date_diff($tmp_miden_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $hourly_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
}
echo $salary;

$db = null;
// $result2 = $db->query("select * job_schedule where date > ")