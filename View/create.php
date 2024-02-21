<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();

// Inisialisasi variabel pesan
$productNameErr = $priceErr = $quantityErr = $descriptionErr = '';
$productName = $price = $quantity = $description = '';
$message = '';

// Memproses data yang dikirimkan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    
    // Validasi product name
    if (empty($product_name)) {
        $productNameErr = "Product name is required.";
    } else {
        $productName = $product_name;
    }
    
    // Validasi price harus berupa angka
    if (empty($price)) {
        $priceErr = "Price is required.";
    } elseif (!is_numeric($price)) {
        $priceErr = "Price must be a numeric value.";
    } else {
        $price = $price;
    }
    
    // Validasi quantity harus berupa angka positif
    if (empty($quantity)) {
        $quantityErr = "Quantity is required.";
    } elseif (!is_numeric($quantity) || $quantity <= 0) {
        $quantityErr = "Quantity must be a positive integer.";
    } else {
        $quantity = $quantity;
    }
    
    // Validasi description
    if (empty($description)) {
        $descriptionErr = "Description is required.";
    } else {
        $description = $description;
    }
    
    // Jika tidak ada kesalahan validasi, maka proses simpan data
    if (empty($productNameErr) && empty($priceErr) && empty($quantityErr) && empty($descriptionErr)) {
        // Memanggil metode createProduct dari controller untuk membuat produk baru
        $data = [
            'product_name' => $productName,
            'price' => $price,
            'quantity' => $quantity,
            'description' => $description
        ];
        
        $result = $controller->createProduct($data);

        // Menyiapkan pesan berdasarkan hasil operasi
        if ($result) {
            $message = "Product created successfully!";
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Failed to create product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <a href='../index.php' class='back-link'>Back to Product List</a>
    <br><br>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <!-- Form for creating a new product -->
    <form action="" method="POST">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo $productName; ?>"><br>
        <span style="color: red;"><?php echo $productNameErr; ?></span><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>"><br>
        <span style="color: red;"><?php echo $priceErr; ?></span><br>
        
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>"><br>
        <span style="color: red;"><?php echo $quantityErr; ?></span><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo $description; ?></textarea><br>
        <span style="color: red;"><?php echo $descriptionErr; ?></span><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
