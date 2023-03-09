<?php
include_once '/xampp/htdocs/project7/front-end/algemeen/header.php';
include '../../../includes/login/functions-login.inc.php';
include '../../../includes/reserveren/function.inc.php';
include '../../../includes/algemeen/dbh.inc.php';

if ($_SESSION['userlevel'] !== 4 || !isset($_SESSION['userid'])) {
    header("location: ../../algemeen/index.php?gekkedingen");
    exit();
}
?>
<div class="container">
    <div class="col-md-6 offset-md-3">
        <div class="mt-3 text-center text-decoration-underline">
            <h1>Samenvatting reservering</h1>
        </div>
        <div class="mb-3 text-center">
            <?php
            if (!isset($_GET['filter'])) {
                $data = getReservation($conn, $_GET['resId']);
                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
            ?>
                        <div class="col-6 mb-3 offset-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['date'] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <?php
                                        $data2 = getUser($conn, $row['userid']);
                                        $row2 = $data2->fetch_assoc();
                                        ?>
                                        Op naam van <?= $row2['firstname'] . " " . $row2['lastname'] ?>
                                    </h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= "Van " . $row['starttijd'] . " tot " . $row['eindtijd'] ?></h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= "Reservering voor " . $row['quantity'] . " personen" ?></h6>
                                    <hr>
                                    <h6 class="card-subtitle mb-2 text-muted">Bestelde menu's</h6>
                                    <p>
                                        <?php
                                        if (!isset($_GET['filter'])) {
                                            $data1 = getReservationsMenu($conn, $row['id']);
                                            if ($data1->num_rows > 0) {
                                                while ($row1 = $data1->fetch_assoc()) {
                                        ?>
                                                    <?= $row1['name'] ?><br>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
        <div class="mb-3 text-center">
            <a href="../../../front-end/algemeen/index.php" class="btn-submit">Verzenden</a>
        </div>
    </div>
    <?php
    if (isset($_GET["note"])) {
        if ($_GET["note"] == "twp") {
            echo '<div class="ErrorMessage">Reserveer voor minimaal 4 gasten!</div>';
        } else if ($_GET["note"] == "data-ophalen-mislukt") {
            echo '<div class="ErrorMessage">Er is iets fout gegaan</div>';
        }
    }
    ?>
</div>
<?php include '../../algemeen/footer.php'; ?>