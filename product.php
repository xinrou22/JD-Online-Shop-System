<?php
session_start();
include("connect/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/pg-logo.png">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        /* Modal styles */
        .modal-container {
            padding-top: 0px;
            position: relative;
            width: 160px;
        }
        .modal-container .modal-btn {
            display: block;
            margin: 0 auto;
            color: #fff;
            width: 160px;
            height: 50px;
            line-height: 50px;
            background: #446CB3;
            font-size: 22px;
            border: 0;
            border-radius: 3px;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 5px 5px -5px #333;
            transition: background 0.3s ease-in;
        }
        .modal-container .modal-btn:hover {
            background: #365690;
        }
        .modal-container .modal-content,
        .modal-container .modal-backdrop {
            height: 0;
            width: 0;
            opacity: 0;
            visibility: hidden;
            overflow: hidden;
            cursor: pointer;
            transition: opacity 0.2s ease-in;
        }
        .modal-container .modal-close {
            color: #aaa;
            position: absolute;
            right: 5px;
            top: 5px;
            padding-top: 3px;
            background: #fff;
            font-size: 16px;
            width: 25px;
            height: 25px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }
        .modal-container .modal-close:hover {
            color: #333;
        }
        .modal-container .modal-content-btn {
            position: absolute;
            text-align: center;
            cursor: pointer;
            bottom: 20px;
            right: 30px;
            background: black;
            color: #fff;
            width: 50px;
            border-radius: 5px;
            font-size: 14px;
            height: 32px;
            padding-top: 6px;
            font-weight: normal;
        }
        .modal-container .modal-content-btn:hover {
            color: #fff;
            opacity: 0.7;
        }
        .modal-container #modal-toggle,
        .modal-container #success-modal-toggle,
        .modal-container #error-modal-toggle {
            display: none;
        }
        .modal-container #modal-toggle.active ~ .modal-backdrop,
        .modal-container #modal-toggle:checked ~ .modal-backdrop,
        .modal-container #success-modal-toggle.active ~ .modal-backdrop,
        .modal-container #success-modal-toggle:checked ~ .modal-backdrop,
        .modal-container #error-modal-toggle.active ~ .modal-backdrop,
        .modal-container #error-modal-toggle:checked ~ .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.6);
            width: 100vw;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 9;
            visibility: visible;
            opacity: 1;
            transition: opacity 0.2s ease-in;
        }
        .modal-container #modal-toggle.active ~ .modal-content,
        .modal-container #modal-toggle:checked ~ .modal-content,
        .modal-container #success-modal-toggle.active ~ .modal-content,
        .modal-container #success-modal-toggle:checked ~ .modal-content,
        .modal-container #error-modal-toggle.active ~ .modal-content,
        .modal-container #error-modal-toggle:checked ~ .modal-content {
            opacity: 1;
            background-color: #fff;
            max-width: 400px;
            width: 400px;
            height: 280px;
            padding: 10px 30px;
            position: fixed;
            left: calc(50% - 200px);
            top: 12%;
            border-radius: 4px;
            z-index: 999;
            pointer-events: auto;
            cursor: auto;
            visibility: visible;
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.6);
        }
        @media (max-width: 400px) {
            .modal-container #modal-toggle.active ~ .modal-content,
            .modal-container #modal-toggle:checked ~ .modal-content,
            .modal-container #success-modal-toggle.active ~ .modal-content,
            .modal-container #success-modal-toggle:checked ~ .modal-content,
            .modal-container #error-modal-toggle.active ~ .modal-content,
            .modal-container #error-modal-toggle:checked ~ .modal-content {
                left: 0;
            }
        }
    </style>
</head>
<body>
 
    <?php
    include 'nav-footer/nav.php';

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    ?>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <?php if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 product-card">
                            <div class="card h-100">
                                <img src="admin/product/<?php echo $row['img']; ?>" alt="Product Image" style="width: 100%; height: 300px;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text"><?php echo $row['description']; ?></p>
                                    <p class="card-text">RM<?php echo $row['price']; ?></p>
                                    <div class="mb-3">
                                        <label for="size-select-<?php echo $row['id']; ?>" class="form-label">Size</label>
                                        <select class="form-select size-select" id="size-select-<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>">
                                            <?php
                                            $fetch_size = mysqli_query($conn, "SELECT * FROM shoe_size");
                                            while ($size = mysqli_fetch_array($fetch_size)) {
                                                ?>
                                                <option value="<?php echo $size['id']; ?>"><?php echo $size['size']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity-input-<?php echo $row['id']; ?>" class="form-label">Quantity</label>
                                        <input type="number" class="form-control quantity-input" id="quantity-input-<?php echo $row['id']; ?>" min="1" value="1" data-id="<?php echo $row['id']; ?>">
                                    </div>
                                    <button class="btn btn-outline-dark add-to-cart" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-description="<?php echo $row['description']; ?>" data-price="<?php echo $row['price']; ?>" data-img="<?php echo $row['img']; ?>">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </section>

    <?php include 'nav-footer/footer.php'; ?>

    <!-- Custom Modal -->
    <div class="modal-container">
        <input id="modal-toggle" type="checkbox">
        <label class="modal-backdrop" for="modal-toggle"></label>
        <div class="modal-content">
            <label class="modal-close" for="modal-toggle">&#x2715;</label>
            <h2>Login Required</h2><hr />
            <p>You must be logged in to add items to the cart. Please log in to continue.</p>
            <label class="modal-content-btn" for="modal-toggle" onclick="window.location.href='login.php'">OK</label>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-container" id="success-modal-container">
        <input id="success-modal-toggle" type="checkbox">
        <label class="modal-backdrop" for="success-modal-toggle"></label>
        <div class="modal-content">
            <label class="modal-close" for="success-modal-toggle">&#x2715;</label>
            <h2>Success</h2><hr />
            <p>Product added to cart!</p>
            <label class="modal-content-btn" for="success-modal-toggle">OK</label>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal-container" id="error-modal-container">
        <input id="error-modal-toggle" type="checkbox">
        <label class="modal-backdrop" for="error-modal-toggle"></label>
        <div class="modal-content">
            <label class="modal-close" for="error-modal-toggle">&#x2715;</label>
            <h2>Error</h2><hr />
            <p>Failed to add product to cart.</p>
            <label class="modal-content-btn" for="error-modal-toggle">OK</label>
        </div>
    </div>

    <script>
        const isLoggedIn = <?php echo json_encode(isset($_SESSION['cusID'])); ?>;

        function checkLoginStatus(event) {
            if (!isLoggedIn) {
                event.preventDefault();
                // Trigger the custom modal
                document.getElementById('modal-toggle').checked = true;
            } else {
                window.location.href = 'cart.php';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    if (!isLoggedIn) {
                        document.getElementById('modal-toggle').checked = true;
                        return;
                    }

                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const description = this.dataset.description;
                    const price = parseFloat(this.dataset.price);
                    const img = this.dataset.img;
                    const sizeSelect = document.querySelector(`#size-select-${id}`);
                    const quantityInput = document.querySelector(`#quantity-input-${id}`);
                    const size_id = sizeSelect ? sizeSelect.value : 'default';
                    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

                    fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${id}&name=${name}&description=${description}&price=${price}&img=${img}&size_id=${size_id}&quantity=${quantity}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('success-modal-toggle').checked = true;
                        } else {
                            document.getElementById('error-modal-toggle').checked = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('error-modal-toggle').checked = true;
                    });
                });
            });
        });
    </script>
</body>
</html>
