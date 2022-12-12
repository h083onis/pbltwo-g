<?php
function addMonth(DateTimeInterface $before, int $month = 1) {
  $beforeMonth = $before->format("n");

  // 加算する
  $after       = $before->add(new DateInterval("P" . $month . "M"));
  $afterMonth  = $after->format("n");

  // 加算結果が期待値と異なる場合は、前月の最終日に修正する
  $tmpAfterMonth = $beforeMonth + $month;
  $expectAfterMonth = $tmpAfterMonth > 12 ? $tmpAfterMonth - 12 : $tmpAfterMonth;

  if ($expectAfterMonth != $afterMonth) {
    $after = $after->modify("last day of last month");
  }

  return $after;
}

function subMonth(DateTimeInterface $before, int $month = 1) {
    // 変更前の月を取得する
    $beforeMonth = $before->format("n");
  
    // 減算する
    $after       = $before->sub(new DateInterval("P" . $month . "M"));
    $afterMonth  = $after->format("n");
  
    // 減算結果が期待値と異なる場合は、前月の最終日に修正する
    $tmpAfterMonth = $beforeMonth - $month;
    $expectAfterMonth = $tmpAfterMonth <= 0 ? $tmpAfterMonth + 12 : $tmpAfterMonth;
  
    if ($expectAfterMonth != $afterMonth) {
      $after = $after->modify("last day of last month");
    }
  
    return $after;
  }
  ?>