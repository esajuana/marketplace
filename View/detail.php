<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';
$controller = new ProductController();

$productDetails = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productDetails = $controller->detailProducts($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($productDetails) : ?>
            <h2>Product Details</h2>
            <a href="../index.php">Back To Product List</a>
            <table>
                <tr><th>ID</th><td><?php echo $productDetails['id']; ?></td></tr>
                <tr><th>Product Name</th><td><?php echo $productDetails['product_name']; ?></td></tr>
                <tr><th>Price</th><td>Rp.<?php echo number_format($productDetails["price"]) ?></td></tr>
                <tr><th>Quantity</th><td><?php echo $productDetails['quantity']; ?></td></tr>
                <tr><th>Description</th><td><?php echo $productDetails['description']; ?></td></tr>
            </table>
        <?php else : ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
