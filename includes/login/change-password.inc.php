<?php
session_start();

include_once '../algemeen/dbh.inc.php';
include_once 'functions-login.inc.php';

if (!isset($_SESSION['userid'])) {
    header("location: ../../front-end/login/login.php?note=notLoggedIn");
    exit();
} else {
    $email = $_SESSION['email'];
    $user_id = $_SESSION['userid'];
}

if (!isset($_POST['submit-password-change'])) {
    header("location: ../../front-end/login/profile/change-password.php?note=FormNotSend");
    exit();
} else {
    $password = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $checknewpassword = $_POST['checknewpassword'];
}

if (emptyInputPasswordChange($password, $newpassword, $checknewpassword) !== false) {
    header("location: ../../front-end/login/profile/change-password.php?note=emptyinput");
    exit();
}

if (samePassword($password, $newpassword) !== false) {
    header("location: ../../front-end/login/profile/profile.php?note=samePassword");
    exit();
}

if (newPasswordCheck($newpassword, $checknewpassword) !== false) {
    header("location: ../../front-end/login/profile/profile.php?note=newPasswordCheck");
    exit();
}

wachtwoordWijzigen($conn, $user_id, $email, $password, $newpassword);
