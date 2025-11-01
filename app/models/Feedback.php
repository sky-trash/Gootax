<?php

class Feedback
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO feedback (user_id, subject, message, rating, categories, contact_method) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['user_id'],
            $data['subject'],
            $data['message'],
            $data['rating'],
            json_encode($data['categories']),
            $data['contact_method']
        ]);
    }

    public function getAllByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT subject, message, rating, categories, contact_method, created_at 
            FROM feedback 
            WHERE user_id = ? 
            ORDER BY created_at DESC
        ");

        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
