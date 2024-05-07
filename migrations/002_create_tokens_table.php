<?php

$stmt = $pdo->prepare(
    "CREATE TABLE IF NOT EXISTS `tokens` (
        `id` int NOT NULL,
        `token` int NOT NULL,
        `user_id` int NOT NULL,
        `token_data` json DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
"
);
$stmt->execute([]);
