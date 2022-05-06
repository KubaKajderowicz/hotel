<?php

if (isset($_GET["roomid"])) {
    $id = $_GET['roomid'];

    include_once('../dbh.php');
    include_once('../controllers/reservationController.php');

    $reservationController = new ReservationController();

    $reservationController->deleteReservation($id);
}
