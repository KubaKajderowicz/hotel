<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel</title>
</head>

<body>

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Hotel Duinen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end m-3" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Login
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="login.php">login</a></li>
                                <li><a class="dropdown-item" href="mlogin.php">login Medewerkers</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="card w-50 p-5 m-5">
            <form action="./db/inc/singup.inc.php" method="POST">
                <div class="mb-3">
                    <label for="InputName" class="form-label">Uw naam:</label>
                    <input type="text" class="form-control" id="InputName" name="name" aria-describedby="nameHelp" required>
                </div>
                <div class="mb-3">
                    <label for="InputEmail" class="form-label">Uw email:</label>
                    <input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">Wij delen uw email niet met derden.</div>
                </div>
                <div class="mb-3">
                    <label for="InputPassword" class="form-label">Wachtwoord</label>
                    <input type="password" name="pass" class="form-control" id="InputPassword">
                </div>
                <div class="mb-3">
                    <label for="InputConfirmPass" class="form-label">Bevestig uw wachtwoord</label>
                    <input type="password" name="passconfirm" class="form-control" id="InputConfirmPass">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>