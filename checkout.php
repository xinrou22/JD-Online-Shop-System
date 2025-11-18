<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>Check Out</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
/*Checkout Page*/
.checkout_body{
    margin: 50px;
}
.checkoutrow {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -16px;
}

.checkoutcontainer {
    background-color: #f2f2f2;
    padding: 10px 20px 15px 20px;
    border: 1px solid lightgrey;
    border-radius: 3px;
    margin-top: 20px;
    margin-bottom: 20px;
    flex: 50%;
    font-family: Verdana;
    margin-left: 30px;
}

.productContainer {
    flex: 30%;
    padding: 10px 20px 15px 20px;
    border: 1px solid lightgrey;
    border-radius: 3px;
    margin-top: 20px;
    margin-left: 3%;
    font-family: Verdana;
    margin-bottom: 20px;
    margin-right: 30px;
}

.halfColumn {
    padding: 0 16px;
    flex: 50%;
}

.checkoutcontainer select, input[type=text] {
    width: 95%;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.checkoutcontainer label {
    margin-bottom: 10px;
    display: block;
}

/*.icon-container {
    margin-bottom: 20px;
    padding: 7px 0;
    font-size: 24px;
}*/

.Checkout_btn {
    background-color: black;
    color: white;
    font-size: 17px;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 3px;
    width: 100%;
    cursor: pointer;
}

.Checkout_btn:hover {
    opacity: 0.7;
    background-color: grey !important;
    color: white !important;
}

.productContainer th {
    padding: 30px 0;
}

.productContainer td {
    padding-right: 20px;
    padding-left: 10px;
}

.lastCol {
    text-align: right;
}

.productContainer a {
    text-decoration: none;
    color: black;
}

.productContainer p {
    font-size: 14px;
}

.error {
    color: rgb(235, 61, 61);
    font-size: 0.9rem;
    margin-bottom: 15px;
}


.productContainer .price {
    padding-right: 20px; /* Additional padding to move it right */
    float: right;
}
</style>
</head>


<?php
session_start();
include("connect/config.php");

if (empty($_SESSION["cusID"])) {
    header("Location: login.php");
    exit();
}

$cusID = $_SESSION["cusID"];
$query = $conn->prepare("SELECT * FROM customers WHERE cusID = ?");
$query->bind_param("i", $cusID);
$query->execute();
$r = $query->get_result()->fetch_assoc();

$sql = "SELECT c.firstName, c.lastName, c.contact, c.address, ci.name AS city, s.name AS state, c.postcode 
FROM customers c
JOIN cities ci ON c.city_id = ci.id
JOIN states s ON c.state_id = s.id
WHERE c.cusID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cusID);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($customer) {
    $fullName = $customer['firstName'] . " " . $customer['lastName'];
    $contact = $customer['contact'];
    $address = $customer['address'];
    $city = $customer['city'];
    $state = $customer['state'];
    $postcode = $customer['postcode'];
} else {
    echo "Customer not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (empty($_SESSION['cart'])) {
            throw new Exception('Cart is empty.');
        }

        $conn->begin_transaction();

        function generateTrackingNumber() {
            $timestamp = time();
            $random = mt_rand(1000, 9999);
            return $timestamp . $random;
            //return 'TRACK' . $timestamp . $random;
        }


        //The tracking number is the transaction ID. Because the name of many places needs to be changed, I just indicate it here.
        $tracking_number = generateTrackingNumber();
        $placed_datetime = date("Y-m-d H:i:s");

        $user = $_SESSION["cusID"];
        $contact = $_POST['contact'];
        $country_id = $_POST['country_id'];
        $state_id = $_POST['state_id'];
        $city_id = $_POST['city_id'];
        $postcode = $_POST['postalcode'];
        $address = $_POST['address'];
        $status = 'Pending';

        // Debugging output
        // echo "Submitted Values: <br>";
        // echo "City ID: " . htmlspecialchars($city_id) . "<br>";
        // echo "State ID: " . htmlspecialchars($state_id) . "<br>";
        // echo "Country ID: " . htmlspecialchars($country_id) . "<br>";

        $total_price = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $shipping_fee = 10;
        $total_price += $shipping_fee;

        $order_stmt = $conn->prepare("INSERT INTO orders (user_id, tracking_no, total_price, date, contact, country_id, state_id, city_id, postcode, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($order_stmt === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $order_stmt->bind_param("ssdsiiiiiss", $user, $tracking_number, $total_price, $placed_datetime, $contact, $country_id, $state_id, $city_id, $postcode, $address, $status);
        $order_stmt->execute();

        $order_id = $conn->insert_id;
        if (!$order_id) {
            throw new Exception('Order ID not retrieved. Last error: ' . $conn->error);
        }

        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, size_id, total_price) VALUES (?, ?, ?, ?, ?)");
        if ($item_stmt === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $size_id = $item['size_id'];
            $item_total_price = $item['price'] * $quantity;
            $item_stmt->bind_param("iiiii", $order_id, $product_id, $quantity, $size_id, $item_total_price);

            if (!$item_stmt->execute()) {
                throw new Exception('Execute failed: ' . htmlspecialchars($item_stmt->error));
            }
        }

        $delete_cart_stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
        if ($delete_cart_stmt === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $delete_cart_stmt->bind_param("i", $user);
        $delete_cart_stmt->execute();

        $conn->commit();
        unset($_SESSION['cart']);
        $message = "Successfully placed order!";
        $messageType = "success";
        echo "<script>setTimeout(function(){ window.location.href = 'orderhistory.php'; }, 2000);</script>";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Order placement failed: " . $e->getMessage();
        $messageType = "error";
        echo "<script>setTimeout(function(){ window.location.href = 'product.php'; }, 2000);</script>";
    }

    //Don't delete here
    // try {
    //     // Debugging output for session cart
    //     // echo "<pre>Session Cart:\n";
    //     // print_r($_SESSION['cart']);
    //     // echo "</pre>";

    //     if (empty($_SESSION['cart'])) {
    //         throw new Exception('Cart is empty.');
    //     }

    //     $conn->begin_transaction();

    //     function generateTrackingNumber() {
    //         $timestamp = time();
    //         $random = mt_rand(1000, 9999);
    //         $tracking_number = 'TRACK' . $timestamp . $random;
    //         return $tracking_number;
    //     }

    //     // Generate tracking number
    //     $tracking_number = generateTrackingNumber();
        
    //     // Get current date and time
    //     $placed_datetime = date("Y-m-d H:i:s");

    //     $user = $_SESSION["cusID"];
    //     $contact = $_POST['contact'];
    //     $country_id = $_POST['country_id'];
    //     $state_id = $_POST['state_id'];
    //     $city_id = $_POST['city_id'];
    //     $postcode = $_POST['postalcode'];
    //     $address = $_POST['address'];
    //     $status = 'Pending';

    //     $total_price = 0;
    //     foreach ($_SESSION['cart'] as $item) {
    //         $total_price += $item['price'] * $item['quantity'];
    //     }

    //     $shipping_fee = 10;
    //     $total_price += $shipping_fee;

    //     $order_stmt = $conn->prepare("INSERT INTO orders (user_id, tracking_no, total_price, date, contact, country_id, state_id, city_id, postcode, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //     if ($order_stmt === false) {
    //         throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
    //     }
    //     $order_stmt->bind_param("ssdsiiiiiss", $user, $tracking_number, $total_price, $placed_datetime, $contact, $country_id, $state_id, $city_id, $postcode, $address, $status);
    //     $order_stmt->execute();

    //     // Get the last inserted order ID
    //     $order_id = $conn->insert_id;

    //     // Debugging output for order ID
    //     if (!$order_id) {
    //         throw new Exception('Order ID not retrieved. Last error: ' . $conn->error);
    //     }

    //     // Insert order items
    //     $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, size_id, total_price) VALUES (?, ?, ?, ?, ?)");
    //     if ($item_stmt === false) {
    //         throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
    //     }
    //     foreach ($_SESSION['cart'] as $item) {
    //         $product_id = $item['product_id'];
    //         $quantity = $item['quantity'];
    //         $size_id = $item['size_id'];
    //         $item_total_price = $item['price'] * $quantity;

    //         // Debugging output
    //         //echo "Inserting order item - Order ID: $order_id, Product ID: $product_id, Quantity: $quantity, Size ID: $size_id, Total Price: $item_total_price<br>";

    //         $item_stmt->bind_param("iiiii", $order_id, $product_id, $quantity, $size_id, $item_total_price);

    //         if (!$item_stmt->execute()) {
    //             throw new Exception('Execute failed: ' . htmlspecialchars($item_stmt->error));
    //         }
    //     }

    //     // Delete cart items for the user after successful order placement
    //     $delete_cart_stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    //     if ($delete_cart_stmt === false) {
    //         throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
    //     }
    //     $delete_cart_stmt->bind_param("i", $user);
    //     $delete_cart_stmt->execute();

    //     $conn->commit();
    //     unset($_SESSION['cart']);
    //     $message = "Successfully placed order!";
    //     $messageType = "success";
    //     //echo "<script>setTimeout(function(){ window.location.href = 'orderhistory.php'; }, 2000);</script>";
    // } catch (Exception $e) {
    //     $conn->rollback();
    //     $message = "Order placement failed: " . $e->getMessage();
    //     $messageType = "error";
    //    // echo "<script>setTimeout(function(){ window.location.href = 'product.php'; }, 2000);</script>";
    // }
}


include 'nav-footer/nav.php';
$stmt->close();
$conn->close();
?>



<body style="background-color:white">

    <div class="checkout_body">
        <form action="" method="POST" id="checkoutForm" onsubmit="return validateForm()">
            <div class="row">
                <div class="checkoutcontainer">
                    <div class="checkoutrow">
                        <div class="halfColumn">
                            <h3>Shipping Address</h3>
                            <label for="fname"><i class="bi bi-person-circle"></i> Full Name</label>
                            <input readonly type="text" id="user" value="<?= htmlspecialchars($fullName); ?>" style="background-color: #F1F8F8;">
                            
                            <label for="fname"><i class="bi bi-person-circle"></i> Contact</label>
                            <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($contact); ?>">
                            <div class="error" id="errContact"></div>

                            <label for="adr"><i class="bi bi-pin-map-fill"></i> Address</label>
                            <input type="text" id="address" name="address" value="<?= htmlspecialchars($address); ?>">
                            <div class="error" id="errAddress"></div>
                            

                            <label for="country">Country</label>
                            <select id="country" name="country_id">
                              <option value="0">Select Country</option> 
                              <!-- new -->
                              <?php
                              include('connect/config.php');
                              $fetch_country = mysqli_query($conn,"SELECT * FROM countries");
                              while($country = mysqli_fetch_array($fetch_country)){
                                ?>    
                                <option <?php if($r['country_id'] == $country['id']){echo "selected";} ?> value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option><?php } ?>
                            </select>
                            <label for="state">State</label>
                            <select id="state" name="state_id">
                                <option value="0">Select State</option>
                            </select>
                            
                            <div class="row">
                                <div class="halfColumn">
                                   <label for="city"><i class="bi bi-building"></i> City</label>
                                   <select id="city" name="city_id">
                                    <option value="0">Select City</option>
                                </select>
                                
                            </div>

                            <div class="halfColumn">
                                <label for="postalcode">Postal Code</label>
                                <input type="text" id="postalcode" name="postalcode" value="<?= htmlspecialchars($postcode); ?>">
                                <div class="error" id="errPostal"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Cart Show -->
                    <div class="halfColumn">
                        <h3>Payment</h3>

                        <label for="cname">Name on Card</label>
                        <input type="text" id="cname" name="cardname" placeholder="E.g: John Doe">
                        <div class="error" id="errCardName"></div>

                        <label for="ccnum">Credit card number</label>
                        <input type="text" id="ccnum" name="cardnumber" placeholder="E.g: 1111-2222-3333-4444">
                        <div class="error" id="errCardNum"></div>

                        <div class="row">
                            <div class="halfColumn">
                                <label for="expdate">Exp Year</label>
                                <input type="text" id="expdate" name="expdate" placeholder="E.g: MM/YY">
                                <div class="error" id="errExpdate"></div>
                            </div>
                            <div class="halfColumn">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="E.g: 123">
                                <div class="error" id="errCvv"></div>
                            </div>
                            <p>
                                <i class="bi bi-shield-fill-check" style="color:green"></i> Your card details are protected.<br>
                                We partner with CyberSource, a VISA company to ensure that your card details are kept safe and secure. We will not have access to your card info.
                            </p>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Place Order" class="Checkout_btn">
            </div>

            <div class="productContainer">
                <table style="width:100%" id="shoePurchase">
                    <tr>
                        <th>
                            <h4>Cart</h4>
                        </th>
                        <th colspan="2" class="lastCol">
                            <h4><i class="bi bi-cart"></i> <b id="itemNum">0</b></h4>
                        </th>
                    </tr>
                    <!-- Cart items will be dynamically added here -->
                </table>
                <hr>
                <p>Total <span style="float: right; color: #1B99D4; padding-right: 20px;"><b id="totalPrice" name="totalPrice">RM 0.00</b></span></p>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($message)): ?>
    <div class="modal-container">
        <input id="modal-toggle" type="checkbox" checked>
        <label class="modal-backdrop" for="modal-toggle"></label>
        <div class="modal-content">
            <label class="modal-close" for="modal-toggle">&#x2715;</label>
            <h2><?= $messageType == "success" ? "Success" : "Error" ?></h2>
            <hr />
            <p><?= htmlspecialchars($message); ?></p>  
        </div>          
    </div>
<?php endif; ?>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const shoePurchaseTable = document.getElementById('shoePurchase');
        const itemNum = document.getElementById('itemNum');
        const totalPrice = document.getElementById('totalPrice');

        let totalItems = 0;
        let totalCost = 0.00;

        cart.forEach(item => {
            totalItems += parseInt(item.quantity);
            totalCost += item.price * item.quantity;

            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${item.name} (Size: ${item.size}, x${item.quantity})</td>
            <td class="price">RM${(item.price * item.quantity).toFixed(2)}</td>
            `;
            shoePurchaseTable.appendChild(row);
        });

        // Add shipping fee
        const shippingFeeRow = document.createElement('tr');
        shippingFeeRow.innerHTML = `
        <td>Shipping Fee</td>
        <td class="price">RM10.00</td>
        `;
        shoePurchaseTable.appendChild(shippingFeeRow);

        // Update total cost with shipping fee
        totalCost += 10;

        itemNum.textContent = totalItems;
        totalPrice.textContent = `RM${totalCost.toFixed(2)}`;
    });

    //load country, state, city
    $(document).ready(function() {
        function fetchStates(countryId) {
            return $.ajax({
                url: 'ajax.php',
                method: 'post',
                data: { country_id: countryId },
                success: function(result) {
                console.log('States:', result); // Debugging output
                $("#state").html('<option value="0">Select State</option>').append(result);
                $("#city").html('<option value="0">Select City</option>');
            }
        });
        }

        function fetchCities(stateId) {
            return $.ajax({
                url: 'ajax.php',
                method: 'post',
                data: { state_id: stateId, type: 'state' },
                success: function(result) {
                console.log('Cities:', result); // Debugging output
                $("#city").html('<option value="0">Select City</option>').append(result);
            }
        });
        }

        function initializeDropdowns() {
            var countryId = $("#country").val();
            var stateId = <?php echo $r['state_id'] ?>;
            var cityId = <?php echo $r['city_id'] ?>;

            if (countryId != '0') {
                fetchStates(countryId).then(function() {
                    if (stateId != '0') {
                        $("#state").val(stateId);
                        fetchCities(stateId).then(function() {
                            if (cityId != '0') {
                                $("#city").val(cityId);
                            }
                        });
                    }
                });
            }
        }

        $("#country").change(function() {
            var countryId = $(this).val();
            if (countryId == '0') {
                $("#state").html('<option value="0">Select State</option>');
                $("#city").html('<option value="0">Select City</option>');
            } else {
                fetchStates(countryId);
            }
        });

        $("#state").change(function() {
            var stateId = $(this).val();
            if (stateId == '0') {
                $("#city").html('<option value="0">Select City</option>');
            } else {
                fetchCities(stateId);
            }
        });

        initializeDropdowns();
    });

    //end load


    function validateForm() {
            const errors = [];

        // Validate Full Name
        const fullName = document.getElementById('user').value;
        if (fullName.trim() === '') {
            errors.push({ field: 'errFullName', message: 'Full Name is required.' });
        }

        // Validate Contact Number
        const contact = document.getElementById('contact').value;
        const contactPattern = /^(01)[0-46-9]*[0-9]{7,8}$/;
        if (!contactPattern.test(contact)) {
            errors.push({ field: 'errContact', message: 'Valid Malaysia phone number is required.' });
        }

        // Validate Address
        const address = document.getElementById('address').value;
        if (address.trim() === '') {
            errors.push({ field: 'errAddress', message: 'Address is required.' });
        }

        // Validate Postal Code
        const postalCode = document.getElementById('postalcode').value;
        if (postalCode.trim() === '') {
            errors.push({ field: 'errPostal', message: 'Postal Code is required.' });
        }

        // Validate Card Name
        const cardName = document.getElementById('cname').value;
        if (cardName.trim() === '') {
            errors.push({ field: 'errCardName', message: 'Name on Card is required.' });
        }

        // Validate Card Number
        const cardNumber = document.getElementById('ccnum').value;
        if (cardNumber.trim() === '' || !validateCardNumber(cardNumber)) {
            errors.push({ field: 'errCardNum', message: 'Valid Credit Card number is required.' });
        }

        // Validate Exp Date
        const expDate = document.getElementById('expdate').value;
        if (expDate.trim() === '' || !validateExpDate(expDate)) {
            errors.push({ field: 'errExpdate', message: 'Valid Expiration Date is required.' });
        }

        // Validate CVV
        const cvv = document.getElementById('cvv').value;
        if (cvv.trim() === '' || !validateCVV(cvv)) {
            errors.push({ field: 'errCvv', message: 'Valid CVV is required.' });
        }

        displayErrors(errors);
        return errors.length === 0;
    }

    function displayErrors(errors) {
        const errorFields = document.querySelectorAll('.error');
        errorFields.forEach(field => field.textContent = '');

        errors.forEach(error => {
            const errorField = document.getElementById(error.field);
            if (errorField) {
                errorField.textContent = error.message;
            }
        });
    }

    function validateCardNumber(number) {
        const re = /^[0-9]{16}$/;
        return re.test(number.replace(/-/g, ''));
    }

    function validateExpDate(date) {
        const re = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
        return re.test(date);
    }

    function validateCVV(cvv) {
        const re = /^[0-9]{3,4}$/;
        return re.test(cvv);
    }

</script>             
<!-- Insert Footer -->
<?php include 'nav-footer/footer.php' ?>
<?php include 'nav-footer/alert-js.php' ?>

</body>
</html>

