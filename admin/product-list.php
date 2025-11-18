<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product List</title>
  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!--page-icon------------>
  <link rel="shortcut icon" href="assets/images/pg-logo.png">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
</head>

<body>
  <!-- Cannot be deleted -->
  <div class="container-1">
    <?php include'nav.php' ?>
    <!-- Content -->
    <h1 style="margin-top: 10px; margin-left: 30px;">All Product</h1>
    <div class="btn-list">
      <a href="add-product.php"><button class="btn-add" role="button">Add New Product</button></a>
    </div>
    <!-- ================ Product List ================= -->
    <div class="list">
      <div class="recentList">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>ID</td>
              <td>Image</td>
              <td>Name</td>
              <td>Description</td>
           <!--    <td>Category</td>
              <td>Size</td> -->
              <td>Stock</td>
              <td>Status</td>
              <td>Price</td>
              <td>Action</td>
            </tr>
          </thead>

          <tbody>
           <?php
  // Include database connection
           include('../connect/config.php');

  // Fetch product data from database
           $query = "SELECT * FROM products";
           $result = mysqli_query($conn, $query);

           if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="product/<?php echo $row['img']; ?>" alt="Product Image" width="80"></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
              <!--   <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['size']; ?></td> -->
                <td><?php echo $row['stock']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>RM<?php echo $row['price']; ?></td>
                <td>
                  <!-- Action buttons -->
                  <a href="delete-product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="link">
                    <button class="delete-btn"><ion-icon name="trash-outline"></ion-icon></button>
                  </a>
                  <a href="edit-product.php?product_upd=<?php echo $row['id']; ?>"><button class="edit-btn"><ion-icon name="create-outline"></ion-icon></ion-icon></button></a>
                </td>
              </tr>
              <?php
            }
          } else {
            echo "<tr><td colspan='10'>No products found</td></tr>";
          }

  // Close database connection
          mysqli_close($conn);
          ?>
          
        </tbody>
      </table>
    </div>

    <!-- Cannot be deleted -->
    <!-- <div class="main"> in nav.php-->
    </div>
  </div>

        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/datatables.min.js"></script>
        <script src="assets/js/pdfmake.min.js"></script>
        <script src="assets/js/vfs_fonts.js"></script>
        <script src="assets/js/custom.js"></script>
</body>