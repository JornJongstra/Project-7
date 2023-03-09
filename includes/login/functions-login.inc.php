<?php

function emptyInputSignup($firstName, $lastName, $email, $phoneNumber, $pwd, $pwdRepeat)
{
    $result = false;
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidPhoneNumber($phoneNumber)
{
    if (preg_match('/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])$/', $phoneNumber)) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat)
{
    $result = false;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/signup.php?note=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $firstName, $lastName, $email, $phoneNumber, $address, $zipCode, $location, $pwd, $userLevel)
{
    $sql = "INSERT INTO users (firstname, lastname, email, phone, password, userlevel, address, zipcode, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/signup.php?note=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssisss", $firstName, $lastName, $email, $phoneNumber, $hashedPwd, $userLevel, $address, $zipCode, $location);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    $emailExists = emailExists($conn, $email);

    $_SESSION['userid'] = $emailExists["id"];
    $_SESSION['userlevel'] = $emailExists["userlevel"];
    $_SESSION['firstname'] = $emailExists["firstname"];
    $_SESSION['lastname'] = $emailExists["lastname"];
    $_SESSION['email'] = $emailExists["email"];
    $_SESSION['phone'] = $emailExists["phone"];
    $_SESSION['address'] = $emailExists["address"];
    $_SESSION['zipcode'] = $emailExists["zipcode"];
    $_SESSION['location'] = $emailExists["city"];
}

function emptyInputLogin($emailLogin, $pwd)
{
    $result = false;
    if (empty($emailLogin) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $emailLogin, $pwd)
{
    $emailExists = emailExists($conn, $emailLogin);

    if ($emailExists === false) {
        header("location: ../../front-end/login/login.php?note=wronglogin");
        exit();
    }

    $pwdHashed = $emailExists["password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../../front-end/login/login.php?note=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION['userid'] = $emailExists["id"];
        $_SESSION['userlevel'] = $emailExists["userlevel"];
        $_SESSION['firstname'] = $emailExists["firstname"];
        $_SESSION['lastname'] = $emailExists["lastname"];
        $_SESSION['email'] = $emailExists["email"];
        $_SESSION['phone'] = $emailExists["phone"];
        $_SESSION['address'] = $emailExists["address"];
        $_SESSION['zipcode'] = $emailExists["zipcode"];
        $_SESSION['location'] = $emailExists["city"];
        header("location: ../../front-end/algemeen/index.php?note=loginsucces");
        exit();
    }
}

function emptyInputChange($newfirstname, $newlastname, $newemail, $newphonenumber, $password)
{
    $result = false;
    if (empty($newfirstname) || empty($newlastname) || empty($newemail) || empty($newphonenumber) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailIsSame($newemail, $email)
{
    if ($newemail == $email) {
        return true;
    } else {
        return false;
    }
}

function accountWijzigen($conn, $user_id, $email, $newfirstname, $newlastname, $newemail, $newphonenumber, $newaddress, $newzipcode, $newlocation, $password)
{
    $emailExists = emailExists($conn, $email);

    $pwdHashed = $emailExists["password"];
    $checkPwd = password_verify($password, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../../front-end/login/profile/profile.php?note=wrongPwd");
        exit();
    } else if ($checkPwd === true) {
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, address = ?, zipcode = ?, city = ? WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../../front-end/login/profile/profile.php?note=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sssssssi", $newfirstname, $newlastname, $newemail, $newphonenumber, $newaddress, $newzipcode, $newlocation, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $emailExists = emailExists($conn, $email);
        session_start();

        $_SESSION['userid'] = $emailExists["id"];
        $_SESSION['userlevel'] = $emailExists["userlevel"];
        $_SESSION['firstname'] = $emailExists["firstname"];
        $_SESSION['lastname'] = $emailExists["lastname"];
        $_SESSION['email'] = $emailExists["email"];
        $_SESSION['phone'] = $emailExists["phone"];
        $_SESSION['address'] = $emailExists["address"];
        $_SESSION['zipcode'] = $emailExists["zipcode"];
        $_SESSION['location'] = $emailExists["city"];

        header("location: ../../front-end/login/profile/profile.php?note=succes");
        exit();
    }
}

function emptyInputPasswordChange($password, $newpassword, $checknewpassword)
{
    $result = false;
    if (empty($password) || empty($newpassword) || empty($checknewpassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function samePassword($password, $newpassword)
{
    if ($password == $newpassword) {
        return true;
    } else {
        return false;
    }
}

function newPasswordCheck($newpassword, $checknewpassword)
{
    if ($newpassword == $checknewpassword) {
        return false;
    } else {
        return true;
    }
}

function wachtwoordWijzigen($conn, $user_id, $email, $password, $newpassword)
{
    $emailExists = emailExists($conn, $email);

    $pwdHashed = $emailExists["password"];
    $checkPwd = password_verify($password, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../../front-end/login/profile/change-password.php?note=wrongPwd");
        exit();
    } else if ($checkPwd === true) {
        $sql = "UPDATE users SET password = ? WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../../front-end/login/profile/change-password.php?note=stmtfailed");
            exit();
        }

        $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../../front-end/login/profile/profile.php?note=succesPassword");
        exit();
    }
}

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function emptyInputEmployeeSignup($firstName, $lastName, $email, $phoneNumber)
{
    $result = false;
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createEmployee($conn, $firstName, $lastName, $email, $phoneNumber, $address, $zipCode, $location, $pwd, $userLevel)
{
    $sql = "INSERT INTO users (firstname, lastname, email, phone, password, userlevel, address, zipcode, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/signup.php?note=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssisss", $firstName, $lastName, $email, $phoneNumber, $hashedPwd, $userLevel, $address, $zipCode, $location);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getReservationsUser($conn, $userId)
{
    $sql = "    SELECT date, quantity, starttijd, eindtijd, id
                FROM reservations
                WHERE userid = ?
                ORDER BY date DESC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/profile/orders.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function getReservationsMenu($conn, $reservationsId)
{
    $sql = "    SELECT m.name
                From koppel_res_menu_dish k, menus m
                Where k.reservationid = ?
                And k.menuid = m.id
                And k.dishid = (select MIN(dishid)
                                From koppel_dishes_menus d
                                Where d.menuid = m.id);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/profile/orders.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $reservationsId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function getReservationsUser2($conn, $userid)
{
    $sql = "SELECT date, quantity, starttijd, eindtijd, id
            FROM reservations
            WHERE userid = ?
            ORDER BY date DESC LIMIT 2;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/profile/orders.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function getUsers($conn)
{
    $sql = "SELECT *
            FROM users
            WHERE userlevel = 2;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/profile/orders.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function emptyInputCustomerSignup($userid, $quantity, $date, $starttime) {
    if (empty($userid) || empty($quantity) || empty($date) || empty($starttime)) {
        return true;
    } else {
        return false;
    }
}

function getMenus($conn) {
    $sql = "SELECT *
            FROM menus;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/profile/orders.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function getReservation($conn, $reservationId) {
    $sql = "SELECT *
            FROM reservations
            WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/phone-reservation/result.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $reservationId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function getUser($conn, $userId)
{
    $sql = "SELECT *
            FROM users
            WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/phone-reservation/result.php?note=data-ophalen-mislukt");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}