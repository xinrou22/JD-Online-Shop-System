<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!--page-icon------------>
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>Login</title>
</head>
<body>
    <!-- Insert Navbar -->
    <?php include 'nav-footer/nav.php'; ?>
    <div class="container">
        <div class="box form-box">
            <?php 
            include("connect/config.php");

            if(isset($_POST['submit'])){
                $email = $_POST['email'];  
                $password = $_POST['password'];

                $loginquery = "SELECT * FROM customers WHERE email='$email'";
                $result = mysqli_query($conn, $loginquery);
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    if (password_verify($password, $row['password'])) {
                        $_SESSION["cusID"] = $row['cusID'];
                        
                        // Fetch the cart items for this user
                        $cusID = $_SESSION["cusID"];
                        $cart_query = "SELECT cart_items.*, products.name, products.description, products.price, products.img 
                                    FROM cart_items 
                                    JOIN products ON cart_items.product_id = products.id 
                                    WHERE user_id = '$cusID'";
                        $cart_result = mysqli_query($conn, $cart_query);
                        $cart_items = [];
                        while($cart_row = mysqli_fetch_assoc($cart_result)) {
                            $cart_items[] = $cart_row;
                        }
                        $_SESSION["cart"] = $cart_items;

                        echo "<div class='success'>
                        <p>Successfully logged in!</p>
                        </div> <br>";
                        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
                    } else {
                        echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                        </div> <br>";
                    }
                } else {
                    echo "<div class='message'>
                    <p>Wrong Username or Password</p>
                    </div> <br>";
                }

            }
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn-1" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Insert Footer -->
    <?php include 'nav-footer/footer.php'; ?>
    <?php include 'nav-footer/alert-js.php' ?>
</body>
</html>
