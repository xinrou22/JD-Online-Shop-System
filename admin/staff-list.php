<?php
session_start();
// Include your database connection
include('../connect/config.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Check if the user is a manager
if ($_SESSION['levelID'] != 2) {
    header("refresh: .2; url=403error.php");
    exit();
}

// Your existing code for displaying staff list goes here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--page-icon------------>
    <link rel="shortcut icon" href="assets/images/pg-logo.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
</head>
<body>
    <div class="container-1">
        <?php include 'nav.php'; ?>
        <!-- Content -->
        <h1 style="margin-top: 10px; margin-left: 30px;">Admin</h1>
        <div class="btn-list">
            <a href="add-staff.php"><button class="btn-add" role="button">Add New Staff</button></a>
        </div>
        <!-- ================ Staff List ================= -->
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
                            <td>Access Level</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT s.id, s.name, s.username, s.email, s.contact, a.level 
                                FROM staffs s
                                INNER JOIN acesslevel a ON s.levelID = a.id";
                        $res = mysqli_query($conn, $sql);
                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res); 
                            $sn = 1; 
                            if ($count > 0) {
                                while ($rows = mysqli_fetch_assoc($res)) {
                                    $id = $rows['id'];
                                    $name = $rows['name'];
                                    $username = $rows['username'];
                                    $email = $rows['email'];
                                    $contact = $rows['contact'];
                                    $level = $rows['level'];
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td> 
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $contact; ?></td>
                                        <td><?php echo $level; ?></td>
                                        <td>
                                            <a href="delete-staff.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this staff member?');" class="link">
                                                <button class="delete-btn"><ion-icon name="trash-outline"></ion-icon></button>
                                            </a>
                                            <a href="edit-staff.php?staff_upd=<?php echo $id;?>"><button class="edit-btn"><ion-icon name="create-outline"></ion-icon></button></a>
                                        </td>
                                    </tr>
                                    <?php 
                                } 
                            } else { 
                                ?>
                                <tr><td colspan="7"><div class="error">No Staff</div></td></tr>
                                <?php 
                            } 
                        }
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
</html>
