<?php
include_once '/xampp/htdocs/project7/front-end/algemeen/header.php';
include '../../includes/login/functions-login.inc.php';
include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';

print_r($_GET['quantity']);

if (!isset($_SESSION['userlevel']) || $_SESSION['userlevel'] < 2) {
    header("location: ../algemeen/index.php");
    exit();
}
?>
<div class="container">
    <form class="row m-5" method="post" action="../../includes/reserveren/reserveren.inc.php?resId=<?= $_GET['resId'] ?>&quantity=<?= $_GET['quantity'] ?>">
        <div class="col-md-4 offset-md-4">
            <div class="mt-3 text-center text-decoration-underline">
                <h1>Menu selecteren</h1>
            </div>
            <div class="mb-3 text-center">
                <?php
                $i = 1;
                while ($i <= $_GET['quantity']) {
                ?>
                    Menu <?= $i ?> -> <select name="menu[<?= $i ?>]" id="menu" class="mb-2">
                        <option value="">Menu selecteren</option>
                        <?php
                        $data = getMenus($conn);
                        $l = 1;
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                        ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php
                                $l++;
                            }
                        }
                        ?>
                    </select><br>
                <?php
                    $i++;
                }
                ?>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn-submit" name="submit-menu"></input>
            </div>
        </div>
    </form>
    <?php
    if (isset($_GET["note"])) {
        if ($_GET["note"] == "sql") {
            echo '<div class="ErrorMessage">Er is iets fout gegaan.</div>';
        } else if ($_GET["note"] == "nospace") {
            echo '<div class="ErrorMessage">Restaurant zit vol!</div>';
        } else if ($_GET["note"] == "emptyInput") {
            echo '<div class="ErrorMessage">Vul alle velden in!</div>';
        }
    }
    ?>
</div>
<?php include '../algemeen/footer.php'; ?>