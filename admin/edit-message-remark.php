<!-- Edit Message Remarks Page Added by Josh on 21/6/2024-->
<?php 
include("../connect/config.php"); 

if(isset($_POST['submit'])) {
    // Fetch existing message data based on message ID
    $messageId = $_GET['message_remark_upd'];
    $remarks= $_POST['remarks'];
    $sql = "UPDATE contact_us SET remarks='$remarks' WHERE id = $messageId";
    
    if(mysqli_query($conn, $sql)) {
        $success = '<div class="success"><strong>Message remarks updated successfully!</strong></div>';
        // Redirect to message list page after successful update
        header("refresh:1;url=message-list.php");
    } else {
        $error = '<div class="alert"><strong>Error!</strong> Unable to update message remarks</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message Remarks</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/pg-logo.png">
</head>
<body>
    <div class="container">
        <?php include 'nav.php'; ?>
        <?php echo $error; ?>
        <?php echo $success; ?>
        <h1 style="margin-top: 10px; margin-left: 30px;">Edit Message Remarks</h1>
        <div class="container-2">
            <form action="" method="post">
                
                <?php 
                $sql ="select * from contact_us where id='$_GET[message_remark_upd]'";
                $rest=mysqli_query($conn, $sql); 
                $row = mysqli_fetch_assoc($rest);
                ?>

                <div class="row">
                    <div class="col-15">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-80">
                        <input readonly type="text" id="name" name="name" value="<?php echo $row['name']; ?>" style="background-color: #e8fafc;">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-15">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-80">
                        <input readonly type="text" id="email" name="email" value="<?php echo $row['email']; ?>" style="background-color: #e8fafc;">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-15">
                        <label for="phone">Contact No.</label>
                    </div>
                    <div class="col-80">
                        <input readonly type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" style="background-color: #e8fafc;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-15">
                        <label for="message">Message</label>
                    </div>
                    <div class="col-80">
                        <input readonly type="text" id="message" name="message" value="<?php echo $row['message']; ?>" style="background-color: #e8fafc;" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="datetime">Date Time</label>
                    </div>
                    <div class="col-80">
                        <input readonly type="text" id="datetime" name="datetime" value="<?php echo $row['datetime']; ?>" style="background-color: #e8fafc;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-15">
                        <label for="remarks">Remarks</label>
                    </div>
                    <div class="col-80">
                        <input type="text" id="remarks" name="remarks" value="<?php echo $row['remarks']; ?>" >
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-10">
                        <input type="submit" name="submit" value="Update">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-20">
                    <a href="message-list.php"><button class="btn-back">Back</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
