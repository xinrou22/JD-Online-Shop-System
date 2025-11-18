<?php 
include("../connect/config.php"); 
if(isset($_POST['submit'] )) {

    $check_username= mysqli_query($conn, "SELECT username FROM staffs where username = '".$_POST['username']."' ");
    $check_email = mysqli_query($conn, "SELECT email FROM staffs where email = '".$_POST['email']."' ");

    if(strlen($_POST['password']) < 6)  
    {
        $error = '<div class="alert"><strong>Danger!</strong> Password must be 6 digits or more than 6!</div>';
    }
    elseif(strlen($_POST['contact']) < 10 ) 
    {
        $error = '<div class="alert"><strong>Danger!</strong> Invalid phone number! Please type a valid phone number!</div>';
    }

    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    {
        $error = '<div class="alert"><strong>Danger!</strong> Invalid email address. Please type a valid email!</div>';
    }
    elseif(mysqli_num_rows($check_username) > 0) 
    {
        $error = '<div class="alert"><strong>Danger!</strong> This username is used, Try another One Please!</div>';
    }
    elseif(mysqli_num_rows($check_email) > 0) 
    {
        $error = '<div class="alert"><strong>Danger!</strong> This email is used, Try another One Please!</div>';
    }
    else{
        $mql = "INSERT INTO staffs(name,username,email,contact,password,levelID) VALUES('".$_POST['name']."','".$_POST['username']."','".$_POST['email']."','".$_POST['contact']."','".$_POST['password']."','".$_POST['levelID']."')";
            mysqli_query($conn, $mql);
            $success = '<div class="success"><strong>Staff account added successfully!</strong></div>';
            header("refresh:1;url=staff-list.php"); 
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Staff</title>
        <!-- ======= Styles ====== -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!--page-icon------------>
        <link rel="shortcut icon" href="assets/images/pg-logo.png">
    </head>

    <body>
        <!-- Cannot be deleted -->
        <div class="container">
            <?php include'nav.php' ?>
            <!-- Content -->
            <!-- Alert Message -->
            <?php  echo $error; ?>
            <?php echo $success; ?>

            <h1 style="margin-top: 10px; margin-left: 30px;">Add Staff</h1>

            <!-- ================ Add Staff Form ================= -->
            <div class="container-2">
              <form action="" method="post">
                <div class="row">
                    <div class="col-15">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="name" name="name" placeholder="Please enter the staff's full name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="username" name="username" placeholder="Please enter staff's username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="email" name="email" placeholder="Please enter staff's email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="contact">Contact No.</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="contact" name="contact" placeholder="Please enter staff's contact no.">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-80">
                        <input type="password" id="password" name="password" placeholder="Please enter password">
                    </div>
                </div>
          <!--   <div class="row">
                <div class="col-15">
                    <label for="cpassword">Confirm Password</label>
                </div>
                <div class="col-80">
                    <input type="text" id="cpassword" name="cpassword" placeholder="Please confirm your password">
                </div>
            </div> -->

            <div class="row">
                <div class="col-15">
                    <label for="level">Access Level</label>
                </div>
                <div class="col-80">
                    <select id="levelID" name="levelID">
                     <?php
                     include('../connect/config.php');
                     $Acess_Level = mysqli_query($conn,"select * from acessLevel");
                     while($level = mysqli_fetch_array($Acess_Level)){
                      ?>    
                      <option value="<?php echo $level['id']; ?>"><?php echo $level['level']; ?></option>
                  <?php } ?>
              </select>
          </div>
      </div>
      <br>
      <div class="row">
        <div class="col-10">
            <input type="submit" name="submit" value="Submit">
        </div>
    </div>
</form>
<div class="row">
    <div class="col-20">
        <a href="staff-list.php"><button class="btn-back">Back</button></a>
    </div>
</div>
</div>

<!-- Cannot be deleted -->
<!-- <div class="main"> in nav.php-->
</div>
</div>

</body>