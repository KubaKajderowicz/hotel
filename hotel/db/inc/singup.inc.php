<?php

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $passwordconfirm = $_POST['passconfirm'];

    include_once('../dbh.php');
    include_once('../controllers/customerController.php');

    $createUser = new CustomerController;
    $createUser->signup($name,$email,$password,$passwordconfirm);
}