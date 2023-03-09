<?php 
  include '../algemeen/header.php';
  include '../../includes/bediening/functions-bediening.inc.php';
  include '../../includes/algemeen/dbh.inc.php';

?>

<?php
if(!isset($_SESSION['table'])){
    //redirect terug met error.
    header("location: overzicht-tafels.php");
}else{

    $tableId = $_SESSION['table'];

    //Hier haal je alle reserveringen data op.
    $date = date("Y-m-d");
    $reservationsList = getReservationsAndUsers($conn, $date);
    ?>
    <div class="container pt-5 mt-5">
        <h1>Reservering toevoegen</h1>
    </div>
    <div class="container bg-light mb-5 py-5">
        <div class="row">
            <div class="col-lg-4">
                <a href="overzicht-tafels.php" class="btn btn-secondary btn-lg">Ga terug</a>
            </div>
            
            <div class="col-lg-8">
                <form method="post" action="../../includes/bediening/add-reservation.inc.php">
                <input type="hidden" name="tableId" id="tableId" value="<?= $tableId; ?>">
                <div class="row">
                    <div class="col-lg-6">
                        <select name="reservationId" class="form-select form-select-lg mb-3" id="reservationId">
                            <?php
                            while ($reservation = $reservationsList->fetch_assoc()){
                                ?>
                            <option value="<?= $reservation['id'] ?>"><?php echo $reservation['firstname'] . " " . $reservation['lastname'] . " - pers: " . $reservation['quantity'] . " - " . $reservation['starttijd'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-primary btn-lg" type="submit">Voeg toe</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <?php
}
?>
