<?php
class Product extends Model {
    private $table = 'products';

    // Get all products with category information
    public function getAll() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    // Get product by ID
    public function getById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt ? $stmt->fetch() : null;
    }

    // Create new product
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (category_id, name, description, price, image, stock) 
                VALUES (:category_id, :name, :description, :price, :image, :stock)";
        $params = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'] ?? null,
            'stock' => $data['stock'] ?? 0
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt ? $this->db->lastInsertId() : false;
    }

    // Update product
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET category_id = :category_id, 
                    name = :name, 
                    description = :description, 
                    price = :price, 
                    stock = :stock";
        
        $params = [
            'id' => $id,
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock']
        ];

        // Only update image if a new one is provided
        if (isset($data['image']) && !empty($data['image'])) {
            $sql .= ", image = :image";
            $params['image'] = $data['image'];
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->query($sql, $params);
        return $stmt ? true : false;
    }

    // Delete product
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt ? true : false;
    }

    // Search products
    public function search($keyword) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword 
                OR p.description LIKE :keyword 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql, ['keyword' => "%$keyword%"]);
        return $stmt ? $stmt->fetchAll() : [];
    }

    // Get products by category
    public function getByCategory($categoryId) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql, ['category_id' => $categoryId]);
        return $stmt ? $stmt->fetchAll() : [];
    }
} 