<?php

$stmt = $pdo->prepare(
    "CREATE TABLE `users` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_phone` varchar(255) DEFAULT NULL,
        `user_email` varchar(255) NOT NULL,
        `user_password` varchar(255) NOT NULL,
        `email_verified_at` datetime DEFAULT NULL,
        `user_data` json DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute([]);
