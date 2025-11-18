<?php 
include("../connect/config.php"); 

if(isset($_POST['submit'])) {
    // if(empty($_POST['name']) || $_POST['category'] == '' || $_POST['size'] == '' || $_POST['stock'] == '' || $_POST['price'] == '' || $_POST['status'] == '' || $_POST['description'] == '') {
    //     $error = '<div class="alert"><strong>Error:</strong> All fields must be filled !</div>';
    if(empty($_POST['name']) || $_POST['stock'] == '' || $_POST['price'] == '' || $_POST['status'] == '' || $_POST['description'] == '') {
        $error = '<div class="alert"><strong>Error:</strong> All fields must be filled !</div>';
    } else {
        $productId = $_GET['product_upd'] ?? null;

        if (!$productId) {
            $error = '<div class="alert"><strong>Error:</strong> Invalid product ID.</div>';
        } else {
            $img = $_POST['current_img']; // Assuming current_img is a hidden field containing the existing image filename

            if ($_FILES['img']['name']) {
                $fname = $_FILES['img']['name'];
                $temp = $_FILES['img']['tmp_name'];
                $fsize = $_FILES['img']['size'];
                $extension = pathinfo($fname, PATHINFO_EXTENSION);
                $fnew = "product{$productId}." . $extension;

                $store = "product/" . $fnew; // Path to store the uploaded file

                if (move_uploaded_file($temp, $store)) {
                    // File uploaded successfully, update product with new image
                    $img = $fnew;
                } else {
                    $error = '<div class="alert"><strong>Error:</strong> Failed to upload file.</div>';
                }
            }

            // Update product details in database
            $name = $_POST['name'];
            // $category = $_POST['category'];
            // $size = $_POST['size'];
            $stock = $_POST['stock'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $description = $_POST['description'];

            // $sql = "UPDATE products SET name = '$name', category = '$category', size = '$size', stock = '$stock', 
            //         price = '$price', status = '$status', description = '$description', img = '$img' WHERE id = $productId";
             $sql = "UPDATE products SET name = '$name', stock = '$stock', price = '$price', status = '$status', description = '$description', img = '$img' WHERE id = $productId";

            if (mysqli_query($conn, $sql)) {
                $success = '<div class="success"><strong>Product updated successfully</strong></div>';
                header("refresh:1;url=product-list.php");
            } else {
                $error = '<div class="alert"><strong>Error:</strong> Failed to update product in database.</div>';
            }
        }
    }
}

// Fetch existing product data based on product ID
if (isset($_GET['product_upd'])) {
    $productId = $_GET['product_upd'];
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    header("Location: product-list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/pg-logo.png">
</head>
<body>
    <div class="container">
        <?php include 'nav.php'; ?>
        <?php echo $error; ?>
        <?php echo $success; ?>
        <h1 style="margin-top: 10px; margin-left: 30px;">Edit Product</h1>
        <div class="container-2">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-15">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="name" name="name" placeholder="Product name.." value="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-15">
                        <label for="category">Category</label>
                    </div>
                    <div class="col-80">
                        <select id="category" name="category">
                            <option value="Men" <?php echo ($product['category'] == 'Men') ? 'selected' : ''; ?>>Men</option>
                            <option value="Women" <?php echo ($product['category'] == 'Women') ? 'selected' : ''; ?>>Women</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="size">Size</label>
                    </div>
                    <div class="col-80">
                        <select id="size" name="size">
                            <option value="S" <?php echo ($product['size'] == 'S') ? 'selected' : ''; ?>>S</option>
                            <option value="M" <?php echo ($product['size'] == 'M') ? 'selected' : ''; ?>>M</option>
                        </select>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-15">
                        <label for="stock">Stock</label>
                    </div>
                    <div class="col-80">
                        <input type="number" id="stock" name="stock" placeholder="Please enter the quantity.." value="<?php echo htmlspecialchars($product['stock']); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="price">Price (RM)</label>
                    </div>
                    <div class="col-80">
                        <input type="number" id="price" name="price" placeholder="Product price.." value="<?php echo htmlspecialchars($product['price']); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="status">Status</label>
                    </div>
                    <div class="col-80">
                        <select id="status" name="status">
                            <option value="In stock" <?php echo ($product['status'] == 'In stock') ? 'selected' : ''; ?>>In stock</option>
                            <option value="Out of stock" <?php echo ($product['status'] == 'Out of stock') ? 'selected' : ''; ?>>Out of stock</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="description">Description</label>
                    </div>
                    <div class="col-80">
                        <textarea id="description" name="description" placeholder="Write something.." style="height:200px"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="img">Image</label>
                    </div>
                    <div class="col-80">
                        <input type="file" id="img" name="img">
                        <input type="hidden" name="current_img" value="<?php echo htmlspecialchars($product['img']); ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-10">
                        <input type="submit" name="submit" value="Update">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-20">
                    <a href="product-list.php"><button class="btn-back">Back</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
