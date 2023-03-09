<?php
include_once '../../algemeen/header.php';
include_once '../../../includes/algemeen/dbh.inc.php';
include_once '../../../includes/login/functions-login.inc.php';
?>
<link rel="stylesheet" href="../../../css/login.css">

<?php
if (!isset($_SESSION['userid'])) {
    header("location: ../login.php?note=notLoggedIn");
    exit();
} else {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $address = $_SESSION['address'];
    $zipcode = $_SESSION['zipcode'];
    $location = $_SESSION['location'];
}
?>

<div class="bg-light py-5 px-4 px-md-5 container-fluid" style="height: 100vh;">
    <div class="container">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            <div class="col">
                <h3 class="fw-bolder mb-3">Accountoverzicht</h3>
                <section class="bg-secondary text-white p-4 mb-5" style="max-width: 75%;">
                    <h1>Hallo, <?= $firstname ?></h1>
                    <p class="display-6">Hier zijn al uw gegevens op een rijtje</p>
                </section>
                <h4 class="fw-bolder mb-3">Laatste Reserveringen</h4>
                <div class="row">
                    <?php
                    if (!isset($_GET['filter'])) {
                        $data = getReservationsUser2($conn, $_SESSION['userid']);
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                    ?>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row['date'] ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted"><?= "Van " . $row['starttijd'] . " tot " . $row['eindtijd'] ?></h6>
                                            <h6 class="card-subtitle mb-2 text-muted"><?= "Reservering voor " . $row['quantity'] . " personen" ?></h6>
                                            <hr>
                                            <h6 class="card-subtitle mb-2 text-muted">Bestelde menu's</h6>
                                            <ul>
                                                <?php
                                                if (!isset($_GET['filter'])) {
                                                    $data1 = getReservationsMenu($conn, $row['id']);
                                                    if ($data1->num_rows > 0) {
                                                        while ($row1 = $data1->fetch_assoc()) {
                                                ?>
                                                            <li><?= $row1['name'] ?></li>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                    <a href="orders.php" class="mb-5">Zie al uw reserveringen</a>
                </div>
                <h4 class="fw-bolder mb-3">Uw gegevens</h4>
                <div class="row mb-5">
                    <div class="card col-8" style="margin: 0px 12px 0px 12px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card-text"><b>Voornaam:</b> <?= $firstname ?></div>
                                </div>
                                <div class="col">
                                    <div class="card-text"><b>Achternaam:</b> <?= $lastname ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card-text"><b>Email:</b> <?= $email ?></div>
                                </div>
                                <div class="col">
                                    <div class="card-text"><b>Telefoonnummer:</b> <?= $phone ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" <?= empty($address) ? "hidden" : ""; ?>>
                                    <div class="card-text"><b>Adres:</b> <?= $address ?></div>
                                </div>
                                <div class="col" <?= empty($zipcode) ? "hidden" : ""; ?>>
                                    <div class="card-text"><b>Postcode:</b> <?= $zipcode . ", " . $location ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="profile.php">Gegevens wijzigen</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../algemeen/footer.php';
?>