<?php
// Include the database connection file
include("../connect/config.php");

// Fetch orders with their status and related location data
$sql = "SELECT o.id, o.user_id, o.tracking_no, o.total_price, o.date, o.address, o.postcode, 
        c.name AS city_name, s.name AS state_name, cn.name AS country_name, o.status, o.remarks,
        cu.firstName, cu.lastName
        FROM orders o
        JOIN cities c ON o.city_id = c.id
        JOIN states s ON o.state_id = s.id
        JOIN countries cn ON o.country_id = cn.id
        JOIN customers cu ON o.user_id = cu.cusID
        ORDER BY o.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order List</title>
  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!--page-icon------------>
  <link rel="shortcut icon" href="assets/images/pg-logo.png">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">

  <style type="text/css">
    textarea{
      resize: none;
    }
  </style>
</head>

<body>
  <!-- Container -->
  <div class="container-1">
    <?php include 'nav.php'; ?>
    <!-- Content -->
    <h1 style="margin-top: 10px; margin-left: 30px;">All Orders</h1>
    
    <!-- ================ Order List Section ================ -->
    <div class="list">
      <div class="recentList">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Order ID</td>
              <td>User</td>
              <td>Transaction ID.</td>
              <td>Total Price</td>
              <td>Address</td>
              <td>Date</td>
              <td>Status</td>
              <td>Remarks</td>
              <td>Action</td>
            </tr>
          </thead>

          <tbody>
            <?php 
            if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                $address = $row['address'] . ", " . $row['postcode'] . ", " . $row['city_name'] . ", " . $row['state_name'] . ", " . $row['country_name'];
                $fullName = $row['firstName'] . " " . $row['lastName'];
                echo "<tr>
                  <td>" . $row['id'] . "</td>
                  <td>" . $fullName . "</td>
                  <td>" . $row['tracking_no'] . "</td>
                  <td>" . $row['total_price'] . "</td>
                  <td>" . $address . "</td>
                  <td>" . $row['date'] . "</td>
                  <td>" . $row['status'] . "</td>
                  <td><textarea readonly>" . htmlspecialchars($row['remarks']) . "</textarea></td>
                  <td>
                    <a href='order-view.php?order_id=" . $row['id'] . "'>
                      <button class='view-btn'><ion-icon name='eye-outline'></ion-icon></button>
                    </a>
                  </td>
                </tr>";
              }
            } else {
              echo "<tr><td colspan='9'><div class='error'>No Order</div></td></tr>";
            }
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/datatables.min.js"></script>
  <script src="assets/js/pdfmake.min.js"></script>
  <script src="assets/js/vfs_fonts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
