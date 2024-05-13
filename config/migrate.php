<?php

require __DIR__ . '/../vendor/autoload.php';

use Components\Database;

$db = new Database();
$pdo = $db->getConnection();

if ($pdo === null) {
    die("Database could not be connected.");
}

$stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
$stmt->execute([]);

$migrations = scandir(__DIR__ . '/../migrations');
$executedMigrations = $pdo->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

foreach ($migrations as $migration) {
    if ($migration === '.' || $migration === '..' || in_array($migration, $executedMigrations)) {
        continue;
    }

    require __DIR__ . '/../migrations/' . $migration;

    $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)")->execute([$migration]);
}
