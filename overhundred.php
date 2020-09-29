<?php

$f = fopen('data.csv', 'r');

$years = [];

$header = fgetcsv($f);

while ($row = fgetcsv($f)) {
    $combined = array_combine($header, $row);

    $date = new DateTime($combined['DATE']);
    $year = $date->format('Y');

    if (!isset($years[$year])) {
        $years[$year] = [
            $year,
            0,
            0,
            0
        ];
    }

    if ($combined['TMAX'] >= 100) {
        $years[$year][1] += 1;
    }

    if ($combined['TMAX'] >= 110) {
        $years[$year][2] += 1;
    }

    $years[$year][3] += 1;
}

fclose($f);

$f = fopen('processed.csv', 'w');

fputcsv($f, ["Year", "at least 100", "at least 110", "total"]);
foreach ($years as $year => $nums) {
    fputcsv($f, $nums);
}

fclose($f);
