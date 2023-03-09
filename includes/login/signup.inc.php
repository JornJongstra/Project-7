<?php

if (isset($_POST["submit"])) {

    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phonenumber"];
    $adress = $_POST["address"];
    $zipCode = $_POST["zipcode"];
    $location = $_POST["location"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    $userLevel = 2;

    require_once '../algemeen/dbh.inc.php';
    require_once 'functions-login.inc.php';

    if (emptyInputSignup($firstName, $lastName, $email, $phoneNumber, $pwd, $pwdRepeat) !== false) {
        header("location: ../../front-end/login/signup.php?note=emptyinput");
        exit();
    }
    if (invalidPhoneNumber($phoneNumber) !== false) {
        header("location: ../../front-end/login/signup.php?note=invalidPhoneNumber");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../../front-end/login/signup.php?note=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../../front-end/login/signup.php?note=passworddontmatch");
        exit();
    }
    if (emailExists($conn, $email) !== false) {
        header("location: ../../front-end/login/signup.php?note=emailtaken");
        exit();
    }

    createUser($conn, $firstName, $lastName, $email, $phoneNumber, $adress, $zipCode, $location, $pwd, $userLevel);
    header("location: ../../front-end/algemeen/index.php?note=succes");
    exit();
} else {
    header("location: ../../front-end/algemeen/index.php");
    exit();
}