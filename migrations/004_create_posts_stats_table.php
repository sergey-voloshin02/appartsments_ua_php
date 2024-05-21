<?php

$stmt = $pdo->prepare(
    "CREATE TABLE `posts_stats` (
        `id` int NOT NULL AUTO_INCREMENT,
        `post_id` int NOT NULL,
        `user_id` int NOT NULL,
        `phone_views` int NOT NULL DEFAULT '0',
        `post_views` int NOT NULL DEFAULT '0',
        `post_responses` int NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        UNIQUE KEY `post_id` (`post_id`),
        CONSTRAINT `posts_stats_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute([]);
