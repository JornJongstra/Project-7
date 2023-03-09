<?php
include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';
include '../algemeen/header.php';

$selectedReservationId = $_POST['id'];
$reservation = getSelectedReservation($conn, $selectedReservationId);


if (!isset($_SESSION["userlevel"])) {
    header("Location: overview.php");
} else if ($_SESSION["userlevel"] >= 4) {
    true;
} else if ($_SESSION["userid"] !== $reservation['userid']) {
    header("Location: overview.php");
}
?>

<?php ShowMsg(); ?>
<div class="container">
    <form class="row m-5" method="post" action="../../includes/reserveren/reserveren.inc.php">
        <div class="col-md-4 offset-md-4 border">
            <div class="mt-3 text-center text-decoration-underline">
                <h1>Updaten</h1>
            </div>
            <div>
                <input class="hidden" name="reservationId" hidden value="<?php echo $selectedReservationId ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Personen</label>
                <input class="input" type="number" name="quantity" value="<?php echo $reservation['quantity'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Datum</label>
                <input class="input" type="date" min="now" name="date" value="<?php echo $reservation['date'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Starttijd</label>
                <select class="w-25" id="hours" name="hour"></select>
                <select class="w-25" id="minutes" name="minutes"></select>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn-submit" name="update"></input>
            </div>
        </div>
    </form>
    <div class="text-center">
        <a href="overview.php">Terug</input>
    </div>
</div>
<script>
    function createOption(value, text, name) {
        var option = document.createElement('option');
        option.text = text;
        option.value = value;
        option.id = name;
        return option;
    }

    var hourSelect = document.getElementById('hours');
    for (var i = 17; i <= 21; i++) {
        hourSelect.add(createOption(i, i, i));
    }

    var minutesSelect = document.getElementById('minutes');
    for (var i = 0; i < 60; i += 15) {
        minutesSelect.add(createOption(i, i, i));
    }

    var php_var_hour = "<?php echo date('H', $reservationTime) ?>"
    const a = document.getElementById(php_var_hour);
    a.setAttribute('selected', 'selected');

    var php_var_min = "<?php echo date('i', $reservationTime) ?>"
    const b = document.getElementById(php_var_min);
    b.setAttribute('selected', 'selected');



    console.log(a);
</script>
<?php include '../algemeen/footer.php'; ?>