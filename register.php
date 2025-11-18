<?php
include("connect/config.php");
session_start();

$success_message = "";

if(isset($_POST['submit'])) {
    $check_username = mysqli_query($conn, "SELECT username FROM customers WHERE username = '".$_POST['username']."' ");
    $check_email = mysqli_query($conn, "SELECT email FROM customers WHERE email = '".$_POST['email']."' ");
    $check_country = mysqli_query($conn, "SELECT id FROM countries WHERE id = '".$_POST['country_id']."' ");
    $check_state = mysqli_query($conn, "SELECT id FROM states WHERE id = '".$_POST['state_id']."' ");
    $check_city = mysqli_query($conn, "SELECT id FROM cities WHERE id = '".$_POST['city_id']."' ");

    if($_POST['password'] != $_POST['cpassword']){  
        $success_message = "<div class='message'><p>Password not match</p></div> <br>";
    } elseif(strlen($_POST['password']) < 6) {
        $success_message = "<div class='message'><p>Password must be 6 digits or more.</p></div> <br>";
    } elseif(strlen($_POST['contact']) < 10) {
        $success_message = "<div class='message'><p>Invalid phone number! Please type a valid phone number!</p></div> <br>";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $success_message = "<div class='message'><p>Invalid email address. Please type a valid email!</p></div> <br>";
    } elseif(mysqli_num_rows($check_username) > 0) {
        $success_message = "<div class='message'><p>This username is used, Try another One Please!</p></div> <br>";
    } elseif(mysqli_num_rows($check_email) > 0) {
        $success_message = "<div class='message'><p>This email is used, Try another One Please!</p></div> <br>";
    } elseif(mysqli_num_rows($check_country) == 0) {
        $success_message = "<div class='message'><p>Please select country!</p></div> <br>";
    } elseif(mysqli_num_rows($check_state) == 0) {
        $success_message = "<div class='message'><p>Please select state!</p></div> <br>";
    } elseif(mysqli_num_rows($check_city) == 0) {
        $success_message = "<div class='message'><p>Please select city!</p></div> <br>";
    } else {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $mql = "INSERT INTO customers (firstName, lastName, username, email, contact, password, country_id, state_id, city_id, postcode, address) VALUES ('".$_POST['firstName']."', '".$_POST['lastName']."', '".$_POST['username']."', '".$_POST['email']."', '".$_POST['contact']."', '".$hashed_password."', '".$_POST['country_id']."', '".$_POST['state_id']."', '".$_POST['city_id']."', '".$_POST['postcode']."', '".$_POST['address']."')";
        mysqli_query($conn, $mql);
        $success_message = '<div class="success"><p>Registration successfully! Redirecting to login...</p></div> <br>';
        header("refresh:3; url=login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>Register</title>
</head>
<body>
   <!-- Insert Navbar -->
   <?php include 'nav-footer/nav.php' ?>
   <div class="container">
       <div class="box form-box-2">
           <!-- Alert Message -->
           <?php echo $success_message; ?>
           <header>Sign Up</header>
           <form action="" method="post">
               <div class="field input">
                   <label for="firstName">First Name</label>
                   <input type="text" name="firstName" id="firstName" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="lastName">Last Name</label>
                   <input type="text" name="lastName" id="lastName" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="username">Username</label>
                   <input type="text" name="username" id="username" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="email">Email</label>
                   <input type="text" name="email" id="email" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="contact">Contact No.</label>
                   <input type="text" name="contact" id="contact" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="password">Password</label>
                   <input type="password" name="password" id="password" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="cpassword">Confirm Password</label>
                   <input type="password" name="cpassword" id="cpassword" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="country">Country</label>
                   <select id="country" name="country_id">
                       <option value="0">Select Country</option>
                       <?php
                       $fetch_country = mysqli_query($conn, "SELECT * FROM countries");
                       while($country = mysqli_fetch_array($fetch_country)){
                           echo '<option value="'.$country['id'].'">'.$country['name'].'</option>';
                       }
                       ?>
                   </select>
               </div>
               <div class="field input">
                   <label for="state">State</label>
                   <select id="state" name="state_id">
                       <option value="0">Select State</option>
                   </select>
               </div>
               <div class="field input">
                   <label for="city">City</label>
                   <select id="city" name="city_id">
                       <option value="0">Select City</option>
                   </select>
               </div>
               <div class="field input">
                   <label for="postcode">Post Code</label>
                   <input type="text" name="postcode" id="postcode" autocomplete="off" required>
               </div>
               <div class="field input">
                   <label for="address">Address</label>
                   <input type="text" name="address" id="address" autocomplete="off" required>
               </div>
               <div class="field">
                   <input type="submit" class="btn-1" name="submit" value="Register">
               </div>
               <div class="links">
                   Already a member? <a href="login.php">Sign In</a>
               </div>
           </form>
       </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script type="text/javascript">
   $(document).ready(function(){
       $("#country").change(function(){
           var id = $(this).val();
           if(id=='0') {
               $("#state").html('<option value="0">Select State</option>');
               $("#city").html('<option value="0">Select City</option>');
           } else {
               $("#state").html('<option value="0">Select State</option>');
               $("#city").html('<option value="0">Select City</option>');
               $.ajax({
                   url: 'ajax.php',
                   method: 'post',
                   data: {country_id: id},
                   success: function(result) {
                       $("#state").append(result);
                   }
               });
           }
       });
       $("#state").change(function(){
           var id = $(this).val();
           if(id=='0') {
               $("#city").html('<option value="0">Select City</option>');
           } else {
               $("#city").html('<option value="0">Select City</option>');
               $.ajax({
                   url: 'ajax.php',
                   method: 'post',
                   data: {state_id: id, type:'state'},
                   success: function(result) {
                       $("#city").append(result);
                   }
               });
           }
       });
   });
   </script>

   <!-- Insert Footer -->
   <?php include 'nav-footer/footer.php' ?>
   <?php include 'nav-footer/alert-js.php' ?>

</body>
</html>
