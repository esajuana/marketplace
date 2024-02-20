<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_POST['id'];
    $data = [];
    foreach ($_POST as $key => $value) {
        if ($key !== 'id' && $key !== 'submit') {
            $data[$key] = $value;
        }
    }
    $success = $controller->updateProduct($id, $data);
    if ($success) {
        header("Location: ../index.php"); // Redirect to index page or any other page
        exit();
    } else {
        echo "Failed to update product.";
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
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" required><br>
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea><br>
        <br>
        <input type="submit" name="submit" value="Update Product" on="return confirmUpdate()">
    </form>

</body>
</html>
