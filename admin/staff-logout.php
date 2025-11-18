<?php 

// session_start();
// session_destroy();

// header("Location: index.php");



// admin_logout.php
session_start();
unset($_SESSION['id']);
header("Location: index.php");
exit();

?>