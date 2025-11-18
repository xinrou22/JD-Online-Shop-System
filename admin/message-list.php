<!--All Code below written by joshua on 30/5/2024-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Message List</title>
  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!--page-icon------------>
  <link rel="shortcut icon" href="assets/images/pg-logo.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
</head>

<body>
    <!-- Container -->
    <div class="container-1">
        <?php include 'nav.php'; ?>
        <!-- Content -->
        <h1 style="margin-top: 10px; margin-left: 30px;">All messages</h1>
        
        <!-- ================ Message List Section ================ -->
        <div class="list">
            <div class="recentList">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <td>ID</td>
                        <td>Full Name</td>
                        <td>Email</td>
                        <td>Contact No.</td>
                        <td>Date</td>
                        <td>Remarks</td>
                        <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Include the database connection file
                            include("../connect/config.php");

                            // Fetch messages data from database
                            $sql = "SELECT * FROM contact_us";
                            
                            
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                            
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                 <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <!--message column removed only in this page by Josh on 21/6/2024-->
                                    <!--<td><?php echo $row['message']; ?></td>-->
                                    <td><?php echo $row['datetime']; ?></td>
    
                                    <td><input readonly type="text" id="remarks" name="remarks" value="<?php echo $row['remarks']; ?>"></td>


                              
                                    <td>
                                        <a href="edit-message-remark.php?message_remark_upd=<?php echo $row['id']; ?>"><button class="edit-btn"><ion-icon name="create-outline"></ion-icon></ion-icon></button></a>
                                    </td>
                                </tr>
                                <?php
                                }
                            } else {
                                echo "<tr><td colspan='10'>No messages found</td></tr>";
                            }

                            // Close database connection
                            mysqli_close($conn);
                                    
                            ?>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/datatables.min.js"></script>
  <script src="assets/js/pdfmake.min.js"></script>
  <script src="assets/js/vfs_fonts.js"></script>
  <script src="assets/js/custom.js"></script>
    
</body>