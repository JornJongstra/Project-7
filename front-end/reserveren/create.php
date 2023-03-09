<?php
include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';
?>

<?php include '../algemeen/header.php'; ?>

<?php ShowMsg(); ?>
<div class="container">
    <form class="row m-5" method="post" action="../../includes/reserveren/reserveren.inc.php">
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
                <label class="form-label">Starttijd</label>
                <div class="row gx-0">
                    <select class="col form-select" id="hours" name="hour"></select>
                    <select class="col form-select" id="minutes" name="minutes"></select>
                </div>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn-submit" name="submit"></input>
            </div>
        </div>
    </form>
    <div class="text-center">
        <a href="overview.php">Terug</input>
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
<?php include '../algemeen/footer.php'; ?>