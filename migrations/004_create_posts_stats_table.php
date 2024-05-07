<?php

$stmt = $pdo->prepare(
    "CREATE TABLE IF NOT EXISTS `posts_stats` (
        `id` int NOT NULL,
        `post_id` int NOT NULL,
        `phone_views` int NOT NULL DEFAULT '0',
        `post_views` int NOT NULL DEFAULT '0',
        `post_responses` int NOT NULL DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
"
);
$stmt->execute([]);
