<?php
// Include necessary files and start session
include("../connect/config.php");
error_reporting(0);
session_start();

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $levelID = $_POST['levelID'];
    $staffId = $_GET['staff_upd']; // Get staff ID from URL parameter

    // Check if all fields are filled
    if(empty($name) || empty($contact) || empty($password) || empty($levelID)) {
        $error = '<div class="alert"><strong>Danger!</strong> All fields must be filled!</div>';
    } else {
        // Check contact length or any other validation
        if(strlen($contact) < 10) {
            $error = '<div class="alert"><strong>Danger!</strong> Invalid phone number!</div>';
        } else {
            // Update staff member's information
            $sql = "UPDATE staffs SET name='$name', contact='$contact', password='$password', levelID='$levelID' WHERE id= $staffId";

            // Execute SQL query
            if(mysqli_query($conn, $sql)) {
                $success = '<div class="success"><strong>Update completed</strong></div>';
                // Redirect to staff list page after successful update
                header("refresh:1;url=staff-list.php");
            } else {
                $error = '<div class="alert"><strong>Error!</strong> Unable to update staff information</div>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Staff's Information</title>
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

    <h1 style="margin-top: 10px; margin-left: 30px;">Edit Staff's Information</h1>

    <!-- ================ Edit Staff ================= -->
    <div class="container-2">
      <form action="" method="post">

        <?php 
        $qml ="select * from staffs where id='$_GET[staff_upd]'";
        $rest=mysqli_query($conn, $qml); 
        $row = mysqli_fetch_assoc($rest);
        ?> 

        <div class="row">
          <div class="col-15">
            <label for="name">Name</label>
          </div>
          <div class="col-80">
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" placeholder="Please enter the staff's full name">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="username">Username</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="username" name="username" value="<?php echo $row['username']; ?>" placeholder="Please enter staff's username" style="background: lightgrey;">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="email">Email</label>
          </div>
          <div class="col-80">
            <input readonly type="text" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Please enter staff's email" style="background: lightgrey;">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="contact">Contact No.</label>
          </div>
          <div class="col-80">
            <input type="text" id="contact" name="contact" placeholder="Please enter your current contact number" value="<?php echo $row['contact']; ?>" placeholder="Please enter staff's contact no.">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="password">Password</label>
          </div>
          <div class="col-80">
            <input type="password" id="password" name="password" placeholder="Please enter your new password" value="<?php echo $row['password']; ?>" placeholder="Please enter password">
          </div>
        </div>
        <div class="row">
          <div class="col-15">
            <label for="level">Access Level</label>
          </div>
          <div class="col-80">
            <select id="levelID" name="levelID">
             <?php
            $Access_Levels = mysqli_query($conn, "SELECT * FROM acesslevel");
            while ($level = mysqli_fetch_array($Access_Levels)) {
                ?>
                <option <?php if ($row['levelID'] == $level['id']) {echo "selected";} ?> value="<?php echo $level['id']; ?>"><?php echo $level['level']; ?></option>
            <?php } ?>
          </select>
        </div>
        <br>
        <div class="row">
          <div class="col-10">
            <input type="submit" name="submit" value="Update">
          </div>
        </div>
      </form>
    </div>
     <div class="row">
        <div class="col-20">
          <a href="staff-list.php"><button class="btn-back">Back</button></a>
        </div>
      </div>

    <!-- Cannot be deleted -->
    <!-- <div class="main"> in nav.php-->
    </div>
  </div>
</body>