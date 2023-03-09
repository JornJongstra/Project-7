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
}
?>

<div class="bg-light py-5 px-4 px-md-5 container-fluid" style="height: 100vh;">
    <div class="container">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            <div class="col">
                <h3 class="fw-bolder mb-3">Mijn reserveringen</h3>
                <div class="row">
                    <?php
                    if (!isset($_GET['filter'])) {
                        $data = getReservationsUser($conn, $_SESSION['userid']);
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                    ?>
                                <div class="col-4 mb-4">
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../algemeen/footer.php';
?>