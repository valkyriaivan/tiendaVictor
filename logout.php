<?php
  session_start();
  session_unset();
  session_destroy();
  if (isset($_GET["redirect"])){
    header('location: ' . urldecode($_GET["redirect"]));
  }else
    header("location: index.php");
?>
