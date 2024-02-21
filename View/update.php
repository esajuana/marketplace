<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();

// Inisialisasi variabel pesan
$productNameErr = $priceErr = $quantityErr = $descriptionErr = '';
$message = '';

// Memproses data yang dikirimkan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil data dari formulir
    $id = $_POST['id'];
    $data = [];
    // Validasi product name
    if (!empty($_POST['product_name'])) {
        $data['product_name'] = $_POST['product_name'];
    } else {
        $productNameErr = "*Product name is required.";
    }
    // Validasi price
    if (!empty($_POST['price'])) {
        $data['price'] = $_POST['price'];
    } else {
        $priceErr = "*Price is required.";
    }
    // Validasi quantity
    if (!empty($_POST['quantity'])) {
        $data['quantity'] = $_POST['quantity'];
    } else {
        $quantityErr = "*Quantity is required.";
    }
    // Validasi description
    if (!empty($_POST['description'])) {
        $data['description'] = $_POST['description'];
    } else {
        $descriptionErr = "*Description is required.";
    }
    
    // Jika tidak ada kesalahan validasi, maka proses update data
    if (empty($productNameErr) && empty($priceErr) && empty($quantityErr) && empty($descriptionErr)) {
        $success = $controller->updateProduct($id, $data);

        // Menyiapkan pesan berdasarkan hasil operasi
        if ($success) {
            header("Location: ../index.php"); // Redirect to index page or any other page
            exit();
        } else {
            $message = "Failed to update product.";
        }
    }
}

$id = $_GET['id'] ?? null;
$product = $controller->getProductById($id);
if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <a href='../index.php' class='back-link'>Back to Product List</a>
    <br><br>

    <?php if (!empty($message)): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : $product['product_name']; ?>"><br>
        <span style="color: red;"><?php echo $productNameErr; ?></span><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : $product['price']; ?>"><br>
        <span style="color: red;"><?php echo $priceErr; ?></span><br>
        
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : $product['quantity']; ?>"><br>
        <span style="color: red;"><?php echo $quantityErr; ?></span><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : $product['description']; ?></textarea><br>
        <span style="color: red;"><?php echo $descriptionErr; ?></span><br><br>
        
        <input type="submit" name="submit" value="Update Product">
    </form>

</body>
</html>
