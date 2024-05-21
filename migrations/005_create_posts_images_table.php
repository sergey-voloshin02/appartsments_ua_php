<?php

$stmt = $pdo->prepare(
    "CREATE TABLE `posts_images` (
        `id` int NOT NULL AUTO_INCREMENT,
        `post_id` int NOT NULL,
        `image_path` varchar(255) NOT NULL,
        `is_main` tinyint(1) DEFAULT 0,
        `sort_order` int DEFAULT 0,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute([]);
