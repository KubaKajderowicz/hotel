<?php
session_start();

if (isset($_GET['roomid'])) {

    $roomid = $_GET['roomid'];
    $userid = $_SESSION['userid'];

    // vertify that request is done by the user logged in
    if (empty($userid) || $userid == NULL) {
        // return with error
        header("Location: ../../reserveer.php?error=noid");
        exit();
    } else {
        // else continue to make reservation:

        include_once('../dbh.php');
        include_once('../controllers/reservationController.php');

        $reservationController = new ReservationController;
        $reservationController->createReservation($roomid, $userid);
    }
}
