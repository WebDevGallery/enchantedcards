<?php
session_start();

include("connection.php"); // Database connection

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit; // Ensure the script stops after redirection
}
?>

