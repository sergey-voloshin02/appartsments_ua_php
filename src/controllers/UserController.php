<?php

namespace Controllers;

use PDO;
use Ramsey\Uuid\Uuid;

class UserController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function register(array $userData)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = ['email', 'name', 'password'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                http_response_code(400);
                return json_encode(array(
                    'status' => 'error',
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                ), JSON_UNESCAPED_UNICODE);
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (name, phone, password) VALUES (?, ?, ?)");
            $stmt->execute([
                $userData['name'],
                $userData['phone'],
                password_hash($userData['password'], PASSWORD_DEFAULT)
            ]);

            $this->pdo->commit();
            echo json_encode(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // Логика обработки ошибки
            http_response_code(500);
            echo json_encode(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function login(array $userData)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = ['email', 'password'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                http_response_code(400);
                return json_encode(array(
                    'status' => 'error',
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                ), JSON_UNESCAPED_UNICODE);
            }

            // перевірка токена
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE user_email = ?");
            $stmt->execute([
                $userData['email']
            ]);

            $token = strtoupper(Uuid::uuid4()->toString());

            $stmt = $this->pdo->prepare("INSERT INTO tokens (name, phone, password) VALUES (?, ?, ?)");
            $stmt->execute([
                $userData['name'],
                $userData['phone'],
                password_hash($userData['password'], PASSWORD_DEFAULT)
            ]);

            $this->pdo->commit();
            echo json_encode(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // Логика обработки ошибки
            http_response_code(500);
            echo json_encode(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
