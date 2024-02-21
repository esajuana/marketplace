<?php
include PROJECT_ROOT . '/Database/Database.php';

class Product {
    private $db;
    private $table = 'products';
    private $fillable = ['product_name', 'price', 'quantity', 'description', 'deleted_at'];


    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts(){
        return $this->db->getAll($this->table);
    }

    public function getProductDetails($id) {
        return $this->db->getDetails($this->table, $id);
    }

    public function createProduct($data) {
        $filteredData = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $filteredData[$key] = $value;
            }
        }
        return $this->db->create($this->table, $filteredData);
    }
    
    public function getProductById($id) {
        return $this->db->getRowById($this->table, $id);
    }

    public function updateProduct($id, $data) {
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
        return $this->db->update($this->table, $id, $filteredData);
    }

    public function deleteProduct($id) {
        return $this->db->delete($this->table, $id);
    }

    public function deletePermanentProduct($id) {
        return $this->db->deletePermanent($this->table, $id);
    }

    public function getRestoreData() {
        return $this->db->getRestoreData($this->table);
    }

    public function restoreProducts($ids) {
        return $this->db->restore($this->table, $ids);
    }
}


?>
