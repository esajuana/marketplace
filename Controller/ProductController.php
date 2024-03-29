<?php
include PROJECT_ROOT . '/Model/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getAllProducts(){
        return $this->productModel->getAllProducts();
    }

    public function detailProducts($id) {
        return $this->productModel->getProductDetails($id);
    }

    public function createProduct($data) {
        return $this->productModel->createProduct($data);
    }

    public function updateProduct($id, $data) {
        return $this->productModel->updateProduct($id, $data);
    }
    
    public function getProductById($id) {
        return $this->productModel->getProductById($id);
    }

    public function deleteProduct($id) {
        return $this->productModel->deleteProduct($id);
    }

    public function deletePermanentProduct($id) {
        return $this->productModel->deletePermanentProduct($id);
    }

    public function getRestoreData() {
        return $this->productModel->getRestoreData();
    }

    public function restore($ids) {
        return $this->productModel->restoreProducts($ids);
    }
 
}



?>
