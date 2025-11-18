<?php
include("../connect/config.php");

error_reporting(0); 
session_start(); 

if (isset($_POST['submit'])) {
  
    $email = $_POST['email'];  
    $password = $_POST['password'];

    $loginquery = "SELECT * FROM staffs WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $loginquery);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["id"] = $row['id'];
        $_SESSION["levelID"] = $row['levelID']; // Store access level in session
        $_SESSION['username'] = $row['username'];

        echo "<script type='text/javascript'> alert('Login successful. Welcome back!')</script>";
        header("refresh: .2; url=dashboard.php");
    } else {
        echo "<script type='text/javascript'> alert('Log in failed. Please enter valid username & password.')</script>";
        header("refresh: 0; url=index.php");
    }
}
?>


   <!DOCTYPE html>
   <html lang="en" dir="ltr">
   <head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
    <link rel="stylesheet" href="assets/css/stafflogin.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--page-icon------------>
    <link rel="shortcut icon" href="assets/images/pg-logo.png">
  </head>
  <body>
    <div class="container">
      <div class="cover">
        <div class="front">
          <img src="assets/images/loginCover.png" alt="">
          <div class="logo">
            <img src="assets/images/nav-logo.png">
          </div>
        </div>
      </div>
      <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <!--?php
            if(isset($_POST['submit'])){

              $email = $_POST['email'];  
              $password = $_POST['password'];

              $loginquery ="SELECT * FROM staffs WHERE email='$email' AND password='".($password)."'"; 
              $result=mysqli_query($conn, $loginquery);
              if($result->num_rows > 0){
                $row = mysqli_fetch_assoc($result);
                $_SESSION["id"] = $row['id'];
                echo "<script type='text/javascript'> alert('Login successful. Welcome back!')</script>";
                header("refresh: .2; url=dashboard.php");
              }else{
                echo "<script type='text/javascript'> alert('Log in failed. Please enter valid username & password.')</script>" . $loginquery . "<br>" . $conn->error;;
                header("refresh: 0; url=index.php");
              }
            }
            ?-->
            
            <div class="title">Login</div>
            <form action="" method="post">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="text" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-box">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <!-- <div class="text"><a href="#">Forgot password?</a></div> -->
                <div class="button input-box">
                  <input type="submit" name="submit" value="Submit">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
