<?php
include PROJECT_ROOT . '/Config/db.php';

class Database {
    private $conn;

    public function __construct() {
        $servername = DB_SERVER;
        $dbname = DB_NAME;
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAll($table) {
        try {
            $stmt = $this->conn->query("SELECT * FROM $table WHERE deleted_at IS NULL");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getDetails($table, $id) {
        try {
            $sql = "SELECT * FROM $table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function create($table, $data) {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        
        $i = 1;
        foreach ($data as $value) {
            $stmt->bindValue($i++, $value);
        }

        return $stmt->execute();
    }

    public function getRowById($table, $id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function update($table, $id, $data) {
        try {
            $placeholders = implode(', ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($data)));
            $sql = "UPDATE $table SET $placeholders WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $data['id'] = $id;
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function delete($table, $id)
    {
        try {
            $deletedAt = date("Y-m-d H:i:s");
            $stmt = $this->conn->prepare("UPDATE $table SET deleted_at = :deleted_at WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':deleted_at', $deletedAt);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deletePermanent($table, $id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM $table WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getRestoreData($table) {
        try {
            $stmt = $this->conn->query("SELECT * FROM $table WHERE deleted_at IS NOT NULL");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e)  {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function restore($table, $ids) {
        try {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $this->conn->prepare("UPDATE $table SET `deleted_at` = NULL WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            return true;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    
}

   

?>
