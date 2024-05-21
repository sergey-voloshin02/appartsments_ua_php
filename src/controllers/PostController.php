<?php

namespace Controllers;

use Exception;
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



            $stmt = $this->pdo->prepare("");
            $stmt->execute([]);

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
     * @param array $files
     * @return string
     */
    public function addPost(array $post, array $files)
    {
        try {
            $this->pdo->beginTransaction();

            // Перевірка обов'язкових полів
            $requiredFields = [
                'title', 'status', 'period', 'type', 'price', 'quadrature', 'numberOfRooms',
                'city', 'adress', 'age', 'badrooms', 'bathrooms', 'parking', 'heating',
                'waterSupply', 'gym', 'storeroom', 'realtyPlanDescription'
            ];
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

            // Проверка количества изображений
            if (count($files['images']['name']) > 20) {
                http_response_code(400);
                return array(
                    'status' => 'error',
                    'message' => 'Too many images. Maximum allowed is 20.'
                );
            }

            $stmt = $this->pdo->prepare(
                "INSERT INTO 
                    posts 
                        (title, description, publication_status, realty_status, plan_photo, data) 
                    VALUES 
                        (?, ?, ?, ?, ?, ?)
                        "
            );
            $stmt->execute([
                $post['title'],
                $post['description'],
                'unapproved',
                $post['status'],
                $post['plan_photo'],
                json_encode(array())
            ]);

            $postId = $this->pdo->lastInsertId();

            // збереження зображень
            $isMain = true;
            foreach ($files['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $files['images']['name'][$key];
                $file_tmp = $files['images']['tmp_name'][$key];
                $upload_dir = 'uploads/';
                $file_path = $upload_dir . basename($file_name);
                $sortOrder = $key + 1; // Порядок сортировки

                if (move_uploaded_file($file_tmp, $file_path)) {
                    $stmt = $this->pdo->prepare("INSERT INTO posts_images (post_id, image_path, is_main, sort_order) VALUES (?, ?, ?, ?)");
                    $stmt->execute([
                        $postId,
                        $file_path,
                        $isMain ? 1 : 0,
                        $sortOrder
                    ]);
                    $isMain = false;
                } else {
                    throw new Exception("Failed to upload image: " . $file_name);
                }
            }

            $this->pdo->commit();
            return array(
                'status' => 'done',
                'message' => ''
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
     * @param array $filters
     * @return string
     */
    public function getActivePosts(array $post, array $filters)
    {
    }
}
