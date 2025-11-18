<?php 
session_start();
include("connect/config.php");

if(empty($_SESSION["cusID"])){
    header("Location: login.php");
}
$cusID = $_SESSION["cusID"];
$query = mysqli_query($conn,"SELECT * FROM customers WHERE cusID=$cusID");
$r = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>My Profile</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Additional styles specific to the profile page */

        /* Styling for the container holding the profile form */
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #EBF5FB;
            min-height: 83vh;
            min-width: 100%;
        }

        /* Styling for the profile form box */
        .form-box {
            width: 600px;
            margin: 0px 10px;
            background: #fdfdfd;
            padding: 30px 30px;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
            0 32px 64px -48px rgba(0, 0, 0, 0.5);
            font-family: Verdana; /* Set font family to Verdana */
            margin: 20px;
        }

        /* Styling for the header of the profile form */
        .form-box header {
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 20px;
            text-align: center;
            font-family: Verdana; /* Set font family to Verdana */
        }

        /* Styling for form fields within the profile form */
        .form-box form .field {
            display: flex;
            margin-bottom: 20px;
            flex-direction: column;
        }

        /* Styling for input fields within the profile form */
        .form-box form .input input, select {
            height: 40px;
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            font-family: Verdana; /* Set font family to Verdana */
        }

        .form-box textarea{
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        /* Styling for buttons within the profile form */
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
            font-family: Verdana; /* Set font family to Verdana */
        }

        /* Hover effect for buttons */
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
            <header>My Profile</header>
            <!-- PHP code for database interaction -->
            <?php

                // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(isset($_POST['submit'] )) {

                    $check_email = mysqli_query($conn, "SELECT email FROM customers where email = '".$_POST['email']."' && cusID != $cusID");
                    $check_country = mysqli_query($conn, "SELECT id FROM countries where id = '".$_POST['country_id']."' ");
                    $check_state = mysqli_query($conn, "SELECT id FROM states where id = '".$_POST['state_id']."' ");
                    $check_city = mysqli_query($conn, "SELECT id FROM cities where id = '".$_POST['city_id']."' ");
                    
                    // if(strlen($_POST['password']) < 6)  
                    // {
                    //     echo "<div class='message'>
                    //     <p>Password must be 6 digits or more than 6.</p>
                    //     </div> <br>";
                    // }
                    if(strlen($_POST['contact']) < 10 ) 
                    {
                        echo "<div class='message'>
                        <p>Invalid phone number! Please type a valid phone number!</p>
                        </div> <br>";
                    }
                    
                    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
                    {
                        echo "<div class='message'>
                        <p>Invalid email address. Please type a valid email!</p>
                        </div> <br>";
                    }
                    elseif(mysqli_num_rows($check_email) > 0) 
                    {
                        echo "<div class='message'>
                        <p>This email is used, Try another One Please!</p>
                        </div> <br>";
                    }
                    elseif(mysqli_num_rows($check_country) == 0) 
                    {
                        echo "<div class='message'>
                        <p>Please select country!</p>
                        </div> <br>";
                    }
                    elseif(mysqli_num_rows($check_state) == 0) 
                    {
                        echo "<div class='message'>
                        <p>Please select state!</p>
                        </div> <br>";
                    }
                    elseif(mysqli_num_rows($check_city) == 0) 
                    {
                        echo "<div class='message'>
                        <p>Please select city!</p>
                        </div> <br>";
                    }
                    else {
                        $mql = "UPDATE `customers` SET 
                        `firstName`='".$_POST['firstName']."',
                        `lastName`='".$_POST['lastName']."',
                        `email`='".$_POST['email']."',
                        `contact`='".$_POST['contact']."',
                        
                        `country_id`='".$_POST['country_id']."',
                        `state_id`='".$_POST['state_id']."',
                        `city_id`='".$_POST['city_id']."',
                        `postcode`='".$_POST['postcode']."',
                        `address`='".$_POST['address']."'
                        WHERE `cusID`='$cusID'";
                        mysqli_query($conn, $mql);
                        echo "<div class='success'>
                        <p>Profile Updated successfully!</p>
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
                    <label for="firstName" style="font-family: Verdana;">First Name:</label>
                    <input type="text" value="<?php echo $r['firstName'] ?>" id="firstName" name="firstName" required style="font-family: Verdana;">
                </div>
                <div class="field input">
                    <label for="lastName" style="font-family: Verdana;">Last Name:</label>
                    <input type="text" value="<?php echo $r['lastName'] ?>" id="lastName" name="lastName" required style="font-family: Verdana;">
                </div>
                <div class="field input">
                    <label for="username" style="font-family: Verdana;">Username:</label>
                    <input type="text" value="<?php echo $r['username'] ?>" id="username" name="username" disabled style="font-family: Verdana;">
                </div>
                <div class="field input">
                    <label for="email" style="font-family: Verdana;">Email:</label>
                    <input type="email" value="<?php echo $r['email'] ?>" id="email" name="email" required style="font-family: Verdana;">
                </div>
                <div class="field input">
                    <label for="contact" style="font-family: Verdana;">Contact:</label>
                    <input type="text" value="<?php echo $r['contact'] ?>" id="contact" name="contact" required style="font-family: Verdana;">
                </div>
           <!--      <div class="field input">
                    <label for="password" style="font-family: Verdana;">New Password:</label>
                    <input type="password" value="<?php echo $r['password'] ?>" id="password" name="password" required style="font-family: Verdana;">
                </div> -->
                <!-- Manual override code -->
                <div class="field input">
                    <label for="country">Country</label>
                    <select id="country" name="country_id">
                      <option value="0">Select Country</option> 

                      <?php
                      include('connect/config.php');
                      $fetch_country = mysqli_query($conn,"SELECT * FROM countries");
                      while($country = mysqli_fetch_array($fetch_country)){
                        ?>    
                        <option <?php if($r['country_id'] == $country['id']){echo "selected";} ?> value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="field input">
                <label for="state">State</label>
                <select id="state" name="state_id">
                    <option value="0">Select State</option>
                </select>
            </div>

            <!-- Manual modify for "city" -->
            <div class="field input">
                <label for="city" style="font-family: Verdana;">City</label>
                <select id="city" name="city_id">
                    <option value="0">Select City</option>
                </select>
            </div>
            <div class="field input">
                <label for="postcode" style="font-family: Verdana;">Postcode:</label>
                <input type="text" value="<?php echo $r['postcode'] ?>" id="postcode" name="postcode" required style="font-family: Verdana;">
            </div>
            <div class="field input">
                <label for="address" style="font-family: Verdana;">Address:</label>
                <textarea id="address" name="address" rows="4" cols="50" required style="font-family: Verdana;"><?php echo $r['address'] ?></textarea>
            </div>
            <div class="field submit">
                <!-- Update Profile button -->
                <button type="submit" name="submit" class="btn-1">Update Profile</button>
                <!-- Change Password button -->
                <button type="button" onclick="window.location.href='change-pass.php'" class="btn-1">Change Password</button>
                <!-- Cancel button -->
                <button type="button" onclick="window.location.href='index.php'" class="btn-2">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        function fetchStates(countryId, selectedStateId = 0) {
            $.ajax({
                url: 'ajax.php',
                method: 'post',
                data: { country_id: countryId },
                success: function(result) {
                    $("#state").html('<option value="0">Select State</option>');
                    $("#city").html('<option value="0">Select City</option>');
                    $("#state").append(result);

                    if (selectedStateId) {
                        $("#state").val(selectedStateId);
                    }
                }
            });
        }

        function fetchCities(stateId, selectedCityId = 0) {
            $.ajax({
                url: 'ajax.php',
                method: 'post',
                data: { state_id: stateId, type: 'state' },
                success: function(result) {
                    $("#city").html('<option value="0">Select City</option>');
                    $("#city").append(result);

                    if (selectedCityId) {
                        $("#city").val(selectedCityId);
                    }
                }
            });
        }

    // Fetch states and cities for the initially selected country and state
        var countryId = $("#country").val();
        var stateId = <?php echo $r['state_id'] ?>;
        var cityId = <?php echo $r['city_id'] ?>;
        if (countryId != '0') {
            fetchStates(countryId, stateId);
        }
        if (stateId != '0') {
            fetchCities(stateId, cityId);
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
    });
</script>             

<!-- Insert Footer -->
<?php include 'nav-footer/footer.php' ?>
<?php include 'nav-footer/alert-js.php' ?>

<!-- Link to external JavaScript file for slideshow -->
<script src="js/HomeScript.js"></script>
</body>

</html>