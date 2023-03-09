<?php
include_once '../../algemeen/header.php';
?>
<link rel="stylesheet" href="../../../css/login.css">

<?php
if (!isset($_SESSION['userid'])) {
    header("location: ../login.php?note=notLoggedIn");
    exit();
} else {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $address = $_SESSION['address'];
    $zipcode = $_SESSION['zipcode'];
    $location = $_SESSION['location'];
}
?>

<div class="bg-light py-5 px-4 px-md-5 container-fluid" style="height: 100vh;">
    <div class="container">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            <div class="col">
                <h3 class="fw-bolder mb-3">Gegevens wijzigen</h3>
                <section class="bg-secondary text-white p-4 mb-5" style="max-width: 75%;">
                    <h1>Hallo, <?= $firstname ?></h1>
                    <p class="display-6">Hier kunt u alle gegevens wijzigen</p>
                </section>
                <form action="../../../includes/login/change-profile.inc.php" method="post" autocomplete="off" style="max-width: 75%;">
                    <div class="form mb-3 row">
                        <div class="col">
                            <input class="form-control col-2" name="newfirstname" type="text" placeholder="Voornaam...*" value="<?= $firstname ?>" />
                        </div>
                        <div class="col">
                            <input class="form-control col-2" name="newlastname" type="text" placeholder="Achternaam...*" value="<?= $lastname ?>" />
                        </div>
                    </div>
                    <div class="form mb-3 row">
                        <div class="col">
                            <input class="form-control" name="newemail" type="text" placeholder="Email...*" value="<?= $email ?>" />
                        </div>
                        <div class="col">
                            <input class="form-control" name="newphonenumber" type="text" placeholder="Telefoonnummer...*" value="<?= $phone ?>" />
                        </div>
                    </div>
                    <div class="form mb-3 row">
                        <div class="col">
                            <input class="form-control" name="newaddress" type="text" placeholder="Adres..." value="<?= $address ?>" />
                        </div>
                        <div class="col">
                            <input class="form-control" name="newzipcode" type="text" placeholder="Postcode..." value="<?= $zipcode ?>" />
                        </div>
                        <div class="col">
                            <input class="form-control" name="newlocation" type="text" placeholder="Plaats..." value="<?= $location ?>" />
                        </div>
                    </div>
                    <div class="form mb-3 row">
                        <div class="col mb-5">
                            <input class="form-control" name="password" type="password" placeholder="Wachtwoord...*" />
                        </div>
                    </div>
                    <div class="d-grid mb-3"><button class="btn btnLogin btn-lg" name="submit-profile-change" type="submit">Bewaren</button></div>
                </form>
                <a href="change-password.php" class="noTextDecoration mb-3">
                    <div class="d-grid mb-3" style="max-width: 75%;">
                        <button class="btn btnLogin btn-lg">Wachtwoord wijzigen</button>
                    </div>
                </a>
                <a href="overview.php" class="noTextDecoration">
                    <div class="d-grid" style="max-width: 75%;">
                        <button class="btn btnLogin btn-lg">Annuleren</button>
                    </div>
                </a>
                <div class="text-center pt-3" style="max-width: 75%;">* Verplicht veld!</div>
                <?php
                if (isset($_GET["note"])) {
                    if ($_GET["note"] == "emptyinput") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Vul alle velden in!</div>';
                    } else if ($_GET["note"] == "wronglogin") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Incorrecte login!</div>';
                    } else if ($_GET["note"] == "succes") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Account is succesvol gewijzigd</div>';
                    } else if ($_GET["note"] == "stmtfailed") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Er is iets fout gegaan</div>';
                    } else if ($_GET["note"] == "samePassword") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Je nieuwe wachtwoord mag niet overeen komen met vorig wachtwoord!</div>';
                    } else if ($_GET["note"] == "invalidPhoneNumber") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Voer een geldig telefoonnummber in!</div>';
                    } else if ($_GET["note"] == "wrongPwd") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Wachtwoord is incorrect!</div>';
                    } else if ($_GET["note"] == "succesPassword") {
                        echo '<div class="ErrorMessage" style="max-width: 75%;">Wachtwoord is succesvol gewijzigd</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../algemeen/footer.php';
?>