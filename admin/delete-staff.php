<?php 

include("../connect/config.php");

$id = $_GET['id'];
$sql = "DELETE FROM staffs WHERE id=$id";
$res = mysqli_query($conn, $sql);
header("refresh:1; url=staff-list.php"); 

?>