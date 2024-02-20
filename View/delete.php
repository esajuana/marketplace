<?php
include '../Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$productController = new ProductController();

// Check if product ID is provided
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if delete button is pressed
    if(isset($_POST['delete_product'])) {
        $success = $productController->deleteProduct($product_id);
        if ($success) {
            echo "Product successfully marked as deleted.";
            header("Location: ../index.php");
            exit; 
        } 
    }

    $productDetails = $productController->detailProducts($product_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
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

        .container {
            margin-top: 20px;
        }

        .back-link {
            display: block;
            margin-bottom: 10px;
        }

        .delete-form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Details</h2>
        <a href='../index.php' class='back-link'>Back to Homepage</a>
        <?php if(isset($productDetails)) : ?>
            <table>
                <tr><th>ID</th><td><?php echo $productDetails['id']; ?></td></tr>
                <tr><th>Name</th><td><?php echo $productDetails['product_name']; ?></td></tr>
                <tr><th>Price</th><td><?php echo 'Rp' . number_format($productDetails['price']) ?></td></tr>
                <tr><th>Quantity</th><td><?php echo $productDetails['quantity']; ?></td></tr>
                <tr><th>Description</th><td><?php echo $productDetails['description']; ?></td></tr>
            </table>

            <form action='' method='post' class='delete-form' onsubmit='return confirmDelete()'>
                <input type='hidden' name='product_id' value='<?php echo $product_id; ?>'>
                <input type='submit' name='delete_product' value='Delete'>
            </form>

            <script>
                function confirmDelete() {
                    return confirm('Are you sure you want to delete this product?');
                }
            </script>

        <?php else : ?>
            <p>No product details found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
