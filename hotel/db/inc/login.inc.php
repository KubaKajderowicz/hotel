<?php

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['pass'];

    include_once('../dbh.php');
    include_once('../controllers/customerController.php');

  
    $customerController = new CustomerController;
    $customerController->login($email,$password);
}