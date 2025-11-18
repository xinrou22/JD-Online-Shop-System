<?php
include("../connect/config.php");
error_reporting(0);
session_start();

if(empty($_SESSION['id']))
{
  header('location:index.php');
}
else
{  

  ?>
  <?php
if(isset($_POST['submit']))           //if upload btn is pressed
{
  if(empty($_POST['contact']||$_POST['password']==''))
  { 
    $error = '<div class="alert"><strong>Danger!</strong> All fields must be filled!</div>';
  }
  else
  {
    if(strlen($_POST['contact']) < 10)  //cal phone length
    {
      // $message = "Invalid phone number!";
      $error = '<div class="alert"><strong>Danger!</strong> Invalid phone number!</div>';
    }
    else{

      $sql = "UPDATE staffs SET contact='$_POST[contact]',password='$_POST[password]' where id='{$_SESSION['id']}'";  
      mysqli_query($conn, $sql); 
      move_uploaded_file($temp, $store);

      // $success =  'Update completed';
      $success = '<div class="success"><strong>Update completed</strong></div>';
      header("refresh:1;url=staff-profile.php");
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
  <title>Profile</title>
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

    <h1 style="margin-top: 10px; margin-left: 30px;">Profile</h1>
    <div class="container-2">
      <form action="" method="post">

        <?php 
        $sql ="select * from staffs where id='{$_SESSION['id']}'";
        $rest=mysqli_query($conn, $sql); 
        if(mysqli_num_rows($rest)>0){
          while($row = mysqli_fetch_assoc($rest)){
            ?> 

            <div class="row">
              <div class="col-15">
                <label for="name">Name</label>
              </div>
              <div class="col-80">
                <input readonly type="text" id="name" name="name" value="<?php echo $row['name']; ?>" style="background-color:#E7E7E7;">
              </div>
            </div>
            <div class="row">
              <div class="col-15">
                <label for="username">Username</label>
              </div>
              <div class="col-80">
                <input readonly type="text" id="username" name="username" value="<?php echo $row['username']; ?>" style="background-color:#E7E7E7;">
              </div>
            </div>
            <div class="row">
              <div class="col-15">
                <label for="email">Email</label>
              </div>
              <div class="col-80">
                <input readonly type="text" id="email" name="email" value="<?php echo $row['email']; ?>" style="background-color:#E7E7E7;">
              </div>
            </div>
            <div class="row">
              <div class="col-15">
                <label for="contact">Contact No.</label>
              </div>
              <div class="col-80">
                <input type="text" id="contact" name="contact" placeholder="Please enter your contact number" value="<?php echo $row['contact']; ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-15">
                <label for="password">Password</label>
              </div>
              <div class="col-80">
                <input type="password" id="password" name="password" placeholder="Please enter password" value="<?php echo $row['password']; ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-15">
                <label for="level">Access Level</label>
              </div>
              <div class="col-80">
                <input readonly type="text" id="levelID" name="levelID" value="<?php echo $row['levelID']; ?>" style="background-color:#E7E7E7;">
              </div>
            </div>

            <?php
          }
        }
        ?>
        <br>
        <div class="row">
          <div class="col-10">
            <input type="submit" name="submit" value="Update">
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-20">
          <a href="dashboard.php"><button class="btn-back">Back</button></a>
        </div>
      </div>
    </div>

    <!-- Cannot be deleted -->
    <!-- <div class="main"> in nav.php-->
    </div>
  </div>
</body>
<?php
}
?>