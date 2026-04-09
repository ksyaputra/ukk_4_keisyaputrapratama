<?php
class Review {
    private $table = 'reviews';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getReviewsByBookId($bookId) {
        $this->db->query("SELECT r.*, u.fullname as user_name FROM {$this->table} r JOIN users u ON r.user_id = u.id WHERE r.book_id=:book_id ORDER BY r.created_at DESC");
        $this->db->bind('book_id', $bookId);
        return $this->db->resultSet();
    }

    public function addReview($data) {
        $this->db->query("INSERT INTO {$this->table} (user_id, book_id, rating, comment) VALUES (:user_id, :book_id, :rating, :comment)");
        $this->db->bind('user_id', $data['user_id']);
        $this->db->bind('book_id', $data['book_id']);
        $this->db->bind('rating', $data['rating']);
        $this->db->bind('comment', htmlspecialchars($data['comment']));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getAverageRating($bookId) {
        $this->db->query("SELECT COALESCE(AVG(rating), 0) as avg_rating, COUNT(*) as total FROM {$this->table} WHERE book_id=:book_id");
        $this->db->bind('book_id', $bookId);
        return $this->db->single();
    }

    public function hasReviewed($userId, $bookId) {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id=:user_id AND book_id=:book_id");
        $this->db->bind('user_id', $userId);
        $this->db->bind('book_id', $bookId);
        return $this->db->single();
    }
}
