<?php
session_start();

if (isset($_POST["submit-customer-signup"])) {

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

    $userLevel = 2;

    if (emptyInputEmployeeSignup($firstName, $lastName, $email, $phoneNumber) !== false) {
        header("location: ../../front-end/login/phone-reservation/customer-signup.php?note=emptyinput");
        exit();
    }
    if (invalidPhoneNumber($phoneNumber) !== false) {
        header("location: ../../front-end/login/phone-reservation/customer-signup.php?note=invalidPhoneNumber");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../../front-end/login/phone-reservation/customer-signup.php?note=invalidemail");
        exit();
    }
    if (emailExists($conn, $email) !== false) {
        header("location: ../../front-end/login/phone-reservation/customer-signup.php?note=emailtaken");
        exit();
    }

    if (($_SESSION['userlevel'] !== 4 or !$_SESSION['userlevel'] !== 5) and !isset($_SESSION['userid'])) {
        header("location: ../../front-end/algemeen/index.php");
        exit();
    } else {
        createEmployee($conn, $firstName, $lastName, $email, $phoneNumber, $adress, $zipCode, $location, $pwd, $userLevel);

        // $userid[] = emailExists($conn, $email);
        // var_dump($userid);

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

        $to = $userEmail;

        $subject = 'Nieuw account Bon Temps';

        $message = '<p>We hebben een account voor je aangemaakt met een automatisch wachtwoord. Klik op de link om meteen je wachtwoord aan te passen en je account te activeren, als deze mail niet voor jou is bestemd kan je deze negeren.</p>';
        $message .= '<p>Hier heb je de link voor het resetten van je wachtwoord: </br>';
        $message .= '<a href="' . $url . '">' . $url . '</a></p>';

        $headers = "From: Bon Temps <project.666@yahoo.com>\r\n";
        $headers .= "Reply-To: project.666@yahoo.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);
        $userid = emailExists($conn, $email);
        header('location: ../../front-end/login/phone-reservation/reservation.php?userid=' . $userid['id']);
        exit();
    }
} else if (isset($_POST["submit-reservation"])) {

    require_once '../algemeen/dbh.inc.php';
    require_once 'functions-login.inc.php';
    include '../reserveren/function.inc.php';

    // Variabelen definieren
    $userid = $_GET['userid'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $starttime = date('H:i:s', strtotime($_POST['hour'] . ":" . $_POST['minutes'] . ":" . "00"));

    if (emptyInputCustomerSignup($userid, $quantity, $date, $starttime) !== false) {
        header("location: ../../front-end/login/phone-reservation/reservation.php?userid=$userid&note=emptyinput");
        exit();
    }

    //Variables valideren
    if ($quantity <= 3) {
        header("location: ../../front-end/login/phone-reservation/reservation.php?userid=$userid&note=twp");
        exit();
    }

    //kijk of er nog ruimte is die dag
    if (calculateRoom($quantity, $date, $conn) != true) {
        header("Location: ../../front-end/login/phone-reservation/reservation.php?userid=$userid&note=noSpace");
        exit();
    }

    //roept de function createReservation en daarna doorsturen naar menu kiezen
    $resId = createReservation($conn, $userid, $quantity, $date, $starttime);
    header("Location: ../../front-end/login/phone-reservation/menu.php?resId=$resId&quantity=$quantity");
    exit();
} else if (isset($_POST["submit-menu"])) {

    require_once '../../includes/algemeen/dbh.inc.php';
    include '../reserveren/function.inc.php';
    include '../bediening/functions-bediening.inc.php';

    foreach($_POST['menu'] as $menu){
        if(!isset($_POST['menu'][$menu])){
            header("location: ../../front-end/login/phone-reservation/menu.php?resId=" . $_GET['resId'] . "&quantity=" . $_GET['quantity'] . "&note=emptyinput");
            exit();
        }
    }

    

    $quantity = count($_POST['menu']);
    $reservationId = intval($_GET['resId']);

    $i = 1;
    while ($i <= $quantity) {
        $menuId = intval($_POST['menu'][$i]);
        $dishes = getAllDishesFromMenu($conn, $menuId);
        while ($dish = $dishes->fetch_assoc()) {
            $result = insertMenuDishRes($conn, $dish['dishid'], $reservationId, $menuId);
            if ($result != true) {
                header("location: ../../front-end/login/phone-reservation/menu.php?note=sql");
                exit();
            } elseif ($result == true) {
            }
        }
        $i++;
    }
    header("location: ../../front-end/login/phone-reservation/result.php?note=succes&resId=$reservationId");
    exit();

} else {
    header("location: ../../front-end/algemeen/index.php");
    exit();
}
