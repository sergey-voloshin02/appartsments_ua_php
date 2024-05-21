<?php

$stmt = $pdo->prepare(
    "CREATE TABLE `posts` (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `publication_status` varchar(55) NOT NULL,
        `realty_status` varchar(55) NOT NULL,
        `plan_photo` varchar(255),
        `data` json NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
$stmt->execute([]);
