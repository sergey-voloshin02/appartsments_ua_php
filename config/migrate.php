<?php

// файл виконання міграцій

print_r(555);exit;

$migrations = scandir(__DIR__ . '/migrations');

foreach ($migrations as $migration) {
    if ($migration === '.' || $migration === '..') {
        continue;
    }
    require __DIR__ . '/migrations/' . $migration;
}
