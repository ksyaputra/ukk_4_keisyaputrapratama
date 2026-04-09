<?php
class Book {
    private $table = 'books';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllBooks() {
        $this->db->query("SELECT b.*, c.name as category_name FROM {$this->table} b LEFT JOIN categories c ON b.category_id = c.id ORDER BY b.created_at DESC");
        return $this->db->resultSet();
    }

    public function getBookById($id) {
        $this->db->query("SELECT b.*, c.name as category_name FROM {$this->table} b LEFT JOIN categories c ON b.category_id = c.id WHERE b.id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function searchBooks($keyword) {
        $this->db->query("SELECT b.*, c.name as category_name FROM {$this->table} b LEFT JOIN categories c ON b.category_id = c.id WHERE b.title LIKE :keyword OR b.author LIKE :keyword2 ORDER BY b.created_at DESC");
        $this->db->bind('keyword', '%' . $keyword . '%');
        $this->db->bind('keyword2', '%' . $keyword . '%');
        return $this->db->resultSet();
    }

    public function addBook($data) {
        $this->db->query("INSERT INTO {$this->table} (category_id, title, author, publish_year, quantity, cover_image) VALUES (:category_id, :title, :author, :publish_year, :quantity, :cover_image)");
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('title', htmlspecialchars($data['title']));
        $this->db->bind('author', htmlspecialchars($data['author']));
        $this->db->bind('publish_year', $data['publish_year']);
        $this->db->bind('quantity', $data['quantity']);
        $this->db->bind('cover_image', $data['cover_image'] ?? 'default_cover.png');
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateBook($data) {
        $this->db->query("UPDATE {$this->table} SET category_id=:category_id, title=:title, author=:author, publish_year=:publish_year, quantity=:quantity, cover_image=:cover_image WHERE id=:id");
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('title', htmlspecialchars($data['title']));
        $this->db->bind('author', htmlspecialchars($data['author']));
        $this->db->bind('publish_year', $data['publish_year']);
        $this->db->bind('quantity', $data['quantity']);
        $this->db->bind('cover_image', $data['cover_image']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteBook($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id=:id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $this->db->single()['total'];
    }

    public function updateQuantity($id, $change) {
        $this->db->query("UPDATE {$this->table} SET quantity = quantity + :change WHERE id=:id");
        $this->db->bind('change', $change);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
