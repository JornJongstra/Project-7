<?php
session_start();

if (isset($_POST["submit-employee-signup"])) {

    require_once '../algemeen/dbh.inc.php';
    require_once 'functions-login.inc.php';

    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phonenumber"];
    $adress = $_POST["address"];
    $zipCode = $_POST["zipcode"];
    $location = $_POST["location"];
    $pwd = generateRandomString(30);

    $userLevel = 4;

    if (emptyInputEmployeeSignup($firstName, $lastName, $email, $phoneNumber) !== false) {
        header("location: ../../front-end/login/employee-signup.php?note=emptyinput");
        exit();
    }
    if (invalidPhoneNumber($phoneNumber) !== false) {
        header("location: ../../front-end/login/employee-signup.php?note=invalidPhoneNumber");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../../front-end/login/employee-signup.php?note=invalidemail");
        exit();
    }
    if (emailExists($conn, $email) !== false) {
        header("location: ../../front-end/login/employee-signup.php?note=emailtaken");
        exit();
    }

    if ($_SESSION['userlevel'] !== 5) {
        header("location: ../../front-end/algemeen/index.php");
        exit();
    } else {
        createEmployee($conn, $firstName, $lastName, $email, $phoneNumber, $adress, $zipCode, $location, $pwd, $userLevel);
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $url = "localhost/project7/front-end/login/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

        require '../algemeen/dbh.inc.php';

        $userEmail = $_POST['email'];

        $sql = "DELETE FROM pwdReset WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('location: ../../front-end/login/reset-password.php?note=stmtfailed');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }

        $sql = "INSERT INTO pwdReset (email, selector, token) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('location: ../../front-end/login/reset-password.php?note=stmtfailed');
            exit();
        } else {
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sss", $userEmail, $selector, $hashedToken);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $to = $userEmail;

        $subject = 'Nieuw account Bon Temps Medewerker';

        $message = '<p>We hebben een account voor je aangemaakt met een automatisch wachtwoord. Klik op de link om meteen je wachtwoord aan te passen en je account te activeren, als deze mail niet voor jou is bestemd kan je deze negeren.</p>';
        $message .= '<p>Hier heb je de link voor het resetten van je wachtwoord: </br>';
        $message .= '<a href="' . $url . '">' . $url . '</a></p>';

        $headers = "From: Bon Temps <project.666@yahoo.com>\r\n";
        $headers .= "Reply-To: project.666@yahoo.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);
        header("location: ../../front-end/algemeen/index.php?note=accountAangemaakt");
        exit();
    }

} else {
    header("location: ../../front-end/algemeen/index.php");
    exit();
}
