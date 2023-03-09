<?php

if (isset($_POST["submit"])) {

    $emailLogin = $_POST["emaillogin"];
    $pwd = $_POST["pwd"];

    include '../algemeen/dbh.inc.php';
    include 'functions-login.inc.php';

    if (emptyInputLogin($emailLogin, $pwd) !== false) {
        header("location: ../../front-end/login/login.php?note=emptyinput");
        exit();
    }

    loginUser($conn, $emailLogin, $pwd);
} else {
    header("location: ../../front-end/login/login.php");
    exit();
}
