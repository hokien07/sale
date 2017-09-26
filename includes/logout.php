<?php include('mysqli_connect.php'); ?>
<?php include('function.php'); ?>
<?php
session_start();
session_unset();
session_destroy();
header("location:../index.php");
?>