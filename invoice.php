<?php
// Include the database connection file
include("connect/config.php");

// Start the session
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['cusID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the order ID from the query parameter
$orderID = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($orderID <= 0) {
    echo "Invalid order ID.";
    exit();
}

// Fetch order details from the database
$query = "SELECT orders.id AS order_id, orders.tracking_no, orders.total_price, orders.date, orders.address, orders.postcode, 
                 cities.name AS city_name, states.name AS state_name, countries.name AS country_name, orders.status,
                 customers.firstName, customers.lastName, customers.contact, customers.email
          FROM orders
          JOIN cities ON orders.city_id = cities.id
          JOIN states ON orders.state_id = states.id
          JOIN countries ON orders.country_id = countries.id
          JOIN customers ON orders.user_id = customers.cusID
          WHERE orders.id = ? AND orders.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $orderID, $_SESSION['cusID']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}

// Fetch order items from the database
$queryItems = "SELECT order_items.id AS order_item_id, order_items.quantity, order_items.total_price, 
                      products.name AS product_name, shoe_size.size, products.price AS unit_price
               FROM order_items
               JOIN products ON order_items.product_id = products.id
               JOIN shoe_size ON order_items.size_id = shoe_size.id
               WHERE order_items.order_id = ?";
$stmtItems = $conn->prepare($queryItems);
$stmtItems->bind_param("i", $orderID);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/pg-logo.png">
    <title>Invoice</title>

    <link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <script src='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        body {
            background: #eee;
            margin-top: 20px;
        }

        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            border-bottom: 12px solid #333333;
            border-top: 12px solid #9f181c;
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
            font-family: open sans;
        }

        .receipt-main p {
            color: #333333;
            font-family: open sans;
            line-height: 1.42857;
        }

        .receipt-footer h1 {
            font-size: 20px;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .receipt-main::after {
            background: #414143 none repeat scroll 0 0;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }

        .receipt-main thead {
            background: #414143 none repeat scroll 0 0;
        }

        .receipt-main thead th {
            color: #fff;
            font-size: 15px;
        }

        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }

        .receipt-right p {
            font-size: 15px;
            margin: 0px;
        }

        .receipt-right p i {
            text-align: center;
            width: 18px;
        }

        .receipt-main td {
            padding: 9px 20px !important;
        }

        .receipt-main th {
            padding: 13px 20px !important;
        }

        .receipt-main td {
            font-size: 15px;
            font-weight: initial !important;
        }

        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }

        .receipt-main td h2 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }

        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 34px 0 0;
            text-align: right;
            text-transform: uppercase;
        }

        .receipt-header-mid {
            margin: 24px 0;
            overflow: hidden;
        }

        #container {
            background-color: #dcdcdc;
        }

        .btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
            color: #2d353c;
            background: #fff;
            border-color: #d9dfe3;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="col-md-12">
        <div class="row">
            <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="receipt-header">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="receipt-left">
                                <img class="img-responsive" alt="iamgurdeeposahan" src="images/pg-logo.png" style="width: 71px; border-radius: 43px;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                            <div class="receipt-right">
                                <div class="action-buttons">
                                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5">
                                        <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                                    </a>
                                </div>
                                <div><br></div>
                                <div>
                                    <h5>JD Online Shop</h5>
                                    <p>+603 840 81066 <i class="fa fa-phone"></i></p>
                                    <p>customercare@jdsports.my <i class="fa fa-envelope-o"></i></p>
                                    <p>Malaysia <i class="fa fa-location-arrow"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="receipt">
                    <div class="receipt-header receipt-header-mid">
                        <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                            <div class="receipt-right">
                                <h5><?= htmlspecialchars($order['firstName'] . ' ' . htmlspecialchars($order['lastName'])); ?></h5>
                                <p><b>Mobile :</b> <?= htmlspecialchars($order['contact']); ?></p>
                                <p><b>Email :</b> <?= htmlspecialchars($order['email']); ?></p>
                                <p><b>Address :</b> <?= htmlspecialchars($order['address'] . ', ' . $order['postcode'] . ', ' . $order['city_name'] . ', ' . $order['state_name'] . ', ' . $order['country_name']); ?></p>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="receipt-left">
                                <h3>INVOICE # <?= htmlspecialchars($order['order_id']); ?> <span class="badge bg-success font-size-12 ms-2">Paid</span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            $totalAmount = 0;
                            while ($item = $resultItems->fetch_assoc()) {
                                $amount = $item['quantity'] * $item['unit_price'];
                                $totalAmount += $amount;
                                echo "<tr>";
                                echo "<td class='col-md-0'>" . $index++ . ".</td>";
                                echo "<td class='col-md-6'>" . htmlspecialchars($item['product_name']) . "</td>";
                                echo "<td class='col-md-1'>" . htmlspecialchars($item['size']) . "</td>";
                                echo "<td class='col-md-1'>" . htmlspecialchars($item['quantity']) . "</td>";
                                echo "<td class='col-md-2'>RM" . htmlspecialchars(number_format($item['unit_price'], 2)) . "</td>";
                                echo "<td class='col-md-4'>RM" . htmlspecialchars(number_format($amount, 2)) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td colspan="4" class="text-right">
                                    <p>
                                        <strong>Subtotal:</strong>
                                    </p>
                                    <p>
                                        <strong>Shipping Fee:</strong>
                                    </p>
                                <td colspan="4" class="text-right">
                                    <p class="text-left">
                                        RM<?= htmlspecialchars(number_format($totalAmount, 2)); ?>
                                    </p>
                                    <p class="text-left">
                                        RM 10.00
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="4" class="text-right"><h2><strong>Total: </strong></h2></td>
                                <td class="text-left"><h2><strong>RM<?= htmlspecialchars(number_format($order['total_price'], 2)); ?></strong></h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="receipt-header receipt-header-mid receipt-footer">
                        <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                            <div class="receipt-right">
                                <p><b>Date :</b> <?= htmlspecialchars(date("d M Y", strtotime($order['date']))); ?></p>
                                <h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5>
                            </div>
                            <br><br />
                            <div class="receipt-right">
                                <div class="arrow">
                                    <h5 class="backToorder">
                                        <a href="orderhistory.php" class="text-body">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i><strong>Back to shop</strong>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                        <!--     <div class="receipt-left">
                                <h1>Receipt.</h1>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmtItems->close();
$conn->close();
?>
