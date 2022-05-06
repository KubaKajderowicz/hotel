<?php

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $van = $_POST['van'];
    $tot = $_POST['tot'];

    include_once('../dbh.php');
    include_once('../controllers/reservationController.php');

    $reservationController = new ReservationController();

    $reservationController->updateReservation($id,$van,$tot);
}
