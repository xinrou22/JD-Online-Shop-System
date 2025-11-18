<?php
      // session_start();
      // session_destroy();
      // header("Location: ../index.php");

// customer_logout.php
      session_start();
      unset($_SESSION['cusID']);
      header("Location: ../index.php");
      exit();
?>