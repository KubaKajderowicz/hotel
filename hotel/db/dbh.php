<?php

class Dbh
{

    // Use connect() to connect and send stmt to db.
    protected function connect()
    {
        try {
            $username = "root";
            $password = "";
            $dbname = "hotel";
            $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
