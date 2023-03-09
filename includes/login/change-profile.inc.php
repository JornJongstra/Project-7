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

if (!isset($_POST['submit-profile-change'])) {
    header("location: ../../front-end/login/profile/profile.php?note=FormNotSend");
    exit();
} else {
    $newfirstname = $_POST['newfirstname'];
    $newlastname = $_POST['newlastname'];
    $newemail = $_POST['newemail'];
    $newphonenumber = $_POST['newphonenumber'];
    $newaddress = $_POST['newaddress'];
    $newzipcode = $_POST['newzipcode'];
    $newlocation = $_POST['newlocation'];
    $password = $_POST['password'];
}

if (emptyInputChange($newfirstname, $newlastname, $newemail, $newphonenumber, $password) !== false) {
    header("location: ../../front-end/login/profile/profile.php?note=emptyinput");
    exit();
}
if (invalidPhoneNumber($newphonenumber) !== false) {
    header("location: ../../front-end/login/profile/profile.php?note=invalidPhoneNumber");
    exit();
}
if (invalidEmail($newemail) !== false) {
    header("location: ../../front-end/login/profile/profile.php?note=invalidemail");
    exit();
}
// if (samePassword($oldpassword, $newpassword) !== false) {
//     header("location: ../../front-end/login/profile/profile.php?note=samePassword");
//     exit();
// }

if (emailIsSame($newemail, $email)) {
    accountWijzigen($conn, $user_id, $email, $newfirstname, $newlastname, $newemail, $newphonenumber, $newaddress, $newzipcode, $newlocation, $password);
    header("location: ../../front-end/login/profile/profile.php?note=acountgewijzigd");
    exit();
} else {
    if (emailExists($conn, $newemail) !== false) {
        header("location: ../../front-end/login/profile/profile.php?note=emailtaken");
        exit();
    } else {
        accountWijzigen($conn, $user_id, $email, $newfirstname, $newlastname, $newemail, $newphonenumber, $newaddress, $newzipcode, $newlocation, $password);
        header("location: ../../front-end/login/profile/profile.php?note=acountgewijzigd");
        exit();
    }
}
