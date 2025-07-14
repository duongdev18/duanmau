<?php
class Category extends Model {
    private $table = 'categories';

    // Get all categories
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    // Get category by ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt ? $stmt->fetch() : null;
    }

    // Create new category
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $params = [
            'name' => $data['name'],
            'description' => $data['description']
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt ? $this->db->lastInsertId() : false;
    }

    // Update category
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET name = :name, description = :description WHERE id = :id";
        $params = [
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt ? true : false;
    }

    // Delete category
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt ? true : false;
    }
} 