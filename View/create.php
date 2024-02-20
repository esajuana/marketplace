
<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();

// Inisialisasi variabel pesan
$message = '';

// Memproses data yang dikirimkan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $data = [
        'product_name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity'],
        'description' => $_POST['description']
    ];
    
    // Memanggil metode createProduct dari controller untuk membuat produk baru
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
    <!-- Form for creating a new product -->
    <form action="" method="POST">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name"><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br>
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
