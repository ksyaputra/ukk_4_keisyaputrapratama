<?php
class Category {
    private $table = 'categories';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCategories() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $this->db->resultSet();
    }

    public function getCategoryById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function addCategory($name) {
        $this->db->query("INSERT INTO {$this->table} (name) VALUES (:name)");
        $this->db->bind('name', htmlspecialchars($name));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateCategory($data) {
        $this->db->query("UPDATE {$this->table} SET name=:name WHERE id=:id");
        $this->db->bind('name', htmlspecialchars($data['name']));
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteCategory($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id=:id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
