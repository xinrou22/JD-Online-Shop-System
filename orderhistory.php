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

$customerID = $_SESSION['cusID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Page icon -->
    <link rel="shortcut icon" href="images/pg-logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling for the profile form box */
        .form-box {
            width: 80%;
            margin: 0px 10px;
            background: #fdfdfd;
            padding: 30px 30px;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
            0 32px 64px -48px rgba(0, 0, 0, 0.5);
            font-family: Verdana; 
            margin: 20px;
        }

        .container {
            min-height: 55vh;
        }

        thead.thead-dark th {
            color: #fff;                            /*TABLE HEADER <TH> TEXT COLOR*/
            background-color: #24262b;              /* #343a40*/
            border-color: black;                  /*#454d55*/
            border: 1pt;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }

        h2 {
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 20px;
            text-align: center;
            font-family: Verdana;
        }

        tbody {
            height: 40px;
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            font-family: Verdana; /* Set font family to Verdana */
        }

        td {
            height: 7vh;
            text-align: center;
        }

        /* Custom status classes that determines the status colours */
        .status-pending {
            color: white;
            background-color: #FF9900; /* Slightly muted Amber */
            padding: 10px 20px;
            border: 1px solid #B36B00; /* Darker shade of amber */
            border-radius: 5px;
            text-align: center;
            pointer-events: none; /* Disable clicking on button */
            font-weight: bold;
        }

        .status-underprocess {
            color: white;
            background-color: #0056b3; /* Slightly muted Blue */
            padding: 10px 20px;
            border: 1px solid #004080; /* Darker shade of blue */
            border-radius: 5px;
            text-align: center;
            pointer-events: none;
            font-weight: bold;
        }

        .status-shipped {
            color: white;
            background-color: #218838; /* Slightly muted Green */
            padding: 10px 20px;
            border: 1px solid #1C7430; /* Darker shade of green */
            border-radius: 5px;
            text-align: center;
            pointer-events: none;
            font-weight: bold;
        }

        .status-rejected {
            color: white;
            background-color: #800000; /* Maroon Red */
            padding: 10px 20px;
            border: 1px solid #4d0000; /* Darker shade of maroon red */
            border-radius: 5px;
            text-align: center;
            pointer-events: none;
            font-weight: bold;
        }

        /*Custom css for generate invoice button*/
        .generateInvoiceButton {
            color: white;
            background-color: #78706E; /* Dark gray to match the Checkout button */
            padding: 10px 20px; /* Larger padding for prominence */
            border: none; /* Remove border for a cleaner look */
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            cursor: pointer; /* Change cursor to pointer to indicate it's clickable */
            transition: background-color 0.3s; /* Smooth transition for hover effects */
        }

        .generateInvoiceButton:hover {
            opacity: 0.7;
        }

        /* Styling for textarea to disable resize */
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
    <!-- Insert Navbar -->
    <?php include 'nav-footer/nav.php'; ?>
    
    <!-- Container for order history -->
    <div class="container">
        <div class="form-box">
        <h2><b>Order History</b></h2><br>
        
        <!-- Order History Section -->
        <div class="order-history">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Transaction ID.</th>
                        <th>Total Price</th>
                        <!-- <th>Address</th> -->
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th> <!-- New column for remarks -->
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT orders.id AS order_id, orders.tracking_no, orders.total_price, orders.date, orders.address, orders.postcode,
                                     cities.name AS city_name, states.name AS state_name, countries.name AS country_name, orders.status, orders.remarks
                              FROM orders
                              JOIN cities ON orders.city_id = cities.id
                              JOIN states ON orders.state_id = states.id
                              JOIN countries ON orders.country_id = countries.id
                              WHERE orders.user_id = ?
                              ORDER BY orders.date DESC";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $customerID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td data-column='OrderID'>" . htmlspecialchars($row['order_id']) . "</td>";
                            echo "<td data-column='TrackingNo'>" . htmlspecialchars($row['tracking_no']) . "</td>";
                            echo "<td data-column='TotalPrice'>RM" . htmlspecialchars($row['total_price']) . "</td>";
                            $fullAddress = htmlspecialchars($row['address']) . ", " . htmlspecialchars($row['postcode']) . ", " . htmlspecialchars($row['city_name']) . ", " . htmlspecialchars($row['state_name']) . ", " . htmlspecialchars($row['country_name']);
                            // echo "<td data-column='Address'>" . $fullAddress . "</td>";
                            echo "<td data-column='Date'>" . htmlspecialchars($row['date']) . "</td>";
                            
                            // Apply status classes (order status will change colour based on the status)
                            $statusClass = 'status-pending'; // Default status class is Pending
                            if ($row['status'] == 'Under Process') {
                                $statusClass = 'status-underprocess';
                            } elseif ($row['status'] == 'Shipped') {
                                $statusClass = 'status-shipped';
                            } elseif ($row['status'] == 'Rejected') {
                                $statusClass = 'status-rejected';
                            } 
                            echo "<td data-column='Status'><button class='" . $statusClass . "'>" . htmlspecialchars($row['status']) . "</button></td>";

                            // Show remarks
                            echo "<td data-column='Remarks'><textarea readonly>" . htmlspecialchars($row['remarks']) . "</textarea></td>";

                            // Show invoice button
                            echo "<td data-column='Invoice'><a href='invoice.php?order_id=" . htmlspecialchars($row['order_id']) . "'><button class='generateInvoiceButton'>Invoice</button></a></td>";
                            
                            echo "</tr>";
                        }
                        
                    } else {
                        echo '<tr><td colspan="8"><center>You have no orders placed yet.</center></td></tr>';
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    
    <!-- Insert Footer -->
    <?php include 'nav-footer/footer.php'; ?>
    <?php include 'nav-footer/alert-js.php'; ?>
</body>
</html>
