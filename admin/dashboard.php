<?php
// Database connection
include("../connect/config.php");

// Fetch counts
$staffCount = $conn->query("SELECT COUNT(*) AS total FROM staffs")->fetch_assoc()['total'];
$customerCount = $conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc()['total'];
$productCount = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$orderCount = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];

// below code is written by josh (29/5/2024)
$inquiryCount = $conn->query("SELECT COUNT(*) AS total FROM contact_us")->fetch_assoc()['total'];

// Fetch orders with their status
$sql = "SELECT o.id, o.user_id, o.tracking_no, o.total_price, o.date, o.address, o.postcode, o.city_id, o.state_id, o.country_id, o.status,
               c.name AS city_name, s.name AS state_name, cn.name AS country_name
        FROM orders o
        JOIN cities c ON o.city_id = c.id
        JOIN states s ON o.state_id = s.id
        JOIN countries cn ON o.country_id = cn.id
        ORDER BY o.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--page-icon------------>
    <link rel="shortcut icon" href="assets/images/pg-logo.png">
</head>

<body>
    <div class="container">
        <?php include 'nav.php'; ?>

        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $customerCount; ?></div>
                    <div class="cardName">Customers</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $staffCount; ?></div>
                    <div class="cardName">Staff</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="person-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $productCount; ?></div>
                    <div class="cardName">Products</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="file-tray-stacked-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $orderCount; ?></div>
                    <div class="cardName">Sales</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>
            <!-- card below written by Joshua (29/5/2024) -->
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $inquiryCount; ?></div>
                    <div class="cardName">Message</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- ================ Order Details List ================= -->
 <!--        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Recent Orders</h2>
                    <a href="order-list.php" class="btn">View All</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Date</td>
                            <td>Status</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                  <td>" . $row['user'] . "</td>
                                  <td>" . $row['total_price'] . "</td>
                                  <td>" . $row['date'] . "</td>
                                  <td>" . $row['status'] . "</td>
                                </tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
 -->
            <!-- ================= New Customers ================ -->
<!--             <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Recent Customers</h2>
                </div>

                <table>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>
                </table>
            </div> -->
        </div>
    </div>
    </div>
</body>

</html>
