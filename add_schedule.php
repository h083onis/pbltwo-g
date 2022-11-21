<?php
// session_start();
// if (isset($_SESSION['idname']) == 0) {
//     header("Location:index.php"); //ログイン画面に飛ばす
// }
// $id = $_SESSION['id'];
$y = $_POST['year'];
$m = $_POST['month'];
$d = $_POST['day'];

$date = strval($y) .'-'. strval($m) .'-'. strval($d);
echo $date;
$item = $_POST['items'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// $db = new PDO("sqlite:circle.db");
// $money = $db->query("select money from bulletin where id='$id' and items='$item'");

// $sql = "insert into bulletin(id, date, startTime, endTime, money) values(:id, :date, :startTime, :endTime, :money)"; //idはint型として代入
// if ($stmt = $db->prepare($sql)) {
//   $stmt->bindValue(':id', $name, PDO::PARAM_STR);
//   $stmt->bindValue(':date', $date, PDO::PARAM_STR);
//   $stmt->bindValue(':startTime', $start_time, PDO::PARAM_STR);
//   $stmt->bindValue(':endTime', $end_time, PDO::PARAM_STR);
//   $stmt->bindValue(':money', $money, PDO::PARAM_STR);
//   $stmt->execute();
// }
// $db = null;

// header("Location:home.php?y=$y&m=$m");
