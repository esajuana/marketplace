<?php
include 'Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();

// Delete single or multiple products
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    if (isset($_POST['selected_products'])) {
        $product_ids = $_POST['selected_products'];
        foreach ($product_ids as $product_id) {
            $controller->deleteProduct($product_id);
        }
    } else {
        // Handle case where no products selected
    }
}

// Retrieve products from controller
$products = $controller->getAllProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
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
    <h2>Product List</h2>
    <a href="View/create.php">Add Product</a>
    <a href="View/restore.php">Restore Data</a>

    <br><br>
    <!-- Form for multiple delete -->
    <form action="" method="post">
        <button type="submit" name="delete_product" onclick="return confirmDelete()">Delete Selected Products</button>
        <br><br>
        <table>
            <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Description</th>
                <th>Multiple Delete</th>
                <th>Action</th>
            </tr>
            <?php if (count($products) > 0) : ?>
                <?php $counter = 1 ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $counter ?></td>
                        <td><?php echo $product["product_name"] ?></td>
                        <td><?php echo 'Rp.' . number_format($product["price"]) ?></td>
                        <td><?php echo $product["quantity"] ?></td>
                        <td><?php echo 'Rp. ' . number_format($product ["price"] * $product["quantity"]) ?></td> 
                        <td><?php echo $product["description"] ?></td>
                        <td>
                            <input type="checkbox" name="selected_products[]" value="<?php echo $product['id'] ?>">
                        </td>
                        <td>
                            <a href="View/detail.php?id=<?php echo $product["id"] ?>">View</a> |
                            <a href="View/update.php?id=<?php echo $product["id"] ?>">Update</a> |
                            <a href="View/delete.php?id=<?php echo $product["id"] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php $counter++ ?>
                <?php endforeach ?>
            <?php else : ?>
                <tr><td colspan="8">No products available</td></tr>
            <?php endif ?>
        </table>
    </form>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete the selected products?");
         }
    </script>
</body>
</html>
