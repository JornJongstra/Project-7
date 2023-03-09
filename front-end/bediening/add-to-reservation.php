
<?php
  include '../algemeen/header.php';
  include '../../includes/bediening/functions-bediening.inc.php';
  include '../../includes/algemeen/dbh.inc.php';
?>

<?php
if(!isset($_POST['reservation_id']) && !isset($_SESSION['reservationid'])){

}elseif(isset($_POST['reservation_id']) || isset($_SESSION['reservationid'])){
?>

<?php
if(isset($_POST['reservation_id'])){
    $reservationId = $_POST['reservation_id'];
}elseif(isset($_SESSION['reservationid'])){
    $reservationId = $_SESSION['reservationid'];
}

?>


<!-- Dit moet helemaal anders, met soort plus en min knopjes. Wanneer dan op submit gedrukt word, dan gaat het in één keer. -->
<?php
$menus = getAllMenus($conn);
$drinks = getAllDrinks($conn);
$other_suplements = getAllOtherSuplements($conn);
?>

<div class="container bg-light mb-5 py-5">
    <div class="row">
        <div class="col-12">
            <h1>Menu's</h1>
        </div>
    </div>
    <form action="../../includes/bediening/add-to-reservation.inc.php" method="post">
    <input type="hidden" name="reservation_id" value="<?= $reservationId ?>">
    <?php
        while ($menu = $menus->fetch_assoc()){
            ?>
            <div class="row" style=" padding-bottom: 5px;">
                <div class="col-sm-3"><b><?= $menu['name'] ?></b></div>
                <div class="col-sm-3"><?= $menu['discription'] ?></div>
                <div class="col-sm-3"><?= $menu['price'] ?></div>
                <div class="col-sm-3"><button type="submit" name="menuId" value="<?= $menu['id'] ?>" class="btn btn-secondary">Voeg toe</button></div>
            </div>
            <hr>
            <?php
        }
        ?>
    </form>
    <div class="row">
        <div class="col-12">
            <h1>Drankjes</h1>
        </div>
    </div>
    <form action="../../includes/bediening/add-to-reservation.inc.php" method="post">
    <input type="hidden" name="reservation_id" value="<?= $reservationId ?>">
    <?php
        while ($drink = $drinks->fetch_assoc()){
            ?>
        <div class="row" style="padding-bottom: 5px;">
            <div class="col-sm-3"><b><?= $drink['name'] ?></b></div>
            <div class="col-sm-3"><?= $drink['discription'] ?></div>
            <div class="col-sm-3">€ <?= $drink['price'] ?></div>
            <div class="col-sm-3"><button type="submit" name="drinkId" value="<?= $drink['id'] ?>" class="btn btn-secondary">Voeg toe</button></div>
        </div>
        <hr>
            <?php
        }
        ?>
    </form>
    <div class="row">
        <div class="col-12">
            <h1>Extra's</h1>
        </div>
    </div>
    <form action="../../includes/bediening/add-to-reservation.inc.php" method="post">
    <input type="hidden" name="reservation_id" value="<?= $reservationId ?>">
    <?php
        while ($other_suplement = $other_suplements->fetch_assoc()){
            ?>
        <div class="row" style=" padding-bottom: 5px;">
            <div class="col-sm-3"><b><?= $other_suplement['name'] ?></b></div>
            <div class="col-sm-3"><?= $other_suplement['discription'] ?></div>
            <div class="col-sm-3">€ <?= $other_suplement['price'] ?></div>
            <div class="col-sm-3"><button type="submit" name="otherSuplementId" value="<?= $other_suplement['id'] ?>" class="btn btn-secondary">Voeg toe</button></div>
        </div>
        <hr>
            <?php
        }
        ?>
    </form>
    <div class="row">
        <div class="col-lg-4">
            <a href="overzicht-tafels.php" class="btn btn-secondary btn-lg">Ga terug</a>
        </div>
    </div>
</div>
<?php include('../algemeen/footer.php');
} ?>