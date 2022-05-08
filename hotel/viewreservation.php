<?php

session_start();

// if user not logged as EMPLOYEE in return to login page
if (!isset($_SESSION['employee'])) {
    header("Location: ./login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel</title>
</head>

<body>

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Hotel Duinen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end m-3" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <?php
                        if (isset($_SESSION['employee'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="beheer.php">Beheer</a>
                            </li>
                        <?php }
                        if (!isset($_SESSION['userid'])) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Login
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="login.php">login</a></li>
                                    <li><a class="dropdown-item" href="mlogin.php">login Medewerkers</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="mijnreservatie.php">Mijn Reservatie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="reserveer.php">Reserveer Kamer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="db/inc/logout.inc.php">uitloggen</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="conatiner d-flex justify-content-center">
        <div class="card m-5 p-5">
            <h4>Klant Reservatie: </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Reservatie ID</th>
                        <th scope="col">Kamernummer</th>
                        <th scope="col">Door</th>
                        <th scope="col">Van:</th>
                        <th scope="col">Tot:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once './db/dbh.php';
                    include_once './db/controllers/reservationController.php';

                    $resController = new ReservationController;
                    $resController->getReservationInfo($_GET['roomid']);
                    ?>
                </tbody>
            </table>
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>