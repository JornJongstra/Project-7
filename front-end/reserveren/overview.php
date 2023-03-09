<?php
include '../algemeen/header.php';

if ($_SESSION['userlevel'] <= 3) {
    header("Location: ../../front-end/algemeen/index.php");
    exit();
}

include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';

$reservationList = getReservations($conn);
$reservationListLength = mysqli_num_rows($reservationList);
$reservationCounter = 1;

?>

<script>
    deleteAlert()
</script>
<div class="container">
    <table id="datatable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Klant</th>
                <th>Telefoon</th>
                <th>Datum</th>
                <th>Starttijd</th>
                <th>Opties</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reservation = $reservationList->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $reservation["lastName"] ?></td>
                    <td><?php echo $reservation["phone"] ?></td>
                    <td><?php echo $reservation["date"] ?></td>
                    <td><?php echo $reservation["starttijd"] ?></td>
                    <td class="row">
                        <form method="POST" action="update.php" class="col">
                            <input type="hidden" value="<?php echo $reservation["id"] ?>" name="id">
                            <input type="submit" name="update" value="Update" class="btn-upd-overview">
                        </form>
                        <?php if ($_SESSION['userlevel'] >= 4) { ?>
                            <form onsubmit="return confirm('Weet je zeker dat je de reservering wil deleten');" method="POST" action="../../includes/reserveren/reserveren.inc.php" class="col">
                                <input type="hidden" value="<?php echo $reservation["id"] ?>" name="id">
                                <input type="submit" name="delete" value="Delete" class="btn-del-overview">
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php $reservationCounter++;
            } ?>
            </tfoot>
    </table>
</div>

<?php
include '../algemeen/footer.php';
?>