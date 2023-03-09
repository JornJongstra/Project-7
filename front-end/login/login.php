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
        <div class="feature logoFeatures bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
        <h1 class="fw-bolder">Login</h1>
    </div>
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <form action="../../includes/login/login.inc.php" autocomplete="off" method="post">
                <!-- Email input-->
                <div class="form mb-3">
                    <input class="form-control" name="emaillogin" type="text" placeholder="Email..." />
                </div>
                <!-- Pwd  input-->
                <div class="form mb-3">
                    <input class="form-control" type="password" name="pwd" placeholder="Wachtwoord..." />
                </div>
                <div class="d-grid"><button class="btn btnLogin btn-lg" name="submit" type="submit">Login</button></div>
            </form>
            <div class="text-center mt-3">
                <a href="reset-password.php" class="btn btnLogin">Wachtwoord vergeten?</a>
            </div>
            <?php
            if (isset($_GET["note"])) {
                if ($_GET["note"] == "emptyinput") {
                    echo '<div class="ErrorMessage">Vul alle velden in!</div>';
                } else if ($_GET["note"] == "wronglogin") {
                    echo '<div class="ErrorMessage">Incorrecte login!</div>';
                } else if ($_GET["note"] == "notLoggedIn") {
                    echo '<div class="ErrorMessage">Log eerst in!</div>';
                } else if ($_GET["note"] == "verwijderd") {
                    echo '<div class="ErrorMessage">Account is verwijderd!</div>';
                } else if ($_GET["note"] == "loginsucces") {
                    echo '<div class="ErrorMessage">Succesvol ingelogd!</div>';
                } else if ($_GET["note"] == "noLoginOrUserevel") {
                    echo '<div class="ErrorMessage">Log in met een account met de geschikte rechten!</div>';
                } else if ($_GET["note"] == "passwordupdated") {
                    echo '<div class="ErrorMessage">Wachtwoord is geupdate!</div>';
                }
            }
            ?>
        </div>
    </div>
    <div class="text-center mb-5 mt-5">
        <h1 class="fw-bolder mb-4">Nog geen account?</h1>
        <a href="signup.php" class="btn btnLogin">Maak er hier eentje aan!</a>
    </div>
</div>

<?php
include_once '../algemeen/footer.php';
?>