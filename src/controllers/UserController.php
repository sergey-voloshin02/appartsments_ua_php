<?php

namespace Controllers;

use PDO;
use Components\SysMethods;

class UserController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Логіка реєстрації юзера
     * @param array $userData ['email', 'name', 'password']
     * @return string
     */
    public function register(array $userData)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = ['email', 'name', 'password'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
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

            // перевірка пошти
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE user_email = ? LIMIT 1");
            $stmt->execute([
                $userData['email']
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {

                $stmt = $this->pdo->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
                $stmt->execute([
                    $userData['name'],
                    $userData['email'],
                    password_hash($userData['password'], PASSWORD_DEFAULT)
                ]);

                $this->pdo->commit();
                return array(
                    'status' => 'done',
                    'message' => 'User registered successfully'
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => 'Email already registered'
                );
            }
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
     * Логіка авторизації юзера
     * @param array $userData ['email', 'password']
     * @return string
     */
    public function login(array $userData)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = ['email', 'password'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
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

            // перевірка пошти
            $stmt = $this->pdo->prepare("SELECT id, user_password FROM users WHERE user_email = ? LIMIT 1");
            $stmt->execute([
                $userData['email']
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {

                if (password_verify($userData['password'], $user['user_password'])) {

                    $token = SysMethods::generateToken();

                    $stmt = $this->pdo->prepare("INSERT INTO tokens (token, user_id, created_at) VALUES (?, ?, ?)");
                    $stmt->execute([
                        $token,
                        $user['id'],
                        date('Y-m-d H:i:s')
                    ]);

                    $this->pdo->commit();
                    return array(
                        'status' => 'done',
                        'message' => 'User registered successfully',
                        'data' => array(
                            'token' => $token
                        )
                    );
                } else {
                    return array(
                        'status' => 'error',
                        'message' => 'Password is incorrect'
                    );
                }
            } else {
                return array(
                    'status' => 'error',
                    'message' => 'User with this email was not found'
                );
            }
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
     * Логіка виходу з аккаунту
     * @param array $data
     * @return string
     */
    public function logout(array $data)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = ['token'];
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

            $stmt = $this->pdo->prepare("DELETE FROM tokens WHERE token = ?");
            $stmt->execute([
                $data['token']
            ]);

            $this->pdo->commit();
            return array(
                'status' => 'done',
                'message' => 'User registered logouted'
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
     * Логіка отримання інформації по юзеру
     * @param array $params Очікує токен
     * @return string
     */
    public function getUser(array $params)
    {
        try {
            $this->pdo->beginTransaction();



            $this->pdo->commit();
            return array(
                'status' => 'done',
                'data' => array(
                    'userData' => [],
                    'stat' => array(
                        'postViews' => 0,
                        'phoneViews' => 0,
                        'responses' => 0, // відгуки на оголошення
                    ),
                    'likes' => [],
                    'myposts' => [],
                )
            );
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            http_response_code(500);
            return array(
                'status' => 'error',
                'message' => 'Operation failed: ' . $e->getMessage()
            );
        }
    }
}
