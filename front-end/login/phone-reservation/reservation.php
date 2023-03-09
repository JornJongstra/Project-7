<?php
include_once '/xampp/htdocs/project7/front-end/algemeen/header.php';
include '../../../includes/reserveren/function.inc.php';
include '../../../includes/algemeen/dbh.inc.php';

if ($_SESSION['userlevel'] !== 4 || !isset($_SESSION['userid'])) {
    header("location: ../../algemeen/index.php");
    exit();
}

?>
<div class="container">
    <form class="row m-5" method="post" action="../../../includes/login/customer-signup.inc.php?userid=<?= $_GET['userid'] ?>">
        <div class="col-md-4 offset-md-4">
            <div class="mt-3 text-center text-decoration-underline">
                <h1>Reserveren</h1>
            </div>
            <div class="mb-3">
                <label class="form-label">Personen</label>
                <input class="input" type="number" name="quantity" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Datum</label>
                <input class="input" type="date" min="now" name="date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Starttijd</label><br>
                <select class="w-25" id="hours" name="hour"></select>
                <select class="w-25" id="minutes" name="minutes"></select>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn-submit" name="submit-reservation"></input>
            </div>
        </div>
    </form>
    <?php
    if (isset($_GET["note"])) {
        if ($_GET["note"] == "twp") {
            echo '<div class="ErrorMessage">Reserveer voor minimaal 4 gasten!</div>';
        } else if ($_GET["note"] == "nospace") {
            echo '<div class="ErrorMessage">Restaurant zit vol!</div>';
        } else if ($_GET["note"] == "emptyinput") {
            echo '<div class="ErrorMessage">Vul alle velden in!</div>';
        }
    }
    ?>
    <div class="text-center">
        <a href="customer-signup.php">Terug</input>
    </div>
</div>
<script>
    function createOption(value, text) {
        var option = document.createElement('option');
        option.text = text;
        option.value = value;
        return option;
    }

    var hourSelect = document.getElementById('hours');
    for (var i = 17; i <= 21; i++) {
        hourSelect.add(createOption(i, i));
    }

    var minutesSelect = document.getElementById('minutes');
    for (var i = 0; i < 60; i += 15) {
        minutesSelect.add(createOption(i, i));
    }
</script>
<?php include '../../algemeen/footer.php'; ?>