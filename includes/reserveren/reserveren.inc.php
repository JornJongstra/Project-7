<?php
session_start();
include '../../includes/reserveren/function.inc.php';
include '../../includes/algemeen/dbh.inc.php';

//create
if(isset($_POST["submit"]))
{
    //POST data omzetten in var
    $userid = $_SESSION['userid'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $starttime = date('H:i:s', strtotime($_POST['hour'] . ":" . $_POST['minutes'] . ":" . "00"));

    //Variables valideren
    if($quantity <= 3){
        StoreMsg('alert-danger', 'Moet voor 4 of meer reserveren');
        header("location: ../../front-end/reserveren/create.php?note=Te weinig personen");
        exit();
    }         

    //kijk of er nog ruimte is die dag
    if (calculateRoom($quantity, $date, $conn) != true){
        StoreMsg('alert-danger', 'Geen ruimte meer');
        header("Location: ../../front-end/reserveren/create.php?note=Geen ruimte meer");
        exit();
    }

    //roept de function createReservation
    $resId = createReservation($conn, $userid, $quantity, $date, $starttime);
    header("Location: ../../front-end/reserveren/create-menu.php?resId=$resId&quantity=$quantity");
    exit();
}
//update
else if (isset($_POST['update'])) 
{
    //POST data omzetten in variable
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $starttime = date('H:i:s', strtotime($_POST['hour'] . ":" . $_POST['minutes'] . ":" . "00"));
    $id = $_POST['reservationId'];

    //kijk of er nog ruimte is die dag
    if (calculateRoomUpdate($id, $quantity, $date, $conn) != true){
        StoreMsg('alert-danger', 'Geen ruimte meer');
        header("Location: ../../front-end/reserveren/create.php?note=Geen ruimte meer");
        exit();
    }

    //roept de function updateReservation
    updateReservation($conn, $quantity, $date, $starttime, $id);
}
//delete
else if (isset($_POST['delete'])) {
    if (!$_SESSION['userlevel'] >= 4){
        StoreMsg('alert-danger', 'U heeft hier geen recht op');
        header("location: ../../front-end/reserveren/overview.php");
    }
    //zet de POST['id'] om in een variable $id
    $id = $_POST['id'];

    //roept de function deleteReservation
    deleteReservation($conn, $id);
} else if (isset($_POST["submit-menu"])) {

    require_once '../../includes/algemeen/dbh.inc.php';
    //include '../reserveren/function.inc.php';
    include '../bediening/functions-bediening.inc.php';

    foreach($_POST['menu'] as $menu){
        if(!isset($_POST['menu'][$menu])){
            header("location: ../../front-end/reserveren/create-menu.php?resId=" . $_GET['resId'] . "&quantity=" . $_GET['quantity'] . "&note=emptyinput");
            exit();
        }
    }

    

    $quantity = count($_POST['menu']);
    $reservationId = intval($_GET['resId']);

    $i = 1;
    while ($i <= $quantity) {
        $menuId = intval($_POST['menu'][$i]);
        $dishes = getAllDishesFromMenu($conn, $menuId);
        while ($dish = $dishes->fetch_assoc()) {
            $result = insertMenuDishRes($conn, $dish['dishid'], $reservationId, $menuId);
            if ($result != true) {
                header("location: ../../front-end/login/phone-reservation/menu.php?note=sql");
                exit();
            } elseif ($result == true) {
            }
        }
        $i++;
    }
    header("location: ../../front-end/algemeen/index.php?note=reservering aangemaakt");
    exit();
} else {
    StoreMsg('alert-danger', 'Geen Submit');
    header("location: ../../front-end/reserveren/create.php?note=Geen submit");
}
?>