<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer List</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <!--page-icon------------>
  <link rel="shortcut icon" href="assets/images/pg-logo.png">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
</head>

<body>
  <!-- Cannot be deleted -->
  <div class="container-1">
    <?php include'nav.php' ?>
    
    <!-- Content -->
    <h1 style="margin-top: 10px; margin-left: 30px;">Customer List</h1>
    
    <!-- ================ Customer List ================= -->
    <div class="list">
      <div class="recentList">
        <table id="example" class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Username</td>
              <td>Email</td>
              <td>Contact No.</td>
              <td>Country</td>
              <td>State</td>
              <td>City</td>
              <td>Post Code</td>
              <td>Address</td>
              <!-- <td>Action</td> -->
            </tr>
          </thead>

          <tbody>
            <?php 
            include('../connect/config.php');
            $sql = "SELECT customers.*, states.name AS state_name, cities.name AS city_name, countries.name AS country_name
            FROM customers
            JOIN states ON customers.state_id = states.id
            JOIN cities ON customers.city_id = cities.id
            JOIN countries ON customers.country_id = countries.id";
            $res = mysqli_query($conn, $sql);
            if($res==TRUE)
            {
              $count = mysqli_num_rows($res); 
              $sn=1; 
              if($count>0)
              {
                while($rows=mysqli_fetch_assoc($res))
                {
                // $id=$rows['id'];
                  $fname=$rows['firstName'];
                  $lname=$rows['lastName'];
                  $username=$rows['username'];
                  $email=$rows['email'];
                  $contact=$rows['contact'];
                  $country=$rows['country_name'];
                  $state=$rows['state_name'];
                  $city=$rows['city_name'];
                  $postcode=$rows['postcode'];
                  $address=$rows['address'];
                  ?>

                  <tr>
                    <td><?php echo $sn++; ?>. </td> 
                    <td><?php echo $fname; ?><?php echo $lname; ?></td>
                    <td><?php echo $username; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $contact; ?></td>
                    <td><?php echo $country; ?></td> 
                    <td><?php echo $state; ?></td>
                    <td><?php echo $city; ?></td> 
                    <td><?php echo $postcode; ?></td> 
                    <td><?php echo $address; ?></td>
                   <!--  <td>                                
                      <a><button class="delete-btn"><ion-icon name="trash-outline"></ion-icon></button></a>
                      <a><button class="edit-btn"><ion-icon name="create-outline"></ion-icon></ion-icon></button></a>
                    </td> -->
                  </tr>
                <?php } }
                else{ ?>
                  <tr><td colspan="11"><div class="error">No customer</div></td></tr>
                <?php } }?>
              </tbody>
            </table>
          </div>

          <!-- Cannot be deleted -->
          <!-- <div class="main"> in nav.php-->
          </div>
        </div>

        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/datatables.min.js"></script>
        <script src="assets/js/pdfmake.min.js"></script>
        <script src="assets/js/vfs_fonts.js"></script>
        <script src="assets/js/custom.js"></script>
      </body>