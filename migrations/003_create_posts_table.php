<?php

$stmt = $pdo->prepare(
    "CREATE TABLE IF NOT EXISTS `posts` (
        `id` int NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `status` varchar(55) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
"
);
$stmt->execute([]);
