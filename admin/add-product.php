<?php 
include("../connect/config.php"); 
if(isset($_POST['submit'] )) {
    // if(empty($_POST['name'])||$_POST['category']==''||$_POST['size']==''||$_POST['stock']==''||$_POST['price']==''||$_POST['status']==''||$_POST['description']=='') {
    //     $error = '<div class="alert"><strong>Error:</strong> All fields must be filled !</div>';
    if(empty($_POST['name'])||$_POST['stock']==''||$_POST['price']==''||$_POST['status']==''||$_POST['description']=='') {
        $error = '<div class="alert"><strong>Error:</strong> All fields must be filled !</div>';
    } else {
        if ($_FILES['img']['name']) {
            // Get current date and time
            $created_at = date('Y-m-d H:i:s');
            $fname = $_FILES['img']['name'];
            $temp = $_FILES['img']['tmp_name'];
            $fsize = $_FILES['img']['size'];
            $extension = pathinfo($fname, PATHINFO_EXTENSION);

            // First, insert the product information without the image
            // $sql = "INSERT INTO products (name, category, size, stock, price, status, description) 
            //         VALUES ('" . $_POST['name'] . "', '" . $_POST['category'] . "', '" . $_POST['size'] . "', 
            //                 '" . $_POST['stock'] . "', '" . $_POST['price'] . "', '" . $_POST['status'] . "', 
            //                 '" . $_POST['description'] . "')";
             $sql = "INSERT INTO products (name, stock, price, status, description) 
                    VALUES ('" . $_POST['name'] . "', '" . $_POST['stock'] . "', '" . $_POST['price'] . "', '" . $_POST['status'] . "', '" . $_POST['description'] . "')";

            if (mysqli_query($conn, $sql)) {
                // Get the last inserted product ID
                $product_id = mysqli_insert_id($conn);
                $fnew = "product" . $product_id . '.' . $extension;
                $store = "product/" . $fnew;

                // Move uploaded file to the specified location
                if (move_uploaded_file($temp, $store)) {
                    // Update the product record with the new image file name
                    $sql = "UPDATE products SET img = '" . $fnew . "' WHERE id = " . $product_id;

                    if (mysqli_query($conn, $sql)) {
                        $success = '<div class="success"><strong>Product added successfully</strong></div>';
                        header("refresh:1;url=product-list.php");
                    } else {
                        $error = '<div class="alert"><strong>Error:</strong> Failed to update product image in database.</div>';
                    }
                } else {
                    $error = '<div class="alert"><strong>Error:</strong> Failed to upload file.</div>';
                }
            } else {
                $error = '<div class="alert"><strong>Error:</strong> Failed to insert product into database.</div>';
            }
        } else {
            $error = '<div class="alert"><strong>Error:</strong> Please select an image file.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--page-icon------------>
    <link rel="shortcut icon" href="assets/images/pg-logo.png">
</head>
<body>
    <!-- Cannot be deleted -->
    <div class="container">
        <?php include'nav.php' ?>
        <!-- Content -->
        <!-- Alert Message -->
        <?php  echo $error; ?>
        <?php echo $success; ?>

        <h1 style="margin-top: 10px; margin-left: 30px;">Add New Product</h1>
        <!-- ================ Add Product Form ================= -->
        <div class="container-2">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-15">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="name" name="name" placeholder="Product name..">
                    </div>
                </div>
       <!--          <div class="row">
                    <div class="col-15">
                        <label for="category">Category</label>
                    </div>
                    <div class="col-80">
                        <select id="category" name="category">
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>
                </div> -->
             <!--    <div class="row">
                    <div class="col-15">
                        <label for="size">Size</label>
                    </div>
                    <div class="col-80">
                        <select id="size" name="size">
                            <option value="S">S</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-15">
                        <label for="stock">Stock</label>
                    </div>
                    <div class="col-80">
                        <input type="number" id="stock" name="stock" placeholder="Please enter the quantity..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="price">Price (RM)</label>
                    </div>
                    <div class="col-80">
                        <input type="number" id="price" name="price" placeholder="Product price..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="status">Status</label>
                    </div>
                    <div class="col-80">
                        <select id="status" name="status">
                            <option value="In stock">In stock</option>
                            <option value="Out of stock">Out of stock</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="description">Description</label>
                    </div>
                    <div class="col-80">
                        <textarea id="description" name="description" placeholder="Write something.." style="height:200px"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="img">Image</label>
                    </div>
                    <div class="col-80">
                        <input type="file" id="img" name="img">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-10">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-20">
                    <a href="product-list.php"><button class="btn-back">Back</button></a>
                </div>
            </div>
        </div>
        <!-- Cannot be deleted -->
        <!-- <div class="main"> in nav.php-->
    </div>
</div>
</body>
</html>
