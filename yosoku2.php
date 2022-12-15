<?php
// $user_id = $_SESSINN['user_id'];
$user_id = 1;
$y = 2022;
$m = 12;
$job_name = '居酒屋';

$db = new PDO("sqlite:part-time-job.db");
$sel_date = date_create(strval($y) . '-' . strval($m));
$sel_formated_date = date_format($sel_date, 'Y-m-d');
$job_count = $db->query("select count(*) from job_income_aggregation where user_id = '$user_id' and job_name = '$job_name' and date = '$sel_formated_date'");
$num_rows = $job_count->fetchColumn();
if ($num_rows == 0) {
    $result1 = $db->query("select * from part_time_job_inf where user_id = '$user_id' and job_name = '$job_name'");
    foreach ($result1 as $value) {
        $hourly_wage = $value['hourly_wage'];
        $cutoff_day = $value['cutoff_day'];
        $mid_wage = $value['mid_wage'];
        $start_mid_time = $value['start_mid_time'];
        $end_mid_time = $value['end_mid_time'];
    }
} else {
 
    $result1 = $db->query("select * from job_income_aggregation where user_id = '$user_id' and job_name = '$job_name' and date = '$sel_formated_date'");
    foreach ($result1 as $value) {
        $hourly_wage = $value['current_hourly_wage'];
        $cutoff_day = $value['current_cutoff_day'];
        $mid_wage = $value['current_mid_wage'];
        $start_mid_time = $value['current_start_mid_time'];
        $end_mid_time = $value['current_end_mid_time'];
    }
}
// echo  $start_mid_time;


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
    echo date_format($tmp_st_time, "Y-m-d H:i") . '<br>';

    if (strtotime($value['start_time']) > strtotime($value['end_time'])) {
        $tmp_en_time = new Datetime($value['job_date'] . ' ' . $value['end_time'] . '+1 day');
        $tmp_en_time->format('Y-m-d H:i');
    } else {
        $tmp_en_time = new DateTime($value['job_date'] . ' ' . $value['end_time']);
    }
    echo date_format($tmp_en_time, "Y-m-d H:i") . '<br>';

    
    $tmp_midst_time = new DateTime($value['job_date'] . ' ' . $start_mid_time);
    echo date_format($tmp_midst_time, "Y-m-d H:i").'<br>';

    $tmp_premiden_time = new Datetime(($value['job_date'] . ' ' . $end_mid_time));
    $tmp_miden_time = new Datetime($value['job_date'] . ' ' . $end_mid_time.'+ 1 day');
    $tmp_miden_time->format('Y-m-d H:i');
    echo date_format($tmp_premiden_time, "Y-m-d H:i") . '<br>';
    echo date_format($tmp_miden_time, "Y-m-d H:i").'<br>';


    // 始まり深夜
    if ($tmp_st_time <= $tmp_premiden_time) {
        //始まり～5:00
        $difference = date_diff($tmp_st_time, $tmp_premiden_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //5:00～終わり
        $difference = date_diff($tmp_premiden_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $hourly_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    // 深夜なし
    else if ($tmp_st_time <= $tmp_midst_time && $tmp_en_time <= $tmp_midst_time) {
        $difference = date_diff($tmp_st_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;    //勤務時間(分
        $min_wage = $hourly_wage / 60;  //分給
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //終わりが深夜
    else if ($tmp_st_time <= $tmp_midst_time && ($tmp_en_time > $tmp_midst_time && $tmp_en_time <= $tmp_miden_time)) {
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
    else if ($tmp_st_time > $tmp_midst_time && $tmp_en_time <= $tmp_miden_time) {
        $difference = date_diff($tmp_st_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;
        $min_wage = $mid_wage / 60;
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
    }
    //深夜またぎ
    else if ($tmp_st_time <= $tmp_midst_time && $tmp_en_time > $tmp_miden_time) {
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
$date = date_create(strval($y) . '-' . strval($m));
$formated_date = date_format($date, 'Y-m-d');
$sql = "replace into job_income_aggregation(user_id,job_name,date,current_hourly_wage,current_mid_wage,current_cutoff_day,current_start_mid_time,current_end_mid_time,predict_income) values(:user_id,:job_name,:date,:current_hourly_wage,:current_mid_wage,:current_cutoff_day,:current_start_mid_time,:current_end_mid_time,:predict_income)";
if ($stmt = $db->prepare($sql)) {
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
    $stmt->bindValue(':date', $formated_date, PDO::PARAM_STR);
    $stmt->bindValue(':current_hourly_wage', $hourly_wage, PDO::PARAM_STR);
    $stmt->bindValue(':current_mid_wage', $mid_wage, PDO::PARAM_STR);
    $stmt->bindValue(':current_cutoff_day', $cutoff_day, PDO::PARAM_INT);
    $stmt->bindValue(':current_start_mid_time', $start_mid_time, PDO::PARAM_STR);
    $stmt->bindValue(':current_end_mid_time', $end_mid_time, PDO::PARAM_STR);
    $stmt->bindValue(':predict_income', $salary, PDO::PARAM_INT);
    $stmt->execute();
}

$db = null;
// $result2 = $db->query("select * job_schedule where date > ")
