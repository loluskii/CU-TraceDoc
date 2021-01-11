<?php 
include('config.php');
session_start();


if (!isset($_SESSION['id'])) {
    header('location: ../login.php');
}

$user_id="";
if (isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    
    
}

if (isset($_SESSION['user_name'])){
    $user_name = $_SESSION['user_name'];
 
}

if (isset($_SESSION['user_type'])){
    $user_type = $_SESSION['user_type'];
    
 
}


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['user_name']);
    header("location: ../login.php");
}
?>