<?php

$stmt = $pdo->prepare(
    "CREATE TABLE IF NOT EXISTS `tokens` (
        `id` int NOT NULL AUTO_INCREMENT,
        `token` VARCHAR(255) NOT NULL,
        `user_id` int NOT NULL,
        `token_data` json DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute();
