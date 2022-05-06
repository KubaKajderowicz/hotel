<?php

class ReservationController extends Dbh
{


    public function getOpenReservations()
    {

        $sql = "SELECT * FROM reservations WHERE booked IS NULL";

        if ($result = $this->connect()->query($sql)) {
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch()) {
                    // echo Result:
                    echo '<tr>
                        <th scope="row">' . $row['kamernummer'] . '</th>
                        <td>' . $row['van'] . '</td>
                        <td>' . $row['tot'] . '</td>
                        <td><a href="db/inc/reserve.inc.php?roomid=' . $row['id'] . '"><span class="fa fa-check-square"></span></a></td>
                        </tr>';
                }
            }
        }
    }

    public function createReservation($roomid, $userid)
    {
        // Check input errors before inserting in database
        if (!empty($roomid) && !empty($userid)) {

            $sql = "UPDATE reservations SET booked=1, bookedby=:userid WHERE id=:id";

            if ($stmt = $this->connect()->prepare($sql)) {

                // Bind params:
                $stmt->bindParam(":userid", $userid);
                $stmt->bindParam(":id", $roomid);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Records updated successfully. Redirect to landing page
                    header("location: ../../mijnreservatie.php");
                    exit();
                } else {
                    // Record update failed
                    header("location: ../../reserveer.php?error=stmtfailed");
                    exit();
                }
            }
        }
    }

    public function getUserReservation($userid)
    {
        // Prepare a select statement
        $sql = "SELECT * FROM reservations WHERE bookedby = :id";

        if ($stmt = $this->connect()->prepare($sql)) {

            // Bind params;
            $stmt->bindParam(":id", $userid);

            if ($stmt->execute()) {

                if ($stmt->rowCount() > 0) {

                    // fetch reservation
                    while ($row = $stmt->fetch()) {

                        echo '<tr>
                        <th scope="row">' . $row['kamernummer'] . '</th>
                        <td>' . $row['van'] . '</td>
                        <td>' . $row['tot'] . '</td>
                        <a href="./editreservation.php?roomid=' . $row['id'] . '"><span class="fa fa-pencil"></span></a>
                        <a href="./db/inc/deleteReservation.inc.php?roomid=' . $row['id'] . '"><span class="fa fa-trash"></span></a></td>
                        </tr>';
                    }
                }
            }
        }
    }

    public function getAllReservations()
    {
        // Prepare a select statement
        $sql = "SELECT * FROM reservations WHERE booked IS NOT NULL";

        if ($stmt = $this->connect()->prepare($sql)) {

            if ($stmt->execute()) {

                if ($stmt->rowCount() > 0) {
                    // fetch reservation
                    while ($row = $stmt->fetch()) {

                        echo '<tr>
                        <th scope="row">' . $row['kamernummer'] . '</th>
                        <td>' . $row['van'] . '</td>
                        <td>' . $row['tot'] . '</td>
                        <a href="./editreservation.php?roomid=' . $row['id'] . '"><span class="fa fa-pencil"></span></a>
                        <a href="./db/inc/deleteReservation.inc.php?roomid=' . $row['id'] . '"><span class="fa fa-trash"></span></a></td>
                        </tr>';
                    }
                }
            }
        }
    }

    public function getReservationToForm($roomid)
    {
        // Prepare a select statement
        $sql = "SELECT * FROM reservations WHERE id = :id";

        if ($stmt = $this->connect()->prepare($sql)) {

            //bind params;
            $stmt->bindParam(":id", $roomid);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $id = $row['id'];
                    $van = $row['van'];
                    $tot = $row['tot'];

                    echo '<input type="hidden" name="id"  value="' . $id . '">
                    <div class="form-group">
                </div>
                <div class="form-group">
                    <label>Van</label>
                    <input type="date" name="van" class="form-control" value="' . $van . '"></input>
                    <span class="invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label>Tot</label>
                    <input type="date" name="tot" class="form-control" value="' . $tot . '">
                    <span class="invalid-feedback"></span>
                </div>';
                }
            }
        }
    }

    public function updateReservation($roomid, $van, $tot)
    {
        // Check input errors before inserting in database
        if (!empty($roomid) && !empty($van) && !empty($tot)) {
            // Prepare an update statement
            $sql = "UPDATE reservations SET van=:van, tot=:tot WHERE id=:roomid";

            if ($stmt = $this->connect()->prepare($sql)) {

                // bind params:
                $stmt->bindParam(":van", $van);
                $stmt->bindParam(":tot", $tot);
                $stmt->bindParam(":roomid", $roomid);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    session_start();
                    // Records updated successfully. Redirect to landing page
                    if (!isset($_SESSION['employee'])) {
                        header("location: ../../mijnreservatie.php");
                        exit();
                    } else {
                        header("location: ../../bookedrooms.php");
                        exit();
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
    }

    public function deleteReservation($id)
    {
        // Prepare an update statement
        $sql = "UPDATE reservations SET booked=NULL, bookedby=NULL WHERE id=:id";

        if ($stmt = $this->connect()->prepare($sql)) {

            // bind params:
            $stmt->bindParam(":id", $id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                session_start();
                // Records updated successfully. Redirect to landing page
                if (!isset($_SESSION['employee'])) {
                    header("location: ../../mijnreservatie.php");
                    exit();
                } else {
                    header("location: ../../bookedrooms.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }

    public function lowRoomWarning()
    {
        $sql = "SELECT * FROM reservations WHERE booked IS NULL";

        if ($stmt = $this->connect()->prepare($sql)) {
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 2) {
                    // Do nothing.
                } else {
                    //echo warning
                    echo '<div class="d-flex justify-content-center m-5 p-7">
                    <div class="toast align-items-center text-white bg-danger border-0 d-flex" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                Er zijn minder dan 2 kamers over!
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
        }
    }
}
