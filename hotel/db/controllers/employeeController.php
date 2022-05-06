<?php


class EmployeeController extends Dbh
{
    /* Public Functions */
    public function login($email, $password)
    {

        $validatedEmail = $this->validateEmail($email);

        $this->loginUser($validatedEmail, $password);
    }


    /* DB EVENTS */
    private function loginUser($email, $inputpassword)
    {

        $sql = "SELECT password FROM employees WHERE email = :email";

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
                        $stmt = $this->connect()->prepare('SELECT * FROM employees WHERE email = :email AND password = :pass;');

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
                            //For Employee set special session:
                            $_SESSION['employee'] = 1;
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
                    header("location: ../../mlogin.php?error=nouser");
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
