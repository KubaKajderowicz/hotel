<?php

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['pass'];

    include_once('../dbh.php');
    include_once('../controllers/employeeController.php');

    $employeeController = new EmployeeController;
    $employeeController->login($email,$password);
}