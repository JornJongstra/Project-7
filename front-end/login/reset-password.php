<?php
include '../algemeen/header.php';
?>

<main>
    <div class="wrapper-main">
        <section class="section-default">
            <h1>Reset jou wachtwoord</h1>
            <p>Een email wordt verzonden met verdere instructies voor het resetten van je wachtwoord.</p>
            <form action="../../includes/login/reset-request.inc.php" method="post">
                <input type="text" name="email" placeholder="Vul je email in...">
                <button type="submit" name="reset-request-submit">Ontvang nieuw wachtwoord per email</button>
            </form>
        </section>
    </div>
</main>
<?php
if (isset($_GET["note"])) {
    if ($_GET["note"] == "stmtfailed") {
        echo '<div class="ErrorMessage">Er is iets fout gegaan!</div>';
    } else if ($_GET["note"] == "succes") {
        echo '<div class="ErrorMessage">Je hebt een email ontvangen!</div>';
    }
}
?>
<?php
include '../algemeen/footer.php';
?>