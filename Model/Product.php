<?php
include PROJECT_ROOT . '/Database/Database.php';

class Product {
    private $db;
    private $table = 'products';
    private $fillable = ['product_name', 'price', 'quantity', 'description'];


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
        $filteredData = array_intersect_key($data, array_flip($this->fillable));
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

    public function deleteMultipleProducts($ids) {
        return $this->db->deleteMultiple($this->table, $ids);
    }

    public function restoreData() {
        return $this->db->restoreData($this->table);
    }

    public function restoreProducts($ids) {
        return $this->db->restore($this->table, $ids);
    }
}


?>
