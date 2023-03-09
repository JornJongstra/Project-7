<?php
include_once '../algemeen/header.php';

if (isset($_SESSION['userid'])) {
    header("location: ../algemeen/index.php");
    exit();
}
?>
<link rel="stylesheet" href="../../css/login.css">

<div class="bg-light rounded-3 py-5 px-4 px-md-5 " style="height: 100vh;">
    <div class="text-center mb-5">
        <div class="feature logoFeatures bg-gradient text-white rounded-3 mb-3"><i class="bi bi-file-earmark-plus"></i></div>
        <h1 class="fw-bolder">Aanmelden</h1>
    </div>
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <form action="../../includes/login/signup.inc.php" autocomplete="off" method="post">
                <!-- Signup Form-->
                <div class="form mb-3 row">
                    <div class="col">
                        <input class="form-control col-2" name="firstname" type="text" placeholder="Voornaam...*" />
                    </div>
                    <div class="col">
                        <input class="form-control col-2" name="lastname" type="text" placeholder="Achternaam...*" />
                    </div>
                </div>
                <div class="form mb-3 row">
                    <div class="col">
                        <input class="form-control" name="email" type="text" placeholder="Email...*" />
                    </div>
                    <div class="col">
                        <input class="form-control" name="phonenumber" type="text" placeholder="Telefoonnummer...*" />
                    </div>
                </div>
                <div class="form mb-3 row">
                    <div class="col">
                        <input class="form-control" name="address" type="text" placeholder="Adres..." />
                    </div>
                    <div class="col">
                        <input class="form-control" name="zipcode" type="text" placeholder="Postcode..." />
                    </div>
                    <div class="col">
                        <input class="form-control" name="location" type="text" placeholder="Plaats..." />
                    </div>
                </div>
                <div class="form mb-3 row">
                    <div class="col">
                        <input class="form-control" name="pwd" type="password" placeholder="Wachtwoord...*" />
                    </div>
                    <div class="col">
                        <input class="form-control" type="password" name="pwdrepeat" placeholder="Herhaal wachtwoord...*" />
                    </div>
                </div>
                <div class="d-grid mb-3"><button class="btn btnLogin btn-lg" name="submit" type="submit">Maak account</button></div>
                <div class="d-grid"><button class="btn btnLogin btn-lg"><a href="../../front-end/algemeen/index.php" class="noTextDecoration">Annuleren</a></button></div>
                <div class="text-center pt-3">* Verplicht veld!</div>
            </form>
            <!-- Start error handling -->
            <?php
            if (isset($_GET["note"])) {
                if ($_GET["note"] == "emptyinput") {
                    echo '<div class="ErrorMessage">Vul alle velden in!</div>';
                } else if ($_GET["note"] == "invalidPhoneNumber") {
                    echo '<div class="ErrorMessage">Kies een bestaand nummer!</div>';
                } else if ($_GET["note"] == "invalidemail") {
                    echo '<div class="ErrorMessage">Kies een bestaande email!</div>';
                } else if ($_GET["note"] == "passwordsdontmatch") {
                    echo '<div class="ErrorMessage">Wachtwoorden komen niet overeen!</div>';
                } else if ($_GET["note"] == "invaliduid") {
                    echo '<div class="ErrorMessage">Er is iets fout gegaan, probeer het opnieuw...</div>';
                } else if ($_GET["note"] == "emailtaken") {
                    echo '<div class="ErrorMessage">Email is al in gebruik</div>';
                } else if ($_GET["note"] == "none") {
                    echo '<div class="ErrorMessage">Je bent aangemeld!</div>';
                } else if ($_GET["note"] == "stmtfailed") {
                    echo '<div class="ErrorMessage">Er is iets fout gegaan!</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
include_once '../algemeen/footer.php';
?>