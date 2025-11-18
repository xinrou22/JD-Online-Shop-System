<?php
session_start();
include("connect/config.php");

if (isset($_SESSION["cusID"])) {
    $user_id = $_SESSION["cusID"];

    // Fetch POST data
    $postData = json_decode(file_get_contents('php://input'), true);

    if (isset($postData['action'])) {
        // Check if the action is to update the quantity
        if ($postData['action'] === 'update_quantity') {
            $index = $postData['index']; // Index of the item in the cart array
            $quantity = $postData['quantity']; // New quantity value

            // Update the quantity of the item in the database
            $update_query = "UPDATE cart_items SET quantity = '$quantity' WHERE user_id = '$user_id' AND id = '$index'";
            mysqli_query($conn, $update_query);

            // Fetch the updated cart items and send them back as JSON response
            $cart_query = "SELECT cart_items.*, products.name, products.description, products.price, products.img, shoe_size.size 
            FROM cart_items 
            JOIN products ON cart_items.product_id = products.id 
            JOIN shoe_size ON cart_items.size_id = shoe_size.id 
            WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $cart_query);
            $cart_items = [];
            while ($row = mysqli_fetch_assoc($cart_result)) {
                $cart_items[] = $row;
            }
            $_SESSION["cart"] = $cart_items;

            // Send the updated cart items back as JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'cart' => $cart_items]);
            exit;
        }

        // Check if the action is to remove an item
        if ($postData['action'] === 'remove_item') {
            $index = $postData['index']; // Index of the item in the cart array

            // Remove the item from the database
            $delete_query = "DELETE FROM cart_items WHERE user_id = '$user_id' AND id = '$index'";
            mysqli_query($conn, $delete_query);

            // Fetch the updated cart items and send them back as JSON response
            $cart_query = "SELECT cart_items.*, products.name, products.description, products.price, products.img, shoe_size.size 
            FROM cart_items 
            JOIN products ON cart_items.product_id = products.id 
            JOIN shoe_size ON cart_items.size_id = shoe_size.id 
            WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $cart_query);
            $cart_items = [];
            while ($row = mysqli_fetch_assoc($cart_result)) {
                $cart_items[] = $row;
            }
            $_SESSION["cart"] = $cart_items;

            // Send the updated cart items back as JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'cart' => $cart_items]);
            exit;
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!--page-icon------------>
    <link rel="shortcut icon" href="images/pg-logo.png">
    <style>
        body{
            background-color: #343337;
        }
        /*.h-custom {
            height: 100% !important;
        }*/
        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }
        .card-registration .select-arrow {
            top: 13px;
        }
        .bg-grey {
            background-color: #eae8e8;
        }
        @media (min-width: 992px) {
            .card-registration-2 .bg-grey {
                border-top-right-radius: 16px;
                border-bottom-right-radius: 16px;
            }
        }
        @media (max-width: 991px) {
            .card-registration-2 .bg-grey {
                border-bottom-left-radius: 16px;
                border-bottom-right-radius: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- <section class="h-100 h-custom" style="background-color: #343337;"> -->
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted" id="cart-items-count">0 items</h6>
                                        </div>
                                        <hr class="my-4">
                                        <div id="cart-items">
                                            <!-- Cart items will be dynamically injected here -->
                                        </div>
                                        <hr class="my-4">
                                        <div class="pt-5">
                                            <h6 class="mb-0">
                                                <a href="product.php" class="text-body">
                                                    <i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-grey">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase" id="summary-items-count">0 items</h5>
                                            <h5 id="summary-total-price">RM0.00</h5>
                                        </div>
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5 id="summary-total-price-final">RM0.00</h5>
                                        </div>
                                        <button type="button" class="btn btn-dark btn-block btn-lg" onclick="proceedToCheckout()"> Checkout </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </section> -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cartItemsContainer = document.getElementById('cart-items');
                const cartItemsCount = document.getElementById('cart-items-count');
                const summaryItemsCount = document.getElementById('summary-items-count');
                const summaryTotalPrice = document.getElementById('summary-total-price');
                const summaryTotalPriceFinal = document.getElementById('summary-total-price-final');

                function renderCart(cart) {
                    cartItemsContainer.innerHTML = '';
                    let totalItems = 0;
                    let totalPrice = 0.0;

                    cart.forEach((item) => {
                        const itemTotal = item.price * item.quantity;
            totalItems += parseInt(item.quantity); // Ensure the quantity is correctly summed up
            totalPrice += itemTotal;

            const cartItem = document.createElement('div');
            cartItem.classList.add('row', 'mb-4', 'd-flex', 'justify-content-between', 'align-items-center');
            cartItem.innerHTML = `
            <div class="col-md-2 col-lg-2 col-xl-2">
            <img src="admin/product/${item.img}" class="img-fluid rounded-3" alt="${item.name}">
            </div>
            <div class="col-md-3 col-lg-3 col-xl-3">
            <h6 class="text-muted">${item.name}</h6>
            
            <h6 class="text-black mb-0">Size: ${item.size}</h6>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
            <input class="form-control form-control-sm quantity-input-cart" type="number" min="1" value="${item.quantity}" data-index="${item.id}">
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
            <h6 class="mb-0">RM${itemTotal.toFixed(2)}</h6>
            </div>
            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
            <a href="#!" class="text-muted remove-item" data-index="${item.id}"><i class="fas fa-times"></i></a>
            </div>
            `;

            cartItemsContainer.appendChild(cartItem);
        });

                    cartItemsCount.textContent = `${totalItems} items`;
                    summaryItemsCount.textContent = `${totalItems} items`;
                    summaryTotalPrice.textContent = `RM${totalPrice.toFixed(2)}`;
                    summaryTotalPriceFinal.textContent = `RM${totalPrice.toFixed(2)}`;

                    attachEventListeners();
                }

                function attachEventListeners() {
                    document.querySelectorAll('.quantity-input-cart').forEach(input => {
                        input.addEventListener('change', function() {
                            const index = this.dataset.index;
                            const newQuantity = parseInt(this.value);

                            fetch('cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    action: 'update_quantity',
                                    index: index,
                                    quantity: newQuantity,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    renderCart(data.cart);
                                }
                            });
                        });
                    });

                    document.querySelectorAll('.remove-item').forEach(link => {
                        link.addEventListener('click', function(event) {
                            event.preventDefault();
                            const index = this.dataset.index;

                            fetch('cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    action: 'remove_item',
                                    index: index,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    renderCart(data.cart);
                                }
                            });
                        });
                    });
                }

                const cart = <?php echo json_encode($_SESSION['cart'] ?? []); ?>;

                window.proceedToCheckout = function() {
                    if (cart.length > 0) {
                        localStorage.setItem('cart', JSON.stringify(cart));
                        window.location.href = 'checkout.php';
                    } else {
                        alert('Your cart is empty. Please add items to proceed to checkout.');
                    }
                };

                renderCart(cart);
            });

        </script>


    </body>
    </html>
