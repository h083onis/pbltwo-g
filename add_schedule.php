<?php
// session_start();
// if (isset($_SESSION['idname']) == 0) {
//     header("Location:index.php"); //ログイン画面に飛ばす
// }
// $user_id = $_SESSION['user_id'];
$user_id = 1;
$y = $_POST['year'];
$m = $_POST['month'];
$d = $_POST['day'];

$job_date = strval($y) .'-'. strval($m) .'-'. strval($d);
$job_name = $_POST['job_name'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$db = new PDO("sqlite:part-time-job.db");
$current_hourly_wage = $db->query("select hourly_wage from part_time_job_inf where user_id=$user_id and job_name='$job_name'");
// echo($current_hourly_wage);
$wage = $current_hourly_wage->fetchColumn();
echo $wage;

$sql = "insert into job_schedule(user_id, job_name, job_date, start_time, end_time, current_hourly_wage) values(:user_id, :job_name,:job_date, :start_time, :end_time, :current_hourly_wage)";
if ($stmt = $db->prepare($sql)) {
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':job_name', $job_name, PDO::PARAM_STR);
  $stmt->bindValue(':job_date', $job_date, PDO::PARAM_STR);
  $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR);
  $stmt->bindValue(':current_hourly_wage', $wage, PDO::PARAM_INT);
  $stmt->execute();
}
$db = null;

header("Location:home.php?y=$y&m=$m");
