<?php
// Database connection
include("../connect/config.php");

// Fetch orders with their products
$order_id = $_GET['order_id']; // assuming the order ID is passed via GET
$sql = "SELECT o.id, o.user, o.tracking_no, o.total_price, o.date, o.contact, o.country_id, o.state_id, o.city_id, o.postcode, o.address, o.status, 
               oi.product_id, p.name as product_name, oi.quantity, oi.total_price as item_total_price
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch order details
$order_details = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!--page-icon------------>
  <link rel="shortcut icon" href="assets/images/pg-logo.png">

  <style type="text/css">




    h1 {
      text-align: center;
      color: #333;
    }

    .order-summary, .order-items, .customer-details {
      margin-bottom: 20px;
    }

    h2 {
      border-bottom: 2px solid #ddd;
      padding-bottom: 10px;
      color: #666;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    table thead th {
      background-color: #f8f8f8;
    }

    table tfoot td {
      font-weight: bold;
    }

    @media (max-width: 600px) {
      .container {
        padding: 10px;
      }

      table th, table td {
        padding: 8px;
      }
    }

  </style>
</head>

<body>
  <!-- Cannot be deleted -->
  <div class="container">
    <?php include'nav.php' ?>
    <!-- Content -->
    <!-- <h1 style="margin-top: 10px; margin-left: 30px;">Orders</h1> -->
    
    <!-- ================ View Order Form - 2 column ================= -->
 <!--<div class="container-2">
 <div class="row">
  <div class="column" style="background-color:#aaa;">
    <h2>Delivery Details</h2>
    <br><hr><br>
        <div class="row">
          <div class="col-15">
            <label for="name">Name</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="name" name="name">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="email">Email</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="email" name="email">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="contact">Phone</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="contact" name="contact">
          </div>
        </div>
         <div class="row">
          <div class="col-15">
            <label for="tracking_no">Tracking No.</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="tracking_no" name="tracking_no">
          </div>
        </div>
         <div class="row">
          <div class="col-15">
            <label for="address">Address</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="address" name="address">
          </div>
        </div>
  </div>
 
  <div class="column" style="background-color:#bbb;">
    <h2>Order Details</h2>
    <br><hr><br>
     </div> 
  </div>
</div> -->
<div class="container-2">
 <h1>Order Details</h1>
 <div class="order-summary">
  <h2>Order #12345</h2>
 <!--  <p><strong>Date:</strong> May 17, 2024</p>
  <p><strong>Status:</strong> Shipped</p> -->
   <div class="row">
          <div class="col-15">
            <label for="date">Date</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="date" name="date">
          </div>
        </div>
  <div class="row">
                <div class="col-15">
                    <label for="status">Status</label>
                </div>
                <div class="col-80">
                    <select id="status" name="status">
                        <option value="Under Process">Under Process</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Reject">Reject</option>
                    </select>
                </div>
            </div>
</div>
<div class="order-items">
  <h2>Items</h2>
  <table>
    <thead>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Product 1</td>
        <td>2</td>
        <td>$20.00</td>
      </tr>
      <tr>
        <td>Product 2</td>
        <td>1</td>
        <td>$15.00</td>
      </tr>
      <tr>
        <td>Product 3</td>
        <td>3</td>
        <td>$30.00</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">Total</td>
        <td>$65.00</td>
      </tr>
    </tfoot>
  </table>
</div>
<div class="customer-details">
  <h2>Customer Details</h2>
 <!--  <p><strong>Name:</strong> John Doe</p>
  <p><strong>Email:</strong> john.doe@example.com</p>
  <p><strong>Address:</strong> 123 Main St, Anytown, USA</p> -->

  <div class="row">
          <div class="col-15">
            <label for="name">Name</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="name" name="name">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="email">Email</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="email" name="email">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="contact">Phone</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="contact" name="contact">
          </div>
        </div>
         <div class="row">
          <div class="col-15">
            <label for="tracking_no">Tracking No.</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="tracking_no" name="tracking_no">
          </div>
        </div>
         <div class="row">
          <div class="col-15">
            <label for="address">Address</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="address" name="address">
          </div>
        </div>
</div>
 <div class="row">
            <div class="col-10">
                <input type="submit" name="submit" value="Submit">
            </div>
        </div>
 <div class="row">
        <div class="col-20">
            <a href="order-list.php"><button class="btn-back">Back</button></a>
        </div>
    </div>
</div>

<!-- Cannot be deleted -->
<!-- <div class="main"> in nav.php-->
</div>
</div>
</body>