<?php
class User extends Model {
    private $table = 'users';

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetchAll() : [];
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result->fetch() : false;
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        return $result ? $result->fetch() : false;
    }

    public function create($data) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO {$this->table} (full_name, email, password, role, created_at) 
                    VALUES (:full_name, :email, :password, :role, NOW())";
            
            $params = [
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role'] ?? 'user'
            ];

            $result = $this->db->query($sql, $params);
            
            if ($result) {
                $this->db->commit();
                return $this->db->lastInsertId();
            }
            
            $this->db->rollBack();
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $this->db->beginTransaction();

            $fields = [];
            $params = ['id' => $id];

            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $fields[] = "{$key} = :{$key}";
                    $params[$key] = $value;
                }
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            $result = $this->db->query($sql, $params);
            
            if ($result) {
                $this->db->commit();
                return true;
            }
            
            $this->db->rollBack();
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();
            
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $result = $this->db->query($sql, ['id' => $id]);
            
            if ($result) {
                $this->db->commit();
                return true;
            }
            
            $this->db->rollBack();
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        $result = $this->db->query($sql, ['limit' => $limit]);
        return $result ? $result->fetchAll() : [];
    }
} 