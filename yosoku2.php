<?php
session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 1;
$y = $_GET['y'];
$m = $_GET['m'];
if(isset($_GET['d'])){
    $d = $_GET['d'];
}
if(isset($_GET['sel_d'])){
    $d = $_GET['sel_d'];
}

$job_name = $_GET['job_name'];

$db = new PDO("sqlite:part-time-job.db");
$sel_date = date_create(strval($y) . '-' . strval($m));
$sel_formated_date = date_format($sel_date, 'Y-m');


//$sel_date = date_create(strval($tem_aft_y) . '-' . strval($tem_aft_m));
//$sel_formated_date = date_format($sel_date, 'Y-m');

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

$tem_pre_m = $m - 1;
$tem_pre_y = $y;
$tem_aft_m = $m;
$tem_aft_y = $y;

if ($tem_pre_m == 0) {
    $tem_pre_m = 12;
    $tem_pre_y = $y - 1;
}

$tem_cutoff_day = $cutoff_day+1;
if($tem_cutoff_day==32){
    if($tem_m == 12){
        $tem_y = $tem_y + 1;
        $tem_m = 1;
        $tem_cutoff_day = 1;
    }
    else{
        $tem_cutoff_day = 1;
        $tem_m += 1;
    }
}

if($d > $cutoff_day && $m == 12){
    $tem_pre_m += 1;
    $tem_aft_y += 1;
    $tem_aft_m = 1;
}
else if($d > $cutoff_day){
    $tem_pre_m += 1;
    $tem_aft_m += 1;
}

$pre_job_date = date_create(strval($tem_pre_y) . '-' . strval($tem_pre_m) . '-' . strval($tem_cutoff_day));
$formated_pre_date = date_format($pre_job_date, 'Y-m-d');
$now_job_date = date_create(strval($tem_aft_y) . '-' . strval($tem_aft_m) . '-' . strval($cutoff_day));
$formated_now_date = date_format($now_job_date, 'Y-m-d');
$cutoff_month = date_create(strval($tem_aft_y) . '-' . strval($tem_aft_m));
$format_cutoff_month = date_format($cutoff_month, 'Y-m');
//echo $formated_pre_date.'から<br>';
//echo $formated_now_date.'まで<br>';

$result2 = $db->query("select * from job_schedule where user_id ='$user_id' and job_name ='$job_name' and job_date BETWEEN '$formated_pre_date' and '$formated_now_date'");
$salary = 0;

foreach ($result2 as $value) {
    $tmp_st_time = new DateTime($value['job_date'] . ' ' . $value['start_time']);
    $tmp_st_time->format('Y-m-d H:i');

    if (strtotime($value['start_time']) > strtotime($value['end_time'])) {
        $tmp_en_time = new Datetime($value['job_date'] . ' ' . $value['end_time'] . '+1 day');
        $tmp_en_time->format('Y-m-d H:i');
    } else {
        $tmp_en_time = new DateTime($value['job_date'] . ' ' . $value['end_time']);
        $tmp_en_time->format('Y-m-d H:i');
    }

    $tmp_midst_time = new DateTime($value['job_date'] . ' ' . $start_mid_time);
    $tmp_midst_time->format('Y-m-d H:i');

    $tmp_premiden_time = new Datetime(($value['job_date'] . ' ' . $end_mid_time));
    $tmp_premiden_time->format('Y-m-d H:i');
    
    $tmp_miden_time = new Datetime($value['job_date'] . ' ' . $end_mid_time.'+ 1 day');
    $tmp_miden_time->format('Y-m-d H:i');

    // 深夜制度なし
    if($mid_wage == 0){
        $difference = date_diff($tmp_st_time, $tmp_en_time);
        $min_time = $difference->days * 24 * 60;
        $min_time += $difference->h * 60;
        $min_time += $difference->i;    //勤務時間(分
        $min_wage = $hourly_wage / 60;  //分給
        $day_salary = $min_wage * $min_time;
        $salary += $day_salary;
        //echo '0<br>';
    }
    // 始まり深夜
    else if ($tmp_st_time <= $tmp_premiden_time) {
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
        //echo '1<br>';
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
        //echo '2<br>';
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
        //echo '3<br>';
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
        //echo '4<br>';
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
        //echo '5<br>';
    }
}

//echo $salary;

// echo gettype($start_mid_time);
// echo $start_mid_time;

$sql = "replace into job_income_aggregation(user_id,job_name,date,current_hourly_wage,current_mid_wage,current_cutoff_day,current_start_mid_time,current_end_mid_time,predict_income) values(:user_id,:job_name,:date,:current_hourly_wage,:current_mid_wage,:current_cutoff_day,:current_start_mid_time,:current_end_mid_time,:predict_income)";
if ($stmt = $db->prepare($sql)) {
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
    $stmt->bindValue(':date', $format_cutoff_month, PDO::PARAM_STR);
    $stmt->bindValue(':current_hourly_wage', $hourly_wage, PDO::PARAM_STR);
    $stmt->bindValue(':current_mid_wage', $mid_wage, PDO::PARAM_STR);
    $stmt->bindValue(':current_cutoff_day', $cutoff_day, PDO::PARAM_INT);
    $stmt->bindValue(':current_start_mid_time', $start_mid_time, PDO::PARAM_STR);
    $stmt->bindValue(':current_end_mid_time', $end_mid_time, PDO::PARAM_STR);
    $stmt->bindValue(':predict_income', $salary, PDO::PARAM_INT);
    $stmt->execute();
}

$db = null;
if(isset($_GET['sel_d'])){
    $sel_d = $_GET['sel_d'];
    header("Location:home.php?y=$y&m=$m&sel_d=$sel_d");
    exit();
}
header("Location:home.php?y=$y&m=$m&sel_d=$d");
