<?php
class User {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllUsers() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getAllMembers() {
        $this->db->query("SELECT * FROM {$this->table} WHERE role='user' ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getUserByUsername($username) {
        $this->db->query("SELECT * FROM {$this->table} WHERE username=:username");
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function addUser($data) {
        $this->db->query("INSERT INTO {$this->table} (username, password, fullname, role) VALUES (:username, :password, :fullname, :role)");
        $this->db->bind('username', htmlspecialchars($data['username']));
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('fullname', htmlspecialchars($data['fullname']));
        $this->db->bind('role', $data['role'] ?? 'user');
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateProfile($data) {
        $this->db->query("UPDATE {$this->table} SET fullname=:fullname, avatar=:avatar WHERE id=:id");
        $this->db->bind('fullname', htmlspecialchars($data['fullname']));
        $this->db->bind('avatar', $data['avatar']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteUser($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id=:id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE role='user'");
        return $this->db->single()['total'];
    }
}
