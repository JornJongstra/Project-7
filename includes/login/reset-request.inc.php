<?php

if(isset($_POST['reset-request-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/project7/front-end/login/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require '../algemeen/dbh.inc.php';

    $userEmail = $_POST['email'];

    $sql = "DELETE FROM pwdReset WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../front-end/login/reset-password.php?note=stmtfailed');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (email, selector, token, expires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../front-end/login/reset-password.php?note=stmtfailed');
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $to = $userEmail;

    $subject = 'Reset je wachtwoord voor Bon Temps';

    $message = '<p>We hebben een aanvraag gekregen voor een wachtwoord reset. Klik op de link om je wachtwoord aan te passen, als deze mail niet voor jou is bestemd kan je deze negeren.</p>';
    $message .= '<p>Hier heb je de link voor het resetten van je wachtwoord: </br>';
    $message .= '<a href="' . $url . '">' . $url . '</a></p>';

    $headers = "From: Bon Temps <project.666@yahoo.com>\r\n";
    $headers .= "Reply-To: project.666@yahoo.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header('location: ../../front-end/login/reset-password.php?note=succes');

} else {
    header('location: ../../front-end/algemeen/index.php');
}