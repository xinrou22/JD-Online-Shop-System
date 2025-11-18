<?php 
session_start();
include("connect/config.php");

if(empty($_SESSION["cusID"])){
    header("Location: login.php");
}
$cusID = $_SESSION["cusID"];
$query = mysqli_query($conn,"SELECT * FROM customers WHERE cusID=$cusID");
$r = mysqli_fetch_array($query);
$current_password = $r['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #EBF5FB;
            min-height: 83vh;
            min-width: 100%;
        }
        .form-box {
            width: 600px;
            margin: 0px 10px;
            background: #fdfdfd;
            padding: 30px 30px;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
            0 32px 64px -48px rgba(0, 0, 0, 0.5);
            font-family: Verdana;
            margin: 20px;
        }
        .form-box header {
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 20px;
            text-align: center;
            font-family: Verdana;
        }
        .form-box form .field {
            display: flex;
            margin-bottom: 20px;
            flex-direction: column;
        }
        .form-box form .input input, select {
            height: 40px;
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            font-family: Verdana;
        }
        .form-box textarea{
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }
        .btn-1 {
            height: 35px;
            background: #000000;
            border: 0;
            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            transition: all .3s;
            margin-top: 10px;
            padding: 0px 10px;
            font-family: Verdana;
        }
        .btn-1:hover {
            opacity: 0.7;
        }

         .btn-2 {
            height: 35px;
            background: #D73919;
            border: 0;
            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            transition: all .3s;
            margin-top: 10px;
            padding: 0px 10px;
            font-family: Verdana; /* Set font family to Verdana */
        }

        /* Hover effect for buttons */
        .btn-2:hover {
            opacity: 0.7;
        }

    </style>
</head>
<body>
    <!-- Insert Navbar -->
    <?php include 'nav-footer/nav.php' ?>

    <!-- Container for profile form -->
    <div class="container">
        <div class="form-box">
            <header>Change Password</header>
            <!-- PHP code for database interaction -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST['submit'] )) {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];

                    if(strlen($new_password) < 6) {
                        echo "<div class='message'>
                        <p>Password must be 6 characters or more.</p>
                        </div> <br>";
                    } elseif(!password_verify($old_password, $current_password)) {
                        echo "<div class='message'>
                        <p>Old password is incorrect.</p>
                        </div> <br>";
                    } elseif(password_verify($new_password, $current_password)) {
                        echo "<div class='message'>
                        <p>New password cannot be the same as the current password.</p>
                        </div> <br>";
                    } else {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $mql = "UPDATE `customers` SET 
                        `password`='".$hashed_password."'
                        WHERE `cusID`='$cusID'";
                        mysqli_query($conn, $mql);
                        echo "<div class='success'>
                        <p>Password updated successfully!</p>
                        </div> <br>";
                        ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = "customerprofile.php"
                            }, 3000); 
                        </script>
                        <?php 
                    }
                }
            }
            ?>
            <!-- Profile Form -->
            <form id="profileForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="field input">
                    <label for="old_password" style="font-family: Verdana;">Old Password:</label>
                    <input type="password" id="old_password" name="old_password" required style="font-family: Verdana;" placeholder="Please fill in your old password...">
                </div>
                <div class="field input">
                    <label for="new_password" style="font-family: Verdana;">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required style="font-family: Verdana;" placeholder="Your new password must be at least 6 digits...">
                </div>
               
                <div class="field submit">
                    <button type="submit" name="submit" class="btn-1">Confirm</button>
                    <!-- Cancel button -->
                    <button type="button" onclick="window.location.href='customerprofile.php'" class="btn-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Insert Footer -->
<?php include 'nav-footer/footer.php' ?>
<?php include 'nav-footer/alert-js.php' ?>
</body>
</html>
