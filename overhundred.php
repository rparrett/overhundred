<?php

$f = fopen('data.csv', 'r');

$years = [];
$thresholds = [100, 110];

$header = fgetcsv($f);

while ($row = fgetcsv($f)) {
    $combined = array_combine($header, $row);

    $date = new DateTime($combined['DATE']);
    $year = $date->format('Y');

    if (!isset($years[$year])) {
        $init = [
            'year' => $year,
            'total' => 0
        ];

        foreach ($thresholds as $threshold) {
            $init[(string) $threshold] = 0;
            $init[$threshold . '_streak'] = 0;
            $init[$threshold . '_max_streak'] = 0;
        }

        $years[$year] = $init;
    }

    foreach ($thresholds as $threshold) {
        if ($combined['TMAX'] >= $threshold) {
            $years[$year][(string) $threshold] += 1;
            $years[$year][$threshold . '_streak'] += 1;

            if ($years[$year][$threshold . '_streak'] > $years[$year][$threshold . '_max_streak']) {
                $years[$year][$threshold . '_max_streak'] = $years[$year][$threshold . '_streak'];
            }
        } else {
            $years[$year][$threshold . '_streak'] = 0;
        }
    }

    $years[$year]['total'] += 1;
}

fclose($f);

$f = fopen('processed.csv', 'w');

$headers = ["Year"];
foreach ($thresholds as $threshold) {
    array_push($headers, "At least {$threshold}");
    array_push($headers, "At least {$threshold} (streak)");
}
array_push($headers, "Total");

fputcsv($f, $headers);
foreach ($years as $year => $nums) {
    $out = [$nums['year']];
    foreach ($thresholds as $threshold) {
        array_push($out, $nums[$threshold]);
        array_push($out, $nums[$threshold . '_max_streak']);
    }

    array_push($out, $nums['total']);

    fputcsv($f, $out);
}

fclose($f);
