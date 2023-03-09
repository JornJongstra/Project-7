<?php

if (isset($_POST['reset-password-submit'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    if (empty($password) || empty($passwordRepeat)) {
        header("location: ../../front-end/login/create-new-password.php?note=empty&selector=$selector&validator=$validator");
        exit();
    } else if ($password != $passwordRepeat) {
        header("location: ../../front-end/login/create-new-password.php?note=pwdnotsame&selector=$selector&validator=$validator");
        exit();
    }

    require '../algemeen/dbh.inc.php';

    $sql = "SELECT * FROM pwdReset WHERE selector=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../front-end/login/create-new-password.php?note=stmtfailed1&selector=$selector&validator=$validator");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            header("location: ../../front-end/login/create-new-password.php?note=stmtfailed2&selector=$selector&validator=$validator");
            exit();
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["token"]);
            if ($tokenCheck === false) {
                header("location: ../../front-end/login/create-new-password.php?note=stmtfailed3&selector=$selector&validator=$validator");
                exit();
            } elseif ($tokenCheck === true) {
                $tokenEmail = $row['email'];
                $sql = "SELECT * FROM users WHERE email=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: ../../front-end/login/create-new-password.php?note=stmtfailed4&selector=$selector&validator=$validator");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)) {
                        header("location: ../../front-end/login/create-new-password.php?note=stmtfailed5&selector=$selector&validator=$validator");
                        exit();
                    } else {
                        $sql = "UPDATE users SET password=? WHERE email=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("location: ../../front-end/login/create-new-password.php?note=stmtfailed6&selector=$selector&validator=$validator");
                            exit();
                        } else {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE email=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("location: ../../front-end/login/create-new-password.php?note=stmtfailed7&selector=$selector&validator=$validator");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("location: ../../front-end/login/login.php?note=passwordupdated");
                            }
                        }
                    }
                }
            }
        }
    }

} else {
    header("location: ../../front-end/algemeen/index.php");
}