<?php
include 'Config/init.php';
include PROJECT_ROOT . '/Controller/ProductController.php';
$controller = new ProductController();

$products = $controller->getAllProducts();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_products'])) {
    $controller = new ProductController();
    $ids = $_POST['selected_products'];
    if ($controller->deleteMultipleProducts($ids)) {
        header("Location: index.php?soft_delete_success=1");
        exit;
    } else {
        echo "Failed to delete products.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['selected_products'])) {
    $message = "No products selected for deletion."; 
}
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
            th,
            td {
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
    
    <?php if (!empty($message)) : ?> 
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <br><br>
    <form action="" method="post">
    <div>
        <button type="submit" class="delete-button" onclick="return confirmMultipleDelete()">Delete Selected Products</button>
    </div>
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
                
            <?php endif ?>
        </table>
    </form>
    <script>
        function confirmMultipleDelete() {
            var checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
            if (checkboxes.length > 0) {
                return confirm("Are you sure you want to delete the selected products?");
            } else {
                alert("Please select at least one product to delete.");
                return false;
            }
        }
    </script>
</body>
</html>