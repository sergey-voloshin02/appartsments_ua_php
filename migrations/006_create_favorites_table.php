<?php

$stmt = $pdo->prepare(
    "CREATE TABLE `favorites` (
        `id` int NOT NULL AUTO_INCREMENT,
        `post_id` int NOT NULL,
        `user_id` int NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute([]);
