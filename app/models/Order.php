<?php
class Order extends Model {
    private $table = 'orders';

    public function getAll() {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC")->fetchAll();
    }

    public function getRecent($limit = 5) {
        return $this->db->query("SELECT o.*, u.full_name as customer_name 
            FROM {$this->table} o 
            LEFT JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC 
            LIMIT ?", [$limit])->fetchAll();
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (user_id, total_amount, status, created_at) 
                VALUES (?, ?, ?, NOW())";
        return $this->db->query($sql, [
            $data['user_id'],
            $data['total_amount'],
            $data['status'] ?? 'pending'
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->db->query($sql, [$data['status'], $id]);
    }
} 