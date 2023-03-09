<?php
include '../algemeen/header.php';
?>

<main>
    <div class="wrapper-main">
        <section class="section-default">

            <?php
            $selector = $_GET["selector"];
            $validator = $_GET['validator'];

            if (empty($selector) || empty($validator)) {
                echo "Opdracht kan niet gevalideerd worden!";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>

                    <form action="../../includes/login/reset-password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?= $selector ?>">
                        <input type="hidden" name="validator" value="<?= $validator ?>">
                        <input type="password" name="pwd" placeholder="Vul je nieuwe wachtwoord in...">
                        <input type="password" name="pwd-repeat" placeholder="Vul opnieuw je nieuwe wachtwoord in...">
                        <button type="submit" name="reset-password-submit">Reset wachtwoord</button>
                    </form>

            <?php
                }
                if (isset($_GET["note"])) {
                    if ($_GET["note"] == "empty") {
                        echo '<div class="ErrorMessage">Vul de velden voor het wachtwoord in!</div>';
                    } else if ($_GET["note"] == "pwdnotsame") {
                        echo '<div class="ErrorMessage">Wachtwoorden komen niet overeen!</div>';
                    } else if ($_GET["note"] == "stmtfailed") {
                        echo '<div class="ErrorMessage">Er is iets fout gegaan!</div>';
                    }
                }
            }
            ?>

        </section>
    </div>
</main>
<?php
include '../algemeen/footer.php';
?>