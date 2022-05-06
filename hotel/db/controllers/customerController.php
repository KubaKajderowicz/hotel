<?php


class CustomerController extends Dbh
{
    /* Public Functions */

    // This function gets called by inc.
    public function signup($name, $email, $pass, $passconfirm)
    {

        // Return validated Name
        $validatedname = $this->validateName($name);

        // Return validated Email
        $validatedemail = $this->validateEmail($email);

        // Return validated & Hashed Pass
        $hashedPass = $this->validatePass($pass, $passconfirm);

        // Check if email is not in use 
        if ($this->isUnique($validatedemail)) {
            // if we got here create user...
            $this->createUser($validatedname, $validatedemail, $hashedPass);
        } else {
            // return with in use error
            header("location: ../../index.php?error=emailused");
            exit();
        }
    }

    public function login($email, $password)
    {

        $validatedEmail = $this->validateEmail($email);

        $this->loginUser($validatedEmail, $password);
    }


    /* DB EVENTS */

    // enter user into DB 
    private function createUser($name, $email, $hashedpass)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)";

        // Prepare stmt
        if ($stmt = $this->connect()->prepare($sql)) {

            // Bind Params
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pass", $hashedpass);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // If successfull return to login page...
                unset($stmt);
                header("location: ../../login.php");
                exit();
            } else {
                // Return to register with error
                unset($stmt);
                header("location: ../../register.php?error=regfailed");
                exit();
            }
        }
    }

    private function loginUser($email, $inputpassword)
    {

        $sql = "SELECT password FROM users WHERE email = :email";

        if ($stmt = $this->connect()->prepare($sql)) {

            // Bind Param:
            $stmt->bindParam("email", $email);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    // if we receive result:
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($inputpassword, $row['password'])) {
                        // If we got here password is correct.

                        // Unset previous stmt
                        unset($stmt);

                        // prepare stmt
                        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = :email AND password = :pass;');

                        // bind params
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":pass", $row['password']);

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {

                            // if successfull:
                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            // Continue to create session and assign info
                            session_start();
                            $_SESSION['userid'] = $row[0]['id'];
                            unset($stmt);
                            header("location: ../../index.php?login=success");
                        }
                    } else {
                        unset($stmt);
                        // incorrect password.
                        header("location: ../../login.php?error=invalidpass");
                        exit();
                    }
                } else {
                    unset($stmt);
                    header("location: ../../login.php?error=nouser");
                    exit();
                }
            } else {
                unset($stmt);
                header("location: ../../login.php?error=nouser");
                exit();
            }
        }
    }

    /* VALIDATION  */
    // Check if email is valid
    private function validateName($input)
    {
        // Trim user input
        $input_name = trim($input);
        if (empty($input_name)) {
            // Invalid name return with error.
            header("location: ../../index.php?error=invalidname");
            exit();
        } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
            // Invalid name return with error.
            header("location: ../../index.php?error=invalidname");
            exit();
        } else {
            return $input_name;
        }
    }

    // Check if email is valid
    private function validateEmail($input)
    {
        // Trim user input
        $input_email = trim($input);

        // validate email using PHP filter.
        if (filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
            // If correct:
            return $input_email;
        } else {
            // Invalid name return with error.
            header("location: ../../index.php?error=invalidemail");
            exit();
        }
    }

    // Check if Email has been used before
    private function isUnique($input)
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        if ($stmt = $this->connect()->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $input);

            // Attempt to execute:
            if ($stmt->execute()) {
                if ($stmt->rowCount() >= 1) {
                    // if we have more than 1 or more entries email is in use
                    unset($stmt);
                    return false;
                } else {
                    // Else no rows returned so email is not in use...
                    unset($stmt);
                    return true;
                }
            }
        }
    }

    // Check if Pass is correct and repeated correctly
    private function validatePass($input, $confirminput)
    {
        if ($input !== $confirminput) {
            // if input not equal
            header("location: ../../index.php?error=passmissmatch");
            exit();
        } else {
            // Otherwise hash the pass and return.
            $hashed = password_hash($input, PASSWORD_DEFAULT);
            return $hashed;
        }
    }
}
