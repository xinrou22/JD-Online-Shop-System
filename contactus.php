<?php
include("connect/config.php");
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html>
<head>
 <title>Contact us</title>
 <link rel="stylesheet" type="text/css" href="css/style.css">
 <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
 <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
 <!--page-icon------------>
 <link rel="shortcut icon" href="images/pg-logo.png">
 <style>

  *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: Verdana;
  }

  body{
    height: 100vh;
    width: 100%;
  }

  .container{
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px 100px;
  }

  .container:after{
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background: url("img/bg.jpg") no-repeat center;
    background-size: cover;
    filter: blur(50px);
    z-index: -1;
  }
  .contact-box{
    max-width: 850px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    justify-content: center;
    align-items: center;
    text-align: center;
    background-color: #fff;
    box-shadow: 0px 0px 19px 5px rgba(0,0,0,0.19);
  }

  .left{
    background: url("images/1.jpg") no-repeat center;
    background-size: cover;
    height: 100%;
  }

  .right{
    padding: 25px 40px;
  }

  h2{
    position: relative;
    padding: 0 0 10px;
    margin-bottom: 10px;
  }

  h2:after{
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    height: 4px;
    width: 50px;
    border-radius: 2px;
    background-color: #8b2c50;
  }

  .field{
    width: 100%;
    border: 2px solid rgba(0, 0, 0, 0);
    outline: none;
    background-color: rgba(230, 230, 230, 0.6);
    padding: 0.5rem 1rem;
    font-size: 1.1rem;
    margin-bottom: 22px;
    transition: .3s;
  }

  .field:hover{
    background-color: rgba(0, 0, 0, 0.1);
  }

  textarea{
    min-height: 150px;
  }

  .btn-2{
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
    width: 100%;
  }
  .btn-2:hover{
    opacity: 0.7;
  }

  .field:focus{
    border: 2px solid rgba(30,85,250,0.47);
    background-color: #fff;
  }

  @media screen and (max-width: 880px){
    .contact-box{
      grid-template-columns: 1fr;
    }
    .left{
      height: 200px;
    }
  }
</style>
</head>
<body>
  <?php include 'nav-footer/nav.php'; ?>
  <div class="container">
    <div class="contact-box">
     <div class="left"></div>
     <div class="right">
      <?php
      if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
          $form_valid = true; // Flag to track form validity

          // Validate Name
          if(empty($name)){
            echo "<div class='message'>
            <p>Name is required</p>
            </div>";
            $form_valid = false;
          }

          // Validate Email
          if(empty($email)){
            echo "<div class='message'>
            <p>Email is required</p>
            </div>";
            $form_valid = false;
          }
          elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<div class='message'>
            <p>Invalid email format!</p>
            </div>";
            $form_valid = false;
          }

          // Validate Phone
          if(empty($phone)){
            echo "<div class='message'>
            <p>Phone is required</p>
            </div>";
            $form_valid = false;
          }
          elseif(!preg_match("/^01[0-46-9]-?[0-9]{7,8}$/", $phone)){
            echo "<div class='message'>
            <p>Invalid Phone format! Please make sure that the phone number format is written as 010-2638546 etc</p>
            </div>";
            $form_valid = false;
          }
          else{
            // Check if the phone number matches the valid format
            if(preg_match("/^01[0-46-9][0-9]{7,8}$/", $phone)){
              // If the phone number is in the valid format, add a dash
              $phone = substr($phone, 0, 3) . '-' . substr($phone, 3);
            }
          }

          // Validate Message
          if(empty($message)){
            echo "<div class='message'>
            <p>Message is required</p>
            </div>";
            $form_valid = false;
          }

          // If form is valid, proceed to insert into the database
          if($form_valid){
            $sql = "INSERT INTO contact_us (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
            $result = mysqli_query($conn, $sql);
            if($result){
              echo "<div class='success'>
              <p>Message successfully submitted. Thank you</p>
              </div>";
              // Clear fields after successful submission
              $_POST = array();

              echo "<script>setTimeout(function(){ window.location.href = 'contactus.php'; }, 2000);</script>";

            } else {
              echo "<div class='message'>
              <p>Something went wrong!</p>
              </div>";
            }
          }
        }
        ?>
        <h2>Get in touch!</h2>

        <!-- Form -->
        <form method="post" action="">
          <input type="text" class="field" placeholder="Your Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
          <?php if(isset($errors['name'])) echo "<p class='error'>".$errors['name']."</p>"; ?>

          <input type="email" class="field" placeholder="Your Email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
          <?php if(isset($errors['email'])) echo "<p class='error'>".$errors['email']."</p>"; ?>

          <input type="text" class="field" placeholder="Phone (e.g., 011-1234567)" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
          <?php if(isset($errors['phone'])) echo "<p class='error'>".$errors['phone']."</p>"; ?>

          <textarea placeholder="Message" class="field" name="message" required><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
          <?php if(isset($errors['message'])) echo "<p class='error'>".$errors['message']."</p>"; ?>

          <button type="submit" name="submit" class="btn-2">Send</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Insert Footer -->
  <?php include 'nav-footer/footer.php'; ?>
  <?php include 'nav-footer/alert-js.php'; ?>
</body>
</html>