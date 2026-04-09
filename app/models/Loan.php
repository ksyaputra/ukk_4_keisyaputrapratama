<?php
class Loan {
    private $table = 'loans';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllLoans() {
        $this->db->query("SELECT l.*, u.fullname as user_name, u.username, b.title as book_title FROM {$this->table} l JOIN users u ON l.user_id = u.id JOIN books b ON l.book_id = b.id ORDER BY l.borrow_date DESC");
        return $this->db->resultSet();
    }

    public function getLoanById($id) {
        $this->db->query("SELECT l.*, u.fullname as user_name, b.title as book_title FROM {$this->table} l JOIN users u ON l.user_id = u.id JOIN books b ON l.book_id = b.id WHERE l.id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getLoansByUserId($userId) {
        $this->db->query("SELECT l.*, b.title as book_title, b.author as book_author FROM {$this->table} l JOIN books b ON l.book_id = b.id WHERE l.user_id=:user_id ORDER BY l.borrow_date DESC");
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    public function getActiveLoansByUserId($userId) {
        $this->db->query("SELECT l.*, b.title as book_title, b.author as book_author FROM {$this->table} l JOIN books b ON l.book_id = b.id WHERE l.user_id=:user_id AND l.status='borrowed' ORDER BY l.due_date ASC");
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    public function addLoan($data) {
        $this->db->query("INSERT INTO {$this->table} (user_id, book_id, borrow_date, due_date, status) VALUES (:user_id, :book_id, :borrow_date, :due_date, 'borrowed')");
        $this->db->bind('user_id', $data['user_id']);
        $this->db->bind('book_id', $data['book_id']);
        $this->db->bind('borrow_date', $data['borrow_date']);
        $this->db->bind('due_date', $data['due_date']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function returnBook($id) {
        $loan = $this->getLoanById($id);
        $returnDate = date('Y-m-d');
        $fine = 0;
        $status = 'returned';

        if ($returnDate > $loan['due_date']) {
            $diff = (strtotime($returnDate) - strtotime($loan['due_date'])) / 86400;
            $fine = $diff * 1000; // Rp 1.000 per hari
            $status = 'late';
        }

        $this->db->query("UPDATE {$this->table} SET return_date=:return_date, status=:status, fine_amount=:fine WHERE id=:id");
        $this->db->bind('return_date', $returnDate);
        $this->db->bind('status', $status);
        $this->db->bind('fine', $fine);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countActive() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status='borrowed'");
        return $this->db->single()['total'];
    }

    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $this->db->single()['total'];
    }

    public function getTotalFines() {
        $this->db->query("SELECT COALESCE(SUM(fine_amount), 0) as total FROM {$this->table}");
        return $this->db->single()['total'];
    }

    public function getRecentLoans($limit = 5) {
        $this->db->query("SELECT l.*, u.fullname as user_name, b.title as book_title FROM {$this->table} l JOIN users u ON l.user_id = u.id JOIN books b ON l.book_id = b.id ORDER BY l.borrow_date DESC LIMIT $limit");
        return $this->db->resultSet();
    }

    public function checkActiveLoan($userId, $bookId) {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id=:user_id AND book_id=:book_id AND status='borrowed'");
        $this->db->bind('user_id', $userId);
        $this->db->bind('book_id', $bookId);
        return $this->db->single();
    }
}
