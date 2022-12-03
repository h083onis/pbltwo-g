<?php
$time1 = new DateTime('2020/02/22 09:23:00');
$time2 = new DateTime('2020/03/10 09:23:00');

$diff = $time1->diff($time2);

if ($diff->h == 0 && $diff->i == 0 && $diff->s == 0) {
  echo '一致しています';
}
