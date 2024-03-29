<?php
session_start();
$user_id = $_SESSION['user_id'];
$y = $_POST['year'];
$m = $_POST['month'];
$d = $_POST['day'];

$job_date = strval($y) . '-' . strval($m) . '-' . strval($d);
$date = date_create($job_date);
$formated_date = date_format($date, 'Y-m-d');
$job_name = $_POST['job_name'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$db = new PDO("sqlite:part-time-job.db");
$result = $db->query("select * from job_schedule where user_id = '$user_id' and job_date = '$formated_date'");
$check_st_time = new DateTime($start_time);
$check_en_time = new DateTime($end_time);

#入力がおかしい場合のエラー
if ($job_name == '' || $start_time == '' || $end_time == '') {
  $db = null;
  header("Location:home.php?e=1&y=$y&m=$m&sel_d=$d"); //エラーを返す
  exit();
}

#時間帯にかぶりがある場合のエラー
foreach ($result as $value) {
  echo $value['start_time'];
  $tem_st_time = new DateTime($value['start_time']);
  $tem_en_time = new DateTime($value['end_time']);
  if ($tem_st_time <= $check_en_time && $tem_en_time >= $check_st_time){
    $db = null;
    header("Location:home.php?e=2&y=$y&m=$m&sel_d=$d"); //エラーを返す
    exit();
  }
}

$sql = "insert into job_schedule(user_id, job_name, job_date, start_time, end_time) values(:user_id, :job_name,:job_date, :start_time, :end_time)";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->bindValue(':job_date', $formated_date, PDO::PARAM_STR);
  $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR);
  $stmt->execute();
}
$db = null;

header("Location:yosoku2.php?y=$y&m=$m&d=$d&job_name=$job_name");
