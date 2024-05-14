<?php

namespace Controllers;

use PDO;

class PostController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Створення оголошення
     * @param array $get
     * @return string
     */
    public function main(array $get)
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
                return array(
                    'status' => 'error',
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                );
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (name, phone, password) VALUES (?, ?, ?)");
            $stmt->execute([
                $userData['name'],
                $userData['phone'],
                password_hash($userData['password'], PASSWORD_DEFAULT)
            ]);

            $this->pdo->commit();
            return array(
                'status' => 'done',
                'message' => 'User registered successfully'
            );
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // Логика обработки ошибки
            http_response_code(500);
            return array(
                'status' => 'error',
                'message' => 'Operation failed: ' . $e->getMessage()
            );
        }
    }

    /**
     * Створення оголошення
     * @param array $post
     * @return string
     */
    public function addPost(array $post)
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
                return array(
                    'status' => 'error',
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                );
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (name, phone, password) VALUES (?, ?, ?)");
            $stmt->execute([
                $userData['name'],
                $userData['phone'],
                password_hash($userData['password'], PASSWORD_DEFAULT)
            ]);

            $this->pdo->commit();
            return array(
                'status' => 'done',
                'message' => 'User registered successfully'
            );
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // Логика обработки ошибки
            http_response_code(500);
            return array(
                'status' => 'error',
                'message' => 'Operation failed: ' . $e->getMessage()
            );
        }
    }

    /**
     * Публікація оголошення адміном
     * @param array $post
     * @return string
     */
    public function approvePost(array $post)
    {
    }

    /**
     * Список оголошень на перевірку
     * @param array $post
     * @return string
     */
    public function getUncheckedPosts(array $post)
    {
    }

    /**
     * Список активних оголошень
     * @param array $post
     * @return string
     */
    public function getActivePosts(array $post)
    {
    }
}
