<?php
include_once '../Config/init.php';
include_once PROJECT_ROOT . '/Controller/ProductController.php';

$controller = new ProductController();
$products = $controller->getRestoreData();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['restore'])) {
        if (isset($_POST['selected_products'])) {
            $ids = $_POST['selected_products'];
            if ($controller->restore($ids)) {
                header("Location: restore.php?restore_data_success=1");
                exit;
            } else {
                $message = "Failed to restore products.";
            }
        } else {
            $message = "No products selected for recovery.";
        }
    } elseif (isset($_POST['delete_permanent'])) {
        $id = $_POST['delete_permanent'];
        if ($controller->deletePermanentProduct($id)) {
            header("Location: restore.php?delete_permanent_success=1");
            exit;
        } else {
            $message = "Failed to delete product permanently.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Product</title>
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
    <h2>Restore Deleted Products</h2>
    
    <a href="../index.php">Back To Product List</a>
    <br><br>

    <form action="" method="POST" onsubmit="return confirmRestore()">
        <button type="submit" name="restore" value="restore">Restore Products</button>
        <br><br>

        <table>
            <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Select</th>
                <th>Delete Permanent</th>
            </tr>
            <?php if (count($products) > 0) : ?>
                <?php $counter = 1 ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $counter ?></td>
                        <td><?php echo $product["product_name"] ?></td>
                        <td><?php echo 'Rp. ' . number_format($product["price"])  ?></td>
                        <td><?php echo $product["quantity"] ?></td>
                        <td><?php echo $product["description"] ?></td>
                        <td>
                            <input type="checkbox" name="selected_products[]" value="<?php echo $product['id'] ?>">
                        </td>
                        <td>
                            <button type="submit" name="delete_permanent" value="<?php echo $product['id'] ?>" onclick="return confirmDeletePermanent()">Delete Permanent</button>
                        </td>
                    </tr>
                    <?php $counter++ ?>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">No deleted products found.</td>
                </tr>
            <?php endif ?>
        </table>
    </form>

    <script>
        function confirmRestore() {
            return confirm('Are you sure you want to restore selected products?');
        }

        function confirmDeletePermanent() {
            return confirm('Are you sure you want to permanently delete this product?');
        }
    </script>
</body>
</html>
